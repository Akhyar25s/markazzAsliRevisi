<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Laporan - Sistem Markaz</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f5f0;
            color: #333;
        }

        /* Navbar */
        .navbar {
            background: #26a35a;
            color: white;
            padding: 0 20px;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .toggle-sidebar-btn {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s;
            padding: 8px;
            margin-right: 15px;
        }

        .toggle-sidebar-btn:hover {
            transform: scale(1.1);
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand::before {
            content: "📱";
            font-size: 24px;
        }

        .navbar-title {
            margin-left: 20px;
            font-size: 18px;
            font-weight: 600;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            text-align: right;
            font-size: 13px;
        }

        .user-info-name {
            font-weight: 600;
            font-size: 14px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 13px;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 60px;
            width: 250px;
            height: calc(100vh - 60px);
            background: #1e8449;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
            transition: transform 0.3s ease, left 0.3s ease;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 14px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #26a35a;
            color: white;
            padding-left: 25px;
        }

        .sidebar-menu a::before {
            content: "→";
            font-weight: bold;
            font-size: 16px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 30px;
            min-height: calc(100vh - 60px);
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
        }

        /* Date Filter */
        .date-filter {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .date-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .date-group label {
            font-size: 14px;
            font-weight: 600;
        }

        .date-group input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .date-group input:focus {
            outline: none;
            border-color: #26a35a;
            box-shadow: 0 0 0 3px rgba(38, 163, 90, 0.1);
        }

        .date-group button {
            background: #26a35a;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .date-group button:hover {
            background: #1e8449;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .stat-card h4 {
            font-size: 13px;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 10px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #26a35a;
            margin-bottom: 8px;
        }

        .stat-change {
            font-size: 12px;
            font-weight: 600;
        }

        .stat-change.positive {
            color: #28a745;
        }

        .stat-change.negative {
            color: #dc3545;
        }

        /* Charts Grid */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .chart-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .chart-container {
            position: relative;
            height: 250px;
            margin-bottom: 15px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn-action {
            background: #495057;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 14px;
        }

        .btn-action:hover {
            background: #383d41;
        }

        .btn-export {
            background: #26a35a;
        }

        .btn-export:hover {
            background: #1e8449;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .date-filter {
                flex-direction: column;
                align-items: flex-start;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-left">
            <button class="toggle-sidebar-btn" id="toggleSidebarBtn">☰</button>
            <a href="{{ route('dashboard') }}" class="navbar-brand">Sistem Markaz</a>
            <div class="navbar-title">Rekap Laporan</div>
        </div>
        <div class="navbar-right">
            <div class="user-info">
                <div class="user-info-name">{{ Auth::user()->nama }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin-masjid.kelola-pengguna') }}">Kelola Pengguna</a></li>
            <li><a href="{{ route('admin-masjid.rekap-laporan') }}" class="active">Rekap Laporan</a></li>
            <li><a href="#profil">Profil</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1 class="page-title">Rekap Laporan</h1>

        <!-- Date Filter -->
        <div class="date-filter">
            <div class="date-group">
                <label for="startDate">Tanggal Mulai</label>
                <input type="date" id="startDate">
                <button onclick="filterByDate()">→</button>
            </div>
            <div class="date-group">
                <label for="endDate">Tanggal Selesai</label>
                <input type="date" id="endDate">
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Pengguna</h4>
                <div class="stat-value">11.8M</div>
                <div class="stat-change positive">+2.5%</div>
            </div>
            <div class="stat-card">
                <h4>Pengguna Baru</h4>
                <div class="stat-value">8.236K</div>
                <div class="stat-change negative">-1.2%</div>
            </div>
            <div class="stat-card">
                <h4>Pengguna Aktif</h4>
                <div class="stat-value">2.352M</div>
                <div class="stat-change positive">+11%</div>
            </div>
            <div class="stat-card">
                <h4>Pengguna Baru</h4>
                <div class="stat-value">8K</div>
                <div class="stat-change positive">+5.2%</div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-grid">
            <!-- Target Chart -->
            <div class="chart-card">
                <div class="chart-title">Target</div>
                <div class="chart-container">
                    <canvas id="targetChart"></canvas>
                </div>
                <div style="text-align: center; color: #999; font-size: 40px; font-weight: 700; margin-top: 20px;">67%</div>
                <div style="text-align: center; font-size: 13px; color: #666;">Tercapai: 67% | Sisa: 33%</div>
            </div>

            <!-- Most Active Account Types -->
            <div class="chart-card">
                <div class="chart-title">Tipe Akun Paling Aktif</div>
                <div class="chart-container">
                    <canvas id="accountTypesChart"></canvas>
                </div>
            </div>

            <!-- Active Countries -->
            <div class="chart-card">
                <div class="chart-title">Negara Aktif</div>
                <div class="chart-container" style="height: 300px;">
                    <canvas id="countriesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn-action btn-export" onclick="exportData()">Ekspor ></button>
            <button class="btn-action" onclick="filterByProvince()">Berdasarkan Kegiatan</button>
            <button class="btn-action" onclick="filterByName()">Berdasarkan Nama</button>
            <button class="btn-action" onclick="filterByDate()">Berdasarkan Tanggal/Bulan</button>
        </div>
    </div>

    <script>
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');

        toggleSidebarBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        // Target Chart (Gauge)
        const targetCtx = document.getElementById('targetChart').getContext('2d');
        new Chart(targetCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tercapai', 'Sisa'],
                datasets: [{
                    data: [67, 33],
                    backgroundColor: ['#6c757d', '#dee2e6'],
                    borderColor: ['#6c757d', '#dee2e6'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });

        // Most Active Account Types
        const accountTypesCtx = document.getElementById('accountTypesChart').getContext('2d');
        new Chart(accountTypesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Sangat Aktif', 'Tidak Aktif'],
                datasets: [{
                    data: [60, 40],
                    backgroundColor: ['#6c757d', '#dee2e6'],
                    borderColor: ['#6c757d', '#dee2e6'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });

        // Active Countries Bar Chart
        const countriesCtx = document.getElementById('countriesChart').getContext('2d');
        new Chart(countriesCtx, {
            type: 'bar',
            data: {
                labels: ['Sangat Aktif', 'Tidak Aktif'],
                datasets: [{
                    label: 'Negara',
                    data: [65, 40],
                    backgroundColor: '#6c757d',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function exportData() {
            alert('Fitur ekspor sedang dalam pengembangan');
        }

        function filterByProvince() {
            alert('Fitur filter berdasarkan kegiatan sedang dalam pengembangan');
        }

        function filterByName() {
            alert('Fitur filter berdasarkan nama sedang dalam pengembangan');
        }

        function filterByDate() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            console.log('Filter dari:', startDate, 'sampai:', endDate);
            alert('Fitur filter berdasarkan tanggal sedang dalam pengembangan');
        }
    </script>
</body>
</html>
