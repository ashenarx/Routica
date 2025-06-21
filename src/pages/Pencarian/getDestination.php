<?php
header('Content-Type: application/json');
include '../../../service/database.php';

try {
    $category = isset($_GET['jenis']) ? $_GET['jenis'] : ''; 
    $lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : '';

    $query = "SELECT name, kota, provinsi, main_image FROM destinasi";
    $params = [];
    $types = '';
    $conditions = [];

    if ($category) {
        $conditions[] = "category = ?";
        $params[] = $category;
        $types .= 's';
    }
    if ($lokasi) {
        $conditions[] = "provinsi = ?";
        $params[] = $lokasi;
        $types .= 's';
    }

    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $query .= " LIMIT 8";

    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    } else {
        $stmt = $conn->prepare($query);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $destinations = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($destinations);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error fetching data: ' . $e->getMessage()]);
}
$conn->close();
?>