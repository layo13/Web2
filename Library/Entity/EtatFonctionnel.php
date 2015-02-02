<?php

namespace Library\Entity;

class EtatFonctionnel {

	private $id;
	private $libelle;

	function getId() {
		return $this->id;
	}

	function getLibelle() {
		return $this->libelle;
	}

	function setId($id) {
		$this->id = $id;
		return $this;
	}

	function setLibelle($libelle) {
		$this->libelle = $libelle;
		return $this;
	}
}
