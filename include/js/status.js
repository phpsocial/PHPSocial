function changeStatus() {
  document.getElementById('ajax_currentstatus_none').style.display='none';
  document.getElementById('ajax_currentstatus').style.display='none';
  document.getElementById('ajax_changestatus').style.display='block';
  document.getElementById('status_new').select();
  document.getElementById('status_new').focus();
}

function changeStatus_return() {
  document.getElementById('ajax_changestatus').style.display='none';
  document.getElementById('status_new').value = document.getElementById('ajax_currentstatus_value').innerHTML;
  if(document.getElementById('status_new').value=='') {
    document.getElementById('ajax_currentstatus_none').style.display='block';
    document.getElementById('ajax_currentstatus').style.display='none';
  } else {
    document.getElementById('ajax_currentstatus_none').style.display='none';
    document.getElementById('ajax_currentstatus').style.display='block';
  }
}

function changeStatus_submit() {
  document.getElementById('ajax_statusform').submit();
  changeStatus_do();
}

function changeStatus_do() {
  var newValue = document.getElementById('status_new').value;
  newValue = newValue.replace(/</g, "&lt;");
  newValue = newValue.replace(/>/g, "&gt;");
  newValue = newValue.replace(/(\S{12,}?)/g, "$1<br>");
  document.getElementById('ajax_currentstatus_value').innerHTML=newValue;
  changeStatus_return();
}

