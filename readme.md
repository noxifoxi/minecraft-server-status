# Lightweight Minecraft server status script for PHP

Copyright noxifoxi https://github.com/noxifoxi/minecraft-server-status

This lightweight script queries the server information from Minecraft java servers.

- `MinecraftServer.php` *(Minecraft 1.0.0+)* uses the query method and supports all servers with enabled queries.
- `MinecraftServerBasic.php` *(Minecraft Beta 1.8+)* can be used as a fallback if the server does not permit queries, if something else goes wrong or just a simple request is required.

## Features

* Queries the server if the server setting `enable-query` is enabled and parses the server infos.
* Fallback to read and parse the build-in server infos from Minecraft Beta 1.8+ servers.
* Lightweight and fast
* Simple error handling
* Easy to use

## Requirements

* PHP 7.0+

# How to use the script

In order to fetch advanced server information the server's **server.properties** has to have the following settings:
```properties
enable-query=true
query.port=25565
```
If `enable-query` is disabled (`false`) only basic information can be retrieved, methods of `MinecraftServerBasic.php` will be used then.

This is the suggested method for using this class to fetch server information:
```php
try {
	require_once('MinecraftServer.php');
	$server = new MinecraftServer('example-minecraft-host.com');
} catch (Exception $e) {
	// handle errors
}
```
If the script throws an Exception it's safe to assume that the server is offline (for you).

Arguments:
```php
MinecraftServer(string $host, int $port = 25565, int $timeout = 1)
```
- `host` - IP or domain
- `port` - Port where the Minecraft server is listening (Defaut: `25565`)
- `timeout` - how long is the script allowed try connecting to the server before it times out in seconds (Default: `1` second)

## Examples

### Check online/offline

```php
$server->online;
```

If the server is online the return value is `1` otherwise it's `0`.

### Get player count

```php
echo $server->numplayers . ' / ' . $server->maxplayers;
```

### Get a list of the online players names

```php
foreach($server->players as $player)
	echo $player . '<br>';
```

Note: `$server->players` returns an array of strings.

### Get everything

```php
$serverStatus = $server->getInfoArray();
```

Returns an array with all information the sever sent or the script was able to fetch.

## Default server properties

Some of these properties are only available when server query is enabled, properties marked with "(Simple)" are always available via the Simple class or fallback - if the server is online:
- **hostname** (Simple)
- **gametype**
- **game_id**
- **version**
- **plugins**
- **map**
- **numplayers** (Simple)
- **maxplayers** (Simple)
- **hostport** (Simple)
- **hostip** (Simple)
- **online** (Simple)
- **software**

Servers can add more than these default properties, check the keys of [Get everything](#get-everything) if you are unsure.

## Fallback

`MinecraftServer.php` automatically falls back using `MinecraftServerBasic.php` if the file is present in the same folder.
