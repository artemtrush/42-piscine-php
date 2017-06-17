#!/usr/bin/php
<?PHP 
if ($argc > 1 && $argv[1])
{
	$tab = explode(" ", $argv[1]);
	$tab = array_filter($tab);
	$i = 0;
	foreach ($tab as $str)
	{
		if ($i > 0)
			echo " ";
		echo "$str";
		$i++;
	}
}
if ($argc > 1)
	echo "\n";
?>