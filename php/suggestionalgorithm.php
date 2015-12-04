<?php

// ==================================================================
// Project:   PandaHat > Iter4? backend php > suggestionalgorithm.php
// Authors:   Panda_M (& Panda_S contributed to design)
// Created:   2015-12-02
// Modified:  2015-12-02
//
// Purpose:   Function definitions to implement the Simple Suggestion Algorithm.
// ==================================================================


// ==================================================================
// Algorithm I/O
//
// Input: {StuId-1: [[RoleNum-1, Response-1], […], …], …, StuId-i: […, [RoleNum-j, Response-j], …], …}
//   where StuId-i is of Int, RoleNum-j is of Int, Response-j is of Bool.
//
// Output: [Group-1, Group-2, …]
//   where Group-i is of [StuId-i1, StuId-i2, ...] 
// ==================================================================

// Access like SugAlg::compute_groups();

class SugAlg
{

    // Main Algorithm.
    public static function compute_groups( $input_data )
    {

        // Step 1: Set up empty groups & alternative format of input.
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        $Num_Stu = count($input_data);
        //$Num_Groups = ($Num_Stu - $Num_Stu % 5) / 5;
        $Num_Groups = 4;  //DEBUG.

        $Groups = [];
        $NeededRoles = [];
        for ($i = 1; $i <= $Num_Groups; $i++)
        {
        	$Groups[$i] = [];
        	$NeededRoles[$i] = [TRUE, TRUE, TRUE, TRUE];  // Bitfield for 1, 2, 3, 4.
        }

        $StuCapabilities = array();
        foreach (array_keys($input_data) as $S_i)
            $StuCapabilities[$S_i] = [];
        $RolePools = array(1=>[], 2=>[], 3=>[], 4=>[]);

        foreach ($input_data as $S_i => $RoleRespList_i)
        {
        	foreach ($RoleRespList_i as list($RoleNum_j, $RoleResp_j))
	            if ($RoleResp_j)
	        	{
	        		$RolePools[$RoleNum_j][] = $S_i;
	        		$StuCapabilities[$S_i][] = $RoleNum_j;
	        	}
        }


        // Step 2:
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Arbitrarily pick one of the smallest in RolePools. (Cred: Amal Murali)
        $PoolSizes = array_map('count', $RolePools);
		$MinPoolSize = min($PoolSizes);
		$MinIndex = array_flip($PoolSizes)[$MinPoolSize];
		$RarePool = $RolePools[$MinIndex];

		$NumToDistribute = min(count($RarePool), $Num_Groups);
		for ($count = 1; $count <= $NumToDistribute; $count++)
		{
			$S = array_pop($RarePool);
			SugAlg::AddStudent($S, $Groups[$count], $StuCapabilities, $NeededRoles[$count]);
		}


        // Step 3:
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


    	return $Groups;
    }


    // Subroutine AddStudent
    private static function AddStudent($StuId, &$Group_x, $StuCapabilities, &$NeededRoles_x)
    {
    	$Group_x[] = $StuId;  // Technically, should watch for duplicates.
    	foreach ($StuCapabilities[$StuId] as $R)
    		$NeededRoles_x[$R] = FALSE;
    }

}



?>