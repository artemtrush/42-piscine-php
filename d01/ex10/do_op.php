#!/usr/bin/php
<?PHP
if ($argc == 4)
{
	$f = 1;
	$s1 = trim($argv[1]);
	$s2 = trim($argv[2]);
	$s3 = trim($argv[3]);

	if ($s2 == "+")
		$r = $s1 + $s3;
	else if ($s2 == "-")
		$r = $s1 - $s3;
	else if ($s2 == "*")
		$r = $s1 * $s3;
	else if ($s2 == "/")
		$r = $s1 / $s3;
	else if ($s2 == "%")
		$r = $s1 % $s3;
	else
		$f = 0;
	if ($f == 1)
		echo "$r\n";
}
?>