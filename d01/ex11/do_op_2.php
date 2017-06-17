#!/usr/bin/php
<?PHP
if ($argc == 2)
{
	if (!preg_match('/^\-?\d+\s*[\+\-\*\/\%]\s*\-?\d+$/', trim($argv[1])))
	{
		echo "Syntax Error\n";
		exit ;
	}
	$f = 1;
	$str = str_replace(" ", "", $argv[1]);
	list($s1, $s2, $s3, $err) = sscanf($str, "%d%c%d%s");
	if (!is_numeric($s1) || $s2 == null || !is_numeric($s3) || $err != null)
		echo "Syntax Error\n";
	else
	{
		if ($s2 == "+")
			$r = $s1 + $s3;
		else if ($s2 == "-")
			$r = $s1 - $s3;
		else if ($s2 == "*")
			$r = $s1 * $s3;
		else if ($s2 == "/")
		{
			if ($s3 == 0)
				$f = 0;
			else
				$r = $s1 / $s3;
		}
		else if ($s2 == "%")
		{
			if ($s3 == 0)
				$f = 0;
			else
				$r = $s1 % $s3;
		}
		else
			$f = 0;
		if ($f == 1)
			echo "$r\n";
		else
			echo "Syntax Error\n";
	}
}
else
	echo "Incorrect Parameters\n";
?>