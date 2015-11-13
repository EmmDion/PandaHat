<?php

// Authors:  Panda_S (Panda_X), and Panda_M

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>
<head>
	<title>PandaHat Beta: Survey submitted</title>
	</head>
	
	<body bgcolor="white">
	
	
	<hr>
	
	
<?php
	
//$manu = $_POST['manu'];


/*
$query = "INSERT INTO survey_results VALUE ('textid', 'texttag', 42, 'textresult')";
if($stmt = $conn -> prepare($query))
{
	$stmt -> execute();
	echo "The query has executed.";
}
else
{
	echo "The query did not execute.";
}
*/

//$successTest = mysql_query($query);
//$testSuccess = (boolean) $stmt;
//echo "<p>". ($testSuccess ? "Executed" : "Failed") . "</p>";

$numberOfQuestions = 3;
//$questionIndexMap = array();
for ($i = 0; $i < $numberOfQuestions; $i++)
{
	// Some mapping between naming conventions.
	$paramName = "q00" . strval($i); //FIXME - need leading zeros

	echo "We are inside the loop.";

    //$query = "INSERT INTO survey_results VALUE ('textid', 'texttag', 42, 'textresult')";
    $query = "INSERT INTO survey_results VALUE ('{$_POST['student_id']}', '{$_POST['survey_tag']}', $i, '{$_POST[$paramName]}');";

    echo "The query is: $query" . "<br>";

    //$successTest = mysql_query($query);
    //echo "<p>". ($successTest ? "Executed" : "Failed") . "</p>";

	if($stmt = $conn -> prepare($query))
	{
		$stmt -> execute();
		echo "That executed.";
	}
	else
	{
		echo "That didn't work out.";
	}


	//$questionIndexMap[]
}


//$query = "SELECT * FROM survey_results";

?>

<p> Thank you! You are now assuming that the script has worked. Congratulations. </p>


 
</body>
</html>
	  