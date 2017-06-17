<?php
class Color
{
	public $red, $green, $blue;

	public static $verbose = False;

	public static function doc()
	{
		return (file_get_contents('./Color.doc.txt'));
	}

	public function add($another_argument)
	{
		 return (new Color(array(
		 	'red' =>  $this->red + $another_argument->red,
		 	'green' =>  $this->green + $another_argument->green,
		 	'blue' => $this->blue + $another_argument->blue)));
	}

	public function sub($another_argument)
	{
		 return (new Color(array(
		 	'red' =>  $this->red - $another_argument->red,
		 	'green' =>  $this->green - $another_argument->green,
		 	'blue' => $this->blue - $another_argument->blue)));
	}

	public function mult($another_argument)
	{
		 return (new Color(array(
		 	'red' =>  $this->red * $another_argument,
		 	'green' =>  $this->green * $another_argument,
		 	'blue' => $this->blue * $another_argument)));
	}

	function __toString()
	{
		return (sprintf("Color( red: %3d, green: %3d, blue: %3d )",
			$this->red, $this->green, $this->blue));
	}

	function __construct(array $kwargs)
	{
		if (isset($kwargs['rgb']))
		{
			$this->red = intval($kwargs['rgb'] >> 16);
			$this->green = intval(($kwargs['rgb'] >> 8) & 255);
			$this->blue = intval($kwargs['rgb'] & 255);
		}
		else if (isset($kwargs['red']) && isset($kwargs['green']) && isset($kwargs['blue']))
		{
			$this->red = intval($kwargs['red']);
			$this->green = intval($kwargs['green']);
			$this->blue = intval($kwargs['blue']);
		}
		else
			exit("Invalid parameters".PHP_EOL);

		if (self::$verbose)
			echo $this." constructed.".PHP_EOL;
	}

	function __destruct()
	{
		if (self::$verbose)
			echo $this." destructed.".PHP_EOL;
	}
}
?>