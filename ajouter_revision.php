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

if (isset($_POST["add"])) {

    if (empty($_POST["matiere"]) || empty($_POST["duree"]) || empty($_POST["note"]) || empty($_POST["date"])) {
        die("Erreur : Tous les champs sont obligatoires !");
    }

    if (!is_numeric($_POST["note"]) || $_POST["note"] < 0 || $_POST["note"] > 10) {
        die("Erreur : La note doit être un nombre entre 0 et 10 !");
    }

    if (!is_numeric($_POST["duree"]) || $_POST["duree"] < 0) {
        die("Erreur : La durée doit être un nombre positif !");
    }

    $matiere = $_POST["matiere"];
    $duree = $_POST["duree"];
    $note = $_POST["note"];
    $date = $_POST["date"];


    if (!is_numeric($note) || $note < 0 || $note > 10) {
        die("Erreur : La note doit être un nombre entre 0 et 10.");
    }

    $connect = new PDO("mysql:host=$host;dbname=$db_db", $user, $pass);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO revisions (matiere, duree, note_comprehension, date_revision, utilisateur_id) 
            VALUES (:matiere, :duree, :note, :ldate, :usr_id)";

    $stmt = $connect->prepare($sql);
    $stmt->execute([
        ':matiere' => $matiere,
        ':duree'   => $duree,
        ':note'    => $note,
        ':ldate'   => $date,
        ':usr_id'  => $user_id
    ]);
    header("Location: ./revisions.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Revision</title>
</head>
<body>
    <form action="" method="post">
        <label for="matiere">
            Matière : <input type="text" placeholder="enter le matière" name="matiere">
        </label>
        <br>
        <label for="duree">
            Durée : <input type="text" placeholder="durée en minutes" name="duree"> 
        </label>
        <br>
        <label for="note">
            Note :  <input type="text" placeholder="note (0 - 10)" name="note">
        </label>
        <br>
        <label for="date">
            Date :  <input type="date" placeholder="" name="date">
        </label>
        <br>
        <button type="submit" name="add">Ajouter</button>
    </form>
</body>
</html>