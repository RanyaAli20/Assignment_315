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
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        echo "Username and password are required.";
        return;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $sql = "SELECT * FROM user WHERE u_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
    
        if ($user && $password == $user['Password']) {
            $_SESSION['user_id'] = $user['U_no'];
            $_SESSION['username'] = $user['u_name'];
            $_SESSION['role'] = $user['Priv'];
            
            if ($user['Priv'] == 'Admin') {
                header("Location: admin.php");
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
