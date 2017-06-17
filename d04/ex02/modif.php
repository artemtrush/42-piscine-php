<?php
if ($_POST['login'] && $_POST['oldpw'] && $_POST['newpw'] && $_POST['submit'] && $_POST['submit'] === 'OK')
{
	$file = file_get_contents('./../private/passwd');
	$data = unserialize($file);
	if ($data)
	{
		foreach ($data as $user)
			if ($user['login'] === $_POST['login'])
			{
				if ($user['passwd'] === hash('whirlpool', $_POST['oldpw']))
				{ 
					$new['login'] = $_POST['login'];
					$new['passwd'] = hash('whirlpool', $_POST['newpw']);
					$mas[] = $new;
					file_put_contents('./../private/passwd', serialize($mas));
					echo "OK\n";
				}
				else
					echo "ERROR\n";
				return ;
			}
	}
}
echo "ERROR\n";
?>