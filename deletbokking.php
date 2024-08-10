<?php
include_once("connection.php");
// استدعاء ملف الاتصال بقاعدة البيانات
 // تأكد من تضمين ملف الاتصال بقاعدة البيانات

// دالة لحذف الحجز
function cancel_reservation($res_no, $conn) {
    $sql = "DELETE FROM Reservation_flight WHERE Res_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$res_no]);
    return $stmt->rowCount() > 0; // ترجع true إذا تم إلغاء الحجز بنجاح
}

// دالة للحصول على الحجوزات الحالية
function get_current_reservations($passport_no, $conn) {
    $sql = "SELECT * FROM Reservation_flight WHERE Passport_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$passport_no]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

// التعامل مع البيانات المستلمة من النموذج
function handle_post_request($conn) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['cancel'])) {
            $res_no = $_POST['res_no'];
            if (cancel_reservation($res_no, $conn)) {
                return "تم إلغاء الحجز بنجاح!";
            } else {
                return "حدث خطأ أثناء إلغاء الحجز.";
            }
        }
    }
    return null;
}

// تخزين الرسالة الناتجة عن المعالجة
$message = handle_post_request($conn);

// الحصول على الحجوزات الحالية للمستخدم
$reservations = get_current_reservations($_SESSION['passport_no'], $conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>إلغاء حجز رحلة</title>
</head>
<body>
    <h1>حجوزاتك الحالية</h1>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    
    <?php if (count($reservations) > 0): ?>
        <form method="post">
            <table border="1">
                <tr>
                    <th>رقم الحجز</th>
                    <th>رقم الرحلة</th>
                    <th>اسم المسافر</th>
                    <th>البريد الإلكتروني</th>
                    <th>الدرجة</th>
                    <th>إلغاء</th>
                </tr>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo $reservation->Res_no; ?></td>
                        <td><?php echo $reservation->F_no; ?></td>
                        <td><?php echo $reservation->pass_Name; ?></td>
                        <td><?php echo $reservation->Email; ?></td>
                        <td><?php echo $reservation->Class; ?></td>
                        <td>
                            <input type="radio" name="res_no" value="<?php echo $reservation->Res_no; ?>" />
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>
            <input type="submit" name="cancel" value="إلغاء الحجز">
        </form>
    <?php else: ?>
        <p>لا توجد حجوزات حالياً.</p>
    <?php endif; ?>
</body>
</html>
