<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Sistem Markaz</title>
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

        .navbar-title {
            margin-left: 20px;
            font-size: 18px;
            font-weight: 600;
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

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
        }

        /* Search Section */
        .search-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .search-box {
            flex: 1;
            display: flex;
            gap: 10px;
        }

        .search-box input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .search-box input:focus {
            outline: none;
            border-color: #26a35a;
            box-shadow: 0 0 0 3px rgba(38, 163, 90, 0.1);
        }

        .btn-cari {
            background: #26a35a;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-cari:hover {
            background: #1e8449;
            transform: translateY(-2px);
        }

        /* User List */
        .user-list {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .user-item {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: background 0.3s;
        }

        .user-item.expanded {
            background: #f6fbf7;
            padding: 24px;
        }

        .user-item:hover {
            background: #f9f9f9;
        }

        .user-item:last-child {
            border-bottom: none;
        }

        .user-main {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-avatar {
            width: 56px;
            height: 56px;
            background: #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .user-item.expanded .user-avatar {
            width: 88px;
            height: 88px;
            font-size: 42px;
        }

        .user-info-detail {
            flex: 1;
        }

        .user-name {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 0;
        }

        .user-item.expanded .user-name {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .user-detail {
            font-size: 13px;
            color: #666;
            margin-bottom: 3px;
            display: none;
        }

        .user-item.expanded .user-detail {
            display: block;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .user-detail strong {
            color: #333;
        }

        .user-extra {
            display: none;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #c7ddd0;
        }

        .user-item.expanded .user-extra {
            display: block;
        }

        .user-extra .user-detail {
            display: block;
            font-size: 15px;
        }

        .user-actions {
            display: flex;
            gap: 10px;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .btn-role {
            background: #495057;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-role:hover {
            background: #383d41;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 90%;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group select:focus {
            outline: none;
            border-color: #26a35a;
            box-shadow: 0 0 0 3px rgba(38, 163, 90, 0.1);
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }

        .btn-submit {
            background: #26a35a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background: #1e8449;
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

            .user-item {
                flex-direction: column;
                text-align: center;
            }

            .user-info-detail {
                text-align: center;
            }

            .user-actions {
                width: 100%;
                justify-content: center;
            }

            .search-section {
                flex-direction: column;
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
            <div class="navbar-title">Kelola Pengguna</div>
        </div>
        <div class="navbar-right">
            <div class="user-info">
                <div class="user-info-name">{{ Auth::user()->nama }}</div>
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
            <li><a href="{{ route('admin-masjid.kelola-pengguna') }}" class="active">Kelola Pengguna</a></li>
            <li><a href="{{ route('admin-masjid.rekap-laporan') }}">Rekap Laporan</a></li>
            <li><a href="#profil">Profil</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1 class="page-title">Kelola Pengguna</h1>

        <!-- Search Section -->
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Ketik Nama Yang Ingin di Cari...">
                <button class="btn-cari" onclick="searchUsers()">Cari</button>
            </div>
        </div>

        <!-- User List -->
        <div class="user-list" id="userList">
            @forelse($users as $user)
                <div class="user-item {{ $loop->first ? 'expanded' : '' }}" data-user-id="{{ $user->id }}">
                    <div class="user-main">
                        <div class="user-avatar">👤</div>
                        <div class="user-info-detail">
                            <div class="user-name">{{ $user->nama }}</div>
                            <div class="user-detail">No. Hp: <strong>{{ $user->no_hp ?? '-' }}</strong></div>
                            <div class="user-detail">Sandi: <strong>••••••••••</strong></div>
                            <div class="user-extra">
                                <div class="user-detail">Alamat: <strong>{{ $user->alamat ?? '-' }}</strong></div>
                                <div class="user-detail">Role: <strong>{{ ucwords(str_replace('_', ' ', $user->role ?? '-')) }}</strong></div>
                                <div class="user-detail">Tanggal daftar: <strong>{{ $user->created_at ? $user->created_at->format('d-m-Y H:i') : '-' }}</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="user-actions">
                        <button class="btn-delete" onclick="deleteUser('{{ $user->id }}')">🗑</button>
                        <button class="btn-role" onclick="openRoleModal('{{ $user->id }}', @js($user->nama), @js($user->role))">Ubah Role</button>
                        <button class="btn-role btn-toggle-details" onclick="toggleUserDetails('{{ $user->id }}', this)" style="background: #6c757d;">Selengkapnya {{ $loop->first ? '▲' : '▼' }}</button>
                    </div>
                </div>
            @empty
                <div class="user-item" style="justify-content: center;">
                    <div class="user-name">Belum ada data pengguna.</div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Ubah Role -->
    <div class="modal" id="roleModal">
        <div class="modal-content">
            <div class="modal-title">Ubah Role</div>
            <form id="roleForm">
                <div class="form-group">
                    <label for="roleSelect">Pilih Role Baru:</label>
                    <select id="roleSelect" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin_masjid">Admin Masjid</option>
                        <option value="admin_jamaah">Admin Jamaah</option>
                        <option value="anggota_jamaah">Anggota Jamaah</option>
                    </select>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeRoleModal()">Batal</button>
                    <button type="submit" class="btn-submit">Simpan</button>
                </div>
            </form>
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

        function searchUsers() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
            const userItems = document.querySelectorAll('.user-item[data-user-id]');

            userItems.forEach((item) => {
                const nameText = item.querySelector('.user-name')?.textContent.toLowerCase() || '';
                const phoneText = item.querySelector('.user-detail strong')?.textContent.toLowerCase() || '';
                item.style.display = (nameText.includes(searchValue) || phoneText.includes(searchValue)) ? 'flex' : 'none';
            });
        }

        function openRoleModal(userId, userName, currentRole) {
            const modal = document.getElementById('roleModal');
            modal.classList.add('active');
            console.log('Ubah role untuk:', userId, userName, currentRole);
        }

        function closeRoleModal() {
            const modal = document.getElementById('roleModal');
            modal.classList.remove('active');
        }

        function deleteUser(userId) {
            if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                console.log('Menghapus user:', userId);
                // TODO: Implementasi delete
            }
        }

        function toggleUserDetails(userId, buttonEl) {
            const currentItem = document.querySelector(`.user-item[data-user-id="${userId}"]`);
            if (!currentItem) return;

            const isExpanded = currentItem.classList.contains('expanded');

            document.querySelectorAll('.user-item').forEach(item => item.classList.remove('expanded'));
            document.querySelectorAll('.btn-toggle-details').forEach(btn => {
                btn.textContent = 'Selengkapnya ▼';
            });

            if (!isExpanded) {
                currentItem.classList.add('expanded');
                buttonEl.textContent = 'Selengkapnya ▲';
            }
        }

        document.getElementById('roleForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const role = document.getElementById('roleSelect').value;
            console.log('Role baru:', role);
            closeRoleModal();
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('roleModal');
            if (event.target === modal) {
                closeRoleModal();
            }
        });
    </script>
</body>
</html>
