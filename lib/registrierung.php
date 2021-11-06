<?php
session_start();
//Verbindungsaufbau zur Datenbank: ebankingusers
$pdo = new PDO('mysql:host=localhost;dbname=ebankingusers', 'root', '' );
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <title>Registrierung</title>
</head>
<body>

<?php
$showFormular = true; //Variable ob das Registrierungsformular agezeigt werden soll

//Datenabfrage aus dem Formular: zuerst überpüft man ob es abgesendet wurde (isset)
if (isset($_GET['register'])) {
    $error = false;
    $vname = $_POST['vname'];
    $nname = $_POST['nname'];
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if (strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if ($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if (!$error) {
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();

        if ($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }

    //Keine Fehler!, wir können den Nutzer registrieren
    if (!$error) {
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

        $statement = $pdo->prepare(" INSERT INTO users (email, passwort, vorname, nachname) VALUES (:email, :passwort, :vname, :nname )");
        $result = $statement->execute(array( 'email' => $email, 'passwort' => $passwort_hash, 'vname' => $vname, 'nname' => $nname));

        if ($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="../index.php">Zum Login</a>';
            //Formular wir nicht nochmal ausgegeben im Erfolgsfall
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

if ($showFormular) {
    ?>

    <form action="?register=1" method="post">


        Vorname:<br>
        <input type="text" size="40" maxlength="250" name="vname" required><br><br>

        Nachname:<br>
        <input type="text" size="40" maxlength="250" name="nname" ><br><br>

        E-Mail:<br>
        <input type="email" size="40" maxlength="250" name="email"><br><br>

        Dein Passwort:<br>
        <input type="password" size="40" minlength="4" maxlength="250" name="passwort"><br>

        Passwort wiederholen:<br>
        <input type="password" size="40" minlength="4" maxlength="250" name="passwort2"><br><br>

        <input type="submit" value="Abschicken">
        <a href="../index.php">Zurück</a>
    </form>

    <?php
} //Ende von if($showFormular)
?>

</body>
</html>