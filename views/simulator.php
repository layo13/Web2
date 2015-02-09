<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name = "viewport" content="width=device-width, initial-scale=1">
		<title>Simulateur</title>
		<link rel="stylesheet" href="<?php echo $url; ?>css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $url; ?>css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="<?php echo $url; ?>css/font-awesome.min.css">
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="page-header">
						<h1>Simulateur <small>Gestion des équipements</small></h1>
						<button id="btn_refresh" type="button" class="btn btn-primary">
							<span class="glyphicon glyphicon-refresh"></span> Rafraîchir
						</button>
						<button id="btn_reboot" type="button" class="btn btn-success">
							<span class="glyphicon glyphicon-ok"></span> Remettre en marche
						</button>
					</div>
				</div>
			</div>
			<div class="row">
				
			</div>
			<div id="equipement_list" class="row">

			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" id="myModalDialog">
				<div class="modal-content">
					<div class="modal-header" id="myModalHeader">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Modal title</h4>
					</div>
					<div class="modal-body" id="myModalBody">

					</div>
					<div class="modal-footer" id="myModalFooter">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>

		<script src="<?php echo $url; ?>js/jquery.min.js"></script>
		<script src="<?php echo $url; ?>js/bootstrap.min.js"></script>
		<script>
			$(function () {
				function heaveEquipement(equipementId, etatTechniqueId, messageMaintenance) {
					if (messageMaintenance === null) {
						var data = {"etat_technique_id":etatTechniqueId};
					} else {
						var data = {"etat_technique_id":etatTechniqueId, "message_maintenance":messageMaintenance};
					}
					$.ajax({
						url: "<?php echo $url . "api/simulator/equipement/heave/"; ?>"+equipementId,
						type: "POST",
						data: data,
						success: function (json) {
							if (json.state !== "ok") {
								alert("erreur sur heaveEquipement");
							} else {
								initEquipementList();
							}
						}
					});
				}
				
				function initEquipementList() {
					$("#equipement_list").empty();
					$.ajax({
						url: "<?php echo $url . "api/equipement"; ?>",
						type: "GET",
						//data: $this.serialize(),
						success: function (json) {
							if (json.state === "ko") {
								alert(json.error);
							} else {
								var jsonEquipements = json.content;
								console.log(jsonEquipements);
								for (var i = 0; i < jsonEquipements.length; ++i) {
									var jsonEquipement = jsonEquipements[i];

									var h3Title = $("<h3/>", {"class": "panel-title"}).text(jsonEquipement.id + " - " + jsonEquipement.nom);
									var dlEtats = $("<dl/>", {"class": "dl-horizontal"});
									var dtEtatFonctionnel = $("<dt/>").text("Etat Fonctionnel");
									var ddEtatFonctionnel = $("<dd/>").text(jsonEquipement.etatFonctionnel.libelle);
									var dtEtatTechnique = $("<dt/>").text("Etat Technique");
									var ddEtatTechnique = $("<dd/>").text(jsonEquipement.etatTechnique.libelle);
									var panelHeading = $("<div/>", {"class": "panel-heading"});
									var panelBody = $("<div/>", {"class": "panel-body"});
									var panel = $("<div/>", {"class": "panel panel-default"});
									var divColMd3 = $("<div/>", {"class": "col-md-3"});
									var spanCaretEtatTechnique = $("<span/>", {"class":"caret"});
									var btnToggleEtatTechnique = $("<button/>", {"type":"button","class":"btn btn-default dropdown-toggle","data-toggle":"dropdown","aria-expanded":"false"});
									var btnEtatTechniquePanneMineure = $("<a/>", {"href":"#", "data-equipement":jsonEquipement.id, "data-etat-technique":"2", "class":"btn_etat_technique"});
									var liEtatTechniquePanneMineure = $("<li/>");
									var btnEtatTechniquePanneMajeure = $("<a/>", {"href":"#", "data-equipement":jsonEquipement.id, "data-etat-technique":"3", "class":"btn_etat_technique"});
									var liEtatTechniquePanneMajeure = $("<li/>");
									var btnEtatTechniquePanneInconnue = $("<a/>", {"href":"#", "data-equipement":jsonEquipement.id, "data-etat-technique":"4", "class":"btn_etat_technique"});
									var liEtatTechniquePanneInconnue = $("<li/>");
									var divider = $("<li/>", {"class":"divider"});
									var btnEtatTechniqueFonctionnel = $("<a/>", {"href":"#","data-etat-technique":"1","class":"btn_etat_technique"});
									var linEtatTechniqueFonctionnel = $("<li/>");
									var ulDropdownTechnique = $("<ul/>", {"class":"dropdown-menu","role":"menu"});
									var divBtnGroupTechnique = $("<div/>", {"class":"btn-group"});
									var spanCaretEtatFonctionnel = $("<span/>", {"class":"caret"});
									var btnToggleEtatFonctionnel = $("<button/>", {"type":"button","class":"btn btn-default dropdown-toggle","data-toggle":"dropdown","aria-expanded":"false"});
									var btnEtatFonctionneAllumer = $("<a/>", {"href":"#","data-etat-fonctionnel":"1","class":"btn_etat_fonctionnel"});
									var liEtatFonctionneAllumer = $("<li/>");
									var btnEtatFonctionnelEteindre = $("<a/>", {"href":"#","data-etat-fonctionnel":"2","class":"btn_etat_fonctionnel"});
									var liEtatFonctionnelEteindre = $("<li/>");
									var ulDropdownMenuFonctionnel = $("<ul/>", {"class":"dropdown-menu","role":"menu"});
									var divBtnGroupFonctionnel = $("<div/>", {"class":"btn-group"});
									var labelMessagePanne = $("<label/>", {"id":"lbl-"+jsonEquipement.id, "class":"control-label"}).text("Message de la panne");
									var textareaMessagePanne = $("<textarea/>", {"id":"ta-"+jsonEquipement.id, "class":"form-control"});
									if (jsonEquipement.messageMaintenance !== null) {
										$(textareaMessagePanne).text(jsonEquipement.messageMaintenance);
									}
									var divFormGroup = $("<div/>", {"class":"form-group"});

									$(divFormGroup).append(labelMessagePanne);
									$(divFormGroup).append(textareaMessagePanne);
									
									$(dlEtats).append(dtEtatFonctionnel);
									$(dlEtats).append(ddEtatFonctionnel);
									$(dlEtats).append(dtEtatTechnique);
									$(dlEtats).append(ddEtatTechnique);
									
									$(panelBody).append(dlEtats);
									$(panelBody).append(divFormGroup);
									$(btnToggleEtatTechnique).text("Modifier l'état technique ");
									$(btnToggleEtatTechnique).append(spanCaretEtatTechnique);
									$(divBtnGroupTechnique).append(btnToggleEtatTechnique);
									$(btnEtatTechniquePanneMineure).text("Panne mineure");
									$(liEtatTechniquePanneMineure).append(btnEtatTechniquePanneMineure);
									$(ulDropdownTechnique).append(liEtatTechniquePanneMineure);
									$(btnEtatTechniquePanneMajeure).text("Panne majeure");
									$(liEtatTechniquePanneMajeure).append(btnEtatTechniquePanneMajeure);
									$(ulDropdownTechnique).append(liEtatTechniquePanneMajeure);
									$(btnEtatTechniquePanneInconnue).text("Panne inconnue");
									$(liEtatTechniquePanneInconnue).append(btnEtatTechniquePanneInconnue);
									$(ulDropdownTechnique).append(liEtatTechniquePanneInconnue);
									$(ulDropdownTechnique).append(divider);
									$(btnEtatTechniqueFonctionnel).text("Remettre en marche");
									$(linEtatTechniqueFonctionnel).append(btnEtatTechniqueFonctionnel);
									$(ulDropdownTechnique).append(linEtatTechniqueFonctionnel);
									$(divBtnGroupTechnique).append(ulDropdownTechnique);
									$(panelBody).append(divBtnGroupTechnique);
									$(btnToggleEtatFonctionnel).append("Modifier l'état fonctionnel ");
									$(btnToggleEtatFonctionnel).append(spanCaretEtatFonctionnel);
									$(divBtnGroupFonctionnel).append(btnToggleEtatFonctionnel);
									$(btnEtatFonctionneAllumer).text("Allumer");
									$(liEtatFonctionneAllumer).append(btnEtatFonctionneAllumer);
									$(ulDropdownMenuFonctionnel).append(liEtatFonctionneAllumer);
									$(btnEtatFonctionnelEteindre).text("Eteindre");
									$(liEtatFonctionnelEteindre).append(btnEtatFonctionnelEteindre);
									$(ulDropdownMenuFonctionnel).append(liEtatFonctionnelEteindre);
									$(divBtnGroupFonctionnel).append(ulDropdownMenuFonctionnel);
									$(panelBody).append(divBtnGroupFonctionnel);
									$(panelHeading).append(h3Title);
									$(panel).append(panelHeading);
									$(panel).append(panelBody);
									$(divColMd3).append(panel);
									$("#equipement_list").append(divColMd3);
									
									// =========================================
									// ETAT TECHNIQUE
									// =========================================
									$(btnEtatTechniquePanneMineure).click(function(e) {
										e.preventDefault();
										var taVal = $(this).parent().parent().parent().parent().find("textarea").val();
										var messageMaintenance = taVal !== "" ? taVal : null;
										heaveEquipement(this.dataset.equipement, this.dataset.etatTechnique, messageMaintenance);
									});
									$(btnEtatTechniquePanneMajeure).click(function(e) {
										e.preventDefault();
										var taVal = $(this).parent().parent().parent().parent().find("textarea").val();
										var messageMaintenance = taVal !== "" ? taVal : null;
										heaveEquipement(this.dataset.equipement, this.dataset.etatTechnique, messageMaintenance);
									});
									$(btnEtatTechniquePanneInconnue).click(function(e) {
										e.preventDefault();
										var taVal = $(this).parent().parent().parent().parent().find("textarea").val();
										var messageMaintenance = taVal !== "" ? taVal : null;
										heaveEquipement(this.dataset.equipement, this.dataset.etatTechnique, messageMaintenance);
									});
									$(btnEtatTechniqueFonctionnel).click(function(e) {
										e.preventDefault();
										var taVal = $(this).parent().parent().parent().parent().find("textarea").val();
										var messageMaintenance = taVal !== "" ? taVal : null;
										heaveEquipement(this.dataset.equipement, this.dataset.etatTechnique, messageMaintenance);
									});
									
									// =========================================
									// ETAT FONCTIONNEL
									// =========================================
									$(btnEtatFonctionneAllumer).click(function() {

									});
									$(btnEtatFonctionnelEteindre).click(function() {

									});
								}
							}
						}
					});
				}
				$("#btn_refresh").click(function () {
					initEquipementList();
				});
				$("#btn_reboot").click(function () {
					$.ajax({
						url: "<?php echo $url . "api/simulator/equipement/reboot"; ?>",
						type: "POST",
						//data: {"etat_technique_id":etatTechniqueId},
						success: function (json) {
							if (json.state !== "ok") {
								alert("erreur sur reboot");
							} else {
								initEquipementList();
							}
						}
					});
				});
				
				initEquipementList();
			});
		</script>
	</body>
</html>
