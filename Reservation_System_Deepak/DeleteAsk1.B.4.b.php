<?php
//Server and database information and login credentials
$servername = "localhost"; //Default localhost name
$username = "root"; //Default username for localhost is root
$password = ""; //Default password for localhost is empty
$dbname = "reservation_deecuts"; //Database name

//Create connection with the servers and database
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Check connection with the server and database
if (!$conn) {
    die("connection failed: " . mysqli_connect_error());
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@300&family=Roboto&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="Style.css">

    <title>Deecuts!</title>
</head>

<body>
<!--Text on top of the page-->
<h1 class="titel">Reservering verwijderen?</h1>
<div class="backroute">
    <a class="" href="DeleteReservation1.B.4.php?id=<?php if (isset($_GET['id'])) { //Check for the id
        $res_id = $_GET['id'];
        echo $res_id; //Pass the id through to the delete page
    } ?>
   ">
        <button class="sysbutton">Ja, verwijderen</button>
        <br>
        <!--Send back to the reservation overview-->
        <a href="OverviewReservation1.B.2.php">
            <button class="sysbutton">Nee, ga terug</button>
        </a>
</div>
</body>




