<?php

namespace Library\Model;

use Library\Entity\ChangementEtat;

class ChangementEtatManager {

	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function getUnique($date, $equipement) {
		$requete = $this->pdo->prepare("SELECT * FROM changement_etat WHERE date = :date AND equipement = :equipement");
		$requete->bindValue(":date", $date);
		$requete->bindValue(":equipement", $equipement);
		$requete->execute();
		if ($row = $requete->fetch()) {
			$changementEtat = new ChangementEtat();
			$changementEtat->setDate($row['date']);
			$changementEtat->setEquipement($row['equipement']);
			$changementEtat->setEtatFonctionnel($row['etat_fonctionnel']);
			$changementEtat->setEtatTechnique($row['etat_technique']);
			$changementEtat->setType($row['type']);
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
			$changementEtat->setDate($row['date']);
			$changementEtat->setEquipement($row['equipement']);
			$changementEtat->setEtatFonctionnel($row['etat_fonctionnel']);
			$changementEtat->setEtatTechnique($row['etat_technique']);
			$changementEtat->setType($row['type']);
			$changementEtat->setMessage($row['message']);
			
			$changementEtatList[] = $changementEtat;
		}
		return $changementEtatList;
	}

	public function insert(ChangementEtat $changementEtat) {
		$requete = $this->pdo->prepare("INSERT INTO changement_etat (date, equipement, etat_fonctionnel, etat_technique, type, message) VALUES(:date, :equipement, :etatFonctionnel, :etatFechnique, :type, :message)");
		$requete->bindValue(':date', $changementEtat->getDate());
		$requete->bindValue(':equipement', $changementEtat->getEquipement());
		$requete->bindValue(':etatFonctionnel', $changementEtat->getEtatFonctionnel());
		$requete->bindValue(':etatFechnique', $changementEtat->getEtatTechnique());
		$requete->bindValue(':type', $changementEtat->getType());
		$requete->bindValue(':message', $changementEtat->getMessage());
		return $requete->execute();
	}
}
