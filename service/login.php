<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validasi input
    if (empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(["message" => "Email dan kata sandi harus diisi."]);
        exit;
    }

    // Cek email di database
    $sql = "SELECT id, email, password FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi kata sandi
        if (password_verify($password, $user['password'])) {
            // Mulai sesi
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            http_response_code(200);
            echo json_encode(["message" => "Login berhasil."]);
        } else {
            http_response_code(401);
            echo json_encode(["message" => "Kata sandi salah."]);
        }
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Email tidak ditemukan."]);
    }

    $stmt->close();
}

$conn->close();
?>