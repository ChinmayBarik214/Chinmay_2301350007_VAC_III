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
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and bind the SQL statement
$stmt = $conn->prepare("SELECT password FROM userdata WHERE email = ?");
$stmt->bind_param("s", $email);

// Execute the statement
$stmt->execute();

// Store the result
$stmt->store_result();

// Check if the email exists
if ($stmt->num_rows > 0) {
  // Bind the result to a variable
  $stmt->bind_result($hashed_password);
  $stmt->fetch();

  // Verify the password
  if (password_verify($password, $hashed_password)) {
    echo "Login successful!";
    // Here, you could redirect to another page, start a session, etc.
  } else {
    echo "Invalid password.";
  }
} else {
  echo "No account found with that email.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
