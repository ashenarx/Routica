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

    <section class="search-results">
        <h2>Hasil Pencarian</h2>
        <?php
        include '../service/database.php';

        $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
        $sql = "SELECT id, name, category, main_image FROM destinasi";
        if ($search) {
            $sql .= " WHERE name LIKE ? OR category LIKE ?";
            $stmt = $conn->prepare($sql);
            $search_param = "%$search%";
            $stmt->bind_param("ss", $search_param, $search_param);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $sql .= " LIMIT 4";
            $result = $conn->query($sql);
        }

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

        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
        ?>
    </section>
</body>
</html>