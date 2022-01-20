<?php
//Start the session
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
if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM admins WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
}

//Query to get the data from the database
$sql = "SELECT * FROM reservations";

//Execute the query
$result = $conn->query($sql);
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

    <title>Overzicht Reserveringen</title>
</head>

<body>
<div class="container">
    <h1 class="titel">Overzicht reserveringen</h1>
    <!-- Displays the reservation data in the table -->
    <div class="tablediv">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Email</th>
                <th>Telefoonnummer</th>
                <th>Datum en tijd</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                //Outputs the reservation data in each row
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <!--Protection against XSS attacks by use of htmlspecialchars()-->
                        <td><?php echo htmlspecialchars($row['reservation_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phonenumber']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_time']); ?></td>
                        <!-- Button to go to the edit page-->
                        <td class="tdbut"><a class="buttonEdit"
                                             href="EditReservation1.B.3.php?id=<?php echo htmlspecialchars($row['reservation_id']); ?>">
                                <button class="butedit">Edit</button>
                            </a>
                            <!-- Button to delete a reservation-->
                            <a class="buttonDelete" href="DeleteAsk1.B.4.b.php?id=<?php echo
                            htmlspecialchars($row['reservation_id']) ?>">
                                <button class="butdel">Delete</button>
                            </a></td>
                    </tr>
                <?php }
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="backroute">
        <div class="backlog">
            <!--Log out button-->
            <a href="LogOut1.B.2.b.php">
                <button class="sysbutton">Log out</button>
            </a>
        </div>
    </div>
</div>
</body>