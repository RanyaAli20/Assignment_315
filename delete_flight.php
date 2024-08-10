<?php
include_once("connection.php");

// دالة لعرض نموذج حذف الرحلة
function display_delete_flight_form($conn) {
    ?>
    <form method="post" action="#">
        <label for="F_no">Select Flight Number to Delete:</label>
        <select name="F_no" required>
            <?php
            $sql = "SELECT F_no FROM Flight";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['F_no']}'>{$row['F_no']}</option>";
            }
            ?>
        </select>
        <input type="submit" name="delete_flight" value="Delete Flight">
    </form>
    <?php
}

// دالة لحذف الرحلة
function delete_flight($conn, $F_no) {
    try {
        $query = "DELETE FROM Flight WHERE F_no = :F_no";
        $stmt = $conn->prepare($query);
        $stmt->execute([':F_no' => $F_no]);
        echo "<p>Flight deleted successfully!</p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Flight</title>
    <link rel="stylesheet" type="text/css" href="delete_flight.css">
</head>
<body>
    <h1>Delete Flight</h1>
    <?php 
    // عرض نموذج الحذف أو تنفيذ عملية الحذف بناءً على الطلب
    if (isset($_POST['delete_flight'])) {
        $F_no = $_POST['F_no'];
        delete_flight($conn, $F_no);
    } else {
        display_delete_flight_form($conn);
    }
    ?>
</body>
</html>
