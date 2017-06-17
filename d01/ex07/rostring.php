#!/usr/bin/php
<?PHP 
if ($argc > 1 && $argv[1])
{
	$tab = explode(" ", $argv[1]);
	$tab = array_filter($tab);
	$i = 0;
	foreach ($tab as $str)
	{
		if ($i > 1)
			echo " ";
		if ($i > 0)
			echo "$str";
		else
			$tmp = $str;
		$i++;
	}
	if ($i > 1)
		echo " ";
	if ($i > 0)
		echo $tmp;
}
if ($argc > 1)
	echo "\n";
?>