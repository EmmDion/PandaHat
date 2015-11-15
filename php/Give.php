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

$numberOfQuestions = 3;  // Should probably store this somewhere else.

//$questionIndexMap = array();  // An attempt at mechanism to 'factor out' the name conventions from the code.

for ($i = 0; $i < $numberOfQuestions; $i++)
{
	// Some mapping between naming conventions.
	$paramName = "q00" . strval($i); //FIXME - need leading zeros (Iter1)

    //DEBUG:
	echo "We are inside the loop.";

	//DEBUG:
    //$query = "INSERT INTO survey_results VALUE ('arbitrary_textid', 'arbitrary_texttag', 42, 'arbitrary_textresult')";

    $query = "INSERT INTO survey_results VALUE ('{$_POST['student_id']}', '{$_POST['survey_tag']}', $i, '{$_POST[$paramName]}');";

    //DEBUG:
    echo "The query is: $query" . "<br>";

    // The mysqli way of querying the database.
	if($stmt = $conn -> prepare($query))
	{
		$stmt -> execute();
	    //DEBUG:
		echo "That executed.";
	}
	else
	{
	    //DEBUG:
		echo "That didn't work out.";
	}

}


?>

<!-- Something to show the user once we get done with the script. -->
<p> Thank you! You are now assuming that the script has worked. Congratulations. </p>


 
</body>
</html>
	  