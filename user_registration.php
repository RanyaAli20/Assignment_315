<?php
include_once("connection.php");

function display_registration_form($conn) { ?>
    <form method="post" action="#">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        
        <label for="role">Role:</label>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br>
        
        <label for="passport_no">Passport No:</label>
        <input type="text" name="passport_no" required><br>
        
        <input type="submit" name="register" value="Register">
    </form>
<?php }

function register_user($conn) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $passport_no = $_POST['passport_no'];

    try {
        $sql = "INSERT INTO user (u_name, Password, Priv, Passport_no) VALUES ('$username', '$password', '$role', '$passport_no')";
        $conn->exec($sql);
        echo "User registered successfully";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Register User</title>
</head>
<body>
<?php
if (!isset($_POST['register'])) {
    display_registration_form($conn);
} else {
    register_user($conn);
}
?>
</body>
</html>
