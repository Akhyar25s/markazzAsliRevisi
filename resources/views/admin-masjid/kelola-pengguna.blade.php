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
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
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

        /* Search Box */
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .search-input {
            flex: 1;
            padding: 12px 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            background: white;
        }

        .search-btn {
            padding: 12px 30px;
            background: #555;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .search-btn:hover {
            background: #333;
        }

        /* User List */
        .user-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .user-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            justify-content: space-between;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            flex-shrink: 0;
        }

        .user-info-section {
            flex: 1;
        }

        .user-name {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .user-detail {
            font-size: 13px;
            color: #666;
            margin: 3px 0;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-icon {
            width: 35px;
            height: 35px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s;
            border-radius: 4px;
        }

        .btn-delete {
            color: #999;
        }

        .btn-delete:hover {
            background: #ffe6e6;
            color: #d63031;
        }

        .btn-primary {
            padding: 8px 15px;
            background: #555;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: #333;
        }

        .btn-dropdown {
            padding: 8px 15px;
            background: white;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-dropdown:hover {
            background: #f5f5f5;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 8px;
            text-align: center;
            min-width: 400px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #333;
        }

        .modal-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 30px;
            background: white;
            cursor: pointer;
        }

        .modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn-modal {
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 13px;
        }

        .btn-cancel {
            background: #999;
            color: white;
        }

        .btn-cancel:hover {
            background: #777;
        }

        .btn-save {
            background: #26a35a;
            color: white;
        }

        .btn-save:hover {
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

            .user-card {
                flex-direction: column;
                text-align: center;
            }

            .user-actions {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .modal-content {
                min-width: 90%;
                max-width: 400px;
            }

            .page-title {
                font-size: 22px;
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
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="#kelola-pengguna" class="active">Kelola Pengguna</a></li>
            <li><a href="#rekap-laporan">Rekap Laporan</a></li>
            <li><a href="#profil">Profil</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1 class="page-title">Kelola Pengguna</h1>

        <!-- Search Box -->
        <div class="search-box">
            <input type="text" class="search-input" id="searchInput" placeholder="Ketik Nama Yang Ingin di Cari............">
            <button class="search-btn" id="searchBtn">Cari</button>
        </div>

        <!-- User List -->
        <div class="user-list" id="userList">
            <!-- User items will be generated dynamically or loaded from server -->
            <div class="user-card">
                <div class="user-avatar">👤</div>
                <div class="user-info-section">
                    <div class="user-name">A'syim</div>
                    <div class="user-detail">No. Hp : 083821234567</div>
                    <div class="user-detail">Sandi : Asyimganteng123</div>
                </div>
                <div class="user-actions">
                    <button class="btn-icon btn-delete" title="Hapus">🗑️</button>
                    <button class="btn-primary" onclick="openRoleModal('A\'syim')">Ubah Role</button>
                    <button class="btn-dropdown">Selengkapnya ▼</button>
                </div>
            </div>

            <div class="user-card">
                <div class="user-avatar">👤</div>
                <div class="user-info-section">
                    <div class="user-name">Ahyar</div>
                    <div class="user-detail">No. Hp : 081234567890</div>
                    <div class="user-detail">Sandi : Ahyar123</div>
                </div>
                <div class="user-actions">
                    <button class="btn-icon btn-delete" title="Hapus">🗑️</button>
                    <button class="btn-primary" onclick="openRoleModal('Ahyar')">Ubah Role</button>
                    <button class="btn-dropdown">Selengkapnya ▼</button>
                </div>
            </div>

            <div class="user-card">
                <div class="user-avatar">👤</div>
                <div class="user-info-section">
                    <div class="user-name">Ahmad Muzaki</div>
                    <div class="user-detail">No. Hp : 082345678901</div>
                    <div class="user-detail">Sandi : Ahmad123</div>
                </div>
                <div class="user-actions">
                    <button class="btn-icon btn-delete" title="Hapus">🗑️</button>
                    <button class="btn-primary" onclick="openRoleModal('Ahmad Muzaki')">Ubah Role</button>
                    <button class="btn-dropdown">Selengkapnya ▼</button>
                </div>
            </div>

            <div class="user-card">
                <div class="user-avatar">👤</div>
                <div class="user-info-section">
                    <div class="user-name">Aliando Syarief</div>
                    <div class="user-detail">No. Hp : 083456789012</div>
                    <div class="user-detail">Sandi : Aliando123</div>
                </div>
                <div class="user-actions">
                    <button class="btn-icon btn-delete" title="Hapus">🗑️</button>
                    <button class="btn-primary" onclick="openRoleModal('Aliando Syarief')">Ubah Role</button>
                    <button class="btn-dropdown">Selengkapnya ▼</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Role -->
    <div class="modal" id="roleModal">
        <div class="modal-content">
            <h2 class="modal-title">Ubah Role</h2>
            <select class="modal-select" id="roleSelect">
                <option value="">-- Pilih Role --</option>
                <option value="admin_masjid">Admin Masjid</option>
                <option value="admin_jamaah">Admin Jamaah</option>
                <option value="anggota_jamaah">Anggota Jamaah</option>
            </select>
            <div class="modal-buttons">
                <button class="btn-modal btn-cancel" onclick="closeRoleModal()">Batalkan</button>
                <button class="btn-modal btn-save" onclick="saveRole()">Simpan</button>
            </div>
        </div>
    </div>

    <script>
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        const roleModal = document.getElementById('roleModal');
        let selectedUsername = '';

        toggleSidebarBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        function openRoleModal(username) {
            selectedUsername = username;
            roleModal.classList.add('active');
        }

        function closeRoleModal() {
            roleModal.classList.remove('active');
            selectedUsername = '';
        }

        function saveRole() {
            const role = document.getElementById('roleSelect').value;
            if (role) {
                alert(`Role ${selectedUsername} berhasil diubah menjadi ${role}`);
                closeRoleModal();
            } else {
                alert('Pilih role terlebih dahulu');
            }
        }

        // Close modal when clicking outside
        roleModal.addEventListener('click', function(e) {
            if (e.target === roleModal) {
                closeRoleModal();
            }
        });

        // Search functionality
        document.getElementById('searchBtn').addEventListener('click', function() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const userCards = document.querySelectorAll('.user-card');
            
            userCards.forEach(card => {
                const userName = card.querySelector('.user-name').textContent.toLowerCase();
                if (userName.includes(searchValue)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
