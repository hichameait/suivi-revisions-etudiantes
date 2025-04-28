<?php
    session_start();

   $user = "root";
   $pass = "";
   $db_db = "suivi_revisions";
   $host = "localhost";
   $error = ""; 

    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION["id"];
    } else {
        header("location: ./connexion.php");
    }

    try {
        $connect = new PDO("mysql:host=$host;dbname=$db_db", $user, $pass);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = "WHERE date >= NOW() - INTERVAL 7 DAY AND utilisateur_id = :id";
    
        $stmt = $connect->prepare($sql);
        $stmt->execute([
            ':id'  => $user_id
        ]);
    } catch (PDOException $ro) {
        echo 'Error : {$ro}';
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
    <p>Total d’heures de révision : </p>
    <p>Moyenne des notes de compréhension : </p>

    <ul>
        <li><a href="./ajouter_revision.php">Ajouter Revision</a></li>
        <li><a href="./ajouter_revision.php">List Revision</a></li>

</ul>
</body>
</html>