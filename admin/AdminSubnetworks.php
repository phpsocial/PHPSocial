<?php
$page = "AdminSubnetworks";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['s'])) { $s = $_POST['s']; } elseif(isset($_GET['s'])) { $s = $_GET['s']; } else { $s = "id"; }
if(isset($_POST['subnet_id'])) { $subnet_id = $_POST['subnet_id']; } elseif(isset($_GET['subnet_id'])) { $subnet_id = $_GET['subnet_id']; } else { $subnet_id = 0; }

// VALIDATE SUBNETWORK ID IF NECESSARY
if($task != "doupdate") {
  if($database->database_num_rows($database->database_query("SELECT subnet_id FROM phps_subnets WHERE subnet_id='$subnet_id'")) != 1) { $task = "main"; }
}



// SET RESULT VARIABLE
$result = "";





// UPDATE DIFFERENTIATION FIELDS
if($task == "doupdate") {
  $field1_id = $_POST['field1_id'];
  $field2_id = $_POST['field2_id'];

  if($field1_id == "") { $field1_id = -1; }
  if($field2_id == "") { $field2_id = -1; }

  $database->database_query("UPDATE phps_settings SET
			setting_subnet_field1_id='$field1_id',
			setting_subnet_field2_id='$field2_id'");

  $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM phps_settings LIMIT 1"));
  $result = $admin_subnetworks[17];






// DELETE SUBNETWORK
} elseif($task == "deletesubnet") {

  // DELETE SUBNETWORK AND MOVE ALL USERS TO DEFAULT SUBNETWORK
  $database->database_query("DELETE FROM phps_subnets WHERE subnet_id='$subnet_id'");
  $database->database_query("UPDATE phps_users SET user_subnet_id='0' WHERE user_subnet_id='$subnet_id'");
  $result = $admin_subnetworks[21];







// CONFIRM DELETION OF SUBNETWORK
} elseif($task == "confirm") {

  // SET HIDDEN INPUT ARRAYS FOR TWO TASKS
  $confirm_hidden = Array(Array('name' => 'task', 'value' => 'deletesubnet'),
			  Array('name' => 'subnet_id', 'value' => $subnet_id),
			  Array('name' => 's', 'value' => $s));
  $cancel_hidden = Array(Array('name' => 'task', 'value' => 'main'),
			 Array('name' => 's', 'value' => $s));

  // LOAD CONFIRM PAGE WITH APPROPRIATE VARIABLES
  $smarty->assign('confirm_form_action', 'AdminSubnetworks.php');
  $smarty->assign('cancel_form_action', 'AdminSubnetworks.php');
  $smarty->assign('confirm_hidden', $confirm_hidden);
  $smarty->assign('cancel_hidden', $cancel_hidden);
  $smarty->assign('headline', $admin_subnetworks[18]);
  $smarty->assign('instructions', $admin_subnetworks[19]);
  $smarty->assign('confirm_submit', $admin_subnetworks[18]);
  $smarty->assign('cancel_submit', $admin_subnetworks[20]);
  $smarty->display("AdminConfirm.tpl");
  exit();


}





// SET SUBNETWORK SORT-BY VARIABLES FOR HEADING LINKS
$i = "id";   // SUBNET_ID
$n = "n";    // SUBNET_NAME
$u = "ud";    // NUMBER OF USERS

// SET SORT VARIABLE FOR DATABASE QUERY
if($s == "i") {
  $sort = "subnet_id";
  $i = "id";
} elseif($s == "id") {
  $sort = "subnet_id DESC";
  $i = "i";
} elseif($s == "n") {
  $sort = "subnet_name";
  $n = "nd";
} elseif($s == "nd") {
  $sort = "subnet_name DESC";
  $n = "n";
} elseif($s == "u") {
  $sort = "users";
  $u = "ud";
} elseif($s == "ud") {
  $sort = "users DESC";
  $u = "u";
} else {
  $sort = "subnet_id DESC";
  $i = "i";
}








// GET NON DEPENDENT FIELDS
$fields = $database->database_query("SELECT field_id, field_title, field_signup, field_birthday FROM phps_fields WHERE field_dependency='0' ORDER BY field_order");
$num_fields = $database->database_num_rows($fields);
$field_count = 0;
$field_array = Array();
$primary_field_title = "";
$secondary_field_title = "";
    
// LOOP OVER NON DEPENDENT FIELDS
while($field_info = $database->database_fetch_assoc($fields)) {

  if($field_info[field_id] == $setting[setting_subnet_field1_id]) { 
    $primary_field_title = $field_info[field_title];
    $primary_field_birthday = $field_info[field_birthday];
  }
  if($field_info[field_id] == $setting[setting_subnet_field2_id]) { 
    $secondary_field_title = $field_info[field_title];
    $secondary_field_birthday = $field_info[field_birthday];
  }

  if($field_info[field_birthday] == 1) { $field_info[field_title] .= " $admin_subnetworks[23]"; }

  // SET FIELD ARRAY AND INCREMENT FIELD COUNT
  $field_array[$field_count] = Array('field_id' => $field_info[field_id], 
				     'field_title' => $field_info[field_title]);
  $field_count++;
} 


// GET PRIMARY AND SECONDARY FIELD INFO
$primary = $database->database_fetch_assoc($database->database_query("SELECT field_title, field_type, field_options, field_birthday FROM phps_fields WHERE field_id='$setting[setting_subnet_field1_id]'"));
$secondary = $database->database_fetch_assoc($database->database_query("SELECT field_title, field_type, field_options, field_birthday FROM phps_fields WHERE field_id='$setting[setting_subnet_field2_id]'"));


// IF EMAIL ADDRESS HAS BEEN SELECTED
if($setting[setting_subnet_field1_id] == "0") {
  $primary_field_title = $admin_subnetworks[16];
  $primary[field_type] = 1;
}
if($setting[setting_subnet_field2_id] == "0") {
  $secondary_field_title = $admin_subnetworks[16];
  $secondary[field_type] = 1;
}

// IF BIRTHDAY HAS BEEN SELECTED
if($primary[field_birthday] == 1) {
  $primary_field_title .= " $admin_subnetworks[23]";
  $primary[field_type] = 1;
}
if($secondary[field_birthday] == 1) {
  $secondary_field_title .= " $admin_subnetworks[23]";
  $secondary[field_type] = 1;
}





// GET SUBNETWORK ARRAY
$subnets = $database->database_query("SELECT phps_subnets.*, count(phps_users.user_id) AS users FROM phps_subnets LEFT JOIN phps_users ON phps_subnets.subnet_id=phps_users.user_subnet_id GROUP BY phps_subnets.subnet_id ORDER BY $sort");
$subnet_count = 0;
$subnet_array = Array();

// LOOP OVER SUBNETWORKS
while($subnet_info = $database->database_fetch_assoc($subnets)) {

  switch($primary[field_type]) {
    case "1":
    case "2":
      $subnet_field1_value = $subnet_info[subnet_field1_value];
      break;
    case "3":
    case "4":
      // LOOP OVER FIELD OPTIONS
      $option_value = "";
      $field_options = Array();
      $options = explode("<~!~>", $primary[field_options]);
      $num_options = 0;
      for($i=0,$max=count($options);$i<$max;$i++) {
        if(str_replace(" ", "", $options[$i]) != "") {
          $option = explode("<!>", $options[$i]);
          if($subnet_info[subnet_field1_value] == $option[0]) {
            $option_label = $option[1];
            $option_dependency = $option[2];
            $option_dependent_field_id = $option[3];
  
            // SET FIELD VALUE
            $subnet_field1_value = $option_label;
            break;
          }  
        }
      }
      break;
    case "5":
      $subnet_field1_value = $datetime->cdate($setting[setting_dateformat], $subnet_info[subnet_field1_value]);
      break;
  }

  // SET SECONDARY FIELD TITLE
  if($setting[setting_subnet_field2_id] == -1 | $subnet_info[subnet_field2_qual] == "" | $subnet_info[subnet_field2_value] == "") {
    $subnet_field2_title = "";
    $subnet_field2_qual = "";
    $subnet_field2_value = "";
  } else {
    $subnet_field2_title = $secondary_field_title;
    $subnet_field2_qual = $subnet_info[subnet_field2_qual];
    switch($secondary[field_type]) {
      case "1":
      case "2":
        $subnet_field2_value = $subnet_info[subnet_field2_value];
        break;
      case "3":
      case "4":
        // LOOP OVER FIELD OPTIONS
        $option_value = "";
        $field_options = Array();
        $options = explode("<~!~>", $secondary[field_options]);
        $num_options = 0;
        for($i=0,$max=count($options);$i<$max;$i++) {
          if(str_replace(" ", "", $options[$i]) != "") {
            $option = explode("<!>", $options[$i]);
            if($subnet_info[subnet_field2_value] == $option[0]) {
              $option_label = $option[1];
              $option_dependency = $option[2];
              $option_dependent_field_id = $option[3];
  
              // SET FIELD VALUE
              $subnet_field2_value = $option_label;
              break;
            }  
          }
        }
        break;
      case "5":
        $subnet_field2_value = $datetime->cdate($setting[setting_dateformat], $subnet_info[subnet_field2_value]);
        break;
    }
  }

  // SET SUBNET ARRAY AND INCREMENT SUBNET COUNT
  $subnet_array[$subnet_count] = Array('subnet_id' => $subnet_info[subnet_id],
				       'subnet_name' => $subnet_info[subnet_name],
				       'subnet_field1_title' => $primary_field_title,
				       'subnet_field1_qual' => $subnet_info[subnet_field1_qual],
				       'subnet_field1_value' => $subnet_field1_value,
				       'subnet_field2_title' => $subnet_field2_title,
				       'subnet_field2_qual' => $subnet_field2_qual,
				       'subnet_field2_value' => $subnet_field2_value,
				       'subnet_users' => $subnet_info[users]);
  $subnet_count++;
}





// SET NUMBER OF USERS IN DEFAULT SUBNETWORK
$default_users = $database->database_num_rows($database->database_query("SELECT user_id FROM phps_users WHERE user_subnet_id='0'"));




// ASSIGN VARIABLES AND SHOW SUBNETWORK PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('s', $s);
$smarty->assign('i', $i);
$smarty->assign('n', $n);
$smarty->assign('u', $u);
$smarty->assign('result', $result);
$smarty->assign('subnets', $subnet_array);
$smarty->assign('fields', $field_array);
$smarty->assign('default_users', $default_users);
$smarty->assign('primary_field_id', $setting[setting_subnet_field1_id]);
$smarty->assign('primary_field_title', $primary_field_title);
$smarty->assign('secondary_field_id', $setting[setting_subnet_field2_id]);
$smarty->assign('secondary_field_title', $secondary_field_title);
$smarty->display("$page.tpl");
exit();
?>