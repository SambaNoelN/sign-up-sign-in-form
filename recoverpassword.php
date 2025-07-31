<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Replace with your database connection
        $conn =mysqli_connect('localhost', 'root', '', 'your_database');
        if ($conn->connect_error) {
            die('Database connection failed: ' . $conn->connect_error);
        }

        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $stmt2 = $conn->prepare('UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?');
            $stmt2->bind_param('sss', $token, $expires, $email);
            $stmt2->execute();

            // Send email (replace with actual mail sending)
            $resetLink = "http://localhost/sign-up-sign-in-form/resetpassword.php?token=$token";
            mail($email, 'Password Recovery', "Click here to reset your password: $resetLink");

            $message = 'A password reset link has been sent to your email.';
        } else {
            $message = 'Email not found.';
        }
        $stmt->close();
        $conn->close();
    } else {
        $message = 'Please enter a valid email address.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Recover Password</title>
</head>
<body>
    <div class="container" id="signup">
    <h2>Recover Password</h2>
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>
    <form method="post" action="">
        <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" id="email" required><br><br>
        </div>
        <button type="submit" class="btn">Send Recovery Link</button>
    </form>
    </div>
</body>
</html>