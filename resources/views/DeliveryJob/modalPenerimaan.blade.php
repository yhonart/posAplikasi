<div class="row">
    <div class="col-md-12">
        <div class="card card-purple">
            <div class="card-header">
                <h3 class="card-title">Penerimaan Item</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <button id="startCamera" class="btn btn-info rounded-pill">Mulai Kamera</button>
                            <button id="takePhoto" class="btn btn-success rounded-pill" disabled>Ambil Foto</button>
                            <button id="submitPhoto" class="btn btn-success rounded-pill" disabled>Simpan Foto</button>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 20px;">
                    <div class="col-md-12">
                        <video id="cameraFeed" autoplay playsinline></video>
                        <canvas id="photoCanvas"></canvas>
                        <img id="capturedImage" style="display: none; max-width: 100%; margin-top: 20px;">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p id="locationInfo">Mencari lokasi...</p>
                        <p id="statusMessage"></p>
                        <div class="loading" id="loadingSpinner">Mengirim data...</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p>Pastikan untuk memberikan izin akses kamera dan lokasi pada browser Anda.</p>
                        <p>Foto yang diambil akan disimpan dengan informasi lokasi (jika tersedia).</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const cameraFeed = document.getElementById('cameraFeed');
    const photoCanvas = document.getElementById('photoCanvas');
    const capturedImage = document.getElementById('capturedImage');
    const startCameraButton = document.getElementById('startCamera');
    const takePhotoButton = document.getElementById('takePhoto');
    const submitPhotoButton = document.getElementById('submitPhoto');
    const statusMessage = document.getElementById('statusMessage');
    const locationInfo = document.getElementById('locationInfo');
    const loadingSpinner = document.getElementById('loadingSpinner');

    let stream = null;
    let photoData = null; // Untuk menyimpan base64 foto
    let currentLatitude = null;
    let currentLongitude = null;

    async function startCamera() {
        statusMessage.textContent = 'Memulai kamera...';
        try {
            // Hentikan stream sebelumnya jika ada
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }

            stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false });
            cameraFeed.srcObject = stream;
            cameraFeed.style.display = 'block';
            capturedImage.style.display = 'none';
            photoCanvas.style.display = 'none';
            takePhotoButton.disabled = false;
            submitPhotoButton.disabled = true;
            submitPhotoButton.classList.remove('enabled');
            statusMessage.textContent = 'Kamera siap!';
        } catch (err) {
            console.error('Error mengakses kamera:', err);
            statusMessage.textContent = 'Gagal mengakses kamera. Pastikan browser Anda memiliki izin.';
            takePhotoButton.disabled = true;
            submitPhotoButton.disabled = true;
            submitPhotoButton.classList.remove('enabled');
        }
    }

    // --- Fungsi untuk Mengambil Foto ---
    function takePhoto() {
        if (!stream) {
            statusMessage.textContent = 'Kamera belum dimulai.';
            return;
        }

        statusMessage.textContent = 'Mengambil foto...';
        const context = photoCanvas.getContext('2d');

        // Set ukuran canvas sesuai dengan video feed
        photoCanvas.width = cameraFeed.videoWidth;
        photoCanvas.height = cameraFeed.videoHeight;

        context.drawImage(cameraFeed, 0, 0, photoCanvas.width, photoCanvas.height);

        // Convert canvas content to base64 image data
        photoData = photoCanvas.toDataURL('image/jpeg', 0.9); // 0.9 adalah kualitas JPEG

        // Tampilkan hasil foto di img tag
        capturedImage.src = photoData;
        capturedImage.style.display = 'block';
        cameraFeed.style.display = 'none';
        photoCanvas.style.display = 'none'; // Sembunyikan canvas setelah digunakan

        takePhotoButton.disabled = true; // Nonaktifkan tombol ambil foto
        submitPhotoButton.disabled = false; // Aktifkan tombol simpan foto
        submitPhotoButton.classList.add('enabled');

        if (stream) {
            stream.getTracks().forEach(track => track.stop()); // Hentikan stream kamera setelah foto diambil
        }
        statusMessage.textContent = 'Foto berhasil diambil. Sekarang Anda bisa menyimpannya.';
    }

    // --- Fungsi untuk Mengambil Lokasi ---
    function getLocation() {
        if (navigator.geolocation) {
            locationInfo.textContent = 'Mencari lokasi Anda...';
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    currentLatitude = position.coords.latitude;
                    currentLongitude = position.coords.longitude;
                    locationInfo.textContent = `Lokasi: Lintang ${currentLatitude}, Bujur ${currentLongitude}`;
                    console.log('Lokasi:', currentLatitude, currentLongitude);
                },
                (error) => {
                    console.error('Error mengambil lokasi:', error);
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            locationInfo.textContent = "Izin lokasi ditolak. Foto akan disimpan tanpa info lokasi.";
                            break;
                        case error.POSITION_UNAVAILABLE:
                            locationInfo.textContent = "Informasi lokasi tidak tersedia. Foto akan disimpan tanpa info lokasi.";
                            break;
                        case error.TIMEOUT:
                            locationInfo.textContent = "Waktu habis untuk mengambil lokasi. Foto akan disimpan tanpa info lokasi.";
                            break;
                        case error.UNKNOWN_ERROR:
                            locationInfo.textContent = "Terjadi kesalahan yang tidak diketahui saat mengambil lokasi. Foto akan disimpan tanpa info lokasi.";
                            break;
                    }
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            locationInfo.textContent = "Geolocation tidak didukung oleh browser ini. Foto akan disimpan tanpa info lokasi.";
            console.warn("Geolocation is not supported by this browser.");
        }
    }
    // --- Fungsi untuk Mengirim Data via AJAX ---
    async function submitPhoto() {
        if (!photoData) {
            statusMessage.textContent = 'Tidak ada foto yang diambil.';
            return;
        }

        statusMessage.textContent = 'Mengirim foto...';
        loadingSpinner.classList.add('show');
        submitPhotoButton.disabled = true; // Disable tombol submit
        submitPhotoButton.classList.remove('enabled');

        try {
            const response = await $.ajax({
                url: '/photos', // Sesuaikan dengan rute Anda
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    image: photoData,
                    latitude: currentLatitude,
                    longitude: currentLongitude
                },
                dataType: 'json'
            });

            statusMessage.textContent = response.message;
            console.log('Respon server:', response);
            // Reset form setelah sukses
            photoData = null;
            capturedImage.src = '';
            capturedImage.style.display = 'none';
            startCameraButton.disabled = false;
            takePhotoButton.disabled = true;
            submitPhotoButton.disabled = true;
            submitPhotoButton.classList.remove('enabled');
            getLocation(); // Dapatkan lokasi lagi untuk pengambilan berikutnya
        } catch (xhr) {
            const errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Terjadi kesalahan saat mengirim foto.';
            statusMessage.textContent = errorMessage;
            console.error('Error AJAX:', xhr);
            submitPhotoButton.disabled = false; // Aktifkan kembali jika gagal
            submitPhotoButton.classList.add('enabled');
        } finally {
            loadingSpinner.classList.remove('show');
        }
    }

    // --- Event Listeners ---
    startCameraButton.addEventListener('click', startCamera);
    takePhotoButton.addEventListener('click', takePhoto);
    submitPhotoButton.addEventListener('click', submitPhoto);

    // --- Inisialisasi saat halaman dimuat ---
    document.addEventListener('DOMContentLoaded', () => {
        getLocation(); // Langsung minta izin lokasi saat halaman dimuat
    });
</script>