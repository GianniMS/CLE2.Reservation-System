<?php
//Starts the session
session_start();

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

//Server side validation messages
$nicknamemail_error = '';
$password_error = '';

//Checks if the data has been submitted
if (isset($_POST["submit"])) {
    //Input protected against SQL Injections by using mysqli_real_escape_string()
    $nicknamemail = mysqli_real_escape_string($conn, $_POST["nicknamemail"]);
    $password = $_POST["password"];
    //Query to retrieve the information from the database
    //Makes it so that both the nickname and email are valid for logging in
    $result = mysqli_query($conn, "SELECT * FROM admins WHERE nickname = '$nicknamemail' OR email = '$nicknamemail'");
    $row = mysqli_fetch_assoc($result);
    //Server side validation
    if (empty($_POST['nicknamemail'])) {
        //Checks for empty input
        $nicknamemail_error = '<p>Dit veld is verplicht!</p>';
    }
    if (empty($_POST['password'])) {
        //Checks for empty input
        $password_error = '<p>Dit veld is verplicht!</p>';
    }
    //If the error messages are empty it will allow to check for corresponding password and username
    if (empty($nicknamemail_error || $password_error)) {
        if (mysqli_num_rows($result) > 0) {
            //Checks if the password corresponds with the hashed password that is stored in the database
            if (password_verify($password, $row['password'])) {
                $_SESSION["login"] = true;
                $_SESSION["id"] = $row["id"];
                //Once its verified it will redirect to the reservation overview
                header("Location: OverviewReservation1.B.2.php");
            } else {
                //If the password is incorrect it will display an error message
                $password_error = 'Verkeerd wachtwoord';
            }
        } else {
            //If the username doesn't correspond with the database an error message will display
            $nicknamemail_error = 'Gebruiker niet geregistreerd';
        }

    }
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

    <title>Log in</title>
</head>

<body>
<!--Text on top of the page-->
<h1 class="titel">Inloggen</h1>
<div class="container">
    <!-- Form to enter login credentials-->
    <form method="post"
          action=""
          class="">
        <div class="formdiv">
            <label for="nicknamemail">Gebruikersnaam of email</label><br>
            <input type="text"
                   class="form-control"
                   id="nicknamemail"
                   name="nicknamemail"
                   autocomplete="off"
                   placeholder="Uw gebruikersnaam of email"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $nicknamemail_error ?></span>

        </div>
        <div class="formdiv">
            <label for="password">Wachtwoord</label><br>
            <input type="password"
                   class="form-control"
                   id="password"
                   name="password"
                   autocomplete="off"
                   placeholder="Uw wachtwoord"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $password_error ?></span>
        </div>
        <div class="submitbut">
            <!-- Button to submit the entered information-->
            <button type="submit"
                    name="submit"
                    class="sysbutton"
                    value="Log in">Log in
            </button>
        </div>
    </form>
</div>
<div class="backroute">
    <!-- Go to the register page incase the user does not own an account-->
    Nog geen account? <a href="Register1.B2.1.php">Registreer</a><br>
    <!-- Go back to the home page incase the user wants to go back -->
    <a href="Home1.X.0.php">Home</a>
</div>
</body>