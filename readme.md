# Lightweight Minecraft server status script for PHP

Copyright noxifoxi https://github.com/noxifoxi/minecraft-server-status

This lightweight script queries the server information from Minecraft java servers.

``MinecraftServerStatus.class.php`` *(Minecraft 1.0.0+)* uses the query method and supports all servers with enabled queries.
``MinecraftServerStatusSimple.class.php`` *(Minecraft Beta 1.8+)* can be used as a fallback if the server does not permit queries, if something else goes wrong or just a simple request is required.

## Features

* Queries the server if the server setting ``enable-query`` is enabled and parses the server infos.
* Fallback to read and parse the build-in server infos from Minecraft Beta 1.8+ servers.
* OOPHP
* Error handling
* Easy to use
* Lightweight

## Requirements

* PHP 5.4.0+
* PHP stream sockets (``stream_socket_client``, ``fwrite``, ``fread``, ``fclose``)

# How to use the script

The **server.properties** has to include the following settings:
```properties
enable-query=true
query.port=25565
```

```php
<?php
require_once('MinecraftServerStatus.class.php');
$Server = new MinecraftServerStatus('example-minecraft-host.com');
?>
```

```php
MinecraftServerStatus($Host, $Port = 25565, $Timeout = 1)
```

## Check online/offline

```php
$Server->Get('online');
```

If the server is online the return value is true otherwise its false.

## Get player count

```php
echo $Server->Get('numplayers').' / '.$Server->Get('maxplayers');
```

## Get a list of the online players names

```php
foreach($Server->Get('players') as $Player)
	echo $Player.'<br>';
```

``$Server->Get('players')`` returns an array of strings,

## Get everything

```php
$ServerStatus = $Server->Get();
```

Returns an array with every information the script was able to fetch.

## All available "hooks"

Most of these hooks are only available if the server has query enabled or is non-vanilla.
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

Check if ``$Server->Get('hook');`` returns the expected value (No hook = false).

## Fallback

``MinecraftServerStatus.class.php`` automatically falls back using ``MinecraftServerStatusSimple.class.php`` if the file is present in the same folder. Providing less information, but information at all.
