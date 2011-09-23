# Minecraft Server Status Script for PHP
This script...

Create new Server Status Object:

```
$Server = new MinecraftStatus($IP, $Port = 25565);
```

Check if online or offline

```
$Server->Online
```

Return: bool