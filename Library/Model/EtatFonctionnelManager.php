<?php

namespace Library\Model;

use Library\Entity\EtatFonctionnel;

class EtatFonctionnelManager {

	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function getUnique($id) {
		$requete = $this->pdo->prepare("SELECT * FROM etat_fonctionnel WHERE id = :id");
		$requete->bindValue(":id", $id);
		$requete->execute();
		if ($row = $requete->fetch()) {
			$etatFonctionnel = new EtatFonctionnel();
			$etatFonctionnel->setId($row['id']);
			$etatFonctionnel->setLibelle($row['libelle']);
			
			return $etatFonctionnel;
		} else {
			return NULL;
		} 
	}

	public function get() {
		$requete = $this->pdo->query("SELECT * FROM etat_fonctionnel");
		$etatFonctionnelList = array();
		foreach ($requete->fetchAll() as $row) {
			
			$etatFonctionnel = new EtatFonctionnel();
			$etatFonctionnel->setId($row['id']);
			$etatFonctionnel->setLibelle($row['libelle']);
			
			$etatFonctionnelList[] = $etatFonctionnel;
		}
		return $etatFonctionnelList;
	}

}
