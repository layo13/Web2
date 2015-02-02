<?php
require_once('Library/PDOProvider.php');
require_once('Entity/Equipement.php');
require_once('Model/EquipementManager.php');

$pdo = PDOProvider::getInstance();
$equipement = new Equipement();
$equipementManager = new EquipementManager($pdo);

$equipement->setId("G5TRI6GH");
$equipement->setPere(NULL);
$equipement->setEtatTechnique(1);
$equipement->setEtatFonctionnel(1);
$equipement->setFabricant(2);
$equipement->setType(2);
$equipement->setNom("Ordi");
$equipement->setAdresseIp("45.45.45.45");
$equipement->setAdressePhysique("");
$equipement->setMessageMaintenance("");
$equipement->setNumeroSupport("");
$equipement->setUtilisateur("Patrick");

//var_dump($equipementManager->insert($equipement));
var_dump($equipementManager->get());
//var_dump($equipementManager->getUnique('G453SR65'));
//var_dump($equipementManager->getUnique('G453R65'));

