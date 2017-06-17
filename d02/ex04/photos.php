#!/usr/bin/php
<?php
if ($argc == 2)
{
	$host = parse_url($argv[1], PHP_URL_HOST);
    $c = curl_init();

    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $argv[1]);
	$str = curl_exec($c);
	curl_close($c);

	preg_match_all("/<\s*img[^>]*src=[\'|\"](.*?)[\'|\"][^>]*>/si", $str, $tab);

	mkdir($host);
}
?>