<?php

// Project:   PandaHat > Iter2 backend php > FetchOneStudent.php
// Authors:   Panda_S (Panda_X)
// Created:   2015-12-1
// Modified:  2015-12-1

// See note in 'Give.php' about the use of mysqli.

// Defines $server, $user, $pass, $dbname, and $port.
include('connectionData.txt');


$return_value = json_decode('{"debug":null,"data":{"success":false,"question_ord_list":null} }');
$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');


$question_result = array();
$question_list = array();
$survey_tag = $_POST['survey_tag'];
$student_id = $_POST['student_id'];

// Fetch survey results for one survey and one student. Also, list in sorted order.

//TODO: rename quiz_tag to survey_tag


$query = "SELECT stu.name, s.question_num, s.result FROM survey_results s join student_info stu using (student_id)WHERE survey_tag  = '$survey_tag' AND student_id = '$student_id' ORDER BY question_num";
        
    
// The mysqli way of querying the database.
if($stmt = $conn -> prepare($query)){


	$stmt -> execute();
	// Identifiers post-fixed with 'fetch' - otherwise wasn't sure if would cause clash.
	$stmt -> bind_result($name_fetch, $ID_question_num, $result_fetch);
     
    // Currently data is output in HTML. Will change to JSON in future.
   
    
    }
	while($stmt -> fetch()){
		
		$question_result[] = {$name_fetch,$ID_question_num,$result_fetch};
		$question_list[] = $question_result;
		
		}


$stmt->close();


$return_value -> data ->success = true;
	
$return_value -> data ->question_ord_list = $question_list;



echo json_encode($question_list);

mysqli_close($conn);

?>

	  