<?php
$page = "Search";
include "Header.php";

if($user->user_exists == 0 & $setting[setting_permission_search] == 0) {
  $page = "Error";
  $smarty->assign('error_header', $Application[293]);
  $smarty->assign('error_message', $Application[292]);
  $smarty->assign('error_submit', $Application[294]);
  include "Footer.php";
}

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['p'])) { $p = (int) $_POST['p']; } elseif(isset($_GET['p'])) { $p = (int) $_GET['p']; } else { $p = 1; }
if(isset($_POST['search_text'])) { $search_text = $_POST['search_text']; } elseif(isset($_GET['search_text'])) { $search_text = $_GET['search_text']; } else { $search_text = ""; }
if(isset($_POST['t'])) { $t = $_POST['t']; } elseif(isset($_GET['t'])) { $t = $_GET['t']; } else { $t = 0; }

// set default values
$results_per_page = 10;
$results = Array();
$total_results = 0;
$is_results = 0;
$object_count = 0;
$search_objects = Array();
$is_next_page = 0;
if($p < 1) { $p = 1; }



// do search
if($task == "dosearch" & $search_text != "") {
  
  // start search timer
  $start_timer = getmicrotime();
  
  // search profiles
  if($t == "0") { $total_only = 0; } else { $total_only = 1; }  
  search_profile($search_text, $total_only, $search_objects, $results, $total_results);

  // search plugin object if necessary
  //print_r(($global_plugins));
  for($g=0;$g<count($global_plugins);$g++) {    
    if(function_exists('search_'.strtolower($global_plugins[$g]))) {
  	  //echo '<br>'.'search_'.strtolower($global_plugins[$g]);
      if($t == strtolower($global_plugins[$g])) { $total_only = 0; } else { $total_only = 1; }
      call_user_func_array('search_'.strtolower($global_plugins[$g]), array($search_text, $total_only, &$search_objects, &$results, &$total_results)); 
    }
  }

  //get round total results
  for($r=0;$r<count($search_objects);$r++) {
    if($search_objects[$r][search_total] != 0) { 
      if($total_results == 0) { header("Location: Search.php?task=dosearch&search_text=".urlencode($search_text)."&t=".$search_objects[$r][search_type]); exit(); }
      $is_results = 1; 
    }
  }

  // end timer
  $end_timer = getmicrotime();
  $search_time = round($end_timer - $start_timer, 3); 

  // check for the "next page"
  if(count($results) > $results_per_page) { 
    $is_next_page = 1;
    while(count($results) > $results_per_page) {
      array_pop($results);
    }
  }

  // if total results is more than 200 change to 200+
  if($total_results > 200) { 
    if($is_next_page == 1) { $maxpage = $p+1; } else { $maxpage = $p; }
    $total_results = "200+";
  } else {
    if(($total_results % $results_per_page) != 0) { $maxpage = ($total_results) / $results_per_page + 1; } else { $maxpage = ($total_results) / $results_per_page; }
    $maxpage = (int) $maxpage; 
  }

  // if empty - display nothing
  if(count($results) == 0 & $p != 1) { $search_text = ""; }

}


$smarty->assign('search_text', $search_text);
$smarty->assign('url_search', urlencode($search_text));
$smarty->assign('is_results', $is_results);
$smarty->assign('results', $results);
$smarty->assign('total_results', $total_results);
$smarty->assign('search_objects', $search_objects);
$smarty->assign('search_time', $search_time);
$smarty->assign('maxpage', $maxpage);
$smarty->assign('t', $t);
$smarty->assign('p', $p);
$smarty->assign('p_start', (($p-1)*$results_per_page)+1);
$smarty->assign('p_end', (($p-1)*$results_per_page)+count($results));
include "Footer.php";
?>