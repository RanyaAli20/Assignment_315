<?php
include_once("connection.php");
// استدعاء اتصال قاعدة البيانات
 // تأكد من تضمين ملف الاتصال بقاعدة البيانات

// التعامل مع البيانات المستلمة من النموذج
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['search'])) {
        // استلام بيانات البحث عن الرحلات
        $from = $_POST['from'];
        $to = $_POST['to'];
        $date = $_POST['date'];

        // استعلام للبحث عن الرحلات
        $sql = "SELECT * FROM Flight WHERE from_C_no = ? AND to_C_no = ? AND F_Date = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$from, $to, $date]);
        $flights = $stmt->fetchAll(PDO::FETCH_OBJ);
    } elseif (isset($_POST['book'])) {
        // استلام بيانات حجز الرحلة
        $flight_id = $_POST['flight_id'];
        $passenger_name = $_POST['passenger_name'];
        $passport_no = $_POST['passport_no'];
        $email = $_POST['email'];
        $class = $_POST['class']; // E/F

        // إدراج بيانات الحجز في قاعدة البيانات
        $sql = "INSERT INTO Reservation_flight (F_no, pass_Name, Passport_no, Email, Class) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$flight_id, $passenger_name, $passport_no, $email, $class]);

        echo "تم حجز الرحلة بنجاح!";
        exit; // إنهاء التنفيذ بعد إدراج الحجز
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>حجز الرحلات</title>
</head>
<body>
    <h1>بحث عن رحلات</h1>
    <form method="post">
        <label for="from">مكان المغادرة:</label>
        <input type="text" id="from" name="from" required>
        <br>
        <label for="to">مكان الوصول:</label>
        <input type="text" id="to" name="to" required>
        <br>
        <label for="date">تاريخ الرحلة:</label>
        <input type="date" id="date" name="date" required>
        <br>
        <input type="submit" name="search" value="بحث">
    </form>

    <?php if (isset($flights)): ?>
        <h1>نتائج البحث</h1>
        <form method="post">
            <table border="1">
                <tr>
                    <th>Select</th>
                    <th>رقم الرحلة</th>
                    <th>مكان المغادرة</th>
                    <th>مكان الوصول</th>
                    <th>تاريخ الرحلة</th>
                    <th>سعر الدرجة الأولى</th>
                </tr>
                <?php foreach ($flights as $flight): ?>
                    <tr>
                        <td><input type="radio" name="flight_id" value="<?php echo $flight->F_no; ?>" /></td>
                        <td><?php echo $flight->F_no; ?></td>
                        <td><?php echo $flight->from_C_no; ?></td>
                        <td><?php echo $flight->to_C_no; ?></td>
                        <td><?php echo $flight->F_Date; ?></td>
                        <td><?php echo $flight->F_prise; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <h1>تفاصيل الحجز</h1>
            <label for="passenger_name">اسم المسافر:</label>
            <input type="text" id="passenger_name" name="passenger_name" required>
            <br>
            <label for="passport_no">رقم جواز السفر:</label>
            <input type="text" id="passport_no" name="passport_no" required>
            <br>
            <label for="email">البريد الإلكتروني:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="class">الدرجة:</label>
            <select id="class" name="class">
                <option value="F">الدرجة الأولى</option>
                <option value="E">الدرجة الاقتصادية</option>
            </select>
            <br>
            <input type="submit" name="book" value="حجز">
        </form>
    <?php endif; ?>
</body>
</html>
