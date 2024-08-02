<?php
session_start();
include_once("connection.php");

function display_login_form() { ?>
    <form method="post" action="#">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        
        <input type="submit" name="login" value="Login">
    </form>
<?php }

function login_user($conn) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $sql = "SELECT * FROM User WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect based on the role
            if ($user['role'] == 'admin') {
                header("Location: admin_page.php");
            } else {
                header("Location: user_page.php");
            }
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
</head>
<body>
<?php
if (!isset($_POST['login'])) {
    display_login_form();
} else {
    login_user($conn);
}
?>
</body>
</html>