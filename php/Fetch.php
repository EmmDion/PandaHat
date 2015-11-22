<?php

// Project:   PandaHat > Iter1 backend php > Fetch.php
// Authors:   Panda_S (Panda_X), and Panda_M
// Created:   2015-11-12
// Modified:  2015-11-21

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
$name = "";	
//$ID = 0;
$survey_tag = $_POST['survey_tag'];
$student_id = $_POST['student_id'];
//$question_num = $_POST['question_num'];
$selectmode = $_POST['selectmode'];
$question_map = array("All" =>"*", 
					  "Java"=>"19",
					  "C++" => "20",
					  "C" => "21",
					  "Python" => "22",
					  "Android" => "23",
					  "Web_design" => "24",
					  "Web_programing" =>25
					 );

// Fetch survey results for one survey and one student. Also, list in sorted order.

//TODO: rename quiz_tag to survey_tag


switch($selectmode){
     case "All":
        $query = "SELECT stu.name, s.question_num, s.result FROM survey_results s join student_info stu using (student_id)WHERE survey_id  = '$survey_tag' AND student_id = '$student_id' ORDER BY question_num";
        break;
     default:
    	$query = "SELECT stu.name, s.question_num, s.result FROM survey_results s join student_info stu using (student_id)WHERE survey_id  = '$survey_tag' AND question_num=".$question_map[$selectmode];
    	break;
}




?>

<p>
The query:
<p>
<?php

echo $query;

?>

<hr>
<p>
Result of
<?php

echo $selectmode;

?>

<p>

<?php


print "<pre>";

// The mysqli way of querying the database.
if($stmt = $conn -> prepare($query)){


	$stmt -> execute();
	// Identifiers post-fixed with 'fetch' - otherwise wasn't sure if would cause clash.
	$stmt -> bind_result($name_fetch, $question_num_fetch, $result_fetch);
     
    // Currently data is output in HTML. Will change to JSON in future.
   
    
    }

echo "<table style=\"width:50%\">";
	while($stmt -> fetch()){
		echo "\n";
		echo "<tr><td>$name_fetch</td>
				  <td>$question_num_fetch</td>
		          <td>$result_fetch</td><tr>";
	}
echo "</table>";



print "</pre>";

$stmt->close();

mysqli_close($conn);

?>

</body>
</html>
	  