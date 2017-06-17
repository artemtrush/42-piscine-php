#!/usr/bin/php
<?PHP
	$tab = array();
	unset($argv[0]);
	foreach ($argv as $str)
	{
		$tmp = explode(" ", $str);
		$tab = array_merge($tab, $tmp);
	}
	$tab = array_filter($tab);
	sort($tab);
	foreach ($tab as $str)
		echo "$str\n";
?>