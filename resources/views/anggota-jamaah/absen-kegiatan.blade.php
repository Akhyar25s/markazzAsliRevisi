<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Kegiatan - Sistem Markaz</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f5f0; color: #333; }

        .navbar { background: #26a35a; color: white; padding: 0 20px; height: 60px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,.15); position: fixed; top: 0; left: 0; right: 0; z-index: 1000; }
        .navbar-left { display: flex; align-items: center; gap: 0; }
        .toggle-sidebar-btn { background: none; border: none; color: white; font-size: 24px; cursor: pointer; padding: 8px; margin-right: 15px; }
        .navbar-brand { font-size: 20px; font-weight: 700; color: white; text-decoration: none; display: flex; align-items: center; gap: 10px; }
        .navbar-brand::before { content: "📱"; font-size: 24px; }
        .navbar-title { margin-left: 20px; font-size: 18px; font-weight: 600; }
        .logout-btn { background: rgba(255,255,255,.2); color: white; border: 1px solid rgba(255,255,255,.5); padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: 600; font-size: 13px; }

        .sidebar { position: fixed; left: 0; top: 60px; width: 250px; height: calc(100vh - 60px); background: #1e8449; overflow-y: auto; box-shadow: 2px 0 10px rgba(0,0,0,.1); z-index: 100; transition: transform .3s ease; }
        .sidebar.collapsed { transform: translateX(-100%); }
        .sidebar-menu { list-style: none; padding: 20px 0; }
        .sidebar-menu a { display: flex; align-items: center; gap: 12px; padding: 15px 20px; color: rgba(255,255,255,.85); text-decoration: none; transition: all .3s; font-weight: 500; font-size: 14px; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: #26a35a; color: white; padding-left: 25px; }
        .sidebar-menu a::before { content: "→"; font-weight: bold; font-size: 16px; }

        .main-content { margin-left: 250px; margin-top: 60px; padding: 30px; min-height: calc(100vh - 60px); transition: margin-left .3s ease; }
        .main-content.expanded { margin-left: 0; }

        .page-title { font-size: 28px; font-weight: 700; margin-bottom: 20px; }

        .table-card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.08); overflow: hidden; margin-bottom: 16px; }
        .table-header { display: flex; justify-content: space-between; align-items: center; padding: 14px 16px; border-bottom: 1px solid #edf2ed; }
        .table-header h3 { font-size: 18px; color: #1f3f2c; }
        .btn-add { background: #26a35a; color: white; border: none; padding: 10px 14px; border-radius: 6px; cursor: pointer; font-weight: 700; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 14px; border-bottom: 1px solid #edf2ed; text-align: left; font-size: 14px; }
        th { background: #f2fbf4; color: #24583c; }

        .form-card { display: none; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.08); padding: 18px; }
        .form-card.show { display: block; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px 18px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #2d5039; }
        .form-group input, .form-group select { width: 100%; padding: 10px 12px; border: 1px solid #dce6dd; border-radius: 6px; font-size: 14px; }
        .map-wrap { grid-column: 1 / -1; border: 1px solid #dce6dd; border-radius: 8px; overflow: hidden; }
        .map-wrap iframe { width: 100%; height: 260px; border: 0; }
        .form-actions { display: flex; gap: 10px; margin-top: 14px; }
        .btn-secondary { background: #5d8f6e; color: white; border: none; padding: 10px 14px; border-radius: 6px; cursor: pointer; font-weight: 700; }
        .btn-primary { background: #26a35a; color: white; border: none; padding: 10px 14px; border-radius: 6px; cursor: pointer; font-weight: 700; }

        .scan-card { display: none; margin-top: 14px; padding: 16px; border: 1px dashed #b9d7c1; border-radius: 8px; background: #f7fcf8; }
        .scan-card.show { display: block; }
        .scan-title { font-weight: 700; color: #1f3f2c; margin-bottom: 8px; }
        .scan-preview { height: 200px; border-radius: 8px; background: linear-gradient(135deg, #d3ecdc 0%, #ebf8ef 60%, #f8fdf9 100%); display: flex; align-items: center; justify-content: center; color: #3f7253; font-weight: 700; }
        .scan-actions { margin-top: 10px; display: flex; gap: 10px; }

        .toast { position: fixed; right: 20px; top: 80px; min-width: 280px; background: #1e8449; color: white; padding: 12px 14px; border-radius: 8px; box-shadow: 0 8px 20px rgba(0,0,0,.2); z-index: 3000; transform: translateY(-15px); opacity: 0; pointer-events: none; transition: all .25s ease; font-size: 14px; font-weight: 600; }
        .toast.show { opacity: 1; transform: translateY(0); }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .form-grid { grid-template-columns: 1fr; }
            .table-card { overflow-x: auto; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <button class="toggle-sidebar-btn" id="toggleSidebarBtn">☰</button>
            <a href="{{ route('dashboard') }}" class="navbar-brand">Sistem Markaz</a>
            <div class="navbar-title">Absen Kegiatan</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">@csrf<button type="submit" class="logout-btn">Logout</button></form>
    </div>

    <aside class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('anggota-jamaah.absen-kegiatan') }}" class="active">Absen Kegiatan</a></li>
            <li><a href="{{ route('anggota-jamaah.itikaf') }}">I'tikaf</a></li>
        </ul>
    </aside>

    <main class="main-content" id="mainContent">
        <h1 class="page-title">Absen Kegiatan</h1>

        <section class="table-card">
            <div class="table-header">
                <h3>Daftar Kegiatan Absen Anda</h3>
                <button class="btn-add" id="btnTambahKegiatan">Tambah Kegiatan</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="absenTableBody">
                    <tr>
                        <td>Kunjungan</td>
                        <td>04-04-2026</td>
                        <td>09:00</td>
                        <td>Masjid Al-Ihsan</td>
                        <td>Hadir</td>
                    </tr>
                    <tr>
                        <td>Kultum</td>
                        <td>03-04-2026</td>
                        <td>18:30</td>
                        <td>Masjid Al-Ikhlas</td>
                        <td>Hadir</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="form-card" id="formKegiatanCard">
            <h3 style="margin-bottom: 12px; color:#1f3f2c;">Form Tambah Kegiatan</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label>Jenis Kegiatan</label>
                    <select id="jenisKegiatan">
                        <option value="">Pilih kegiatan</option>
                        <option value="Kunjungan">Kunjungan</option>
                        <option value="Kultum">Kultum</option>
                        <option value="Ta'lim">Ta'lim</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input id="tanggalKegiatan" type="date">
                </div>
                <div class="form-group">
                    <label>Jam</label>
                    <input id="jamKegiatan" type="time">
                </div>
                <div class="form-group">
                    <label>Nama Lokasi</label>
                    <input id="lokasiKegiatan" type="text" placeholder="Contoh: Masjid Al-Ihsan">
                </div>
                <div class="map-wrap">
                    <iframe src="https://maps.google.com/maps?q=-6.200000,106.816666&z=15&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="form-actions">
                <button class="btn-secondary" type="button" id="btnBatalTambah">Batal</button>
                <button class="btn-primary" type="button" id="btnLanjutScan">Lanjut Scan Wajah</button>
            </div>

            <div class="scan-card" id="scanCard">
                <div class="scan-title">Scan Wajah untuk Validasi Absen</div>
                <div class="scan-preview">Preview kamera (placeholder)</div>
                <div class="scan-actions">
                    <button class="btn-secondary" type="button" id="btnTutupScan">Kembali</button>
                    <button class="btn-primary" type="button" id="btnVerifikasiWajah">Verifikasi Wajah</button>
                </div>
            </div>
        </section>
    </main>

    <div id="toast" class="toast"></div>

    <script>
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const formCard = document.getElementById('formKegiatanCard');
        const scanCard = document.getElementById('scanCard');
        const absenTableBody = document.getElementById('absenTableBody');
        const toast = document.getElementById('toast');

        toggleSidebarBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        function showToast(message) {
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2400);
        }

        document.getElementById('btnTambahKegiatan').addEventListener('click', function () {
            formCard.classList.add('show');
            scanCard.classList.remove('show');
            formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        document.getElementById('btnBatalTambah').addEventListener('click', function () {
            formCard.classList.remove('show');
            scanCard.classList.remove('show');
        });

        document.getElementById('btnLanjutScan').addEventListener('click', function () {
            const jenis = document.getElementById('jenisKegiatan').value;
            const tanggal = document.getElementById('tanggalKegiatan').value;
            const jam = document.getElementById('jamKegiatan').value;
            const lokasi = document.getElementById('lokasiKegiatan').value;

            if (!jenis || !tanggal || !jam || !lokasi) {
                showToast('Lengkapi form kegiatan terlebih dahulu.');
                return;
            }

            scanCard.classList.add('show');
            scanCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });

        document.getElementById('btnTutupScan').addEventListener('click', function () {
            scanCard.classList.remove('show');
        });

        document.getElementById('btnVerifikasiWajah').addEventListener('click', function () {
            const jenis = document.getElementById('jenisKegiatan').value;
            const tanggal = document.getElementById('tanggalKegiatan').value;
            const jam = document.getElementById('jamKegiatan').value;
            const lokasi = document.getElementById('lokasiKegiatan').value;

            const row = document.createElement('tr');
            row.innerHTML = `<td>${jenis}</td><td>${tanggal}</td><td>${jam}</td><td>${lokasi}</td><td>Hadir</td>`;
            absenTableBody.prepend(row);

            formCard.classList.remove('show');
            scanCard.classList.remove('show');
            document.getElementById('jenisKegiatan').value = '';
            document.getElementById('tanggalKegiatan').value = '';
            document.getElementById('jamKegiatan').value = '';
            document.getElementById('lokasiKegiatan').value = '';

            showToast('Absen kegiatan berhasil dibuat dan terverifikasi wajah.');
        });
    </script>
</body>
</html>
