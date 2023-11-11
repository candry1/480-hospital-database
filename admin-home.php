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
            <h2>Nurses</h2>
            <button name="register-nurse">Register Nurse</button>
            <button name="update-nurse">Update Nurse</button>
            <button name="delete-nurse">Delete Nurse</button>
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

    <?php
    $conn->close();
    ?>
</html>