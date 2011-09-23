<?php
/**
 * MC-Server-Status:
 * Extended server info and error handle
 **/

// Include MC-SS Class
include('MinecraftStatus.class.php');
// Create a new Server Object
$Server = new MinecraftStatus('localhost');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Minecraft Server Status - Example 3</title>
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