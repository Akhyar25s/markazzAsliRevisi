<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keaktifan Anggota - Sistem Markaz</title>
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

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

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

        .sidebar-menu a::before {
            content: "→";
            font-weight: bold;
            font-size: 16px;
        }

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

        .filter-row {
            display: grid;
            grid-template-columns: 1fr 120px 170px 170px 80px;
            gap: 10px;
            background: white;
            padding: 14px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 16px;
        }

        .filter-row input,
        .filter-row button {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 14px;
        }

        .filter-row button {
            background: #4f5e6d;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        .list {
            display: grid;
            gap: 10px;
        }

        .item {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .item-name {
            font-size: 18px;
            font-weight: 600;
            color: #444;
        }

        .bar-wrap {
            width: 280px;
            height: 20px;
            background: #eef1ef;
            border-radius: 999px;
            overflow: hidden;
        }

        .bar {
            height: 100%;
            background: linear-gradient(90deg, #1e8449 0%, #67c08b 100%);
        }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .filter-row { grid-template-columns: 1fr; }
            .item { flex-direction: column; align-items: flex-start; }
            .bar-wrap { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <button class="toggle-sidebar-btn" id="toggleSidebarBtn">☰</button>
            <a href="{{ route('dashboard') }}" class="navbar-brand">Sistem Markaz</a>
            <div class="navbar-title">Keaktifan Anggota</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <aside class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin-jamaah.keaktifan-anggota') }}" class="active">Keaktifan Anggota</a></li>
            <li><a href="{{ route('admin-jamaah.rekap-laporan') }}">Rekap Laporan</a></li>
            <li><a href="{{ route('admin-jamaah.kelompok-itikaf') }}">Kelompok I'tikaf</a></li>
        </ul>
    </aside>

    <main class="main-content" id="mainContent">
        <h1 class="page-title">Keaktifan Anggota</h1>

        <div class="filter-row">
            <input type="text" placeholder="Ketik nama/kegiatan yang ingin dicari...">
            <button>Cari</button>
            <input type="date" aria-label="Tanggal mulai">
            <input type="date" aria-label="Tanggal selesai">
            <button>Filter</button>
        </div>

        <section class="list">
            <article class="item"><div class="item-name">Asyim</div><div class="bar-wrap"><div class="bar" style="width:92%"></div></div></article>
            <article class="item"><div class="item-name">Ahyar</div><div class="bar-wrap"><div class="bar" style="width:100%"></div></div></article>
            <article class="item"><div class="item-name">Ahay</div><div class="bar-wrap"><div class="bar" style="width:68%"></div></div></article>
            <article class="item"><div class="item-name">Ahmad Nazar</div><div class="bar-wrap"><div class="bar" style="width:87%"></div></div></article>
            <article class="item"><div class="item-name">Ahmad Muzaki</div><div class="bar-wrap"><div class="bar" style="width:82%"></div></div></article>
            <article class="item"><div class="item-name">Aliando Syarief</div><div class="bar-wrap"><div class="bar" style="width:56%"></div></div></article>
            <article class="item"><div class="item-name">Alexander Islam</div><div class="bar-wrap"><div class="bar" style="width:79%"></div></div></article>
            <article class="item"><div class="item-name">Guz Salamanca</div><div class="bar-wrap"><div class="bar" style="width:74%"></div></div></article>
            <article class="item"><div class="item-name">Bahrudini</div><div class="bar-wrap"><div class="bar" style="width:61%"></div></div></article>
            <article class="item"><div class="item-name">Carlieansyah</div><div class="bar-wrap"><div class="bar" style="width:70%"></div></div></article>
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
    </script>
</body>
</html>
