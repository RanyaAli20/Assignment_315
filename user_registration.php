<?php
include_once("connection.php");

function display_registration_form($conn) { ?>
    <div class="container">
        <h2>Register a new user👨‍💼🆕</h2>
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
            
            <label for="passport_no">Passport Number:</label>
            <input type="text" name="passport_no" required><br>
            
            <input type="submit" name="register" value="Register">
        </form>
    </div>
<?php }

function register_user($conn) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $passport_no = $_POST['passport_no'];

    // Input validation
    if (empty($username) || !preg_match("/^[a-zA-Z]+$/", $username)) {
        echo "اسم المستخدم غير صالح. يجب أن يحتوي على أحرف فقط ولا يحتوي على فراغات.";
        return;
    }

    if (strlen($password) < 6) {
        echo "كلمة المرور يجب أن تكون على الأقل 6 أحرف.";
        return;
    }

    if (!ctype_digit($passport_no)) {
        echo "رقم جواز السفر يجب أن يحتوي على أرقام فقط.";
        return;
    }

    try {
        $sql = "INSERT INTO user (u_name, Password, Priv, Passport_no) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $password, $role, $passport_no]);
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
