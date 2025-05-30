<?php
// upload_db_debug.php - Debug version dengan logging detail
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
require_once 'config.php';

// Log function untuk debugging
function debugLog($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'debug.log');
}

debugLog("=== UPLOAD DEBUG START ===");
debugLog("REQUEST METHOD: " . $_SERVER['REQUEST_METHOD']);
debugLog("FILES received: " . print_r($_FILES, true));
debugLog("POST data: " . print_r($_POST, true));

// Buat folder uploads jika belum ada
$uploadDir = 'uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
    debugLog("Created uploads directory: " . $uploadDir);
}

$response = array();

try {
    // Test koneksi database
    $database = new Database();
    $pdo = $database->getConnection();
    
    if (!$pdo) {
        throw new Exception("Koneksi database gagal");
    }
    debugLog("Database connection: SUCCESS");

    // Cek apakah ada file yang diupload
    if (!isset($_FILES['photos'])) {
        debugLog("ERROR: No 'photos' in FILES array");
        debugLog("Available FILES keys: " . implode(', ', array_keys($_FILES)));
        throw new Exception("Tidak ada file 'photos' yang diterima");
    }

    $files = $_FILES['photos'];
    debugLog("Photos array structure: " . print_r($files, true));

    // Handle both single and multiple file uploads
    $fileCount = 0;
    if (is_array($files['name'])) {
        $fileCount = count($files['name']);
        debugLog("Multiple files detected: " . $fileCount);
    } else {
        $fileCount = 1;
        debugLog("Single file detected");
        // Convert single file to array format
        $files = array(
            'name' => array($files['name']),
            'type' => array($files['type']),
            'tmp_name' => array($files['tmp_name']),
            'error' => array($files['error']),
            'size' => array($files['size'])
        );
    }

    if ($fileCount == 0 || empty($files['name'][0])) {
        throw new Exception("Tidak ada file yang dipilih");
    }

    $uploadedPhotos = array();
    
    // Loop untuk multiple file upload
    for ($i = 0; $i < $fileCount; $i++) {
        debugLog("Processing file $i: " . $files['name'][$i]);
        
        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            debugLog("File $i upload error: " . $files['error'][$i]);
            continue;
        }
        
        $fileData = array(
            'name' => $files['name'][$i],
            'type' => $files['type'][$i],
            'tmp_name' => $files['tmp_name'][$i],
            'error' => $files['error'][$i],
            'size' => $files['size'][$i]
        );
        
        debugLog("File $i data: " . print_r($fileData, true));
        
        // Validasi file
        $validation = validateImageFile($fileData);
        if ($validation !== true) {
            debugLog("File $i validation failed: " . $validation);
            continue;
        }
        
        debugLog("File $i validation: PASSED");
        
        // Generate nama file unik
        $uniqueFileName = generateUniqueFileName($fileData['name']);
        $filePath = $uploadDir . $uniqueFileName;
        
        debugLog("Moving file from " . $fileData['tmp_name'] . " to " . $filePath);
        
        // Pindahkan file ke folder uploads
        if (move_uploaded_file($fileData['tmp_name'], $filePath)) {
            debugLog("File moved successfully: " . $filePath);
            
            // Get random romantic quote
            $romanticQuote = getRandomRomanticQuote($pdo);
            debugLog("Quote selected: " . $romanticQuote);
            
            // Simpan data ke database
            $stmt = $pdo->prepare("
                INSERT INTO photos (filename, original_name, file_path, romantic_quote, file_size, mime_type) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            $dbResult = $stmt->execute([
                $uniqueFileName,
                $fileData['name'],
                $filePath,
                $romanticQuote,
                $fileData['size'],
                $fileData['type']
            ]);
            
            if ($dbResult) {
                $photoId = $pdo->lastInsertId();
                debugLog("Database insert SUCCESS. ID: " . $photoId);
                
                $uploadedPhotos[] = array(
                    'id' => $photoId,
                    'filename' => $uniqueFileName,
                    'originalName' => $fileData['name'],
                    'path' => $filePath,
                    'quote' => $romanticQuote,
                    'uploadDate' => date('Y-m-d H:i:s')
                );
            } else {
                debugLog("Database insert FAILED");
                debugLog("SQL Error: " . print_r($stmt->errorInfo(), true));
            }
        } else {
            debugLog("Failed to move uploaded file");
        }
    }
    
    debugLog("Total uploaded photos: " . count($uploadedPhotos));
    
    if (empty($uploadedPhotos)) {
        throw new Exception("Tidak ada foto yang berhasil diupload. Check debug.log untuk detail.");
    }
    
    $response['success'] = true;
    $response['message'] = count($uploadedPhotos) . " foto berhasil diupload! 💕";
    $response['photos'] = $uploadedPhotos;
    $response['debug'] = "Check debug.log for detailed information";
    
} catch (Exception $e) {
    debugLog("EXCEPTION: " . $e->getMessage());
    debugLog("Stack trace: " . $e->getTraceAsString());
    
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    $response['debug_message'] = "Check debug.log file for detailed error information";
}

debugLog("Response: " . json_encode($response));
debugLog("=== UPLOAD DEBUG END ===");

echo json_encode($response);
?>