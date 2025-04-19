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
        $_SESSION['email'] = $email;
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
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
        }

        form {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        label {
            display: block;
            margin-bottom: 1.5rem;
            color: #333;
        }

        input {
            width: 100%;
            padding: 0.8rem;
            margin-top: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background-color: #1877f2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
        }

        button:hover {
            background-color: #166fe5;
        }

        .error {
            text-align: center;
            margin-top: 1rem;
            color: red;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <label for="email">Email : <input type="email" name="email" id="email" required></label>
        <label for="pass">Mot de passe : <input type="password" name="pass" id="pass" required></label>
        <button type="submit" name="login">Se connecter</button>
        <div class="error"><?php echo $error; ?></div>
    </form>
</body>
</html>