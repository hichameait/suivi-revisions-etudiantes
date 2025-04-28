<?php 

session_start();

$user = "root";
$pass = "";
$db_db = "suivi_revisions";
$host = "localhost";
$error = "";

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["pass"];

    $connect = new PDO("mysql:host=$host;dbname=$db_db", $user, $pass);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT mot_de_passe FROM utilisateurs WHERE email = :email";
    $stmt = $connect->prepare($sql);
    $stmt->execute([':email' => $email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($password, $result['mot_de_passe'])) {

        $sql = "SELECT id FROM utilisateurs WHERE email = :email";
        $stmt = $connect->prepare($sql);
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['email'] = $email;
        $_SESSION['id'] = $result['id'];
        
        header("location: ./dashboard.php");
        exit();
    } else {
        $error = "Email ou mot de passe incorrects";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <form action="" method="post">
        <label for="email">Email : <input type="email" name="email" id="email" required></label><br>
        <label for="pass">Mot de passe : <input type="password" name="pass" id="pass" required></label><br>
        <button type="submit" name="login">Se connecter</button>
        <div class="error"><?php echo $error; ?></div>
    </form>
</body>
</html>