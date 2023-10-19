<?php
    if(isset($_POST['username'])){

    }
    $username = $_POST['username'];
    $email = $_POST['email'];
    $comments = $_POST['comments'];
    }

    if (!empty($username) || !empty($email) || !empty($comments)){
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "plantscan";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

        if (mysqli_connect_error()) {
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        } else  {
            $SELECT = "SELECT email From register Where email = ? Limit 1";
            $INSERT = "INSERT Into register (username, email, comments) values(?, ?, ?)";

            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;

            if($rnum==0) {
                $stmt->close();

                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("sss", $username, $email, $comments);
                $stmt->execute();
                echo "New Record Inserted Successfully";
            } else {
                echo "someone already register using this email";
            }
            $stmt->close();
            $conn->close();
        }
    } else{
        echo "All field are requird";
        die();
    }
?>