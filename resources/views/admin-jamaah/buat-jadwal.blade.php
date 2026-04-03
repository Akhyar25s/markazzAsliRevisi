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

        .field small {
            display: block;
            margin-top: 6px;
            color: #6a746d;
            font-size: 12px;
        }

        .member-section {
            margin-top: 20px;
            border: 1px solid #e7ece8;
            border-radius: 10px;
            padding: 16px;
            background: #fcfffc;
        }

        .member-title {
            font-size: 15px;
            font-weight: 700;
            color: #1f3c2c;
            margin-bottom: 12px;
        }

        .member-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            max-height: 220px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .member-item {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #e8eeea;
            border-radius: 8px;
            padding: 10px;
            background: #fff;
        }

        .member-item input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #26a35a;
            flex: 0 0 auto;
        }

        .member-meta {
            min-width: 0;
        }

        .member-name {
            font-size: 14px;
            font-weight: 600;
            color: #20392c;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .member-email {
            font-size: 12px;
            color: #6d7870;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .map-wrap {
            margin-top: 18px;
        }

        .map-frame {
            width: 100%;
            height: 260px;
            border: 1px solid #e1e7e2;
            border-radius: 10px;
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

        .save-btn:disabled {
            background: #a6cfb6;
            cursor: not-allowed;
        }

        .helper {
            margin-top: 10px;
            text-align: center;
            color: #5e695f;
            font-size: 13px;
        }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .form-grid { grid-template-columns: 1fr; }
            .member-grid { grid-template-columns: 1fr; }
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
            <form id="jadwalForm">
                <div class="form-grid">
                    <div class="field">
                        <label>Tanggal</label>
                        <input type="date" id="tanggal" required>
                    </div>
                    <div class="field">
                        <label>Masjid</label>
                        <input type="text" id="masjid" placeholder="Nama masjid" required>
                    </div>
                    <div class="field">
                        <label>Amir</label>
                        <select id="amir" required disabled>
                            <option value="">Pilih amir dari anggota terpilih</option>
                        </select>
                        <small>Amir dipilih dari anggota yang dicentang.</small>
                    </div>
                    <div class="field">
                        <label>Total Hari</label>
                        <select id="totalHari" required>
                            <option value="">Pilih durasi</option>
                            <option value="3">3 Hari</option>
                            <option value="10">10 Hari</option>
                            <option value="30">30 Hari</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Lokasi I'tikaf (Alamat/Nama Tempat)</label>
                        <input type="text" id="lokasiInput" placeholder="Contoh: Masjid Al-Ihsan, Bandung" required>
                        <small>Lokasi akan otomatis dipreview di Google Maps.</small>
                    </div>
                </div>

                <section class="member-section">
                    <div class="member-title">Pilih Anggota I'tikaf</div>
                    <div class="member-grid" id="memberGrid">
                        @forelse($anggota as $user)
                            <label class="member-item">
                                <input
                                    type="checkbox"
                                    class="member-checkbox"
                                    value="{{ $user->id }}"
                                    data-name="{{ $user->nama }}"
                                    data-phone="{{ $user->no_hp }}"
                                >
                                <span class="member-meta">
                                    <span class="member-name">{{ $user->nama }}</span>
                                    <span class="member-email">{{ $user->no_hp }}</span>
                                </span>
                            </label>
                        @empty
                            <div>Tidak ada data anggota jamaah.</div>
                        @endforelse
                    </div>
                </section>

                <div class="map-wrap">
                    <iframe
                        id="mapPreview"
                        class="map-frame"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://maps.google.com/maps?q=Masjid%20Al%20Ihsan&t=&z=14&ie=UTF8&iwloc=&output=embed"
                    ></iframe>
                </div>

                <div class="form-actions">
                    <button type="submit" id="saveBtn" class="save-btn">Simpan Jadwal</button>
                </div>
                <div class="helper" id="helperText">Pilih minimal 2 anggota untuk membuat kelompok i'tikaf.</div>
            </form>
        </div>
    </main>

    <script>
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const memberCheckboxes = document.querySelectorAll('.member-checkbox');
        const amirSelect = document.getElementById('amir');
        const lokasiInput = document.getElementById('lokasiInput');
        const mapPreview = document.getElementById('mapPreview');
        const jadwalForm = document.getElementById('jadwalForm');
        const helperText = document.getElementById('helperText');

        toggleSidebarBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        function getSelectedMembers() {
            return Array.from(memberCheckboxes)
                .filter((checkbox) => checkbox.checked)
                .map((checkbox) => ({
                    id: checkbox.value,
                    name: checkbox.dataset.name,
                    phone: checkbox.dataset.phone,
                }));
        }

        function updateAmirOptions() {
            const selectedMembers = getSelectedMembers();
            amirSelect.innerHTML = '<option value="">Pilih amir dari anggota terpilih</option>';

            selectedMembers.forEach((member) => {
                const option = document.createElement('option');
                option.value = member.name;
                option.textContent = member.name;
                amirSelect.appendChild(option);
            });

            amirSelect.disabled = selectedMembers.length === 0;

            if (selectedMembers.length < 2) {
                helperText.textContent = 'Pilih minimal 2 anggota untuk membuat kelompok i\'tikaf.';
            } else {
                helperText.textContent = `Anggota terpilih: ${selectedMembers.length} orang.`;
            }
        }

        function buildEmbedUrl(query) {
            const encoded = encodeURIComponent(query);
            return `https://maps.google.com/maps?q=${encoded}&t=&z=14&ie=UTF8&iwloc=&output=embed`;
        }

        function updateMapPreview() {
            const lokasi = lokasiInput.value.trim();
            if (!lokasi) {
                return;
            }

            mapPreview.src = buildEmbedUrl(lokasi);
        }

        memberCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', updateAmirOptions);
        });

        lokasiInput.addEventListener('change', updateMapPreview);
        lokasiInput.addEventListener('blur', updateMapPreview);

        jadwalForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const selectedMembers = getSelectedMembers();
            if (selectedMembers.length < 2) {
                alert('Pilih minimal 2 anggota untuk membuat kelompok i\'tikaf.');
                return;
            }

            if (!amirSelect.value) {
                alert('Pilih amir i\'tikaf dari anggota yang sudah dipilih.');
                return;
            }

            const totalHariValue = document.getElementById('totalHari').value;
            const jadwal = {
                tanggal: document.getElementById('tanggal').value,
                masjid: document.getElementById('masjid').value.trim(),
                amir: amirSelect.value,
                totalHari: Number(totalHariValue),
                lokasiText: lokasiInput.value.trim(),
                anggota: selectedMembers,
                createdAt: new Date().toISOString(),
            };

            const existing = JSON.parse(localStorage.getItem('itikafSchedules') || '[]');
            existing.unshift(jadwal);
            localStorage.setItem('itikafSchedules', JSON.stringify(existing));

            window.location.href = "{{ route('admin-jamaah.kelompok-itikaf') }}";
        });

        updateAmirOptions();
    </script>
</body>
</html>
