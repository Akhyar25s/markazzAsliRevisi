<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Jamaah - Sistem Markaz</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f5f0; color: #333; }
        .navbar { background: #26a35a; color: #fff; padding: 0 20px; height: 60px; display: flex; justify-content: space-between; align-items: center; position: fixed; top: 0; left: 0; right: 0; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,.15); }
        .navbar-left { display: flex; align-items: center; gap: 10px; }
        .toggle-sidebar-btn { background: none; border: none; color: #fff; font-size: 24px; cursor: pointer; }
        .navbar-brand { color: #fff; text-decoration: none; font-size: 20px; font-weight: 700; }
        .logout-btn { background: rgba(255,255,255,.2); color: #fff; border: 1px solid rgba(255,255,255,.5); padding: 8px 15px; border-radius: 5px; cursor: pointer; }
        .sidebar { position: fixed; left: 0; top: 60px; width: 250px; height: calc(100vh - 60px); background: #1e8449; transition: transform .3s ease; }
        .sidebar.collapsed { transform: translateX(-100%); }
        .sidebar-menu { list-style: none; padding: 20px 0; }
        .sidebar-menu a { display: block; padding: 14px 20px; color: rgba(255,255,255,.85); text-decoration: none; font-weight: 500; }
        .sidebar-menu a.active, .sidebar-menu a:hover { background: #26a35a; color: #fff; }
        .main-content { margin-left: 250px; margin-top: 60px; padding: 30px; transition: margin-left .3s ease; }
        .main-content.expanded { margin-left: 0; }
        .page-title { font-size: 28px; margin-bottom: 20px; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-bottom: 16px; }
        .stat { background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.08); padding: 15px; }
        .stat h4 { font-size: 12px; color: #777; margin-bottom: 8px; text-transform: uppercase; }
        .stat p { font-size: 28px; color: #26a35a; font-weight: 700; }
        .chart { background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.08); padding: 18px; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <button class="toggle-sidebar-btn" id="toggleSidebarBtn">☰</button>
            <a href="{{ route('dashboard') }}" class="navbar-brand">Sistem Markaz</a>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin-jamaah.kelola-jamaah') }}">Kelola Jamaah</a></li>
            <li><a href="{{ route('admin-jamaah.kelola-kegiatan') }}">Kelola Kegiatan</a></li>
            <li><a href="{{ route('admin-jamaah.laporan-jamaah') }}" class="active">Laporan Jamaah</a></li>
        </ul>
    </div>

    <main class="main-content" id="mainContent">
        <h1 class="page-title">Laporan Jamaah</h1>

        <section class="stats">
            <div class="stat">
                <h4>Total Anggota</h4>
                <p>45</p>
            </div>
            <div class="stat">
                <h4>Hadir Pekan Ini</h4>
                <p>32</p>
            </div>
            <div class="stat">
                <h4>Izin</h4>
                <p>6</p>
            </div>
            <div class="stat">
                <h4>Tidak Hadir</h4>
                <p>7</p>
            </div>
        </section>

        <section class="chart">
            <canvas id="jamaahChart" height="95"></canvas>
        </section>
    </main>

    <script>
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        toggleSidebarBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        const ctx = document.getElementById('jamaahChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Kehadiran Jamaah',
                    data: [28, 30, 25, 32, 35, 27, 24],
                    backgroundColor: '#26a35a'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</body>
</html>
