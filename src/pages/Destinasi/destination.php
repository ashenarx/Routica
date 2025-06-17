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
    <div id="navbar-container"></div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('/src/components/navbar.html')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('navbar-container').innerHTML = html;
                })
                .catch(error => console.error('Error fetching navbar:', error));
        });
    </script>
    <section class="destination-detail">
        <?php
        include '../../../service/database.php';

        if (!isset($_GET['name']) || empty($_GET['name'])) {
            echo '<p>Error: Name destinasi tidak valid. Silakan kembali ke <a href="../index.php">halaman pencarian</a>.</p>';
        } else {
            $name = str_replace('_', ' ', $_GET['name']);
            $sql = "SELECT * FROM destinasi WHERE name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $activities = explode('|', $row['activities']);
                $important_info = explode('|', $row['important_info']);
            ?>
                <div class="back">
                    <button class="back-button" onclick="goBack()">
                        <img src="../../assets/icons/chevron-left.svg" alt="Back" />        
                    </button>
                </div>
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
                        <button class="itinerary-button" data-destination='<?php echo json_encode($row); ?>'>Tambah ke Itinerary</button>
                    </div>
                </div>
            <?php
            } else {
               echo '<p>Destinasi dengan nama ' . $name . ' tidak ditemukan. Silakan kembali ke <a href="/Routica/src/pages/Pencarian/pencarian.html">halaman pencarian</a>.</p>';
            }
            $stmt->close();
        }

        $conn->close();
        ?>
    </section>

    <script src="script.js"></script>
    <script>
        function goBack() {
            window.history.back();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const itineraryButton = document.querySelector('.itinerary-button');
            if (itineraryButton) {
                itineraryButton.addEventListener('click', () => {
                    const destination = JSON.parse(itineraryButton.getAttribute('data-destination'));
                    const itineraries = JSON.parse(localStorage.getItem('itineraries') || '[]');
                    const newDestination = {
                        name: destination.name,
                        image: destination.main_image,
                        addedAt: new Date().toISOString()
                    };

                    // Tambahkan destinasi ke itinerary pertama (atau buat baru jika kosong)
                    let updated = false;
                    for (let itinerary of itineraries) {
                        if (!itinerary.destinations) itinerary.destinations = [];
                        itinerary.destinations.push(newDestination);
                        updated = true;
                        break;
                    }
                    if (!updated && itineraries.length === 0) {
                        itineraries.push({ destinations: [newDestination] });
                    }
                    localStorage.setItem('itineraries', JSON.stringify(itineraries));
                    alert('Destinasi ditambahkan ke itinerary!');
                    window.location.href = '../Perencanaan/perencanaan.html';
                });
            }
        });
    </script>
</body>
</html>