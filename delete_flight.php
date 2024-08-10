<?php
include_once("connection.php");

function display_delete_flight_form($conn) { ?>
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
<?php }

function delete_flight($conn, $F_no) {
    try {
        $query = "DELETE FROM Flight WHERE F_no = $F_no";
        $conn->exec($query);
        echo "Flight deleted successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['delete_flight'])) {
    $F_no = $_POST['F_no'];
    delete_flight($conn, $F_no);
} else {
    display_delete_flight_form($conn);
}
?>

