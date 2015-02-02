<?php

namespace Library\Model;

use Library\Entity\Fabricant;

class FabricantManager {

	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function getUnique($id) {
		$requete = $this->pdo->prepare("SELECT * FROM fabricant WHERE id = :id");
		$requete->bindValue(":id", $id);
		$requete->execute();
		if ($row = $requete->fetch()) {
			$fabricant = new Fabricant();
			$fabricant->setId($row['id']);
			$fabricant->setNom($row['nom']);
			
			return $fabricant;
		} else {
			return NULL;
		} 
	}

	public function get() {
		$requete = $this->pdo->query("SELECT * FROM fabricant");
		$fabricantList = array();
		foreach ($requete->fetchAll() as $row) {
			
			$fabricant = new Fabricant();
			$fabricant->setId($row['id']);
			$fabricant->setNom($row['nom']);
			
			$fabricantList[] = $fabricant;
		}
		return $fabricantList;
	}

}
