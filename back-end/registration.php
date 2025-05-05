<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once 'db-conn.php';  // Include your database connection file

// Flag to indicate if there is an error
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize and get form data
  $username = $conn->real_escape_string($_POST['username']);
  $email = $conn->real_escape_string($_POST['email']);
  $phone = $conn->real_escape_string($_POST['phone_number']);
  $password = $_POST['password'] ?? '';
  $confirmPassword = $_POST['confirm_password'] ?? '';
  $address = $conn->real_escape_string($_POST['address']);
  $firstname = $conn->real_escape_string($_POST['firstname']);
  $middlename = $conn->real_escape_string($_POST['middlename']);
  $lastname = $conn->real_escape_string($_POST['lastname']);
  $birthday = $conn->real_escape_string($_POST['birthday']);
}

// Check if passwords match
$passwordPattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/';

if (!preg_match($passwordPattern, $password)) {
  $message = "Password must be at least 8 characters long and should contain at least one of all the following: UPPERCASE letter, LOWERCASE letter, NUMBER, and one SPECIAL character.";
} elseif ($password !== $confirmPassword) {
  $message = "Passwords do not match";
} else {
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Check for duplicate username
  $checkUsernameQuery = "SELECT * FROM Users WHERE username = '$username'";
  $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);

  if (mysqli_num_rows($checkUsernameResult) > 0) {
    $message = "Username is already taken.";
  } else {
    // Check for duplicate email
    $checkEmailQuery = "SELECT * FROM Users WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
      $message = "Email is already taken.";
    } else {
      // Check for duplicate phone number
      $checkPhoneQuery = "SELECT * FROM Users WHERE phone_number = '$phone'";
      $checkPhoneResult = mysqli_query($conn, $checkPhoneQuery);

      if (mysqli_num_rows($checkPhoneResult) > 0) {
        $message = "Phone number is already taken.";
      } else {
        // Insert data into the database
        $sql = "INSERT INTO Users (username, email, phone_number, password, address, firstname, middlename, lastname, birthday)
                VALUES ('$username', '$email', '$phone', '$hashed_password', '$address', '$firstname', '$middlename', '$lastname', '$birthday')";

        if (mysqli_query($conn, $sql)) {
          $message = "Registration Successful";
        } else {
          $message = "Error: Unable to register. Please try again later.";
        }
      }
    }
  }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <script>
    const message = "<?= htmlspecialchars($message) ?>";
    alert(message); // Alert appears
    setTimeout(() => {
      window.location.href = "../homepage.html"; // Redirect after short delay
    }, 100); // Delay lets alert show before redirecting
  </script>
</head>

<body>
</body>

</html>