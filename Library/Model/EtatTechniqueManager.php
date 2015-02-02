<?php

namespace Library\Model;

use Library\Entity\EtatTechnique;

class EtatTechniqueManager {

	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function getUnique($id) {
		$requete = $this->pdo->prepare("SELECT * FROM etat_technique WHERE id = :id");
		$requete->bindValue(":id", $id);
		$requete->execute();
		if ($row = $requete->fetch()) {
			$etatTechnique = new EtatTechnique();
			$etatTechnique->setId($row['id']);
			$etatTechnique->setLibelle($row['libelle']);
			
			return $etatTechnique;
		} else {
			return NULL;
		} 
	}

	public function get() {
		$requete = $this->pdo->query("SELECT * FROM etat_technique");
		$etatTechniqueList = array();
		foreach ($requete->fetchAll() as $row) {
			
			$etatTechnique = new EtatTechnique();
			$etatTechnique->setId($row['id']);
			$etatTechnique->setLibelle($row['libelle']);
			
			$etatTechniqueList[] = $etatTechnique;
		}
		return $etatTechniqueList;
	}

}
