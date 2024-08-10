<?php
include_once("connection.php");

// دالة لعرض نموذج تحديث الطائرة
function display_form_update($v,$conn) { ?>
    <form method="post" action="#">
        <table border="1">
            <tr>
                <td>Plane Number</td>
                <td><input type="hidden" name="P_no" value="<?= htmlspecialchars($v['P_no']); ?>"><?= htmlspecialchars($v['P_no']); ?></td>
            </tr>

            <tr>
                <td>Model</td>
                <td><input type="text" name="Model" value="<?= htmlspecialchars($v['Model']); ?>" required></td>
            </tr>

            <tr>
                <td>Number of First Class Seats</td>
                <td><input type="number" name="F_Num_seats" value="<?= htmlspecialchars($v['F_Num_seats']); ?>" required></td>
            </tr>

            <tr>
                <td>Number of Economy Seats</td>
                <td><input type="number" name="E_Num_seats" value="<?= htmlspecialchars($v['E_Num_seats']); ?>" required></td>
            </tr>

            <tr>
                <td>Company Name</td>
                <td>
                    <input list="company_list" name="Comp_Name" value="<?= htmlspecialchars($v['Comp_Name']); ?>" required>
                    <datalist id="company_list">
                        <?php 
                        try {
                            $query = "SELECT DISTINCT Comp_Name FROM plan_info";
                            $rows = $conn->query($query);
                            $all_rows = $rows->fetchAll();
                            foreach($all_rows as $row) { ?>
                                <option value="<?= htmlspecialchars($row['Comp_Name']); ?>">
                            <?php }
                        } catch(PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        } ?>
                    </datalist>
                </td>
            </tr>

            <tr>
                <td>Nationality</td>
                <td>
                    <input list="nationality_list" name="Nationality" value="<?= htmlspecialchars($v['Nationality']); ?>" required>
                    <datalist id="nationality_list">
                        <?php 
                        try {
                            $query = "SELECT DISTINCT Nationality FROM plan_info";
                            $rows = $conn->query($query);
                            $all_rows = $rows->fetchAll();
                            foreach($all_rows as $row) { ?>
                                <option value="<?= htmlspecialchars($row['Nationality']); ?>">
                            <?php }
                        } catch(PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        } ?>
                    </datalist>
                </td>
            </tr>

            <tr>
                <td align="center" colspan="2"><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
<?php }

// دالة للحصول على الطائرات حسب اسم الشركة
function get_planes_by_company($conn, $Comp_Name) {
    try {
        $query = "SELECT P_no, Model FROM plan_info WHERE Comp_Name = :Comp_Name";
        $stmt = $conn->prepare($query);
        $stmt->execute([':Comp_Name' => $Comp_Name]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

// دالة للحصول على معلومات الطائرة بناءً على رقم الطائرة
function get_plane_info($conn, $P_no) {
    try {
        $query = "SELECT * FROM plan_info WHERE P_no = :P_no";
        $stmt = $conn->prepare($query);
        $stmt->execute([':P_no' => $P_no]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

// دالة لعرض نموذج البحث عن الشركة
function display_form_search($conn) { ?>
    <form method="post" action="#">
        <label for="Comp_Name">Select Company Name to Update Plane:</label>
        <select name="Comp_Name" required>
            <?php
            $sql = "SELECT DISTINCT Comp_Name FROM plan_info";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['Comp_Name']}'>{$row['Comp_Name']}</option>";
            }
            ?>
        </select>
        <input type="submit" name="button_getid" value="Select Plane">
    </form>
<?php }

// دالة لعرض خيارات الطائرات لاختيار واحدة
function display_plane_selection($planes) { ?>
    <form method="post" action="#">
        <label>Select Plane Model:</label>
        <?php foreach ($planes as $plane) { ?>
            <input type="radio" id="P_no_<?= $plane['P_no']; ?>" name="P_no" value="<?= $plane['P_no']; ?>" required>
            <label for="P_no_<?= $plane['P_no']; ?>"><?= $plane['Model']; ?></label><br>
        <?php } ?>
        <input type="submit" name="select_plane" value="Select Plane">
    </form>
<?php }

// دالة لتحديث معلومات الطائرة
function update_plane_info($conn, $P_no, $Model, $F_Num_seats, $E_Num_seats, $Comp_Name, $Nationality) {
    try {
        // تأمين القيم لتجنب أخطاء SQL Injection
        $Model = $conn->quote($Model);
        $F_Num_seats = (int)$F_Num_seats;
        $E_Num_seats = (int)$E_Num_seats;
        $Comp_Name = $conn->quote($Comp_Name);
        $Nationality = $conn->quote($Nationality);
        $P_no = (int)$P_no;

        // كتابة الاستعلام
        $query = "UPDATE plan_info 
                  SET Model = $Model, 
                      F_Num_seats = $F_Num_seats, 
                      E_Num_seats = $E_Num_seats, 
                      Comp_Name = $Comp_Name, 
                      Nationality = $Nationality 
                  WHERE P_no = $P_no";

        // تنفيذ الاستعلام
        $conn->exec($query);
        echo "Plane updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


?>
<html>
<head>
    <title>Update Plane</title>
</head>
<body>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    display_form_search($conn);
} elseif (isset($_POST['button_getid'])) {

    $comp_name = $_POST['Comp_Name'];
    $planes = get_planes_by_company($conn, $comp_name);
    display_plane_selection($planes);
} elseif (isset($_POST['select_plane'])) {
    $P_no = $_POST['P_no'];
    $v = get_plane_info($conn, $P_no);
    display_form_update($v,$conn);
} elseif (isset($_POST['update'])) {
    $P_no = $_POST['P_no'];
    $Model = $_POST['Model'];
    $F_Num_seats = $_POST['F_Num_seats'];
    $E_Num_seats = $_POST['E_Num_seats'];
    $Comp_Name = $_POST['Comp_Name'];
    $Nationality = $_POST['Nationality'];

    update_plane_info($conn, $P_no, $Model, $F_Num_seats, $E_Num_seats, $Comp_Name, $Nationality);

}
?>
</body>
</html>
