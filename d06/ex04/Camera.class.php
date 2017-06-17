<?php

require_once 'Matrix.class.php';

class Camera
{
	private $_origin;
	private $_tT;
    private $_tR;
	private $_proj;  
    private $_width;
    private $_height;
    private $_ratio;

	public static $verbose = False;

	public static function doc()
	{
		return (file_get_contents('./Camera.doc.txt'));
	}

	public function watchVertex(Vertex $worldVertex)
	{
		$tmp = $this->_tR->transformVertex($worldVertex);
		$res = $this->_proj->transformVertex($tmp);
		$res->setColor($worldVertex->getColor());
		$res->setW($worldVertex->getW());
        $res->setX($res->getX() * $this->_ratio);
        $res->setY($res->getY() * $this->_ratio);
        return ($res);
	}

	function __toString()
	{
		return ("Camera( ".PHP_EOL.
				"+ Origine: ".$this->_origin.PHP_EOL.
				"+ tT:".PHP_EOL.$this->_tT.PHP_EOL.
				"+ tR:".PHP_EOL.$this->_tR.PHP_EOL.
				"+ tR->mult( tT ):".PHP_EOL.$this->_tR->mult($this->_tT).PHP_EOL.
				"+ Proj:".PHP_EOL.$this->_proj.PHP_EOL.")");
	}

	function __construct(array $keys)
	{
		$this->_origin = $keys['origin'];
		$vtc = new Vector(array('dest' => new Vertex(array(
			'x' => -($this->_origin->getX()),
			'y' => -($this->_origin->getY()),
			'z' => -($this->_origin->getZ()),
			'w' => $this->_origin->getW()))));
		$this->_tT = new Matrix(array('preset' => Matrix::TRANSLATION, 'vtc' => $vtc));

		$this->_width = (float)($keys['width'] / 2);
		$this->_height = (float)($keys['height'] / 2);
		$this->_ratio = $this->_width / $this->_height;
		$this->_proj = new Matrix(array('preset' => Matrix::PROJECTION, 'fov' => $keys['fov'],
			'near' => $keys['near'], 'far' => $keys['far'], 'ratio' => $this->_ratio));

		$mat = $keys['orientation'];
		$this->_tR = $mat->rotate();
	
		if (self::$verbose)
			echo "Camera instance constructed".PHP_EOL;
	}

	function __destruct()
	{
		if (self::$verbose)
			echo "Camera instance destructed".PHP_EOL;
	}
}
?>
