<?php
function ft_is_sort($tab)
{
	$tmp1 = $tab;
	$tmp2 = $tab;
	sort($tmp1);
	rsort($tmp2);
	if (array_diff_assoc($tab, $tmp1) && array_diff_assoc($tab, $tmp2))
		return false;
	else
		return true;
}
?>