<html>
    <body>
        <?php
        //add them as a user and send them to the login page!
        include('signup.html');


        // testing connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "final-project";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

       
        $user_name = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $user_type = 1; 
        
        $stmt = $conn->prepare("INSERT INTO login_table  VALUES (?,?,?,?)");
        $stmt->bind_param("sssi", $user_name,$email,$password,$user_type); 


        if ($stmt->execute()) {
            echo "<br>";
            echo "Sign-up of = $user_name is successfully";
        } else {
            echo "Error adding a new user " . $stmt->error;
        }
        $stmt->close();


/*
        if ($result->num_rows > 0) {
            echo "Nurses: <br><br>";
            while($row = $result->fetch_assoc()) {
                echo "Name: " . $row["Fname"]. " " . $row["Lname"]. "<br>";
            }
        } else {
            echo "0 results";
        }
*/
        $conn->close();
        ?> 
    </body>
</html>