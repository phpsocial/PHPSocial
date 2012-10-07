<?php
$page = "AdminSubnetworksEdit";
$category_main = 'network';
include "AdminHeader.php";

if(isset($_POST['s'])) { $s = $_POST['s']; } elseif(isset($_GET['s'])) { $s = $_GET['s']; } else { $s = "id"; }
if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['subnet_id'])) { $subnet_id = $_POST['subnet_id']; } elseif(isset($_GET['subnet_id'])) { $subnet_id = $_GET['subnet_id']; } else { $subnet_id = 0; }

// VALIDATE SUBNETWORK ID
$subnets = $database->database_query("SELECT * FROM phps_subnets WHERE subnet_id='$subnet_id'");
if($database->database_num_rows($subnets) != 1) {
  header("Location: AdminSubnetworks.php?s=$s");
  exit();
}

// RETRIEVE SUBNETWORK INFORMATION
$subnet = $database->database_fetch_assoc($subnets);
$subnet_name = $subnet[subnet_name];
$subnet_field1_qual = $subnet[subnet_field1_qual];
$subnet_field1_value = $subnet[subnet_field1_value];
$subnet_field2_qual = $subnet[subnet_field2_qual];
$subnet_field2_value = $subnet[subnet_field2_value];



// INITIALIZE ERROR VARS
$is_error = 0;
$error_message = "";

// GET PRIMARY AND SECONDARY FIELD TITLES
$primary = $database->database_fetch_assoc($database->database_query("SELECT field_title, field_type, field_options, field_birthday FROM phps_fields WHERE field_id='$setting[setting_subnet_field1_id]'"));
$secondary = $database->database_fetch_assoc($database->database_query("SELECT field_title, field_type, field_options, field_birthday FROM phps_fields WHERE field_id='$setting[setting_subnet_field2_id]'"));

// IF EMAIL DOMAIN SELECTED
if($setting[setting_subnet_field1_id] == "0") {
  $primary['field_title'] = $Admin[837];
  $primary[field_type] = 1;
}
if($setting[setting_subnet_field2_id] == "0") {
  $secondary['field_title'] = $Admin[837];
  $secondary[field_type] = 1;
}

// CHECK FOR AGE
if($primary[field_birthday] == 1) {
  $primary[field_title] .= " $Admin[838]";
  $primary[field_type] = 1;
}
if($secondary[field_birthday] == 1) {
  $secondary[field_title] .= " $Admin[838]";
  $secondary[field_type] = 1;
}


// TRY TO EDIT SUBNETWORK
if($task == "doedit") {
  $subnet_name = $_POST['subnet_name'];
  $subnet_field1_qual = htmlspecialchars_decode($_POST['subnet_field1_qual'], ENT_QUOTES);
  $subnet_field1_value = $_POST['subnet_field1_value'];
  $subnet_field2_qual = htmlspecialchars_decode($_POST['subnet_field2_qual'], ENT_QUOTES);
  $subnet_field2_value = $_POST['subnet_field2_value'];

  // ENSURE DATES ARE IN APPROPRIATE ORDER
  if($primary[field_type] == 5) {
    // SET MONTH, DAY, AND YEAR FORMAT FROM SETTINGS
    switch($setting[setting_dateformat]) {
      case "n/j/Y":
      case "n.j.Y":
      case "n-j-Y":
        $month_format = "n";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "mdy";
        break;
      case "Y/n/j":
      case "Ynj":
        $month_format = "n";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "ymd";
        break;
      case "Y-n-d":
        $month_format = "n";
        $day_format = "d";
        $year_format = "Y";
        $date_order = "ymd";
        break;
      case "Y-m-d":
        $month_format = "m";
        $day_format = "d";
        $year_format = "Y";
        $date_order = "ymd";
        break;
      case "j/n/Y":
      case "j.n.Y":
        $month_format = "n";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "dmy";
        break;
      case "M. j, Y":
        $month_format = "M";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "mdy";
        break;
      case "F j, Y":
      case "l, F j, Y":
        $month_format = "F";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "mdy";
        break;
      case "j F Y":
      case "D j F Y":
      case "l j F Y":
        $month_format = "F";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "dmy";
        break;
      case "D-j-M-Y":
      case "D j M Y":
      case "j-M-Y":
        $month_format = "M";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "dmy";
        break;
      case "Y-M-j":
        $month_format = "M";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "ymd";
        break;
    }  

    // RETRIEVE POSTED FIELD VALUE
    $profile_var1 = "subnet_field1_value_1";
    $profile_var2 = "subnet_field1_value_2";
    $profile_var3 = "subnet_field1_value_3";
    $field_1 = $_POST[$profile_var1];
    $field_2 = $_POST[$profile_var2];
    $field_3 = $_POST[$profile_var3];

    // ORDER DATE VALUES PROPERLY
    switch($date_order) {
      case "mdy":
        $month = $field_1;
        $day = $field_2;
        $year = $field_3;
        break;
      case "ymd":
        $year = $field_1;
        $month = $field_2;
        $day = $field_3;
        break;
      case "dmy":
        $day = $field_1;
        $month = $field_2;
        $year = $field_3;
        break;
    }

    // SET ALL TO BLANK IF ONE FIELD BLANK
    if($month == 0 | $day == 0 | $year == 0) {
      $month = 0;
      $day = 0;
      $year = 0;
    }

    // CONSTRUCT TIMESTAMP FROM MONTH, DAY, YEAR
    $subnet_field1_value = $datetime->MakeTime("0", "0", "0", "$month", "$day", "$year");
  }




  // ENSURE DATES ARE IN APPROPRIATE ORDER
  if($secondary[field_type] == 5) {
    // SET MONTH, DAY, AND YEAR FORMAT FROM SETTINGS
    switch($setting[setting_dateformat]) {
      case "n/j/Y":
      case "n.j.Y":
      case "n-j-Y":
        $month_format = "n";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "mdy";
        break;
      case "Y/n/j":
      case "Ynj":
        $month_format = "n";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "ymd";
        break;
      case "Y-n-d":
        $month_format = "n";
        $day_format = "d";
        $year_format = "Y";
        $date_order = "ymd";
        break;
      case "Y-m-d":
        $month_format = "m";
        $day_format = "d";
        $year_format = "Y";
        $date_order = "ymd";
        break;
      case "j/n/Y":
      case "j.n.Y":
        $month_format = "n";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "dmy";
        break;
      case "M. j, Y":
        $month_format = "M";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "mdy";
        break;
      case "F j, Y":
      case "l, F j, Y":
        $month_format = "F";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "mdy";
        break;
      case "j F Y":
      case "D j F Y":
      case "l j F Y":
        $month_format = "F";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "dmy";
        break;
      case "D-j-M-Y":
      case "D j M Y":
      case "j-M-Y":
        $month_format = "M";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "dmy";
        break;
      case "Y-M-j":
        $month_format = "M";
        $day_format = "j";
        $year_format = "Y";
        $date_order = "ymd";
        break;
    }  

    // RETRIEVE POSTED FIELD VALUE
    $profile_var1 = "subnet_field2_value_1";
    $profile_var2 = "subnet_field2_value_2";
    $profile_var3 = "subnet_field2_value_3";
    $field_1 = $_POST[$profile_var1];
    $field_2 = $_POST[$profile_var2];
    $field_3 = $_POST[$profile_var3];

    // ORDER DATE VALUES PROPERLY
    switch($date_order) {
      case "mdy":
        $month = $field_1;
        $day = $field_2;
        $year = $field_3;
        break;
      case "ymd":
        $year = $field_1;
        $month = $field_2;
        $day = $field_3;
        break;
      case "dmy":
        $day = $field_1;
        $month = $field_2;
        $year = $field_3;
        break;
    }

    // SET ALL TO BLANK IF ONE FIELD BLANK
    if($month == 0 | $day == 0 | $year == 0) {
      $month = 0;
      $day = 0;
      $year = 0;
    }

    // CONSTRUCT TIMESTAMP FROM MONTH, DAY, YEAR
    $subnet_field2_value = $datetime->MakeTime("0", "0", "0", "$month", "$day", "$year");
  }

  if(str_replace(" ", "", $subnet_name) == "") {
    $is_error = 1;
    $error_message = $Admin[835];

  } elseif($subnet_field1_qual == "" | str_replace(" ", "", $subnet_field1_value) == "" | ($primary[field_type] == 5 & $subnet_field1_value == $datetime->MakeTime("0", "0", "0", "0", "0", "0"))) {
    $is_error = 1;
    $error_message = $Admin[834];

  } elseif(($subnet_field2_qual != "" | str_replace(" ", "", $subnet_field2_value) != "") & ($subnet_field2_qual == "" | str_replace(" ", "", $subnet_field2_value) == "" | ($secondary[field_type] == 5 & $subnet_field2_value == $datetime->MakeTime("0", "0", "0", "0", "0", "0")))) {
    $is_error = 1;
    $error_message = $Admin[836];

  // NO ERROR, UPDATE SUBNETWORK
  } else {
    $database->database_query("UPDATE phps_subnets SET subnet_name='$subnet_name', subnet_field1_qual='$subnet_field1_qual', subnet_field1_value='$subnet_field1_value', subnet_field2_qual='$subnet_field2_qual', subnet_field2_value='$subnet_field2_value' WHERE subnet_id='$subnet[subnet_id]'");
    header("Location: AdminSubnetworks.php?s=$s");
    exit();
  }



}





if($primary[field_type] == 3 | $primary[field_type] == 4) {

  // LOOP OVER FIELD OPTIONS
  $field_options = Array();
  $options = explode("<~!~>", $primary[field_options]);
  $num_options = 0;
  for($i=0,$max=count($options);$i<$max;$i++) {
    $dep_field_info = "";
    $option_dependency = 0;
    $dep_field_value = "";
    if(str_replace(" ", "", $options[$i]) != "") {
      $option = explode("<!>", $options[$i]);
      $option_id = $option[0];
      $option_label = $option[1];
      $option_dependency = $option[2];
      $option_dependent_field_id = $option[3];
          
      // GET VALUE OF FIELD
      $option_value = "";
      if($subnet_field1_value == $option_id) { $option_value = " SELECTED"; }
          
      // SET OPTIONS ARRAY
      $field_options[$num_options] = Array('option_id' => $option_id,
					   'option_label' => $option_label,
					   'option_value' => $option_value);
      $num_options++;
    }
  }



// DATE FIELD
} elseif($primary[field_type] == 5) {

  // SET MONTH, DAY, AND YEAR FORMAT FROM SETTINGS
  switch($setting[setting_dateformat]) {
    case "n/j/Y":
    case "n.j.Y":
    case "n-j-Y":
      $month_format = "n";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "mdy";
      break;
    case "Y/n/j":
    case "Ynj":
      $month_format = "n";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "ymd";
      break;
    case "Y-n-d":
      $month_format = "n";
      $day_format = "d";
      $year_format = "Y";
      $date_order = "ymd";
      break;
    case "Y-m-d":
      $month_format = "m";
      $day_format = "d";
      $year_format = "Y";
      $date_order = "ymd";
      break;
    case "j/n/Y":
    case "j.n.Y":
      $month_format = "n";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "dmy";
      break;
    case "M. j, Y":
      $month_format = "M";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "mdy";
      break;
    case "F j, Y":
    case "l, F j, Y":
      $month_format = "F";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "mdy";
      break;
    case "j F Y":
    case "D j F Y":
    case "l j F Y":
      $month_format = "F";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "dmy";
      break;
    case "D-j-M-Y":
    case "D j M Y":
    case "j-M-Y":
      $month_format = "M";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "dmy";
      break;
    case "Y-M-j":
      $month_format = "M";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "ymd";
      break;
  }  


  // DECONSTRUCT TIMESTAMP INTO DATE MONTH, DAY, AND YEAR
  if($subnet_field1_value != $datetime->MakeTime("0", "0", "0", "0", "0", "0") & $subnet_field1_value != "") {
    $field_date = $datetime->MakeDate($subnet_field1_value);
    $field_month = $field_date[0];
    $field_day = $field_date[1];
    $field_year = $field_date[2];
  } else {
    $field_month = 0;
    $field_day = 0;
    $field_year = 0;
  }

  // CONSTRUCT MONTH ARRAY
  $month_array = Array();
  $month_array[0] = Array('name' => "[MONTH]", 'value' => "0", 'selected' => "");
  for($m=1;$m<=12;$m++) {
    if($field_month == $m) { $selected = " SELECTED"; } else { $selected = ""; }
    $month_array[$m] = Array('name' => $datetime->cdate("$month_format", mktime(0, 0, 0, $m, 1, 1990)),
				'value' => $m,
				'selected' => $selected);
  }

  // CONSTRUCT DAY ARRAY
  $day_array = Array();
  $day_array[0] = Array('name' => "[DAY]", 'value' => "0", 'selected' => "");
  for($d=1;$d<=31;$d++) {
    if($field_day == $d) { $selected = " SELECTED"; } else { $selected = ""; }
    $day_array[$d] = Array('name' => $datetime->cdate("$day_format", mktime(0, 0, 0, 1, $d, 1990)),
				'value' => $d,
				'selected' => $selected);
  }

  // CONSTRUCT YEAR ARRAY
  $year_array = Array();
  $year_count = 1;
  $current_year = $datetime->cdate("Y", time());
  $year_array[0] = Array('name' => "[YEAR]", 'value' => "0", 'selected' => "");
  for($y=$current_year;$y>=1920;$y--) {
    if($field_year == $y) { $selected = " SELECTED"; } else { $selected = ""; }
    $year_array[$year_count] = Array('name' => $y,
					'value' => $y,
					'selected' => $selected);
    $year_count++;
  }

  // ORDER DATE ARRAYS PROPERLY
  switch($date_order) {
    case "mdy":
      $date_array1 = $month_array;
      $date_array2 = $day_array;
      $date_array3 = $year_array;
      break;
    case "ymd":
      $date_array1 = $year_array;
      $date_array2 = $month_array;
      $date_array3 = $day_array;
      break;
    case "dmy":
      $date_array1 = $day_array;
      $date_array2 = $month_array;
      $date_array3 = $year_array;
      break;
  }
    

}

// SET FIELD ARRAY AND INCREMENT FIELD COUNT
$primary_field = Array('field_type' => $primary[field_type],
				'field_options' => $field_options,
				'field_value' => $subnet_field1_value,
				'date_array1' => $date_array1,
				'date_array2' => $date_array2,
				'date_array3' => $date_array3);






if($secondary[field_type] == 3 | $secondary[field_type] == 4) {

  // LOOP OVER FIELD OPTIONS
  $field_options = Array();
  $options = explode("<~!~>", $secondary[field_options]);
  $num_options = 0;
  for($i=0,$max=count($options);$i<$max;$i++) {
    $dep_field_info = "";
    $option_dependency = 0;
    $dep_field_value = "";
    if(str_replace(" ", "", $options[$i]) != "") {
      $option = explode("<!>", $options[$i]);
      $option_id = $option[0];
      $option_label = $option[1];
      $option_dependency = $option[2];
      $option_dependent_field_id = $option[3];
          
      // GET VALUE OF FIELD
      $option_value = "";
      if($subnet_field2_value == $option_id) { $option_value = " SELECTED"; }
          
      // SET OPTIONS ARRAY
      $field_options[$num_options] = Array('option_id' => $option_id,
					   'option_label' => $option_label,
					   'option_value' => $option_value);
      $num_options++;
    }
  }



// DATE FIELD
} elseif($secondary[field_type] == 5) {

  // SET MONTH, DAY, AND YEAR FORMAT FROM SETTINGS
  switch($setting[setting_dateformat]) {
    case "n/j/Y":
    case "n.j.Y":
    case "n-j-Y":
      $month_format = "n";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "mdy";
      break;
    case "Y/n/j":
    case "Ynj":
      $month_format = "n";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "ymd";
      break;
    case "Y-n-d":
      $month_format = "n";
      $day_format = "d";
      $year_format = "Y";
      $date_order = "ymd";
      break;
    case "Y-m-d":
      $month_format = "m";
      $day_format = "d";
      $year_format = "Y";
      $date_order = "ymd";
      break;
    case "j/n/Y":
    case "j.n.Y":
      $month_format = "n";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "dmy";
      break;
    case "M. j, Y":
      $month_format = "M";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "mdy";
      break;
    case "F j, Y":
    case "l, F j, Y":
      $month_format = "F";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "mdy";
      break;
    case "j F Y":
    case "D j F Y":
    case "l j F Y":
      $month_format = "F";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "dmy";
      break;
    case "D-j-M-Y":
    case "D j M Y":
    case "j-M-Y":
      $month_format = "M";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "dmy";
      break;
    case "Y-M-j":
      $month_format = "M";
      $day_format = "j";
      $year_format = "Y";
      $date_order = "ymd";
      break;
  }  


  // DECONSTRUCT TIMESTAMP INTO DATE MONTH, DAY, AND YEAR
  if($subnet_field2_value != $datetime->MakeTime("0", "0", "0", "0", "0", "0") & $subnet_field2_value != "") {
    $field_date = $datetime->MakeDate($subnet_field2_value);
    $field_month = $field_date[0];
    $field_day = $field_date[1];
    $field_year = $field_date[2];
  } else {
    $field_month = 0;
    $field_day = 0;
    $field_year = 0;
  }

  // CONSTRUCT MONTH ARRAY
  $month_array = Array();
  $month_array[0] = Array('name' => "[MONTH]", 'value' => "0", 'selected' => "");
  for($m=1;$m<=12;$m++) {
    if($field_month == $m) { $selected = " SELECTED"; } else { $selected = ""; }
    $month_array[$m] = Array('name' => $datetime->cdate("$month_format", mktime(0, 0, 0, $m, 1, 1990)),
				'value' => $m,
				'selected' => $selected);
  }

  // CONSTRUCT DAY ARRAY
  $day_array = Array();
  $day_array[0] = Array('name' => "[DAY]", 'value' => "0", 'selected' => "");
  for($d=1;$d<=31;$d++) {
    if($field_day == $d) { $selected = " SELECTED"; } else { $selected = ""; }
    $day_array[$d] = Array('name' => $datetime->cdate("$day_format", mktime(0, 0, 0, 1, $d, 1990)),
				'value' => $d,
				'selected' => $selected);
  }

  // CONSTRUCT YEAR ARRAY
  $year_array = Array();
  $year_count = 1;
  $current_year = $datetime->cdate("Y", time());
  $year_array[0] = Array('name' => "[YEAR]", 'value' => "0", 'selected' => "");
  for($y=$current_year;$y>=1920;$y--) {
    if($field_year == $y) { $selected = " SELECTED"; } else { $selected = ""; }
    $year_array[$year_count] = Array('name' => $y,
					'value' => $y,
					'selected' => $selected);
    $year_count++;
  }

  // ORDER DATE ARRAYS PROPERLY
  switch($date_order) {
    case "mdy":
      $date_array1 = $month_array;
      $date_array2 = $day_array;
      $date_array3 = $year_array;
      break;
    case "ymd":
      $date_array1 = $year_array;
      $date_array2 = $month_array;
      $date_array3 = $day_array;
      break;
    case "dmy":
      $date_array1 = $day_array;
      $date_array2 = $month_array;
      $date_array3 = $year_array;
      break;
  }
    

}

// SET FIELD ARRAY AND INCREMENT FIELD COUNT
$secondary_field = Array('field_type' => $secondary[field_type],
				'field_options' => $field_options,
				'field_value' => $subnet_field2_value,
				'date_array1' => $date_array1,
				'date_array2' => $date_array2,
				'date_array3' => $date_array3);





// DECODE QUALIFIERS
$subnet_field1_qual = htmlspecialchars_decode($subnet_field1_qual, ENT_QUOTES);
$subnet_field2_qual = htmlspecialchars_decode($subnet_field2_qual, ENT_QUOTES);


// ASSIGN VARIABLES AND SHOW EDIT SUBNETWORK PAGE
$smarty->assign('category_main', $category_main);
$smarty->assign('s', $s);
$smarty->assign('error_message', $error_message);
$smarty->assign('old_subnet_name', $subnet[subnet_name]);
$smarty->assign('subnet_id', $subnet[subnet_id]);
$smarty->assign('subnet_name', $subnet_name);
$smarty->assign('primary_field_id', $setting[setting_subnet_field1_id]);
$smarty->assign('primary_field_title', $primary[field_title]);
$smarty->assign('primary_field', $primary_field);
$smarty->assign('secondary_field_id', $setting[setting_subnet_field2_id]);
$smarty->assign('secondary_field_title', $secondary[field_title]);
$smarty->assign('secondary_field', $secondary_field);
$smarty->assign('subnet_field1_value', $subnet_field1_value);
$smarty->assign('subnet_field2_value', $subnet_field2_value);
$smarty->assign('field1_qual', $subnet_field1_qual);
$smarty->assign('field2_qual', $subnet_field2_qual);
$smarty->display("$page.tpl");
exit();
?>