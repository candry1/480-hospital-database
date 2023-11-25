<!-- http://localhost/480-hospital-database/nurse-home.php -->

<html>
    <head>
        <link rel="stylesheet" href="nurse-home.css">
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
        <?php echo "<title>$nurse_name's Home Page</title>"?>

    </head>

    <div class="nurse-home-page">
        <div class="tab-bar">
            <?php echo "<h1>Welcome, $nurse_name!</h1>"?>

        </div>

        <div class="display-options">
            <div class="nurse-display">

                <form method="POST" action="nurse-home.php">
                    <input type="submit" name="update-info" value="Update Info"/>

                    <?php
                        if(isset($_POST['update-info'])){
                            echo '<form method="post">';

                            echo '<br><br><input type="radio" name="update_type_nurse" value="phone_number"> Update Phone Number<br><br>';
                            echo '<input type="radio" name="update_type_nurse" value="street"> Update Address<br><br>';
                            echo '<input type="radio" name="update_type_nurse" value="city"> Update City<br><br>';
                            echo '<input type="radio" name="update_type_nurse" value="state"> Update State<br><br>';

                            
                            echo '<label for="updated-value">Enter Updated Information:</label>';
                            echo '<input type="text" name="updated-value" id="input"><br><br>';

                            echo '<input type="submit" name="update-submit" id="input">';
                            echo "</form>";

                        } else if(isset($_POST['update-submit'])){
                            $column = $_POST['update_type_nurse'];
                            $value = $_POST['updated-value'];

                            if($_POST['update_type_nurse'] == "phone_number"){
                                $stmt = $conn->prepare("UPDATE nurse SET phone_number = ? WHERE eid = ?");
                                $stmt->bind_param("ii", $value, $nurse_eid);
                            } else{
                                $stmt = $conn->prepare("UPDATE nurse SET $column = ? WHERE eid = ?");
                                $stmt->bind_param("si", $value, $nurse_eid);
                            }

                            if ($stmt->execute()) {
                                echo "<br>Update successfull!";
                            } else {
                                echo "Error updating info: " . $stmt->error;
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
                    </tr>
                    <?php
                    $stmt = "SELECT * FROM nurse WHERE eid = $nurse_eid";
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
                                <td>" . $row["street"].  ", " . $row["city"] . ", ". $row["state"]."</td>
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

            <div class="scheduling-display">
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
            </div>

            <div class="scheduling-display">
                <h2>Your Availablility</h2>

                <form method="POST" action="nurse-availability-scheduling.php">
                    <input type="submit" name="add-availability" value="Add Your Availablility"/>
                    <input type="submit" name="cancel-availability" value="Cancel Your Timeslot"/>
                </form>

                <table>
                    <tr>
                        <th>Date</th>
                        <th>Timeslot</th>
                    </tr>
                    <?php
                    $stmt = "SELECT * FROM nurse_availability WHERE eid = $nurse_eid";
                    $result = $conn->query($stmt);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>" . $row["the_date"]. "</td>
                                <td>" . $row["time_slot"]. "</td>
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