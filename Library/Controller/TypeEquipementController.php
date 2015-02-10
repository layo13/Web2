<?php

namespace Library\Controller;

use Library\Model\TypeEquipementManager;

class TypeEquipementController {

	public function readAction() {
		header('Content-Type: application/json; Charset=utf-8');
		$typeEquipementManager = new TypeEquipementManager(\Library\PDOProvider::getInstance());
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
		return json_encode($jsonResponse);
	}

}
