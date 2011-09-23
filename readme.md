Minecraft Server Status Script for PHP
======================================
By Patrick Kleinschmidt (Nox Nebula).<br>
https://github.com/NoxNebula/MC-Server-Status/

This is a lightweight script, which reads the server infos of Minecraft servers, it supports Minecraft server beta 1.8 or higher.

## Features

* Read and parse the build-in server infos from minecraft beta 1.8 or higher servers
* OOPHP!
* Error handles
* Easy to use
* Lightweight

## Requirements

* PHP 4 (But 5.x is recommended)
* PHP allowed stream sockets
* PHP allowed fwrite, fread, fclose (For URLs).

# How to use the script

Include the php-file first:

```
include('MinecraftStatus.class.php');
```

Then, create a new Server Status Object:

```
$Server = new MinecraftStatus($IP, $Port = 25565);
```

This will return a new MinecraftStatus Object which has already read all available server infos.


## Check Online/Offline

You can easily check if the server is online or offline:

```
$Server->Online
```

This will return a boolean, it's true, if the server is online else false.

### Example

```
echo $Server->Online ? 'Online' : 'Offline';
```

## Display the message of the day

To get the MOTD from the server info, you just have to write:

```
$Server->MOTD;
```

This will return a string with the message of the day.

### Example

```
echo 'Message of the day: '.$Server->MOTD;
```

## Get the player status

You can also easily get the current and maximum player info:

```
$Server->CurPlayers;
$Server->MaxPlayers;
```

These both will return an integer with the playernumber or - if something is wrong - a string with three questionmarks (???)

### Example

```
echo 'Player: '.$Server->CurPlayers.' / '.$Server->MaxPlayers;
```

## Further Infos

You can get the Serveraddress and the Port from the object:

```
$Server->IP;    // Serveraddress
$Server->Port;  // Port
```

### Example

```
echo 'Serveraddress: '.$Server->IP.($Server->Port != 25565 ? ':'.$Server->Port : '');
```

You can also get infos about the errors happened:

```
$Server->Error;
```

This return a string with an error if a error happened, else it return false.

### Example

```
echo $Server->Error ? 'Error: '.$Server->Error : '';
```

## Get the main infos shorthanded

To get the MOTD, CurPlayers and MaxPlayers infos, just write:

```
$Server->Info();
```

This one return an array which contains the following keys:

* MOTD
* CurPlayers
* MaxPlayers

### Example

```
$Info = $Server->Info();
echo $Info['MOTD'].'<br>'.$Info['CurPlayers'].' / '.$Info['MaxPlayers'];
```