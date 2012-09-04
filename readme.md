Minecraft Server Status Script for PHP
======================================

By Patrick K. (Nox Nebula).<br>
http://www.silexboard.org/, https://github.com/NoxNebula/Minecraft-Server-Status

This is a lightweight script, which reads the server infos of Minecraft servers.<br>
The simple script (MinecraftServerStatusSimple.class.php) supports Minecraft server beta 1.8 or higher.<br>
The newer one (MinecraftServerStatus.class.php) uses the query method and supports Minecraft servers beginning with Minecraft 1.0.0.

## Features

* Query the server if "enable-query" is activated and parse the server infos.<br>
  The simple one read and parse the build-in server infos from minecraft beta 1.8 or higher servers.
* OOPHP
* Handles some errors
* Easy to use
* Lightweight
* Fallback

## Requirements

* PHP 5.4.0 (You need to edit the scripts, if you want to use older php versions)
* PHP allowed stream sockets (stream_socket_client, fwrite, fread, fclose)

# How to use the script

Make sure in your **server.properties** are the following lines:
> *enable-query=true*<br>
> *query.port=25565*

```php
<?php
require_once('MinecraftServerStatus.class.php');
$Server = new MinecraftServerStatus('example-minecraft-host.com');
?>
```

```php
MinecraftServerStatus($Host, $Port = 25565, $Timeout = 1)
```

## Check Online/Offline

You can easily check if the server is online or offline:

```php
$Server->Get('online');
```

This will return a boolean, if it's true, the server is online else false.

## Get the player count

```php
echo $Server->Get('numplayers').' / '.$Server->Get('maxplayers');
```

## Get a list of online players

```php
foreach($Server->Get('players') as $Player)
	echo $Player.'<br>';
```

## Get the whole info / status

```php
$ServerStatus = $Server->Get();
```

## All available "hooks"

The most of these hooks are only available if the server has query enabled or the server is not vanilla.
> 'hostname'<br>
> 'gametype'<br>
> 'game_id'<br>
> 'version'<br>
> 'plugins'<br>
> 'map'<br>
> 'numplayers'<br>
> 'maxplayers'<br>
> 'hostport'<br>
> 'hostip'<br>
> 'online'<br>
> 'software'<br>
note to check if ```$Server->Get('hook');``` return the expected value (No hook = false).

## Fallback

You can just use the "MinecraftServerStatus.class.php" file without the simple one, but if you want a fallback (fewer server infos but works everytime if the requested server is ok) you also should have the "MinecraftServerStatusSimple.class.php" in the same folder.