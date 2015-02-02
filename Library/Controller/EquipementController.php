<?php

namespace Library\Controller;

class EquipementController {

	public function readUnique($id) {
		header('Content-Type: application/json');
		
		$equipementManager = new \Library\Model\EquipementManager(\Library\PDOProvider::getInstance());
		$equipement = $equipementManager->getUnique($id);

		$jsonEquipement = array(
			'id' => $equipement->getId(),
			'pere' => $equipement->getPere(),
			'etatTechnique' => $equipement->getEtatTechnique(),
			'etatFonctionnel' => $equipement->getEtatFonctionnel(),
			'fabricant' => $equipement->getFabricant(),
			'type' => $equipement->getType(),
			'nom' => $equipement->getNom(),
			'adresseIp' => $equipement->getAdresseIp(),
			'adressePhysique' => $equipement->getAdressePhysique(),
			'messageMaintenance' => $equipement->getMessageMaintenance(),
			'numeroSupport' => $equipement->getNumeroSupport(),
			'utilisateur' => $equipement->getUtilisateur()
		);

		$jsonResponse = array(
			"state" => "ok",
			"content" => $jsonEquipement
		);
		return json_encode($jsonResponse);
	}

	public function read() {
		$equipementManager = new \Library\Model\EquipementManager(\Library\PDOProvider::getInstance());
		$equipementList = $equipementManager->get();

		$jsonEquipementList = array();
		/* @var $equipement \Library\Entity\Equipement */
		foreach ($equipementList as $equipement) {
			$jsonEquipementList[] = array(
				'id' => $equipement->getId(),
				'pere' => $equipement->getPere(),
				'etatTechnique' => $equipement->getEtatTechnique(),
				'etatFonctionnel' => $equipement->getEtatFonctionnel(),
				'fabricant' => $equipement->getFabricant(),
				'type' => $equipement->getType(),
				'nom' => $equipement->getNom(),
				'adresseIp' => $equipement->getAdresseIp(),
				'adressePhysique' => $equipement->getAdressePhysique(),
				'messageMaintenance' => $equipement->getMessageMaintenance(),
				'numeroSupport' => $equipement->getNumeroSupport(),
				'utilisateur' => $equipement->getUtilisateur()
			);
		}
		$jsonResponse = array(
			"state" => "ok",
			"content" => $jsonEquipementList
		);
		return json_encode($jsonResponse);
	}

	public function create() {
		$jsonResponse = array();

		$equipementManager = new \Library\Model\EquipementManager(\Library\PDOProvider::getInstance());

		$id = $_POST['id'];
		$type = $_POST['type'];
		$fabricant = $_POST['fabricant'];
		$pere = $_POST['pere'];
		$nom = $_POST['nom'];
		$adresseIp = $_POST['adresse_ip'];
		$adressePhysique = $_POST['adresse_physique'];
		$utilisateur = $_POST['utilisateur'];
		$numeroSupport = $_POST['numero_support'];

		$equipement = new Library\Entity\Equipement();
		$equipement->setId($id);
		$equipement->setType($type);
		$equipement->setFabricant($fabricant);
		$equipement->setEtatTechnique(1); // en marche
		$equipement->setEtatFonctionnel(2); // éteind
		if ($pere !== "") {
			$equipement->setPere($pere);
		}
		$equipement->setNom($nom);
		$equipement->setAdresseIp($adresseIp);
		$equipement->setAdressePhysique($adressePhysique);
		$equipement->setUtilisateur($utilisateur);
		$equipement->setNumeroSupport($numeroSupport);

		if ($equipementManager->insert($equipement)) {
			$jsonResponse["state"] = "ok";
		} else {
			$jsonResponse["state"] = "ko";
		}
		return json_encode($jsonResponse);
	}

	public function update($oldId) {
		$jsonResponse = array();

		$equipementManager = new \Library\Model\EquipementManager(\Library\PDOProvider::getInstance());
		$equipement = $equipementManager->getUnique($oldId);
		
		$id = $_POST['id'];
		$type = $_POST['type'];
		$fabricant = $_POST['fabricant'];
		$pere = $_POST['pere'];
		$nom = $_POST['nom'];
		$adresseIp = $_POST['adresse_ip'];
		$adressePhysique = $_POST['adresse_physique'];
		$utilisateur = $_POST['utilisateur'];
		$numeroSupport = $_POST['numero_support'];

		$equipement->setId($id);
		$equipement->setOldId($oldId);
		$equipement->setType($type);
		$equipement->setFabricant($fabricant);
		
		if ($pere !== "") {
			$equipement->setPere($pere);
		}
		$equipement->setNom($nom);
		$equipement->setAdresseIp($adresseIp);
		$equipement->setAdressePhysique($adressePhysique);
		$equipement->setUtilisateur($utilisateur);
		$equipement->setNumeroSupport($numeroSupport);

		if ($equipementManager->update($equipement)) {
			$jsonResponse["state"] = "ok";
		} else {
			$jsonResponse["state"] = "ko";
		}
		return json_encode($jsonResponse);
	}

	public function delete() {
		
	}

}
