<?php

namespace Library\Controller;

use Library\Entity\Equipement;
use Library\Entity\ChangementEtat;
use Library\Model\ChangementEtatManager;
use Library\Model\EquipementManager;
use Library\Model\EtatTechniqueManager;
use Library\Model\EtatFonctionnelManager;
use Library\Model\FabricantManager;
use Library\Model\TypeChangementManager;
use Library\Model\TypeEquipementManager;
use Library\PDOProvider;

class EquipementController {

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

	public function readUniqueAction($id) {
		header('Content-Type: application/json; Charset=utf-8');

		$equipementManager = new EquipementManager(PDOProvider::getInstance());
		$equipement = $equipementManager->getUnique($id);
		if ($equipement !== null) {
			$jsonEquipement = array(
				'id' => $equipement->getId(),
				'pere' => $equipement->getPere() !== null ? array(
					'id' => $equipement->getPere()->getId(),
					'nom' => $equipement->getPere()->getNom(),
					'etatTechnique' => array(
						'id' => $equipement->getPere()->getEtatTechnique()->getId(),
						'libelle' => $equipement->getPere()->getEtatTechnique()->getLibelle(),
					),
					'etatFonctionnel' => array(
						'id' => $equipement->getPere()->getEtatFonctionnel()->getId(),
						'libelle' => $equipement->getPere()->getEtatFonctionnel()->getLibelle(),
					),
					'fabricant' => array(
						'id' => $equipement->getPere()->getFabricant()->getId(),
						'nom' => $equipement->getPere()->getFabricant()->getNom(),
					),
					'type' => array(
						'id' => $equipement->getPere()->getType()->getId(),
						'libelle' => $equipement->getPere()->getType()->getLibelle(),
					),
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
		} else {
			$jsonResponse = array(
				"state" => "ok",
				"content" => null
			);
			return json_encode($jsonResponse);
		}
	}

	private function read() {
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
					'etatTechnique' => array(
						'id' => $equipement->getPere()->getEtatTechnique()->getId(),
						'libelle' => $equipement->getPere()->getEtatTechnique()->getLibelle(),
					),
					'etatFonctionnel' => array(
						'id' => $equipement->getPere()->getEtatFonctionnel()->getId(),
						'libelle' => $equipement->getPere()->getEtatFonctionnel()->getLibelle(),
					),
					'fabricant' => array(
						'id' => $equipement->getPere()->getFabricant()->getId(),
						'nom' => $equipement->getPere()->getFabricant()->getNom(),
					),
					'type' => array(
						'id' => $equipement->getPere()->getType()->getId(),
						'libelle' => $equipement->getPere()->getType()->getLibelle(),
					),
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

	public function createAction() {
		$jsonResponse = array();

		$equipementManager = new EquipementManager(PDOProvider::getInstance());
		$typeChangementManager = new TypeChangementManager(PDOProvider::getInstance());
		$changementEtatManager = new ChangementEtatManager(PDOProvider::getInstance());

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

		$ok = $equipementManager->insert($equipement);
		if ($ok !== NULL) {

			$changementEtat = new ChangementEtat();
			$changementEtat->setEquipement($equipement);
			$changementEtat->setType($typeChangementManager->getUnique(1)); // Ajoute de materiel
			if ($changementEtatManager->insert($changementEtat)) {
				$jsonResponse["state"] = "ok";
			} else {
				$jsonResponse["state"] = "ko";
			}
		} else {
			$jsonResponse["state"] = "ko";
		}
		return json_encode($jsonResponse);
	}

	public function updateAction($oldId) {
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

	public function deleteAction($id) {
		header('Content-Type: application/json; Charset=utf-8');

		$equipementManager = new EquipementManager(PDOProvider::getInstance());
		if ($equipementManager->delete($id)) {
			$jsonResponse["state"] = "ok";
		} else {
			$jsonResponse["state"] = "ko";
		}
		return json_encode($jsonResponse);
	}

	public function rebootAction() {
		header('Content-Type: application/json; Charset=UTF-8');

		if ($this->rebootPark()) {
			$state = "ok";
		} else {
			$state = "ko";
		}
		return json_encode(array("state" => $state));
	}

	private function rebootPark() {
		$equipementManager = new EquipementManager(PDOProvider::getInstance());
		$etatTechniqueManager = new EtatTechniqueManager(PDOProvider::getInstance());
		$etatFonctionnelManager = new EtatFonctionnelManager(PDOProvider::getInstance());

		$equipementList = $equipementManager->get();
		$etatTechnique = $etatTechniqueManager->getUnique(1);
		$etatFonctionnel = $etatFonctionnelManager->getUnique(1);

		foreach ($equipementList as $equipement) {
			$equipement->setEtatTechnique($etatTechnique);
			$equipement->setEtatFonctionnel($etatFonctionnel);
			$equipement->setMessageMaintenance(null);

			$ok = $equipementManager->update($equipement);
			if ($ok === false) {
				return $ok;
			}
		}
		return true;
	}

	public function heaveAction($id) {
		header('Content-Type: application/json; Charset=UTF-8');
		$messageMaintenance = isset($_POST["message_maintenance"]) ? $_POST["message_maintenance"] : null;
		if ($this->heaveMaterial($id, $_POST["etat_technique_id"], $messageMaintenance)) {
			$state = "ok";
		} else {
			$state = "ko";
		}
		return json_encode(array("state" => $state));
	}

	private function heaveMaterial($id, $etatTechniqueId, $messageMaintenance = null) {
		$changementEtatManager = new ChangementEtatManager(PDOProvider::getInstance());
		$equipementManager = new EquipementManager(PDOProvider::getInstance());
		$etatTechniqueManager = new EtatTechniqueManager(PDOProvider::getInstance());
		$etatFonctionnelManager = new EtatFonctionnelManager(PDOProvider::getInstance());

		$equipement = $equipementManager->getUnique($id);
		$etatFonctionnel = $etatFonctionnelManager->getUnique(4);

		// Mise en panne
		if ($etatTechniqueId !== 0) { // C'est le pere, on change l'etat technique
			$etatTechnique = $etatTechniqueManager->getUnique($etatTechniqueId);

			$equipement->setEtatTechnique($etatTechnique);
			$equipement->setEtatFonctionnel($etatFonctionnel);
			$equipement->setMessageMaintenance($messageMaintenance);

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
		return true;
	}

}
