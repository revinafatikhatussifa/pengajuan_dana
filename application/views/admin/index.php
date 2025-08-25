

<div class="container-fluid">

    <!-- Page Heading -->
   

    <div class="row">
        <!-- Total -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengajuan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total; ?></div>
                </div>
            </div>
        </div>

        <!-- Diproses -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Diproses</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $proses; ?></div>
                </div>
            </div>
        </div>

        <!-- Disetujui -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $setuju; ?></div>
                </div>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tolak; ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Diagram Lingkaran -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Pengajuan</h6>
                </div>
                <div class="card-body">
                   <div class="chart-pie pt-4 pb-2" style="position: relative; height:300px; width:100%;">
                     <canvas id="myPieChart"></canvas>
                   </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Diproses
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Disetujui
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Ditolak
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Script Pie Chart -->
 <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
<script>
    const ctx = document.getElementById("myPieChart");
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Diproses", "Disetujui", "Ditolak"],
            datasets: [{
                data: [<?= $proses ?? 0 ?>, <?= $setuju ?? 0 ?>, <?= $tolak ?? 0 ?>],
                backgroundColor: ['#f6c23e', '#1cc88a', '#e74a3b'],
                hoverBackgroundColor: ['#dda20a', '#17a673', '#be2617'],
                borderColor: "#fff",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: true,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 70,
        },
    });
</script>



