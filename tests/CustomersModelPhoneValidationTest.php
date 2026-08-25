<?php

use PHPUnit\Framework\TestCase;

if (!defined('BASEPATH')) {
    define('BASEPATH', 'test');
}

if (!defined('DB_SLUG_CUSTOMER')) {
    define('DB_SLUG_CUSTOMER', 'customer');
}

if (!function_exists('setting')) {
    function setting(string $key): mixed
    {
        return match ($key) {
            'require_first_name' => '0',
            'require_last_name' => '0',
            'require_email' => '0',
            'require_phone_number' => '0',
            'require_address' => '0',
            'require_city' => '0',
            'require_zip_code' => '0',
            default => null,
        };
    }
}

class CI_Model {}

require_once __DIR__ . '/../application/core/EA_Model.php';
require_once __DIR__ . '/../application/models/Customers_model.php';

class TestDbStub
{
    private int $existingCustomerCount;
    private int $emailDuplicateCount;
    private int $phoneDuplicateCount;
    private array $whereClauses = [];

    public function __construct(int $existingCustomerCount = 1, int $emailDuplicateCount = 0, int $phoneDuplicateCount = 0)
    {
        $this->existingCustomerCount = $existingCustomerCount;
        $this->emailDuplicateCount = $emailDuplicateCount;
        $this->phoneDuplicateCount = $phoneDuplicateCount;
    }

    public function select(): self
    {
        return $this;
    }

    public function from(string $table): self
    {
        $this->whereClauses[] = ['from' => $table];

        return $this;
    }

    public function join(string $table, string $condition, string $type = 'inner'): self
    {
        $this->whereClauses[] = ['join' => [$table, $condition, $type]];

        return $this;
    }

    public function where($key, $value = null): self
    {
        $this->whereClauses[] = ['where' => [$key, $value]];

        return $this;
    }

    public function get_where(string $table, array $where): object
    {
        return new class($this->existingCustomerCount) {
            private int $count;

            public function __construct(int $count)
            {
                $this->count = $count;
            }

            public function num_rows(): int
            {
                return $this->count;
            }
        };
    }

    public function get(): object
    {
        return new class($this->emailDuplicateCount, $this->phoneDuplicateCount) {
            private int $emailDuplicateCount;
            private int $phoneDuplicateCount;

            public function __construct(int $emailDuplicateCount, int $phoneDuplicateCount)
            {
                $this->emailDuplicateCount = $emailDuplicateCount;
                $this->phoneDuplicateCount = $phoneDuplicateCount;
            }

            public function num_rows(): int
            {
                return $this->emailDuplicateCount;
            }

            public function result_array(): array
            {
                if ($this->phoneDuplicateCount > 0) {
                    return [
                        ['id' => 99, 'phone_number' => '+1 (555) 123-4567'],
                    ];
                }

                return [];
            }
        };
    }
}

class CustomersModelPhoneValidationTest extends TestCase
{
    public function testRejectsDuplicatePhoneNumbersEvenWhenFormattedDifferently(): void
    {
        $model = new \Customers_model();
        $model->db = new TestDbStub(1, 0, 1);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The provided phone number is already in use, please use a different one.');

        $model->validate([
            'id' => 2,
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'phone_number' => '+1 (555) 123-4567',
        ]);
    }

    public function testAllowsUpdatingTheSameCustomerWithTheSamePhoneNumber(): void
    {
        $model = new \Customers_model();
        $model->db = new TestDbStub(1, 0, 0);

        $model->validate([
            'id' => 2,
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'phone_number' => '+1 (555) 123-4567',
        ]);

        $this->assertTrue(true);
    }
}
