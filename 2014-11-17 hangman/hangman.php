<!doctype html>
<html>
	<head>
		<title>2014-11-17 Hangman</title>
	</head>
	<body>
<?php
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
			fwrite($handle, $chosen);
			fclose($handle);			
			endif;
		else :?>
		Please, <a href="hangman.php">try again</a>
		<?php	
		endif;
	elseif (isset($_GET["letter"])) :
	
	else : ?>
		Please, <a href="hangman.php">try again</a>
	<?php	
	endif;
	
	function printStuff($letter = "") {
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
		//print graphics here
		
	}
?>
	</body>
</html>