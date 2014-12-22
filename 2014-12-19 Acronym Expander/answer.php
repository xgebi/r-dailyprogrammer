<?php
	$postStr = filter_input(INPUT_POST, "str", FILTER_SANITIZE_STRING);
	$wordlist = array(
					"lol" => "laugh out loud",
					"dw" => "don't worry",
					"hf" => "have fun",
					"gg" => "good game",
					"brb" => "be right back",
					"g2g" => "got to go",
					"wtf" => "what the fuck",
					"wp" => "well played",
					"gl" => "good luck",
					"imo" => "in my opinion"
					);
	$listOfWords = explode(" ", $postStr);
	for ($i = 0; $i < count($listOfWords); $i++) {
		$addDot = false;
		$temp = $listOfWords[$i];
		if (strpos($listOfWords[$i], ".") !== false) {
			$temp = substr($temp, 0, strlen($listOfWords[$i])-1);
			$addDot = true;
		}
		if ($wordlist[$temp] != null) {
			$listOfWords[$i] = $wordlist[$temp];
		}
		if ($addDot) {
			$listOfWords[$i] .= ".";
		}
	}
	echo implode(" ", $listOfWords);
?>