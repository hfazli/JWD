<?php
include 'koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                header("Location: booking.php"); 
                exit();
            } else {
                $error = "Invalid password. Please try again.";
            }
        } else {
            $error = "Invalid username. Please try again.";
        }

        $stmt->close();
    } else {
        $error = "Please fill in both fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="L.css" />
</head>
<body>
    <main>
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="example@example.com" required /><br />
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required /><br />
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required /><br />
            <input type="submit" value="Login" />
        </form>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </main>
</body>
</html>
