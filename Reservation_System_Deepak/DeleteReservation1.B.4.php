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

//If the ID variable is set in the URL. The selected reservation will be deleted
if (isset($_GET['id'])) {
    $res_id = $_GET['id'];
    //Write delete query
    $sql = "DELETE FROM `reservations` WHERE `reservation_id`='$res_id'";
    //Execute delete query
    $result = $conn->query($sql);
    if ($result == TRUE) {
        //Show confirmation that the selected reservation has been deleted
        echo "Record deleted succesfully";
    } else {
        //Show error message incase the deleting sequence fails
        echo "Error:" . $sql . "<br>" . $conn->error;
    }
    //Redirect back to the "Reservation Overview" when executed
    header("Location: OverviewReservation1.B.2.php");
}
?>

