<!-- http://localhost/480-hospital-database/admin-home.php -->

<html>
    <head>
        <title>Admin Home</title>
        <link rel="stylesheet" href="admin-home.css">
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "final-project-2";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        ?>
    </head>

    <div class="admin-home-page">
        <div class="tab-bar">
            <h2>Welcome to the Admin Homepage!</h2>
            <a href='http://localhost/480-hospital-database'>Log Out</a>
        </div>

        <div class="display-options">
            <div class="full-scheduling-display">
                <br>
                <br>
                <h2>Full Schedule</h2>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Timeslot</th>
                        <th>Number of Nurses Available</th>
                        <th>Number of Patients Scheuled</th>
                    </tr>
                    <?php
                    $stmt = "SELECT * FROM schedule";
                    $result = $conn->query($stmt);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>" . $row["the_date"]. "</td>
                                <td>" . $row["time_slot"]. "</td>
                                <td>" . $row["num_of_nurses"]. "</td>
                                <td>" . $row["num_of_patients"]. "</td>
                            </tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </table>
                <br>
                <br>
            </div>

            <div class="nurse-display">
                <br>
                <br>
                <h2>All Nurses</h2>
                <form method="POST" action="admin-home.php">
                    <input type="submit" name="register-nurse" value="Register Nurse"/>
                    <input type="submit" name="update-nurse" value="Update Nurse"/>
                    <input type="submit" name="delete-nurse" value="Delete Nurse"/>

                    <?php
                        if(isset($_POST['register-nurse'])){
                            echo '<form method="post">';
                            echo "<br><br>";

                            echo '<label for="first-name">First Name:</label>';
                            echo '<input type="text" name="first-name" id="input">';

                            echo '<label for="mi">  MI:</label>';
                            echo '<input type="text" name="mi" id="input">';

                            echo '<label for="last-name">  Last Name:</label>';
                            echo '<input type="text" name="last-name" id="input">';

                            echo "<br><br>";

                            echo '<label for="phone-num">Phone Number(no characters):</label>';
                            echo '<input type="text" name="phone-num" id="input">';

                            echo '<label for="age">  Age:</label>';
                            echo '<input type="text" name="age" id="input">';

                            echo '<label for="gender">  Gender(0=F, 1=M):</label>';
                            echo '<input type="text" name="gender" id="input">';

                            echo '<br><br><label for="street">  Address:</label>';
                            echo '<input type="text" name="street" id="input">';

                            echo '<label for="city">  City:</label>';
                            echo '<input type="text" name="city" id="input">';

                            echo '<label for="state">  State Initials:</label>';
                            echo '<input type="text" name="state" id="input">';

                            echo '<br><br><label for="username">  Username:</label>';
                            echo '<input type="text" name="username" id="input">';

                            echo '<label for="password">  Password:</label>';
                            echo '<input type="password" name="password" id="input">';

                            echo '<button type="submit" name="add-submit">Add Info</button>';
                            echo '</form>';

                        }else if(isset($_POST["add-submit"])){
                            $age = $_POST["age"];
                            $first = $_POST["first-name"];
                            $gender = $_POST["gender"];
                            $last = $_POST["last-name"];
                            $mi = $_POST["mi"];
                            $phone_num = $_POST["phone-num"];
                            $street = $_POST["street"];
                            $city = $_POST["city"];
                            $state = $_POST["state"];
                            $user_name = $_POST["username"];
                            $password = $_POST["password"];

                            $stmt_temp = "select MAX(eid) as max_eid from nurse";
                            $result = $conn->query($stmt_temp);
                            $row = $result->fetch_assoc();
                            $eid = $row['max_eid'] + 1;


                            $stmt = $conn->prepare("INSERT INTO nurse (eid, age, Fname, gender, Lname, MI, phone_number, user_name, street, city, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("iisississss", $eid, $age, $first, $gender, $last, $mi, $phone_num, $user_name, $street, $city, $state);
                            $stmt->execute();

                            $stmt = $conn->prepare("INSERT INTO login_table (user_name, pass_word, user_type) VALUES (?, ?, 2)");
                            $stmt->bind_param("ss",$user_name, $password);
                            $stmt->execute();

                            $stmt->close();
                        } elseif(isset($_POST['update-nurse'])){
                            echo '<form method="post">';
                            echo '<br><br><label for="update-eid">Enter eid:</label>';
                            echo '<input type="text" name="update-eid" id="input"><br><br>';

                            echo '<input type="radio" name="update_type_nurse" value="Fname"> Update First Name <br><br>';
                            echo '<input type="radio" name="update_type_nurse" value="MI"> Update Middle Initial <br><br>';
                            echo '<input type="radio" name="update_type_nurse" value="Lname"> Update Last Name<br><br>';
                            echo '<input type="radio" name="update_type_nurse" value="age"> Update Age<br><br>';
                            // echo '<input type="radio" name="update_type_nurse" value="phone_number"> Update Phone Number<br><br>';
                            echo '<input type="radio" name="update_type_nurse" value="gender"> Update Gender<br><br>';
                            // echo '<input type="radio" name="update_type_nurse" value="street"> Update Address<br><br>';
                            // echo '<input type="radio" name="update_type_nurse" value="city"> Update City<br><br>';
                            // echo '<input type="radio" name="update_type_nurse" value="state"> Update State<br><br>';
                            echo '<input type="radio" name="update_type_nurse" value="user_name"> Update Username<br><br>';
                            echo '<input type="radio" name="update_type_nurse" value="pass_word"> Update Password<br><br>';


                            echo '<br><br><label for="update-info">Enter Updated Info:</label>';
                            echo '<input type="text" name="update-info" id="input"><br><br>';

                            echo '<input type="submit" name="update-submit" id="input">';
                            echo "</form>";

                        } elseif(isset($_POST['update-submit'])){
                            $eid = $_POST["update-eid"];
                            $column = $_POST['update_type_nurse'];
                            $value = $_POST['update-info'];

                            if($_POST['update_type_nurse'] == "age" || $_POST['update_type_nurse'] == "gender"){
                                $stmt = $conn->prepare("UPDATE nurse SET $column = ? WHERE eid = ?");
                                $stmt->bind_param("ii", $value, $eid);
                            } else if($_POST['update_type_nurse'] == "pass_word" ){
                                $temp = $conn->prepare("SELECT user_name from nurse where eid = ?");
                                $temp->bind_param("i", $eid);
                                $temp->execute();
                                $result = $temp->get_result();
                    
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $user_name_to_update = $row["user_name"];

                                    $stmt = $conn->prepare("UPDATE login_table SET pass_word = ? WHERE user_name = ?");
                                    $stmt->bind_param("ss", $value, $user_name_to_update);
                                }
                            } else{
                                if($_POST['update_type_nurse'] == "user_name"){
                                    $temp = $conn->prepare("SELECT user_name from nurse where eid = ?");
                                    $temp->bind_param("i", $eid);
                                    $temp->execute();
                                    $result = $temp->get_result();
                        
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $new_user_name = $value;
                                        $old_user_name = $row["user_name"];

                                        echo "<p>updating $old_user_name to $new_user_name<p>";

                                        $stmt = $conn->prepare("UPDATE login_table SET user_name = ? WHERE user_name = ?");
                                        $stmt->bind_param("ss", $value, $old_user_name);
                                        $value = $new_user_name;

                                        $stmt->execute();
                                    }
                                }
                                $stmt = $conn->prepare("UPDATE nurse SET $column = ? WHERE eid = ?");
                                $stmt->bind_param("si", $value, $eid);
                            }

                            if ($stmt->execute()) {
                                echo "<br>Nurse with eid = $eid update successfully";
                            } else {
                                echo "Error updating nurse: " . $stmt->error;
                            }

                            $stmt->close();
                        }elseif(isset($_POST['delete-nurse'])){
                            echo "<br><br>";

                            echo '<form method="post">';
                            echo '<label for="delete-eid">Enter eid:</label>';
                            echo '<input type="text" name="delete-eid" id="input">';

                            echo '<input type="submit" name="delete-submit" id="input">';
                            echo "</form>";
                        } elseif(isset($_POST['delete-submit'])){
                            $eid = $_POST["delete-eid"];

                            $stmt = $conn->prepare("DELETE FROM nurse WHERE eid = ?");
                            $stmt->bind_param("i", $eid);

                            if ($stmt->execute()) {
                                echo "<br>";
                                echo "Nurse with eid = $eid deleted successfully";
                            } else {
                                echo "Error deleting nurse: " . $stmt->error;
                            }
                            $stmt->close();
                        }
                    ?>
                </form>

                <table>
                    <tr>
                        <th>Name</th>
                        <th>EID</th>
                        <th>Sex(0=F, 1=M)</th>
                        <th>Phone Number</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Username</th>
                        <th>Password</th>
                    </tr>
                    <?php
                    $stmt = "SELECT * FROM nurse";
                    $result = $conn->query($stmt);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $stmt_password = $conn->prepare("SELECT pass_word FROM login_table where user_name = ?");
                            $stmt_password->bind_param("s", $row["user_name"]);
                            $stmt_password->execute();
                            $result_password = $stmt_password->get_result();
                            $password_placement = "";
                    
                            if ($result_password->num_rows > 0) {
                                $password_row = $result_password->fetch_assoc();
                                $password_placement = $password_row["pass_word"];
                            }

                            echo "
                            <tr>
                                <td>" . $row["Fname"]. " " . $row["MI"]. ". " . $row["Lname"]. "</td>
                                <td>" . $row["eid"]. "</td>
                                <td>" . $row["gender"]. "</td>
                                <td>" . $row["phone_number"]. "</td>
                                <td>" . $row["age"]. "</td>
                                <td>" . $row["street"].  ", " . $row["city"] . ", ". $row["state"]."</td>
                                <td>" . $row["user_name"]. "</td>
                                <td>" . $password_placement . "</td>

                            </tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </table>
                <br>
                <br>


                <h2>Nurse Availability Schedule</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>EID</th>
                        <th>Date</th>
                        <th>Time Slot</th>
                    </tr>
                    <?php
                    $stmt = "SELECT * FROM nurse_availability";
                    $result = $conn->query($stmt);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $stmt_password = $conn->prepare("SELECT Fname, Lname FROM nurse where eid = ?");
                            $stmt_password->bind_param("i", $row["eid"]);
                            $stmt_password->execute();
                            $result_password = $stmt_password->get_result();
                            $password_placement = "";
                    
                            if ($result_password->num_rows > 0) {
                                $password_row = $result_password->fetch_assoc();

                                $first_name = $password_row["Fname"];
                                $last_name = $password_row["Lname"];
                            }

                            echo "
                            <tr>
                                <td>" . $first_name. " " . $last_name. "</td>
                                <td>" . $row["eid"]. "</td>
                                <td>" . $row["the_date"].  "</td>
                                <td>" . $row["time_slot"]. "</td>
                            </tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </table>
                <br>
                <br>
            </div>

            <div class="patient-display">
                <h2>Patients</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>SSN</th>
                        <th>Sex(0=F, 1=M)</th>
                        <th>Race</th>
                        <th>Phone Number</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Occupation Class</th>
                        <th>Medical History</th>
                        <th>Username</th>
                    </tr>
                    <?php
                    $stmt = "SELECT * FROM patient";
                    $result = $conn->query($stmt);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>" . $row["Fname"]. " " . $row["MI"]. ". " . $row["Lname"]. "</td>
                                <td>" . $row["ssn"]. "</td>
                                <td>" . $row["gender"]. "</td>
                                <td>" . $row["race"]. "</td>
                                <td>" . $row["phone_number"]. "</td>
                                <td>" . $row["age"]. "</td>
                                <td>" . $row["building_number"]. " " . $row["direction"]. " " . $row["street_name"]. ", " . $row["city"].  ", " . $row["state_initials"]. ", " . $row["zip_code"].  "</td>
                                <td>" . $row["occupation_class"]. "</td>
                                <td>" . $row["medical_history"]. "</td>
                                <td>" . $row["user_name"]. "</td>
                            </tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </table>
                <br>
                <br>

                <h2>Patient Vaccine Schedules</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>SSN</th>
                        <th>Date</th>
                        <th>Time Slot</th>
                        <th>Vaccine</th>
                        <th>Company</th>
                        <th>Dosage Number</th>
                        <th>Completed?</th>
                        <th>EID of Vaccinating Nurse</th>
                    </tr>
                    <?php
                    $stmt = "SELECT * FROM patient_vaccination_schedule";
                    $result = $conn->query($stmt);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $stmt_password = $conn->prepare("SELECT Fname, Lname FROM patient where ssn = ?");
                            $stmt_password->bind_param("i", $row["ssn"]);
                            $stmt_password->execute();
                            $result_password = $stmt_password->get_result();
                            $password_placement = "";
                    
                            if ($result_password->num_rows > 0) {
                                $password_row = $result_password->fetch_assoc();

                                $first_name = $password_row["Fname"];
                                $last_name = $password_row["Lname"];
                            }

                            $stmt_grab_vaccination_scheule_info = $conn->prepare("SELECT completed, nurse_eid FROM patient_vaccination_schedule where ssn = ? and the_date = ? and time_slot = ?");
                            $stmt_grab_vaccination_scheule_info->bind_param("iss", $row["ssn"], $row["the_date"], $row["time_slot"]);
                            $stmt_grab_vaccination_scheule_info->execute();
                            $result = $stmt_grab_vaccination_scheule_info->get_result();
                    
                            if ($result->num_rows > 0) {
                                $info_row = $result->fetch_assoc();

                                $completed = $info_row["completed"];
                                $nurse_eid_completed = $info_row["nurse_eid"];
                            }

                            echo "
                            <tr>
                                <td>" . $first_name. " " .$last_name. "</td>
                                <td>" . $row["ssn"]. "</td>
                                <td>" . $row["the_date"].  "</td>
                                <td>" . $row["time_slot"]. "</td>
                                <td>" . $row["vaccine_name"]. "</td>
                                <td>" . $row["vaccine_company"]. "</td>
                                <td>" . $row["dose_num"]. "</td>
                                <td>" . $completed. "</td>
                                <td>" . $nurse_eid_completed. "</td>
                            </tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </table>

                <br>
                <br>
            </div>


            <div class="vaccine-display">
                <h2>Vaccines</h2>

                <form method="POST" action="admin-home.php">
                    <input type="submit" name="add-vaccine" value="Add Vaccine">
                    <input type="submit" name="update-vaccine" value="Update Vaccine">

                    <?php
                        if(isset($_POST['add-vaccine'])){
                            echo '<form method="post">';
                            echo "<br><br>";

                            echo '<label for="vaccine-name">Vaccine Name:</label>';
                            echo '<input type="text" name="vaccine-name" id="input">';

                            echo '<label for="company-name">  Company Name:</label>';
                            echo '<input type="text" name="company-name" id="input">';

                            echo "<br><br>";

                            echo '<label for="dosage-count">Dosage count:</label>';
                            echo '<input type="text" name="dosage-count" id="input">';

                            echo '<label for="available-count">  Available Count:</label>';
                            echo '<input type="text" name="available-count" id="input">';

                            echo '<label for="on-hold-count">  On-Hold Count:</label>';
                            echo '<input type="text" name="on-hold-count" id="input">';

                            echo '<label for="total-count">  Total Count:</label>';
                            echo '<input type="text" name="total-count" id="input">';
                            
                            echo "<br><br>";
                            echo '<label for="description">  Description:</label>';
                            echo '<input type="text" name="description" id="input">';

                            echo '<button type="submit" name="add-vaccine-submit">Add Info</button>';
                            echo '</form>';

                        }else if(isset($_POST["add-vaccine-submit"])){
                            $vaccine_name = $_POST["vaccine-name"];
                            $company_name = $_POST["company-name"];
                            $dosage_count = $_POST["dosage-count"];
                            $available_count = $_POST["available-count"];
                            $on_hold_count = $_POST["on-hold-count"];
                            $total_count = $_POST["total-count"];
                            $description = $_POST["description"];       

                            $stmt = $conn->prepare("INSERT INTO vaccine (vaccine_name, vaccine_company, num_dose, total_count, num_available, num_on_hold, text_desc) VALUES (?, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("ssiiiis", $vaccine_name, $company_name, $dosage_count, $total_count, $available_count, $on_hold_count, $description);

                            $stmt->execute();
                            $stmt->close();
                        } elseif(isset($_POST['update-vaccine'])){
                            echo '<form method="post">';
                            echo '<br><br><label for="updated-vaccine-name">Enter Vaccine Name(Case sensitive):</label>';
                            echo '<input type="text" name="updated-vaccine-name" id="input"><br><br>';

                            echo '<label for="updated-vaccine-company">Enter Vaccine Company(Case sensitive):</label>';
                            echo '<input type="text" name="updated-vaccine-company" id="input"><br><br>';

                            echo '<input type="radio" name="update_type" value="num_dose"> Update Dosage Count <br><br>';
                            echo '<input type="radio" name="update_type" value="num_available"> Update Available Count <br><br>';
                            echo '<input type="radio" name="update_type" value="num_on_hold"> Update On-Hold Count <br><br>';
                            echo '<input type="radio" name="update_type" value="total_count"> Update Total Count <br><br>';
                            echo '<input type="radio" name="update_type" value="text_desc"> Update Description <br><br>';

                            echo '<label for="updated-value">Enter Updated Value:</label>';
                            echo '<input type="text" name="updated-value" id="input"><br><br>';

                            echo '<input type="submit" name="update-vaccine-submit" id="input">';
                            echo "</form>";

                        } elseif(isset($_POST['update-vaccine-submit'])){
                            $vaccine_name = $_POST["updated-vaccine-name"];
                            $vaccine_company = $_POST["updated-vaccine-company"];
                            $update_column = $_POST['update_type'];
                            $value = $_POST['updated-value'];


                            $stmt = $conn->prepare("UPDATE vaccine SET $update_column = ? WHERE vaccine_name like ? AND vaccine_company like ?");
                            if($update_column == "text_desc"){
                                $stmt->bind_param("sss", $value, $vaccine_name, $vaccine_company);
                            } else{
                                $stmt->bind_param("iss", $value, $vaccine_name, $vaccine_company);

                            }

                            if ($stmt->execute()) {
                                echo "<br>$vaccine_name - $vaccine_company update successfully";
                            } else {
                                echo "Error updating vaccine: " . $stmt->error;
                            }
                            $stmt->close();
                        }
                    ?>
                </form>

                <table>
                    <tr>
                        <th>Vaccine Name</th>
                        <th>Company</th>
                        <th>Dosage Count</th>
                        <th>Available Count</th>
                        <th>On-Hold Count</th>
                        <th>Total Count</th>
                        <th>Description</th>
                    </tr>
                    <?php
                    $stmt = "SELECT * FROM vaccine";
                    $result = $conn->query($stmt);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>" . $row["vaccine_name"]. "</td>
                                <td>" . $row["vaccine_company"]. "</td>
                                <td>" . $row["num_dose"]. "</td>
                                <td>" . $row["num_available"]. "</td>
                                <td>" . $row["num_on_hold"]. "</td>
                                <td>" . $row["total_count"]. "</td>
                                <td>" . $row["text_desc"]. "</td>
                            </tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <?php
    $conn->close();
    ?>
</html>