<?php
/**
 * Minecraft Server Status Class
 * @copyright	© 2011 Nox Nebula - Patrick Kleinschmidt
 * @website		https://github.com/NoxNebula/MC-Server-Status
 * @licence		GNU Public Licence - Version 3
 * @author		Nox Nebula - Patrick Kleinschmidt
 **/
class MinecraftStatus {
	private $Socket, $Info;
	public $Online, $MOTD, $CurPlayers, $MaxPlayers, $IP, $Port, $Error;
	
	public function __construct($IP, $Port = '25565') {
		$this->IP = $IP;
		$this->Port = $Port;
		if($this->Socket = @stream_socket_client('tcp://'.$IP.':'.$Port, $ErrNo, $ErrStr, 1)) {
			$this->Online = true;
			
			fwrite($this->Socket, "\xfe");
			$Handle = fread($this->Socket, 2048);
			$Handle = str_replace("\x00", '', $Handle);
			$Handle = substr($Handle, 2);
			$this->Info = explode("\xa7", $Handle); // Separate Infos
			unset($Handle);
			fclose($this->Socket);
			
			if(sizeof($this->Info) == 3) {
				$this->MOTD       = $this->Info[0];
				$this->CurPlayers = (int)$this->Info[1];
				$this->MaxPlayers = (int)$this->Info[2];
				$this->Error      = false;
			} else if(sizeof($this->Info) > 3) { // Handle error
				$Temp = '';
				for($i = 0; $i < sizeof($this->Info) - 2; $i++) {
					$Temp .= ($i > 0 ? '§' : '').$this->Info[$i];
				}
				$this->MOTD       = $Temp;
				$this->CurPlayers = (int)$this->Info[sizeof($this->Info) - 2];
				$this->MaxPlayers = (int)$this->Info[sizeof($this->Info) - 1];
				$this->Error      = 'Faulty motd or outdated script';
			} else {
				$this->MOTD       = false;
				$this->CurPlayers = false;
				$this->MaxPlayers = false;
				$this->Error      = 'Unexpected error, cause may be an outdated script';
			}
		} else {
			$this->Online = false;
			$this->Error = 'Can not reach the server';
		}
	}
	
	public function Info() {
		return array(
			'MOTD'       => $this->MOTD,
			'CurPlayers' => $this->CurPlayers,
			'MaxPlayers' => $this->MaxPlayers
		);
	}
}
?>