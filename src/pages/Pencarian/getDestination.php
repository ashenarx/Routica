<?php
header('Content-Type: application/json');
include '../../../service/database.php';

try {
    $category = isset($_GET['jenis']) ? $_GET['jenis'] : ''; // Menggunakan 'category' sebagai nama kolom
    $lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : '';

    // Query dasar
    $query = "SELECT name, kota, provinsi, main_image FROM destinasi";
    $params = [];
    $types = '';
    $conditions = [];

    // Tambahkan kondisi jika ada filtrasi
    if ($category) {
        $conditions[] = "category = ?"; // Diubah dari 'jenis' ke 'category'
        $params[] = $category;
        $types .= 's';
    }
    if ($lokasi) {
        $conditions[] = "provinsi = ?";
        $params[] = $lokasi;
        $types .= 's';
    }

    // Gabungkan kondisi jika ada
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $query .= " LIMIT 8"; // Batasi hasil

    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    } else {
        // Jika tidak ada parameter, jalankan query tanpa binding
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