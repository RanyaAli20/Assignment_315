<?php
include_once("connection.php");

function display_update_flight_form($v, $conn) { ?>
    <form method="post" action="#">
        <input type="hidden" name="F_no" value="<?= htmlspecialchars($v['F_no']); ?>" />
        <table border='1'>
            <tr>
                <td>Plane Number</td>
                <td><input type="text" name="P_no" value="<?= htmlspecialchars($v['P_no']); ?>" required></td>
            </tr>

            <tr>
                <td>Departure Location</td>
                <td>
                    <select name="from_C_no" required>
                        <?php
                        $sql = "SELECT C_no, C_Name FROM Country";
                        $stmt = $conn->query($sql);
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $selected = $v['from_C_no'] == $row['C_no'] ? "selected" : "";
                            echo "<option value='{$row['C_no']}' $selected>{$row['C_Name']}</option>";
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
                        $stmt = $conn->query($sql);  // إعادة استخدام الاستعلام نفسه
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $selected = $v['to_C_no'] == $row['C_no'] ? "selected" : "";
                            echo "<option value='{$row['C_no']}' $selected>{$row['C_Name']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Departure Time</td>
                <td><input type="time" name="D_Time" value="<?= htmlspecialchars($v['D_Time']); ?>" required></td>
            </tr>

            <tr>
                <td>Flight Date</td>
                <td><input type="date" name="F_Date" value="<?= htmlspecialchars($v['F_Date']); ?>" required></td>
            </tr>

            <tr>
                <td>Arrival Time</td>
                <td><input type="time" name="Ar_time" value="<?= htmlspecialchars($v['Ar_time']); ?>" required></td>
            </tr>

            <tr>
                <td>First Class Price</td>
                <td><input type="number" step="0.01" name="F_prise" value="<?= htmlspecialchars($v['F_prise']); ?>" required></td>
            </tr>

            <tr>
                <td>Economic Class Price</td>
                <td><input type="number" step="0.01" name="E_prise" value="<?= htmlspecialchars($v['E_prise']); ?>" required></td>
            </tr>

            <tr>
                <td>Reserved First Class Seats</td>
                <td><input type="number" name="Res_num_F" value="<?= htmlspecialchars($v['Res_num_F']); ?>" required></td>
            </tr>

            <tr>
                <td>Reserved Economic Class Seats</td>
                <td><input type="number" name="Res_num_E" value="<?= htmlspecialchars($v['Res_num_E']); ?>" required></td>
            </tr>

            <tr>
                <td align='center' colspan='2'><input name="update_flight" type="submit" value="Update Flight"></td>
            </tr>
        </table>
    </form>
<?php }

function get_flight_info($conn, $F_no) {
    try {
        $query = "SELECT * FROM Flight WHERE F_no = :F_no";
        $stmt = $conn->prepare($query);
        $stmt->execute([':F_no' => $F_no]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function update_flight($conn, $F_no, $P_no, $from_C_no, $to_C_no, $D_Time, $F_Date, $Ar_time, $F_prise, $E_prise, $Res_num_F, $Res_num_E) {
    try {
        $query = "UPDATE Flight 
                  SET P_no = :P_no, from_C_no = :from_C_no, to_C_no = :to_C_no, D_Time = :D_Time, F_Date = :F_Date, Ar_time = :Ar_time,
                      F_prise = :F_prise, E_prise = :E_prise, Res_num_F = :Res_num_F, Res_num_E = :Res_num_E
                  WHERE F_no = :F_no";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':P_no' => $P_no,
            ':from_C_no' => $from_C_no,
            ':to_C_no' => $to_C_no,
            ':D_Time' => $D_Time,
            ':F_Date' => $F_Date,
            ':Ar_time' => $Ar_time,
            ':F_prise' => $F_prise,
            ':E_prise' => $E_prise,
            ':Res_num_F' => $Res_num_F,
            ':Res_num_E' => $Res_num_E,
            ':F_no' => $F_no
        ]);
        echo "Flight updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['select_flight'])) {
    $F_no = $_POST['F_no'];
    $v = get_flight_info($conn, $F_no);
    display_update_flight_form($v, $conn);
} elseif (isset($_POST['update_flight'])) {
    $F_no = $_POST['F_no'];
    $P_no = $_POST['P_no'];
    $from_C_no = $_POST['from_C_no'];
    $to_C_no = $_POST['to_C_no'];
    $D_Time = $_POST['D_Time'];
    $F_Date = $_POST['F_Date'];
    $Ar_time = $_POST['Ar_time'];
    $F_prise = $_POST['F_prise'];
    $E_prise = $_POST['E_prise'];
    $Res_num_F = $_POST['Res_num_F'];
    $Res_num_E = $_POST['Res_num_E'];
    update_flight($conn, $F_no, $P_no, $from_C_no, $to_C_no, $D_Time, $F_Date, $Ar_time, $F_prise, $E_prise, $Res_num_F, $Res_num_E);
} else {
    ?>
    <form method="post" action="#">
        <label for="F_no">Select Flight Number to Update:</label>
        <select name="F_no" required>
            <?php
            $sql = "SELECT F_no FROM Flight";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['F_no']}'>{$row['F_no']}</option>";
            }
            ?>
        </select>
        <input type="submit" name="select_flight" value="Select Flight">
    </form>
    <?php
}
?>
