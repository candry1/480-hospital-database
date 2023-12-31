<!-- TODO: go through and fix all tag names and variable names so that it matches the file!! (patients not nurses, etc) -->
<html>
    <head>
        <link rel="stylesheet" href="patient-vaccination-scheduling.css"> 
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

            $patient_username = "";
            $patient_ssn= -1;
            $patient_name = "";

            if (isset($_SESSION['username'])) {
                $patient_username = $_SESSION['username'];
                $stmt = $conn->prepare("SELECT ssn, Fname FROM patient WHERE user_name = ?");
                $stmt->bind_param("s", $patient_username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $patient_ssn = $row["ssn"];
                    $patient_name = $row["Fname"];
                } else {
                    echo "Patient not found";
                }
            }

        ?>

        <title>Vaccination Scheduling</title>
    </head>

    <div class="availability-info">
        <?php
            //$vaccine_name = "" ; 
            if(isset($_POST["schedule-vaccine"])){

                $stmt = "SELECT DISTINCT(the_date) FROM nurse_availability";
                $result = $conn->query($stmt);

                echo '<h2>Available Dates</h2>';
                echo "<a href='http://localhost/480-hospital-database'>Log Out</a><br><br>";
                echo '<p>Choose a date:</p>';

                if ($result->num_rows > 0) {
                    echo '<form method="post" action="patient-vaccination-scheduling.php">';

                    while($row = $result->fetch_assoc()) {
                        echo '<input type="radio" name="available_date_option" value="' .  $row["the_date"]. '"> '. $row["the_date"]. '<br><br>';
                    }
                    echo '<input type="submit" name="availability-date-submit" id="input">';
                    echo '</form>';
                } else {
                    echo "No available dates for scheduling!";
                }
            }else if(isset($_POST["availability-date-submit"])){
                $date = $_POST['available_date_option'];
                

                $stmt = "SELECT vaccine_name FROM vaccine";
                $result = $conn->query($stmt);

                echo '<h2>Available Vaccines</h2>';
                echo '<p>Choose one:</p>';
                if ($result->num_rows > 0) {
                    echo '<form method="post" action="patient-vaccination-scheduling.php">';
                    echo '<input type="hidden" name="selected_date" value="' . $date . '">';

                    while($row = $result->fetch_assoc()) {
                        echo '<input type="radio" name="available_vaccine_option" value="' .  $row["vaccine_name"]. '"> '. $row["vaccine_name"]. '<br><br>';
                       
                        //console.log($vaccine_name); 
                    }
                    echo '<input type="submit" name="availability-vaccine-submit" id="input">';
                    
                    echo '</form>';
                } else {
                    echo "No available vaccine for scheduling!";
                }

            }else if(isset($_POST['availability-vaccine-submit'])){
                $date = $_POST['selected_date'];
                $vaccine_name = $_POST['available_vaccine_option']; 
                echo "$vaccine_name"; 
            
                //this works bc we tested it on num_of_patients < 1, and only 1 time slot showed where the num_of_patients was 0. should also work with 100
                $stmt = $conn->prepare("SELECT time_slot FROM schedule WHERE the_date = ? AND time_slot not in (SELECT time_slot from patient_vaccination_schedule where the_date = ? and ssn = ?) and num_of_patients < 100 and num_of_patients < num_of_nurses * 10" );
                $stmt->bind_param("ssi", $date, $date, $patient_ssn);
                $stmt->execute();
                $result = $stmt->get_result();
            
                echo '<h2>Available Timeslots</h2>';
                echo "<a href='http://localhost/480-hospital-database'>Log Out</a><br><br>";
                echo '<p>Choose a time to schedule yourself for. If you need more than one, redo the form:</p>';
            
                if ($result->num_rows > 0) {
                    echo '<form method="post" action="patient-vaccination-scheduling.php">';
                    echo '<input type="hidden" name="selected_date" value="' . $date . '">';
                    echo '<input type="hidden" name="selected_vac" value="' . $vaccine_name . '">';
            
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
                $vaccine_name = $_POST['selected_vac']; 

                // DONE: get which vaccine they're signing up for, and add that to the schedule below(vaccine_name)
                // TODO: DONE don't allow them to sign up for a vaccine that isn't available (num_available = 0)
            
                //$stmt = $conn->prepare("INSERT INTO patient_vaccination_schedule (ssn, the_date, time_slot) VALUES (?, ?, ?); select num_available from vaccine where num_available >0");
                //$stmt->bind_param("iss", $patient_ssn, $date, $time);
                
                 //$sqlCheckAvailability = "SELECT num_available FROM vaccine WHERE num_available > 0 and vaccine_name = ?";

                 $sqlCheckAvailability = $conn->prepare("SELECT num_available FROM vaccine WHERE num_available > 0 and vaccine_name = ?");
                $sqlCheckAvailability->bind_param("s", $vaccine_name);

                //$result = $conn->execute($sqlCheckAvailability);
                 $sqlCheckAvailability->execute();
                 $result= $sqlCheckAvailability->get_result();

            
                
                if ($result && $result->num_rows > 0) {
                    // There are available vaccines, so you can proceed with the INSERT
                    $sqlInsert = "INSERT INTO patient_vaccination_schedule (ssn, the_date, time_slot,vaccine_name) VALUES (?, ?, ?,?)";
                
                    $stmt = $conn->prepare($sqlInsert);
                    $stmt->bind_param("isss", $patient_ssn, $date, $time,$vaccine_name);
                    if (!$stmt->execute()) {
                        echo "Error updating availability: " . $stmt->error;
                    }
                        
                    // $conn->query("UPDATE vaccine SET num_available = num_available - 1  AND num_on_hold = num_on_hold + 1 WHERE num_available > 0 and vaccine_name = ?");
                    $stmt = $conn->prepare("SELECT num_on_hold,num_available from vaccine where vaccine_name = ? ;");
                    $stmt->bind_param("s", $vaccine_name);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        if( $row['num_available'] - 1 < 0){
                            $num_available = 0;
                        } else {
                            $num_available= $row['num_available'] - 1;
                            $num_on_hold = $row['num_on_hold'] + 1;
                        }

                    
                        $stmt = $conn->prepare("UPDATE vaccine set  num_available = ? , num_on_hold = ? where vaccine_name = ?;");
                        $stmt->bind_param("iis", $num_available,$num_on_hold,$vaccine_name);
                        $stmt->execute();
                    }

                }else {
                    // No available vaccines, handle this situation as needed
                    echo "No available vaccines.";
                }
            

                $stmt = $conn->prepare("SELECT num_of_patients from schedule where the_date = ? and time_slot = ?;");
                $stmt->bind_param("ss", $date, $time);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $num_of_nurses = $row['num_of_patients'] + 1;

                    $stmt = $conn->prepare("UPDATE schedule set num_of_patients = ? where the_date = ? and time_slot = ?;");
                    $stmt->bind_param("iss", $num_of_nurses, $date, $time);

                    // TODO: be sure to upadte num_available and num_on_hold in the table as well

                    if ($stmt->execute()) {
                        echo "<br>Scheduling successful!";
                        header("Location: patient-home.php");
                    } else {
                        echo "Error updating availability: " . $stmt->error;
                    }
                }
            }else if(isset($_POST["cancel-vaccine"])){
                $stmt = "SELECT DISTINCT(the_date) FROM patient_vaccination_schedule where ssn = $patient_ssn";
                $result = $conn->query($stmt);

                echo '<h2>Scheduled Times</h2>';
                echo "<a href='http://localhost/480-hospital-database'>Log Out</a><br><br>";
                echo '<p>Choose a date to delete from your schedule:</p>';

                if ($result->num_rows > 0) {
                    echo '<form method="post" action="patient-vaccination-scheduling.php">';

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
            
                $stmt = $conn->prepare("SELECT time_slot FROM patient_vaccination_schedule WHERE the_date = ? and ssn = ?");
                $stmt->bind_param("si", $date, $patient_ssn);
                $stmt->execute();
                $result = $stmt->get_result();
            
                echo '<br><br><h2>Timeslots to delete</h2>';
                echo "<a href='http://localhost/480-hospital-database'>Log Out</a><br><br>";
                echo '<p>Choose a time to delete yourself from. If you need more than one, redo the form:</p>';
            
                if ($result->num_rows > 0) {
                    echo '<form method="post" action="patient-vaccination-scheduling.php">';
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
            
                $stmt = $conn->prepare("DELETE from patient_vaccination_schedule where ssn = ? and the_date = ? and time_slot = ?;");
                $stmt->bind_param("iss", $patient_ssn, $date, $time);
            
                if (!$stmt->execute()) {
                    echo "Error canceling availability: " . $stmt->error;
                }
            
                $stmt = $conn->prepare("SELECT num_of_patients from schedule where the_date = ? and time_slot = ?;");
                $stmt->bind_param("ss", $date, $time);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if( $row['num_of_patients'] - 1 < 0){
                        $num_of_nurses = 0;
                    } else {
                        $num_of_nurses = $row['num_of_patients'] - 1;
                    }

                    $stmt = $conn->prepare("UPDATE schedule set num_of_patients = ? where the_date = ? and time_slot = ?;");
                    $stmt->bind_param("iss", $num_of_nurses, $date, $time);

                    if ($stmt->execute()) {
                        echo "<br>Update successful!";
                        header("Location: patient-home.php");
                    } else {
                        echo "Error canceling availability: " . $stmt->error;
                    }
                }
            }
        
        ?>
    </div>
</html>