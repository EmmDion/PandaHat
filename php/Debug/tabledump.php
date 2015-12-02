<?php

// ==========================================================================
// * Desc.: Debugging tool to see all data in a table.
// *
// * Inputs:   [GET] 'table' (name of the table).
// *
// * Returns:  Raw text. Table rows are separated by '<br>'.
// *
// * TODO: Move login information to a protected config file!
// * TODO: Remove this file from the live site!
// ==========================================================================


// ============================================================================
// Get parameters.
// ============================================================================

if (!array_key_exists('table', $_GET))
{
	echo 'Please supply an argument to the parameter: tabledump.php?table= ...';
	die();
}

$tableName = $_GET['table'];


// ============================================================================
// Static parameters.
// ============================================================================

// Defines $server, $user, $pass, $dbname, and $port.
include('../connectionData.txt');

// ============================================================================
// Open DB connection.
// ============================================================================

//mysql_connect('localhost','guest','guest') or die("Could not connect: " . mysql_error() );
mysql_connect($server, $user, $pass, $port) or die("Could not connect: " . mysql_error() );
mysql_select_db($dbname) or die("Could not find database: " . mysql_error() );


// ============================================================================
// Execute a MySQL query to select data of entire table.
// ============================================================================

$sql = "SELECT * FROM $tableName";    // Select all.
echo "The query was: $sql <br>";


$queryResult = mysql_query($sql);


// ============================================================================
// Dump rows to screen.
// ============================================================================

while($row = mysql_fetch_assoc($queryResult))
{
	print_r($row);
	echo '<br>';
}


// ============================================================================
// Close DB connection.
// ============================================================================

mysql_close();

echo '<br><br>End of dump.';

?>