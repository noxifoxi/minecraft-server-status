# Minecraft Server Status Script for PHP
This script supports Minecraft servers 1.8 or higher

Create new Server Status Object:

```
$Server = new MinecraftStatus($IP, $Port = 25565);
```

Return: new MinecraftStatus Object


Check if server is online or offline:

```
$Server->Online
```

Return: bool