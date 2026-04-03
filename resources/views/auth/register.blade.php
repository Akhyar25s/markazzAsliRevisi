<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Sistem Markaz</title>
    <script async src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f5f0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #1f1f1f;
            font-size: 28px;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            border-bottom: 2px solid #e0e0e0;
        }

        .tab-button {
            flex: 1;
            padding: 10px;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            color: #999;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: all 0.3s;
        }

        .tab-button.active {
            color: #26a35a;
            border-bottom-color: #26a35a;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="tel"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #c0d8c0;
            background: #e8f5e9;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #26a35a;
            background: #f1f8f1;
            box-shadow: 0 0 0 3px rgba(38, 163, 90, 0.1);
        }

        .error {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 10px;
        }

        .btn-primary {
            background: #26a35a;
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            background: #1e8449;
            box-shadow: 0 5px 15px rgba(38, 163, 90, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover:not(:disabled) {
            background: #d0d0d0;
        }

        .face-container {
            text-align: center;
            margin: 20px 0;
        }

        .face-info {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 14px;
            color: #666;
        }

        video {
            width: 100%;
            border-radius: 5px;
            margin: 15px 0;
            max-width: 300px;
        }

        canvas {
            display: none;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #26a35a;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 10px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .link-text {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-top: 20px;
        }

        .link-text a {
            color: #26a35a;
            text-decoration: none;
            font-weight: 600;
        }

        .link-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Registrasi</h1>
            <p>Buat akun baru untuk mengakses sistem</p>
        </div>

        <div class="tabs">
            <button class="tab-button active" data-tab="form">Data Pribadi</button>
            <button class="tab-button" data-tab="face">Scan Wajah</button>
        </div>

        <!-- TAB 1: Form Registrasi -->
        <div id="form-tab" class="tab-content active">
            @if ($errors->any())
                <div class="error" style="background: #ffe6e6; padding: 12px; border-radius: 5px;">
                    <ul style="list-style: none;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="registrationForm" onsubmit="handleFormSubmit(event)">
                @csrf

                <div class="form-group">
                    <label for="nama">Username</label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        value="{{ old('nama') }}"
                        placeholder="Masukkan username Anda"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="no_hp">Nomor HP</label>
                    <input 
                        type="tel" 
                        id="no_hp" 
                        name="no_hp" 
                        value="{{ old('no_hp') }}"
                        placeholder="08xxxxxxxxxx atau +628xxxxxxxxxx"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input 
                        type="text" 
                        id="alamat" 
                        name="alamat" 
                        value="{{ old('alamat') }}"
                        placeholder="Masukkan alamat lengkap Anda"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Minimal 6 karakter"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Ulangi password Anda"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary">Lanjut ke Scan Wajah</button>
            </form>

            <div class="link-text">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </div>
        </div>

        <!-- TAB 2: Scan Wajah -->
        <div id="face-tab" class="tab-content">
            <div class="face-info">
                ✨ Harap pastikan wajah Anda terlihat dengan jelas di hadapan kamera
            </div>

            <div class="face-container">
                <video id="video" width="300" height="300" autoplay></video>
                <canvas id="canvas"></canvas>
            </div>

            <div id="detectionStatus" class="face-info" style="display: none;">
                <span id="statusText"></span>
            </div>

            <button type="button" class="btn btn-primary" id="captureBtn" disabled>
                📷 Ambil Foto Wajah
            </button>

            <button type="button" class="btn btn-secondary" id="retryBtn" style="display: none;">
                🔄 Coba Lagi
            </button>

            <button type="button" class="btn btn-primary" id="submitBtn" style="display: none;">
                ✓ Selesaikan Registrasi
            </button>

            <button type="button" class="btn btn-secondary" onclick="switchTab('form')">
                ← Kembali
            </button>
        </div>
    </div>

    <script>
        let currentTab = 'form';
        let captureButtonClicked = false;
        let faceDescriptor = null;
        let registrationFormData = null; // Store form data here

        // Tab switching
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.addEventListener('click', function() {
                switchTab(this.dataset.tab);
            });
        });

        function switchTab(tabName) {
            currentTab = tabName;
            
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });

            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Find and activate the correct button
            document.querySelectorAll('.tab-button').forEach(btn => {
                if (btn.dataset.tab === tabName) {
                    btn.classList.add('active');
                }
            });

            if (tabName === 'face') {
                setTimeout(() => {
                    initFaceDetection();
                }, 100);
            }
        }

        // Form submission to tab 2 - HANYA VALIDASI DULU
        async function handleFormSubmit(e) {
            e.preventDefault();

            const formData = new FormData(document.getElementById('registrationForm'));

            try {
                console.log('Validating registration form...');
                const response = await fetch('{{ route("register") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                });

                console.log('Response status:', response.status);
                
                const data = await response.json();
                console.log('Response data:', data);

                if (data.success) {
                    // Store form data for later use when face capture is complete
                    registrationFormData = data.form_data;
                    console.log('Validation success, form data stored:', registrationFormData);
                    
                    document.getElementById('form-tab').classList.remove('active');
                    document.getElementById('face-tab').classList.add('active');
                    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                    document.querySelectorAll('.tab-button')[1].classList.add('active');
                    currentTab = 'face';
                    
                    setTimeout(() => {
                        console.log('Initializing face detection...');
                        initFaceDetection();
                    }, 100);
                } else {
                    alert('Validasi gagal: ' + data.message);
                }
            } catch (error) {
                console.error('Form submission error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            }
        }

        // Initialize face detection
        async function initFaceDetection() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const captureBtn = document.getElementById('captureBtn');
            const detectionStatus = document.getElementById('detectionStatus');
            const statusText = document.getElementById('statusText');

            try {
                // Check if faceapi is loaded
                if (typeof faceapi === 'undefined') {
                    throw new Error('Face-api.js belum dimuat. Periksa console browser.');
                }

                console.log('Face-api.js loaded, initializing...', faceapi);
                statusText.textContent = '⏳ Memuat model Face-api...';
                detectionStatus.style.display = 'block';

                // Load models
                const MODEL_URL = 'https://raw.githubusercontent.com/justadudewhohacks/face-api.js/master/weights/';
                
                console.log('Loading models from:', MODEL_URL);

                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                    faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                    faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL),
                ]);

                console.log('Models loaded successfully');
                statusText.textContent = '📷 Mengakses kamera...';

                // Request camera permission
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: { 
                        width: { ideal: 300 },
                        height: { ideal: 300 }
                    }
                });

                console.log('Camera stream obtained');
                video.srcObject = stream;
                
                // Wait for video to load
                video.onloadedmetadata = () => {
                    console.log('Video loaded, canvas size:', video.videoWidth, 'x', video.videoHeight);
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    
                    statusText.textContent = '✅ Kamera siap! Arahkan wajah Anda.';
                    captureBtn.disabled = false;
                    
                    // Start detection
                    startDetection(video, canvas, captureBtn, detectionStatus, statusText, stream);
                };

            } catch (error) {
                console.error('Full Error Object:', error);
                console.error('Error name:', error.name);
                console.error('Error message:', error.message);
                
                detectionStatus.style.display = 'block';
                
                if (error.name === 'NotAllowedError') {
                    statusText.textContent = '❌ Akses kamera ditolak. Izinkan akses kamera di browser settings.';
                } else if (error.name === 'NotFoundError') {
                    statusText.textContent = '❌ Kamera tidak ditemukan. Pastikan kamera terpasang dan driver ter-install.';
                } else if (error.name === 'TypeError') {
                    statusText.textContent = '❌ Face-api.js gagal di-load. Cek koneksi internet atau console browser.';
                } else {
                    statusText.textContent = '❌ Error: ' + error.message;
                }
                statusText.style.color = '#e74c3c';
                captureBtn.disabled = true;
            }
        }

        function startDetection(video, canvas, captureBtn, detectionStatus, statusText, stream) {
            const detectorOptions = new faceapi.TinyFaceDetectorOptions({
                inputSize: 224,
                scoreThreshold: 0.5,
            });

            let isDetecting = false;
            let latestDescriptor = null;

            // Real-time face detection (optimized, no overlapping async calls)
            const detectionInterval = setInterval(async () => {
                if (isDetecting || captureButtonClicked) {
                    return;
                }

                isDetecting = true;
                try {
                    const detection = await faceapi
                        .detectSingleFace(video, detectorOptions)
                        .withFaceLandmarks()
                        .withFaceDescriptor();

                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    if (detection) {
                        latestDescriptor = Array.from(detection.descriptor);
                        const resized = faceapi.resizeResults(detection, {
                            width: video.videoWidth,
                            height: video.videoHeight,
                        });
                        faceapi.draw.drawDetections(canvas, [resized]);

                        detectionStatus.style.display = 'block';
                        statusText.textContent = '✅ Wajah terdeteksi! Klik "Ambil Foto Wajah"';
                        statusText.style.color = '#28a745';
                        captureBtn.disabled = false;
                    } else {
                        latestDescriptor = null;
                        detectionStatus.style.display = 'block';
                        statusText.textContent = '⚠️ Wajah tidak terdeteksi. Posisikan wajah ke depan kamera.';
                        statusText.style.color = '#ffc107';
                        captureBtn.disabled = true;
                    }
                } catch (err) {
                    console.error('Detection error:', err);
                } finally {
                    isDetecting = false;
                }
            }, 500);

            // Capture button click handler
            const handleCapture = async () => {
                if (captureButtonClicked) return;
                captureButtonClicked = true;
                captureBtn.disabled = true;
                statusText.textContent = '⏳ Mengambil data wajah...';
                statusText.style.color = '#333';

                try {
                    let descriptorToSave = latestDescriptor;

                    // Fallback: detect once more if latest descriptor is unavailable
                    if (!descriptorToSave) {
                        const detection = await faceapi
                            .detectSingleFace(video, detectorOptions)
                            .withFaceLandmarks()
                            .withFaceDescriptor();

                        if (detection) {
                            descriptorToSave = Array.from(detection.descriptor);
                        }
                    }

                    if (descriptorToSave) {
                        faceDescriptor = descriptorToSave;

                        // Stop video
                        stream.getTracks().forEach(track => track.stop());
                        video.style.display = 'none';
                        clearInterval(detectionInterval);

                        detectionStatus.innerHTML = '<strong style="color: #28a745;">✅ Wajah berhasil diambil!</strong>';
                        document.getElementById('captureBtn').style.display = 'none';
                        document.getElementById('retryBtn').style.display = 'block';
                        document.getElementById('submitBtn').style.display = 'block';
                    } else {
                        alert('Wajah tidak terdeteksi. Silakan coba lagi dengan pencahayaan lebih terang.');
                        captureButtonClicked = false;
                        captureBtn.disabled = false;
                    }
                } catch (err) {
                    console.error('Capture error:', err);
                    alert('Error saat mengambil foto: ' + err.message);
                    captureButtonClicked = false;
                    captureBtn.disabled = false;
                }
            };

            captureBtn.onclick = handleCapture;
            document.getElementById('retryBtn').onclick = () => {
                location.reload();
            };
            document.getElementById('submitBtn').onclick = submitFaceData;
        }

        // Submit face data + CREATE USER
        async function submitFaceData() {
            if (!faceDescriptor || !registrationFormData) {
                alert('Data tidak lengkap');
                return;
            }

            document.getElementById('submitBtn').disabled = true;

            try {
                console.log('Submitting registration + face data...');
                const response = await fetch('{{ route("store-face-data") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify({
                        ...registrationFormData,
                        face_data: JSON.stringify(faceDescriptor),
                    }),
                });

                console.log('Face data response status:', response.status);
                const data = await response.json();
                console.log('Face data response:', data);

                if (data.success) {
                    alert(data.message);
                    window.location.href = data.redirect;
                } else {
                    alert(data.message);
                    document.getElementById('submitBtn').disabled = false;
                }
            } catch (error) {
                console.error('Face data submission error:', error);
                alert('Gagal menyimpan data wajah: ' + error.message);
                document.getElementById('submitBtn').disabled = false;
            }
        }

        // Check Face-api on page load
        window.addEventListener('load', () => {
            console.log('Page loaded');
            console.log('Face-api available?', typeof faceapi !== 'undefined');
            if (typeof faceapi !== 'undefined') {
                console.log('Face-api nets:', Object.keys(faceapi.nets));
            }
        });
    </script>
</body>
</html>
