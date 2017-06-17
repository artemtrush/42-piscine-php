<?php 
	function auth($login, $passwd)
	{
		if ($login && $passwd)
		{
			$file = file_get_contents('./../private/passwd');
			$data = unserialize($file);
			if ($data)
			{
				foreach ($data as $user)
				{
					if ($user['login'] === $login && $user['passwd'] === hash('whirlpool', $passwd))
						return (TRUE);
				}
			}
		}
		return (FALSE);
	}
?>