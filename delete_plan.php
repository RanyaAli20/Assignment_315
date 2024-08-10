<?php
include_once("connection.php");

// دالة لعرض النموذج الذي يحتوي على قائمة اختيار الشركة
function display_company_selection_form($conn) {
    ?>
    <form method="post" action="#">
        <label for="Comp_Name">Select Company Name:</label>
        <select name="Comp_Name" required>
            <?php
            $sql = "SELECT DISTINCT Comp_Name FROM plan_info";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['Comp_Name']}'>{$row['Comp_Name']}</option>";
            }
            ?>
        </select>
        <input type="submit" name="select_company" value="Select Company">
    </form>
    <?php
}

// دالة لعرض نموذج اختيار الطائرات باستخدام مربعات اختيار checkbox
function display_planes_selection_form($conn, $Comp_Name) {
    ?>
    <form method="post" action="#">
        <label>Select Planes to Delete:</label><br>
        <?php
        $sql = "SELECT P_no, Model FROM plan_info WHERE Comp_Name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$Comp_Name]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<input type='checkbox' name='planes_to_delete[]' value='{$row['P_no']}'> {$row['Model']}<br>";
        }
        ?>
        <input type="submit" name="delete_planes" value="Delete Selected Planes">
    </form>
    <?php
}

function delete_selected_planes($conn, $planes_to_delete) {
    try {
        // تحويل مصفوفة أرقام الطائرات إلى سلسلة نصية من القيم مفصولة بفواصل
        $planes_ids = implode(',', $planes_to_delete);
        
        // كتابة استعلام الحذف مع تضمين القيم مباشرة في الاستعلام
        $sql = "DELETE FROM plan_info WHERE P_no IN ($planes_ids)";
        
        // تنفيذ الاستعلام
        $conn->exec($sql);
        
        echo "Selected planes deleted successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Delete Planes</title>
</head>
<body>
<h1>Delete Planes</h1>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['select_company'])) {
        // إذا تم اختيار الشركة
        $Comp_Name = $_POST['Comp_Name'];
        display_planes_selection_form($conn, $Comp_Name);
    } elseif (isset($_POST['delete_planes'])) {
        // إذا تم اختيار الطائرات لحذفها
        if (!empty($_POST['planes_to_delete'])) {
            $planes_to_delete = $_POST['planes_to_delete'];
            delete_selected_planes($conn, $planes_to_delete);
        } else {
            echo "No planes selected for deletion.";
        }
    }
} else {
    display_company_selection_form($conn);
}
?>

</body>
</html>
