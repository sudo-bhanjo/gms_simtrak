<?php

include("dbconn.php");

    $sql = "CREATE TABLE `goal_parameter` (
        `parameter_id` int(10) NOT NULL,
        `team_id` int(10) NOT NULL,
        `parameter` varchar(50) NOT NULL,
        `parameter_data_type` varchar(50) NOT NULL,
         PRIMARY KEY (`parameter_id`)
      )";

    if($conn->query($sql)){
        echo "done";
    }else{
        echo "not done";
    }
   

// Close the connection
$conn->close();
?>
