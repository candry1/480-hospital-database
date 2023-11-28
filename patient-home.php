<!DOCTYPE html>
<html>
    <head>
        <title>Patient Home</title>
        <link rel="stylesheet" href="patient-home.css">
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
            $patient_ssn = -1;
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
                    header("Location: signup_profile_patient.html");

                }
            }

        ?>
        <?php echo "<title>$patient_name's Home Page</title>"?>

    </head>


    <body >

    <div class="patient-home-page">
        <div class="tab-bar">
            <?php echo "<h1>Welcome, $patient_name!</h1>"?>
            <a href='http://localhost/480-hospital-database'>Log Out</a>

        </div>

        <div class="display-options">
            <div class="patient-display">

                <form method="POST" action="patient-home.php">
                    <input type="submit" name="update-info" value="Update Your Information"/>
                </form>

                    <?php
                        if(isset($_POST['update-info'])){
                            echo '<form method="post">';

                            echo '<br><br><input type="radio" name="update_type_patient" value="Fname"> Update First Name<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="MI"> Update Middle Initial<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="Lname"> Update Last Name<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="ssn"> Update SSN<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="age"> Update Age<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="gender"> Update Gender<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="race"> Update Race<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="phone_number"> Update Phone Number<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="building_number"> Update Building Number<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="street_name"> Update Street Name<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="direction"> Update Street Direction<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="city"> Update City<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="state_initials"> Update State Initials<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="zip_code"> Update Zip Code<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="occupation_class"> Update Occupation Class<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="medical_history"> Update Medical History<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="user_name"> Update Username<br><br>';
                            echo '<input type="radio" name="update_type_patient" value="pass_word"> Update Password<br><br>';

                            
                            echo '<label for="updated-value">Enter Updated Information:</label>';
                            echo '<input type="text" name="updated-value" id="input"><br><br>';

                            echo '<input type="submit" name="update-submit" id="input">';
                            echo "</form>";

                        } else if(isset($_POST['update-submit'])){
                            $column = $_POST['update_type_patient'];
                            $value = $_POST['updated-value'];

                            if($_POST['update_type_patient'] == "phone_number" || $_POST['update_type_patient'] == "age" || $_POST['update_type_patient'] == "gender" || $_POST['update_type_patient'] == "ssn"){
                                $stmt = $conn->prepare("UPDATE patient SET $column = ? WHERE ssn = ?");
                                $stmt->bind_param("ii", $value, $patient_ssn);
                            } else if($_POST['update_type_patient'] == "pass_word"){
                                $stmt = $conn->prepare("UPDATE login_table SET $column = ? WHERE user_name = ?");
                                $stmt->bind_param("ss", $value, $patient_username);
                            }else{
                                $stmt = $conn->prepare("UPDATE patient SET $column = ? WHERE ssn = ?");
                                $stmt->bind_param("si", $value, $patient_ssn);
                            }

                            if ($stmt->execute()) {
                                echo "<br>Update successfull!";
                            } else {
                                echo "Error updating info: " . $stmt->error;
                            }

                            $stmt->close();
                        }
                    
                    ?>

                <table>
                    <tr>
                        <th>Name</th>
                        <th>SSN</th>
                        <th>Sex(0=F, 1=M)</th>
                        <th>Phone Number</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Username</th>
                    </tr>
                    <?php
                    $stmt = "SELECT * FROM patient WHERE ssn = $patient_ssn";
                    $result = $conn->query($stmt);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>" . $row["Fname"]. " " . $row["MI"]. ". " . $row["Lname"]. "</td>
                                <td>" . $row["ssn"]. "</td>
                                <td>" . $row["gender"]. "</td>
                                <td>" . $row["phone_number"]. "</td>
                                <td>" . $row["age"]. "</td>
                                <td>" . $row["building_number"]. " " .$row["direction"]. " " .$row["street_name"].", " . $row["city"] . ", ". $row["state_initials"]. ", ". $row["zip_code"]."</td>
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
                <br>
            </div>






    </body>

</html>