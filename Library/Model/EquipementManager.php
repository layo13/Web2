<?php

namespace Library\Model;

use Library\Entity\Equipement;

class EquipementManager {

	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function getUnique($id) {
		$requete = $this->pdo->prepare("SELECT * FROM equipement WHERE id = :id");
		$requete->bindValue(":id", $id);
		$requete->execute();
		if ($row = $requete->fetch()) {
			$equipement = new Equipement();
			$equipement->setId($row['id']);
			$equipement->setPere($row['pere']);
			$equipement->setEtatTechnique($row['etat_technique']);
			$equipement->setEtatFonctionnel($row['etat_fonctionnel']);
			$equipement->setFabricant($row['fabricant']);
			$equipement->setType($row['type']);
			$equipement->setNom($row['nom']);
			$equipement->setAdresseIp($row['adresse_ip']);
			$equipement->setAdressePhysique($row['adresse_physique']);
			$equipement->setMessageMaintenance($row['message_maintenance']);
			$equipement->setNumeroSupport($row['numero_support']);
			$equipement->setUtilisateur($row['utilisateur']);
			return $equipement;
		} else {
			return NULL;
		} 
	}

	public function get() {
		$requete = $this->pdo->query("SELECT * FROM equipement");
		$equipementList = array();
		foreach ($requete->fetchAll() as $row) {
			
			$equipement = new Equipement();
			$equipement->setId($row['id']);
			$equipement->setPere($row['pere']);
			$equipement->setEtatTechnique($row['etat_technique']);
			$equipement->setEtatFonctionnel($row['etat_fonctionnel']);
			$equipement->setFabricant($row['fabricant']);
			$equipement->setType($row['type']);
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
		return $requete->execute();
	}

	public function update(Equipement $equipement) {
		$requete = $this->pdo->prepare("UPDATE equipement SET id = :id, pere = :pere, etat_technique = :etatTechnique, etat_fonctionnel = :etatFonctionnel, fabricant = :fabricant, type = :type, nom = :nom, adresse_ip = :adresseIp, adresse_physique = :adressePhysique, message_maintenance = :messageMaintenance, numero_support = :numeroSupport, utilisateur = :utilisateur WHERE id = :oldId");
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
		$requete->bindValue(':oldId', $equipement->getOldId());
		return $requete->execute();
	}

	public function delete($id) {
		$requete = $this->pdo->prepare("DELETE FROM equipement WHERE id = :id");
		$requete->bindValue(':id', $id);
		return $requete->execute();
	}

}
