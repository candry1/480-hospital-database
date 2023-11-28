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
        session_start();

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $first_name = $_POST["Fname"];
        $MI = $_POST["MI"];
        $Lname  = $_POST["Lname"];
        $ssn =  $_POST["ssn"];
        $age = $_POST["age"];
        $street_name = $_POST["street_name"];
        $direction = $_POST["direction"];
        $building_number = $_POST["building_number"];
        $city = $_POST["city"];
        $state_initials =  $_POST["state_initials"];    
        $zip_code =  $_POST["zip_code"];  
        $phone_number =  $_POST["phone_number"]; 
        $gender =  $_POST["gender"];
        $race =  $_POST["race"];
        $occupation_class =  $_POST["occupation_class"];
        $medical_history =  $_POST["medical_history"];
        $username = $_SESSION["username"];



        $stmt = $conn->prepare("INSERT INTO patient (ssn,Fname, MI, Lname, age, street_name, direction,building_number,city,state_initials,zip_code,phone_number,gender,race,occupation_class,medical_history,user_name ) VALUES (?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("isssississiisssss", $ssn,$first_name, $MI, $Lname,$age, $street_name,$direction,$building_number,$city,$state_initials,$zip_code,$phone_number,$gender,$race,$occupation_class,$medical_history,$username);

        $stmt->execute();
        

        //$result = $conn->query($stmt);


        if ($stmt->affected_rows> 0) {
            echo "You have registered successfully!";
                sleep(3);
                echo "redirction to the login page!"; 
                header("location: patient-home.php"); 
            
        } else {
            echo "Error, some issues occured call the admin";
            sleep(5); 
           //header("location: index.html"); 

        }
        $stmt->close();
        $conn->close();

        ?> 
    </body>
</html>