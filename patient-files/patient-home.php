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

         <p> Welcome to the Patient Page! </p>




    </body>

</html>