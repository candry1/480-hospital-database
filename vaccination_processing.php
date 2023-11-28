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
    <a href='http://localhost/480-hospital-database'>Log Out</a>
    <br>
    <a href='http://localhost/480-hospital-database/nurse-home.php'>Home</a>
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
                echo '<input type="hidden" name="selected_date" value="' . $date . '">';

                while($row = $result->fetch_assoc()) {
                    $time = $row["time_slot"];

                    echo '<input type="radio" name="vaccination_time_option" value="' .  $time. '"> '. $time. '<br><br>';
                }
                echo '<input type="submit" name="vaccination_time_submit" id="input">';
                echo '</form>';
            } else {
                echo "No scheduled times found for you on this date";
            }
        } else if(isset($_POST['vaccination_time_submit'])){
            $time = $_POST['vaccination_time_option'];
            $date = $_POST["selected_date"];

            echo "<h3>Choose which patient you would like to serve(listed by SSN):</h3>";
                                
            $stmt = $conn->prepare("SELECT ssn FROM patient_vaccination_schedule WHERE the_date = ? and time_slot = ?  and completed = 0");
            $stmt->bind_param("ss", $date, $time);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<form method="post" action="vaccination_processing.php">';
                echo '<input type="hidden" name="selected_date" value="' . $date . '">';
                echo '<input type="hidden" name="selected_time" value="' . $time . '">';

                while($row = $result->fetch_assoc()) {
                    $patient = $row["ssn"];

                    echo '<input type="radio" name="vaccination_patient_option" value="' .  $patient. '"> '. $patient. '<br><br>';
                }
                echo '<input type="submit" name="vaccination_patient_submit" id="input">';
                echo '</form>';
            } else {
                echo "No patients scheduled for this time";
                sleep(5);
                header("location: nurse-home.php"); 
            }

            
        } else if(isset($_POST['vaccination_patient_submit'])){
            $time = $_POST['selected_time'];
            $date = $_POST["selected_date"];
            $patient_ssn = $_POST['vaccination_patient_option'];

            $stmt = $conn->prepare("SELECT vaccine_name, vaccine_company, dose_num FROM patient_vaccination_schedule WHERE the_date = ? and time_slot = ? and ssn = ?");
            $stmt->bind_param("ssi", $date, $time, $patient_ssn);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $vaccine_name = $row["vaccine_name"];
                    $vaccine_company = $row["vaccine_company"];
                    $dose_num = $row["dose_num"];

                    // execute vaccinatioon record(works)
                    $stmt = $conn->prepare("INSERT into vaccine_record (patient_SSN, employee_ID, vaccine_name, the_date, dose_num, time_slot) VALUES (?,?,?,?,?,?)");
                    $stmt->bind_param("iissis", $patient_ssn, $nurse_eid, $vaccine_name, $date, $dose_num, $time);
                        
                    if (!$stmt->execute()) {
                        echo "Error adding vaccine_record: " . $stmt->error;
                    }

                    //update "num_patients" attribute in schedule
                    $stmt = $conn->prepare("SELECT num_of_patients from schedule where the_date = ? and time_slot = ?;");
                    $stmt->bind_param("ss", $date, $time);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        if( $row['num_of_patients'] - 1 < 0){
                            $num_of_patients = 0;
                        } else {
                            $num_of_patients = $row['num_of_patients'] - 1;
                        }
    
                        $stmt = $conn->prepare("UPDATE schedule set num_of_patients = ? where the_date = ? and time_slot = ?;");
                        $stmt->bind_param("iss", $num_of_patients, $date, $time);
    
                        if (!$stmt->execute()) {
                            echo "Error decreasing num_of_patients count: " . $stmt->error;
                        }
                    }

                    //update "completed" attribute
                    $stmt = $conn->prepare("UPDATE patient_vaccination_schedule set completed = 1 where ssn = ? and the_date = ? and time_slot = ?");
                    $stmt->bind_param("iss", $patient_ssn, $date, $time);
                        
                    if (!$stmt->execute()) {
                        echo "Error updating patient's appointment to completed: " . $stmt->error;
                    }

                    //update "nurse_eid" attribute in this table
                    $stmt = $conn->prepare("UPDATE patient_vaccination_schedule set nurse_eid = ? where ssn = ? and the_date = ? and time_slot = ?");
                    $stmt->bind_param("iiss", $nurse_eid, $patient_ssn, $date, $time);
                        
                    if (!$stmt->execute()) {
                        echo "Error adding nurse_eid to table: " . $stmt->error;
                    }

                    // decrease # on-hol
                    $stmt = $conn->prepare("SELECT num_on_hold from vaccine where vaccine_name = ? and vaccine_company = ?;");
                    $stmt->bind_param("ss", $vaccine_name, $vaccine_company);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $num_on_hold = -1;
                    
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        if( $row['num_on_hold'] - 1 < 0){
                            $num_on_hold = 0;
                        } else {
                            $num_on_hold = $row['num_on_hold'] - 1;
                        }
                    }

                    $stmt = $conn->prepare("UPDATE vaccine set num_on_hold = ? where vaccine_name = ? and vaccine_company = ?");
                    $stmt->bind_param("iss", $num_on_hold, $vaccine_name, $vaccine_company);
                        
                    if (!$stmt->execute()) {
                        echo "Error updating vaccine's on-hold count: " . $stmt->error;
                    }

                    // decrease total
                    $stmt = $conn->prepare("SELECT total_count from vaccine where vaccine_name = ? and vaccine_company = ?;");
                    $stmt->bind_param("ss", $vaccine_name, $vaccine_company);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $total_count = -1;
                    
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        if( $row['total_count'] - 1 < 0){
                            $total_count = 0;
                        } else {
                            $total_count = $row['total_count'] - 1;
                        }
                    }

                    $stmt = $conn->prepare("UPDATE vaccine set total_count = ? where vaccine_name = ? and vaccine_company = ?");
                    $stmt->bind_param("iss", $total_count, $vaccine_name, $vaccine_company);
                        
                    if (!$stmt->execute()) {
                        echo "Error updating vaccine's total count: " . $stmt->error;
                    }
<<<<<<< HEAD

                    // not displaying words
                    echo "<p>You successfully completed a vaccine! Redirecting you home..</p>";
                    sleep(2) ; 
                    header("Location: nurse-home.php");
=======
                    header("location: nurse-home.php"); 
>>>>>>> 0d0cccec60bed7bec81057ee0ee4fab025c37ad6
                    
                }
            } else {
                echo "No information was foun on this patient";
            }
        }
    ?>
</html>