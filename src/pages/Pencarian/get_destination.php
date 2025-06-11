<?php
header('Content-Type: application/json');
include '../../../service/database.php';

try {
    $stmt = $conn->prepare("SELECT name, kota, provinsi, main_image FROM destinasi LIMIT 8");
    $stmt->execute();
    $result = $stmt->get_result();
    $destinations = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($destinations);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error fetching data: ' . $e->getMessage()]);
}
$conn->close();
?>