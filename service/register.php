<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(["message" => "Email dan kata sandi harus diisi."]);
        exit;
    }

    $sql = "SELECT id FROM User WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        http_response_code(400);
        echo json_encode(["message" => "Email sudah terdaftar."]);
        exit;
    }

    $sql = "INSERT INTO user (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(["message" => "Registrasi berhasil."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Gagal menyimpan data."]);
    }

    $stmt->close();
}

$conn->close();
?>