<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Update Flight</title>
</head>
<body>
<h1>Update Flight</h1>

<form method="post" action="update_flight.php">
    <label for="F_no">Select Flight Number to Update:</label>
    <select name="F_no" required>
        <?php
        include_once("connection.php");

        $sql = "SELECT F_no FROM flight";
        $stmt = $conn->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$row['F_no']}'>{$row['F_no']}</option>";
        }
        ?>
    </select>
    <input type="submit" name="select_flight" value="Select Flight">
</form>

<?php
if (isset($_POST['select_flight'])) {
    $F_no = $_POST['F_no'];

    $sql = "SELECT * FROM flight WHERE F_no = :F_no";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':F_no' => $F_no]);
    $flight = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($flight) {
        ?>
        <form method="post" action="update_flight.php">
            <input type="hidden" name="F_no" value="<?= $flight['F_no']; ?>">
            <label for="P_no">Plane Number:</label>
            <input type="text" name="P_no" value="<?= $flight['P_no']; ?>" required><br>

            <label for="from_C_no">From City Code:</label>
            <input type="text" name="from_C_no" value="<?= $flight['from_C_no']; ?>" required><br>

            <label for="to_C_no">To City Code:</label>
            <input type="text" name="to_C_no" value="<?= $flight['to_C_no']; ?>" required><br>

            <label for="D_time">Departure Time:</label>
            <input type="datetime-local" name="D_time" value="<?= date('Y-m-d\TH:i', strtotime($flight['D_time'])); ?>" required><br>

            <label for="F_Date">Flight Date:</label>
            <input type="date" name="F_Date" value="<?= $flight['F_Date']; ?>" required><br>

            <label for="Ar_time">Arrival Time:</label>
            <input type="datetime-local" name="Ar_time" value="<?= date('Y-m-d\TH:i', strtotime($flight['Ar_time'])); ?>" required><br>

            <label for="F_prise">First Class Price:</label>
            <input type="number" name="F_prise" value="<?= $flight['F_prise']; ?>" required><br>

            <label for="E_prise">Economy Price:</label>
            <input type="number" name="E_prise" value="<?= $flight['E_prise']; ?>" required><br>

            <label for="Res_num_F">Reserved First Class Seats:</label>
            <input type="number" name="Res_num_F" value="<?= $flight['Res_num_F']; ?>" required><br>

            <label for="Res_num_E">Reserved Economy Seats:</label>
            <input type="number" name="Res_num_E" value="<?= $flight['Res_num_E']; ?>" required><br>

            <input type="submit" name="update_flight" value="Update Flight">
        </form>
        <?php
    } else {
        echo "Flight not found.";
    }
}

if (isset($_POST['update_flight'])) {
    $F_no = $_POST['F_no'];
    $P_no = $_POST['P_no'];
    $from_C_no = $_POST['from_C_no'];
    $to_C_no = $_POST['to_C_no'];
    $D_time = $_POST['D_time'];
    $F_Date = $_POST['F_Date'];
    $Ar_time = $_POST['Ar_time'];
    $F_prise = $_POST['F_prise'];
    $E_prise = $_POST['E_prise'];
    $Res_num_F = $_POST['Res_num_F'];
    $Res_num_E = $_POST['Res_num_E'];

    try {
        $sql = "UPDATE flight 
                SET P_no = '$P_no', from_C_no = '$from_C_no', to_C_no = '$to_C_no', D_time = '$D_time', 
                    F_Date = '$F_Date', Ar_time = '$Ar_time', F_prise = $F_prise, E_prise = $E_prise, 
                    Res_num_F = $Res_num_F, Res_num_E = $Res_num_E
                WHERE F_no = '$F_no'";
        $conn->exec($sql);
        echo "Flight updated successfully!";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
</body>
</html>
