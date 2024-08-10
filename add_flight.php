<!DOCTYPE html>
<html>
<head>
    <title>Add Flight</title>
    <link rel="stylesheet" type="text/css" href="css.css"> <!-- ربط ملف CSS -->
</head>
<body>
    
    <div class="container">
    <h1> Add Flight✈️ </h1>
        <?php
        include_once("connection.php");

        function display_add_flight_form($conn) { ?>
            <form method="post" action="#">
                <table border='1'>
                    <tr>
                        <td>Plane Model</td>
                        <td>
                            <select name="Model" required>
                                <?php
                                $sql = "SELECT Model FROM plan_info";
                                $stmt = $conn->query($sql);
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['Model']}'>{$row['Model']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Departure Location</td>
                        <td>
                            <select name="from_C_no" required>
                                <?php
                                $sql = "SELECT C_no, C_Name FROM Country";
                                $stmt = $conn->query($sql);
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['C_no']}'>{$row['C_Name']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Arrival Location</td>
                        <td>                        
                            <select name="to_C_no" required>
                                <?php
                                $sql = "SELECT C_no, C_Name FROM Country";
                                $stmt = $conn->query($sql);
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['C_no']}'>{$row['C_Name']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Departure Time</td>
                        <td><input type="time" name="D_Time" required></td>
                    </tr>

                    <tr>
                        <td>Flight Date</td>
                        <td><input type="date" name="F_Date" required></td>
                    </tr>

                    <tr>
                        <td>Arrival Time</td>
                        <td><input type="time" name="Ar_time" required></td>
                    </tr>

                    <tr>
                        <td>First Class Price</td>
                        <td><input type="number" name="F_prise" required></td>
                    </tr>

                    <tr>
                        <td>Economic Class Price</td>
                        <td><input type="number" name="E_prise" required></td>
                    </tr>

                    <tr>
                        <td>Reserved First Class Seats</td>
                        <td><input type="number" name="Res_num_F" required></td>
                    </tr>

                    <tr>
                        <td>Reserved Economic Class Seats</td>
                        <td><input type="number" name="Res_num_E" required></td>
                    </tr>

                    <tr>
                        <td align='center' colspan='2'><input name="add_flight" type="submit" value="Add Flight"></td>
                    </tr>
                </table>
            </form>
        <?php }

        function add_flight($conn, $Model, $from_C_no, $to_C_no, $D_Time, $F_Date, $Ar_time, $F_prise, $E_prise, $Res_num_F, $Res_num_E) {
            try {
                // الحصول على P_no بناءً على Model
                $sql = "SELECT P_no FROM plan_info WHERE Model = '$Model'";
                $stmt = $conn->query($sql);
                $plane = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($plane) {
                    $P_no = $plane['P_no'];
                    
                    // إدخال البيانات إلى جدول الرحلات
                    $query = "INSERT INTO Flight (P_no, from_C_no, to_C_no, D_Time, F_Date, Ar_time, F_prise, E_prise, Res_num_F, Res_num_E)
                              VALUES ('$P_no', '$from_C_no', '$to_C_no', '$D_Time', '$F_Date', '$Ar_time', '$F_prise', '$E_prise', '$Res_num_F', '$Res_num_E')";
                    $conn->exec($query);
                    echo "Flight added successfully!";
                } else {
                    echo "Plane model not found!";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_flight'])) {
            $Model = $_POST['Model'];
            $from_C_no = $_POST['from_C_no'];
            $to_C_no = $_POST['to_C_no'];
            $D_Time = $_POST['D_Time'];
            $F_Date = $_POST['F_Date'];
            $Ar_time = $_POST['Ar_time'];
            $F_prise = $_POST['F_prise'];
            $E_prise = $_POST['E_prise'];
            $Res_num_F = $_POST['Res_num_F'];
            $Res_num_E = $_POST['Res_num_E'];

            add_flight($conn, $Model, $from_C_no, $to_C_no, $D_Time, $F_Date, $Ar_time, $F_prise, $E_prise, $Res_num_F, $Res_num_E);
        } else {
            display_add_flight_form($conn);
        }
        ?>
    </div>
</body>
</html>
