<!-- http://localhost/480-hospital-database/process-sign-up.php -->

<html>
    <body>
        <?php
        //add them as a user and send them to the login page!

        // testing connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "final-project-2";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = "SELECT * FROM nurse";
        $result = $conn->query($stmt);


        if ($result->num_rows > 0) {
            echo "Nurses: <br><br>";
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