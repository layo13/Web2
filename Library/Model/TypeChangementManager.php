<?php

namespace Library\Model;

use Library\Entity\TypeChangement;

class TypeChangementManager {

	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function getUnique($id) {
		$requete = $this->pdo->prepare("SELECT * FROM type_changement WHERE id = :id");
		$requete->bindValue(":id", $id);
		$requete->execute();
		if ($row = $requete->fetch()) {
			$typeChangement = new TypeChangement();
			$typeChangement->setId($row['id']);
			$typeChangement->setLibelle($row['libelle']);
			
			return $typeChangement;
		} else {
			return NULL;
		} 
	}

	public function get() {
		$requete = $this->pdo->query("SELECT * FROM type_changement");
		$typeChangementList = array();
		foreach ($requete->fetchAll() as $row) {
			
			$typeChangement = new TypeChangement();
			$typeChangement->setId($row['id']);
			$typeChangement->setLibelle($row['libelle']);
			
			$typeChangementList[] = $typeChangement;
		}
		return $typeChangementList;
	}

}
