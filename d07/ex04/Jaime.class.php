<?php
class Jaime
{
	public function sleepWith($someone)
	{
		if ($someone instanceof Tyrion)
			print("Not even if I'm drunk !".PHP_EOL);
		if ($someone instanceof Sansa)
			print("Let's do this.".PHP_EOL);
		if ($someone instanceof Cersei)
			print("With pleasure, but only in a tower in Winterfell, then.".PHP_EOL);
	}
}
?>