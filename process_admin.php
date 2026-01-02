<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nouvelle_labs_db";

// الاتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// عند إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // تأمين البيانات
    $name = $conn->real_escape_string($_POST['name']);
    $wilaya = $conn->real_escape_string($_POST['wilaya']);
    $location = $conn->real_escape_string($_POST['location']);
    $type = $conn->real_escape_string($_POST['type']); // جديد: حقل النوع
    $analyses = isset($_POST['analyses']) ? $_POST['analyses'] : [];

    // إدخال المختبر مع النوع
    $sql = "INSERT INTO labs (name, wilaya, location, type) VALUES ('$name', '$wilaya', '$location', '$type')";
    if ($conn->query($sql) === TRUE) {
        $lab_id = $conn->insert_id;

        // إدخال التحاليل المرتبطة بالمختبر
        if (!empty($analyses)) {
            foreach ($analyses as $analysis_id) {
                $analysis_id = intval($analysis_id);
                // التحقق من صحة ID التحليل
                $check_sql = "SELECT id FROM analyses WHERE id = $analysis_id";
                $check_result = $conn->query($check_sql);
                if ($check_result->num_rows > 0) {
                    $insert_sql = "INSERT INTO lab_analyses (lab_id, analysis_id) VALUES ($lab_id, $analysis_id)";
                    $conn->query($insert_sql);
                }
            }
            echo "✅ Laboratoire ajouté avec succès avec les analyses !";
        } else {
            echo "✅ Laboratoire ajouté sans analyses sélectionnées.";
        }
    } else {
        echo "❌ Erreur lors de l'ajout du laboratoire : " . $conn->error;
    }
}

// غلق الاتصال
$conn->close();
?>
