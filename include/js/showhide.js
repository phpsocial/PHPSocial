function showhide(id1) {
	if(document.getElementById(id1).style.display=='none') {
		document.getElementById(id1).style.display='block';
	} else {
		document.getElementById(id1).style.display='none';
	}
}

function showdiv(id1) {
	if(document.getElementById(id1))
	document.getElementById(id1).style.display='block';
}

function hidediv(id1) {
	if(document.getElementById(id1))
	document.getElementById(id1).style.display='none';
}

function ShowHideSelectDeps(field_id) {
  var elem = "field_"+field_id;
  var show = document.getElementById(elem).options[document.getElementById(elem).options.selectedIndex].value;
  var possible_options = document.getElementById(elem).options.length-1;
  for(x=0; x<possible_options; x++) {
    if(x != show | show == "") {
      hidediv(elem+"_option"+x);
    } else {
      showdiv(elem+"_option"+x);
    }
  }
}

function ShowHideRadioDeps(field_id, show, dep_field, total_options) {
  var elem = "field_"+field_id;
  for(x=0; x<total_options; x++) {
    if(x != show) {
      hidediv(elem+"_radio"+x);
    } else {
      showdiv(elem+"_radio"+x);
      if(document.getElementById(dep_field)) {
        document.getElementById(dep_field).focus()
	document.getElementById(dep_field).value = document.getElementById(dep_field).value;
      }
    }
  }
}

