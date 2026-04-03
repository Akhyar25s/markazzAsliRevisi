<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I'tikaf - Sistem Markaz</title>
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
        .tab-wrap { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.08); overflow: hidden; }
        .tabs { display: grid; grid-template-columns: 1fr 1fr; border-bottom: 1px solid #e5efe8; }
        .tab-btn { border: none; background: #eef8f1; color: #24583c; padding: 14px; font-size: 16px; font-weight: 700; cursor: pointer; }
        .tab-btn.active { background: white; color: #1f3f2c; }
        .tab-content { display: none; padding: 18px; }
        .tab-content.active { display: block; }

        .itikaf-card { background: #f4fbf6; border: 1px solid #dceadf; border-radius: 12px; padding: 16px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; }
        .itikaf-title { font-size: 20px; font-weight: 700; color: #1f3f2c; margin-bottom: 4px; }
        .itikaf-sub { font-size: 16px; color: #3d6a4f; }
        .itikaf-right { text-align: right; }
        .itikaf-amir { font-size: 22px; font-weight: 700; margin-bottom: 8px; color: #24583c; }
        .btn-absen { border: none; background: #2f7f4c; color: white; padding: 10px 14px; border-radius: 6px; cursor: pointer; font-weight: 700; font-size: 14px; }

        .kegiatan-card { background: #f4fbf6; border: 1px solid #dceadf; border-radius: 12px; padding: 16px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: end; }
        .kegiatan-title { font-size: 22px; font-weight: 700; color: #1f3f2c; margin-bottom: 6px; }
        .kegiatan-sub { font-size: 16px; color: #3d6a4f; }
        .kegiatan-progress { font-size: 24px; font-weight: 700; color: #2f7f4c; }
        .kegiatan-actions { margin-top: 10px; }
        .btn-mini { border: none; background: #2f7f4c; color: white; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-weight: 700; font-size: 12px; }

        .day-panel { background: #ecf8f0; border: 1px solid #d2e8d9; border-radius: 10px; padding: 12px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .day-label { color: #1f3f2c; font-weight: 700; }
        .day-actions { display: flex; gap: 8px; }

        .status-list { margin-top: 14px; }
        .status-item { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5efe8; padding: 12px 6px; font-size: 16px; }
        .status-ok { color: #1e8449; font-weight: 700; }
        .status-pending { color: #c27800; font-weight: 700; }
        .btn-lanjut { margin-top: 14px; margin-left: auto; display: block; border: none; background: #2f7f4c; color: white; padding: 10px 16px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 700; }

        .absen-form {
            margin-top: 14px;
            border: 1px solid #dceadf;
            border-radius: 10px;
            background: #f8fdf9;
            padding: 12px;
            display: none;
        }

        .absen-form.show { display: block; }

        .absen-form-title {
            font-weight: 700;
            margin-bottom: 10px;
            color: #1f3f2c;
        }

        .status-item select {
            border: 1px solid #cfe0d5;
            border-radius: 6px;
            padding: 6px 8px;
            font-size: 13px;
            background: white;
        }

        .toast { position: fixed; right: 20px; top: 80px; min-width: 280px; background: #1e8449; color: white; padding: 12px 14px; border-radius: 8px; box-shadow: 0 8px 20px rgba(0,0,0,.2); z-index: 3000; transform: translateY(-15px); opacity: 0; pointer-events: none; transition: all .25s ease; font-size: 14px; font-weight: 600; }
        .toast.show { opacity: 1; transform: translateY(0); }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .itikaf-card, .kegiatan-card { flex-direction: column; align-items: flex-start; gap: 10px; }
            .itikaf-right { text-align: left; }
            .itikaf-title { font-size: 22px; }
            .itikaf-sub, .kegiatan-sub { font-size: 16px; }
            .itikaf-amir, .kegiatan-title, .kegiatan-progress, .status-item, .btn-absen, .btn-lanjut { font-size: 16px; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <button class="toggle-sidebar-btn" id="toggleSidebarBtn">☰</button>
            <a href="{{ route('dashboard') }}" class="navbar-brand">Sistem Markaz</a>
            <div class="navbar-title">I'tikaf</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">@csrf<button type="submit" class="logout-btn">Logout</button></form>
    </div>

    <aside class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('anggota-jamaah.absen-kegiatan') }}">Absen Kegiatan</a></li>
            <li><a href="{{ route('anggota-jamaah.itikaf') }}" class="active">I'tikaf</a></li>
        </ul>
    </aside>

    <main class="main-content" id="mainContent">
        <h1 class="page-title">I'tikaf</h1>

        <section class="tab-wrap">
            <div class="tabs">
                <button class="tab-btn active" data-tab="khusus">Absen Khusus I'tikaf</button>
                <button class="tab-btn" data-tab="amir">Amir I'tikaf</button>
            </div>

            <div class="tab-content active" id="tab-khusus">
                <article class="itikaf-card">
                    <div>
                        <div class="itikaf-title">Masjid Al-Ihsan</div>
                        <div class="itikaf-sub">3 Hari</div>
                    </div>
                    <div class="itikaf-right">
                        <div class="itikaf-amir">A'syim</div>
                        <button class="btn-absen" onclick="showToast('Absen I\'tikaf untuk Masjid Al-Ihsan berhasil.')">Absen</button>
                    </div>
                </article>
                <article class="itikaf-card">
                    <div>
                        <div class="itikaf-title">Masjid Sabilal</div>
                        <div class="itikaf-sub">1 Hari</div>
                    </div>
                    <div class="itikaf-right">
                        <div class="itikaf-amir">Nazar</div>
                        <button class="btn-absen" onclick="showToast('Absen I\'tikaf untuk Masjid Sabilal berhasil.')">Absen</button>
                    </div>
                </article>
                <article class="itikaf-card">
                    <div>
                        <div class="itikaf-title">Masjid Al-Jami'</div>
                        <div class="itikaf-sub">40 Hari</div>
                    </div>
                    <div class="itikaf-right">
                        <div class="itikaf-amir">Gus Fring</div>
                        <button class="btn-absen" onclick="showToast('Absen I\'tikaf untuk Masjid Al-Jami\' berhasil.')">Absen</button>
                    </div>
                </article>
                <article class="itikaf-card">
                    <div>
                        <div class="itikaf-title">Masjid Al-Ikhlas</div>
                        <div class="itikaf-sub">3 Hari</div>
                    </div>
                    <div class="itikaf-right">
                        <div class="itikaf-amir">Guz Salamanca</div>
                        <button class="btn-absen" onclick="showToast('Absen I\'tikaf untuk Masjid Al-Ikhlas berhasil.')">Absen</button>
                    </div>
                </article>
            </div>

            <div class="tab-content" id="tab-amir">
                <div class="day-panel">
                    <div class="day-label" id="dayIndicator">Hari ke-1 dari 3</div>
                    <div class="day-actions">
                        <button class="btn-mini" id="btnPrevDay" type="button">Hari Sebelumnya</button>
                        <button class="btn-mini" id="btnNextDay" type="button">Hari Berikutnya</button>
                    </div>
                </div>

                <article class="kegiatan-card">
                    <div>
                        <div class="kegiatan-title">Kultum Subuh</div>
                        <div class="kegiatan-sub">Ba'da Subuh</div>
                        <div class="kegiatan-actions">
                            <button class="btn-mini" type="button" onclick="openAbsenForm('Kultum Subuh')">Buat Absen Hari Ini</button>
                        </div>
                    </div>
                    <div class="kegiatan-progress day-progress">1/3</div>
                </article>
                <article class="kegiatan-card">
                    <div>
                        <div class="kegiatan-title">Tadarusan Pagi</div>
                        <div class="kegiatan-sub">Ba'da Subuh</div>
                        <div class="kegiatan-actions">
                            <button class="btn-mini" type="button" onclick="openAbsenForm('Tadarusan Pagi')">Buat Absen Hari Ini</button>
                        </div>
                    </div>
                    <div class="kegiatan-progress day-progress">1/3</div>
                </article>
                <article class="kegiatan-card">
                    <div>
                        <div class="kegiatan-title">Ceramah Maghrib</div>
                        <div class="kegiatan-sub">Ba'da Subuh</div>
                        <div class="kegiatan-actions">
                            <button class="btn-mini" type="button" onclick="openAbsenForm('Ceramah Maghrib')">Buat Absen Hari Ini</button>
                        </div>
                    </div>
                    <div class="kegiatan-progress day-progress">1/3</div>
                </article>

                <div class="absen-form" id="absenForm">
                    <div class="absen-form-title" id="absenFormTitle">Buat Absen Hari Ini</div>
                    <div class="status-list">
                        <div class="status-item"><span>Ahyar</span><select><option>Sudah Absen</option><option>Belum Absen</option><option>Izin</option></select></div>
                        <div class="status-item"><span>Ahay</span><select><option>Sudah Absen</option><option>Belum Absen</option><option>Izin</option></select></div>
                        <div class="status-item"><span>Ahmad Nazar</span><select><option>Belum Absen</option><option>Sudah Absen</option><option>Izin</option></select></div>
                        <div class="status-item"><span>Ahmad Muzaki</span><select><option>Sudah Absen</option><option>Belum Absen</option><option>Izin</option></select></div>
                        <div class="status-item"><span>Aliando Syarief</span><select><option>Belum Absen</option><option>Sudah Absen</option><option>Izin</option></select></div>
                    </div>
                    <button class="btn-lanjut" type="button" id="btnSimpanAbsen">Simpan Absensi Hari Ini</button>
                </div>
            </div>
        </section>
    </main>

    <div id="toast" class="toast"></div>

    <script>
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toast = document.getElementById('toast');
        const dayIndicator = document.getElementById('dayIndicator');
        const dayProgressEls = document.querySelectorAll('.day-progress');
        const btnPrevDay = document.getElementById('btnPrevDay');
        const btnNextDay = document.getElementById('btnNextDay');
        const absenForm = document.getElementById('absenForm');
        const absenFormTitle = document.getElementById('absenFormTitle');
        const btnSimpanAbsen = document.getElementById('btnSimpanAbsen');
        let currentDay = 1;
        const totalDays = 3;
        let selectedKegiatan = '';

        toggleSidebarBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        document.querySelectorAll('.tab-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach((item) => item.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach((item) => item.classList.remove('active'));

                btn.classList.add('active');
                document.getElementById(`tab-${btn.dataset.tab}`).classList.add('active');
            });
        });

        function renderDayState() {
            dayIndicator.textContent = `Hari ke-${currentDay} dari ${totalDays}`;
            dayProgressEls.forEach((el) => {
                el.textContent = `${currentDay}/${totalDays}`;
            });
            btnPrevDay.disabled = currentDay === 1;
            btnNextDay.disabled = currentDay === totalDays;
            btnPrevDay.style.opacity = currentDay === 1 ? '0.6' : '1';
            btnNextDay.style.opacity = currentDay === totalDays ? '0.6' : '1';
        }

        btnPrevDay.addEventListener('click', function () {
            if (currentDay > 1) {
                currentDay -= 1;
                renderDayState();
            }
        });

        btnNextDay.addEventListener('click', function () {
            if (currentDay < totalDays) {
                currentDay += 1;
                renderDayState();
            }
        });

        function openAbsenForm(namaKegiatan) {
            selectedKegiatan = namaKegiatan;
            absenFormTitle.textContent = `Absensi ${namaKegiatan} - Hari ${currentDay}/${totalDays}`;
            absenForm.classList.add('show');
            absenForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        btnSimpanAbsen.addEventListener('click', function () {
            if (!selectedKegiatan) {
                showToast('Pilih kegiatan dulu untuk membuat absensi.');
                return;
            }
            showToast(`Absensi anggota untuk ${selectedKegiatan} hari ${currentDay}/${totalDays} berhasil disimpan.`);
            absenForm.classList.remove('show');
        });

        function showToast(message) {
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2400);
        }

        renderDayState();
    </script>
</body>
</html>
