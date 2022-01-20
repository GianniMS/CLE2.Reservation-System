<?php
//Server and database information and login credentials
$servername = "localhost"; //Default localhost name
$username = "root"; //Default username for localhost is root
$password = ""; //Default password for localhost is empty
$dbname = "reservation_deecuts"; //Database name

//Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Create connection with the servers and database
if (!$conn) {
    die("connection failed: " . mysqli_connect_error());
}
//Server side validation message variables
$nicknamemail_error = '';
$name_error = '';
$nickname_error = '';
$email_error = '';
$password_error = '';
$repassword_error = '';
$succes_message = '';
$passwordrepassword_error = '';

if (isset($_POST["submit"])) {
    //Input protected against SQL Injections by using mysqli_real_escape_string()
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $nickname = mysqli_real_escape_string($conn, $_POST["nickname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];
    //Server side validation
    if (empty($_POST['name'])) {
        //Checks for empty input
        $name_error = '<p>Dit veld is verplicht!</p>';
    } else {
        //Checks value of the characters
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $name_error = '<p>Gebruik hier alleen letters!</p>';
        }
    }
    if (empty($_POST['nickname'])) {
        //Checks for empty input
        $nickname_error = '<p>Dit veld is verplicht!</p>';
    } else {
        //Checks for value of the characters
        if (!preg_match("/^[a-zA-Z ]*$/", $nickname)) {
            $nickname_error = '<p>Gebruik hier alleen letters!</p>';
        }
    }
    if (empty($_POST['email'])) {
        //Checks for empty input
        $email_error = '<p>Dit veld is verplicht!</p>';
    } else {
        //Checks if the entered email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = '<p>Voer geldige email in!</p>';
        }
    }
    //If there are no errors it will check the if the input is correct
    if (empty($name_error || $nickname_error || $email_error)) {
        //Checks if the nickname or email are already registered in the database
        $duplicate = mysqli_query($conn, "SELECT * FROM admins WHERE nickname = '$nickname' OR email = '$email'");
        if (mysqli_num_rows($duplicate) > 0) {
            //If there are more than 0 items in the database with the same name or email. An error message will be displayed
            $nicknamemail_error = '<p>Gebruikersnaam of email al ingebruik</p>';
        } else {
            //Checks if the password and the repeated password correspond
            if ($password == $repassword) {
                //Hashes the entered password for security reasons
                $passhash = password_hash($password, PASSWORD_DEFAULT);
                //Insert the data and the hashed password into the database
                $query = "INSERT INTO admins VALUES('', '$name', '$nickname', '$email', '$passhash')";
                mysqli_query($conn, $query);
                //If the data insertion went succesfull. Display confirmation message
                $succes_message = '<p class="updatemsg">Registratie gelukt!</p>';
            } else {
                //If the data insertion failed. Display error message
                $passwordrepassword_error = '<p>Wachtwoord en herhaling komen niet overheen</p>';
            }
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

    <title>Registreer</title>
</head>
<body>
<span class="updatemsg"><?php echo $succes_message ?></span>
<h1 class="titel">Registreren</h1>
<div class="container">
    <form method="post"
          action=""
          class="">
        <div class="formdiv">
            <label for="name">Naam</label><br>
            <input type="text"
                   class="form-control"
                   id="name"
                   name="name"
                   placeholder="Uw naam"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $name_error ?></span>
        </div>
        <div class="formdiv">
            <label for="nickname">Gebruikersnaam</label><br>
            <input type="text"
                   class="form-control"
                   id="nickname"
                   name="nickname"
                   autocomplete="off"
                   placeholder="Uw gebruikersnaam"><br>
            <!--Server side validation messages-->
            <span class="text-danger"><?php echo $nicknamemail_error; ?></span>
            <span class="text-danger"><?php echo $nickname_error; ?></span>
        </div>
        <div class="formdiv">
            <label for="email">Email</label><br>
            <input type="text"
                   class="form-control"
                   id="email"
                   name="email"
                   autocomplete="off"

                   placeholder="Uw email"><br>
            <!--Server side validation messages-->
            <span class="text-danger"><?php echo $nicknamemail_error; ?></span>
            <span class="text-danger"><?php echo $email_error ?></span>

        </div>
        <div class="formdiv">
            <label for="password">Wachtwoord</label><br>
            <input type="password"
                   class="form-control"
                   id="password"
                   autocomplete="off"
                   name="password"
                   placeholder="Uw wachtwoord"><br>
        </div>
        <div class="formdiv">
            <label for="repassword">Herhaal wachtwoord</label><br>
            <input type="password"
                   class="form-control"
                   id="repassword"
                   autocomplete="off"
                   name="repassword"
                   placeholder="Herhaal wachtwoord"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $passwordrepassword_error; ?></span>
        </div>
        <!--Submit button for the form-->
        <div class="submitbut">
            <button type="submit" class="sysbutton" name="submit">Registreer</button>
        </div>
    </form>
</div>
<div class="backroute">
    <a href="LogInAdmin1.B.1.php">Log in</a>
</div>
</body>
