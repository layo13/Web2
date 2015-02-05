<?php

namespace Library\Controller;

use Library\Entity\Equipement;
use Library\Model\EquipementManager;
use Library\Model\EtatTechniqueManager;
use Library\Model\EtatFonctionnelManager;
use Library\Model\FabricantManager;
use Library\Model\TypeEquipementManager;
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
					'nom' => $equipement->getPere()->getNom(),
					'type' => $equipement->getPere()->getType()
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
		$fabricantManager = new FabricantManager(PDOProvider::getInstance());
		$typeEquipementManager = new TypeEquipementManager(PDOProvider::getInstance());
		
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
		$equipement->setType($typeEquipementManager->getUnique($type));
		$equipement->setFabricant($fabricantManager->getUnique($fabricant));

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

	public function rebootPark() {
		
	}

	public function heaveMaterial($id, $etatTechniqueId) {
		var_dump($id, $etatTechniqueId);
		$equipementManager = new EquipementManager(PDOProvider::getInstance());
		$etatTechniqueManager = new EtatTechniqueManager(PDOProvider::getInstance());
		$etatFonctionnelManager = new EtatFonctionnelManager(PDOProvider::getInstance());
		
		$equipement = $equipementManager->getUnique($id);
		var_dump($equipement);
		// Mise en panne
		if ($etatTechniqueId !== 0) { // C'est le pere, on change l'etat technique
			$etatTechnique = $etatTechniqueManager->getUnique($etatTechniqueId);
			
			$equipement->setEtatTechnique($etatTechnique);

			$ok = $equipementManager->update($equipement);
			if ($ok === false) {
				return $ok;
			}
		} else { // C'est les enfants, on les met en inoperant
			$equipement->setEtatFonctionnel($etatFonctionnelManager->getUnique(4));
			return $equipementManager->update($equipement);
		}
		
		// Pareil pour les enfants
		$enfants = $equipementManager->getByPere($id);
		foreach ($enfants as $enfant) {
			$ok = $this->heaveMaterial($enfant->getId(), 0);
			if ($ok === false) {
				return $ok;
			}
		}
	}
}
