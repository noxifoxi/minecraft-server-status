<?php
/**
 * Minecraft server status fallback class
 * Read the simple server info wich are actually for minecraft clients
 * @author    Patrick K. - http://www.silexboard.org/ - https://github.com/NoxNebula
 * @license   GNU Public Licence - Version 3
 * @copyright © 2011-2012 Patrick K.
 */
class MinecraftServerStatusSimple {
	private $Socket;

	private $Info = [];

	/**
	 * Read the minecraft server info and parse it
	 * @param string $Host
	 * @param int    $Port    optional
	 * @param int    $Timeout optional
	 */
	public function __construct($Host, $Port = 25565, $Timeout = 1) {
		$this->Socket = @stream_socket_client('tcp://'.$Host.':'.$Port, $ErrNo, $ErrStr, $Timeout);
		if($ErrNo || $this->Socket === false) {
			$this->Info['online'] = false; return;
			//throw new Exception('Failed to connect', 1);
		}
		stream_set_timeout($this->Socket, $Timeout);

		fwrite($this->Socket, "\xfe");
		$Data = fread($this->Socket, 2048);
		$Data = str_replace("\x00", '', $Data);
		$Data = substr($Data, 2);
		$Info = explode("\xa7", $Data); // Separate Infos
		unset($Data);
		fclose($this->Socket);

		$this->Info['online'] = false;
		if(sizeof($Info) == 3) {
			$this->Info['motd']       = $Info[0];
			$this->Info['numplayers'] = (int)$Info[1];
			$this->Info['maxplayers'] = (int)$Info[2];
			$this->Info['online']     = true;
		} else if(sizeof($Info) > 3) {
			// Handle error, Minecraft doesn't handle this.
			$tmp = '';
			for($i = 0; $i < sizeof($Info) - 2; $i++) {
				$tmp .= ($i > 0 ? '§' : '').$Info[$i];
			}
			$this->Info['motd']       = $tmp;
			$this->Info['numplayers'] = (int)$Info[sizeof($Info) - 2];
			$this->Info['maxplayers'] = (int)$Info[sizeof($Info) - 1];
			$this->Info['error']      = 'Faulty motd or outdated script';
			$this->Info['online']     = true;
		} else {
			$this->Info['error'] = 'Unexpected error, maybe this script is outdated';
		}
	}

	/**
	 * Return the value of an key or the whole server info
	 * @param  string $Key optional
	 * @return mixed
	 */
	public function Get($Key = '') {
		return $Key ? (array_key_exists($this->Info[$Key]) ? $this->Info[$Key] : false) : $this->Info;
	}
}
