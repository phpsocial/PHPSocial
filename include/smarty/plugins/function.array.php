<?php
/**
 * Smarty {array} function plugin
 *
 * File:     function.array.php<br>
 * Type:     function<br>
 * Name:     array<br>
 * Purpose:  creates/appends to an array in a Smarty template
 *
 * @version 1.0
 * @copyright Copyright 2007 by Andrew Teixeira
 * @author Andrew Teixeira - ateixeira (at) gmail (dot) com
 *
 * @param array $params parameters                                        
 * @param object &$smarty Smarty object 
 *
 * @return void|string No return value.  The array values are set internally
 * to Smarty
 */
function smarty_function_array($params, &$smarty) {                             
  static $arrays = array();                                                     
                                                                                
  if (empty($params['var'])) {                                                  
    $smarty->trigger_error("array: missing 'var' parameter");                   
    return;                                                                     
  }                                                                             
                                                                                
  $arrName = (isset($params['var'])) ? $params['var'] : NULL;                   
  if ($arrName == NULL) {                                                       
    $smarty->trigger_error("array: 'var' parameter is empty");                  
    return;                                                                     
  }                                                                             
                                                                                
  if (!in_array('value', array_keys($params))) {                                
    $smarty->trigger_error("array: missing 'value' parameter");                 
    return;                                                                     
  }                                                                             
                                                                                
  $theArr =& $arrays[$arrName];                                                 
  if (isset($params['key'])) {                                                  
    $theArr[(string)$params['key']] = $params['value'];                         
  }                                                                             
  else {                                                                        
    if(!is_array($theArr)) {                                                    
      $theArr = array();                                                        
    }                                                                           
    array_push($theArr, $params['value']);                                      
  }                                                                             
                                                                                
  $smarty->assign($arrName, $theArr);                                           
} /* end function smarty_function_array */ 
?>