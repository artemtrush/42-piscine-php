#!/usr/bin/php
<?php
if ($argc == 2 && file_exists($argv[1]))
{
	$html = '';
	$file = fopen($argv[1], "r");
	while ($file && !feof($file))
		$html .= fgets($file);
	fclose($file);

	$tab = explode("</a>", $html);
	for ($i =0; $i < count($tab) - 1; $i++)
	{
		preg_match('/<a.*>(.*)$/si', $tab[$i], $match, PREG_OFFSET_CAPTURE);
		for ($j = 0; $j < $match[0][1]; $j++)
			echo $tab[$i][$j];
		$str = $match[0][0];
		$str = preg_replace_callback("/( title=\")(.*?)(\")/s", function ($matches)
			{
				$tmp = ' title='.strtoupper(substr($matches[0], 7));
				return ($tmp);
			}, $str);
		$str = preg_replace_callback('/>.*?(<|$)/s', function ($matches)
			{
				return (strtoupper($matches[0]));
			}, $str);
		echo "$str</a>";
	}
	echo $tab[count($tab) - 1];
}
?>