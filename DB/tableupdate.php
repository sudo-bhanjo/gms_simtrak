
<?php

    include("dbconn.php");

    $sql = "INSERT INTO `Lset Institution Development`(`goalset`) VALUES ('1')";

    if($conn->query($sql)){
        echo "done ok";
    }else{
        echo "not done" . $conn->error;
    }
   

// Close the connection
    $conn->close();

?>



