function suggest(fieldname, divname, items) {
  var keyword_raw = document.getElementById(fieldname).value;
  var keyword = keyword_raw.toLowerCase();
  var resultCount = 0;
  if(keyword != "") {
    var x;
    var suggestions = "";
    var usernames = items.split(",");
    for(x in usernames) {
      var username = usernames[x].toLowerCase();
      if(username.indexOf(keyword) != -1) {
	var matchString = new RegExp("("+keyword+")", "i");
        var username_label = usernames[x].replace(matchString, "<b>$1</b>");
        suggestions = suggestions + "<div class='suggest_item'><a class='suggest' href=\"javascript:insertTo('" + fieldname + "', '" + divname + "', '" + usernames[x] + "')\">" + username_label + "</a></div>";
	resultCount++;
      }
    }
  }
  if(resultCount > 0) {
    document.getElementById(divname).innerHTML = suggestions;
    document.getElementById(divname).style.display = "block";
  } else {
    document.getElementById(divname).innerHTML = "";
    document.getElementById(divname).style.display = "none";
  }
}
function insertTo(fieldname, divname, stringToInsert) {
    document.getElementById(fieldname).value = stringToInsert;
    document.getElementById(divname).style.display = "none";
}