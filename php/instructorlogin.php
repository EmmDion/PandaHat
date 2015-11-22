<?php

// Project:   PandaHat > Iter2 backend php > instructorlogin.php
// Authors:   Panda_M
// Created:   2015-11-21
// Modified:  2015-11-21
// Buggy? :   Yes, probably error around database connection.


// ------------------------------------------------------------------

// Initialize return value to the failure message state.
$return_value = json_decode('{"debug": null, "data": {"success": false} }');

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
$param_user = $_POST['user'];
$param_pass = $_POST['pass'];

// Fetch survey_id, and start and end times for survey with given survey_tag.
$query = "SELECT user FROM credentials_pro WHERE user = '$param_user' AND pass = '$param_pass'";

//DEBUG:
echo "The query was '$query'";

// (The mysqli way of querying the database.)
if($stmt = $conn -> prepare($query)){
    $stmt -> execute();
    $stmt -> bind_result($result_user);

    // Populate variables with query results, as bound above.
    $stmt->fetch();

    // Check if the SQL results are nonempty--i.e., user entered a valid survey_tag.
    if (!is_null($result_user)
    {
        // Credentials ok.
        $return_value->data->success = TRUE;
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
