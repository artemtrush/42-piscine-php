<?php
if ($_POST['login'] && $_POST['passwd'] && $_POST['submit'] && $_POST['submit'] === 'OK')
{
	if (!file_exists('./../private'))
		mkdir('./../private');
	if (file_exists('./../private/passwd'))
	{
		$file = file_get_contents('./../private/passwd');
		$data = unserialize($file);
		foreach ($data as $user)
			if ($user['login'] === $_POST['login'])
			{
				echo "ERROR\n";
				return ;
			}
	}
	$data['login'] = $_POST['login'];
	$data['passwd'] = hash('whirlpool', $_POST['passwd']);
	$mas[] = $data;
	file_put_contents('./../private/passwd', serialize($mas));
	echo "OK\n";
}
else
	echo "ERROR\n";
?>