<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Delete Flight</title>
</head>
<body>
<h1>Delete Flight</h1>

<form method="post" action="delete_flight.php">
    <label for="F_no">Select Flight Number to Delete:</label>
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
    <input type="submit" name="delete_flight"
