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
    $res_id = mysqli_real_escape_string($conn, $_POST['id']);
    $last_name = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phonenumber']);
    $date_time = mysqli_real_escape_string($conn, $_POST['date_time']);
    //Server side validation for the input forms
    if (empty($_POST['firstname'])) {
        //Checks for empty input
        $firstname_error = '<p>Dit veld is verplicht!</p>';
    } else {
        //Checks the value of the characters
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
        $sql = "UPDATE `reservations` SET `firstname`='$first_name',`lastname`='$last_name',`email`='$email',
           `phonenumber`='$phone_number',`date_time`='$date_time' WHERE `reservation_id`='$res_id' ";
        //Execute update query
        $result = $conn->query($sql);
        if ($result == TRUE) {
            //Customize and display the update confirmation
            echo "<h2 class='updatemsg'>Succesvol geupdate!</h2>";
        } else {
            echo "Error:" . $sql . "<br>" . $conn->error;
        }
    }
}

//If the ID variable is set in the URL. The selected reservation will be updated
if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];
    // write SQL to get userdata
    $sql = "SELECT * FROM reservations WHERE reservation_id='$reservation_id'";
    //Execute the SQL
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $first_name = htmlspecialchars($row['firstname']);
            $last_name = htmlspecialchars($row['lastname']);
            $email = htmlspecialchars($row['email']);
            $phonenumber = htmlspecialchars($row['phonenumber']);
            $date_time = htmlspecialchars($row['date_time']);
            $res_id = htmlspecialchars($row['reservation_id']);
        }
    } else {
        //If the ID value is not valid. Redirect to Overview Reservation
        header('Location: OverviewReservation1.B.2.php');
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
    <title>Reservering wijzigen</title>
</head>

<body>
<h1 class="titel">Reservering wijzigen</h1>
<div class="container">
    <!--Input form for reservation editing-->
    <form method="post"
          action=""
          class="">
        <div class="formdiv">
            <label for="firstname">Voornaam</label><br>
            <input type="text"
                   class="form-control"
                   id="firstname"
                   value="<?php echo //Display original firstname
                   $first_name ?>"
                   name="firstname"
                   autocomplete="off"
                   placeholder="Uw voornaam"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $firstname_error; ?></span>
        </div>
        <div class="formdiv">
            <label for="id">ID</label><br>
            <input type="text"
                   class="form-control"
                   id="id"
                   value="<?php echo //Display original reservation_ID
                   $res_id ?>"
                   autocomplete="off"
                   name="id" <br>
        </div>
        <div class="formdiv">
            <label for="lastname">Achternaam</label><br>
            <input type="text"
                   class="form-control"
                   id="lastname"
                   value="<?php echo //Display original lastname
                   $last_name ?>"
                   autocomplete="off"
                   name="lastname"
                   placeholder="Uw achternaam"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $lastname_error; ?></span>
        </div>
        <div class="formdiv">
            <label for="email">Email</label><br>
            <input type="email"
                   class="form-control"
                   id="email"
                   value="<?php echo //Display original email
                   $email ?>"
                   name="email"
                   autocomplete="off"
                   placeholder="Uw email"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $email_error; ?></span>
        </div>
        <div class="formdiv">
            <label for="phonenumber">Telefoonnummer</label><br>
            <input type="text"
                   class="form-control"
                   id="phonenumber"
                   value="<?php echo //Display original phonenumber
                   $phonenumber ?>"
                   autocomplete="off"
                   name="phonenumber"
                   placeholder="Uw telefoon nummer"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $phonenumber_error; ?></span>
        </div>
        <div class="formdiv">
            <label for="date_time">Datum en tijd</label><br>
            <input type="datetime-local"
                   class="form-control"
                   id="date_time"
                   value="<?php echo //Display original date and time
                   $date_time ?>"
                   autocomplete="off"
                   name="date_time"
                   placeholder="Kies uw datum en tijd"><br>
            <!--Server side validation message-->
            <span class="text-danger"><?php echo $datetime_error; ?></span>
        </div>
        <!--Button to submit info-->
        <div class="backroute">
            <input type="submit" name="submit" class="updatebut" value="Update">
        </div>
    </form>
    <!--Link to go back to reservation overview-->
    <div class="backroute">
        <a href="OverviewReservation1.B.2.php">Terug naar overzicht</a>
    </div>
</div>
</body>
