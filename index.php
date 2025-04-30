<?php
    session_start();

   $user = "root";
   $pass = "";
   $db_db = "suivi_revisions";
   $host = "localhost";
   $totalHours = "";
   $totalMinutes = "";
   $totalDays = "";
   $avgNote = "";
   $error = ""; 

    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION["id"];
    } else {
        header("location: ./connexion.php");
    }

    try {
        $connect = new PDO("mysql:host=$host;dbname=$db_db", $user, $pass);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Calculate total minutes
        $sql = "SELECT SUM(duree) AS total_minutes FROM revisions WHERE utilisateur_id = :id AND date_revision >= NOW() - INTERVAL 7 DAY";
        $stmt = $connect->prepare($sql);
        $stmt->execute([
            ':id'  => $user_id
        ]);
        $result = $stmt->fetch();
        $totalMinutes = $result["total_minutes"] ?? 0;

        // Calculate total hours
        $totalHours = round($totalMinutes / 60, 2);

        // Calculate total days
        $sqlDays = "SELECT COUNT(DISTINCT DATE(date_revision)) AS total_days FROM revisions WHERE utilisateur_id = :id AND date_revision >= NOW() - INTERVAL 7 DAY";
        $stmt = $connect->prepare($sqlDays);
        $stmt->execute([
            ':id'  => $user_id
        ]);
        $result = $stmt->fetch();
        $totalDays = $result["total_days"] ?? 0;

        // Calculate average note
        $sql2 = "SELECT AVG(note_comprehension) AS moyenne_notes FROM revisions WHERE utilisateur_id = :id AND date_revision >= NOW() - INTERVAL 7 DAY";
        $stmt = $connect->prepare($sql2);
        $stmt->execute([
            ':id'  => $user_id
        ]);
        $result = $stmt->fetch();
        $avgNote = $result["moyenne_notes"] ? round($result['moyenne_notes'], 2) : 0;

    } catch (PDOException $ro) {
        echo "Error : {$ro}";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
</head>
<body>
    <h1>Statistiques hebdomadaires</h1>
    <p>Total d’heures de révision : <?= $totalHours ?></p>
    <p>Total de minutes de révision : <?= $totalMinutes ?></p>
    <p>Total de jours de révision : <?= $totalDays ?></p>
    <p>Moyenne des notes de compréhension : <?= $avgNote ?></p>

    <ul>
        <li><a href="./ajouter_revision.php">Ajouter Revision</a></li>
        <li><a href="./revisions.php">List Revision</a></li>
    </ul>
</body>
</html>