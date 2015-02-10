<?php

namespace Library\Controller;

class ChangementEtatController {

	public function sseAction() {
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');

		$data = $this->read();
		
		echo "data: {$data}\n\n";
		flush();
	}
	
	public function readAction() {
		header('Content-Type: application/json; Charset=utf-8');
		return $this->read();
	}

	public function read() {
		$changementEtatManager = new \Library\Model\ChangementEtatManager(\Library\PDOProvider::getInstance());
		$changementEtatList = $changementEtatManager->get();

		$jsonChangementEtatList = array();
		/* @var $changementEtat \Library\Entity\ChangementEtat */
		foreach ($changementEtatList as $changementEtat) {
			$jsonChangementEtatList[] = array(
				'id' => $changementEtat->getId(),
				'equipement' => array(
					"id" => $changementEtat->getEquipement()->getId(),
					"nom" => $changementEtat->getEquipement()->getNom(),
				),
				'etatFonctionnel' => $changementEtat->getEtatFonctionnel() !== null ? array(
					"id" => $changementEtat->getEtatFonctionnel()->getId(),
					"libelle" => $changementEtat->getEtatFonctionnel()->getLibelle()
						) : null,
				'etatTechnique' => $changementEtat->getEtatTechnique() !== null ? array(
					"id" => $changementEtat->getEtatTechnique()->getId(),
					"libelle" => $changementEtat->getEtatTechnique()->getLibelle()
						) : null,
				'type' => array(
					"id" => $changementEtat->getType()->getId(),
					"libelle" => $changementEtat->getType()->getLibelle()
				),
				'date' => $changementEtat->getDate(),
				'message' => $changementEtat->getMessage()
			);
		}
		$jsonResponse = array(
			"state" => "ok",
			"content" => $jsonChangementEtatList
		);

		return json_encode($jsonResponse);
	}
}
