<?php

namespace Library\Controller;

use Library\Model\FabricantManager;

class FabricantController {

	public function readAction() {
		header('Content-Type: application/json; Charset=utf-8');
		$fabricantManager = new FabricantManager(\Library\PDOProvider::getInstance());
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
		return json_encode($jsonResponse);
	}

}
