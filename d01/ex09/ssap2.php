#!/usr/bin/php
<?PHP
	function  cmp($s1, $s2)
	{
		if ($s1[0] == $s2[0])
		{
			if (!$s1[1])
				return (0);
			if (!$s2[1])
				return (1);
			return (cmp(substr($s1, 1), substr($s2, 1)));
		}
		$c1 = $s1[0];
		$c2 = $s2[0];
		if (ctype_alpha($c1) && ctype_alpha($c2))
		{
			if (ord($c1) + 32 == ord($c2))
				return (0);
			else if (ord($c2) + 32 == ord($c1))
				return (1);
			if (strtoupper($c1) > strtoupper($c2))
				return (1);
		}
		else if (is_numeric($c1) && is_numeric($c2))
		{
			if ($c1 > $c2)
				return (1);
		}
		else if (ctype_alpha($c2))
			return (1);
		else if (is_numeric($c2) && !ctype_alpha($c1))
			return (1);
		else if (!ctype_alnum($c1) && !ctype_alnum($c2))
		{
			if ($c1 > $c2)
				return (1);
		}
		return (0);
	}

	$tab = array();
	unset($argv[0]);
	foreach ($argv as $str)
	{
		$tmp = explode(" ", $str);
		$tmp = array_filter($tmp);
		$tab = array_merge($tab, $tmp);
	}

	$j = count($tab);
	while ($j > 0)
	{ 
		$i = 0;
		$j--;
		while ($i < count($tab) - 1)
		{
			if (cmp($tab[$i], $tab[$i + 1]))
			{
				$tmp = $tab[$i];
				$tab[$i] = $tab[$i + 1];
				$tab[$i + 1] = $tmp; 
			}
			$i++;
		}
	}
	foreach ($tab as $str)
		echo "$str\n";
?>