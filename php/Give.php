<?php
// Project:   PandaHat > Iter1 backend php > Give.php
// Authors:   Panda_S (Panda_X), and Panda_M
// Created:   2015-11-12
// Modified:  2015-11-14
// In Iter1 code somehow uses mysqli instead of mysql.
//
// It is planned that the MeekroDB library interface will be used in the future.
//
// Panda_M couldn't get hello world to work. Panda_S provided an example of code
// which worked (and incidentally relies on mysqli), so the following code was
// built using that example as a template.
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
$numberOfQuestions = 41;  // Should probably store this somewhere else.
//$questionIndexMap = array();  // An attempt at mechanism to 'factor out' the name conventions from the code.


for ($i = 0; $i <= $numberOfQuestions; $i++)
{
	// Some mapping between naming conventions.
	$paramName = "q" . strval($i); //FIXME - need leading zeros (Iter1)
    //DEBUG:
	//DEBUG:
    $query = "INSERT INTO survey_results VALUE ('{$_POST['ID']}', 'survey_1', $i, '{$_POST[$paramName]}');";
    $query2 = "INSERT INTO student_info VALUE ('{$_POST['name']}', '{$_POST['nickname']}','{$_POST['ID']}');";
    //DEBUG:
    // The mysqli way of querying the database.
	if($stmt1 = $conn -> prepare($query))
	{
		$stmt1 -> execute();
	    //DEBUG:
	}
	else
	{
	    //DEBUG:
		echo "That didn't work out.";
	}
	if($stmt2 = $conn -> prepare($query2))
	{
		$stmt2 -> execute();
	    //DEBUG:
	}
	else
	{
	    //DEBUG:
		echo "That didn't work out.";
	}
}
?>

<!-- Something to show the user once we get done with the script. -->
<p> Thank you! You have finished this survey. </p>


 
</body>
</html>