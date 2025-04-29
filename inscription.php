<?php 
    session_start();
    $user = "root";
    $pass = "";
    $db_db = "suivi_revisions";
    $host = "localhost";
    $code = "";

    if (isset($_SESSION['id'])) {
        header("location: ./index.php");
    }

    if (isset($_POST["singup"])) {


        if (!empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["pass"])) {

            $nom = $_POST["nom"];
            $email = $_POST["email"];

            $hashedPass = password_hash($_POST["pass"], PASSWORD_DEFAULT);
            $ladate = date("Y-m-d H:i:s");

            $connect = new PDO("mysql:host=$host;dbname=$db_db", $user, $pass);
            $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, date_inscription) VALUES (:nom, :email, :mot_de_passe, :ladate)";
            $stmt = $connect->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':email' => $email,
                ':mot_de_passe' => $hashedPass,
                ':ladate' => $ladate
            ]);
            $code = "Thank you for Singup ";
            header("location: ./connexion.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <form action="" method="post">
        <label for="nom">Le Nom : <input type="text" name="nom" id="nom"> </label><br>
        <label for="email">Email : <input type="email" name="email" id="email"> </label><br>
        <label for="pass">Mot de passe : <input type="password" name="pass" id="pass"></label><br>
        <button type="submit" name="singup">S'inscrire</button><br>
        <a href="./connexion.php">Or Login</a>
        <div class="message"><?php echo $code ?></div>
    </form>
</body>
</html>