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

			img, [draggable=true] {
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
						<svg id="graph" width="100%" height="600" style="border: 2px solid black;">
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

				var texte = document.getElementById("Text"+selectedElement.id);
				var currentTextX = parseInt(texte.getAttribute("x")) + dx;
				var currentTextY = parseInt(texte.getAttribute("y")) + dy;
				texte.setAttribute("x", currentTextX);
				texte.setAttribute("y", currentTextY);
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

			function makeImg(height, width, id, href, x ,y){
						svgimg = document.createElementNS('http://www.w3.org/2000/svg','image');
						svgimg.setAttribute('height',height);
						svgimg.setAttribute('width',width);
						svgimg.setAttribute('id', id);
						svgimg.setAttributeNS('http://www.w3.org/1999/xlink','href',href);
						svgimg.setAttribute('x',x);
						svgimg.setAttribute('y',y);
						svgimg.setAttribute('transform', "matrix(1 0 0 1 0 0)");
						svgimg.setAttribute('onmousedown', "selectElement(evt)");

						return svgimg;
					}

					function makeSVG(tag, attrs) {
							var el= document.createElementNS('http://www.w3.org/2000/svg', tag);
							for (var k in attrs)
								el.setAttribute(k, attrs[k]);
							return el;
					}

					function removeSvg(id){
						img = document.getElementById(id);
						text = document.getElementById("Text"+id);

						// suppression des lignes
						var lines = document.getElementsByTagName("line");
						for (var i = 0; i < lines.length; i++) {
							var line = lines[i];
							if (line.dataset.from === id) {
								document.getElementById("graph").removeChild(line);
							}
							if (line.dataset.to === id) {
								document.getElementById("graph").removeChild(line);
							}
						}
						// suppression du texte 
						document.getElementById("graph").removeChild(text);
						// suppression de l'image
						document.getElementById("graph").removeChild(img);
					}

						function overlap(TestedEquipementX, TestedEquipementY, equipementX, equipementY){

				        	// X axis overlap
				        	if( (TestedEquipementX >= equipementX && (TestedEquipementX - 40 <= equipementX + 40)) || (TestedEquipementX <= equipementX && (TestedEquipementX + 40 >= equipementX - 40)) ){
				        		// Y axis Overlap
				        		if((TestedEquipementY >=equipementY && (TestedEquipementY - 40 <=equipementY + 40)) || (TestedEquipementY <=equipementY && (TestedEquipementY + 40 >=equipementY - 40))){
				        			return true;
				        		}
				        	}

				        	return false;
				        }

				        function changeEquipement(id, name, libelleTechnique, libelleFonctionnel, type){
				        	changeEquipementState(id, libelleTechnique, libelleFonctionnel, type);
				        	changeEquipementText(id, name);
				        }

				        function formatText(innerText){
				        	if(innerText.length > 10){
								innerText = innerText.substring(0, 10);
								innerText += "[..]";
							}
				        	return innerText;
				        }

						function changeEquipementText(id, text){
							document.getElementById("Text"+id).innerHTML = formatText(text);
						}

				        function changeEquipementState(id, libelleTechnique, libelleFonctionnel, type){

				        	if(libelleTechnique !== "Fonctionnel"){
				        		changeEquipementColor(id, "red", type);
				        	}
				        	else{
				        		if(libelleFonctionnel === "En marche") {
				        			changeEquipementColor(id, "green", type);
				        		} else if(libelleFonctionnel === "Eteint") {
				        			changeEquipementColor(id, "grey", type);
				        		} else if (libelleFonctionnel === "En arrêt de maintenance"){
				        			changeEquipementColor(id, "yellow", type);
				        		}
				        	}
				        }

				        function changeEquipementColor(id, color, type){

				        	var folder;

				        	switch(type) {
							    case "Ordinateur fixe":
							        folder = "workstation";
							        break;
							    case "Ordinateur portable":
							        folder = "notebook";
							        break;
							    case "Imprimante":
							        folder = "printer";
							        break;
							    case "Photocopieuse":
							        folder = "scanner";
							        break;
							    case "Téléphone":
							        folder = "smartphone";
							        break;
							    case "Routeur":
							        folder = "stack";
							        break;
							    case "Serveur":
							        folder = "switch";
							        break;
							    default: 
							    	alert(type);
							    	break;
							}

				        	equipement = document.getElementById(id);
				        	equipement.setAttributeNS('http://www.w3.org/1999/xlink','href', "img/"+folder+"/"+color+".gif");
				       
				        }

				        function getSvgVoidSpace(){

							var cercles = document.getElementsByTagName("image"); 
				        	var cercle;
				        	var voidSpaceX = 0;
				        	var voidSpaceY = 40;
				        	var cercleX;
				        	var cercleY;
				        	var svgWidth = $("#graph").innerWidth();
				        	var placed = false;

				        	while(!placed){
				        		voidSpaceX += 40;
				        		placed = true;

				        		if(cercles.length !== 0){
					        		for (var i = 0; i < cercles.length; i++) {
					        			cercle = cercles[i];
					        			cercleX = parseInt(cercle.getAttribute("x"));
										cercleY = parseInt(cercle.getAttribute("y"));
					        			if(overlap(voidSpaceX, voidSpaceY, cercleX, cercleY)){
					        				placed = false;
					        			}
					        		};
					        	}
					        	if((voidSpaceX + 40) > svgWidth){
					        		voidSpaceX = 0;
					        		voidSpaceY += 80;
					        		placed = false;
					        	}
				        	}

				        	return {"x":voidSpaceX, "y":voidSpaceY};
				        }

				        function drawLine(idEquipement, idPere){
				        	var equipement = $("#"+idEquipement);
							var pere = $("#"+idPere);
							var x1 = parseInt(equipement.attr("x")) + parseInt(12);	
							var y1 = parseInt(equipement.attr("y")) + parseInt(12);
							var x2 = parseInt(pere.attr("x")) + parseInt(12);
							var y2 = parseInt(pere.attr("y")) + parseInt(12);

				        	var lien = makeSVG('line' , {"x1": x1 , "y1": y1 , "x2": x2 , "y2": y2 ,"style": "stroke:#000000;", "data-from": idEquipement, "data-to": idPere});
							$("#graph").append(lien);
				        }

				        function drawEquipement(equipementId, name, libelleTechnique, libelleFonctionnel, type){
				        	var coord = getSvgVoidSpace();
							var x = coord.x;
							var y = coord.y;
							
							var text 	= makeSVG('text' , {"id":"Text"+equipementId ,"x":x-15, "y":y-5, "fill":"black"});
							var image 	= makeImg("24", "24", equipementId, "img/defaut.gif", x, y);
							
							$("#graph").append(image);
							$("#graph").append(text);

							changeEquipement(equipementId, name, libelleTechnique, libelleFonctionnel, type);
							changeEquipementText(equipementId, name);
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

							if(document.getElementById(jsonEquipement.id) === null){
								drawEquipement(jsonEquipement.id, jsonEquipement.nom, jsonEquipement.etatTechnique.libelle, jsonEquipement.etatFonctionnel.libelle, jsonEquipement.type.libelle);		
								if(jsonEquipement.pere !== null){
									if(document.getElementById(jsonEquipement.pere.id) === null){
										drawEquipement(jsonEquipement.pere.id, jsonEquipement.pere.nom, jsonEquipement.pere.etatTechnique.libelle, jsonEquipement.pere.etatFonctionnel.libelle, jsonEquipement.pere.type.libelle);  // Infos à ajouter dans le JSON PLZ 
									}
									drawLine(jsonEquipement.id, jsonEquipement.pere.id);
								}
							}
						} else {
							$(liEquipement).find(".li-label").text(jsonEquipement.id + " - " + jsonEquipement.nom);

							if(document.getElementById(jsonEquipement.id) !== null){
								changeEquipement(jsonEquipement.id, jsonEquipement.nom, jsonEquipement.etatTechnique.libelle, jsonEquipement.etatFonctionnel.libelle, jsonEquipement.type.libelle);
							}
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
							removeSvg($(liEquipement).attr("data-equipement-id"));
						}
					}
				}

				function initSSEEquipement() {
					if (typeof (EventSource) !== "undefined") {
						var sourceEquipement = new EventSource("<?php echo $url . "sse/equipement"; ?>");
						sourceEquipement.onmessage = function (event) {
							var json = JSON.parse(event.data);
							//console.log("initSSEEquipement", json);
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
						var sourceChangementEtat = new EventSource("<?php echo $url . "sse/changement-etat"; ?>");
						console.log(sourceChangementEtat);
						sourceChangementEtat.onmessage = function (event) {
							var json = JSON.parse(event.data);
							console.log("initSSEChangementEtat", json);
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
					
					$(modal).find(".btn.btn-primary").unbind();

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
						url: "<?php echo $url . 'api/type-equipement'; ?>",
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

									$("#myModal").find(".btn.btn-primary").unbind();

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
							//console.log("initEquipementList", json);
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
							//console.log("initChangementEtatList", json);
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

				function initSvg() {
									$.ajax({
										url: "<?php echo $url . "api/equipement"; ?>",
										type: "GET",
									
									success: function (json) {
										if (json.state === "ko") {
											alert(json.error);
										} else {
											var jsonEquipements = json.content;
											for (var i = 0; i < jsonEquipements.length; ++i) {

												var found = false;
												var jsonEquipement = jsonEquipements[i];

												for (var j = 0; j < $("image").length; j++) {
													var Equipement = $("image")[j];
													if (jsonEquipement.id === $(Equipement).attr("id")) {
														found = true;
														break;
													}
												}

												if(!found){
													var equipementId = jsonEquipements[i].id;
													drawEquipement(equipementId, jsonEquipements[i].nom, jsonEquipements[i].etatTechnique.libelle, jsonEquipements[i].etatFonctionnel.libelle, jsonEquipements[i].type.libelle);
													
													if(jsonEquipements[i].pere != null){
														var pereId = jsonEquipements[i].pere.id;
														if(document.getElementById(pereId) == null){
															drawEquipement(pereId, jsonEquipements[i].pere.nom, jsonEquipements[i].pere.etatTechnique.libelle, jsonEquipements[i].pere.etatFonctionnel.libelle, jsonEquipements[i].pere.type.libelle);  // Infos à ajouter dans le JSON PLZ 
														}
														drawLine(equipementId, pereId);
													}
												}
												
											}
										}
									}
								});
							}
				initEquipementList();
				initChangementEtatList();
				initSSEEquipement();
				initSSEChangementEtat();
				//initSvg();
			});
		</script>
	</body>
</html>
