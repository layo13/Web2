<?php

namespace Library\Controller;

use Library\Entity\Equipement;
use Library\Model\EquipementManager;
use Library\PDOProvider;

class EquipementController {

	public function readUnique($id) {
		header('Content-Type: application/json');

		$equipementManager = new EquipementManager(PDOProvider::getInstance());
		$equipement = $equipementManager->getUnique($id);

		$jsonEquipement = array(
			'id' => $equipement->getId(),
			'pere' => $equipement->getPere() !== null ? array(
					'id' => $equipement->getPere()->getId(),
					'nom' => $equipement->getPere()->getNom()
				) : null,
			'etatTechnique' => array(
				'id' => $equipement->getEtatTechnique()->getId(),
				'libelle' => $equipement->getEtatTechnique()->getLibelle(),
			),
			'etatFonctionnel' => array(
				'id' => $equipement->getEtatFonctionnel()->getId(),
				'libelle' => $equipement->getEtatFonctionnel()->getLibelle(),
			),
			'fabricant' => array(
				'id' => $equipement->getFabricant()->getId(),
				'nom' => $equipement->getFabricant()->getNom(),
			),
			'type' => array(
				'id' => $equipement->getType()->getId(),
				'libelle' => $equipement->getType()->getLibelle(),
			),
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
		$equipementManager = new EquipementManager(PDOProvider::getInstance());
		$equipementList = $equipementManager->get();

		$jsonEquipementList = array();
		/* @var $equipement Equipement */
		foreach ($equipementList as $equipement) {
			$jsonEquipementList[] = array(
				'id' => $equipement->getId(),
				'pere' => $equipement->getPere() !== null ? array(
					'id' => $equipement->getPere()->getId(),
					'nom' => $equipement->getPere()->getNom()
				) : null,
				'etatTechnique' => array(
					'id' => $equipement->getEtatTechnique()->getId(),
					'libelle' => $equipement->getEtatTechnique()->getLibelle(),
				),
				'etatFonctionnel' => array(
					'id' => $equipement->getEtatFonctionnel()->getId(),
					'libelle' => $equipement->getEtatFonctionnel()->getLibelle(),
				),
				'fabricant' => array(
					'id' => $equipement->getFabricant()->getId(),
					'nom' => $equipement->getFabricant()->getNom(),
				),
				'type' => array(
					'id' => $equipement->getType()->getId(),
					'libelle' => $equipement->getType()->getLibelle(),
				),
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

		$equipementManager = new EquipementManager(PDOProvider::getInstance());

		$id = $_POST['id'];
		$type = $_POST['type'];
		$fabricant = $_POST['fabricant'];
		$pere = $_POST['pere'];
		$nom = $_POST['nom'];
		$adresseIp = $_POST['adresse_ip'];
		$adressePhysique = $_POST['adresse_physique'];
		$utilisateur = $_POST['utilisateur'];
		$numeroSupport = $_POST['numero_support'];

		$equipement = new Equipement();
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

		$equipementManager = new EquipementManager(PDOProvider::getInstance());
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

	public function delete($id) {
		header('Content-Type: application/json');

		$equipementManager = new EquipementManager(PDOProvider::getInstance());
		if ($equipementManager->delete($id)) {
			$jsonResponse["state"] = "ok";
		} else {
			$jsonResponse["state"] = "ko";
		}
		return json_encode($jsonResponse);
	}

}
