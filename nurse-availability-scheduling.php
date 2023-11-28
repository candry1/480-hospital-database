<html>
    <head>
        <link rel="stylesheet" href="nurse-availability-scheduling.css">

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
            }

        ?>

        <title>Availablility Page</title>
    </head>

    <div class="availability-info">
        <?php
            if(isset($_POST["add-availability"])){
                $stmt = "SELECT DISTINCT(the_date) FROM schedule";
                $result = $conn->query($stmt);

                echo '<h2>Available Dates</h2>';
                echo "<a href='http://localhost/480-hospital-database'>Log Out</a><br><br>";
                echo "<a href='http://localhost/480-hospital-database/nurse-home.php'>Home</a><br><br>";
                echo '<p>Choose a date to schedule yourself for:</p>';

                if ($result->num_rows > 0) {
                    echo '<form method="post" action="nurse-availability-scheduling.php">';

                    while($row = $result->fetch_assoc()) {
                        echo '<input type="radio" name="available_date_option" value="' .  $row["the_date"]. '"> '. $row["the_date"]. '<br><br>';
                    }
                    echo '<input type="submit" name="availability-date-submit" id="input">';
                    echo '</form>';
                } else {
                    echo "No available dates for scheduling!";
                }
            }else if(isset($_POST['availability-date-submit'])){
                $date = $_POST['available_date_option'];
            
                // and where they're not already signed up for it
                $stmt = $conn->prepare("SELECT time_slot FROM schedule WHERE the_date = ? AND num_of_nurses < 12 and time_slot not in (SELECT time_slot from nurse_availability where the_date = ? and eid = ?)");
                $stmt->bind_param("ssi", $date, $date, $nurse_eid);
                $stmt->execute();
                $result = $stmt->get_result();
            
                echo '<h2>Available Timeslots</h2>';
                echo "<a href='http://localhost/480-hospital-database'>Log Out</a><br><br>";
                echo "<a href='http://localhost/480-hospital-database/nurse-home.php'>Home</a><br><br>";
                echo '<p>Choose a time to schedule yourself for. If you need more than one, redo the form:</p>';
            
                if ($result->num_rows > 0) {
                    echo '<form method="post" action="nurse-availability-scheduling.php">';
                    echo '<input type="hidden" name="selected_date" value="' . $date . '">';
            
                    while($row = $result->fetch_assoc()) {
                        echo '<input type="radio" name="available_time_option" value="' . $row["time_slot"]. '"> '. $row["time_slot"]. '<br><br>';
                    }
            
                    echo '<input type="submit" name="availability-time-submit" id="input">';
                    echo '</form>';
                } else {
                    echo "No available timeslots for this date!";
                }
            } else if(isset($_POST['availability-time-submit'])){
                $date = $_POST['selected_date'];
                $time = $_POST['available_time_option'];
            
                $stmt = $conn->prepare("INSERT INTO nurse_availability (eid, the_date, time_slot) VALUES (?, ?, ?);");
                $stmt->bind_param("iss", $nurse_eid, $date, $time);
            
                if (!$stmt->execute()) {
                    echo "Error updating availability: " . $stmt->error;
                }
            
                $stmt = $conn->prepare("SELECT num_of_nurses from schedule where the_date = ? and time_slot = ?;");
                $stmt->bind_param("ss", $date, $time);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $num_of_nurses = $row['num_of_nurses'] + 1;

                    $stmt = $conn->prepare("UPDATE schedule set num_of_nurses = ? where the_date = ? and time_slot = ?;");
                    $stmt->bind_param("iss", $num_of_nurses, $date, $time);

                    if ($stmt->execute()) {
                        echo "<br>Update successful!";
                        header("Location: nurse-home.php");
                    } else {
                        echo "Error updating availability: " . $stmt->error;
                    }
                }
            }else if(isset($_POST["cancel-availability"])){
                $stmt = "SELECT DISTINCT(the_date) FROM nurse_availability where eid = $nurse_eid";
                $result = $conn->query($stmt);

                echo '<h2>Scheduled Times</h2>';
                echo "<a href='http://localhost/480-hospital-database'>Log Out</a><br><br>";
                echo "<a href='http://localhost/480-hospital-database/nurse-home.php'>Home</a><br><br>";
                echo '<p>Choose a date to delete from your schedule:</p>';

                if ($result->num_rows > 0) {
                    echo '<form method="post" action="nurse-availability-scheduling.php">';

                    while($row = $result->fetch_assoc()) {
                        echo '<input type="radio" name="cancel_date_option" value="' .  $row["the_date"]. '"> '. $row["the_date"]. '<br><br>';
                    }
                    echo '<input type="submit" name="cancel-date-submit" id="input">';
                    echo '</form>';
                } else {
                    echo "No available dates for scheduling!";
                }
            } else if(isset($_POST['cancel-date-submit'])){
                $date = $_POST['cancel_date_option'];
            
                $stmt = $conn->prepare("SELECT time_slot FROM nurse_availability WHERE the_date = ? and eid = ?");
                $stmt->bind_param("si", $date, $nurse_eid);
                $stmt->execute();
                $result = $stmt->get_result();
            
                echo '<br><br><h2>Timeslots to delete</h2>';
                echo "<a href='http://localhost/480-hospital-database'>Log Out</a><br><br>";
                echo "<a href='http://localhost/480-hospital-database/nurse-home.php'>Home</a><br><br>";
                echo '<p>Choose a time to schedule yourself for. If you need more than one, redo the form:</p>';
            
                if ($result->num_rows > 0) {
                    echo '<form method="post" action="nurse-availability-scheduling.php">';
                    echo '<input type="hidden" name="selected_date" value="' . $date . '">';
            
                    while($row = $result->fetch_assoc()) {
                        echo '<input type="radio" name="cancel_time_option" value="' . $row["time_slot"]. '"> '. $row["time_slot"]. '<br><br>';
                    }
            
                    echo '<input type="submit" name="cancel-time-submit" id="input">';
                    echo '</form>';
                } else {
                    echo "No available timeslots for this date!";
                }
            } else if(isset($_POST['cancel-time-submit'])){
                $date = $_POST['selected_date'];
                $time = $_POST['cancel_time_option'];
            
                $stmt = $conn->prepare("DELETE from nurse_availability where eid = ? and the_date = ? and time_slot = ?;");
                $stmt->bind_param("iss", $nurse_eid, $date, $time);
            
                if (!$stmt->execute()) {
                    echo "Error canceling availability: " . $stmt->error;
                }
            
                $stmt = $conn->prepare("SELECT num_of_nurses from schedule where the_date = ? and time_slot = ?;");
                $stmt->bind_param("ss", $date, $time);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if( $row['num_of_nurses'] - 1 < 0){
                        $num_of_nurses = 0;
                    } else {
                        $num_of_nurses = $row['num_of_nurses'] - 1;
                    }

                    $stmt = $conn->prepare("UPDATE schedule set num_of_nurses = ? where the_date = ? and time_slot = ?;");
                    $stmt->bind_param("iss", $num_of_nurses, $date, $time);

                    if ($stmt->execute()) {
                        echo "<br>Update successful!";
                        header("Location: nurse-home.php");
                    } else {
                        echo "Error canceling availability: " . $stmt->error;
                    }
                }
            }
        ?>
    </div>
</html>