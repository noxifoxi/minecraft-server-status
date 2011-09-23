<?php
/**
 * MC-Server-Status:
 * Extended server info
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
<title>Minecraft Server Status - Example 2</title>
</head>

<body>
<?php
echo 'Serveraddress: '.$Server->IP.'<br>';
echo 'Online: '.($Server->Online ? 'Yes' : 'No').'<br>';
echo 'Message of the day: '.$Server->MOTD.'<br>';
echo 'Player: '.$Server->CurPlayers.' / '.$Server->MaxPlayers;
?>
</body>
</html>