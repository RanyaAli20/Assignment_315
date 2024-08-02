<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Add Flight</title>
</head>
<body>
<h1>Add Flight</h1>

<form method="post" action="add_flight.php">
    <label for="F_no">Flight Number:</label>
    <input type="text" name="F_no" required><br>

    <label for="P_no">Plane Number:</label>
    <input type="text" name="P_no" required><br>

    <label for="from_C_no">From City Code:</label>
    <input type="text" name="from_C_no" required><br>

    <label for="to_C_no">To City Code:</label>
    <input type="text" name="to_C_no" required><br>

    <label for="D_time">Departure Time:</label>
    <input type="datetime-local" name="D_time" required><br>

    <label for="F_Date">Flight Date:</label>
    <input type="date" name="F_Date" required><br>

    <label for="Ar_time">Arrival Time:</label>
    <input type="datetime-local" name="Ar_time" required><br>

    <label for="F_prise">First Class Price:</label>
    <input type="number" name="F_prise" required><br>

    <label for="E_prise">Economy Price:</label>
    <input type="number" name="E_prise" required><br>

    <label for="Res_num_F">Reserved First Class Seats:</label>
    <input type="number" name="Res_num_F" required><br>

    <label for="Res_num_E">Reserved Economy Seats:</label>
    <input type="number" name="Res_num_E" required><br>

    <input type="submit" name="add_flight" value="Add Flight">
</form>

<?php
include_once("connection.php");

if (isset($_POST['add_flight'])) {
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
        $sql = "INSERT INTO flight (F_no, P_no, from_C_no, to_C_no, D_time, F_Date, Ar_time, F_prise, E_prise, Res_num_F, Res_num_E)
                VALUES ('$F_no', '$P_no', '$from_C_no', '$to_C_no', '$D_time', '$F_Date', '$Ar_time', $F_prise, $E_prise, $Res_num_F, $Res_num_E)";
        $conn->exec($sql);
        echo "Flight added successfully!";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
</body>
</html>
