<?php
include_once("connection.php");

function display_form_update($v, $conn) { ?>
    <form method="post" action="#">
        <label for="P_no">Plane Number: <?= $v['P_no']; ?></label>
        <input type="hidden" name="P_no" value="<?= $v['P_no']; ?>" />
        <br>

        <label for="Model">Model:</label>
        <input type="text" id="Model" name="Model" value="<?= $v['Model']; ?>" />
        <br>

        <label for="F_Num_seats">Number of First Class Seats:</label>
        <input type="number" id="F_Num_seats" name="F_Num_seats" value="<?= $v['F_Num_seats']; ?>" />
        <br>

        <label for="E_Num_seats">Number of Economy Seats:</label>
        <input type="number" id="E_Num_seats" name="E_Num_seats" value="<?= $v['E_Num_seats']; ?>" />
        <br>

        <label for="Comp_Name">Company Name:</label>
        <input type="text" id="Comp_Name" name="Comp_Name" value="<?= $v['Comp_Name']; ?>" />
        <br>

        <label for="Nationality">Nationality:</label>
        <input type="text" id="Nationality" name="Nationality" value="<?= $v['Nationality']; ?>" />
        <br>

        <input type="submit" name="update" value="Update" />
    </form>
<?php }

function get_plane_info($conn) {
    $Comp_Name = $_POST['Comp_Name'];
    try {
        $query = "SELECT * FROM plan_info WHERE Comp_Name='$Comp_Name'";
        $rows = $conn->query($query);
        $row = $rows->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    return $row;
}

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
    $v = get_plane_info($conn);
    display_form_update($v, $conn);
} elseif (isset($_POST['update'])) {
    extract($_POST);
    try {
        $query = "UPDATE plan_info SET Model='$Model', F_Num_seats=$F_Num_seats, E_Num_seats=$E_Num_seats, Comp_Name='$Comp_Name', Nationality='$Nationality' WHERE P_no=$P_no";
        $conn->exec($query);
        echo "Plane updated successfully!";
    } catch(PDOException $e) {
        echo $query . "<br>" . $e->getMessage();
    }
}
?>
</body>
</html>
