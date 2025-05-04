<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "turfmaster"; // Make sure this matches your database

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$turfName = $_POST['turfName'];
$username = $_POST['username'];
$email = $_POST['email']; // Capture the email from the form
$mobile = $_POST['mobile'];
$date = $_POST['date'];
$time = $_POST['time'];
$ampm = $_POST['ampm'];
$hours = $_POST['hours'];

// Update the SQL query to include the email
$sql = "INSERT INTO bookings (turfname, username, email, mobile, date, time, ampm, hours)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
  die("Prepare failed: " . $conn->error); // DEBUG LINE
}

$stmt->bind_param("sssssssi", $turfName, $username, $email, $mobile, $date, $time, $ampm, $hours);

if ($stmt->execute()) {
  // Correct redirection with query parameters
  $url = "receipt.html?turfName=" . urlencode($turfName) . 
         "&username=" . urlencode($username) . 
         "&email=" . urlencode($email) . // Add email to the URL
         "&mobile=" . urlencode($mobile) . 
         "&date=" . urlencode($date) . 
         "&time=" . urlencode($time) . 
         "&ampm=" . urlencode($ampm) . 
         "&hours=" . urlencode($hours);
  echo "<script>window.location.href = '$url';</script>";
  exit();
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
