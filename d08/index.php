<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once("game/Game.class.php");
require_once("maps/Map.class.php");
require_once("player/Player.class.php");
require_once("ships/Ship.class.php");

if (!isset($_SESSION['game']))
{
	$M_field = new Map('maps/map.txt');
	$map = $M_field->getMap();
	$flot[1] = new Ship(array('txt' => 'ships/texture/Imperial_Frigate.txt', 'dir' => 2,
		'id' => 1, 'x' => 20, 'y' => 20, 'hp' => 100, 'sp' => 15, 'dmg' => 1, 'shld' => 30));
	$flot[2] = new Ship(array('txt' => 'ships/texture/Imperial_Frigate.txt', 'dir' => 4,
		'id' => 2, 'x' => 130, 'y' => 85, 'hp' => 100, 'sp' => 15, 'dmg' => 1, 'shld' => 30));
	$flot[3] = new Ship(array('txt' => 'ships/texture/User.txt', 'dir' => 2,
		'id' => 3, 'x' => 20, 'y' => 45, 'hp' => 50, 'sp' => 30, 'dmg' => 1, 'shld' => 30));
	$flot[4] = new Ship(array('txt' => 'ships/texture/User.txt', 'dir' => 4,
		'id' => 4, 'x' => 130, 'y' => 65, 'hp' => 50, 'sp' => 30, 'dmg' => 1, 'shld' => 30));
	$player_1 = new Player('atrush');
	$player_2 = new Player('cheater');

	foreach ($flot as $ship) 
	{
		if ($ship->id % 2 != 0)
			$player_1->ships_id[] = $ship->id;
		else
			$player_2->ships_id[] = $ship->id;
	}

	$_SESSION['game'] = serialize(new Game(array('p1' => $player_1, 'p2' => $player_2,
										'map' => $map, 'flot' => $flot)));
}
$game = unserialize($_SESSION['game']);
if (isset($_POST['submit']))
{
	if ($_POST['submit'] == "New Game")
	{
		session_unset();
		header("Refresh:0");
		exit ;
	}
	else
		$game->make_changes($_POST['submit']);
}
$arr = $game->generate_map();
$turn = $game->turn;

$_SESSION['game'] = serialize($game);
?>
<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="css/map.css">
	<title>Warshipper: 42000</title>
</head>
<body>
<form action="index.php" method="POST">
	<br>
	<div class="arena">
	<div class="crop"><img src="res/me.jpg"></div>
	<div class="field">
		<table class="mtab">
			<?php for ($i = 0; $i < 100; $i++) { ?>
				<tr>
					<?php for ($j = 0; $j < 150; $j++) { ?>
						<td 
							<?php 
							$val = $arr[$i * 150 + $j];
							if ($val > 0 && $val % 2 == 1)
								echo 'class="'."cp1".'"';
							else if ($val > 0 && $val % 2 == 0)
								echo 'class="'."cp2".'"';
							?>
						"></td>
					<?php } ?>
				</tr>
			<?php } ?>
		</table>
	</div>
	</div>
<div class="fase">

	<?php if ($turn == 1){ ?>
		<div class="p1">
			 <div class="order">
			 <span>Points left: <?php echo $game->getPP(); ?></span>
			 <input type="submit" name='submit' value="Damage">
			 <input type="submit" name='submit' value="Speed">
			 <input type="submit" name='submit' value="Shield">
			 </div>
		</div>
	<?php } else { ?>
		<div class="p1 hide">
			I
		</div>
	<?php } ?>

	<?php if ($turn == 2){ ?>
		<div class="p2">
			<img class="shtur" src="res/shtur.png">
			<span class="dst">Distance left: <?php echo $game->getSP(); ?></span>
			<input type="submit" name='submit' class="LR R" value="RightR">
			<input type="submit" name='submit' class="LR L" value="LeftR">
			<input type="submit" name='submit' class="go" value="Go!">
		</div>
	<?php } else { ?>
		<div class="p2 hide">
			II
		</div>
	<?php } ?>
	
	<?php if ($turn == 3){ ?>
		<div class="p3">
			<div class="vector">
			<div class="vec_div"></div>
			<input type="submit" name='submit' value="Up">
			<div class="vec_div"></div>
			<input type="submit" name='submit' value="Left">
			<div class="vec_div"></div>
			<input type="submit" name='submit' value="Right">
			<div class="vec_div"></div>
			<input type="submit" name='submit' value="Down">
			<div class="vec_div"></div>
			</div>
		</div>
	<?php } else { ?>
		<div class="p3 hide">
			III
		</div>
	<?php } ?>
</div>

<div class="name">

<?php if ($game->END) { ?>
	<div><?php echo $game->result; ?></div>
	<input class="skip" name='submit' type="submit" value="New Game">
<?php } else { ?>
	<div><?php echo $game->get_player_name()." ".$game->getHP()."(".$game->getSH().")"; ?></div>
	<input class="skip" name='submit' type="submit" value="Skip Phase">
<?php } ?>

</div>
</form>
</table>
</body>
</html>
