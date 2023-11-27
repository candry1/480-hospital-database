<html>
    <head>
        <link rel="stylesheet" href="vaccination_processing.css">
        <?php
            session_start();
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "final-project-2";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $nurse_username = "";
            $nurse_eid = -1;
            $nurse_name = "";

            if (isset($_SESSION['username'])) {
                $nurse_username = $_SESSION['username'];
                $stmt = $conn->prepare("SELECT eid, Fname FROM nurse WHERE user_name = ?");
                $stmt->bind_param("s", $nurse_username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $nurse_eid = $row["eid"];
                    $nurse_name = $row["Fname"];
                } else {
                    echo "Nurse not found";
                }
            } else{
                echo "something went wrong";
            }

        ?>
        <?php echo "<title>Complete Vaccination</title>"?>

    </head>

    <h1>Vaccinations To Complete</h1>
    <br>
    <?php
        
    ?>
    
    <?php
        if(isset($_POST['do-vaccination'])){
            echo "<h3>Choose a date from your scheduled days:</h3>";
            $stmt = "SELECT * FROM nurse_availability WHERE eid = $nurse_eid";
            $result = $conn->query($stmt);

            if ($result->num_rows > 0) {
                echo '<form method="post" action="vaccination_processing.php">';

                while($row = $result->fetch_assoc()) {
                    $date = $row["the_date"];

                    echo '<input type="radio" name="vaccination_date_option" value="' .  $date. '"> '. $date. '<br><br>';
                }
                echo '<input type="submit" name="vaccination_date_submit" id="input">';
                echo '</form>';
            } else {
                echo "0 results";
            }
        } else if(isset($_POST['vaccination_date_submit'])){
            $date = $_POST['vaccination_date_option'];

            echo "<h3>Choose a time from your day $date:</h3>";

            $stmt = $conn->prepare("SELECT time_slot FROM nurse_availability WHERE eid = ? and the_date = ?");
            $stmt->bind_param("is", $nurse_eid, $date);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<form method="post" action="vaccination_processing.php">';

                while($row = $result->fetch_assoc()) {
                    $time = $row["time_slot"];
                    
                    // TODO: select patient_name, time slot from patient_schedule table where date = date and time = time!!

                    // $stmt = "SELECT * FROM schedule WHERE the_date = ?";
                    // $result = $conn->query($stmt);

                    // if ($result->num_rows > 0) {
                    //     echo '<form method="post" action="vaccination_processing.php">';

                    //     while($row = $result->fetch_assoc()) {
                    //         $date = $row["the_date"];
                    //         $time = $row["time_slot"];

                            echo '<input type="radio" name="vaccination_time_option" value="' .  $time. '"> '. $time. '<br><br>';

                    //         // echo "
                    //         // <tr>
                    //         //     <td>" . $row["the_date"]. "</td>
                    //         //     <td>" . $row["time_slot"]. "</td>
                    //         // </tr>";
                    //     }
                    //     // echo '<input type="submit" name="vaccination_date_submit" id="input">';
                    //     echo '</form>';
                    // } else {
                    //     echo "0 results";
                    // }
                }

                echo '<input type="submit" name="vaccination_time_submit" id="input">';
            } else {
                echo "No scheduled times found for you on this date";
            }
        } else if(isset($_POST['vaccination_time_submit'])){
            // based on name and time slot, create a vaccine record
            // decrease # on-hol
            // decrease total
            // mark vaccination as done
            //
        }
    ?>
</html>