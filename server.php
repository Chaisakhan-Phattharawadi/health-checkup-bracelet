<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "checkup_health_login";

    $condb = mysqli_connect($servername, $username, $password, $dbname);

    if(!$condb){
        die("Connection failed" . mysqli_connect_error());
    }else {
        // echo "Connected successfully";
    }



?>