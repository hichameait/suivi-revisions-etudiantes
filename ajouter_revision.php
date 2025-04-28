<?php 

session_start();


$user = "root";
$pass = "";
$db_db = "suivi_revisions";
$host = "localhost";
$error = "";

if(isset($_SESSION['id'])) {
    $user_is = $_SESSION["id"];
}else{
    header("location: ./connexion.php");
}

if (isset($_POST["add"])) {
    $matiere = $_POST["matiere"];
    $duree = $_POST["duree"];
    $note = $_POST["note"];
    $date = $_POST["date"];
    

    $connect = new PDO("mysql:host=$host;dbname=$db_db", $user, $pass);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO revisions (id, matiere, duree, note_comprehension, date_revision) VALUES (:matiere, :duree, :note, :date, :usr_id)";
    $stmt = $connect->prepare($sql);
    $stmt->execute([
        ':matiere' => $matiere,
        ':duree'   => $duree,
        ':note'    => $note,
        ':date'    => $date,
        ':usr_id'  => $user_is
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

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