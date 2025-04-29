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
    $conne = new PDO("mysql:host=$host;dbname=$db_db", $user, $pass);
    $conne->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if (isset($_POST["update"])) {
        $ids = $_POST["ids"];
        $duree = $_POST["duree"];
        $note_co = $_POST["note_comprehension"];
        $matiere = $_POST["matiere"];
    
        $sql = "UPDATE revisions SET matiere = :matiere, duree = :duree, note_comprehension = :note_c 
                WHERE utilisateur_id = :utilisateur_id AND id = :id";
        $stmt = $conne->prepare($sql);
        $stmt->execute([
            ':matiere' => $matiere,
            ':duree' => $duree,
            ':note_c' => $note_co,
            ':utilisateur_id' => $user_id,
            ':id' => $ids
        ]);
    }

    
    if (isset($_POST["remove"])) {
        $ids = $_POST["ids"];
        $sql = "DELETE FROM revisions WHERE id=:id";
        $stmt = $conne->prepare($sql);
        $stmt->execute([':id' => $ids]);
        $code = "Data removed id : {$ids}";
    }

    $sql = "SELECT * FROM revisions WHERE utilisateur_id = :utilisateur_id ORDER BY date_revision DESC";
    $stmt = $conne->prepare($sql);
    $stmt->execute([':utilisateur_id' => $user_id]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

} catch (PDOException $er) {
    $code = "Error : {$er->getMessage()}";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisions List</title>
</head>

<body>
    <table border="1px">
        <tr>
            <th>matiere</th>
            <th>duree</th>
            <th>note_comprehension</th>
            <th>Update</th>
            <th>Remove</th>
        </tr>

        <?php foreach ($stmt->fetchAll() as $value): ?>
            <tr>
                <form action="" method="post">
                    <input type="hidden" value="<?= $value["id"] ?>" name="ids">
                    <td><input type="text" value="<?= $value["matiere"] ?>" name="matiere"></td>
                    <td><input type="number" value="<?= $value["duree"] ?>" name="duree" ></td>
                    <td><input type="number" value="<?= $value["note_comprehension"] ?>" name="note_comprehension"></td>   
                    <td><button type="submit" name="update">update</button></td>
                    <td><button type="submit" name="remove">remove</button></td>
                </form>
            </tr>
        <?php endforeach ?>

    </table>
    <ul>
        <li><a href="./ajouter_revision.php">Ajouter Revision</a></li>
        <li><a href="./revisions.php">List Revision</a></li>

</ul>
</body>
</html>