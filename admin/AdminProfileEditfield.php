<?php
$page = "AdminProfileEditfield";
$category_main = 'global';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_GET['o'])) { $o = $_GET['o']; } elseif(isset($_POST['o'])) { $o = $_POST['o']; } else { $o = "0"; }
if(isset($_POST['field_id'])) { $field_id = $_POST['field_id']; } elseif(isset($_GET['field_id'])) { $field_id = $_GET['field_id']; } else { $field_id = 0; }

// VALIDATE FIELD ID AND GET FIELD INFO
$field = $database->database_query("SELECT * FROM phps_fields WHERE field_id='$field_id'");
if($database->database_num_rows($field) != 1) {
  header("Location: AdminProfile.php?o=$o");
  exit();
}
$field_info = $database->database_fetch_assoc($field);


// INITIALIZE ERROR VARS
$is_error = 0;
$error_message = "";



// CANCEL ADD FIELD
if($task == "cancel") {
  header("Location: AdminProfile.php?o=$o");
  exit();




// CONFIRM FIELD DELETION
} elseif($task == "confirmdeletefield") {

  // SET HIDDEN INPUT ARRAYS FOR TWO TASKS
  $confirm_hidden = Array(Array('name' => 'task', 'value' => 'deletefield'),
			  Array('name' => 'o', 'value' => $o),
			  Array('name' => 'field_id', 'value' => $field_info[field_id]));
  $cancel_hidden = Array(Array('name' => 'task', 'value' => 'main'),
			  Array('name' => 'o', 'value' => $o),
			  Array('name' => 'field_id', 'value' => $field_info[field_id]));

  // LOAD CONFIRM PAGE WITH APPROPRIATE VARIABLES
  $smarty->assign('confirm_form_action', 'AdminProfileEditfield.php');
  $smarty->assign('cancel_form_action', 'AdminProfileEditfield.php');
  $smarty->assign('confirm_hidden', $confirm_hidden);
  $smarty->assign('cancel_hidden', $cancel_hidden);
  $smarty->assign('headline', $admin_profile_editfield[35]);
  $smarty->assign('instructions', $admin_profile_editfield[36]);
  $smarty->assign('confirm_submit', $admin_profile_editfield[34]);
  $smarty->assign('cancel_submit', $admin_profile_editfield[24]);
  $smarty->display("AdminConfirm.tpl");
  exit();  





// DELETE FIELD
} elseif($task == "deletefield") {
  
  // DELETE ALL FIELD COLUMNS
  $fields = $database->database_query("SELECT field_id FROM phps_fields WHERE field_id='$field_info[field_id]' OR field_dependency='$field_info[field_id]'");
  while($field = $database->database_fetch_assoc($fields)) {
    $column = "profile_".$field[field_id];
    $database->database_query("ALTER TABLE phps_profiles DROP COLUMN $column");
  }

  // DELETE ALL FIELDS
  $database->database_query("DELETE FROM phps_fields WHERE field_id='$field_info[field_id]' OR field_dependency='$field_info[field_id]'");

  // RETURN TO ADMIN PROFILE
  header("Location: AdminProfile.php?o=$o");
  exit();








// TRY TO EDIT FIELD
} elseif($task == "editfield") {

  // GET ALL POSTED VARS AND RESET OTHER VARS
  $field_title = $_POST['field_title'];
  $field_tab_id = $_POST['field_tab_id'];
  $field_type = $_POST['field_type'];
  $field_style = $_POST['field_style'];
  $field_desc = $_POST['field_desc'];
  $field_error = $_POST['field_error'];
  $field_browsable = $_POST['field_browsable'];
  $field_required = $_POST['field_required'];
  $field_maxlength = $_POST['field_maxlength'];
  $field_link = $_POST['field_link'];
  $field_regex = $_POST['field_regex'];
  $field_html = $_POST['field_html'];
  $field_birthday = $_POST['field_birthday'];
  $box1_display = "none";
  $box3_display = "none";
  $box4_display = "none";
  $box5_display = "none";
  $box6_display = "none";
  $num_select_options = 1;
  $select_options = Array('0' => Array('select_id' => 0,
			 		'select_label' => '',
					'select_dependency' => '0',
					'select_dependent_field_id' => '',
					'select_dependent_label' => ''));
  $num_radio_options = 1;
  $radio_options = Array('0' => Array('radio_id' => 0,
					'radio_label' => '',
					'radio_dependency' => '0',
					'radio_dependent_field_id' => '',
					'radio_dependent_label' => ''));


  // CREATE TAB ARRAY
  $tabs = $database->database_query("SELECT tab_id, tab_name FROM phps_tabs ORDER BY tab_order");
  $num_tabs = $database->database_num_rows($tabs);
  $tab_count = 0;
  while($tab_info = $database->database_fetch_assoc($tabs)) {
    if($field_tab_id == $tab_info[tab_id]) { $selected = "1"; } else { $selected = ""; }
    $tab_array[$tab_count] = Array('tab_id' => $tab_info[tab_id], 
				   'field_tab_id' => $selected,
				   'tab_name' => $tab_info[tab_name]);
    $tab_count++;
  }   



  // FIELD TYPE IS TEXT FIELD
  if($field_type == "1") {
    $box1_display = "block";
    $box6_display = "block";
    $column_type = "varchar(250)";
    $column_default = "default ''";


  // FIELD TYPE IS TEXTAREA
  } elseif($field_type == "2") {
    $box6_display = "block";
    $column_type = "text";
    $column_default = "";


  // FIELD TYPE IS SELECT BOX
  } elseif($field_type == "3") {
    $box3_display = "block";
    $column_type = "int(2)";
    $column_default = "default '-1'";
    $select_options = Array();
    $old_num_select_options = $_POST['num_select_options'];
    $num_select_options = 0;
    // PULL OPTIONS INTO NEW ARRAY
    for($i=0;$i<$old_num_select_options;$i++) {
      $var_label = "select_label$i";
      $var_dependency = "select_dependency$i";
      $var_dependent_label = "select_dependent_label$i";
      $var_dependent_field_id = "select_dependent_field_id$i";
      
      $select_label = $_POST[$var_label];
      $select_dependency = $_POST[$var_dependency];
      $select_dependent_label = $_POST[$var_dependent_label];
      $select_dependent_field_id = $_POST[$var_dependent_field_id];
      
      
      if(str_replace(" ", "", $select_label) != "") {
        $select_options[$num_select_options] = Array('select_id' => $num_select_options,
			 			     'select_label' => $select_label,
						     'select_dependency' => $select_dependency,
						     'select_dependent_field_id' => $select_dependent_field_id,
						     'select_dependent_label' => $select_dependent_label);

        $options[$num_select_options] = Array('option_id' => $num_select_options,
			 		      'option_label' => $select_label,
					      'option_dependency' => $select_dependency,
					      'option_dependent_field_id' => $select_dependent_field_id,
					      'option_dependent_label' => $select_dependent_label);

        $num_select_options++;

      }
    }


    // IF NO OPTIONS HAVE BEEN SPECIFIED
    if($num_select_options == 0) {
      $num_select_options = 1;
      $select_options = Array('0' => Array('select_id' => 0,
			 		   'select_label' => '',
					   'select_dependency' => '0',
					   'select_dependent_field_id' => '',
					   'select_dependent_label' => ''));
      $is_error = 1;
      $error_message = $admin_profile_editfield[18];
    }



  // FIELD TYPE IS RADIO BUTTON
  } elseif($field_type == "4") {
    $box4_display = "block";
    $column_type = "int(2)";
    $column_default = "default '-1'";
    $radio_options = Array();
    $old_num_radio_options = $_POST['num_radio_options'];
    $num_radio_options = 0;
    // PULL OPTIONS INTO NEW ARRAY
    for($i=0;$i<$old_num_radio_options;$i++) {
      $var_label = "radio_label$i";
      $var_dependency = "radio_dependency$i";
      $var_dependent_label = "radio_dependent_label$i";
      $var_dependent_field_id = "radio_dependent_field_id$i";
      
      $radio_label = $_POST[$var_label];
      $radio_dependency = $_POST[$var_dependency];
      $radio_dependent_label = $_POST[$var_dependent_label];
      $radio_dependent_field_id = $_POST[$var_dependent_field_id];
      
      
      if(str_replace(" ", "", $radio_label) != "") {
        $radio_options[$num_radio_options] = Array('radio_id' => $num_radio_options,
			 			     'radio_label' => $radio_label,
						     'radio_dependency' => $radio_dependency,
						     'radio_dependent_field_id' => $radio_dependent_field_id,
						     'radio_dependent_label' => $radio_dependent_label);

        $options[$num_radio_options] = Array('option_id' => $num_radio_options,
			 		     'option_label' => $radio_label,
					     'option_dependency' => $radio_dependency,
					     'option_dependent_field_id' => $radio_dependent_field_id,
					     'option_dependent_label' => $radio_dependent_label);

        $num_radio_options++;

      }
    }

    // IF NO OPTIONS HAVE BEEN SPECIFIED
    if($num_radio_options == 0) {
      $num_radio_options = 1;
      $radio_options = Array('0' => Array('radio_id' => 0,
					  'radio_label' => '',
					  'radio_dependency' => '0',
					  'radio_dependent_field_id' => '',
					  'radio_dependent_label' => '')); 
      $is_error = 1;
      $error_message = $admin_profile_editfield[18];
    }


  // FIELD TYPE IS DATE FIELD
  } elseif($field_type == "5") {
    $box5_display = "block";
    $column_type = "int(14)";
    $column_default = "default '-2019787262'";


  // FIELD TYPE NOT SPECIFIED
  } else {
    $is_error = 1;
    $error_message = $admin_profile_editfield[26];
  }


  // FIELD TITLE IS EMPTY
  if(str_replace(" ", "", $field_title) == "") {
    $is_error = 1;
    $error_message = $admin_profile_editfield[28];
  }

  // ONLY GET HTML IF FIELD TYPE IS TEXT OR MULTILINE TEXT
  if($field_type == 1 OR $field_type == 2) {
    if($field_html != "") {
      $field_html = str_replace(" ", "", $field_html);
      $field_html = str_replace("&lt;", "", $field_html);
      $field_html = str_replace("&gt;", "", $field_html);
    }
  } else {
    $field_html = "";
  }

  // EDIT FIELD IF NO ERROR
  if($is_error == 0) {
    
    $database->database_query("UPDATE phps_fields SET field_tab_id='$field_tab_id', field_title='$field_title', field_desc='$field_desc', field_error='$field_error', field_browsable='$field_browsable', field_type='$field_type', field_style='$field_style', field_maxlength='$field_maxlength', field_link='$field_link', field_required='$field_required', field_regex='$field_regex', field_birthday='".(int)$field_birthday."', field_html='$field_html' WHERE field_id='$field_info[field_id]'");
        
    $column_name = "profile_".$field_info[field_id];
    $database->database_query("ALTER TABLE phps_profiles MODIFY $column_name $column_type NOT NULL $column_default");

    // EDIT DEPENDENT FIELDS
    $field_options = "";
    for($d=0;$d<count($options);$d++) {

      $option = $options[$d];
      $option_label = str_replace("<~!~>", "", str_replace("<!>", "", $option[option_label]));
      $option_dependent_label = str_replace("<~!~>", "", str_replace("<!>", "", $option[option_dependent_label]));
      $dep_field = $database->database_query("SELECT field_id, field_title FROM phps_fields WHERE field_id='$option[option_dependent_field_id]'");
      $dep_field_info_id = "";

      if($database->database_num_rows($dep_field) == "1") {
        $dep_field_info = $database->database_fetch_assoc($dep_field);
        if($option[option_dependency] == "1") {
          // MODIFY EXISTING DEPENDENT FIELD
          $dep_field_info_id = $dep_field_info[field_id];
          $database->database_query("UPDATE phps_fields SET field_tab_id='$field_tab_id', field_title='$option_dependent_label' WHERE field_id='$dep_field_info[field_id]'");
        } else {
          // DELETE DEPENDENT FIELD IF DEPENDENCY IS NO LONGER REQUIRED
          $database->database_query("DELETE FROM phps_fields WHERE field_id='$dep_field_info[field_id]'");
          $column_name = "profile_".$dep_field_info[field_id];
          $database->database_query("ALTER TABLE phps_profiles DROP COLUMN $column_name");
        }
      } else {
        if($option[option_dependency] == "1") {
          // ADD NEW DEPENDENT FIELD
          $dep_field_order = $database->database_num_rows($database->database_query("SELECT field_id FROM phps_fields WHERE field_dependency='$field_info[field_id]'"))+1;
          $database->database_query("INSERT INTO phps_fields (field_tab_id, field_title, field_desc, field_browsable, field_order, field_type, field_style, field_dependency, field_maxlength, field_link, field_options, field_signup, field_required, field_regex) VALUES ('$field_tab_id', '$option_dependent_label', '', '', '$dep_field_order', '1', '', '$field_info[field_id]', '100', '', '', '0', '0', '')");
          $dep_field_info = $database->database_fetch_assoc($database->database_query("SELECT field_id FROM phps_fields WHERE field_tab_id='$field_tab_id' AND field_title='$option_dependent_label' AND field_desc='' AND field_browsable='' AND field_order='$dep_field_order' AND field_type='1' AND field_style='' AND field_dependency='$field_info[field_id]' AND field_maxlength='100' AND field_link='' AND field_options='' AND field_signup='0' AND field_required='0' AND field_regex='' ORDER BY field_id DESC LIMIT 1"));
          $column_name = "profile_".$dep_field_info[field_id];
          $database->database_query("ALTER TABLE phps_profiles ADD $column_name varchar(250) NOT NULL");
          $dep_field_info_id = $dep_field_info[field_id];
        }
      }


      $field_options .= "$option[option_id]<!>$option_label<!>$option[option_dependency]<!>$dep_field_info_id<~!~>";
    }

    // INSERT OPTIONS
    $database->database_query("UPDATE phps_fields SET field_options='$field_options' WHERE field_id='$field_info[field_id]'");

    header("Location: AdminProfile.php?o=$o");
    exit();
  }






// EDIT FIELD FORM
} else {
  $field_title = $field_info[field_title];
  $field_tab_id = $field_info[field_tab_id];
  $field_type = $field_info[field_type];
  $field_style = $field_info[field_style];
  $field_desc = $field_info[field_desc];
  $field_error = $field_info[field_error];
  $field_maxlength = $field_info[field_maxlength];
  $field_link = $field_info[field_link];
  $field_regex = $field_info[field_regex];
  $field_html = $field_info[field_html];
  $field_browsable = $field_info[field_browsable];
  $field_required = $field_info[field_required];
  $field_birthday = $field_info[field_birthday];
  $field_options = $field_info[field_options];

  $num_select_options = 1;
  $select_options = Array('0' => Array('select_id' => 0,
			 		'select_label' => '',
					'select_dependency' => '0',
					'select_dependent_label' => ''));
  $num_radio_options = 1;
  $radio_options = Array('0' => Array('radio_id' => 0,
					'radio_label' => '',
					'radio_dependency' => '0',
					'radio_dependent_label' => ''));

  $box1_display = "none";
  $box3_display = "none";
  $box4_display = "none";
  $box5_display = "none";
  $box6_display = "none";
  if($field_type == "1") {
    $box1_display = "block";
    $box6_display = "block";
  } elseif($field_type == "2") {
    $box6_display = "block";
  } elseif($field_type == "3") {
    $box3_display = "block";
    // PULL OPTIONS INTO NEW ARRAY    
    $field_options = explode("<~!~>", $field_options);
    $num_select_options = 0;
    for($i=0;$i<count($field_options);$i++) {
      if(str_replace(" ", "", $field_options[$i]) != "") {
        $options = explode("<!>", $field_options[$i]);
        $select_id = $options[0];
        $select_label = $options[1];
        $select_dependency = $options[2];
        $select_dependent_field_id = $options[3];
        $select_dependent_label = "";
        if($select_dependency == "1") { 
          $dep_field = $database->database_query("SELECT field_id, field_title FROM phps_fields WHERE field_id='$select_dependent_field_id'");
          if($database->database_num_rows($dep_field) != "1") {
            $select_dependency = "0";
          } else {
            $select_dependency = "1";
            $dep_field_info = $database->database_fetch_assoc($dep_field);
            $select_dependent_label = $dep_field_info[field_title];
          }
        } else { 
          $select_dependency_0 = " SELECTED"; 
        }
        $select_options[$num_select_options] = Array('select_id' => $select_id,
			 			     'select_label' => $select_label,
						     'select_dependency' => $select_dependency,
						     'select_dependent_field_id' => $select_dependent_field_id,
						     'select_dependent_label' => $select_dependent_label);
        $num_select_options++;
      }
    }

    // IF NO OPTIONS HAVE BEEN SPECIFIED
    if($num_select_options == 0) {
      $num_select_options = 1;
      $select_options = Array('0' => Array('select_id' => 0,
			 		   'select_label' => '',
					   'select_dependency' => '0',
					   'select_dependent_field_id' => '',
					   'select_dependent_label' => ''));
    }

  } elseif($field_type == "4") {
    $box4_display = "block";
    // PULL OPTIONS INTO NEW ARRAY    
    $field_options = explode("<~!~>", $field_options);
    $num_radio_options = 0;
    for($i=0;$i<count($field_options);$i++) {
      if(str_replace(" ", "", $field_options[$i]) != "") {
        $options = explode("<!>", $field_options[$i]);
        $radio_id = $options[0];
        $radio_label = $options[1];
        $radio_dependency = $options[2];
        $radio_dependent_field_id = $options[3];
        $radio_dependent_label = "";
        if($radio_dependency == "1") { 
          $dep_field = $database->database_query("SELECT field_id, field_title FROM phps_fields WHERE field_id='$radio_dependent_field_id'");
          if($database->database_num_rows($dep_field) != "1") {
            $radio_dependency = "0";
          } else {
            $radio_dependency = "1";
            $dep_field_info = $database->database_fetch_assoc($dep_field);
            $radio_dependent_label = $dep_field_info[field_title];
          }
        } else { 
          $radio_dependency_0 = " SELECTED"; 
        }
        $radio_options[$num_radio_options] = Array('radio_id' => $radio_id,
			 			     'radio_label' => $radio_label,
						     'radio_dependency' => $radio_dependency,
						     'radio_dependent_field_id' => $radio_dependent_field_id,
						     'radio_dependent_label' => $radio_dependent_label);
        $num_radio_options++;
      }
    }

    // IF NO OPTIONS HAVE BEEN SPECIFIED
    if($num_radio_options == 0) {
      $num_radio_options = 1;
      $radio_options = Array('0' => Array('radio_id' => 0,
			 		  'radio_label' => '',
					  'radio_dependency' => '0',
					  'radio_dependent_field_id' => '',
					  'radio_dependent_label' => ''));
    }
  } elseif($field_type == "5") {
    $box5_display = "block";
  }
  

  // GET TABS
  $tabs = $database->database_query("SELECT tab_id, tab_name FROM phps_tabs ORDER BY tab_order");
  $num_tabs = $database->database_num_rows($tabs);
  $tab_count = 0;
    
  // LOOP OVER TABS
  while($tab_info = $database->database_fetch_assoc($tabs)) {
    // SET TAB ARRAY AND INCREMENT TAB COUNT
    if($field_tab_id == $tab_info[tab_id]) { $selected = "1"; } else { $selected = ""; }
    $tab_array[$tab_count] = Array('tab_id' => $tab_info[tab_id], 
				   'field_tab_id' => $selected,
				   'tab_name' => $tab_info[tab_name]);
    $tab_count++;
  } 
}



// ASSIGN VARIABLES AND SHOW ADD FIELD PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('field_id', $field_info[field_id]);
$smarty->assign('tabs', $tab_array);
$smarty->assign('field_title', $field_title);
$smarty->assign('field_tab_id', $field_tab_id);
$smarty->assign('field_type', $field_type);
$smarty->assign('field_style', $field_style);
$smarty->assign('field_desc', $field_desc);
$smarty->assign('field_error', $field_error);
$smarty->assign('field_regex', $field_regex);
$smarty->assign('field_html', $field_html);
$smarty->assign('field_maxlength', $field_maxlength);
$smarty->assign('field_link', $field_link);
$smarty->assign('field_birthday', $field_birthday);
$smarty->assign('num_select_options', $num_select_options);
$smarty->assign('select_options', $select_options);
$smarty->assign('num_radio_options', $num_radio_options);
$smarty->assign('radio_options', $radio_options);
$smarty->assign('box1_display', $box1_display);
$smarty->assign('box3_display', $box3_display);
$smarty->assign('box4_display', $box4_display);
$smarty->assign('box5_display', $box5_display);
$smarty->assign('box6_display', $box6_display);
$smarty->assign('field_browsable', $field_browsable);
$smarty->assign('field_required', $field_required);
$smarty->assign('o', $o);
$smarty->display("$page.tpl");
exit();
?>