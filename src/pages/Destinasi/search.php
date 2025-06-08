<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Post No Bills Colombo ExtraBold:wght@400&display=swap" />
</head>
<body>
    <header class="header">
        <div class="logo">ROUTICA</div>
        <div class="search-bar">
            <form method="GET" action="index.php">
                <input type="text" name="search" placeholder="Cari destinasi impianmu di sini" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                <button type="submit">Search</button>
            </form>
        </div>
        <nav class="nav-links">
            <a href="#">EXPLORE</a>
            <a href="#">ITINERARIES</a>
            <div class="profile-icon">👤</div>
        </nav>
    </header>

    <section class="search-results">
        <h2>Hasil Pencarian</h2>
        <?php
        // Database connection
        $conn = new mysqli("localhost", "root", "", "destinasi_db");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Search query
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : ''; 
        $sql = "SELECT id, name, category, main_image FROM destinasi";
        if ($search) {
            $sql .= " WHERE name LIKE '%$search%' OR category LIKE '%$search%'";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="result-item">';
                echo '<a href="destination.php?id=' . $row['id'] . '">';
                echo '<img src="' . htmlspecialchars($row['main_image']) . '" alt="' . htmlspecialchars($row['name']) . '" />';
                echo '<div>';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['category']) . '</p>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo '<p>Tidak ada hasil ditemukan.</p>';
        }

        $conn->close();
        ?>
    </section>
</body>
</html>