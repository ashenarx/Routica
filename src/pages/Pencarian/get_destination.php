<?php
// --- Tambahkan ini untuk debugging ekstra, HANYA SAAT DEVELOPMENT ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ------------------------------------------------------------------

header('Content-Type: application/json');
include '../../../service/database.php'; // <--- Periksa file ini

try {
    $stmt = $conn->prepare("SELECT name, kota, provinsi, main_image FROM destinasi LIMIT 8");
    $stmt->execute();
    $result = $stmt->get_result();
    $destinations = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($destinations);
} catch (Exception $e) {
    // --- Pastikan error di sini juga JSON ---
    echo json_encode(['error' => 'Error fetching data: ' . $e->getMessage()]);
}
$conn->close();
?>