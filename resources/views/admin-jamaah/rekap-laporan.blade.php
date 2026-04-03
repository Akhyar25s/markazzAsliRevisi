<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Laporan - Sistem Markaz</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .filter {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            background: white;
            padding: 14px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 14px;
        }

        .filter input,
        .filter button {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 14px;
        }

        .filter button {
            border: none;
            background: #4f5e6d;
            color: white;
            font-weight: 600;
            cursor: pointer;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-bottom: 12px;
        }

        .stat-card {
            background: white;
            padding: 16px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .stat-card h4 {
            color: #70757a;
            font-size: 12px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: #1f2933;
        }

        .chart-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1.35fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        .chart-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 14px;
            min-height: 260px;
        }

        .chart-card h3 {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .legend {
            font-size: 12px;
            color: #66707a;
            margin-bottom: 8px;
        }

        .map-placeholder {
            height: 200px;
            border: 2px dashed #d0d7d1;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #708079;
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .send-options {
            display: none;
            gap: 10px;
            flex-wrap: wrap;
        }

        .send-options.show {
            display: flex;
        }

        .actions button {
            border: none;
            background: #6e7983;
            color: white;
            padding: 10px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .filter { justify-content: stretch; flex-wrap: wrap; }
            .chart-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <button class="toggle-sidebar-btn" id="toggleSidebarBtn">☰</button>
            <a href="{{ route('dashboard') }}" class="navbar-brand">Sistem Markaz</a>
            <div class="navbar-title">Rekap Laporan</div>
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
            <li><a href="{{ route('admin-jamaah.rekap-laporan') }}" class="active">Rekap Laporan</a></li>
            <li><a href="{{ route('admin-jamaah.kelompok-itikaf') }}">Kelompok I'tikaf</a></li>
        </ul>
    </aside>

    <main class="main-content" id="mainContent">
        <h1 class="page-title">Rekap Laporan</h1>

        <div class="filter">
            <input type="date" aria-label="Tanggal mulai">
            <button>→</button>
            <input type="date" aria-label="Tanggal selesai">
            <button>📅</button>
        </div>

        <section class="stats-grid">
            <article class="stat-card"><h4>Total Pengguna</h4><div class="value">11.8M</div></article>
            <article class="stat-card"><h4>Pengguna Baru</h4><div class="value">8.236K</div></article>
            <article class="stat-card"><h4>Pengguna Aktif</h4><div class="value">2.352M</div></article>
            <article class="stat-card"><h4>Pengguna Baru</h4><div class="value">8K</div></article>
        </section>

        <section class="chart-grid">
            <article class="chart-card">
                <h3>Target</h3>
                <div class="legend">Tercapai | Sisa</div>
                <canvas id="targetChart"></canvas>
            </article>
            <article class="chart-card">
                <h3>Tipe Akun Paling Aktif</h3>
                <div class="legend">Sangat Aktif | Tidak Aktif</div>
                <canvas id="accountChart"></canvas>
            </article>
            <article class="chart-card">
                <h3>Negara Aktif</h3>
                <div class="legend">Sangat Aktif | Tidak Aktif</div>
                <div class="map-placeholder">Peta dunia (placeholder)</div>
            </article>
        </section>

        <div class="actions">
            <button id="sendBtn" onclick="toggleSendOptions()">Kirim</button>
            <div class="send-options" id="sendOptions">
                <button onclick="filterByKegiatan()">Berdasarkan Kegiatan</button>
                <button onclick="filterByNama()">Berdasarkan Nama</button>
                <button onclick="filterByTanggal()">Berdasarkan Tanggal/Bulan</button>
            </div>
        </div>
    </main>

    <script>
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sendBtn = document.getElementById('sendBtn');
        const sendOptions = document.getElementById('sendOptions');

        toggleSidebarBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        const targetCtx = document.getElementById('targetChart');
        new Chart(targetCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tercapai', 'Sisa'],
                datasets: [{ data: [67, 33], backgroundColor: ['#26a35a', '#d8e8dd'] }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        const accountCtx = document.getElementById('accountChart');
        new Chart(accountCtx, {
            type: 'polarArea',
            data: {
                labels: ['A', 'B', 'C', 'D'],
                datasets: [{ data: [20, 28, 18, 34], backgroundColor: ['#1e8449', '#4ea86f', '#88c9a1', '#cce8d8'] }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        function toggleSendOptions() {
            const isShown = sendOptions.classList.toggle('show');
            sendBtn.textContent = isShown ? 'Tutup Opsi' : 'Kirim';
        }

        function filterByKegiatan() {
            alert('Kirim laporan berdasarkan kegiatan sedang dalam pengembangan');
        }

        function filterByNama() {
            alert('Kirim laporan berdasarkan nama sedang dalam pengembangan');
        }

        function filterByTanggal() {
            alert('Kirim laporan berdasarkan tanggal/bulan sedang dalam pengembangan');
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.actions')) {
                sendOptions.classList.remove('show');
                sendBtn.textContent = 'Kirim';
            }
        });
    </script>
</body>
</html>
