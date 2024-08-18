<?php
include_once("connection.php");

function book_flight($conn, $flight_id, $passport_no, $pass_name, $email, $class) {
    try {
        // إدخال بيانات الحجز إلى جدول Reservation_flight
        $sql = "INSERT INTO Reservation_flight (F_no, Class, Passport_no, pass_Name, Email)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$flight_id, $class, $passport_no, $pass_name, $email]);

        // تحديث عدد المقاعد المحجوزة في جدول Flight
        if ($class === 'F') {
            $sql = "UPDATE Flight SET Res_num_F = Res_num_F + 1 WHERE F_no = ?";
        } else {
            $sql = "UPDATE Flight SET Res_num_E = Res_num_E + 1 WHERE F_no = ?";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute([$flight_id]);

        echo "تم حجز الرحلة بنجاح!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function validate_input($passport_no, $pass_name, $email) {
    // التحقق من رقم جواز السفر (أرقام فقط)
    if (!preg_match('/^\d+$/', $passport_no)) {
        echo "رقم جواز السفر يجب أن يحتوي على أرقام فقط.";
        return false;
    }

    // التحقق من اسم المسافر (حروف فقط)
    if (!preg_match('/^[a-zA-Z\s]+$/', $pass_name)) {
        echo "اسم المسافر يجب أن يحتوي على حروف فقط.";
        return false;
    }

    // التحقق من البريد الإلكتروني
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "البريد الإلكتروني غير صحيح.";
        return false;
    }

    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['book'])) {
        $flight_id = $_POST['flight_id'];
        $passport_no = $_POST['passport_no'];
        $pass_name = $_POST['pass_name'];
        $email = $_POST['email'];
        $class = $_POST['class'];

        if (validate_input($passport_no, $pass_name, $email)) {
            book_flight($conn, $flight_id, $passport_no, $pass_name, $email, $class);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>حجز رحلة</title>
</head>
<body>
    <h1>حجز رحلة</h1>
    <form method="post" action="#">
        <label for="from_C_no">مكان المغادرة:</label>
        <select name="from_C_no" required>
            <?php
            $sql = "SELECT C_no, C_Name FROM Country";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['C_no']}'>{$row['C_Name']}</option>";
            }
            ?>
        </select><br>

        <label for="to_C_no">مكان الوصول:</label>
        <select name="to_C_no" required>
            <?php
            $sql = "SELECT C_no, C_Name FROM Country";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['C_no']}'>{$row['C_Name']}</option>";
            }
            ?>
        </select><br>

        <label for="F_Date">تاريخ الرحلة:</label>
        <input type="date" name="F_Date" required><br>

        <label for="class">الدرجة:</label><br>
        <input type="radio" id="class_f" name="class" value="F" required>
        <label for="class_f">First Class</label><br>
        <input type="radio" id="class_e" name="class" value="E" required>
        <label for="class_e">Economy Class</label><br>

        <input type="submit" name="search" value="بحث">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
        $from_C_no = $_POST['from_C_no'];
        $to_C_no = $_POST['to_C_no'];
        $F_Date = $_POST['F_Date'];
        $class = $_POST['class'];
        
        // تعديل استعلام البحث ليتضمن أسماء الدول ووقت الرحلة
        $sql = "SELECT F.F_no, C1.C_Name AS from_country, C2.C_Name AS to_country, F.F_Date, F.D_Time
                FROM Flight F
                JOIN Country C1 ON F.from_C_no = C1.C_no
                JOIN Country C2 ON F.to_C_no = C2.C_no
                WHERE F.from_C_no = ? AND F.to_C_no = ? AND F.F_Date = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$from_C_no, $to_C_no, $F_Date]);
        $flights = $stmt->fetchAll(PDO::FETCH_OBJ);
        ?>
        <h2>الرحلات المتاحة</h2>
        <form method="post" action="#">
            <table border="1">
                <tr>
                    <th>رقم الرحلة</th>
                    <th>مكان المغادرة</th>
                    <th>مكان الوصول</th>
                    <th>تاريخ الرحلة</th>
                    <th>وقت الرحلة</th>
                    <th>الدرجة</th>
                    <th>اختيار</th>
                </tr>
                <?php foreach ($flights as $flight): ?>
                    <tr>
                        <td><?php echo $flight->F_no; ?></td>
                        <td><?php echo $flight->from_country; ?></td>
                        <td><?php echo $flight->to_country; ?></td>
                        <td><?php echo $flight->F_Date; ?></td>
                        <td><?php echo $flight->D_Time; ?></td>
                        <td><?php echo $class; ?></td>
                        <td>
                            <input type="radio" name="flight_id" value="<?php echo $flight->F_no; ?>" required>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>
            <!-- إضافة الحقل المخفي لتمرير قيمة الدرجة -->
            <input type="hidden" name="class" value="<?php echo $class; ?>">
        
            <label for="passport_no">رقم جواز السفر:</label>
            <input type="text" name="passport_no" required><br>
        
            <label for="pass_name">اسم المسافر:</label>
            <input type="text" name="pass_name" required><br>
        
            <label for="email">البريد الإلكتروني:</label>
            <input type="email" name="email" required><br>
        
            <input type="submit" name="book" value="حجز">
        </form>
        

    <?php } ?>
</body>
</html>
