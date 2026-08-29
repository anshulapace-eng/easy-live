<?php extend('layouts/backend_layout1'); ?>

<?php section('content'); ?>

<style>
    .status-dots {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 10px; /* फॉन्ट साइज़ थोड़ा compact किया गया है */
    white-space: nowrap;
    margin-top: 5px;
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

    <!-- Row 2: Middle Section -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8 col-lg-7">
            <div class="dash-card hover-lift" style="min-height: 350px;">
                <div class="dash-card-header">
                    <div>
                        <h3 class="section-title">Revenue Overview</h3>
                        <div class="section-subtitle">Last 12 months Income</div>
                    </div>
                    <div class="toggle-pills">
                        <span class="toggle-pill">Day</span>
                        <span class="toggle-pill">Week</span>
                        <span class="toggle-pill active">Month</span>
                    </div>
                </div>
                <div class="chart-body">
                    <!-- Chart Content Will Go Here -->
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="dash-card hover-lift" style="min-height: 350px;">
                <div class="dash-card-header">
                    <div>
                        <h3 class="section-title">Appointments by Date</h3>
                        <div class="section-subtitle">Recent appointment activity</div>
                    </div>
                </div>
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th width="40%">DATE</th>
                            <th width="30%" class="text-center">PATIENTS</th>
                            <th width="30%" class="text-end">ACTION</th>
                        </tr>
                    </thead>
                </table>
                <div class="empty-state">
                    No data found!
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Bottom Section -->
    <div class="row g-4">
        <div class="col-xl-8 col-lg-7">
            <div class="dash-card hover-lift">
                <h3 class="section-title mb-4">Net Income</h3>
                <div style="border-bottom: 1px solid #edf1f3; padding-bottom: 10px; margin-bottom: 15px;">
                    <span class="dash-title">FISCAL YEAR <i class='bx bxs-info-circle text-muted ms-1'></i></span>
                </div>
                <div class="dash-subtitle text-dark fw-bold">Income</div>
            </div>
        </div>
    </div>
</div>

<?php end_section('content'); ?>