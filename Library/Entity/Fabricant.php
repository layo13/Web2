<?php

namespace Library\Entity;

class Fabricant {

	private $id;
	private $nom;

	function getId() {
		return $this->id;
	}

	function getNom() {
		return $this->nom;
	}

	function setId($id) {
		$this->id = $id;
		return $this;
	}

	function setNom($nom) {
		$this->nom = $nom;
		return $this;
	}
}
