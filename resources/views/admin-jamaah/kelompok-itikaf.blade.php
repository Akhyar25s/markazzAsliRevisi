<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelompok I'tikaf - Sistem Markaz</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f5f0;
            color: #333;
        }

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
            padding: 8px;
            margin-right: 15px;
        }

        .navbar-left { display: flex; align-items: center; }

        .navbar-brand {
            font-size: 20px;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand::before { content: "📱"; font-size: 24px; }

        .navbar-title { margin-left: 20px; font-size: 18px; font-weight: 600; }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
        }

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

        .sidebar.collapsed { transform: translateX(-100%); }

        .sidebar-menu { list-style: none; padding: 20px 0; }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.85);
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

        .sidebar-menu a::before { content: "→"; font-weight: bold; font-size: 16px; }

        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 30px;
            min-height: calc(100vh - 60px);
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded { margin-left: 0; }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .btn-create {
            border: none;
            background: #26a35a;
            color: white;
            padding: 12px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 16px;
        }

        .table-wrap {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: #edf7f0;
            color: #1f3c2c;
            text-align: left;
            padding: 14px;
            font-size: 14px;
        }

        tbody td {
            padding: 14px;
            border-top: 1px solid #eef2ef;
            font-size: 14px;
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .table-wrap { overflow-x: auto; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <button class="toggle-sidebar-btn" id="toggleSidebarBtn">☰</button>
            <a href="{{ route('dashboard') }}" class="navbar-brand">Sistem Markaz</a>
            <div class="navbar-title">Kelompok I'tikaf</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <aside class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin-jamaah.keaktifan-anggota') }}">Keaktifan Anggota</a></li>
            <li><a href="{{ route('admin-jamaah.rekap-laporan') }}">Rekap Laporan</a></li>
            <li><a href="{{ route('admin-jamaah.kelompok-itikaf') }}" class="active">Kelompok I'tikaf</a></li>
        </ul>
    </aside>

    <main class="main-content" id="mainContent">
        <h1 class="page-title">Kelompok I'tikaf</h1>

        <a class="btn-create" href="{{ route('admin-jamaah.buat-jadwal') }}">Buat Jadwal</a>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tempat</th>
                        <th>Nama Amir</th>
                        <th>Total Hari</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>02 Februari 2026</td>
                        <td>Masjid Al-Ihsan</td>
                        <td>A'syim</td>
                        <td>3 Hari</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        toggleSidebarBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    </script>
</body>
</html>
