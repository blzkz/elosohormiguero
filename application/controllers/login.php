<?php
class Login extends CI_Controller
{
	function Login()
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
		if ($cadena->name != 'Admin') {
			return false;
		}
		else 
		{
			return true;
		}
	}
	function index() 
	{
		$data['location'] = 'login';
		$data['titulo'] = 'login';
		$data['admin'] = $this->checkadmin();
		$this->load->view('header', $data);
		$this->load->view('login');
		$this->load->view('sidebar');
		$this->load->view('footer');
	}
	
	private function passEnc($pass)
	{
		for ($i = 0; $i<5; $i++)
		{
			$pass = md5($pass);
		}
		return $pass;
	}
	function error() 
	{
		$data['location'] = 'login';
		$data['titulo'] = 'Login @ elosohormiguero.es';
		$data['admin'] = $this->checkadmin();
		$data['error'] = false;
		$this->load->view('header', $data);
		$this->load->view('login',$data);
		$this->load->view('sidebar');
		$this->load->view('footer');
	}
	function control()
	{
		$data['location'] = 'login';
		if ($this->input->post('Nick') != FALSE) 
		{
			$usuario = new $this->User();
			$usuario->get_by_nick(htmlspecialchars($this->input->post('Nick'),ENT_QUOTES));
			if ($usuario != NULL && $usuario->password === $this->passEnc($this->input->post('Password')))
			{
				$usuario_array['nick'] = $usuario->nick;
				$usuario_array['email'] = $usuario->email;
				$usuario_array['id'] = $usuario->id;
				$this->session->set_userdata($usuario_array);
				redirect('/foro/');
			}
			else
			{ 
				//echo 'Usuario/contrase�a no v�lido';
				redirect(base_url().'login/error/1');
			}
		}
		else
		{
			$data['error'] = TRUE; 
			$this->load->view('login',$data);
		}
	}
	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
?>