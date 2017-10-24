<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Sets global front-end messages
* @author catalin@ipmedia.ro
* @version 1.1
* 
* @param string $noty
* @param string $type
*/
function set_noty($noty, $type = 'information'){
  if(!in_array($type, array('alert', 'success', 'error', 'warning', 'information'))) return;

  $CI =& get_instance();
  $noties   = $CI->session->userdata('noties');
  if(!isset($noties[$type]) || array_search($noty, $noties[$type]) === FALSE){
    $noties[$type][] = $noty;
    $CI->session->set_userdata('noties', $noties);
  }
}

/**
* Generates front-end noties
* 
* @author catalin@ipmedia.ro
* @version 1.0.1
*/
function get_noties($return = false){
    $CI =& get_instance();
    $noties   = (array)$CI->session->userdata('noties');
    
    $r = $CI->load->view('messages', array('noties' => $noties), $return);
    $CI->session->unset_userdata('noties');

    return $r;
}
