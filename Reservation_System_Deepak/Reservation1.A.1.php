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

//Server side validation message variables
$firstname_error = '';
$lastname_error = '';
$email_error = '';
$phonenumber_error = '';
$datetime_error = '';
//If the form's update button has been clicked. The form gets processed
if (isset($_POST['submit'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['firstname']);
    $last_name = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phonenumber']);
    $date_time = mysqli_real_escape_string($conn, $_POST['date_time']);
    //Server side validation for the input forms
    if (empty($_POST['firstname'])) {
        //Checks for empty input
        $firstname_error = '<p>Dit veld is verplicht!</p>';
    } else {
        //Checks value of the characters
        if (!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
            $firstname_error = '<p>Gebruik hier alleen letters!</p>';
        }
    }
    if (empty($_POST['lastname'])) {
        //Checks for empty input
        $lastname_error = '<p>Dit veld is verplicht!</p>';
    } else {
        //Checks value of the characters
        if (!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
            $lastname_error = '<p>Gebruik hier alleen letters!</p>';
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
    if (empty($_POST['phonenumber'])) {
        //Checks for empty input
        $phonenumber_error = '<p>Dit veld is verplicht!</p>';
    }
    if (empty($_POST['date_time'])) {
        //Checks for empty input
        $datetime_error = '<p>Dit veld is verplicht!</p>';
    }
    //If all the forms got correct input it allows the data to be sent to the database
    if (empty($firstname_error || $lastname_error || $email_error || $phonenumber_error || $datetime_error)) {
        //SQL query to insert the data into the database
        $sql = "INSERT INTO `reservations`(`firstname`, `lastname`, `email`, `phonenumber`, `date_time`) VALUES ('$first_name',
                '$last_name', '$email', '$phone_number', '$date_time')";
        //Execute query so the data actually gets inserted
        $result = $conn->query($sql);
        //When its inserted succesfully it redirects to the Reservation Succes page
        if ($result == true) {
            echo "Reservering gemaakt!";
            header("Location: ReservationSucces1.A.2.php");
        } else {
            //If the data insertion failed it will display an error
            echo "Error:" . $sql . "<br>" . $conn->error;
        }
        $conn->close();
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
    <title>Reserveren</title>
</head>

<body>
<!--Text on top of the page-->
<h1 class="titel">Reserveren</h1>
<div class="container">
    <!--Input form for reservations-->
    <form method="post"
          action=""
          class="">
        <div class="formdiv">
            <label for="firstname">Voornaam</label><br>
            <input type="text"
                   class="form-control"
                   id="firstname"
                   name="firstname"
                   autocomplete="off"
                   placeholder="Uw voornaam"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $firstname_error; ?></span>
        </div>
        <div class="formdiv">
            <label for="lastname">Achternaam</label><br>
            <input type="text"
                   class="form-control"
                   id="lastname"
                   name="lastname"
                   autocomplete="off"
                   placeholder="Uw achternaam"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $lastname_error; ?></span>
        </div>
        <div class="formdiv">
            <label for="email">Email</label><br>
            <input type="text"
                   class="form-control"
                   id="email"
                   name="email"
                   autocomplete="off"
                   placeholder="Uw email"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $email_error; ?></span>
        </div>
        <div class="formdiv">
            <label for="phonenumber">Telefoon Nummer</label><br>
            <input type="text"
                   class="form-control"
                   id="phonenumber"
                   name="phonenumber"
                   autocomplete="off"
                   placeholder="Uw telefoon nummer"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $phonenumber_error; ?></span>
        </div>
        <div class="formdiv">
            <label for="date_time">Datum en Tijd</label><br>
            <input type="datetime-local"
                   class="form-control"
                   id="date_time"
                   name="date_time"
                   autocomplete="off"
                   placeholder="Kies uw datum en tijd"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $datetime_error; ?></span>
        </div>
        <div class="backroute">
            <!--Submit button for form-->
            <input type="submit" class="sysbutton" name="submit" value="Reserveer">
        </div>
    </form>
</div>
</body>
