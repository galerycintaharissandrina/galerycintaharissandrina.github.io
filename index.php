<?php
include "config.php";
$qry = $koneksi->query("SELECT * FROM photos");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Kenangan Kita 💕</title>
    <link rel="icon" href="hslogoo.png" type="image/png" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
            background-size: 400% 400%;
            animation: dreamyBackground 15s ease infinite;
            min-height: 100vh;
            overflow-x: hidden;
        }

        @keyframes dreamyBackground {
            0% { background-position: 0% 50%; }
            25% { background-position: 100% 50%; }
            50% { background-position: 100% 100%; }
            75% { background-position: 0% 100%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating Elements */
        .floating-heart {
            position: fixed;
            color: rgba(255, 255, 255, 0.8);
            font-size: 20px;
            animation: floatAround 12s infinite ease-in-out;
            z-index: 1;
            pointer-events: none;
        }

        @keyframes floatAround {
            0%, 100% {
                transform: translateY(0px) translateX(0px) rotate(0deg);
                opacity: 0.3;
            }
            25% {
                transform: translateY(-30px) translateX(20px) rotate(90deg);
                opacity: 0.8;
            }
            50% {
                transform: translateY(-60px) translateX(-10px) rotate(180deg);
                opacity: 1;
            }
            75% {
                transform: translateY(-30px) translateX(-30px) rotate(270deg);
                opacity: 0.8;
            }
        }

        .stars {
            position: fixed;
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            animation: twinkle 3s infinite ease-in-out;
            z-index: 1;
            pointer-events: none;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); }
        }

        /* Header */
        .header {
            text-align: center;
            padding: 50px 20px;
            position: relative;
            z-index: 10;
        }

        .main-title {
            font-size: 3.5rem;
            color: white;
            text-shadow: 3px 3px 10px rgba(0,0,0,0.5);
            margin-bottom: 20px;
            animation: titleGlow 4s infinite ease-in-out;
        }

        @keyframes titleGlow {
            0%, 100% {
                text-shadow: 3px 3px 10px rgba(0,0,0,0.5);
                transform: scale(1);
            }
            50% {
                text-shadow: 0 0 20px rgba(255,255,255,0.8), 3px 3px 10px rgba(0,0,0,0.5);
                transform: scale(1.05);
            }
        }

        .subtitle {
            font-size: 1.3rem;
            color: rgba(255,255,255,0.9);
            font-style: italic;
            animation: fadeInOut 3s infinite ease-in-out;
        }

        @keyframes fadeInOut {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }

        /* Upload Section */
        .upload-section {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            margin: 20px;
            padding: 30px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.2);
            text-align: center;
            animation: slideInUp 1s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .upload-title {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
            overflow: hidden;
            background: linear-gradient(45deg, #ff6b9d, #c44569);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            animation: buttonPulse 2s infinite ease-in-out;
        }

        @keyframes buttonPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .file-input-wrapper:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 40px rgba(255,107,157,0.4);
        }

        .file-input {
            position: absolute;
            left: -9999px;
        }

        .file-input-text {
            font-size: 1.1rem;
            font-weight: bold;
        }
          .submit-btn {
            background: linear-gradient(45deg,rgb(55, 189, 180),rgb(97, 201, 180));
            color: white;
            border: none;
            padding: 15px 35px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin: 10px;
            box-shadow: 0 5px 15px rgba(61, 188, 180, 0.4);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(211, 30, 30, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .submit-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(78, 205, 196, 0.6);
        }

        .submit-btn:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(78, 205, 196, 0.4);
        }
            .upload-section {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        max-width: 500px;
        width: 100%;
        text-align: center;
        margin: 20px auto;
    }

    .upload-title {
        color: white;
        font-size: 28px;
        margin-bottom: 30px;
        font-weight: 600;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        animation: glow 2s ease-in-out infinite alternate;
    }

    @keyframes glow {
        from { text-shadow: 0 2px 10px rgba(255, 255, 255, 0.3); }
        to { text-shadow: 0 2px 20px rgba(255, 255, 255, 0.6); }
    }

    .file-input-wrapper {
        position: relative;
        display: inline-block;
        cursor: pointer;
        margin-bottom: 25px;
        overflow: hidden;
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .file-input-wrapper:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .file-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-input-text {
        display: block;
        background: linear-gradient(45deg, #ff6b9d, #c44569);
        color: white;
        padding: 15px 30px;
        font-size: 18px;
        font-weight: 600;
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .file-input-text::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .file-input-wrapper:hover .file-input-text::before {
        left: 100%;
    }

    .download-all-btn {
        background: linear-gradient(45deg, #a8edea, #fed6e3);
        color: #333;
        border: none;
        padding: 15px 35px;
        font-size: 18px;
        font-weight: 600;
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 10px;
        box-shadow: 0 5px 15px rgba(168, 237, 234, 0.4);
        position: relative;
        overflow: hidden;
    }

    .download-all-btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s;
    }

    .download-all-btn:hover::after {
        transform: translateX(100%);
    }

    .download-all-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(168, 237, 234, 0.6);
    }

    .btn-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
        align-items: center;
    }

    #uploadMessage {
        margin-top: 20px;
        color: white;
        font-weight: bold;
        padding: 10px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    #uploadMessage.show {
        opacity: 1;
        transform: translateY(0);
    }

    .file-selected {
        background: rgba(255, 255, 255, 0.1);
        padding: 10px;
        border-radius: 10px;
        margin: 10px 0;
        color: white;
        font-size: 14px;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .file-selected.show {
        opacity: 1;
        transform: translateY(0);
    }

    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
        margin-right: 10px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .pulse {
        animation: pulse 0.6s ease-in-out;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

        .download-all-btn {
            background: linear-gradient(45deg, #00c851, #007e33);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: bold;
            margin-left: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }

        .download-all-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 40px rgba(0,200,81,0.4);
        }

        /* Photo Gallery */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .photo-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 20px;
            border: 1px solid rgba(255,255,255,0.2);
            text-align: center;
            opacity: 0;
            transform: translateY(50px);
            animation: cardAppear 0.8s ease-out forwards;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .photo-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        @keyframes cardAppear {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .photo-container {
            position: relative;
            margin-bottom: 20px;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .photo {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .photo:hover {
            transform: scale(1.1);
        }

        .photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,107,157,0.3), rgba(196,69,105,0.3));
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 15px;
        }

        .photo-container:hover .photo-overlay {
            opacity: 1;
        }

        .romantic-quote {
            color: white;
            font-size: 1.1rem;
            line-height: 1.6;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
            font-style: italic;
            animation: quoteGlow 4s infinite ease-in-out;
            padding: 15px;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            border-left: 4px solid rgba(255,107,157,0.8);
            margin-bottom: 15px;
        }

        @keyframes quoteGlow {
            0%, 100% {
                text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
            }
            50% {
                text-shadow: 0 0 10px rgba(255,255,255,0.5), 1px 1px 3px rgba(0,0,0,0.7);
            }
        }

        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255,0,0,0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            z-index: 5;
        }

        .delete-btn:hover {
            background: rgba(255,0,0,1);
            transform: scale(1.2);
        }

        .download-btn {
            background: linear-gradient(45deg, #00c851, #007e33);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: bold;
            transition: all 0.3s ease;
            margin: 5px;
        }

        .download-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0,200,81,0.4);
        }

        /* Romantic Messages Floating */
        .floating-message {
            position: fixed;
            color: rgba(255,255,255,0.9);
            font-size: 1rem;
            font-style: italic;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
            animation: floatMessage 15s infinite linear;
            z-index: 1;
            pointer-events: none;
            white-space: nowrap;
        }

        @keyframes floatMessage {
            0% {
                opacity: 0;
                transform: translateX(-200px);
            }
            10%, 90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateX(calc(100vw + 200px));
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-title {
                font-size: 2.5rem;
            }
            .gallery {
                grid-template-columns: 1fr;
                padding: 20px 10px;
            }
            .upload-section {
                margin: 10px;
                padding: 20px;
            }
            .download-all-btn {
                margin-left: 0;
                margin-top: 10px;
                display: block;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-left: 10px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .photo-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="main-title">💕 Galeri Kenangan Kita 💕</h1>
        <p class="subtitle">"Setiap foto menceritakan kisah cinta kita yang indah"</p>
        <h class="main-title">💕 Mohamad Haris & Sandrina Nur Shafa 💕</h>
    </div>
    <div class="upload-section">
    <form action="upload_db.php" method="post" id="uploadForm" enctype="multipart/form-data">
    <label for="photoInput" class="file-input-wrapper">
        <input type="file" name="photos[]" id="photoInput" class="file-input" accept="image/*" multiple>
        <span class="file-input-text">📷 Pilih Foto-foto Kita</span>
    </label><br><br>
    <input type="submit" value="Upload" name="submit">
    </form>
        <div id="fileInfo" class="file-selected"></div>
        
        <div class="btn-container">
            <button type="button" onclick="downloadAllPhotos()" class="download-all-btn">
                💾 Download Semua Foto
            </button>
        </div>
    </form>
    
    <div id="uploadMessage"></div>
</div>
    <div class="gallery" id="photoGallery"></div>
    <audio id="bgMusic" autoplay loop controls style="position:fixed;bottom:10px;left:10px;z-index:999;">
        <source src="Rizky Febian - Hingga Tua Bersama.mp3" type="audio/mpeg">
        Lagu tidak bisa diputar.
    </audio>
    <script>
        // File input handler
        const photoInput = document.getElementById('photoInput');
        const fileInfo = document.getElementById('fileInfo');
        const uploadForm = document.getElementById('uploadForm');
        const uploadMessage = document.getElementById('uploadMessage');
        const fileInputText = document.querySelector('.file-input-text');
        const fileInputWrapper = document.querySelector('.file-input-wrapper');
        const romanticQuotes = [
            "Kamu adalah alasan mengapa aku percaya pada cinta sejati 💖",
            "Setiap detik bersamamu terasa seperti keajaiban ✨",
            "Senyummu adalah cahaya yang menerangi hari-hariku ☀️",
            "Bersamamu, aku menemukan arti dari kata 'selamanya' 💕",
            "Foto ini mengingatkanku mengapa aku jatuh cinta padamu 💘",
            "Kamu adalah jawaban dari semua doa-doaku 🙏",
            "Cinta kita lebih indah dari semua kisah dongeng 📖",
            "Bersamamu, hidup ini terasa seperti mimpi yang indah 🌙",
            "Kamu adalah bintang yang membuat malamku terang ⭐",
            "Setiap kenangan bersamamu adalah harta yang tak ternilai 💎",
            "Kamu adalah alasan mengapa aku percaya pada cinta sejati 💖",
            "Setiap detik bersamamu terasa seperti keajaiban ✨",
            "Dalam foto ini, aku melihat masa depan kita yang indah 🌟",
            "Senyummu adalah cahaya yang menerangi hari-hariku ☀️",
            "Bersamamu, aku menemukan arti dari kata 'selamanya' 💕",
            "Foto ini mengingatkanku mengapa aku jatuh cinta padamu 💘",
            "Kamu adalah jawaban dari semua doa-doaku 🙏",
            "Dalam matamu, aku melihat rumah yang selalu ingin kutuju 🏠",
            "Cinta kita lebih indah dari semua kisah dongeng 📖",
            "Bersamamu, hidup ini terasa seperti mimpi yang indah 🌙",
            "Kamu adalah bintang yang membuat malamku terang ⭐",
            "Setiap kenangan bersamamu adalah harta yang tak ternilai 💎",
            "Dalam pelukanmu, aku menemukan kedamaian sejati 🤗",
            "Kamu adalah melodinya, dan aku adalah liriknya 🎵",
            "Bersama kamu, aku ingin menulis kisah cinta yang abadi 📝",
            "Foto ini adalah bukti bahwa mimpi bisa menjadi kenyataan 🌈",
            "Kamu membuat hatiku berdetak dalam irama cinta 💓",
            "Setiap hari bersamamu adalah hari Valentine bagiku 💐",
            "Dalam senyummu, aku melihat jutaan alasan untuk bahagia 😊",
            "Kamu adalah pusatnya, dan aku adalah orbit yang memutar 🌍",
            "Cinta kita adalah karya seni terindah yang pernah ada 🎨",
            "Bersamamu, aku belajar arti dari kata 'sempurna' 💯",
            "Kamu adalah halaman terindah dalam buku hidupku 📚",
            "Setiap foto bersama adalah kenangan yang akan kukenang selamanya 📸",
            "Dalam matamu, aku melihat refleksi jiwa kembarku 👫"
        ];

        const floatingMessages = [
            "I Love You More Each Day 💕",
            "You Are My Everything 💖",
            "Forever and Always 💍",
            "My Heart Belongs to You 💝",
            "You Make Me Complete 🧩",
            "Together Forever 👫",
            "You Are My Sunshine ☀️",
            "Love You to the Moon and Back 🌙",
            "You Are Perfect 👑",
            "My One True Love 💘"
        ];
        window.onload = function () {
            const request = indexedDB.open('RomanticGalleryDB', 1);
            request.onerror = function (event) {
                console.error('IndexedDB error:', event.target.error);
            };
            request.onsuccess = function (event) {
                db = event.target.result;
                loadPhotosFromIndexedDB();
            };
            request.onupgradeneeded = function (event) {
                db = event.target.result;
                if (!db.objectStoreNames.contains('photos')) {
                    db.createObjectStore('photos', { keyPath: 'id' });
                }
            };
        };
         photoInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files.length > 0) {
                // Update button text and show loading
                fileInputText.innerHTML = '<span class="loading"></span>Mengupload...';
                fileInputWrapper.style.pointerEvents = 'none';
                fileInputWrapper.style.opacity = '0.7';
                
                fileInfo.innerHTML = `📁 ${files.length} foto dipilih - Sedang mengupload...`;
                fileInfo.classList.add('show');
                
                // Simulate upload process
                setTimeout(() => {
                    // Show success message
                    showMessage(`✅ ${files.length} foto berhasil disimpan!`, 'success');
                    
                    // Reset button text
                    fileInputText.innerHTML = '📷 Pilih Foto-foto Kita';
                    fileInputWrapper.style.pointerEvents = 'auto';
                    fileInputWrapper.style.opacity = '1';
                    
                    // Update file info
                    fileInfo.innerHTML = `✅ ${files.length} foto berhasil diupload!`;
                    
                    // In real implementation, you would actually submit the form:
                    // uploadForm.submit();
                    
                    // Reset after success message
                    setTimeout(() => {
                        uploadForm.reset();
                        fileInfo.classList.remove('show');
                    }, 3000);
                }, 2000);
            } else {
                fileInfo.classList.remove('show');
            }
        });
        function showMessage(message, type) {
            uploadMessage.innerHTML = message;
            uploadMessage.className = 'show';
            
            if (type === 'error') {
                uploadMessage.style.background = 'rgba(255, 107, 107, 0.2)';
                uploadMessage.style.borderLeft = '4px solid #ff6b6b';
            } else {
                uploadMessage.style.background = 'rgba(78, 205, 196, 0.2)';
                uploadMessage.style.borderLeft = '4px solid #4ecdc4';
            }
            
            setTimeout(() => {
                uploadMessage.classList.remove('show');
            }, 4000);
        }
        function savePhotoToIndexedDB(photo) {
            const tx = db.transaction('photos', 'readwrite');
            const store = tx.objectStore('photos');
            store.put(photo);
        }
        function deletePhotoFromIndexedDB(photoId) {
            const tx = db.transaction('photos', 'readwrite');
            const store = tx.objectStore('photos');
            store.delete(Number(photoId));
        }
        function loadPhotosFromIndexedDB() {
            const tx = db.transaction('photos', 'readonly');
            const store = tx.objectStore('photos');
            const request = store.getAll();
            request.onsuccess = function (event) {
                const photos = event.target.result;
                photos.forEach(p => createPhotoCardFromData(p.src, p.quote, p.id));
            };
        }
        function createPhotoCardFromData(imageSrc, quote, id) {
            const gallery = document.getElementById('photoGallery');
            if (gallery.querySelector(`img[src="${imageSrc}"]`)) return;
            const div = document.createElement('div');
            div.className = 'photo-card';
            div.setAttribute('data-photo-id', id);
            div.innerHTML = `
                <button class="delete-btn" onclick="deletePhoto(this)">×</button>
                <div class="photo-container">
                    <img src="${imageSrc}" class="photo">
                    <div class="photo-overlay"></div>
                </div>
                <div class="romantic-quote">${quote}</div>
                <div class="photo-actions">
                    <button class="download-btn" onclick="downloadSinglePhoto(this)">💾 Download Foto</button>
                </div>
            `;
            gallery.appendChild(div);
        }
        function createPhotoCard(imageSrc) {
            const id = Date.now() + Math.random();
            const quote = romanticQuotes[Math.floor(Math.random() * romanticQuotes.length)];
            createPhotoCardFromData(imageSrc, quote, id);
            savePhotoToIndexedDB({ id, src: imageSrc, quote });
        }
        // Create floating elements
        function createFloatingHearts() {
            const heart = document.createElement('div');
            heart.className = 'floating-heart';
            heart.innerHTML = ['💖', '💕', '💝', '💘', '💗'][Math.floor(Math.random() * 5)];
            heart.style.left = Math.random() * 100 + 'vw';
            heart.style.top = Math.random() * 100 + 'vh';
            heart.style.animationDelay = Math.random() * 5 + 's';
            heart.style.animationDuration = (Math.random() * 8 + 8) + 's';
            document.body.appendChild(heart);
            
            setTimeout(() => heart.remove(), 15000);
        }

        function createStars() {
            const star = document.createElement('div');
            star.className = 'stars';
            star.innerHTML = '✨';
            star.style.left = Math.random() * 100 + 'vw';
            star.style.top = Math.random() * 100 + 'vh';
            star.style.animationDelay = Math.random() * 3 + 's';
            document.body.appendChild(star);
            
            setTimeout(() => star.remove(), 6000);
        }

        function createFloatingMessage() {
            const message = document.createElement('div');
            message.className = 'floating-message';
            message.innerHTML = floatingMessages[Math.floor(Math.random() * floatingMessages.length)];
            message.style.top = Math.random() * 80 + 10 + 'vh';
            message.style.animationDelay = Math.random() * 3 + 's';
            message.style.animationDuration = (Math.random() * 5 + 15) + 's';
            document.body.appendChild(message);
            
            setTimeout(() => message.remove(), 20000);
        }
        document.getElementById('photoInput').addEventListener('change', e => {
            Array.from(e.target.files).forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = e => createPhotoCard(e.target.result);
                reader.readAsDataURL(file);
            });
        });
        function deletePhoto(btn) {
            const card = btn.closest('.photo-card');
            const photoId = card.getAttribute('data-photo-id');
            card.remove();
            deletePhotoFromIndexedDB(photoId);
        }
        function downloadSinglePhoto(btn) {
            const card = btn.closest('.photo-card');
            const img = card.querySelector('img');
            const id = card.getAttribute('data-photo-id');
            const link = document.createElement('a');
            link.href = img.src;
            link.download = `Kenangan_${id}.jpg`;
            link.click();
        }
        function downloadAllPhotos() {
            document.querySelectorAll('.photo-card').forEach((card, i) => {
                setTimeout(() => {
                    const img = card.querySelector('img');
                    const id = card.getAttribute('data-photo-id');
                    const link = document.createElement('a');
                    link.href = img.src;
                    link.download = `Kenangan_${id}.jpg`;
                    link.click();
                }, i * 300);
            });
        }
                // Initial effects
        setTimeout(() => {
            for (let i = 0; i < 15; i++) {
                setTimeout(() => createFloatingHearts(), i * 200);
                setTimeout(() => createStars(), i * 150);
            }
        }, 1000);

        // Initialize animations
        setInterval(createFloatingHearts, 2000);
        setInterval(createStars, 1500);
        setInterval(createFloatingMessage, 4000);

        // Add some initial floating messages
        setTimeout(() => {
            for (let i = 0; i < 3; i++) {
                setTimeout(() => createFloatingMessage(), i * 2000);
            }
        }, 2000);
         // Add some interactive effects
        document.querySelectorAll('.download-all-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add pulse animation to file input when hovered
        fileInputWrapper.addEventListener('mouseenter', function() {
            this.classList.add('pulse');
            setTimeout(() => {
                this.classList.remove('pulse');
            }, 600);
        });
    </script>
</body>
</html>