<?php
class Register extends CI_Controller
{
	// constructor by default
	function Register()
	{
		parent::__construct();
		//$this->load->scaffolding('forums');
	}
	// Método principal que llama a la vista register
	function index()
	{
		$data['admin'] = $this->checkadmin();
		$data['titulo'] = "Registro";
		$data['location'] = "Registro";
		if ($this->session->userdata('nick') == '')
			$data['logged'] = false;
		else $data['logged'] = true;
		$this->load->view('header',$data);
		$this->load->view('register',$data);
		$this->load->view('sidebar');
		$this->load->view('footer');;
	}
	function error()
	{
		$data['error'] = $this->uri->segment(3);
		$data['admin'] = $this->checkadmin();
		$data['titulo'] = "Registro";
		$data['location'] = "Registro";
		if ($this->session->userdata('nick') == '')
			$data['logged'] = false;
		else $data['logged'] = true;
		$this->load->view('header',$data);
		$this->load->view('register',$data);
		$this->load->view('sidebar');
		$this->load->view('footer');
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
	private function passEnc($pass)
	{
		for ($i = 0; $i<5; $i++)
		{
			$pass = md5($pass);
		}
		return $pass;
	}

	
	///////////////////////////////
	// CONTROL SOBRE EL REGISTRO //
	///////////////////////////////
	function control()
	{
		if (($this->input->post('nickname') != FALSE) && ($this->input->post('email') != FALSE) && ($this->input->post('password') != FALSE)) 
		{ 
			//$data['error'] = 1;
			if (preg_match("/^[A-Za-z0-9-_.+%]+@[A-Za-z0-9-.]+\.[A-Za-z]{2,4}$/", $this->input->post('email')))
			{
				$usuario = new $this->User();
				$usuario->get_by_nick(htmlspecialchars($this->input->post('nickname'),ENT_QUOTES));
				if ($usuario->id != NULL)
					$data['error'] = 1;
				$usuario->get_by_email(htmlspecialchars($this->input->post('email'),ENT_QUOTES));
				if ($usuario->id != NULL )
					$data['error'] = 2;			
				if (!isset($data['error']))
				{
				$this->load->view('recaptchalib');
				$privatekey = "6Le1NcwSAAAAABDntyMPTOM8wh8xJ8VklYgayVtB";
				$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
				if (!$resp->is_valid) {
				    // What happens when the CAPTCHA was entered incorrectly
				    redirect('/register/error/3');
				  } else {
				    $rol = new $this->Role();
					$rol->get_by_name('Usuario Registrado');
					$usuario = new $this->User();
					$usuario->nick = htmlspecialchars($this->input->post('nickname'),ENT_QUOTES);
					$usuario->email = htmlspecialchars($this->input->post('email'),ENT_QUOTES);
					$usuario->password = $this->passEnc($this->input->post('password'));
					//$usuario->birth = $this->input->post('anyo').'-'.$this->input->post('mes').'-'.$this->input->post('dia');
					$usuario->save($rol);
					$this->load->library('email');
	
					$this->email->from('beta@elosohormiguero.es', 'El oso hormiguero');
					$this->email->to($usuario->email); 
			
					
					$this->email->subject('Cuenta creada');
					$this->email->message("Bienvenido, su cuenta ha sido creada \n guarde el e-mail puesto que la contraseña se guarda encriptada. \n Datos:
					\n Nombre de usuario:".$usuario->nick." \n Password:".$this->input->post('password'));	
					
					$this->email->send();
					
					redirect('/register/complete');
				  }
				}
				
			
				else
				{ 
					redirect('/register/error/'.$data['error']);
				}
			}
			else redirect('/register/error/3');
		}
		else
		{
			redirect('/register/error/1');
		}
	}
	function complete()
	{
		$data['titulo'] = 'Registro completo - El oso hormiguero';
		$data['location'] = 'Registro';
		$data['admin'] = $this->checkadmin();
		$this->load->view('header',$data);
		$this->load->view('register_complete',$data);
		$this->load->view('sidebar');
		$this->load->view('footer');
	}
	function email_prueba()
	{
		$this->load->library('email');

		$this->email->from('beta@elosohormiguero.es', 'Eloso');
		$this->email->to('blzkz@blzkz.es'); 

		
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');	
		
		$this->email->send();
		echo 'enviado';
	}
	function logout()
	{
		$this->session->sess_destroy();
	}
}