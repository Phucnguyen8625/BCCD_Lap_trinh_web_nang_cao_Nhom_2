<?php $pageTitle = 'Bảng điều khiển'; ?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Revenue -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center mr-4">
            <i class="fas fa-coins text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Doanh thu</p>
            <p class="text-2xl font-black text-slate-800"><?php echo number_format($stats['total_revenue'], 0, ',', '.'); ?>đ</p>
        </div>
    </div>

    <!-- Orders -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center">
        <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center mr-4">
            <i class="fas fa-shopping-cart text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Đơn hàng</p>
            <p class="text-2xl font-black text-slate-800"><?php echo number_format($stats['total_orders'], 0, ',', '.'); ?></p>
        </div>
    </div>

    <!-- Users -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center mr-4">
            <i class="fas fa-users text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Khách hàng</p>
            <p class="text-2xl font-black text-slate-800"><?php echo number_format($stats['total_users'], 0, ',', '.'); ?></p>
        </div>
    </div>

    <!-- Comics -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center">
        <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center mr-4">
            <i class="fas fa-book text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Đầu sách</p>
            <p class="text-2xl font-black text-slate-800"><?php echo number_format($stats['total_comics'], 0, ',', '.'); ?></p>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Revenue Chart -->
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-lg font-bold text-slate-800">Doanh thu 7 ngày gần đây</h3>
            <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded uppercase tracking-tighter">Tính theo đơn hoàn tất</span>
        </div>
        <div class="h-64 h-auto">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Top Seller Chart -->
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-lg font-bold text-slate-800">Sách bán chạy nhất</h3>
            <span class="text-xs font-medium text-slate-400">Top 5 sản phẩm</span>
        </div>
        <div class="h-64 h-auto">
            <canvas id="topSellerChart"></canvas>
        </div>
    </div>
</div>

<!-- Prepare Data for Charts -->
<?php
    $revDates = [];
    $revValues = [];
    foreach($recentRevenue as $row) {
        $revDates[] = date('d/m', strtotime($row['date']));
        $revValues[] = $row['revenue'];
    }

    $topNames = [];
    $topValues = [];
    foreach($topComics as $row) {
        $topNames[] = $row['name'];
        $topValues[] = $row['total_sold'];
    }
?>

<script>
    // Revenue Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($revDates); ?>,
            datasets: [{
                label: 'Doanh thu',
                data: <?php echo json_encode($revValues); ?>,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#6366f1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { borderDash: [5, 5] } }
            }
        }
    });

    // Top Seller Chart
    new Chart(document.getElementById('topSellerChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($topNames); ?>,
            datasets: [{
                label: 'Số lượng bán',
                data: <?php echo json_encode($topValues); ?>,
                backgroundColor: '#f59e0b',
                borderRadius: 8,
                barThickness: 20
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, grid: { display: false } },
                y: { grid: { display: false } }
            }
        }
    });
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
