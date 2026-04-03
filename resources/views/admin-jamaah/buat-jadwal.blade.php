<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Jadwal - Sistem Markaz</title>
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

        .form-wrap {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 20px;
        }

        .field label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #2f3d34;
        }

        .field input,
        .field select {
            width: 100%;
            border: 1px solid #d9dfdb;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 14px;
            background: #fbfdfb;
        }

        .preview {
            margin-top: 18px;
            height: 220px;
            border-radius: 10px;
            border: 1px solid #e1e7e2;
            background: radial-gradient(circle at 70% 30%, #d9f1e2 0, #edf8f1 32%, #f7fcf9 100%);
        }

        .form-actions {
            margin-top: 16px;
            text-align: center;
        }

        .save-btn {
            border: none;
            background: #26a35a;
            color: white;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
        }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <button class="toggle-sidebar-btn" id="toggleSidebarBtn">☰</button>
            <a href="{{ route('dashboard') }}" class="navbar-brand">Sistem Markaz</a>
            <div class="navbar-title">Buat Jadwal</div>
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
        <h1 class="page-title">Buat Jadwal</h1>

        <div class="form-wrap">
            <form>
                <div class="form-grid">
                    <div class="field">
                        <label>Tanggal</label>
                        <input type="date">
                    </div>
                    <div class="field">
                        <label>Masjid</label>
                        <input type="text" placeholder="Nama masjid">
                    </div>
                    <div class="field">
                        <label>Amir</label>
                        <select>
                            <option>Pilih amir</option>
                            <option>A'syim</option>
                            <option>Ahyar</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Anggota</label>
                        <input type="text" placeholder="Tambah anggota">
                    </div>
                    <div class="field">
                        <label>Total Hari</label>
                        <select>
                            <option>3 Hari</option>
                            <option>10 Hari</option>
                            <option>30 Hari</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Anggota Tambahan</label>
                        <input type="text" placeholder="Tambah anggota berikutnya">
                    </div>
                </div>

                <div class="preview"></div>

                <div class="form-actions">
                    <button type="submit" class="save-btn">Simpan</button>
                </div>
            </form>
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
