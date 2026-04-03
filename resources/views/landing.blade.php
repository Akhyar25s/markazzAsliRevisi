<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Markaz - Manajemen Kegiatan & Absensi Digital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            background: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: 700;
            color: #26a35a;
            text-decoration: none;
        }

        .navbar-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #26a35a;
            color: white;
        }

        .btn-primary:hover {
            background: #1e8449;
            transform: translateY(-2px);
        }

        .btn-outline {
            background: white;
            color: #26a35a;
            border: 2px solid #26a35a;
        }

        .btn-outline:hover {
            background: #26a35a;
            color: white;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #f0f5f0 0%, #e8f5e9 100%);
            padding: 80px 20px;
            text-align: center;
            min-height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hero h1 {
            font-size: 48px;
            color: #1f1f1f;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
            max-width: 600px;
        }

        .hero-cta {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Section Styles */
        .section {
            padding: 80px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 36px;
            color: #1f1f1f;
            text-align: center;
            margin-bottom: 50px;
            font-weight: 700;
        }

        /* Visi Misi Section */
        .vision-mission {
            background: white;
        }

        .vision-mission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 40px;
        }

        .vm-card {
            background: #f9fef9;
            padding: 30px;
            border-radius: 10px;
            border-left: 5px solid #26a35a;
            transition: all 0.3s;
        }

        .vm-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(38, 163, 90, 0.15);
        }

        .vm-card h3 {
            color: #26a35a;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .vm-card p {
            color: #666;
            line-height: 1.8;
        }

        /* Video Section */
        .video-section {
            background: #f0f5f0;
        }

        .video-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .video-placeholder {
            width: 100%;
            aspect-ratio: 16 / 9;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #26a35a;
        }

        .video-placeholder-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }

        .video-content {
            padding: 20px;
            text-align: center;
            background: white;
        }

        .video-content h4 {
            color: #1f1f1f;
            margin-bottom: 10px;
        }

        .video-content p {
            color: #666;
            font-size: 14px;
        }

        /* CTA Section */
        .cta-section {
            background: #26a35a;
            color: white;
            text-align: center;
            padding: 60px 20px;
        }

        .cta-section h2 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .cta-section p {
            font-size: 16px;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-white {
            background: white;
            color: #26a35a;
        }

        .btn-white:hover {
            background: #f0f5f0;
        }

        /* Footer */
        .footer {
            background: #1f1f1f;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
            text-align: left;
        }

        .footer-section h4 {
            margin-bottom: 15px;
            color: #26a35a;
        }

        .footer-section p, .footer-section a {
            color: #ccc;
            text-decoration: none;
            font-size: 14px;
            line-height: 1.8;
        }

        .footer-section a:hover {
            color: #26a35a;
        }

        .footer-bottom {
            border-top: 1px solid #333;
            padding-top: 20px;
            font-size: 14px;
            color: #999;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 32px;
            }

            .hero p {
                font-size: 16px;
            }

            .section-title {
                font-size: 28px;
            }

            .navbar-links {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .navbar {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="navbar-brand">📱 Sistem Markaz</a>
        <div class="navbar-links">
            <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Manajemen Kegiatan & Absensi Digital</h1>
        <p>Sistem terintegrasi untuk mengelola kehadiran, itikaf, dan aktivitas jamaah dengan teknologi modern dan akurat</p>
        <div class="hero-cta">
            <a href="{{ route('register') }}" class="btn btn-primary">Mulai Sekarang</a>
            <a href="#visi-misi" class="btn btn-outline">Pelajari Lebih Lanjut</a>
        </div>
    </section>

    <!-- Visi Misi Section -->
    <section id="visi-misi" class="section vision-mission">
        <h2 class="section-title">Visi & Misi</h2>
        
        <div class="vision-mission-grid">
            <!-- Visi -->
            <div class="vm-card">
                <h3>🎯 Visi</h3>
                <p>Menjadi platform digital terpercaya yang mendukung pengelolaan kegiatan keagamaan dengan efisien, transparan, dan inovatif untuk meningkatkan partisipasi dan kohesivitas jamaah.</p>
            </div>

            <!-- Misi 1 -->
            <div class="vm-card">
                <h3>✓ Misi 1</h3>
                <p>Menyediakan sistem absensi yang akurat dan terintegrasi untuk mencatat kehadiran jamaah dalam berbagai kegiatan keagamaan dengan mudah dan real-time.</p>
            </div>

            <!-- Misi 2 -->
            <div class="vm-card">
                <h3>✓ Misi 2</h3>
                <p>Memfasilitasi pengelolaan program itikaf, jadwal kegiatan, dan komunikasi yang efektif antara pengurus markaz dan jamaah untuk hasil yang optimal.</p>
            </div>

            <!-- Misi 3 -->
            <div class="vm-card">
                <h3>✓ Misi 3</h3>
                <p>Menghadirkan analitik dan laporan komprehensif yang membantu dalam evaluasi keaktifan jamaah dan pengambilan keputusan strategis untuk pengembangan markaz.</p>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="section video-section">
        <h2 class="section-title">Kenali Markaz Kami</h2>
        
        <div class="video-container">
            <div class="video-placeholder">
                <div class="video-placeholder-icon">🎬</div>
                <p>Embed video di sini</p>
            </div>
            <div class="video-content">
                <h4>Pengenalan Markaz & Ceramah</h4>
                <p>Tonton video untuk mengenal lebih jauh tentang markaz, program-program kami, dan testimoni jamaah yang telah merasakan manfaatnya.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Bergabunglah Sekarang</h2>
        <p>Daftar akun untuk mengakses semua fitur manajemen kegiatan dan absensi digital kami</p>
        <div class="cta-buttons">
            <a href="{{ route('register') }}" class="btn btn-white">Daftar Sekarang</a>
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-section">
                    <h4>Tentang Kami</h4>
                    <p>Sistem Markaz adalah platform digital yang dirancang untuk memudahkan manajemen kegiatan keagamaan dan absensi jamaah secara terintegrasi dan modern.</p>
                </div>

                <div class="footer-section">
                    <h4>Fitur Utama</h4>
                    <p><a href="#">Absensi Kegiatan</a></p>
                    <p><a href="#">Absensi Itikaf</a></p>
                    <p><a href="#">Jadwal Kegiatan</a></p>
                    <p><a href="#">Laporan & Analitik</a></p>
                </div>

                <div class="footer-section">
                    <h4>Kontak</h4>
                    <p>📧 Email: info@markaz.id</p>
                    <p>📱 WhatsApp: +62 8XX XXXX XXXX</p>
                    <p>📍 Alamat: Jl. Al-Falah No. XX</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 Sistem Markaz. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
