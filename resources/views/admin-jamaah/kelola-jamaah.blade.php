<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jamaah - Sistem Markaz</title>
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
        .toolbar { background: #fff; padding: 16px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.08); display: flex; gap: 10px; margin-bottom: 20px; }
        .toolbar input { flex: 1; border: 1px solid #ddd; border-radius: 6px; padding: 10px 12px; }
        .btn { border: none; border-radius: 6px; padding: 10px 14px; cursor: pointer; font-weight: 600; }
        .btn-primary { background: #26a35a; color: #fff; }
        .btn-secondary { background: #4d5a67; color: #fff; }
        .grid { display: grid; gap: 15px; }
        .card { background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.08); padding: 16px; display: flex; justify-content: space-between; align-items: center; }
        .name { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .meta { color: #666; font-size: 14px; }
        .actions { display: flex; gap: 8px; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .card { flex-direction: column; align-items: flex-start; gap: 10px; }
            .actions { width: 100%; }
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
            <li><a href="{{ route('admin-jamaah.kelola-jamaah') }}" class="active">Kelola Jamaah</a></li>
            <li><a href="{{ route('admin-jamaah.kelola-kegiatan') }}">Kelola Kegiatan</a></li>
            <li><a href="{{ route('admin-jamaah.laporan-jamaah') }}">Laporan Jamaah</a></li>
        </ul>
    </div>

    <main class="main-content" id="mainContent">
        <h1 class="page-title">Kelola Jamaah</h1>

        <div class="toolbar">
            <input type="text" placeholder="Cari nama anggota jamaah...">
            <button class="btn btn-primary">Cari</button>
            <button class="btn btn-secondary">Tambah Anggota</button>
        </div>

        <section class="grid">
            <article class="card">
                <div>
                    <div class="name">Ahyar</div>
                    <div class="meta">No. HP: 08xxxxxxxxxx | Status: Aktif</div>
                </div>
                <div class="actions">
                    <button class="btn btn-secondary">Detail</button>
                    <button class="btn btn-primary">Ubah</button>
                </div>
            </article>
            <article class="card">
                <div>
                    <div class="name">Ahmad Muzaki</div>
                    <div class="meta">No. HP: 08xxxxxxxxxx | Status: Aktif</div>
                </div>
                <div class="actions">
                    <button class="btn btn-secondary">Detail</button>
                    <button class="btn btn-primary">Ubah</button>
                </div>
            </article>
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
