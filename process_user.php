<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nouvelle_labs_db";


$conn = new mysqli("localhost", "root", "", "labs_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $wilaya = $conn->real_escape_string($_POST['wilaya']);
    $location = $conn->real_escape_string($_POST['location']);
    $analysis_id = intval($_POST['analysis']);

    $sql = "SELECT DISTINCT l.* 
            FROM labs l
            JOIN lab_analyses la ON l.id = la.lab_id
            WHERE l.wilaya = '$wilaya' 
            AND l.location LIKE '%$location%'
            AND la.analysis_id = $analysis_id";

    $result = $conn->query($sql);

    echo "<div class='results'>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='result-item'>";
            echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
            echo "<p>Wilaya: " . htmlspecialchars($row['wilaya']) . "</p>";
            echo "<p>Localisation: " . htmlspecialchars($row['location']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucun laboratoire trouvé.</p>";
    }
    echo "</div>";
}

$conn->close();
?>