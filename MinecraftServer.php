<?php
/**
 * Minecraft server status
 * Query minecraft server info
 * @author    noxifoxi https://github.com/noxifoxi
 * @license   GNU Public Licence - Version 3
 * @copyright © 2011-2022 noxifoxi
 */

class MinecraftServer {
	// command byte which tell the server to send the status
	const STATUS    = 0x00;
	// challenge (handshake)
	const HANDSHAKE = 0x09;

	// magic bytes
	const B1 = 0xFE;
	const B2 = 0xFD;

	private $socket;
	private $info = [];

	public function __get($property) {
		if (array_key_exists($property, $this->info))
			return $this->info[$property];
	}

	public function __construct(string $host, int $port = 25565, int $timeout = 1) {
		$this->socket = @stream_socket_client('udp://' . $host . ':' . $port, $errNo, $errStr, $timeout);

		if (!$this->socket) {
			throw new Exception("$errStr ($errNo)");
		}
		stream_set_timeout($this->socket, $timeout);

		/*
			Create handshake and request server status
		*/

		try {
			$data = $this->send(self::STATUS, pack('N', $this->send(self::HANDSHAKE)).pack('c*', 0x00, 0x00, 0x00, 0x00));
		} catch (Exception $e) {
			// Try fallback if query is not enabled on the server
			if(!class_exists('MinecraftServerBasic') && file_exists(__DIR__.'/MinecraftServerBasic.php'))
				require_once(__DIR__.'/MinecraftServerBasic.php');

			if(class_exists('MinecraftServerBasic')) {
				$fallback = new MinecraftServerBasic($host, $port, $timeout);
				$this->info = $fallback->getInfoArray();
			}
			fclose($this->socket);
			return;
		}

		/*
			Prepare the data for parsing
		*/

		// Split the data string on the player position
		$data = explode("\00\00\01player_\00\00", $data);
		// Save the players
		$players = '';
		if(isset($data[1]))
			$players = substr($data[1], 0, -2);
		// Split the server infos (status)
		$data = explode("\x00", $data[0]);

		/*
			populate server info
		*/

		for($i = 0; $i < sizeof($data); $i += 2) {
			$this->info[$data[$i]] = $data[$i+1];
		}

		// Parse plugins and try to determine the server software
		if($this->info['plugins']) {
			$data = explode(": ", $this->info['plugins']);
			$this->info['software'] = $data[0];
			if(isset($data[1]))
				$this->info['plugins']  = explode('; ', $data[1]);
			else
				unset($this->info['plugins']);
		} else {
			// It seems to be a vanilla server
			$this->info['software'] = 'Vanilla';
			unset($this->info['plugins']);
		}

		// Parse players
		if($players)
			$this->info['players'] = explode("\00", $players);

		// encode utf8 server names
		$this->info['hostname'] = utf8_encode($this->info['hostname']);

		// set online status
		$this->info['online'] = 1;

		/*
			Close connection
		*/

		fclose($this->socket);
	}

	public function getInfoArray(): array {
		return $this->info;
	}

	private function send(int $command, string $addition = NULL): string {
		// pack the command into a binary string
		$command = pack('c*', self::B1, self::B2, $command, 0x01, 0x02, 0x03, 0x04).$addition;
		// send the binary string to the server
		if(strlen($command) !== @fwrite($this->socket, $command, strlen($command)))
			throw new Exception('Failed to write on socket', 2);

		// listen what the server has to say now
		$data = fread($this->socket, 2048);
		if($data === false)
			throw new Exception('Failed to read from socket', 3);

		// remove the first 5 unnecessary bytes (0x00, 0x01, 0x02, 0x03, 0x04) Status type and own ID token
		return substr($data, 5);
	}
}