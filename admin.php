<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Admin Page</title>
</head>
<body>
<h1>Welcome, Admin</h1>

<form method="post" action="admin_page.php">
    <label for="P_no">Plane Number:</label>
    <input type="text" name="P_no" required><br>

    <label for="Model">Model:</label>
    <input type="text" name="Model" required><br>

    <label for="F_Num_seats">Number of First Class Seats:</label>
    <input type="number" name="F_Num_seats" required><br>

    <label for="E_Num_seats">Number of Economy Seats:</label>
    <input type="number" name="E_Num_seats" required><br>

    <label for="Comp_Name">Company Name:</label>
    <input type="text" name="Comp_Name" required><br>

    <label for="Nationality">Nationality:</label>
    <input type="text" name="Nationality" required><br>

    <input type="submit" name="add_plane" value="Add Plane">
</form>

<?php
include_once("connection.php");

if (isset($_POST['add_plane'])) {

    $P_no = $_POST['P_no'];
    $Model = $_POST['Model'];
    $F_Num_seats = $_POST['F_Num_seats'];
    $E_Num_seats = $_POST['E_Num_seats'];
    $Comp_Name = $_POST['Comp_Name'];
    $Nationality = $_POST['Nationality'];

    try {
        $sql = "INSERT INTO plan_info (P_no, Model, F_Num_seats, E_Num_seats, Comp_Name, Nationality)
                VALUES ('$P_no', '$Model', $F_Num_seats, $E_Num_seats, '$Comp_Name', '$Nationality')";
        
        $conn->exec($sql);

        echo "Plane added successfully!";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
</body>
</html>
