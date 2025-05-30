<?php
// test_db.php - Test koneksi database dan tabel
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

echo "<h2>🔍 Database Connection Test</h2>";

try {
    // Test koneksi database
    $database = new Database();
    $pdo = $database->getConnection();
    
    if ($pdo) {
        echo "✅ Database connection: <strong style='color: green;'>SUCCESS</strong><br>";
        
        // Test tabel photos
        try {
            $stmt = $pdo->prepare("DESCRIBE photos");
            $stmt->execute();
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "✅ Table 'photos' structure: <strong style='color: green;'>OK</strong><br>";
            echo "<table border='1' style='margin: 10px 0; border-collapse: collapse;'>";
            echo "<tr><th>Column</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
            foreach ($columns as $col) {
                echo "<tr>";
                echo "<td>{$col['Field']}</td>";
                echo "<td>{$col['Type']}</td>";
                echo "<td>{$col['Null']}</td>";
                echo "<td>{$col['Key']}</td>";
                echo "<td>{$col['Default']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
        } catch (PDOException $e) {
            echo "❌ Table 'photos' error: <strong style='color: red;'>" . $e->getMessage() . "</strong><br>";
            echo "<p>Silakan buat tabel dengan menjalankan SQL berikut:</p>";
            echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
            echo "CREATE TABLE IF NOT EXISTS photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    romantic_quote TEXT,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    file_size INT,
    mime_type VARCHAR(100)
);";
            echo "</pre>";
        }
        
        // Test tabel romantic_quotes
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM romantic_quotes");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            echo "✅ Table 'romantic_quotes': <strong style='color: green;'>OK</strong> ({$result['count']} quotes)<br>";
            
            if ($result['count'] == 0) {
                echo "<p style='color: orange;'>⚠️ Tabel romantic_quotes kosong. Menambahkan quotes default...</p>";
                
                $quotes = [
                    "Kamu adalah alasan mengapa aku percaya pada cinta sejati 💖",
                    "Setiap detik bersamamu terasa seperti keajaiban ✨",
                    "Senyummu adalah cahaya yang menerangi hari-hariku ☀️",
                    "Bersamamu, aku menemukan arti dari kata selamanya 💕",
                    "Foto ini mengingatkanku mengapa aku jatuh cinta padamu 💘"
                ];
                
                $stmt = $pdo->prepare("INSERT INTO romantic_quotes (quote_text) VALUES (?)");
                foreach ($quotes as $quote) {
                    $stmt->execute([$quote]);
                }
                echo "✅ Default quotes berhasil ditambahkan!<br>";
            }
            
        } catch (PDOException $e) {
            echo "❌ Table 'romantic_quotes' error: <strong style='color: red;'>" . $e->getMessage() . "</strong><br>";
        }
        
        // Test folder uploads
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            if (mkdir($uploadDir, 0777, true)) {
                echo "✅ Upload directory created: <strong style='color: green;'>$uploadDir</strong><br>";
            } else {
                echo "❌ Failed to create upload directory: <strong style='color: red;'>$uploadDir</strong><br>";
            }
        } else {
            if (is_writable($uploadDir)) {
                echo "✅ Upload directory: <strong style='color: green;'>OK and writable</strong><br>";
            } else {
                echo "❌ Upload directory: <strong style='color: red;'>NOT writable</strong><br>";
            }
        }
        
        // Test existing photos
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM photos");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "📸 Existing photos in database: <strong>{$result['count']}</strong><br>";
            
            if ($result['count'] > 0) {
                $stmt = $pdo->prepare("SELECT id, filename, original_name, upload_date FROM photos ORDER BY upload_date DESC LIMIT 5");
                $stmt->execute();
                $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo "<h3>Recent Photos:</h3>";
                echo "<table border='1' style='border-collapse: collapse;'>";
                echo "<tr><th>ID</th><th>Filename</th><th>Original Name</th><th>Upload Date</th></tr>";
                foreach ($photos as $photo) {
                    echo "<tr>";
                    echo "<td>{$photo['id']}</td>";
                    echo "<td>{$photo['filename']}</td>";
                    echo "<td>{$photo['original_name']}</td>";
                    echo "<td>{$photo['upload_date']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } catch (PDOException $e) {
            echo "❌ Error fetching photos: " . $e->getMessage() . "<br>";
        }
        
    } else {
        echo "❌ Database connection: <strong style='color: red;'>FAILED</strong><br>";
    }
    
} catch (Exception $e) {
    echo "❌ General error: <strong style='color: red;'>" . $e->getMessage() . "</strong><br>";
}

echo "<hr>";
echo "<h3>📋 Next Steps:</h3>";
echo "<ol>";
echo "<li>Jika ada error di atas, perbaiki terlebih dahulu</li>";
echo "<li>Ganti upload handler di index.html dari 'upload_db.php' ke 'upload_db_debug.php' untuk debugging</li>";
echo "<li>Test upload foto dan check file 'debug.log' untuk detail error</li>";
echo "<li>Pastikan semua file PHP berada di folder yang sama dengan index.html</li>";
echo "</ol>";

echo "<h3>🔧 Quick Fix Commands:</h3>";
echo "<pre style='background: #f0f0f0; padding: 10px;'>";
echo "-- Jika tabel belum ada, jalankan SQL ini di phpMyAdmin:
CREATE DATABASE IF NOT EXISTS galeri_kenangan;
USE galeri_kenangan;

CREATE TABLE IF NOT EXISTS photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    romantic_quote TEXT,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    file_size INT,
    mime_type VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS romantic_quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quote_text TEXT NOT NULL,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";
echo "</pre>";
?>