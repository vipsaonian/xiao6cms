<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lang_model extends CI_Model{
	var $CI;
	function __construct(){
  		parent::__construct();
  		$this->CI =& get_instance();
	}
	
	function loadLang($lang_type='admin',$lang=false){
		if($lang_type=='admin'){
			if(!$lang){
				$this->CI->Cache_model->setLang();
				$lang = $this->CI->Cache_model->defaultAdminLang;
			}
			$this->CI->lang->load('admin',$lang,FALSE,TRUE,'data/');
		}else{
			if(!$lang){
				$lang =  $this->CI->Cache_model->defaultLang;
			}
			$this->CI->lang->load($lang_type,$lang,FALSE,TRUE,'data/');
		}
		return $lang;
	}
	
	function loadLangUrl($lang){
		$defaultLang = $this->CI->Cache_model->defaultLang;
		return $lang==$defaultLang?'':'?lang='.$lang;
	}
	
	function getEditLang(){
		$lang = $this->CI->session->userdata('edit_lang');
		if(!$lang){
			$this->CI->load->model('Data_model');
			$row = $this->CI->Data_model->getSingle(array('varname'=>'site_frontlang'),'config');
			$lang = isset($row['value'])&&$row['value']!=''?$row['value']:'zh_cn';
			$this->setLang('edit',$lang);
		}
		return $lang;
	}
	
	function setLang($type,$lang){
		$this->session->set_userdata($type.'_lang',$lang);
	}
}