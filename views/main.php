<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name = "viewport" content="width=device-width, initial-scale=1">
		<title>Gestion des équipements</title>
		<link rel="stylesheet" href="<?php echo $url; ?>css/bootstrap.min.css">
		<!--link rel="stylesheet" href="<?php echo $url; ?>css/bootstrap-theme.min.css"-->
		<link rel="stylesheet" href="<?php echo $url; ?>css/font-awesome.min.css">
		<style type="text/css">
			#equipement_list, #changement_etat_list {		
				max-height: 300px;
				overflow-y: scroll;
			}

			circle, [draggable=true] {
				-moz-user-select: none;
				-khtml-user-select: none;
				-webkit-user-select: none;
				user-select: none;
				cursor:move;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="page-header">
						<h1>Gestion des équipements</h1>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div>
						<!--button id="add_equipement" type="button" class="btn btn-primary btn-lg" data-operation="add" data-toggle="modal" data-target="#myModal" data-size="large">
							<span class="glyphicon glyphicon-plus-sign"></span> Ajouter un équipement
						</button-->
						<a class="btn btn-primary btn-lg" data-operation="add" data-toggle="modal" data-target="#myModal" data-size="large">
							<span class="glyphicon glyphicon-plus-sign"></span> Ajouter un équipement
						</a>
					</div>
					<hr />
					<div id="equipement_list" class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Liste des équipements</h3>
						</div>
					</div>
					<div class="well">
						<ul class="list-unstyled">
							<li>Valider les formulaires</li>
							<li>Finir le journal</li>
						</ul>
					</div>
				</div>
				<div class="col-md-6">
					<div id="flash"></div>
					<div id="main">
						<!--<object data="test.svg" width="100%" height="100%" type="image/svg+xml">
							<embed src="test.svg" width="500" height="500" type="image/svg+xml" />
						</object>-->
						<svg width="100%" height="600" style="border: 2px solid black;">
						<line x1="40" y1="40" x2="200" y2="200" style="stroke:#000000;" data-from="C-G453SR65" data-to="C-G5TRI6GH" />
						<line x1="200" y1="40" x2="200" y2="200" style="stroke:#000000;" data-from="C-RG5TB7H8" data-to="C-G5TRI6GH" />
						<line x1="40" y1="200" x2="200" y2="200" style="stroke:#000000;" data-from="C-SR65G453" data-to="C-G5TRI6GH" />

						<circle id="C-G453SR65" cx="40" cy="40" r="40" style="stroke:#3e8f3e; fill:#5cb85c;" transform="matrix(1 0 0 1 0 0)" onmousedown="selectElement(evt)"/>
						<circle id="C-G5TRI6GH" cx="200" cy="200" r="40" style="stroke:#3e8f3e; fill:#5cb85c;" transform="matrix(1 0 0 1 0 0)" onmousedown="selectElement(evt)"/>
						<circle id="C-RG5TB7H8" cx="200" cy="40" r="40" style="stroke:#3e8f3e; fill:#5cb85c;" transform="matrix(1 0 0 1 0 0)" onmousedown="selectElement(evt)"/>
						<circle id="C-SR65G453" cx="40" cy="200" r="40" style="stroke:#3e8f3e; fill:#5cb85c;" transform="matrix(1 0 0 1 0 0)" onmousedown="selectElement(evt)"/>
						</svg>
					</div>
				</div>
				<div class="col-md-3">
					<a id="link_simulator" href="#" class="btn btn-primary btn-lg">
						<span class="glyphicon glyphicon-new-window"></span> Accéder au simulateur
					</a>
					<a id="example" tabindex="0" class="btn btn-xs btn-info" role="button" data-toggle="popover" data-placement="left" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?">
						<span class="glyphicon glyphicon-new-window"></span>
					</a>
					<div id="changement_etat_list" class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Journal</h3>
						</div>
					</div>
					<div id="debug">

					</div>
				</div>
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
							// Gestion du svg
							var selectedElement = 0;
							var currentX = 0;
							var currentY = 0;
							var currentMatrix = 0;

							function selectElement(evt) {
								selectedElement = evt.target;
								currentX = evt.clientX;
								currentY = evt.clientY;
								currentMatrix = selectedElement.getAttributeNS(null, "transform").slice(7, -1).split(' ');

								for (var i = 0; i < currentMatrix.length; i++) {
									currentMatrix[i] = parseFloat(currentMatrix[i]);
								}

								selectedElement.setAttributeNS(null, "onmousemove", "moveElement(evt)");
								selectedElement.setAttributeNS(null, "onmouseout", "deselectElement(evt)");
								selectedElement.setAttributeNS(null, "onmouseup", "deselectElement(evt)");

							}

							function moveElement(evt) {
								dx = evt.clientX - currentX;
								dy = evt.clientY - currentY;
								currentMatrix[4] += dx;
								currentMatrix[5] += dy;
								newMatrix = "matrix(" + currentMatrix.join(' ') + ")";

								// debut
								var lines = document.getElementsByTagName("line");
								for (var i = 0; i < lines.length; i++) {
									var line = lines[i];

									if (line.dataset.from === selectedElement.id) {
										var currentX1 = parseInt(line.getAttribute("x1")) + dx;
										var currentY1 = parseInt(line.getAttribute("y1")) + dy;
										line.setAttribute("x1", currentX1);
										line.setAttribute("y1", currentY1);

									}
									if (line.dataset.to === selectedElement.id) {
										var currentX2 = parseInt(line.getAttribute("x2")) + dx;
										var currentY2 = parseInt(line.getAttribute("y2")) + dy;
										line.setAttribute("x2", currentX2);
										line.setAttribute("y2", currentY2);
									}
								}
								// fin

								selectedElement.setAttributeNS(null, "transform", newMatrix);
								currentX = evt.clientX;
								currentY = evt.clientY;
							}

							function deselectElement(evt) {
								if (selectedElement !== 0) {
									selectedElement.removeAttributeNS(null, "onmousemove");
									selectedElement.removeAttributeNS(null, "onmouseout");
									selectedElement.removeAttributeNS(null, "onmouseup");
									selectedElement = 0;
								}
							}

							/*(function(i){
							 alert(i);
							 })(2);*/

							$(function () {
								$('#example').popover();

								$('#link_simulator').click(function (event) {
									event.preventDefault();
									window.open("<?php echo $url . "simulator"; ?>");
								});

								function getLiEquipement(equipement) {
									var li = $("<li/>", {"class": "list-group-item", "data-equipement-id": equipement.id, });
									var spanGlyphiconCheck = $("<span/>", {"class": "glyphicon glyphicon-check"});
									var btnRead = $("<button/>", {"type": "button", "class": "btn btn-info btn-xs", "data-equipement-id": equipement.id, "data-operation": "read", "data-toggle": "modal", "data-target": "#myModal", "data-size": "large"});
									var spanGlyphiconEdit = $("<span/>", {"class": "glyphicon glyphicon-edit"});
									var btnUpdate = $("<button/>", {"type": "button", "class": "btn btn-warning btn-xs", "data-equipement-id": equipement.id, "data-operation": "update", "data-toggle": "modal", "data-target": "#myModal", "data-size": "large"});
									var spanGlyphiconTrash = $("<span/>", {"class": "glyphicon glyphicon-trash"});
									var btnDelete = $("<button/>", {"type": "button", "class": "btn btn-danger btn-xs btn-delete", "data-equipement-id": equipement.id, "data-operation": "delete", "data-toggle": "modal", "data-target": "#myModal", "data-size": "small"});
									var divBtnGroup = $("<div/>", {"class": "btn-group pull-right", "role": "group", "aria-label": "Opération"});
									var liLabel = $("<span/>", {"class": "li-label"}).text(equipement.id + " - " + equipement.nom);
									$(btnRead).append(spanGlyphiconCheck);
									$(divBtnGroup).append(btnRead);
									$(btnUpdate).append(spanGlyphiconEdit);
									$(divBtnGroup).append(btnUpdate);
									$(btnDelete).append(spanGlyphiconTrash);
									$(divBtnGroup).append(btnDelete);

									$(li).append(divBtnGroup);
									$(li).append(liLabel);
									return li;
								}
								function addNewEquipement(jsonEquipementList, callback) {
									for (var i = 0; i < jsonEquipementList.length; i++) {
										var found = false;
										var jsonEquipement = jsonEquipementList[i];

										for (var j = 0; j < $("li[data-equipement-id]").length; j++) {
											var liEquipement = $("li[data-equipement-id]")[j];
											if (jsonEquipement.id === $(liEquipement).attr("data-equipement-id")) {
												found = true;
												break;
											}
										}

										if (found === false) {
											$("#ul_equipement").append(getLiEquipement(jsonEquipement));
										} else {
											$(liEquipement).find(".li-label").text(jsonEquipement.id + " - " + jsonEquipement.nom);
										}
									}
									callback(jsonEquipementList);
								}

								function removeOldEquipement(jsonEquipementList) {

									for (var i = 0; i < $("li[data-equipement-id]").length; i++) {
										var found = false;
										var liEquipement = $("li[data-equipement-id]")[i];
										for (var i = 0; i < jsonEquipementList.length; i++) {
											var jsonEquipement = jsonEquipementList[i];
											if (jsonEquipement.id === $(liEquipement).attr("data-equipement-id")) {
												found = true;
												break;
											}
										}
										if (found === false) {
											$(liEquipement).remove();
										}
									}
								}

								function initSSE() {
									if (typeof (EventSource) !== "undefined") {
										var source = new EventSource("<?php echo $url . "sse/equipement"; ?>");
										source.onmessage = function (event) {
											var json = JSON.parse(event.data);

											if (json.state === "ok") {
												var jsonEquipementList = json.content;
												addNewEquipement(jsonEquipementList, removeOldEquipement);
											}
										};
									} else {
										document.getElementById("main").innerHTML = "Sorry, your browser does not support server-sent events...";
									}
								}
								function initSSEChangementEtat() {
									if (typeof (EventSource) !== "undefined") {
										var source = new EventSource("<?php echo $url . "sse/changement-etat"; ?>");
										source.onmessage = function (event) {
											var json = JSON.parse(event.data);
											if (json.state === "ok") {
												var jsonChangementEtatList = json.content;
												//addNew
												for (var i = 0; i < jsonChangementEtatList.length; i++) {
													var found = false;
													var jsonChangementEtat = jsonChangementEtatList[i];
													for (var j = 0; j < $("li[data-changement-etat-id]").length; j++) {
														var liChangementEtat = $("li[data-changement-etat-id]")[j];

														if (jsonChangementEtat.id === $(liChangementEtat).attr("data-changement-etat-id")) {
															found = true;
															break;
														}
													}
													if (found === false) {

														var jsonChangementEtat = jsonChangementEtatList[i];
														var li = $("<li/>", {"class": "list-group-item", "data-changement-etat-id": jsonChangementEtat.id});

														var btnRead = $("<a/>", {"href": "#", "data-equipement-id": jsonChangementEtat.equipement.id, "data-operation": "read", "data-toggle": "modal", "data-target": "#myModal", "data-size": "medium"}).text(jsonChangementEtat.equipement.nom);

														var dateChangementEtat = new Date(jsonChangementEtat.date);
														var formatedDateChangementEtat = (dateChangementEtat.getDate() < 10 ? "0" + dateChangementEtat.getDate() : dateChangementEtat.getDate())
															+ "/" + (dateChangementEtat.getMonth() < 10 ? "0" + (dateChangementEtat.getMonth() + 1) : (dateChangementEtat.getMonth() + 1))
															+ " à " + (dateChangementEtat.getHours() < 10 ? "0" + dateChangementEtat.getHours() : dateChangementEtat.getHours())
															+ "H" + (dateChangementEtat.getMinutes() < 10 ? "0" + dateChangementEtat.getMinutes() : dateChangementEtat.getMinutes());

														var text = "";
														if (jsonChangementEtat.type.id === "1") {// ajout
															text = "Ajout de l'équipement ";
														} else if (jsonChangementEtat.type.id === "2") {// Modif Propriétés
															text = "Modification des propriétés de l'équipement ";
														} else if (jsonChangementEtat.type.id === "3") {// Modif etat fonctionnel (Marche/Arrêt)
															text = "Modification des propriétés de l'équipement ";
														} else if (jsonChangementEtat.type.id === "4") {// Modif etat technique (Panne)
															text = "Modification de l'état technique de l'équipement ";
														} else {
															alert("Type de changement non pris en compte : " + jsonChangementEtat.type);
														}

														$(li).append(text);
														$(li).append(btnRead);
														$(li).append(" le " + formatedDateChangementEtat);

														$("#ul_changement_etat").append(li);
													}

												}
												//removOld
												for (var i = 0; i < $("li[data-changement-etat-id]").length; i++) {
													found = false;
													var liChangementEtat = $("li[data-changement-etat-id]")[i];
													for (var i = 0; i < jsonChangementEtatList.length; i++) {
														var jsonChangementEtat = jsonChangementEtatList[i];
														if (jsonChangementEtat.id === $(liChangementEtat).attr("data-changement-etat-id")) {
															found = true;
															break;
														}
													}
													if (found === false) {
														$(liChangementEtat).remove();
													}
												}
											}
										};
									} else {
										document.getElementById("main").innerHTML = "Sorry, your browser does not support server-sent events...";
									}
								}

								function getTitleAndValue(title, value) {
									var div = $("<div/>", {"class": "col-md-4"});
									var pageHeader = $("<div/>", {"class": "page-header"});
									var h4 = $("<h4/>").text(title);

									$(pageHeader).append(h4);
									$(div).append(pageHeader);
									$(div).append(value);
									return div;
								}

								/*
								 * GESTION DU MODAL
								 */
								$('#myModal').on('hidden.bs.modal', function (event) {
									var modal = $(this);
									$("#myModalBody").empty();

								});
								$('#myModal').on('show.bs.modal', function (event) {
									var button = $(event.relatedTarget);
									var equipementId = button.data('equipement-id') !== "undefined" ? button.data('equipement-id') : null;
									var operation = button.data('operation');
									var size = button.data('size');

									var modal = $(this);
									setSizeModal(modal, size);

									if (operation === "read") {
										$.ajax({
											url: "<?php echo $url . 'api/equipement/'; ?>" + equipementId,
											type: "GET",
											success: function (json) {
												console.log(json);
												if (json.state === "ko") {
													alert(json.error);
												} else {
													var jsonEquipement = json.content;

													var ligne1 = $("<div/>", {"class": "row"});
													var ligne2 = $("<div/>", {"class": "row"});
													var ligne3 = $("<div/>", {"class": "row"});
													var ligne4 = $("<div/>", {"class": "row"});

													$(ligne1).append(getTitleAndValue("Identifiant", jsonEquipement.id));
													$(ligne1).append(getTitleAndValue("Nom", jsonEquipement.nom));

													if (jsonEquipement.pere !== null) {
														$(ligne1).append(getTitleAndValue("Père", jsonEquipement.pere.nom));
													} else {
														$(ligne1).append(getTitleAndValue("Père", "Cet équipement ne dépend d'aucun autre."));
													}

													$(ligne2).append(getTitleAndValue("Utilisateur", jsonEquipement.utilisateur));
													$(ligne2).append(getTitleAndValue("Etat Technique", jsonEquipement.etatTechnique.libelle));
													$(ligne2).append(getTitleAndValue("Etat Fonctionnel", jsonEquipement.etatFonctionnel.libelle));

													$(ligne3).append(getTitleAndValue("Type", jsonEquipement.type.libelle));
													$(ligne3).append(getTitleAndValue("Fabricant", jsonEquipement.fabricant.nom));
													$(ligne3).append(getTitleAndValue("Numéro Support", jsonEquipement.numeroSupport));

													$(ligne4).append(getTitleAndValue("Adresse Ip", jsonEquipement.adresseIp));
													$(ligne4).append(getTitleAndValue("Adresse Physique", jsonEquipement.adressePhysique));
													$(ligne4).append(getTitleAndValue("Message Maintenance", jsonEquipement.messageMaintenance));

													$("#myModalBody").append(ligne1);
													$("#myModalBody").append(ligne2);
													$("#myModalBody").append(ligne3);
													$("#myModalBody").append(ligne4);

													$(modal).find(".btn.btn-primary").click(function () {
														$("#myModal").modal('hide');
													});
												}
											},
											error: function (err) {
												console.log(err);
											}
										});
									} else if (operation === "add") {
										var form = getEquipementForm({});
										$("#myModalBody").append(form);
										$(modal).find(".btn.btn-primary").click(function () {
											$(form).submit();
										});
									} else if (operation === "update") {
										$.ajax({
											url: "<?php echo $url . 'api/equipement/'; ?>" + equipementId,
											type: "GET",
											success: function (json) {
												console.log(json);
												if (json.state === "ko") {
													alert(json.error);
												} else {
													var jsonEquipement = json.content;
													var form = getEquipementForm(jsonEquipement);
													$("#myModalBody").append(form);
													$(modal).find(".btn.btn-primary").click(function () {
														$(form).submit();
													});
												}
											},
											error: function (err) {
												console.log(err);
											}
										});
									} else if (operation === "delete") {
										$("#myModalBody").text("Voulez-vous vraiment supprimer cet équipement ?");
										$(modal).find(".btn.btn-primary").click(function () {
											$("#myModal").modal('hide');
											$(this).unbind();
											$.ajax({
												url: "<?php echo $url; ?>api/equipement/" + equipementId,
												type: "DELETE",
												success: function (json) {
													console.log(json);
													if (json.state === "ko") {
														alert(json.error);
													} else {
														$(modal).find(".btn.btn-primary").unbind();
														var alert = $("<div/>", {"class": "alert alert-success", "role": "alert"}).text("L'équipement a bien été supprimé.");
														$("#flash").append(alert);
														setTimeout(function () {
															$(alert).hide('slow', function () {
																$(this).remove();
															});
														}, 5000);
													}
												},
												error: function (err) {
													console.log(err);
												}
											});
										});
									}
								});

								function getInputText(id, name, value, libelle) {
									var label = $("<label/>", {"class": "control-label", "for": "id"}).text(libelle);
									var input = $("<input/>", {"class": "form-control", "type": "text", "id": id, "name": name, "value": value});
									var divFormGroup = $("<div/>", {"class": "form-group"});

									$(divFormGroup).append(label);
									$(divFormGroup).append(input);
									return divFormGroup;
								}

								function getEquipementForm(options) {
									var defaults = {
										"id": null,
										"pere": null,
										"fabricant": "0",
										"type": "0",
										"nom": null,
										"adresseIp": null,
										"adressePhysique": null,
										"numeroSupport": null,
										"utilisateur": null
									};

									var parameters = $.extend(defaults, options);

									var divModalFlash = $("<div/>", {id: "modalFlash"});

									var labelType = $("<label/>", {"class": "control-label", "for": "type"}).text("Type");
									var selectType = $("<select/>", {"class": "form-control", "id": "type", "name": "type"});
									var divFormGroupType = $("<div/>", {"class": "form-group"});
									$.ajax({
										url: "<?php echo $url . 'api/type_equipement'; ?>",
										type: "GET",
										success: function (json) {
											if (json.state === "ko") {
												alert(json.error);
											} else {
												var jsonTypeEquipementList = json.content;
												var optionType = $("<option/>", {"value": ""}).text("Veuillez sélectionner un type d'équipement");
												$(selectType).append(optionType);
												for (var i = 0; i < jsonTypeEquipementList.length; ++i) {
													var jsonTypeEquipement = jsonTypeEquipementList[i];
													optionType = $("<option/>", {"value": jsonTypeEquipement.id}).text(jsonTypeEquipement.libelle);
													if (parameters.type.id === jsonTypeEquipement.id) {
														$(optionType).attr("selected", "selected");
													}
													$(selectType).append(optionType);
												}
											}
										}
									});

									var labelFabricant = $("<label/>", {"class": "control-label", "for": "fabricant"}).text("Fabricant");
									var selectFabricant = $("<select/>", {"class": "form-control", "id": "fabricant", "name": "fabricant"});
									var divFormGroupFabricant = $("<div/>", {"class": "form-group"});
									$.ajax({
										url: "<?php echo $url . 'api/fabricant'; ?>",
										type: "GET",
										success: function (json) {
											if (json.state === "ko") {
												alert(json.error);
											} else {
												var jsonFabricantList = json.content;
												var optionFabricant = $("<option/>", {"value": ""}).text("Veuillez sélectionner un fabricant");
												$(selectFabricant).append(optionFabricant);
												for (var i = 0; i < jsonFabricantList.length; ++i) {
													var jsonFabricant = jsonFabricantList[i];
													optionFabricant = $("<option/>", {"value": jsonFabricant.id}).text(jsonFabricant.nom);
													if (parameters.fabricant.id === jsonFabricant.id) {
														$(optionFabricant).attr("selected", "selected");
													}
													$(selectFabricant).append(optionFabricant);
												}
											}
										}
									});

									var labelPere = $("<label/>", {"class": "control-label", "for": "pere"}).text("Père");
									var selectPere = $("<select/>", {"class": "form-control", "id": "pere", "name": "pere"});
									var divFormGroupPere = $("<div/>", {"class": "form-group"});
									$.ajax({
										url: "<?php echo $url . "api/equipement"; ?>",
										type: "GET",
										//data: $this.serialize(),
										success: function (json) {
											if (json.state === "ko") {
												alert(json.error);
											} else {
												var ul = $("<ul/>", {"class": "list-group"});
												var jsonEquipementList = json.content;
												var optionPere = $("<option/>", {"value": ""}).text("Aucun");
												$(selectPere).append(optionPere);
												for (var i = 0; i < jsonEquipementList.length; ++i) {
													var jsonEquipement = jsonEquipementList[i];
													optionPere = $("<option/>", {"value": jsonEquipement.id}).text(jsonEquipement.nom);
													if (parameters.pere !== null && (parameters.pere.id === jsonEquipement.id)) {
														$(optionPere).attr("selected", "selected");
													}
													$(selectPere).append(optionPere);
												}
											}
										}
									});

									if (parameters.id === null) {
										var form = $("<form/>", {"method": "POST", "action": "<?php echo $url; ?>api/equipement"});
									} else {
										var form = $("<form/>", {"method": "POST", "action": "<?php echo $url; ?>api/equipement/" + parameters.id});
									}
									$(form).append(divModalFlash);
									$(form).append(getInputText("id", "id", parameters.id, "Identifiant"));

									$(divFormGroupType).append(labelType);
									$(divFormGroupType).append(selectType);
									$(form).append(divFormGroupType);
									$(divFormGroupFabricant).append(labelFabricant);
									$(divFormGroupFabricant).append(selectFabricant);
									$(form).append(divFormGroupFabricant);
									$(divFormGroupPere).append(labelPere);
									$(divFormGroupPere).append(selectPere);
									$(form).append(divFormGroupPere);
									$(form).append(getInputText("nom", "nom", parameters.nom, "Nom"));
									$(form).append(getInputText("adresse_ip", "adresse_ip", parameters.adresseIp, "Adresse Ip"));
									$(form).append(getInputText("adresse_physique", "adresse_physique", parameters.adressePhysique, "Adresse Physique"));

									$(form).append(getInputText("utilisateur", "utilisateur", parameters.utilisateur, "Utilisateur"));
									$(form).append(getInputText("numero_support", "numero_support", parameters.numeroSupport, "Numéro Support"));

									$(form).submit(function (e) {
										e.preventDefault();
										var $this = $(this);

										var id = $("#id").val();
										var type = $("#type").val();
										var fabricant = $("#fabricant").val();
										var nom = $("#nom").val();
										var adresseIp = $("#adresse_ip").val();
										var numeroSupport = $("#numero_support").val();
										var ok = true;
										var errorMessages = [];

										if (id.match(/^[A-Z][A-Z0-9]{7}$/) === null) {
											errorMessages.push("L'identifiant doit commencer par une lettre majuscule "+
												" suivie de 7 lettres majuscules et/ou de chiffres.");
											ok = false;
										} else {
											$.ajax({
												url: "<?php echo $url . "api/equipement"; ?>/"+id,
												type: "GET",
												//data: $this.serialize(),
												success: function (json) {
													console.log(json);
													if (json.state === "ko") {
														alert(json.error);
													} else {
														if (json.content !== null) {
															errorMessages.push("Un équipement porte déjà cet identifiant.");
															ok = false;
														}
													}
												}
											});
											
										}
										
										if (type === "") {
											errorMessages.push("Veuillez sélectionner un type d'équipement.");
											ok = false;
										}
										if (fabricant === "") {
											errorMessages.push("Veuillez sélectionner un fabricant.");
											ok = false;
										}
										if (nom === "") {
											errorMessages.push("Veuillez saisir un nom pour l'équipement.");
											ok = false;
										}
										if (adresseIp.match(/^([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})?$/) === null) {
											errorMessages.push("L'adresse Ip n'a pas un format valide.");
											ok = false;
										}
										if (numeroSupport.match(/^(0[0-9]{9})?$/) === null) {
											errorMessages.push("Le numéro du support n'a pas un format valide.");
											ok = false;
										}

										if (ok === true) {
											$.ajax({
												url: $this.attr('action'),
												type: $this.attr('method'),
												data: $this.serialize(),
												success: function (html) {
													$($this).unbind();
													$("#myModal").modal('hide');
													
													$("#myModal").find(".btn.btn-primary").click(function () {
														$(this).unbind();
													});
													
													$("#debug").html(html);
												}
											});
										} else {
											$(divModalFlash).empty();

											var cross = $("<span/>", {"aria-hidden": "true"}).text("x");
											var buttonCross = $("<button/>", {"type": "button", "class": "close", "data-dismiss": "alert", "aria-label": "Close"});
											var divAlert = $("<div/>", {"class": "alert alert-danger alert-dismissible", "role": "alert"});

											var ulErrors = $("<ul/>");
											for (var i = 0; i < errorMessages.length; ++i) {
												var errorMessage = errorMessages[i];
												var liError = $("<li/>").text(errorMessage);
												$(ulErrors).append(liError);
											}

											$(buttonCross).append(cross);
											$(divAlert).append(buttonCross);
											$(divAlert).append(ulErrors);
											$(divModalFlash).append(divAlert);
										}
									});

									return form;
								}

								function setSizeModal(modal, size) {
									var modalDialog = $(modal).find(".modal-dialog");
									if (size === "small") {
										if ($(modalDialog).hasClass("modal-lg")) {
											$(modalDialog).removeClass("modal-lg");
										}
										$(modalDialog).addClass("modal-sm");
									} else if (size === "medium") {
										if ($(modalDialog).hasClass("modal-lg")) {
											$(modalDialog).removeClass("modal-lg");
										}
										if ($(modalDialog).hasClass("modal-sm")) {
											$(modalDialog).removeClass("modal-sm");
										}
									} else if (size === "large") {
										if ($(modalDialog).hasClass("modal-sm")) {
											$(modalDialog).removeClass("modal-sm");
										}
										$(modalDialog).addClass("modal-lg");
									}
								}

								function initEquipementList() {
									$.ajax({
										url: "<?php echo $url . "api/equipement"; ?>",
										type: "GET",
										//data: $this.serialize(),
										success: function (json) {
											if (json.state === "ko") {
												alert(json.error);
											} else {
												var ul = $("<ul/>", {"id": "ul_equipement", "class": "list-group"});
												var jsonEquipements = json.content;
												for (var i = 0; i < jsonEquipements.length; ++i) {
													var jsonEquipement = jsonEquipements[i];

													$(ul).append(jsonEquipement);
												}
												$("#equipement_list").append(ul);
											}
										}
									});
								}
								function initChangementEtatList() {
									$.ajax({
										url: "<?php echo $url . "api/changement-etat"; ?>",
										type: "GET",
										//data: $this.serialize(),
										success: function (json) {
											if (json.state === "ko") {
												alert(json.error);
											} else {
												var ul = $("<ul/>", {"id": "ul_changement_etat", "class": "list-group"});
												var jsonChangementEtatList = json.content;
												for (var i = 0; i < jsonChangementEtatList.length; ++i) {
													var jsonChangementEtat = jsonChangementEtatList[i];
													var li = $("<li/>", {"class": "list-group-item", "data-changement-etat-id": jsonChangementEtat.id});

													var btnRead = $("<a/>", {"href": "#", "data-equipement-id": jsonChangementEtat.equipement.id, "data-operation": "read", "data-toggle": "modal", "data-target": "#myModal", "data-size": "medium"}).text(jsonChangementEtat.equipement.nom);

													var dateChangementEtat = new Date(jsonChangementEtat.date);
													var formatedDateChangementEtat = (dateChangementEtat.getDate() < 10 ? "0" + dateChangementEtat.getDate() : dateChangementEtat.getDate())
														+ "/" + (dateChangementEtat.getMonth() < 10 ? "0" + dateChangementEtat.getMonth() : dateChangementEtat.getMonth())
														+ " à " + (dateChangementEtat.getHours() < 10 ? "0" + dateChangementEtat.getHours() : dateChangementEtat.getHours())
														+ "H" + (dateChangementEtat.getMinutes() < 10 ? "0" + dateChangementEtat.getMinutes() : dateChangementEtat.getMinutes());

													var text = "";

													if (jsonChangementEtat.type.id === "1") {// ajout
														text = "Ajout de l'équipement ";
													} else if (jsonChangementEtat.type.id === "2") {// Modif Propriétés
														text = "Modification des propriétés de l'équipement ";
													} else if (jsonChangementEtat.type.id === "3") {// Modif etat fonctionnel (Marche/Arrêt)
														text = "Modification des propriétés de l'équipement ";
													} else if (jsonChangementEtat.type.id === "4") {// Modif etat technique (Panne)
														text = "Modification de l'état technique de l'équipement ";
													} else {
														alert("Type de changement non pris en compte : " + jsonChangementEtat.type);
													}

													$(li).append(text);
													$(li).append(btnRead);
													$(li).append(" le " + formatedDateChangementEtat);

													$(ul).append(li);
												}

												$("#changement_etat_list").append(ul);

											}
										}
									});
								}
								initEquipementList();
								initChangementEtatList();
								initSSE();
								initSSEChangementEtat();
							});
		</script>
	</body>
</html>
