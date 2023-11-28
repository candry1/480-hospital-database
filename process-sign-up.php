<html>
    <body>
        <?php
        include('signup.html');


        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "final-project-2";

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
            echo "Sign-up of = $user_name is successfull, please log in!";
            echo "You will be redirected to the log in page ..."; 
            sleep(2); 
            header("Location: index.html");
        } else {
            echo "Error adding a new user " . $stmt->error;
        }
        $stmt->close();
        $conn->close();
        ?> 
    </body>
</html>