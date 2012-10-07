<?php
$page = "AdminProfileAddfield";
$category_main = 'global';
include "AdminHeader.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }
if(isset($_GET['o'])) { $o = $_GET['o']; } elseif(isset($_POST['o'])) { $o = $_POST['o']; } else { $o = "0"; }


// INITIALIZE ERROR VARS
$is_error = 0;
$error_message = "";


// CANCEL ADD FIELD
if($task == "cancel") {
  header("Location: AdminProfile.php?o=$o");
  exit();


// TRY TO ADD FIELD
} elseif($task == "addfield") {
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
  $field_birthday = $_POST['field_birthday'];
  $field_regex = $_POST['field_regex'];
  $field_html = $_POST['field_html'];
  $box1_display = "none";
  $box3_display = "none";
  $box4_display = "none";
  $box5_display = "none";
  $box6_display = "none";
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

  // CREATE TAB ARRAY
  $tabs = $database->database_query("SELECT tab_id, tab_name FROM phps_tabs ORDER BY tab_order");
  $num_tabs = $database->database_num_rows($tabs);
  $tab_count = 0;
  while($tab_info = $database->database_fetch_assoc($tabs)) {
    if($field_tab_id == $tab_info[tab_id]) { $selected = "1"; } else { $selected = "0"; }
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
      
      $select_label = $_POST[$var_label];
      $select_dependency = $_POST[$var_dependency];
      $select_dependent_label = $_POST[$var_dependent_label];

      
      
      if(str_replace(" ", "", $select_label) != "") {
        $select_options[$num_select_options] = Array('select_id' => $num_select_options,
			 			     'select_label' => $select_label,
						     'select_dependency' => $select_dependency,
						     'select_dependent_label' => $select_dependent_label);

        $options[$num_select_options] = Array('option_id' => $num_select_options,
			 		      'option_label' => $select_label,
					      'option_dependency' => $select_dependency,
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
					   'select_dependent_label' => ''));
      $is_error = 1;
      $error_message = $admin_profile_addfield[18];
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
      
      $radio_label = $_POST[$var_label];
      $radio_dependency = $_POST[$var_dependency];
      $radio_dependent_label = $_POST[$var_dependent_label];

      
      
      if(str_replace(" ", "", $radio_label) != "") {
        $radio_options[$num_radio_options] = Array('radio_id' => $num_radio_options,
			 			     'radio_label' => $radio_label,
						     'radio_dependency' => $radio_dependency,
						     'radio_dependent_label' => $radio_dependent_label);

        $options[$num_radio_options] = Array('option_id' => $num_radio_options,
			 		     'option_label' => $radio_label,
					     'option_dependency' => $radio_dependency,
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
					  'radio_dependent_label' => '')); 
      $is_error = 1;
      $error_message = $admin_profile_addfield[18];
    }


  // FIELD TYPE IS DATE FIELD
  } elseif($field_type == "5") {
    $box5_display = "block";
    $column_type = "int(14)";
    $column_default = "default '-2019787262'";


  // FIELD TYPE NOT SPECIFIED
  } else {
    $is_error = 1;
    $error_message = $admin_profile_addfield[26];
  }


  // FIELD TITLE IS EMPTY
  if(str_replace(" ", "", $field_title) == "") {
    $is_error = 1;
    $error_message = $admin_profile_addfield[28];
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


  // ADD FIELD IF NO ERROR
  if($is_error == 0) {
    $field_order_info = $database->database_fetch_assoc($database->database_query("SELECT max(field_order) as f_order FROM phps_fields WHERE field_dependency='0'"));
    $field_order = $field_order_info[f_order]+1;
    $database->database_query("INSERT INTO phps_fields (field_tab_id, field_title, field_desc, field_error, field_browsable, field_order, field_type, field_style, field_dependency, field_maxlength, field_link, field_signup, field_required, field_regex, field_birthday, field_html) VALUES ('$field_tab_id', '$field_title', '$field_desc', '$field_error', '$field_browsable', '$field_order', '$field_type', '$field_style', '0', '$field_maxlength', '$field_link', '1', '$field_required', '$field_regex', '$field_birthday', '$field_html')");
    $field_info = $database->database_fetch_assoc($database->database_query("SELECT field_id FROM phps_fields WHERE field_tab_id='$field_tab_id' AND field_title='$field_title' AND field_desc='$field_desc' AND field_error='$field_error' AND field_browsable='$field_browsable' AND field_order='$field_order' AND field_type='$field_type' AND field_style='$field_style' AND field_dependency='0' AND field_maxlength='$field_maxlength' AND field_link='$field_link' AND field_signup='1' AND field_required='$field_required' AND field_regex='$field_regex' AND field_birthday='$field_birthday' ORDER BY field_id DESC LIMIT 1"));
    $column_name = "profile_".$field_info[field_id];
    $database->database_query("ALTER TABLE phps_profiles ADD $column_name $column_type NOT NULL $column_default");

    // ADD DEPENDENT FIELDS
    $field_options = "";
    $num_dependent_fields = 1;
    for($d=0;$d<count($options);$d++) {
      $option = $options[$d];
      $option_label = str_replace("<~!~>", "", str_replace("<!>", "", $option[option_label]));
      $option_dependent_label = str_replace("<~!~>", "", str_replace("<!>", "", $option[option_dependent_label]));

      if($option[option_dependency] == "1") {
        $database->database_query("INSERT INTO phps_fields (field_tab_id, field_title, field_desc, field_browsable, field_order, field_type, field_style, field_dependency, field_maxlength, field_link, field_options, field_signup, field_required, field_regex) VALUES ('$field_tab_id', '$option_dependent_label', '', '', '$num_dependent_fields', '1', '', '$field_info[field_id]', '100', '', '', '0', '0', '')");
        $dep_field_info = $database->database_fetch_assoc($database->database_query("SELECT field_id FROM phps_fields WHERE field_tab_id='$field_tab_id' AND field_title='$option_dependent_label' AND field_desc='' AND field_browsable='' AND field_order='$num_dependent_fields' AND field_type='1' AND field_style='' AND field_dependency='$field_info[field_id]' AND field_maxlength='100' AND field_link='' AND field_options='' AND field_signup='0' AND field_regex='' AND field_required='0' ORDER BY field_id DESC LIMIT 1"));
        $column_name = "profile_".$dep_field_info[field_id];
        $database->database_query("ALTER TABLE phps_profiles ADD $column_name varchar(250) NOT NULL");
        $num_dependent_fields++;
      }
      $field_options .= "$option[option_id]<!>$option_label<!>$option[option_dependency]<!>$dep_field_info[field_id]<~!~>";
    }

    // INSERT OPTIONS
    $database->database_query("UPDATE phps_fields SET field_options='$field_options' WHERE field_id='$field_info[field_id]'");

    header("Location: AdminProfile.php?o=$o,$field_tab_id");
    exit();
  }


// ADD FIELD FORM
} else {
  $field_title = "";
  $field_tab_id = "";
  $field_type = "";
  $field_style = "";
  $field_desc = "";
  $field_error = "";
  $field_regex = "";
  $field_maxlength = "";
  $field_link = "";
  $field_html = "";
  $field_browsable = 2;
  $field_required = 0;
  $field_birthday = 0;
  $box1_display = "none";
  $box3_display = "none";
  $box4_display = "none";
  $box5_display = "none";
  $box6_display = "none";
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

  // GET TABS
  $tabs = $database->database_query("SELECT tab_id, tab_name FROM phps_tabs ORDER BY tab_order");
  $num_tabs = $database->database_num_rows($tabs);
  $tab_count = 0;
    
  // LOOP OVER TABS
  while($tab_info = $database->database_fetch_assoc($tabs)) {

    // SET TAB ARRAY AND INCREMENT TAB COUNT
    $tab_array[$tab_count] = Array('tab_id' => $tab_info[tab_id], 
				   'field_tab_id' => '',
				   'tab_name' => $tab_info[tab_name]);
    $tab_count++;
  } 
}



// ASSIGN VARIABLES AND SHOW ADD FIELD PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('tabs', $tab_array);
$smarty->assign('field_title', $field_title);
$smarty->assign('field_tab_id', $field_tab_id);
$smarty->assign('field_type', $field_type);
$smarty->assign('field_style', $field_style);
$smarty->assign('field_desc', $field_desc);
$smarty->assign('field_error', $field_error);
$smarty->assign('field_regex', $field_regex);
$smarty->assign('field_birthday', $field_birthday);
$smarty->assign('field_maxlength', $field_maxlength);
$smarty->assign('field_link', $field_link);
$smarty->assign('field_html', $field_html);
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