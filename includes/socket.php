<?php
	class Socket {
		private $socket = null;
		private $host = null;
		private $port = null;
		
		public function __construct($host, $port) {
			if (is_string($host) && is_numeric($port)) {
				$this->host = $host;
				$this->port = $port;
				$this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
				if (socket_bind($this->sock, $this->host, $this->port)) {
					socket_set_nonblock($this->socket);
					socket_listen($this->socket);
				}
				
				return false;
			}
		}
		
		public function accept() {
			$client = socket_accept($this->socket);
			if ($client != false) {
				ConnectionManagement::newConnection(new Connection($client));
				return true;
			}
			return false;
		}
	}
?>