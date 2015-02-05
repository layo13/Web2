<?php

namespace Library\Model;

use Library\Entity\ChangementEtat;
use Library\Model\TypeChangementManager;
use Library\Model\EquipementManager;
use Library\Model\EtatFonctionnelManager;
use Library\Model\EtatTechniqueManager;

class ChangementEtatManager {

	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function getUnique($id) {
		$requete = $this->pdo->prepare("SELECT * FROM changement_etat WHERE id = :id");
		$requete->bindValue(":id", $id);
		$requete->execute();
		if ($row = $requete->fetch()) {
			$equipementManager = new EquipementManager($this->pdo);
			
			$changementEtat = new ChangementEtat();
			$changementEtat->setId($row['id']);
			$changementEtat->setEquipement($row['equipement']);
			$changementEtat->setEtatFonctionnel($row['etat_fonctionnel']);
			$changementEtat->setEtatTechnique($row['etat_technique']);
			$changementEtat->setType($row['type']);
			$changementEtat->setDate($row['date']);
			$changementEtat->setMessage($row['message']);
			return $changementEtat;
		} else {
			return NULL;
		} 
	}

	public function get() {
		$requete = $this->pdo->query("SELECT * FROM changement_etat");
		$changementEtatList = array();
		foreach ($requete->fetchAll() as $row) {
			
			$changementEtat = new ChangementEtat();
			$changementEtat->setId($row['id']);
			$changementEtat->setEquipement($row['equipement']);
			$changementEtat->setEtatFonctionnel($row['etat_fonctionnel']);
			$changementEtat->setEtatTechnique($row['etat_technique']);
			$changementEtat->setType($row['type']);
			$changementEtat->setDate($row['date']);
			$changementEtat->setMessage($row['message']);
			
			$changementEtatList[] = $changementEtat;
		}
		return $changementEtatList;
	}

	public function insert(ChangementEtat $changementEtat) {
		$requete = $this->pdo->prepare("INSERT INTO changement_etat (equipement, etat_fonctionnel, etat_technique, type, date, message) VALUES(:date, :equipement, :etatFonctionnel, :etatFechnique, :type, :message)");
		$requete->bindValue(':equipement', $changementEtat->getEquipement());
		$requete->bindValue(':etatFonctionnel', $changementEtat->getEtatFonctionnel());
		$requete->bindValue(':etatFechnique', $changementEtat->getEtatTechnique());
		$requete->bindValue(':type', $changementEtat->getType());
		$requete->bindValue(':date', $changementEtat->getDate());
		$requete->bindValue(':message', $changementEtat->getMessage());
		return $requete->execute();
	}
}
