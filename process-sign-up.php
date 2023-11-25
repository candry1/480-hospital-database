<html>
    <body>
        <?php
        //add them as a user and send them to the login page!
        include('signup.html');


        // testing connection
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
            sleep(20); 
            header("Location: index.html");
            // TODO: add header() here to redirect them. ** doing this wont 
            // show the "success" message
        } else {
            echo "Error adding a new user " . $stmt->error;
        }
        $stmt->close();
        $conn->close();
        ?> 
    </body>
</html>