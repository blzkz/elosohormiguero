<?php
class Legal extends CI_Controller 
{
	function Legal()
	{
		parent::__construct();
		//$this->load->scaffolding('forums');
	}

	private function checkadmin()
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
	function index()
	{
		$data['titulo'] = "Información legal @ El Oso Hormiguero";
		$data['admin'] = $this->checkadmin();
		$data['location'] = "legal";
		$this->load->view('header',$data);
		$this->load->view('legal');
		$this->load->view('sidebar');
		$this->load->view('footer');
	}
	
}