<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db-conn.php';  // Include your database connection file

// Flag to indicate if there is an error
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get form data
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $address = $conn->real_escape_string($_POST['address']);
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $middlename = $conn->real_escape_string($_POST['middlename']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $birthday = $conn->real_escape_string($_POST['birthday']);

    // Check if passwords match
    if ($password != $confirmPassword) {
        $message = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Users (username, email, phone_number, password, address, firstname, middlename, lastname, birthday)
                VALUES ('$username', '$email', '$phone', '$hashed_password', '$address', '$firstname', '$middlename', '$lastname', '$birthday')";

        if ($conn->query($sql) === TRUE) {
            $message = "Registration successful!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }

}

    // Close database connection
    $conn->close();

?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="refresh" content="2;url=../homepage.html">
</head>
<body>
  <script>
    alert("<?= htmlspecialchars($message) ?>");
  </script>
</body>
</html>