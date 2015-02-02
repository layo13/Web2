<?php

namespace Library\Model;

use Library\Entity\TypeEquipement;

class TypeEquipementManager {

	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function getUnique($id) {
		$requete = $this->pdo->prepare("SELECT * FROM type_equipement WHERE id = :id");
		$requete->bindValue(":id", $id);
		$requete->execute();
		if ($row = $requete->fetch()) {
			$typeEquipement = new TypeEquipement();
			$typeEquipement->setId($row['id']);
			$typeEquipement->setLibelle($row['libelle']);
			
			return $typeEquipement;
		} else {
			return NULL;
		} 
	}

	public function get() {
		$requete = $this->pdo->query("SELECT * FROM type_equipement");
		$typeEquipementList = array();
		foreach ($requete->fetchAll() as $row) {
			
			$typeEquipement = new TypeEquipement();
			$typeEquipement->setId($row['id']);
			$typeEquipement->setLibelle($row['libelle']);
			
			$typeEquipementList[] = $typeEquipement;
		}
		return $typeEquipementList;
	}

}
