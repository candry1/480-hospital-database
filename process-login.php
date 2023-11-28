<!-- http://localhost/480-hospital-database/process-login.php -->

<html>
    <body>
        <?php
        


            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "final-project-2";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $user_name = $_POST["username"];
            $stmt = $conn->prepare("SELECT user_name, pass_word, user_type FROM login_table WHERE user_name = ?");
            $stmt->bind_param("s", $user_name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if($row["pass_word"] == $_POST["password"] && $_POST["login_type"] == $row["user_type"]) {
                    if($_POST["login_type"] == "3"){
                        header("Location: admin-home.php");
                    } else if($_POST["login_type"] == "2"){
                        session_start();

                        $username = $user_name;

                        $_SESSION['username'] = $username;

                        header("Location: nurse-home.php");
                    } 
                     else if($_POST["login_type"] == "1"){
                        session_start();
                        $username = $user_name;
                        $_SESSION['username'] = $username;

                        header("Location: patient-home.php");
                    }
                } else{
                    
                    echo "Wrong Password or Username" ; 
                    sleep(5) ; 
                    header("Location: index.html");
                }
            } else {
                echo "Wrong Password or Username" ; 
                //sleep(5) ; 
                header("Location: index.html");
            }

            $stmt->close();
            $conn->close();
        ?> 
    </body>
</html>