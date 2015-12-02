<?php

// ==================================================================
// Project:   PandaHat > Iter3 backend php > FetchSort.php (Stub)
// Authors:   Panda_M
// Created:   2015-12-01
// Modified:  2015-12-01
// ==================================================================


// ------------------------------------------------------------------
// Initialize return value to the failure message state.
// ------------------------------------------------------------------

$return_value = json_decode('{"debug": null, "data": {"success": false, "student_ord_list": null} }');

// Usage: die(bake_with_debug($return_value, 'Info about error...'));
function bake_with_debug($mutable_return_value, $debug_string)
{
    $mutable_return_value->debug = $debug_string;
    return json_encode($mutable_return_value);
}



// ------------------------------------------------------------------
// Read GET parameters.
// ------------------------------------------------------------------

$survey_tag = (array_key_exists('survey_tag', $_GET)) ?  $_GET['survey_tag'] : 'no_survey_tag_provided';
$select_mode = (array_key_exists('selectmode', $_GET)) ? $_GET['selectmode'] : 'q9001';  // Expecting string like "q32" or "q5".

$question_num = (int) substr($select_mode, 1);


// ------------------------------------------------------------------
// Dummy return data.
// ------------------------------------------------------------------

class StudentAns
{
	public $student_id;
	public $name;
	public $response;

	public function __construct($new_student_id, $new_name, $new_response)
	{
		$this->student_id = $new_student_id;
        $this->name = $new_name;
        $this->response = $new_response;
	}
}

$student_ans_list = array();
for ($i = 1; $i <= 15; $i++)
{
	$score = ($i % 5) + 1;
	$new_student_ans = new StudentAns(950000000 + $i, "firstname$i creativeguy", $score);
	$student_ans_list[] = $new_student_ans;
}


// ------------------------------------------------------------------
// Return with success (must return JSON).
// ------------------------------------------------------------------

$return_value->debug = "survey_tag was $survey_tag, selectmode was $selectmode";
$return_value->data->success = TRUE;
$return_value->data->student_ord_list = $student_ans_list;
echo json_encode($return_value);


?>