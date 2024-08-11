<?php 
include_once("connection.php");

// دالة لعرض النموذج
function display_form($conn) { ?>
    <form method="post" action="#">
    <div class="container">
        <table>
            <h1>Add aircraft data🛫 </h1>
            <tr>
                <td>Model</td>
                <td><input type="text" name="Model" required></td>
            </tr>

            <tr>
                <td>Number of First Class Seats</td>
                <td><input type="number" name="F_Num_seats" required></td>
            </tr>

            <tr>
                <td>Number of Economy Seats</td>
                <td><input type="number" name="E_Num_seats" required></td>
            </tr>

            <tr>
                <td>Company Name</td>
                <td>
                    <input list="company_list" name="Comp_Name" required>
                    <datalist id="company_list">
                        <?php 
                        try {
                            $query = "SELECT DISTINCT Comp_Name FROM plan_info";
                            $rows = $conn->query($query);
                            $all_rows = $rows->fetchAll();
                            foreach($all_rows as $row) { ?>
                                <option value="<?php echo htmlspecialchars($row['Comp_Name']); ?>">
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
                    <input list="nationality_list" name="Nationality" required>
                    <datalist id="nationality_list">
                        <?php 
                        try {
                            $query = "SELECT DISTINCT Nationality FROM plan_info";
                            $rows = $conn->query($query);
                            $all_rows = $rows->fetchAll();
                            foreach($all_rows as $row) { ?>
                                <option value="<?php echo htmlspecialchars($row['Nationality']); ?>">
                            <?php }
                        } catch(PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        } ?>
                    </datalist>
                </td>
            </tr>

            <tr>
                <td align='center' colspan='2'><input name="add_plane" type="submit" value="Add Plane"></td>
            </tr>
        </table>
    </form>
                    </div>
<?php 
} // end function 

// دالة لإدخال بيانات الطائرة
function insert_plane($conn) {
    $Model = trim($_POST['Model']);
    $F_Num_seats = $_POST['F_Num_seats'];
    $E_Num_seats = $_POST['E_Num_seats'];
    $Comp_Name = trim($_POST['Comp_Name']);
    $Nationality = trim($_POST['Nationality']);

    // التحقق من صحة البيانات المدخلة
    if (!preg_match('/^[a-zA-Z0-9]+$/', $Model)) {
        echo "نوع الطائرة غير صحيح. يجب أن يكون حروف وأرقام فقط.";
        return;
    }

    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $Comp_Name)) {
        echo "اسم الشركة غير صحيح. يجب أن يكون حروف وأرقام فقط.";
        return;
    }

    if (!preg_match('/^[a-zA-Z]+$/', $Nationality)) {
        echo "الجنسية غير صحيحة. يجب أن تكون حروف فقط.";
        return;
    }

    try {    
        $sql = "INSERT INTO plan_info (Model, F_Num_seats, E_Num_seats, Comp_Name, Nationality)
                VALUES (:Model, :F_Num_seats, :E_Num_seats, :Comp_Name, :Nationality)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':Model' => $Model,
            ':F_Num_seats' => $F_Num_seats,
            ':E_Num_seats' => $E_Num_seats,
            ':Comp_Name' => $Comp_Name,
            ':Nationality' => $Nationality
        ]);
        echo "Plane added successfully!";
    } catch(PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Plane</title>
    <link rel="stylesheet" href="addplan.css"> <!-- ربط ملف CSS -->
</head>
<body>
    <?php
    if (!isset($_POST['add_plane'])) {  
        display_form($conn);
    } else {
        insert_plane($conn);
    }
    ?>
</body>
</html>
