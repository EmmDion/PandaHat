<?php

// Project:   PandaHat > Iter1 backend php > Fetch.php
// Authors:   Panda_S (Panda_X), and Panda_M
// Created:   2015-11-18
// Modified:  2015-11-18

// Defines $server, $user, $pass, $dbname, and $port.
include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

  
$survey_tag = $_POST['survey_tag'];


// Fetch survey_id, and start and end times for survey with given survey_tag.

//TODO: rename quiz_tag to survey_tag
$query = "SELECT survey_id, start, end FROM credentials_stu WHERE survey_tag = '$survey_tag'";


//DEBUG:
echo $query;

//print "<pre>";

// The mysqli way of querying the database.
if($stmt = $conn -> prepare($query)){


    $stmt -> execute();
    // Identifiers post-fixed with 'fetch' - otherwise wasn't sure if would cause clash.
    $stmt -> bind_result($survey_id, $start_time, $end_time);

    // Check if the SQL results are nonempty--i.e., user entered a valid survey_tag.
    if (!is_null($survey_id))
    {
        // Check start & end, yield survey_id.
    }
    else
    {
        // Return failure, bad login.
    }


    // Use $stmt->fetch() to put results in bound variables.

    // Ouptut in JSON
}



//print "</pre>";

$stmt->close();

mysqli_close($conn);

?>
