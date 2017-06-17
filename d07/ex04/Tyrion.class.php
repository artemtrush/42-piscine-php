<?php
class Tyrion
{
	public function sleepWith($someone)
	{
		if ($someone instanceof Jaime || $someone instanceof Cersei)
			print("Not even if I'm drunk !".PHP_EOL);
		if ($someone instanceof Sansa)
			print("Let's do this.".PHP_EOL);
	}
}
?>