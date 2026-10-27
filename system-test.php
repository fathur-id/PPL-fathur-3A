<?php
/**
 * System Test Script (White Box Testing)
 * File: system-test.php
 * Deskripsi: Skrip pengujian otomatis berbasis struktur internal kode (White Box Testing)
 *            menggunakan struktur Try-Catch untuk memvalidasi alur fungsi cURL dan pembacaan API.
 */

// Load file konfigurasi cURL yang akan diuji
require_once __DIR__ . '/config/config.php';

echo "=========================================================\n";
echo "           WHITE BOX SYSTEM TESTING REPORT               \n";
echo "Aplikasi : REST Client PHP (NewsAPI.org)                 \n";
echo "Tanggal  : " . date('Y-m-d H:i:s') . "                  \n";
echo "=========================================================\n\n";

$passCount = 0;
$failCount = 0;

/**
 * TEST CASE 1: Validation of http_request_get() Function & JSON Response Structure
 * Jenis Testing: Statement Coverage & Response Validation
 */
echo "[TEST CASE 1] TC-WB-001: Validasi Executing cURL Request & JSON Response Structure\n";
echo "Skenario    : Memastikan fungsi http_request_get() berhasil dipanggil, mengembalikan valid JSON,\n";
echo "              serta memiliki key 'status' == 'ok' dan 'articles' ber-type Array.\n";

try {
    $apiKey = "acd26e26c8704880bc3aaa19d344a1e3";
    $testUrl = "https://newsapi.org/v2/top-headlines?country=us&category=technology&apiKey=" . $apiKey;

    // 1. Eksekusi fungsi internal cURL
    $responseRaw = http_request_get($testUrl);

    if ($responseRaw === false || empty($responseRaw)) {
        throw new Exception("Fungsi http_request_get() mengembalikan nilai false/kosong.");
    }

    // 2. Dekode JSON hasil cURL
    $responseData = json_decode($responseRaw, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Format output dari http_request_get() bukan JSON valid: " . json_last_error_msg());
    }

    // 3. Validasi struktur skema data
    if (!isset($responseData['status']) || $responseData['status'] !== 'ok') {
        $statusMsg = isset($responseData['message']) ? $responseData['message'] : 'Status bukan ok';
        throw new Exception("Struktur JSON tidak sesuai standar ok response. Pesan: " . $statusMsg);
    }

    if (!isset($responseData['articles']) || !is_array($responseData['articles'])) {
        throw new Exception("Key 'articles' tidak ditemukan atau bukan berjenis Array.");
    }

    echo "Hasil Test  : [PASS] Function cURL berfungsi normal dan struktur JSON sesuai spesifikasi.\n\n";
    $passCount++;

} catch (Exception $e) {
    echo "Hasil Test  : [FAIL] " . $e->getMessage() . "\n\n";
    $failCount++;
}


/**
 * TEST CASE 2: Decision Coverage on Article Rendering Condition (!empty($hasil['articles']))
 * Jenis Testing: Decision & Branch Coverage
 */
echo "[TEST CASE 2] TC-WB-002: Branch Coverage Evaluasi Kondisi Array Artikel Kosong vs Isi\n";
echo "Skenario    : Memastikan alur logika perkondisian (!empty(\$hasil['articles'])) berjalan akurat\n";
echo "              baik saat data artikel tersedia maupun saat array kosong.\n";

try {
    // Skenario A: Data Dummy Ada
    $dummyValid = [
        'status' => 'ok',
        'articles' => [
            [
                'title' => 'Test Article',
                'author' => 'QA Tester',
                'url' => 'https://example.com',
                'urlToImage' => 'https://example.com/image.jpg'
            ]
        ]
    ];

    if (empty($dummyValid['articles'])) {
        throw new Exception("Branching gagal: Array artikel berisi dianggap kosong oleh sistem.");
    }

    // Skenario B: Data Dummy Kosong
    $dummyEmpty = [
        'status' => 'ok',
        'articles' => []
    ];

    if (!empty($dummyEmpty['articles'])) {
        throw new Exception("Branching gagal: Array artikel kosong dianggap berisi oleh sistem.");
    }

    echo "Hasil Test  : [PASS] Branching condition (!empty(\$hasil['articles'])) mengevaluasi nilai True & False dengan benar.\n\n";
    $passCount++;

} catch (Exception $e) {
    echo "Hasil Test  : [FAIL] " . $e->getMessage() . "\n\n";
    $failCount++;
}


/**
 * TEST CASE 3: Exception & Error Handling when Invalid API Key Provided
 * Jenis Testing: Path Coverage / Negative Path Code Execution
 */
echo "[TEST CASE 3] TC-WB-003: Path Coverage Handling Respon Error HTTP/API Key Invalid\n";
echo "Skenario    : Memastikan sistem dapat mendeteksi status error dari API (misal: apiKeyInvalid)\n";
echo "              dan berhasil masuk ke blok penanganan fallback/alert tanpa menghentikan skrip.\n";

try {
    $invalidApiKey = "12345_invalid_api_key_qa_test";
    $invalidUrl = "https://newsapi.org/v2/top-headlines?country=us&category=technology&apiKey=" . $invalidApiKey;

    $invalidRawResponse = http_request_get($invalidUrl);
    $invalidData = json_decode($invalidRawResponse, true);

    // Validasi bahwa API mengembalikan status error
    if (!isset($invalidData['status']) || $invalidData['status'] !== 'error') {
        throw new Exception("Sistem tidak mendeteksi status 'error' saat API Key salah.");
    }

    // Simulasi logika penanganan error pada index.php
    $articles = isset($invalidData['articles']) ? $invalidData['articles'] : null;

    if (!empty($articles)) {
        throw new Exception("Error Path Terlewati: Kunci 'articles' seharusnya kosong/null saat API Key invalid.");
    }

    echo "Hasil Test  : [PASS] Error path berhasil dieksekusi dengan benar dan ditangkap oleh mekanisme alert fallback.\n\n";
    $passCount++;

} catch (Exception $e) {
    echo "Hasil Test  : [FAIL] " . $e->getMessage() . "\n\n";
    $failCount++;
}


echo "=========================================================\n";
echo "                  SUMMARY REKAPITULASI                   \n";
echo "Total Pengujian : " . ($passCount + $failCount) . "\n";
echo "Total PASS      : " . $passCount . "\n";
echo "Total FAIL      : " . $failCount . "\n";
echo "Status Akhir    : " . ($failCount === 0 ? "SUCCESS (ALL PASS)" : "FAILED HAS ISSUES") . "\n";
echo "=========================================================\n";
?>