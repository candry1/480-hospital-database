<!-- http://localhost/480-hospital-database/nurse-home.php -->

<html>
    <head>
        <title>Nurse Home</title>
        <link rel="stylesheet" href="nurse-home.css">
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

    <div class="nurse-home-page">
        <div class="tab-bar">
            <h2>Welcome to your Homepage!</h2><br>
        </div>

        <div class="display-options">
            <div class="nurse-display">
                <!-- <h2>Nurses</h2> -->

                <form method="POST" action="nurse-home.php">
                    <input type="submit" name="update-info" value="Update Info"/>

                    <?php
                        if(isset($_POST['update-info'])){
                            echo '<form method="post">';

                            echo '<br><br><label for="update-phone-number">Enter new phone number:</label>';
                            echo '<input type="text" name="update-phone-number" id="input"><br><br>';

                            echo '<input type="submit" name="update-submit" id="input">';
                            echo "</form>";

                        } else if(isset($_POST['update-submit'])){
                            $number = $_POST['update-phone-number'];

                            // TODO: add ability to update userame && password
                            $stmt = $conn->prepare("UPDATE nurse SET phone_number = ? WHERE eid = 10");
                            $stmt->bind_param("i", $number);

                            if ($stmt->execute()) {
                                echo "<br>Updated successfully";
                            } else {
                                echo "Error updating nurse: " . $stmt->error;
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
                    $stmt = "SELECT * FROM nurse WHERE eid = 10";
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
        </div>
    </div>

    <?php
    $conn->close();
    ?>
</html>