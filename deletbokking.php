<?php
include_once("connection.php");

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
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cancel'])) {
        $res_no = $_POST['res_no'] ?? null; // التأكد من وجود القيمة
        if ($res_no) {
            if (cancel_reservation($res_no, $conn)) {
                $message = "تم إلغاء الحجز بنجاح!";
            } else {
                $message = "حدث خطأ أثناء إلغاء الحجز.";
            }
        } else {
            $message = "يرجى اختيار حجز للإلغاء.";
        }
    } elseif (isset($_POST['passport_no'])) {
        $passport_no = $_POST['passport_no'];
        $reservations = get_current_reservations($passport_no, $conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>إلغاء حجز رحلة</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>إلغاء حجز رحلة</h1>
    <p><?php echo $message; ?></p>
    
    <form method="post">
        <label for="passport_no">رقم جواز السفر:</label>
        <input type="text" id="passport_no" name="passport_no" required>
        <input type="submit" value="عرض الحجوزات">
    </form>

    <?php if (isset($reservations) && count($reservations) > 0): ?>
        <form method="post">
            <table>
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
    <?php elseif (isset($reservations)): ?>
        <p>لا توجد حجوزات حالياً.</p>
    <?php endif; ?>
</body>
</html>
