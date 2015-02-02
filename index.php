<?php

//error_reporting(E_ALL);

function autoload($class) {
	$file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

	if (is_file($file)) {
		require ($file);
	} else {
		return;
	}
}

spl_autoload_register('autoload');

if (key_exists("WINDIR", $_SERVER)) {
	$requestUri = str_replace("/Web2", "", $_SERVER["REQUEST_URI"]);
	$url = "http://localhost/Web2/";
} else {
	$requestUri = $_SERVER["REQUEST_URI"];
	$url = "http://codebox.lionelguissani.fr/";
}
$requestMethod = $_SERVER["REQUEST_METHOD"];

//var_dump($requestUri, $requestMethod);

$pdo = \Library\PDOProvider::getInstance();

if (preg_match("`^/$`", $requestUri, $matches)) {
	require_once(__DIR__ . '/views/main.php');
} else if (preg_match("`^/sse$`", $requestUri, $matches)) {
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');

	$equipementController = new Library\Controller\EquipementController();
	
	$data = $equipementController->read();
	echo "data: {$data}\n\n";
	flush();
} else if (preg_match("`^/api/equipement$`", $requestUri, $matches) && $requestMethod == "GET") {
	header('Content-Type: application/json');
	$equipementController = new Library\Controller\EquipementController();
	echo $equipementController->read();
} else if (preg_match("`^/api/equipement/([a-z0-9]+)$`i", $requestUri, $matches) && $requestMethod == "GET") {
	$id = $matches[1];
	$equipementController = new Library\Controller\EquipementController($id);
	echo $equipementController->readUnique($id);
} else if (preg_match("`^/api/equipement$`", $requestUri, $matches) && $requestMethod == "POST") {
	$equipementController = new Library\Controller\EquipementController();
	echo $equipementController->add();
} else if (preg_match("`^/api/equipement/([a-z0-9]+)$`i", $requestUri, $matches) && $requestMethod == "POST") {
	$equipementController = new Library\Controller\EquipementController();
	$id = $matches[1];
	echo $equipementController->update($id);
} else if (preg_match("`^/api/type_equipement$`", $requestUri, $matches) && $requestMethod == "GET") {
	header('Content-Type: application/json');
	$typeEquipementManager = new \Library\Model\TypeEquipementManager($pdo);
	$typeEquipementList = $typeEquipementManager->get();

	$jsonTypeEquipementList = array();
	/* @var $equipement \Library\Entity\TypeEquipement */
	foreach ($typeEquipementList as $typeEquipement) {
		$jsonTypeEquipementList[] = array(
			'id' => $typeEquipement->getId(),
			'libelle' => $typeEquipement->getLibelle()
		);
	}
	$jsonResponse = array(
		"state" => "ok",
		"content" => $jsonTypeEquipementList
	);
	echo json_encode($jsonResponse);
} else if (preg_match("`^/api/fabricant$`", $requestUri, $matches) && $requestMethod == "GET") {
	header('Content-Type: application/json');
	$fabricantManager = new \Library\Model\FabricantManager($pdo);
	$fabricantList = $fabricantManager->get();

	$jsonFabricantList = array();
	/* @var $equipement \Library\Entity\Fabricant */
	foreach ($fabricantList as $fabricant) {
		$jsonFabricantList[] = array(
			'id' => $fabricant->getId(),
			'nom' => $fabricant->getNom()
		);
	}
	$jsonResponse = array(
		"state" => "ok",
		"content" => $jsonFabricantList
	);
	echo json_encode($jsonResponse);
} else if (preg_match("`^/api/etat_fonctionnel`", $requestUri, $matches) && $requestMethod == "GET") {
	header('Content-Type: application/json');
	$etatFonctionnelManager = new \Library\Model\EtatFonctionnelManager($pdo);
	$etatFonctionnelList = $etatFonctionnelManager->get();

	$jsonetatFonctionnelList = array();
	/* @var $equipement \Library\Entity\EtatFonctionnel */
	foreach ($etatFonctionnelList as $etatFonctionnel) {
		$jsonetatFonctionnelList[] = array(
			'id' => $etatFonctionnel->getId(),
			'libelle' => $etatFonctionnel->getLibelle()
		);
	}
	$jsonResponse = array(
		"state" => "ok",
		"content" => $jsonetatFonctionnelList
	);
	echo json_encode($jsonResponse);
} else {
	header('HTTP/1.0 404 Not Found');
	echo "Page non trouvée ...";
}
