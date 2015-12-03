<?php

// Project:   PandaHat > Iter2 backend php > FetchOneStudent.php
// Authors:   Panda_S (Panda_X)
// Created:   2015-12-1
// Modified:  2015-12-1

// See note in 'Give.php' about the use of mysqli.

// Defines $server, $user, $pass, $dbname, and $port.
include('connectionData.txt');


$return_value = json_decode('{"debug":null,"data":{"success":false,"student_list":null} }');
$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');


$question_result = array();
$question_list = array();
$student_list = array();

$survey_tag = $_POST['survey_tag'];
$student_id = $_POST['student_id'];

// Fetch survey results for one survey and one student. Also, list in sorted order.

//TODO: rename quiz_tag to survey_tag


$query = "SELECT student_id, question_num, result FROM survey_results WHERE survey_tag  = '$survey_tag'";
        
    
// The mysqli way of querying the database.
if($stmt = $conn -> prepare($query)){


	$stmt -> execute();
	// Identifiers post-fixed with 'fetch' - otherwise wasn't sure if would cause clash.
	$stmt -> bind_result($name_fetch, $question_num_fetch, $result_fetch);
     
    // Currently data is output in HTML. Will change to JSON in future.
   
    
    }
	while($stmt -> fetch()){
		
		$question_result[] = {$id_fetch,$question_num_fetch,$result_fetch};
		$question_list[] = $question_result;
		
		}


$counter = count($question_list);
$current_id = 0;

for($i=0; $i<$counter; $i++){
	$temp_list = array();
	if ($question_list[$i][0] != $current_id){
		if($question_list[$i][0]== 15 or $question_list[$i][0]== 16 or $question_list[$i][0]== 17 $question_list[$i][0]== 18 ){
				$temp_array = array();
				$temp_array [] = $question_list[$i][0];
				$temp_array [] = $question_list[$i][2];
				$current_id = $question_list[$i][0];
				$temp_list = array();
				$temp_list[]=$temp_array;
				$student_list = {$question_list[$i][0]=>$temp_list};}
		
	}
	else{
		if($question_list[$i][0]== 15 or $question_list[$i][0]== 16 or $question_list[$i][0]== 17 $question_list[$i][0]== 18 ){

			$temp_array  = array();
			$temp_array [] = $question_list[$i][0];
			$temp_array [] = $question_list[$i][2];
			$temp_list[]=$temp_array;
		}
	}
	
}





$stmt->close();


$return_value -> data ->success = true;
	
$return_value -> data ->student_list = $student_list;



echo json_encode($student_list);

mysqli_close($conn);

?>

	  