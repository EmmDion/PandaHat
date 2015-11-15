<?php

// Project:   PandaHat > Iter1 backend php > Fetch.php
// Authors:   Panda_S (Panda_X), and Panda_M
// Created:   2015-11-12
// Modified:  2015-11-14

// See note in 'Give.php' about the use of mysqli.

// Defines $server, $user, $pass, $dbname, and $port.
include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
	<title> PandaHat Beta: Survey results </title>
	</head>
	
	<body bgcolor="white">
	
	
	<hr>
	
	
<?php
	
$survey_tag = $_POST['survey_tag'];
$student_id = $_POST['student_id'];


// Fetch survey results for one survey and one student. Also, list in sorted order.

//TODO: rename quiz_tag to survey_tag
$query = "SELECT * FROM survey_results WHERE quiz_tag = '$survey_tag' AND student_id = '$student_id' ORDER BY question_num";

?>

<p>
The query:
<p>
<?php

echo $query;

?>

<hr>
<p>
Result of query:
<p>

<?php


print "<pre>";

// The mysqli way of querying the database.
if($stmt = $conn -> prepare($query)){


	$stmt -> execute();
	// Identifiers post-fixed with 'fetch' - otherwise wasn't sure if would cause clash.
	$stmt -> bind_result($student_id_fetch, $survey_tag_fetch, $question_num_fetch, $result_fetch);

    // Currently data is output in HTML. Will change to JSON in future.
	echo "<table style=\"width:50%\">";
	while($stmt -> fetch()){
		echo "\n";
		echo "<tr><td>$question_num_fetch</td>
		          <td>$result_fetch</td><tr>";
	}
	echo "</table>";
}



print "</pre>";

$stmt->close();

mysqli_close($conn);

?>

</body>
</html>
	  