<!-- http://localhost/480-hospital-database/admin-home.html -->

<html>
    <head>
        <title>Admin Home</title>
        <link rel="stylesheet" href="admin-home.css">
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "final-project";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        ?>
    </head>

    <div class="admin-home-page">
        <div class="tab-bar">
            <h2>Welcome to the Admin Homepage!</h2><br>
        </div>

        <div class="display-options">
            <div class="nurse-display">
                <h2>Nurses</h2>
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

                            echo '<button type="submit" name="add-submit">Add Info</button>';
                            echo '</form>';

                        }else if(isset($_POST["add-submit"])){
                            $age = $_POST["age"];
                            $first = $_POST["first-name"];
                            $gender = $_POST["gender"];
                            $last = $_POST["last-name"];
                            $mi = $_POST["mi"];
                            $phone_num = $_POST["phone-num"];

                            // TODO: adding the next valid ID isn't working!!
                            $stmt = $conn->prepare("INSERT INTO nurse (eid, age, Fname, gender, Lname, MI, phone_number) VALUES (DEFAULT, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("isissi", $age, $first, $gender, $last, $mi, $phone_num);

                            $stmt->execute();
                            $stmt->close();
                        } elseif(isset($_POST['update-nurse'])){
                            // TODO: figure out what specifically they want to update!!

                            echo '<form method="post">';
                            echo '<br><br><label for="update-eid">Enter eid:</label>';
                            echo '<input type="text" name="update-eid" id="input"><br><br>';

                            echo '<input type="radio" name="select" id="input" value="update-address">';
                            echo '<label for="update-address">Update Address</label>';

                            echo '<br><input type="radio" name="select" id="input" value="update-number">';
                            echo '<label for="update-number">Update Phone Number</label>';

                            echo '<br><input type="submit" name="update-submit" id="input">';
                            echo "</form>";

                        } elseif(isset($_POST['update-submit'])){
                            // $eid = $_POST["update-eid"];

                            // TODO: add ability to update userame && password

                            // $stmt = $conn->prepare("DELETE FROM nurse WHERE eid IS ?");
                            // $stmt->bind_param("s", $eid);

                            // if ($stmt->execute()) {
                            //     echo "Rows with eid = $eid deleted successfully";
                            // } else {
                            //     echo "Error deleting rows: " . $stmt->error;
                            // }
                            // $stmt->close();
                        }elseif(isset($_POST['delete-nurse'])){
                            echo "<br><br>";

                            echo '<form method="post">';
                            echo '<label for="delete-eid">Enter eid:</label>';
                            echo '<input type="text" name="delete-eid" id="input">';
                            echo '<input type="submit" name="delete-submit" id="input">';
                            echo "</form>";
                        }elseif(isset($_POST['delete-submit'])){
                            $eid = $_POST["delete-eid"];

                            // TODO: make work with input we receieve
                            $stmt = $conn->prepare("DELETE FROM nurse WHERE eid IS ?");
                            $stmt->bind_param("s", $eid);

                            if ($stmt->execute()) {
                                echo "Rows with eid = $eid deleted successfully";
                            } else {
                                echo "Error deleting rows: " . $stmt->error;
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
                    </tr>
                    <?php
                    $stmt = "SELECT * FROM nurse";
                    $result = $conn->query($stmt);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>" . $row["Fname"]. " " . $row["MI"]. ". " . $row["Lname"]. "</td>
                                <td>" . $row["eid"]. "</td>
                                <td>" . $row["gender"]. "</td>
                                <td>" . $row["phone_number"]. "</td>
                                <td>" . $row["age"]. "</td>
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


            <div class="vaccine-display">
                <h2>Vaccines</h2>
                <button name="add-vaccine">Add Vaccine</button>
                <button name="update-vaccine">Update Vaccine</button>
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