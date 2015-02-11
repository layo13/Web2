<?php

namespace Library\Controller;

class ClientController {
	public function homeAction() {
		$url = "http://localhost/Web2/";
		require_once(__DIR__ . '/../../views/main.php');
		return "";
	}
	public function simulatorAction() {
		$url = "http://localhost/Web2/";
		require_once(__DIR__ . '/../../views/simulator.php');
		return "";
	}
}
