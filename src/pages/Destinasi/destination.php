<!-- src/pages/Destinasi/destination.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" />
    <link href="https://fonts.googleapis.com/css2?family=Stick+No+Bills:wght@200..800&display=swap" rel="stylesheet" />
</head>
<body>
    <header class="header">
        <div class="logo">ROUTICA</div>
        <div class="search-bar">
            <form method="GET" action="../index.php">
                <input type="text" name="search" placeholder="Cari destinasi impianmu di sini" />
                <button type="submit">Search</button>
            </form>
        </div>
        <nav class="nav-links">
            <a href="#">EXPLORE</a>
            <a href="#">ITINERARIES</a>
            <div class="profile-icon">👤</div>
        </nav>
    </header>

    <section class="destination-detail">
        <?php
        // Database connection
        $conn = new mysqli("localhost", "root", "", "destinasi_db");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get destination ID from URL
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || (int)$_GET['id'] <= 0) {
            echo '<p>Error: ID destinasi tidak valid. Silakan kembali ke <a href="../index.php">halaman pencarian</a>.</p>';
        } else {
            $id = (int)$_GET['id'];
            $sql = "SELECT * FROM destinasi WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $activities = explode('|', $row['activities']);
                $important_info = explode('|', $row['important_info']);
            ?>
                <h2>Jelajahi</h2>
                <h1><?php echo htmlspecialchars($row['name']); ?></h1>
                <span class="category-badge"><?php echo htmlspecialchars($row['category']); ?></span>

                <div class="content-wrapper">
                    <div class="destination-content">
                        <div class="destination-images">
                            <img src="<?php echo htmlspecialchars($row['main_image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="main-image" />
                            <div class="side-images">
                                <img src="<?php echo htmlspecialchars($row['side_image_1']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?> 2" />
                                <img src="<?php echo htmlspecialchars($row['side_image_2']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?> 3" />
                            </div>
                        </div>

                        <div class="destination-description">
                            <h3>Deskripsi destinasi</h3>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                        </div>

                        <div class="activities-section">
                            <h3>Aktivitas yang Bisa Dilakukan</h3>
                            <div class="activities-grid">
                                <?php
                                foreach ($activities as $index => $activity) {
                                    echo '<div class="activity-card">';
                                    echo '<span class="activity-number">' . ($index + 1) . '</span>';
                                    echo '<p>' . htmlspecialchars($activity) . '</p>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="important-info">
                            <h3>Penting diketahui sebelum berkunjung</h3>
                            <ul>
                                <?php
                                foreach ($important_info as $index => $info) {
                                    echo '<li>' . htmlspecialchars($info) . '</li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="info-card">
                        <?php echo $row['map_embed']; ?>
                        <div class="info-text">
                            <p><strong>Alamat</strong><br><?php echo htmlspecialchars($row['address']); ?></p>
                            <p><strong>Situs Web</strong><br><a href="<?php echo htmlspecialchars($row['website']); ?>"><?php echo htmlspecialchars($row['website']); ?></a></p>
                            <p><strong>Telepon</strong><br><?php echo htmlspecialchars($row['phone']); ?></p>
                            <p><strong>Jam buka</strong><br><?php echo htmlspecialchars($row['opening_hours']); ?></p>
                        </div>
                        <button class="itinerary-button">Tambah ke Itinerary</button>
                    </div>
                </div>
            <?php
            } else {
                echo '<p>Destinasi dengan ID ' . $id . ' tidak ditemukan. Silakan kembali ke <a href="../index.php">halaman pencarian</a>.</p>';
            }
        }

        $conn->close();
        ?>
    </section>
</body>
</html>