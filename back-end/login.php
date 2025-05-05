<?php
session_start();
require_once 'db-conn.php'; // Your database connection

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userInput = $conn->real_escape_string($_POST['user']);
    $password = $_POST['password'] ?? '';

    // Query to find user by username, email, or phone
    $query = "SELECT * FROM Users 
              WHERE username = '$userInput' 
              OR email = '$userInput' 
              OR phone_number = '$userInput' 
              LIMIT 1";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $message = "Login successful!";
            header("Location: ../main-page.html");
            
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "Invalid username, email, or phone number.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <script>
        const message = "<?= htmlspecialchars($message) ?>";
        alert(message);
        setTimeout(() => {
            window.location.href = "../homepage.html"; // Adjust as needed
        }, 100);
    </script>
</head>

<body>
</body>

</html>