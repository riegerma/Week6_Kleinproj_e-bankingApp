<?php



function getDataPerId($id)
{
    $pdo = new PDO('mysql:host=localhost;dbname=ebankingusers', 'root', '');
    $error = false;



    if (!$error) {
        $statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");

        $result = $statement->execute(array('id' => $id));

        $user = $statement->fetch();

        if ($user == false) {
            echo 'User nicht vorhanden<br>';
            $error = true;
        } else {

            echo "<tr><td>Vorname</td><td>" . $user["vorname"] . "</td></tr>";
            echo "<tr><td>Nachname</td><td>" . $user["nachname"] . "</td></tr>";
            echo "<tr><td>Verfüger</td><td>" . $user["verfüger"] . "</td></tr>";
            echo "<tr><td>Kontonummer</td><td>" . $user["kontonummer"] . "</td></tr>";
            echo "<tr><td>IBAN:</td><td>" . $user["iban"] . "</td></tr>";
            echo "<tr><td>Ihr Kontostand:</td><td>" . $user["kontostand"] . "</td></tr>";


        }


    }
}