var elem3 = $("<h3/>", {"class":"panel-title"});
var elem2 = $("<div/>", {"class":"panel-heading"});
var elem3 = $("<div/>", {"class":"panel-body"});
var elem4 = $("<div/>", {"class":"panel-footer"});
var elem1 = $("<div/>", {"class":"panel panel-default"});

$(elem2).append(elem3);
$(elem1).append(elem2);
$(elem1).append(elem3);
$(elem1).append(elem4);