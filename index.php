<?php
// Définir les informations de connexion
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "labs_db";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Laboratoires</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .checkbox-group {
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Section d'administration -->
    <div class="container">
        <h2>Administration - Ajouter un laboratoire</h2>
        <form action="process_admin.php" method="POST">
            <div class="form-group">
                <label for="wilaya">Wilaya</label>
                <select name="wilaya" id="wilaya" required>
                    <option value="">Sélectionnez une wilaya</option>
                    <option value="Alger">Alger</option>
                    <option value="Oran">Oran</option>
                    <option value="Constantine">Constantine</option>
                    <option value="Mila">Mila</option>
                    <option value="Bejaia">Bejaia</option>
                </select>
            </div>

            <div class="form-group">
                <label for="location">Localisation exacte</label>
                <input type="text" name="location" id="location" required>
            </div>

            <div class="form-group">
                <label for="name">Nom du laboratoire</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label>Analyses proposées</label>
                <div class="checkbox-group">
                    <?php
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        echo "<p class='error'>Erreur de connexion à la base de données : " . $conn->connect_error . "</p>";
                    } else {
                        $result = $conn->query("SELECT * FROM analyses");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<label><input type='checkbox' name='analyses[]' value='{$row['id']}'> {$row['name']}</label><br>";
                            }
                        } else {
                            echo "<p class='error'>Aucune analyse disponible. Veuillez ajouter des analyses dans la base de données.</p>";
                        }
                        $conn->close();
                    }
                    ?>
                </div>
            </div>
            <button type="submit">Ajouter le laboratoire</button>
        </form>
    </div>

    <!-- Section utilisateur -->
    <div class="container">
        <h2>Recherche de laboratoires</h2>
        <form action="process_user.php" method="POST">
            <div class="form-group">
                <label for="user_wilaya">Wilaya</label>
                <select name="wilaya" id="user_wilaya" required>
                    <option value="">Sélectionnez une wilaya</option>
                    <option value="Alger">Alger</option>
                    <option value="Oran">Oran</option>
                    <option value="Constantine">Constantine</option>
                    <option value="Mila">Mila</option>
                    <option value="Bejaia">Bejaia</option>
                </select>
            </div>

            <div class="form-group">
                <label for="user_location">Localisation</label>
                <input type="text" name="location" id="user_location" required>
            </div>

            <div class="form-group">
                <label for="analysis">Type d'analyse</label>
                <select name="analysis" id="analysis" required>
                    <option value="">Sélectionnez une analyse</option>
                    <?php
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        echo "<p class='error'>Erreur de connexion à la base de données : " . $conn->connect_error . "</p>";
                    } else {
                        $result = $conn->query("SELECT * FROM analyses");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id']}'>{$row['name']}</option>";
                            }
                        } else {
                            echo "<option value=''>Aucune analyse disponible</option>";
                        }
                        $conn->close();
                    }
                    ?>
                </select>
            </div>

            <button type="submit">Rechercher</button>
        </form>
    </div>

</body>
</html>
