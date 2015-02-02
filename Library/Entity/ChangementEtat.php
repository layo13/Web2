<?php

namespace Library\Entity;

class ChangementEtat {
	private $date;
	private $equipement;
	private $etatFonctionnel;
	private $etatTechnique;
	private $type;
	private $message;
	
	public function __construct() {
		$this->date = date('Y-m-d H:i:s');
	}
	
	function getDate() {
		return $this->date;
	}

	function getEquipement() {
		return $this->equipement;
	}

	function getEtatFonctionnel() {
		return $this->etatFonctionnel;
	}

	function getEtatTechnique() {
		return $this->etatTechnique;
	}

	function getType() {
		return $this->type;
	}

	function getMessage() {
		return $this->message;
	}

	function setDate($date) {
		$this->date = $date;
		return $this;
	}

	function setEquipement($equipement) {
		$this->equipement = $equipement;
		return $this;
	}

	function setEtatFonctionnel($etatFonctionnel) {
		$this->etatFonctionnel = $etatFonctionnel;
		return $this;
	}

	function setEtatFechnique($etatFechnique) {
		$this->etatFechnique = $etatFechnique;
		return $this;
	}

	function setType($type) {
		$this->type = $type;
		return $this;
	}

	function setMessage($message) {
		$this->message = $message;
		return $this;
	}


}
