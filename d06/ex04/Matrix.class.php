<?php

require_once 'Vector.class.php';

class Matrix
{
	const IDENTITY = "IDENTITY";
	const SCALE = "SCALE";
	const TRANSLATION = "TRANSLATION";
	const PROJECTION = "PROJECTION";
	const RX = "Ox ROTATION";
	const RY = "Oy ROTATION";
	const RZ = "Oz ROTATION";

	private $_matrix = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	private $_preset;
	private $_scale;
	private $_angle;
	private $_vtc;
	private $_fov;
	private $_ratio;
	private $_near;
	private $_far;

	public static $verbose = False;

	public static function doc()
	{
		return (file_get_contents('./Matrix.doc.txt'));
	}

	private function _definition()
	{
		switch ($this->_preset)
		{
			case self::IDENTITY:
				for ($i = 0; $i < 4; $i++)
					$this->_matrix[$i * 4 + $i] = 1;
				break ;
			case self::SCALE:
				for ($i = 0; $i < 3; $i++)
					$this->_matrix[$i * 4 + $i] = $this->_scale;
				$this->_matrix[15] = 1; 	
				break ;
			case self::TRANSLATION:
				for ($i = 0; $i < 4; $i++)
					$this->_matrix[$i * 4 + $i] = 1;
				$this->_matrix[3] = $this->_vtc->getX();
				$this->_matrix[7] = $this->_vtc->getY();
				$this->_matrix[11] = $this->_vtc->getZ();
				break ;
			case self::PROJECTION:
				$this->_matrix[0] = pow(tan(0.5 * $this->_fov), -1) / $this->_ratio;
				$this->_matrix[5] = pow(tan(0.5 * $this->_fov), -1);
				$this->_matrix[10] = -($this->_far + $this->_near) / ($this->_far - $this->_near);
				$this->_matrix[11] = -2 * ($this->_far * $this->_near) / ($this->_far - $this->_near);
				$this->_matrix[14] = -1;
				break ;
			case self::RX:
				$this->_matrix[0] = 1;
				$this->_matrix[15] = 1;
				$this->_matrix[5] = cos($this->_angle);
				$this->_matrix[6] = -sin($this->_angle);
				$this->_matrix[9] = sin($this->_angle);
				$this->_matrix[10] = cos($this->_angle);
				break ;
			case self::RY:
				$this->_matrix[5] = 1;
				$this->_matrix[15] = 1;
				$this->_matrix[0] = cos($this->_angle);
				$this->_matrix[2] = sin($this->_angle);
				$this->_matrix[8] = -sin($this->_angle);
				$this->_matrix[10] = cos($this->_angle);
				break ;
			case self::RZ:
				$this->_matrix[10] = 1;
				$this->_matrix[15] = 1;
				$this->_matrix[0] = cos($this->_angle);
				$this->_matrix[1] = -sin($this->_angle);
				$this->_matrix[4] = sin($this->_angle);
				$this->_matrix[5] = cos($this->_angle);
				break ;
		}
	}

	private function _emptyMatrix()
	{
		$bool = self::$verbose;
		self::$verbose = False;
		$mat = new Matrix(array('preset' => self::IDENTITY));
		self::$verbose = $bool;
		return ($mat);
	}

	public function mult(Matrix $rhs)
	{
		$m1 = $this->getMatrix();
		$m2 = $rhs->getMatrix();
		$res = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		for ($i = 0; $i < 4; $i++)
			for ($j = 0; $j < 4; $j++)
				for ($k = 0 ; $k < 4; $k++)
					$res[$i * 4 + $j] += $m1[$i * 4 + $k] * $m2[$k * 4 + $j];
		$mat = $this->_emptyMatrix();
		$mat->_matrix = $res;
		return ($mat);
	}

	public function transformVertex(Vertex $vtx)
	{
		$m = $this->getMatrix();
		$v = array($vtx->getX(), $vtx->getY(), $vtx->getZ(), $vtx->getW());
		$nv = array(0, 0, 0, 0);
		for ($i = 0; $i < 4; $i++)
			for ($j = 0; $j < 4; $j++)
				$nv[$i] += $m[$i * 4 + $j] * $v[$j];
		return (new Vertex(array('x' => $nv[0], 'y' => $nv[1],
			'z' => $nv[2], 'w' => $nv[3], 'color' => $vtx->getColor())));
	}

	public function rotate()
	{
		$arr = $this->getMatrix();
		$rot_arr = array();
		$i = 0;
		foreach ($arr as $value)
		{
			$rot_arr[$i] = $value;
			$i += 4;
			if ($i > 15)
				$i -= 15;
		}
		$res = $this->_emptyMatrix();
		$res->_matrix = $rot_arr;
		return ($res);
	}

	public function getMatrix()
	{
		return ($this->_matrix);
	}

	function __toString()
	{
		return ("M | vtcX | vtcY | vtcZ | vtxO".PHP_EOL.
				"-----------------------------".PHP_EOL.
		sprintf("x | %0.2f | %0.2f | %0.2f | %0.2f",
		$this->_matrix[0], $this->_matrix[1], $this->_matrix[2], $this->_matrix[3]).PHP_EOL.
		sprintf("y | %0.2f | %0.2f | %0.2f | %0.2f",
		$this->_matrix[4], $this->_matrix[5], $this->_matrix[6], $this->_matrix[7]).PHP_EOL.
		sprintf("z | %0.2f | %0.2f | %0.2f | %0.2f",
		$this->_matrix[8], $this->_matrix[9], $this->_matrix[10], $this->_matrix[11]).PHP_EOL.
		sprintf("w | %0.2f | %0.2f | %0.2f | %0.2f",
		$this->_matrix[12], $this->_matrix[13], $this->_matrix[14], $this->_matrix[15]));
	}

	function __construct(array $keys)
	{
		if (isset($keys['preset']))
		{
			if ($keys['preset'] === self::IDENTITY)
				$this->_preset = self::IDENTITY;
			else if ($keys['preset'] === self::SCALE && isset($keys['scale']))
			{
				$this->_preset = self::SCALE;
				$this->_scale = $keys['scale'];
			}
			else if (($keys['preset'] === self::RX || $keys['preset'] === self::RY ||
				$keys['preset'] === self::RZ) && isset($keys['angle']))
			{
				$this->_preset = $keys['preset'];
				$this->_angle = $keys['angle'];
			}
			else if ($keys['preset'] === self::TRANSLATION && isset($keys['vtc'])
				&& $keys['vtc'] instanceof Vector)
			{
				$this->_preset = self::TRANSLATION;
				$this->_vtc = $keys['vtc'];
			}
			else if ($keys['preset'] === self::PROJECTION && isset($keys['fov']) && isset($keys['ratio'])
				&& isset($keys['near']) && isset($keys['far']) && !empty($keys['ratio']))
			{
				$this->_preset = self::PROJECTION;
				$this->_fov = deg2rad($keys['fov']);
				$this->_ratio = $keys['ratio'];
				$this->_near = $keys['near'];;
				$this->_far = $keys['far'];
			}
			else
				exit("Invalid parameters".PHP_EOL);
		}
		else
			exit("Invalid parameters".PHP_EOL);

		$this->_definition();

		if (self::$verbose)
		{
			echo "Matrix ".$this->_preset;
			if ($this->_preset != self::IDENTITY)
				echo " preset";
			echo " instance constructed".PHP_EOL;
		}
	}

	function __destruct()
	{
		if (self::$verbose)
			echo "Matrix instance destructed".PHP_EOL;
	}
}
?>