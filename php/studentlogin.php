<?php

// Project:   PandaHat > Iter2 backend php > studentlogin.php
// Authors:   Panda_M
// Created:   2015-11-18
// Modified:  2015-11-21
// Issues:    Timezone is not considered yet; as of now, system manipulates pure UTC.


// ------------------------------------------------------------------

// Initialize return value to the failure message state.
$return_value = json_decode('{"debug": null, "data": {"survey_id": null, "success": false} }');

// Change debug member of return value, then get string rep of return value.
//TODO: move to a utilities file.
function bake_with_debug($mutable_return_value, $debug_string)
{
    $mutable_return_value->debug = $debug_string;
    return json_encode($mutable_return_value);
}

// ------------------------------------------------------------------

// Defines $server, $user, $pass, $dbname, and $port.
include('connectionData.txt');

// Connect to SQL database.
$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die(bake_with_debug($return_value, 'Error connecting to MySQL server.'));

// ------------------------------------------------------------------

// Read _POST parameter.
$survey_tag = $_POST['survey_tag'];

// Fetch survey_id, and start and end times for survey with given survey_tag.
$query = "SELECT survey_id, start_date, end_date FROM credentials_stu WHERE survey_tag = '$survey_tag'";

// (The mysqli way of querying the database.)
if($stmt = $conn -> prepare($query)){
    $stmt -> execute();
    $stmt -> bind_result($survey_id, $start_date, $end_date);

    // Populate variables with query results, as bound above.
    $stmt->fetch();

    // Check if the SQL results are nonempty--i.e., user entered a valid survey_tag.
    if (!is_null($survey_id))
    {
        // Credentials ok.
        $return_value->data->survey_id = $survey_id;

        // Get times in UTC ints - Note: no timezone checking yet.
        $now = time();
        $start = strtotime($start_date);
        $end = strtotime($end_date);

        // Check start_date & end_date.
        if ($start <= $now && $now <= $end)
        {
            $return_value->data->success = TRUE;
        }
    }
    //else
    //{
        // Bad login, keep failure state & return.
    //}

    $stmt->close();
}
//else
//{
    // Preparation failed.
//}


// Ouptut in JSON
echo json_encode($return_value);

mysqli_close($conn);

?>
