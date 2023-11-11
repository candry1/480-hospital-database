<!-- http://localhost/480-hospital-database/process-login.php -->

<html>
    <body>
        <?php
        //if they enter "admin" "admin123", send them to admin page!



        // testing connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "final-project";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = "SELECT * FROM patient";
        $result = $conn->query($stmt);

        if ($result->num_rows > 0) {
            echo "Patients: <br><br>";

            while($row = $result->fetch_assoc()) {
                echo "Name: " . $row["Fname"]. " " . $row["Lname"]. "<br>";
            }
        } else {
            echo "0 results";
        }

        $conn->close();
        ?> 
    </body>
</html>