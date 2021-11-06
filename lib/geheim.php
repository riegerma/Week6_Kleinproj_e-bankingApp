<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">


    <title>Kontoübersicht</title>


</head>
<body>
<div class="container">
    <h1 class="mt-5 mb-3"> Kontoübersicht</h1>

    <div class="col-sm-6 form-group">
        <table style="width:65%" class="table-striped">


            <?php
            session_start();

            if (!isset($_SESSION['userid'])) {
                die('Bitte zuerst <a href="../index.php">einloggen</a>');
            }

            //Abfrage der Nutzer ID vom Login
            $userid = $_SESSION['userid'];

            echo "Guten Tag, Verfüger: " . $userid;

            require "func.inc.php";

            getDataPerId($userid);

            ?>
            <br><br>

        </table>
        <br>
        <a href="logout.php">Abmelden</a><br><br>

    </div>
</div>

</body>
</html>





