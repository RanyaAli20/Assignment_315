<?php
include_once("connection.php");

// عرض نموذج البحث وعرض الرحلات
function search_view_form_radio($conn) {
    if (isset($_POST['search_flights'])) {
        $from_city = $_POST['from_city'];
        $to_city = $_POST['to_city'];

        try {
            $sql = "SELECT * FROM Flight WHERE from_C_no = ? AND to_C_no = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $from_city, $to_city);
            $stmt->execute();
            $result = $stmt->get_result();

            echo '<form method="post" action="book.php">';
            echo "<table border='1'>
                    <tr>
                        <th>رقم الرحلة</th>
                        <th>مكان المغادرة</th>
                        <th>مكان الوصول</th>
                        <th>زمن المغادرة</th>
                        <th>تاريخ الرحلة</th>
                        <th>زمن الوصول</th>
                        <th>سعر الدرجة الأولى</th>
                        <th>اختيار</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['F_no']}</td>
                        <td>{$row['from_C_no']}</td>
                        <td>{$row['to_C_no']}</td>
                        <td>{$row['D_Time']}</td>
                        <td>{$row['F_Date']}</td>
                        <td>{$row['Ar_time']}</td>
                        <td>{$row['F_prise']}</td>
                        <td><input type='radio' name='selected_flight' value='{$row['F_no']}'></td>
                    </tr>";
            }

            echo '<tr><td colspan="8"><input type="submit" name="book_flight" value="اختيار"></td></tr>';
            echo "</table></form>";

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // نموذج البحث
        ?>
        <form method="post" action="">
            <label for="from_city">مكان المغادرة:</label>
            <input type="text" id="from_city" name="from_city" required>
            <br>
            <label for="to_city">مكان الوصول:</label>
            <input type="text" id="to_city" name="to_city" required>
            <br>
            <input type="submit" name="search_flights" value="بحث">
        </form>
        <?php
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>بحث وحجز الرحلات</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>بحث عن الرحلات وحجزها</h1>
    <?php
    search_view_form_radio($conn);
    ?>
</body>
</html>

<?php
$conn = null;

?>
