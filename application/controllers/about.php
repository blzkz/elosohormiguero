<?php
class About extends CI_Controller
{
	function Noticias()
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
		$data['location'] = "about";
		$data['admin'] = $this->checkadmin();
		$data['titulo'] = 'About...';
		$this->load->view('header', $data);
		$this->load->view('about');
		$this->load->view('sidebar');
		$this->load->view('footer');
	}
	
}