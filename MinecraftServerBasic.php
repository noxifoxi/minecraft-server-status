<?php
/**
 * Minecraft server simple status (fallback)
 * Read the basic server info which is intended for minecraft clients
 * @author    noxifoxi https://github.com/noxifoxi
 * @license   GNU Public Licence - Version 3
 * @copyright © 2011-2022 noxifoxi
 */

class MinecraftServerBasic {
	private $socket;

	private $info = [];

	
	public function __get($property) {
		if (array_key_exists($property, $this->info))
			return $this->info[$property];
	}

	public function __construct(string $host, int $port = 25565, int $timeout = 1) {
		$this->socket = @stream_socket_client('tcp://' . $host . ':' . $port, $errNo, $errStr, $timeout);

		if (!$this->socket) {
			$this->info['online'] = 0;
			return;
		}
		stream_set_timeout($this->socket, $timeout);

		// Request server status
		fwrite($this->socket, "\xfe");
		// Read received info
		$data = fread($this->socket, 2048);
		// Remove the nulls
		$data = str_replace("\x00", '', $data);
		// drop the first two bytes
		$data = substr($data, 2);
		// split/parse information
		$info = explode("\xa7", $data);
		unset($data);
		// Close connection
		fclose($this->socket);

		/*
			populate/parse info
		*/

		if(sizeof($info) == 3) {
			$this->info = [
				'hostname'   => $info[0], // motd
				'numplayers' => (int) $info[1],
				'maxplayers' => (int) $info[2],
				'online'     => 1
			];
		} else if(sizeof($info) > 3) {
			// try to handle occuring errors, Minecraft doesn't handle this.
			$tmp = '';
			for($i = 0; $i < sizeof($info) - 2; $i++) {
				$tmp .= ($i > 0 ? '§' : '').$info[$i];
			}
			$this->info = [
				'hostname'   => $tmp, // motd
				'numplayers' => (int) $info[sizeof($info) - 2],
				'maxplayers' => (int) $info[sizeof($info) - 1],
				'online'     => 1,
				'error'      => 'Unreadable "motd"'
			];
		} else {
			$this->info['error'] = 'Unexpected error';
			$this->info['online'] = 0;
		}
		$this->info += [
			'hostport'   => $port,
			'hostip'     => $host
		];
	}

	public function getInfoArray(): array {
		return $this->info;
	}
}
