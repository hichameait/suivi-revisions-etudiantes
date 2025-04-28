<?php 
    session_start();
    $user = "root";
    $pass = "";
    $db_db = "suivi_revisions";
    $host = "localhost";
    $code = "";

    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION["id"];
    } else {
        header("location: ./dashboard.php");
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

        .message {
            text-align: center;
            margin-top: 1rem;
            color: #42b72a;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <label for="nom">Le Nom : <input type="text" name="nom" id="nom"> </label>
        <label for="email">Email : <input type="email" name="email" id="email"> </label>
        <label for="pass">Mot de passe : <input type="password" name="pass" id="pass"></label>
        <button type="submit" name="singup">S'inscrire</button>
        <div class="message"><?php echo $code ?></div>
    </form>
</body>
</html>