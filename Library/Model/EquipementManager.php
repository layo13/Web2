<?php

namespace Library\Model;

use Library\Entity\Equipement;
use Library\Model\EtatFonctionnelManager;
use Library\Model\EtatTechniqueManager;
use Library\Model\FabricantManager;
use Library\Model\TypeEquipementManager;

class EquipementManager {

	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	/**
	 * 
	 * @param string $id
	 * @return Equipement
	 */
	public function getUnique($id) {
		$requete = $this->pdo->prepare("SELECT * FROM equipement WHERE id = :id");
		$requete->bindValue(":id", $id);
		$requete->execute();
		if ($row = $requete->fetch()) {
			
			$etatFonctionnelManager = new EtatFonctionnelManager($this->pdo);
			$etatTechniqueManager = new EtatTechniqueManager($this->pdo);
			$fabricantManager = new FabricantManager($this->pdo);
			$typeEquipementManager = new TypeEquipementManager($this->pdo);
			
			$equipement = new Equipement();
			$equipement->setId($row['id']);
			$equipement->setPere($this->getUnique($row['pere']));
			$equipement->setEtatTechnique($etatTechniqueManager->getUnique($row['etat_technique']));
			$equipement->setEtatFonctionnel($etatFonctionnelManager->getUnique($row['etat_fonctionnel']));
			$equipement->setFabricant($fabricantManager->getUnique($row['fabricant']));
			$equipement->setType($typeEquipementManager->getUnique($row['type']));
			$equipement->setNom($row['nom']);
			$equipement->setAdresseIp($row['adresse_ip']);
			$equipement->setAdressePhysique($row['adresse_physique']);
			$equipement->setMessageMaintenance($row['message_maintenance']);
			$equipement->setNumeroSupport($row['numero_support']);
			$equipement->setUtilisateur($row['utilisateur']);
			$equipement->setOldId($row['id']);
			return $equipement;
		} else {
			return NULL;
		} 
	}

	/**
	 * 
	 * @return array
	 */
	public function get() {
		$requete = $this->pdo->query("SELECT * FROM equipement");
		$equipementList = array();
		$etatFonctionnelManager = new EtatFonctionnelManager($this->pdo);
		$etatTechniqueManager = new EtatTechniqueManager($this->pdo);
		$fabricantManager = new FabricantManager($this->pdo);
		$typeEquipementManager = new TypeEquipementManager($this->pdo);
		foreach ($requete->fetchAll() as $row) {
			
			$equipement = new Equipement();
			$equipement->setId($row['id']);
			$equipement->setPere($this->getUnique($row['pere']));
			$equipement->setEtatTechnique($etatTechniqueManager->getUnique($row['etat_technique']));
			$equipement->setEtatFonctionnel($etatFonctionnelManager->getUnique($row['etat_fonctionnel']));
			$equipement->setFabricant($fabricantManager->getUnique($row['fabricant']));
			$equipement->setType($typeEquipementManager->getUnique($row['type']));
			$equipement->setNom($row['nom']);
			$equipement->setAdresseIp($row['adresse_ip']);
			$equipement->setAdressePhysique($row['adresse_physique']);
			$equipement->setMessageMaintenance($row['message_maintenance']);
			$equipement->setNumeroSupport($row['numero_support']);
			$equipement->setUtilisateur($row['utilisateur']);
			$equipement->setOldId($row['id']);
			
			$equipementList[] = $equipement;
		}
		return $equipementList;
	}
	
	public function getByPere($pere) {
		$requete = $this->pdo->prepare("SELECT * FROM equipement where pere = :pere");
		$requete->bindValue(":pere", $pere);
		$ok = $requete->execute();
		if ($ok == false) {
			return $ok;
		}
		$equipementList = array();
		$etatFonctionnelManager = new EtatFonctionnelManager($this->pdo);
		$etatTechniqueManager = new EtatTechniqueManager($this->pdo);
		$fabricantManager = new FabricantManager($this->pdo);
		$typeEquipementManager = new TypeEquipementManager($this->pdo);
		foreach ($requete->fetchAll() as $row) {
			
			$equipement = new Equipement();
			$equipement->setId($row['id']);
			$equipement->setPere($this->getUnique($row['pere']));
			$equipement->setEtatTechnique($etatTechniqueManager->getUnique($row['etat_technique']));
			$equipement->setEtatFonctionnel($etatFonctionnelManager->getUnique($row['etat_fonctionnel']));
			$equipement->setFabricant($fabricantManager->getUnique($row['fabricant']));
			$equipement->setType($typeEquipementManager->getUnique($row['type']));
			$equipement->setNom($row['nom']);
			$equipement->setAdresseIp($row['adresse_ip']);
			$equipement->setAdressePhysique($row['adresse_physique']);
			$equipement->setMessageMaintenance($row['message_maintenance']);
			$equipement->setNumeroSupport($row['numero_support']);
			$equipement->setUtilisateur($row['utilisateur']);
			
			$equipementList[] = $equipement;
		}
		return $equipementList;
	}

	public function insert(Equipement $equipement) {
		
		$requete = $this->pdo->prepare("INSERT INTO equipement (id, pere, etat_technique, etat_fonctionnel, fabricant, type, nom, adresse_ip, adresse_physique, message_maintenance, numero_support, utilisateur) VALUES(:id, :pere, :etatTechnique, :etatFonctionnel, :fabricant, :type, :nom, :adresseIp, :adressePhysique, :messageMaintenance, :numeroSupport, :utilisateur)");
		$requete->bindValue(':id', $equipement->getId());
		$requete->bindValue(':pere', $equipement->getPere());
		$requete->bindValue(':etatTechnique', $equipement->getEtatTechnique());
		$requete->bindValue(':etatFonctionnel', $equipement->getEtatFonctionnel());
		$requete->bindValue(':fabricant', $equipement->getFabricant());
		$requete->bindValue(':type', $equipement->getType());
		$requete->bindValue(':nom', $equipement->getNom());
		$requete->bindValue(':adresseIp', $equipement->getAdresseIp());
		$requete->bindValue(':adressePhysique', $equipement->getAdressePhysique());
		$requete->bindValue(':messageMaintenance', $equipement->getMessageMaintenance());
		$requete->bindValue(':numeroSupport', $equipement->getNumeroSupport());
		$requete->bindValue(':utilisateur', $equipement->getUtilisateur());
		
		if ($requete->execute()) {
			return $equipement->getId();
		} else {
			return null;
		}
	}

	public function update(Equipement $equipement) {
		$requete = $this->pdo->prepare("UPDATE equipement SET id = :id, pere = :pere, etat_technique = :etatTechnique, etat_fonctionnel = :etatFonctionnel, fabricant = :fabricant, type = :type, nom = :nom, adresse_ip = :adresseIp, adresse_physique = :adressePhysique, message_maintenance = :messageMaintenance, numero_support = :numeroSupport, utilisateur = :utilisateur WHERE id = :oldId");
		$requete->bindValue(':id', $equipement->getId());
		$requete->bindValue(':pere', $equipement->getPere() !== null ? $equipement->getPere()->getId() : null);
		$requete->bindValue(':etatTechnique', $equipement->getEtatTechnique()->getId());
		$requete->bindValue(':etatFonctionnel', $equipement->getEtatFonctionnel()->getId());
		$requete->bindValue(':fabricant', $equipement->getFabricant()->getId());
		$requete->bindValue(':type', $equipement->getType()->getId());
		$requete->bindValue(':nom', $equipement->getNom());
		$requete->bindValue(':adresseIp', $equipement->getAdresseIp());
		$requete->bindValue(':adressePhysique', $equipement->getAdressePhysique());
		$requete->bindValue(':messageMaintenance', $equipement->getMessageMaintenance());
		$requete->bindValue(':numeroSupport', $equipement->getNumeroSupport());
		$requete->bindValue(':utilisateur', $equipement->getUtilisateur());
		$requete->bindValue(':oldId', $equipement->getOldId());
		return $requete->execute();
	}

	public function delete($id) {
		$requete = $this->pdo->prepare("DELETE FROM equipement WHERE id = :id");
		$requete->bindValue(':id', $id);
		return $requete->execute();
	}

}
