<?php extend('layouts/backend_layout1'); ?>

<?php section('content'); ?>

<style>
    .status-dots {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 10px;
        white-space: nowrap;
        margin-top: 5px;
    }

    .progress-thin {
        height: 6px;
        border-radius: 3px;
    }
</style>

<div class="container-fluid">
    <!-- Row 1: Top Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Today's Appointments -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="dash-card hover-lift">
                <div class="dash-card-header">
                    <div class="dash-title">TODAY'S APPOINTMENTS</div>
                    <div class="dash-icon-box icon-green">
                        <i class='bx bx-calendar-event'></i>
                    </div>
                </div>
                <div class="dash-number"><?= $today_appointments ?? 0; ?></div>
                <div class="status-dots">
                    <span><span class="dot dot-done"></span> Done: <strong><?= $today_done ?? 0; ?></strong></span>
                    <span><span class="dot dot-queue"></span> Queue: <strong><?= $today_queue ?? 0; ?></strong></span>
                    <span><span class="dot dot-cancel"></span> Cancel: <strong><?= $today_cancel ?? 0; ?></strong></span>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Appointments -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="dash-card hover-lift">
                <div class="dash-card-header">
                    <div class="dash-title">APPOINTMENTS</div>
                    <div class="dash-icon-box icon-blue">
                        <i class='bx bx-clipboard'></i>
                    </div>
                </div>
                <div class="dash-number"><?= $total_appointments ?? 0; ?></div>
                <div class="dash-subtitle">Total appointments</div>
            </div>
        </div>

        <!-- Card 3: Staffs -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="dash-card hover-lift">
                <div class="dash-card-header">
                    <div class="dash-title">STAFFS</div>
                    <div class="dash-icon-box icon-red">
                        <i class='bx bx-share-alt'></i>
                    </div>
                </div>
                <div class="dash-number"><?= $total_staffs ?? 0; ?></div>
                <div class="dash-subtitle">Active staff members</div>
            </div>
        </div>

        <!-- Card 4: Patients -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="dash-card hover-lift">
                <div class="dash-card-header">
                    <div class="dash-title">PATIENTS</div>
                    <div class="dash-icon-box icon-green">
                        <i class='bx bx-group'></i>
                    </div>
                </div>
                <div class="dash-number"><?= $total_patients ?? 0; ?></div>
                <div class="dash-subtitle">Registered patients</div>
            </div>
        </div>
    </div>


    <!-- Row 3: Live Queue & Status Overview -->
    <div class="row g-3">
        <!-- Left Side: Today's Appointments Table -->
        <div class="col-xl-7 col-lg-6">
            <div class="dash-card p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0 text-dark">Today's Appointments</h6>
                    <span class="badge bg-light text-primary" style="font-size: 11px;">Live Queue</span>
                </div>
                <div class="table-responsive" style="max-height: 280px; overflow-y: auto;">
    <table class="table compact-table align-middle mb-0">
        <thead>
            <tr>
                <th>PATIENT</th>
                <th>TIME</th>
                <th class="text-end">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($upcoming_appointments)) : ?>
                <?php foreach ($upcoming_appointments as $apt) : ?>
                    <tr>
                        <td>
                            <div class="fw-bold text-dark" style="font-size: 12px;"><?= $apt->patient_name ?? 'N/A'; ?></div>
                            <div class="text-muted" style="font-size: 11px;"><?= $apt->service_name ?? 'Consultation'; ?></div>
                        </td>
                        
                        <!-- Updated Time Column -->
                        <td class="text-dark" style="font-size: 11px; font-weight: 500; white-space: nowrap;">
                            <?= date('h:i A', strtotime($apt->start_datetime)) ?> - <?= date('h:i A', strtotime($apt->end_datetime)) ?>
                        </td>

                        <td class="text-end">
                            <?php 
                                $status = strtolower($apt->status ?? 'waiting');
                                $badge = 'bg-light-warning text-warning';
                                if($status == 'done' || $status == 'confirmed') $badge = 'bg-light-success text-success';
                                elseif($status == 'cancel' || $status == 'canceled') $badge = 'bg-light-red text-danger';
                            ?>
                            <span class="badge <?= $badge; ?>" style="font-size: 10px; padding: 4px 8px;"><?= ucfirst($status); ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="3" class="text-center text-muted py-4 small">No slots booked for today.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
            </div>
        </div>

        <!-- Right Side: Mini Status Doughnut Graph -->
        <div class="col-xl-5 col-lg-6">
            <div class="dash-card p-4">
                <div class="dash-card-header text-center mb-3">
                    <div>
                        <h3 class="section-title">Today's Performance Progress</h3>
                        <div class="section-subtitle text-muted" style="font-size: 13px;">Real-time completion rate of today's scheduled slots</div>
                    </div>
                </div>
                
                <!-- Chart.js Circle Canvas Container -->
                <div class="chart-container d-flex justify-content-center align-items-center" style="position: relative; height: 260px; width: 100%;">
                    <canvas id="performanceCircleChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN (Ensure this is loaded) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Apne PHP variables yahan assign karein
    const completedVal = <?= $completed_percentage ?? 60 ?>;
    const inQueueVal = <?= $queue_percentage ?? 25 ?>;
    const cancelledVal = <?= $cancelled_percentage ?? 15 ?>;

    const ctx = document.getElementById('performanceCircleChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'doughnut', // Ye 'doughnut' chart ko circle shape deta hai
        data: {
            labels: ['Completed', 'In Queue', 'Cancelled'],
            datasets: [{
                data: [completedVal, inQueueVal, cancelledVal],
                backgroundColor: [
                    '#198754', // Green for Completed
                    '#ffc107', // Yellow for Queue
                    '#dc3545'  // Red for Cancelled
                ],
                borderWidth: 0,
                hoverOffset: 10 // Hover karne par circle thoda bahar aayega
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%', // Ye value circle ko kitna patla/mota rakhna hai wo decide karti hai
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 25,
                        font: {
                            size: 13,
                            family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif"
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.label + ': ' + context.raw + '%';
                        }
                    },
                    padding: 10,
                    cornerRadius: 8
                }
            },
            animation: {
                animateScale: true, // Shuru me zoom hoke aayega
                animateRotate: true, // Shuru me ghumte huye aayega
                duration: 1500,
                easing: 'easeOutBounce'
            }
        }
    });
});
</script>

<?php end_section('content'); ?>