#!/usr/bin/php
<?php
date_default_timezone_set('Europe/Kiev');
$fd = fopen("/var/run/utmpx", "rb");
fread($fd, 1256);
 
$tab = array();
while ($str = fread($fd, 628))
    $tab[] = unpack("a256usr/@260/a32console/@296/Ltype/Vdate", $str);
uasort($tab, function($a, $b)
{
    return (strcmp($a['console'], $b['console']));
});
 
foreach ($tab as $mas)
{
	if ($mas['type'] == 7 || $mas['type'] == 6)
	{
    	$date = new DateTime;
    	$date->setTimestamp($mas['date']);
    	$time = preg_replace('/([a-z]) (\d)/', '$1  $2', $date->format("M j H:i"));
    	printf("%-258s %8s  %s\n", $mas['usr'], $mas['console'], $time);
    }
}
fclose($fd);
?>