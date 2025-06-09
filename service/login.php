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

    $sql = "SELECT id, email, password FROM User WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        http_response_code(200);
        echo json_encode(["message" => "Login berhasil."]);
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Email atau kata sandi salah."]);
    }

    $stmt->close();
}

$conn->close();
?>