<?php

// Project:   PandaHat > Iter2 backend php > instructorlogin.php
// Authors:   Panda_M
// Created:   2015-11-21
// Modified:  2015-11-21
// Buggy? :   Major security hole - if user enters '*' as user and password (single-quotes included),
//            then they can get in without even knowing the login credentials.
//            [Suggested temp fix]: Use mysqli stmt::bind_param instead of quoting input.
//            [Suggested better fix]: The MeekroDB library interface may take care of this.


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

// Read _POST parameters.
$param_user = $_POST['user'];
$param_pass = $_POST['pass'];

// Fetch user for record with given user & pass.
// We don't actually need the fetched value (we already have it), but we need
// to know if the return value of the query is non-null.
$query = "SELECT user FROM credentials_pro WHERE user = '$param_user' AND pass = '$param_pass'";

// (The mysqli way of querying the database.)
if($stmt = $conn -> prepare($query)){
    $stmt -> execute();
    $stmt -> bind_result($result_user);

    // Populate variables with query results, as bound above.
    $stmt->fetch();

    // Check if the SQL results are nonempty--i.e., user entered a valid login.
    if (!is_null($result_user))
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
