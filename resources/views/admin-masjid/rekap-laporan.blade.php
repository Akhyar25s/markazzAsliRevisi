<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Laporan - Sistem Markaz</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
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

        .user-info-role {
            font-size: 12px;
            opacity: 0.9;
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
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
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

        /* Filter Box */
        .filter-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            gap: 20px;
            align-items: flex-end;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            flex-wrap: wrap;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
        }

        .filter-input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            width: 200px;
        }

        .filter-btn {
            padding: 8px 20px;
            background: #26a35a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .filter-btn:hover {
            background: #1e8449;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .stat-label {
            font-size: 12px;
            color: #999;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #26a35a;
            margin-bottom: 5px;
        }

        .stat-change {
            font-size: 12px;
            font-weight: 600;
            color: #26a35a;
        }

        .stat-change.negative {
            color: #e74c3c;
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
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .chart-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .chart-container {
            position: relative;
            height: 250px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 10px 20px;
            background: #666;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s;
        }

        .btn-action:hover {
            background: #444;
        }

        .btn-action.secondary {
            background: #999;
        }

        .btn-action.secondary:hover {
            background: #777;
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

            .filter-box {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-input {
                width: 100%;
            }

            .page-title {
                font-size: 22px;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 15px;
            }

            .stat-value {
                font-size: 24px;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .chart-container {
                height: 200px;
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
        </div>
        <div class="navbar-right">
            <div class="user-info">
                <div class="user-info-name">{{ Auth::user()->nama }}</div>
                <div class="user-info-role">{{ Auth::user()->role }}</div>
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
            <li><a href="#kelola-pengguna">Kelola Pengguna</a></li>
            <li><a href="#rekap-laporan" class="active">Rekap Laporan</a></li>
            <li><a href="#profil">Profil</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1 class="page-title">Rekap Laporan</h1>

        <!-- Filter Box -->
        <div class="filter-box">
            <div class="filter-item">
                <label class="filter-label">Start date</label>
                <input type="date" class="filter-input" id="startDate">
            </div>
            <div class="filter-item">
                <label class="filter-label">End date</label>
                <input type="date" class="filter-input" id="endDate">
            </div>
            <button class="filter-btn">→</button>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Users Total</div>
                <div class="stat-value">11.8M</div>
                <div class="stat-change">+2.5%</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">New Users</div>
                <div class="stat-value">8.236k</div>
                <div class="stat-change negative">-1.2%</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Active Users</div>
                <div class="stat-value">2.352M</div>
                <div class="stat-change">+11%</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">New Users</div>
                <div class="stat-value">8K</div>
                <div class="stat-change">+5.2%</div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="charts-grid">
            <!-- Target Chart -->
            <div class="chart-card">
                <div class="chart-title">Target</div>
                <div class="chart-container">
                    <canvas id="targetChart"></canvas>
                </div>
            </div>

            <!-- Most Active Account Types -->
            <div class="chart-card">
                <div class="chart-title">Most Active Account Types</div>
                <div class="chart-container">
                    <canvas id="accountTypesChart"></canvas>
                </div>
            </div>

            <!-- Active Countries -->
            <div class="chart-card">
                <div class="chart-title">Active Countries</div>
                <div style="padding: 20px; text-align: center; color: #999;">
                    World map visualization (placeholder)
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn-action">Export</button>
            <button class="btn-action secondary">Berdasarkan Kegiatan</button>
            <button class="btn-action secondary">Berdasarkan Nama</button>
            <button class="btn-action secondary">Berdasarkan Tanggal/Bulan</button>
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

        // Target Chart (Gauge-style)
        const targetCtx = document.getElementById('targetChart').getContext('2d');
        new Chart(targetCtx, {
            type: 'doughnut',
            data: {
                labels: ['Achieved', 'Remaining'],
                datasets: [{
                    data: [67, 33],
                    backgroundColor: ['#4a5568', '#e2e8f0'],
                    borderWidth: 0
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

        // Most Active Account Types Chart
        const accountTypesCtx = document.getElementById('accountTypesChart').getContext('2d');
        new Chart(accountTypesCtx, {
            type: 'pie',
            data: {
                labels: ['Very Active', 'Inactive'],
                datasets: [{
                    data: [60, 40],
                    backgroundColor: ['#4a5568', '#cbd5e0'],
                    borderWidth: 0
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

        // Set today's date as default
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('startDate').valueAsDate = new Date(new Date().setDate(new Date().getDate() - 7));
        document.getElementById('endDate').value = today;
    </script>
</body>
</html>
