<?php
	$numbers = array("I" => 1,
					 "V" => 5,
					 "X" => 10,
					 "L" => 50,
					 "C" => 100,
					 "D" => 500,
					 "M" => 1000);
	$postStr = strtoupper(filter_input(INPUT_POST, "str", FILTER_SANITIZE_STRING));
	$thousands = 0;
	$value = 0;	
	for ($i = 0; $i < strlen($postStr); $i++) {
		$temp = 0;
		if ($postStr[$i] == "(") {
			$thousands++;
		} else if ($postStr[$i] == ")") {
			if ($thousands > 0) {
				$value *= 1000;
				$thousands--;
			}
		} else {
			if ($numbers[$postStr[$i]] != null) {
				if (strlen($postStr) > ($i+1)) {
					if ( (($postStr[$i] == "I") && (($postStr[$i+1] == "V") || ($postStr[$i+1] == "X"))) ||
						 (($postStr[$i] == "X") && (($postStr[$i+1] == "L") || ($postStr[$i+1] == "C"))) ||
						 (($postStr[$i] == "C") && (($postStr[$i+1] == "D") || ($postStr[$i+1] == "M"))) ) {						 
						 $temp = $numbers[$postStr[$i+1]] - $numbers[$postStr[$i]];
						 $i++;
					} else {
						$temp = $numbers[$postStr[$i]];
					}
				} else {
					$temp = $numbers[$postStr[$i]];
				}
			}
		}
		$value += $temp;
	}
	echo $value;
?>