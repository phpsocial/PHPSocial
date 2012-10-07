<?php
$page = "AdminProfile";
$category_main = 'global';
include "AdminHeader.php";

if(isset($_GET['o'])) { $o = $_GET['o']; $o_url = $o; $open = explode(",", trim($o)); } else { $open = Array("0"); }

// SET TAB VARIABLES
$all = "0";
$tab_count = 0;
$tab_array = Array();
$tabs = $database->database_query("SELECT * FROM phps_tabs ORDER BY tab_order");

// FIND NUMBER OF TABS
$num_tabs = $database->database_num_rows($tabs);

// LOOP THROUGH TABS
while($tab_info = $database->database_fetch_assoc($tabs)) {

  // PULL ALL TAB IDS INTO A STRING
  $all .= ",".$tab_info[tab_id];

  // SET FIELD ARRAY VAR
  $field_array = Array();

  // FIND TAB STATUS (OPEN OR CLOSED), SET FIELDS AND SET NEW TAB_O
 
    // TAB IS OPEN
    $tab_status = "open";
    $new_open = "";
    $a = 0;
    for($c=0;$c<count($open);$c++) {
      if($open[$c] != $tab_info[tab_id]) {
        $new_open[$a] = $open[$c];
        $a = $a+1;
      }
    }
    $tab_o = implode(",", $new_open);
    
    // GET NON DEPENDENT FIELDS IN TAB
    $fields = $database->database_query("SELECT field_id, field_title, field_birthday, field_options FROM phps_fields WHERE field_tab_id='$tab_info[tab_id]' AND field_dependency='0' ORDER BY field_order");
    $num_fields = $database->database_num_rows($fields);
    $field_count = 0;
    
    // LOOP OVER NON DEPENDENT FIELDS IN TAB
    while($field_info = $database->database_fetch_assoc($fields)) {

      // SET DEPENDENT FIELD ARRAY VAR
      $dep_field_array = Array();

      // GET DEPENDENT FIELDS FOR ORIGINAL FIELD
      $dep_fields = $database->database_query("SELECT field_id, field_title FROM phps_fields WHERE field_tab_id='$tab_info[tab_id]' AND field_dependency='$field_info[field_id]' ORDER BY field_order");
      $num_dep_fields = $database->database_num_rows($dep_fields);
      $dep_field_count = 0;

      // GET FIELD OPTIONS INTO ARRAY
      $options = explode("<~!~>", $field_info[field_options]);
      $field_options = Array();
      foreach($options as $key=>$value) {
          $options[$key]=explode("<!>", $value);
	if($options[$key][2] != 0 & $options[$key][3] != "") {
          $field_options[$options[$key][3]] = $options[$key][1];
        }
      }

      // LOOP OVER DEPENDENT FIELDS
      while($dep_field_info = $database->database_fetch_assoc($dep_fields)) {

        // SET DEPENDENT FIELD VARS
        if($dep_field_count+1 == $num_dep_fields) {
          $dep_field_order = "_last";
        } else {
          $dep_field_order = "";
        }

        // SET DEPENDENT FIELD ARRAY AND INCREMENT DEPENDENT FIELD COUNT
        $dep_field_array[$dep_field_count] = Array('dep_field_id' => $dep_field_info[field_id], 
						   'option_label' => $field_options[$dep_field_info[field_id]],
						   'dep_field_title' => $dep_field_info[field_title], 
						   'dep_field_order' => $dep_field_order);
        $dep_field_count++;
      } 
    



      // SET FIELD VARS
      if($field_count+1 == $num_fields) {
        $field_order = "_last";
      } else {
        $field_order = "";
      }

      // SET FIELD ARRAY AND INCREMENT FIELD COUNT
      $field_array[$field_count] = Array('field_id' => $field_info[field_id], 
					 'field_title' => $field_info[field_title], 
					 'field_order' => $field_order,
					 'field_birthday' => $field_info[field_birthday],
					 'dep_fields' => $dep_field_array);
      $field_count++;
    } 




  // SET TAB VARS
  if($tab_count+1 == $num_tabs) {
    $tab_order = "_last";
  } else {
    $tab_order = "";
  }


  // SET TAB ARRAY AND INCREMENT TAB COUNT
  $tab_array[$tab_count] = Array('tab_id' => $tab_info[tab_id], 
				 'tab_name' => $tab_info[tab_name], 
				 'tab_o' => $tab_o, 
				 'tab_status' => $tab_status,
				 'tab_order' => $tab_order,
				 'tab_fields' => $field_array);
  $tab_count++;
}








// ASSIGN VARIABLES AND SHOW ADMIN PROFILE PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('o_url', $o_url);
$smarty->assign('all', $all);
$smarty->assign('num_tabs', $num_tabs);
$smarty->assign('tabs', $tab_array);
$smarty->display("$page.tpl");
exit();
?>