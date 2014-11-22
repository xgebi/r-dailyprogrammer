<!doctype html>
<html>
	<head>
		<title>2014-11-17 Hangman</title>
	</head>
	<body>
<?php
	define("WORD", 0);
	define("LETTERS", 1);
	define("ERRORS", 2);

	if (!isset($_GET["letter"]) && !isset($_GET["difficulty"])) : ?>		
		<h1>Difficulty settings</h1>
		<form method="post" action="?difficulty">
			<input type="radio" name="diff" value="easy" /> Easy<br />
			<input type="radio" name="diff" value="medium" /> Medium<br />
			<input type="radio" name="diff" value="hard" /> Hard<br />
			<input type="submit" value="Choose difficulty" />
		</form>
	<?php		
	elseif (isset($_GET["difficulty"])) :
		if (isset($_POST["diff"])) :
			$min = 0;
			$max;
			switch ($_POST["diff"]) {
				case "easy":
					$min = 7;
					$max = -1;
					break;
				case "medium":
					$min = 5;
					$max = 7;
					break;
				case "hard":
					$min = 3;
					$max = 5;
					break;			
				default:
			}
			if ($min == 0) : ?>
				Please, <a href="hangman.php">try again</a>
				<?php
			else :
				$handle = @fopen("hangman.txt", "r");
				$list = [];
				if ($handle) {
					while (($buffer = fgets($handle, 4096)) !== false) {
						$list[] = $buffer;
						if ($min == 7) {
							if ((strlen($buffer) > $max) && (strlen($buffer) > 7))
								$max = strlen($buffer);
						}
					}
					if (!feof($handle)) {
				        echo "Error: unexpected fgets() fail\n";
				    }
			    	fclose($handle);
				}
				$start = rand(0, count($list)-1);
				$chosen = "";
				$startedAgain = false;
				for ($i = $start; $i<count($list); $i++) {
					if ((strlen($list[$i]) >= $min) && (strlen($list[$i]) <= $max)) {
						$chosen = $list[$i];
						break;
					}
					if ($i == (count($list)-1)) {
						$i = 1;
						$startedAgain = true;	
					}
					if ($startedAgain && ($i == $start))
						die("Wrong word list");
				}
				$handle = fopen("temp", "w");
				fwrite($handle, strtolower($chosen));
				fclose($handle);			
				printStuff();
			endif;
		else :?>
		Please, <a href="hangman.php">try again</a>
		<?php	
		endif;
	elseif (isset($_GET["letter"])) :
		//print_r($_POST);
		printStuff($_POST["letter"]);
	else : ?>
		Please, <a href="hangman.php">try again</a>
	<?php	
	endif;
	
	function printStuff($letter = "") {
		//echo $letter;
		$handle = fopen("temp", "r");
		$data = [];
		$i = 0;
		if ($handle) {
			while (($buffer = fgets($handle, 4096)) !== false) {
				$data[$i] = $buffer;
				$i++;
			}
			if (!feof($handle)) {
			    echo "Error: unexpected fgets() fail\n";
			}
			fclose($handle);
		} 
		if ($data[LETTERS] == null)
				$data[LETTERS] = "letters=";
		if ($data[ERRORS] == null)
				$data[ERRORS] = "errors=0";
		$data[WORD] = substr($data[WORD], 0, strlen($data[WORD])-1);
		if(strlen($letter) == 1) {
			if (strpos($data[WORD], $letter) >=0) {				
				$data[LETTERS] =trim($data[LETTERS]).trim($letter);
			} else {
				$err = substr($data[ERRORS], strpos($data[ERRORS], "=")+1);
				$err++;
				$data[ERRORS] = "errors=".trim($err);
			}
				
		}
		$handle = fopen("temp", "w");
		fwrite($handle, trim($data[WORD])."\n".trim($data[LETTERS])."\n".trim($data[ERRORS]));
		fclose($handle);
		
		$toPrint;
		if ((strpos($data[LETTERS], "=") == (strlen($data[LETTERS])-1)) || ($data[LETTERS] == null)) {
			//echo "problem";
			for ($i = 0; $i < strlen($data[WORD]); $i++) {
				$toPrint .= "_ ";
			}
		} else {
			//echo "better";
			$letters = substr($data[LETTERS], strpos($data[LETTERS], "=")+1 );		
			$tempToPrint = [];
			for ($i = 0; $i < strlen($data[WORD]); $i++) {
				$tempToPrint[$i] = "_";
				for ($j = 0; $j < strlen($letters); $j++) {
					if ($data[WORD][$i] == $letters[$j]) {
						$tempToPrint[$i] = $letters[$j];
						break;
					}
				}				
			}
			$toPrint = implode(" ", $tempToPrint);
		}
		//print graphics here
		echo $toPrint;
		?>
			<form action="hangman.php?letter" method="post">
				<input type="text" name="letter" />
				<input type="submit" value="Try letter" />
			</form>
		<?php
	}
?>
	</body>
</html>