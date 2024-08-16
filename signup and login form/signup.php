<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "userdatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Capture data from the form
$firstname = $_POST['firstName'];
$lastname = $_POST['lastName'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password before storing it
$gender = $_POST['gender'];

// Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO userdata (firstname, lastname, email, password, gender) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $firstname, $lastname, $email, $password, $gender);

// Execute the statement
if ($stmt->execute()) {
  echo "New record created successfully";
} else {
  echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
