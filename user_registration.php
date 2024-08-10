<?php
include_once("connection.php");

function display_registration_form($conn) { ?>
    <div class="container">
        <h2>Register a new user👨‍💼🆕</h2>
        <form method="post" action="#">
            <label for="username">username:</label>
            <input type="text" name="username" required><br>
            
            <label for="password">password :</label>
            <input type="password" name="password" required><br>
            
            <label for="role">Priv:</label>
            <select name="role" required>
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select><br>
            
            <label for="passport_no">Passport number:</label>
            <input type="text" name="passport_no" required><br>
            
            <input type="submit" name="register" value="register">
        </form>
    </div>
<?php }

function register_user($conn) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $passport_no = $_POST['passport_no'];

    if (!ctype_digit($passport_no)) {
        echo "رقم جواز السفر يجب أن يحتوي على أرقام فقط.";
        return;
    }

    try {
        $sql = "INSERT INTO user (u_name, Password, Priv, Passport_no) VALUES ('$username', '$password', '$role', '$passport_no')";
        $conn->exec($sql);
        echo "تم تسجيل المستخدم بنجاح";

        header("Location: login.php");
        exit();

    } catch(PDOException $e) {
        echo "خطأ: " . $e->getMessage();
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>تسجيل مستخدم</title>
<link rel="stylesheet" type="text/css" href="user_registration.css">
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
