<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Prueba {
	public function probando() 
	{
	    return true;
	}
	public function checkadmin()
	{
		$usuario = new $this->User();
		$nombre = $this->session->userdata('nick');
		if ($nombre == '' ) { return false;}
		$usuario->get_by_nick($this->session->userdata('nick'));
		$role = $usuario->role;
		$cadena = $role->get_by_name('Admin');
		if ($cadena->name != 'Admin')
		return false;
		else
		return true;
	}
	public function botonera_post(){
		return $botonera = form_button('',"b", "onclick='botones(1)'")
							.form_button('','i', "onclick='botones(2)'")
							.form_button('',"[url=]", "onclick='botones(3)'")
							.form_button('',"[img]", "onclick='botones(4)'")
							.form_button('',"[spoiler]", "onclick='botones(5)'")
							.form_button('',"[video]", "onclick='botones(6)'" );
	}
	public function adapta_link($string){
		$array = array(
					'/à|á|â|ã|ä|å|æ|ª/' => 'a',
					'/À|Á|Â|Ã|Ä|Å|Æ/' => 'A',
					'/è|é|ê|ë|ð/' => 'e',
					'/È|É|Ê|Ë|Ð/' => 'E',
					'/ì|í|î|ï/' => 'i',
					'/Ì|Í|Î|Ï/' => 'I',
					'/ò|ó|ô|õ|ö|ø|º/' => 'o',
					'/Ò|Ó|Ô|Õ|Ö|Ø/' => 'o',
					'/ù|ú|û|ü/' => 'u',
					'/Ù|Ú|Û|Ü/' => 'U',
					'/ç/' => 'c',
					'/Ç/' => 'C',
					'/ý|ÿ/' => 'y',
					'/Ý|Ÿ/' => 'Y',
					'/ñ/' => 'n',
					'/Ñ/' => 'N',
					'/[\W¿¡]+/' => '-',
					'/^\-/' => '',
					'/\-$/' => ''
		);
		$patron = '/[\W¿¡]+/';
		return preg_replace(array_keys($array), array_values($array), $string);
		//return preg_replace($patron, "-", $string);
		
	}
}
