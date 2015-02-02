<?php

namespace Library\Entity;

class Equipement {

	private $id;
	private $oldId;
	private $pere;
	private $etatTechnique;
	private $etatFonctionnel;
	private $fabricant;
	private $type;
	private $nom;
	private $adresseIp;
	private $adressePhysique;
	private $messageMaintenance;
	private $numeroSupport;
	private $utilisateur;

	function getId() {
		return $this->id;
	}
	
	function getOldId() {
		return $this->oldId;
	}

	function getPere() {
		return $this->pere;
	}

	function getEtatTechnique() {
		return $this->etatTechnique;
	}

	function getEtatFonctionnel() {
		return $this->etatFonctionnel;
	}

	function getFabricant() {
		return $this->fabricant;
	}

	function getType() {
		return $this->type;
	}

	function getNom() {
		return $this->nom;
	}

	function getAdresseIp() {
		return $this->adresseIp;
	}

	function getAdressePhysique() {
		return $this->adressePhysique;
	}

	function getMessageMaintenance() {
		return $this->messageMaintenance;
	}

	function getNumeroSupport() {
		return $this->numeroSupport;
	}

	function getUtilisateur() {
		return $this->utilisateur;
	}

	function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	function setOldId($oldId) {
		$this->oldId = $oldId;
		return $this;
	}

	function setPere($pere) {
		$this->pere = $pere;
		return $this;
	}

	function setEtatTechnique($etatTechnique) {
		$this->etatTechnique = $etatTechnique;
		return $this;
	}

	function setEtatFonctionnel($etatFonctionnel) {
		$this->etatFonctionnel = $etatFonctionnel;
		return $this;
	}

	function setFabricant($fabricant) {
		$this->fabricant = $fabricant;
		return $this;
	}

	function setType($type) {
		$this->type = $type;
		return $this;
	}

	function setNom($nom) {
		$this->nom = $nom;
		return $this;
	}

	function setAdresseIp($adresseIp) {
		$this->adresseIp = $adresseIp;
		return $this;
	}

	function setAdressePhysique($adressePhysique) {
		$this->adressePhysique = $adressePhysique;
		return $this;
	}

	function setMessageMaintenance($messageMaintenance) {
		$this->messageMaintenance = $messageMaintenance;
		return $this;
	}

	function setNumeroSupport($numeroSupport) {
		$this->numeroSupport = $numeroSupport;
		return $this;
	}

	function setUtilisateur($utilisateur) {
		$this->utilisateur = $utilisateur;
		return $this;
	}


}
