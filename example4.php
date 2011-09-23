<?php
/**
 * MC-Server-Status:
 * Extended server info with $_GET
 **/

// Include MC-SS Class
include('MinecraftStatus.class.php');
// Create a new Server Object
if(isset($_GET['IP']))
	$Server = new MinecraftStatus($_GET['IP'], isset($_GET['Port']) ? $_GET['Port'] : 25565);
else
	$Server = new MinecraftStatus('localhost');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Minecraft Server Status - Example 4</title>
</head>

<body>
<?php
echo 'Error: '.($Server->Error ? $Server->Error : 'None').'<br>';
echo 'Serveraddress: '.$Server->IP.'<br>';
echo 'Online: '.($Server->Online ? 'Yes' : 'No').'<br>';
if($Server->Online) {
	echo 'Message of the day: '.($Server->MOTD ? $Server->MOTD : '').'<br>';
	echo 'Player: '.(is_int($Server->CurPlayers) ? $Server->CurPlayers : '???').' / '.(is_int($Server->MaxPlayers) && $Server->MaxPlayers > 0 ? $Server->MaxPlayers : '???');
}
?>
</body>
</html>