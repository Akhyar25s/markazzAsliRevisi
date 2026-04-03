<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Markaz</title>
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

        .welcome-box {
            background: linear-gradient(135deg, #26a35a 0%, #1e8449 100%);
            color: white;
            padding: 40px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(38, 163, 90, 0.3);
        }

        .welcome-box h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .welcome-box p {
            font-size: 16px;
            opacity: 0.95;
        }

        /* Stats Section */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-top: 3px solid #26a35a;
        }

        .stat-card h4 {
            font-size: 12px;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 10px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .stat-card .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #26a35a;
        }

        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .menu-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: #333;
            border-left: 4px solid #26a35a;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(38, 163, 90, 0.2);
            border-left-color: #1e8449;
        }

        .menu-card-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .menu-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #26a35a;
        }

        .menu-card p {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
        }

        .section-title {
            margin-bottom: 20px;
            font-size: 20px;
            color: #333;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .menu-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
            }

            .menu-card {
                padding: 20px;
            }

            .welcome-box {
                padding: 25px;
            }

            .welcome-box h2 {
                font-size: 24px;
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
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
            <li><a href="{{ route('dashboard') }}" class="active">Dashboard</a></li>
            <li><a href="#absen-kegiatan">Absen Kegiatan</a></li>
            <li><a href="#absen-itikaf">Absen I'tikaf</a></li>
            <li><a href="#jadwal">Jadwal</a></li>
            <li><a href="#keaktifan">Keaktifan</a></li>
            <li><a href="#laporan">Laporan</a></li>
            <li><a href="#profil">Profil</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Welcome Section -->
        <div class="welcome-box">
            <h2>Selamat Datang, {{ Auth::user()->nama }}!</h2>
            <p>Kelola kehadiran dan aktivitas kegiatan Anda dengan mudah melalui sistem Markaz.</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <h4>Kehadiran Bulan Ini</h4>
                <div class="stat-value">8</div>
            </div>
            <div class="stat-card">
                <h4>I'tikaf Tahun Ini</h4>
                <div class="stat-value">2</div>
            </div>
            <div class="stat-card">
                <h4>Tingkat Keaktifan</h4>
                <div class="stat-value">85%</div>
            </div>
            <div class="stat-card">
                <h4>Status Wajah</h4>
                <div class="stat-value">✓</div>
            </div>
        </div>

        <!-- Menu Grid -->
        <h3 class="section-title">Menu Utama</h3>
        <div class="menu-grid">
            <a href="#absen-kegiatan" class="menu-card">
                <div class="menu-card-icon">📋</div>
                <h3>Absen Kegiatan</h3>
                <p>Absensi kehadiran pada kegiatan rutin masjid dengan verifikasi wajah.</p>
            </a>

            <a href="#absen-itikaf" class="menu-card">
                <div class="menu-card-icon">🕌</div>
                <h3>Absen I'tikaf</h3>
                <p>Pencatatan kehadiran khusus kegiatan I'tikaf Ramadan.</p>
            </a>

            <a href="#jadwal" class="menu-card">
                <div class="menu-card-icon">📅</div>
                <h3>Jadwal</h3>
                <p>Lihat jadwal kegiatan dan program yang akan datang.</p>
            </a>

            <a href="#keaktifan" class="menu-card">
                <div class="menu-card-icon">📊</div>
                <h3>Keaktifan</h3>
                <p>Pantau tingkat keaktifan dan partisipasi Anda.</p>
            </a>

            <a href="#laporan" class="menu-card">
                <div class="menu-card-icon">📈</div>
                <h3>Laporan</h3>
                <p>Download laporan kehadiran dan aktivitas Anda.</p>
            </a>

            <a href="#profil" class="menu-card">
                <div class="menu-card-icon">👤</div>
                <h3>Profil</h3>
                <p>Kelola informasi profil dan keamanan akun Anda.</p>
            </a>
        </div>
    </div>

    <script>
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');

        // Toggle sidebar on button click
        toggleSidebarBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        // Active menu handler
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>
