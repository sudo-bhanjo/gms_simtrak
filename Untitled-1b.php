<?php

include ("periousmonthb.php");
$username = $_SESSION['user_id'];
$total = array([], []);
// print team goal
$teamID = $_SESSION["team_id"];
$sql1 = "SELECT * FROM `teams` WHERE `id` = '$teamID'";
$teamname = mysqli_query($conn, $sql1);
$teamname = mysqli_fetch_object($teamname);
$_SESSION["team_name"] = $teamname->team_name;
// $achieve = "SELECT SUM() AS total_quantity FROM sales WHERE order_date BETWEEN '2022-01-01' AND '2022-12-31'"
if (isset($_GET["delete_fgdgoal"])) {
    $sql5 = "DELETE FROM `$teamname->team_name` WHERE `ID` = '" . $_GET["delete_goal"] . "'";
    if (mysqli_query($conn, $sql5)) {
        echo '<script type="text/javascript">';
        echo 'window.location.href="UI.php";';
        echo '</script>';
    } else {
        echo "undifined error";
    }
}



// team parameter
$goal_parameter = "SELECT * FROM `goal_parameter` WHERE team_id ='0' OR team_id =" . $_SESSION["team_id"] . " ORDER BY `goal_parameter`.`team_id` ASC ";
$parameter = mysqli_query($conn, $goal_parameter);
$parameters = mysqli_query($conn, $goal_parameter);
$goalparameters = mysqli_query($conn, $goal_parameter);
$array = array();
$i = 0;
while ($para = mysqli_fetch_object($parameter)) {
    $array[$i] = $para->parameter;
    $i++;
}
// update goal
if (isset($_REQUEST["team_manager_id"])) {
    $updategoal = "UPDATE `$teamname->team_name` SET `Member ID` = " . $_REQUEST["team_manager_id"] . ", `Member Name`= '" . $_REQUEST["team_manager_name"] . "' WHERE `goalset` = '1'";
    if (mysqli_query($conn, $updategoal)) {
        $i = 0;
        foreach ($array as $value) {
            if ($value == "Member Name") {
                continue;
            }
            $updategoal = "UPDATE `$teamname->team_name` SET `$value`= '" . $_REQUEST[$i] . "' WHERE `goalset` = '1'";
            if (mysqli_query($conn, $updategoal)) {
            } else {
                echo $conn->error;
            }
            $i++;
        }
        echo '<script type="text/javascript">';
        echo 'window.location.href="Untitled-1.php";';
        echo '</script>';
    } else {
        echo $conn->error;
    }
}



$sql3 = "SELECT * FROM `users` WHERE `role_id` ='4' OR `role_id` ='3'";
$sql4 = "SELECT * FROM `role_teams` WHERE `team_id` = " . $_SESSION["team_id"] . " ";
$user_result = mysqli_query($conn, $sql3);
$role_result = mysqli_query($conn, $sql4);
$user_array_id = array();
$user_array_name = array();
$role_array_id = array();
$user_role_id = array();
$i = 0;

while ($user_name = mysqli_fetch_object($user_result)) {
    $user_array_id[$i] = $user_name->id;
    $user_array_name[$i] = $user_name->username;
    $i++;
}
$i = 0;
while ($user_id = mysqli_fetch_object($role_result)) {
    $role_array_id[$i] = $user_id->user_id;
    $user_role_id[$i] = $user_id->role_id;
    $i++;
}

$inputpara = array();
$i = 0;
$goalp = array();
while ($parat = mysqli_fetch_object($goalparameters)) {
    if ($parat->parameter == "Date" || $parat->parameter == 'Member Name') {
        continue;
    }
    $goalp[$i] = $parat->parameter;
    $i++;
}
$z = 0;
while (isset($_REQUEST[$z])) {
    if (!empty($_REQUEST[$z])) {
        $inputpara[$z] = $_REQUEST[$z];

    } else {
        $inputpara[$z] = "0";
    }
    $z++;
}
//submit function 
function submitdata()
{
    global $goalp, $inputpara, $user_array_id, $teamname, $conn, $user_array_name ,$totalhistory , $totalmonth, $totalhistorystratingdate;
    $date_data = $_REQUEST["date_data"];
    $Remark = $_REQUEST["Remark"];
    $result = "`Date`,`" . implode("`,`", $goalp) . "`,`Remark`)";
    $results = "'$date_data','" . implode("','", $inputpara) . "','$Remark')";
    $year = date('Y');
    $month = date('n');
    $setgoaldate = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-00';
    $goalset = "SELECT * FROM `$teamname->team_name` where `goalset`='1' AND `DATE` = '$setgoaldate'";
    $goalset = mysqli_query($conn, $goalset);
    $goalset = mysqli_fetch_object($goalset);

    if (isset($_REQUEST["membername"])) {
        $i = $_REQUEST["membername"];
        $temp_uid = $user_array_id[$i];
        // Checking if data is already in the database
        $query_check_db = "SELECT * FROM `$teamname->team_name` WHERE `Member ID` = '$temp_uid' AND `Date` = '$date_data'";
        $check = mysqli_query($conn, $query_check_db);
        $rowcount = mysqli_num_rows($check);

        if ($rowcount >= 1) {
            // Data is already present, alert the user
            $_SESSION["allready"] = "$user_array_name[$i], already filled goal";
            echo "ok";
        } else {
            // Insert data into the database
            $goal = "INSERT INTO `$teamname->team_name` (`Member ID`, `Member Name`,`goalset`, $result VALUES ('$user_array_id[$i]', '$user_array_name[$i]','0', $results";
            if (mysqli_query($conn, $goal)) {
                // Data inserted successfully
                // Construct the HTML message body
                $date = date("d-M-y");
                // Start building the HTML message
                $message = '<html><head>';
                $message .= '<style>
                body { font-family: Arial, sans-serif; }
                .container { margin-top: 20px; }
                .header { margin-bottom: 20px; }
                .table { margin-top: 20px; border-collapse: collapse; width: 100%; }
                .table, .th, .td { border: 1px solid black; }
                .th, .td { padding: 8px; text-align: left; }
             </style>';
                $message .= '</head><body>';
                $message .= '<div class="container">';
                $message .= '<div class="header">';
                $message .= '<h1>Team Goal Update</h1>';
                $message .= '<p>Hi,</p>';
                $message .= '<p>The goal of team <strong>' . htmlspecialchars($teamname->team_name) . '</strong> is to be filled by <strong>' . htmlspecialchars($user_array_name[$i]) . '</strong>.</p>';
                $message .= '</div>';
                $message .= '<table class="table">';
                $message .= '<thead><tr><th class="th">Goal Field</th><th class="th">Goal of ' . htmlspecialchars($date_data) . '</th><th class="th">' . htmlspecialchars(date("F", strtotime($date_data))) . ' Goal </th><th class="th">Total ' . htmlspecialchars(date("F", strtotime($date_data))) . ' Goal</th><th class="th">Total Goal('.htmlspecialchars(date('d-m-y', strtotime($totalhistorystratingdate->Date))).' to '.htmlspecialchars(date('d-m-y')).')</th></tr></thead>';
                $message .= '<tbody>';
                // Loop through the requests
                $z = 0; // Assuming attributes start from 1
                while (isset($_REQUEST["$z"])) {
                    // Get the attribute and value 
                    $attribute = htmlspecialchars($goalp[$z]);
                    $value = isset($_REQUEST["$z"]) ? htmlspecialchars($_REQUEST["$z"]) : 0;
                    $goalvalues = htmlspecialchars($goalset->$attribute);
                    $totalmonths = htmlspecialchars($totalmonth->$attribute); 
                    $totalhistorys = htmlspecialchars($totalhistory->$attribute);
                    // Add the row to the table
                    $message .= '<tr><td class="td">$attribute</td><td class="td">$value</td><td class="td">$goalvalues</td><td class="td">$totalmonths</td><td class="td">$totalhistorys</td></tr>';

                    // Increment the counter
                    $z++;
                }

                $message .= '</tbody></table>';
                $message .= '</div>';
                $message .= '</body></html>';

                $to = "simran.adoreindia@gmail.com";
                $subject = "Goal Sheet of " . htmlspecialchars($teamname->team_name);
                $headers = "From: contact@simtrak.in\r\n";
                $headers .= "cc: dinesh.garghouse@gmail.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                if (mail($to, $subject, $message, $headers)) {
                    echo "ok";
                }
            } else {
                // Error occurred during insertion
                echo "error";
            }
        }
    } else {
        // Insert data for the current user
        $query_check_db = "SELECT * FROM `$teamname->team_name` WHERE `Member ID` = '" . $_SESSION['user_id'] . "' AND `Date` = '$date_data'";
        $check = mysqli_query($conn, $query_check_db);
        $rowcount = mysqli_num_rows($check);

        if ($rowcount >= 1) {
            // Data is already present, alert the user
            $_SESSION["allready"] = "" . $_SESSION['user_name'] . ", already filled goal";
            echo "already_filled";
        } else {
            // Insert data into the database
            $goal = "INSERT INTO `$teamname->team_name` (`Member ID`, `Member Name`,`goalset`, $result VALUES ('" . $_SESSION['user_id'] . "', '" . $_SESSION['user_name'] . "','0', $results";
            if (mysqli_query($conn, $goal)) {
                // Data inserted successfully
                // Construct the HTML message body
                $date = date("d-M-y");
                // Start building the HTML message
                $message = '<html><head>';
                $message .= '<style>
                body { font-family: Arial, sans-serif; }
                .container { margin-top: 20px; }
                .header { margin-bottom: 20px; }
                .table { margin-top: 20px; border-collapse: collapse; width: 100%; }
                .table, .th, .td { border: 1px solid black; }
                .th, .td { padding: 8px; text-align: left; }
             </style>';
                $message .= '</head><body>';
                $message .= '<div class="container">';
                $message .= '<div class="header">';
                $message .= '<h1>Team Goal Update</h1>';
                $message .= '<p>Hi,</p>';
                $message .= '<p>The goal of team <strong>' . htmlspecialchars($teamname->team_name) . '</strong> is to be filled by <strong>' . htmlspecialchars($_SESSION['user_name']) . '</strong>.</p>';
                $message .= '</div>';
                $message .= '<table class="table">';
                $message .= '<thead><tr><th class="th">Goal Field</th><th class="th">Goal of ' . htmlspecialchars($date_data) . '</th><th class="th">' . htmlspecialchars(date("F", strtotime($date_data))) . ' Goal </th><th class="th">Total ' . htmlspecialchars(date("F", strtotime($date_data))) . ' Goal</th><th class="th">Total Goal('.htmlspecialchars(date('d-m-y', strtotime($totalhistorystratingdate->Date))).' to '.htmlspecialchars(date('d-m-y')).')</th></tr></thead>';
                $message .= '<tbody>';
                // Loop through the requests
                $z = 0; // Assuming attributes start from 1
                while (isset($_REQUEST["$z"])) {
                    // Get the attribute and value 
                    $attribute = htmlspecialchars($goalp[$z]);
                    $value = isset($_REQUEST["$z"]) ? htmlspecialchars($_REQUEST["$z"]) : 0;
                    $goalvalues = htmlspecialchars($goal->$attribute);
                    $totalmonths = htmlspecialchars($totalmonth->$attribute);
                    $totalhistorys = htmlspecialchars($totalhistory->$attribute);
                    // Add the row to the table
                    $message .= '<tr><td class="td">$attribute</td><td class="td">$value</td><td class="td">$goalvalues</td><td class="td">$totalmonths</td><td class="td">$totalhistorys</td></tr>';

                    // Increment the counter
                    $z++;
                }

                $message .= '</tbody></table>';
                $message .= '</div>';
                $message .= '</body></html>';

                $to = "simran.adoreindia@gmail.com";
                $subject = "Goal Sheet of " . htmlspecialchars($teamname->team_name);
                $headers = "From: contact@simtrak.in\r\n";
                $headers .= "cc: dinesh.garghouse@gmail.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                if (mail($to, $subject, $message, $headers)) {
                    echo "ok";
                }
            } else {
                // Error occurred during insertion
                echo "error";
            }
        }
    }
}
// update goal date wise
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $last_date = date("Y-m-d", strtotime("-1 day"));
    $i = $_REQUEST["membername"];
    $temp_uid = $user_array_id[$i];
    $lastdatecheck = "SELECT * FROM `$teamname->team_name` WHERE `Member ID` = '$temp_uid' AND `Date` = '$date_data'";
    $lastdatecheck = mysqli_query($conn, $lastdatecheck);
    $lastdaterow = mysqli_num_rows($lastdatecheck);
    if ($lastdaterow >= 1) {
        submitdata();
    } else {
        if (isset($_SESSION["confirm"])) {
            submitdata();
            unset($_SESSION["confirm"]);
        } else {
            $_SESSION["confirm"] = "ok";
            echo "notok";
        }
    }

}

// add normal member
$normalmember = "SELECT * FROM `users` WHERE `role_id` IN (3, 5) ORDER BY id ASC";
$normaladdmember = mysqli_query($conn, $normalmember);

// Create a string with array elements enclosed in parentheses and separated by commas
$printid = "SELECT * FROM `role_teams` WHERE `role_id` IN (3,4) AND `team_id` ='$teamID'  ORDER BY `role_id`";
$printidselect = mysqli_query($conn, $printid);
$selectid = "";
if (mysqli_num_rows($printidselect) > 0) {
    $print = array();
    $p = 0;
    while ($pri = mysqli_fetch_object($printidselect)) {
        $print[$p] = $pri->user_id;
        $p++;
    }
    $selectid = "(" . implode(",", $print) . ")";
    $printname = "SELECT * FROM `users` WHERE `id` IN $selectid ORDER BY role_id ASC";
    $nameprint = mysqli_query($conn, $printname);

    $print = array();
    $p = 0;
    while ($pri = mysqli_fetch_object($nameprint)) {
        $print[$p] = $pri->username;
        $p++;
    }
    $selectid = "(" . implode(",", $print) . ")";
}
?>