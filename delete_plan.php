<?php
include_once("connection.php");

function display_delete_form($conn) {
    ?>
    <form method="post" action="delete_plan.php">
        <label for="P_no">Select Plane Name to Delete:</label>
        <select name="P_no" required>
            <?php
            $sql = "SELECT P_no FROM plan_info";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['P_no']}'>{$row['P_no']}</option>";
            }
            ?>
        </select>
        <input type="submit" name="delete_plane" value="Delete Plane">
    </form>
    <?php
}

function delete_plane($P_no, $conn) {
    try {
        $sql = "DELETE FROM plan_info WHERE P_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$P_no]);
        echo "Plane with P_no $P_no deleted successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Delete Plane</title>
</head>
<body>
<h1>Delete Plane</h1>

<?php
if (isset($_POST['delete_plane'])) {
    $P_no = $_POST['P_no'];
    delete_plane($P_no, $conn);
} else {
    display_delete_form($conn);
}
?>

</body>
</html>
