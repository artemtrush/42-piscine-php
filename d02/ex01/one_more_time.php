#!/usr/bin/php
<?php
if ($argc == 2)
{
	if (preg_match('/^([L|l]undi|[M|m]ardi|[M|m]ercredi|[J|j]eudi|[V|v]endredi|[S|s]amedi|[D|d]imanche) \d{1,2} ([J|j]anvier|[F|f]évrier|[M|m]ars|[A|a]vril|[M|m]ai|[J|j]uin|[J|j]uillet|[A|a]oût|[S|s]eptembre|[O|o]ctobre|[N|n]ovembre|[D|d]écembre) \d{4} \d{2}:\d{2}:\d{2}$/', $argv[1]))
	{
		$str = $argv[1];
		$str = preg_replace('/[L|l]undi/', 'Monday', $str);
		$str = preg_replace('/[M|m]ardi/', 'Tuesday', $str);
		$str = preg_replace('/[M|m]ercredi/', 'Wednesday', $str);
		$str = preg_replace('/[J|j]eudi/', 'Thursday', $str);
		$str = preg_replace('/[V|v]endredi/', 'Friday', $str);
		$str = preg_replace('/[S|s]amedi/', 'Saturday', $str);
		$str = preg_replace('/[D|d]imanche/', 'Sunday', $str);
		
		$str = preg_replace('/[J|j]anvier/', 'January', $str);
		$str = preg_replace('/[F|f]évrier/', 'February', $str);
		$str = preg_replace('/[M|m]ars/', 'March', $str);
		$str = preg_replace('/[A|a]vril/', 'April', $str);
		$str = preg_replace('/[M|m]ai/', 'May', $str);
		$str = preg_replace('/[J|j]uin/', 'June', $str);
		$str = preg_replace('/[J|j]uillet/', 'July', $str);
		$str = preg_replace('/[A|a]oût/', 'August', $str);
		$str = preg_replace('/[S|s]eptembre/', 'September', $str);
		$str = preg_replace('/[O|o]ctobre/', 'October', $str);
		$str = preg_replace('/[N|n]ovembre/', 'November', $str);
		$str = preg_replace('/[D|d]écembre/', 'December', $str);

		date_default_timezone_set('Europe/Paris');
		$res = strtotime($str);
		echo "$res\n";
	}
	else
		echo "Wrong Format\n";
}
?>