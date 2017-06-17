#!/usr/bin/php
<?PHP
$fd = fopen("php://stdin", "r");
while ($fd && !feof($fd))
{
	echo "Enter a number: ";
	$num = fgets($fd);
	if ($num)
	{
		$num = str_replace("\n", "", $num);
		if (!is_numeric($num))
			echo "'".$num."' is not a number\n";
		else if ($num % 2 == 0)
			echo "The number $num is even\n";
		else
			echo "The number $num is odd\n";
	}
}
fclose($fd);
echo "\n";
?>