Minecraft Server Status Script for PHP
======================================

This script reads the server infos of Minecraft servers, it supports Minecraft server beta 1.8 or higher.

## How to use the script:

Create a new Server Status Object:

```
$Server = new MinecraftStatus($IP, $Port = 25565);
```

This will return a new MinecraftStatus Object which has already read all available server infos.


Check if server is online or offline:

```
$Server->Online
```

Return: bool