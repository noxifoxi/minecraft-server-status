<?php
/**
 * MC-Server-Status:
 * Server Online or Offline
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
<title>Minecraft Server Status - Example 1</title>
</head>

<body>
<?php
echo $Server->Online ? 'Online' : 'Offline';
?>
</body>
</html>