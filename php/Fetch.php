<?php

// Authors:  Panda_S (Panda_X), and Panda_M

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

if($stmt = $conn -> prepare($query)){


	$stmt -> execute();
	$stmt -> bind_result($student_id_fetch, $survey_tag_fetch, $question_num_fetch, $result_fetch);
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
	  