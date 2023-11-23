<!-- http://localhost/480-hospital-database/process-login.php -->

<html>
    <body>
        <?php
        //if they enter "admin" "admin123", send them to admin page!
        if($_POST["username"] == "admin" && $_POST["password"] == "admin123" && $_POST["login_type"] == "admin"){
            header("Location: admin-home.php");
        } else if($_POST["username"] == "nurse" && $_POST["password"] == "nurse123" && $_POST["login_type"] == "nurse"){
            header("Location: nurse-home.php");
        }else{
            header("Location: index.html");
        }
        ?> 
    </body>
</html>