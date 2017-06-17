<?php
if ($_GET['action'] === "set" && $_GET['name'] && $_GET['value'])
	setcookie($_GET['name'], $_GET['value'], time() + 2592000, '/');
else if ($_GET['action'] === "get" && $_GET['name'])
{
	foreach ($_COOKIE as $key => $value)
	{
		if ($key == $_GET['name'])
			echo $value."\n";
	}
}
else if ($_GET['action'] === "del" && $_GET['name'])
	setcookie($_GET['name'], '', time() - 3600);
?>