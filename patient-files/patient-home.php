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
            $patient_eid = -1;
            $patient_name = "";

            if (isset($_SESSION['username'])) {
                $patient_username = $_SESSION['username'];
                
                $stmt = $conn->prepare("SELECT ssn, Fname FROM patient WHERE user_name = ?");

                $stmt->bind_param("s", $patient_username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $patient_eid = $row["ssn"];
                    $patient_name = $row["Fname"];
                } else {
                    echo "The user is not found, email the admin for more support";
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
                    <input type="submit" name="register-info" value="register-info"/>

                    <?php
                        if(isset($_POST['register-info'])){
                           
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
                        }

                        

                        if ($stmt->execute()) {
                                echo "<br>Registration  successfull!";
                            } else {
                                echo "Error updating info: " . $stmt->error;
                            }

                            $stmt->close();
                    
                    ?>
                </form>

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
                    $stmt = "SELECT * FROM patient WHERE ssn = $patient_eid";
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
                                <td>" . $row["building_number"]. " " .$row["direction"]. " " .$row["street_name"].", " . $row["city"] . ", ". $row["zip_code"]. ", ". $row["state_initials"]."</td>
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