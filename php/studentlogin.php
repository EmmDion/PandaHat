<?php

// Project:   PandaHat > Iter2 backend php > studentlogin.php
// Authors:   Panda_S (Panda_X), and Panda_M
// Created:   2015-11-18
// Modified:  2015-11-18
// Buggy? :   Yes, could be anywhere between connecting with DB to fetching query result.

//BUG: Query gives null result (even with no constraint on returned rows).

// Defines $server, $user, $pass, $dbname, and $port.
include('connectionData.txt');


//DEBUG:
echo "Here is the beginning of the script.";

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

$survey_tag = $_POST['survey_tag'];


// Fetch survey_id, and start and end times for survey with given survey_tag.

//TODO: rename quiz_tag to survey_tag
//$query = "SELECT survey_id, start_date, end_date FROM credentials_stu WHERE survey_tag = '$survey_tag'";
$query = "SELECT survey_id, start_date, end_date FROM credentials_stu";


//DEBUG:
echo "<br><br>";
echo $query;
echo "<br><br>";

// Initialize return value.
$return_value = json_decode('{"debug": null, "data": {"survey_id": null, "success": false} }');

// The mysqli way of querying the database.
if($stmt = $conn -> prepare($query)){

    //DEBUG:
    //echo "preparation succeeded.";

    $stmt -> execute();
    $stmt -> bind_result($survey_id, $start_date, $end_date);

    // Use $stmt->fetch() to put results in bound variables.
    $stmt->fetch();

    // Check if the SQL results are nonempty--i.e., user entered a valid survey_tag.
    if (!is_null($survey_id))
    {
        // Check start_date & end_date, yield survey_id.
        //$now = time();
        //echo $now;

        //DEBUG:
        echo "survey_tag is valid";
    }
    else
    {
        // Return failure, bad login.

        //DEBUG:
        echo "survey_tag is not valid";
    }

    $stmt->close();
}
//DEBUG:
//else
//{
    //echo "preparation failed.";
//}


// Ouptut in JSON
echo json_encode($return_value);


mysqli_close($conn);

?>
