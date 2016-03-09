<?php

class Profile extends CI_Controller
{
	function index()
	{
		
		echo $hola;
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
	/**
	 * 
	 * Devuelve los permisos de foro de los usuarios,
	 * Si se le introduce un entero concreo (>0) devuelve los permisos del foro con esa id.
	 * Por defecto (=0) devuelve los permisos de todos los foros.
	 * 
	 * @param int $for
	 */
	private function checkrights($for = 0) 
	{	// Pre: hay un usuario (registrado o no), unos foros, unos permisos y unos roles
		$usuario = new $this->User();
		if ($this->session->userdata('nick'))
		{
			$usuario->get_by_nick($this->session->userdata('nick'));
		}
		else
		{
			$usuario->get_by_nick('No registrado');
		}
		$roles_usu = $usuario->role;
		$roles_usu->get();
		if ($for == 0)
		{			
			$foros = new $this->Forum();
			$foros->get();
			foreach ($foros->all as $foro) 
			{
				$permisos = new $this->Permission();
				$permisos->get();
				foreach ($permisos->all as $permiso)
				{
					$encontrado = FALSE;
					$perForum = new $this->Pforum();
					$perForum->where('forum_id', $foro->id);
					$perForum->where('permission_id', $permiso->id)->get();
					$rol_per_for = new $this->Role();
					$rol_per_for->get_by_id($perForum->role_id);
					
					foreach ($roles_usu->all as $role)
					{
						$resta = $role->value - $rol_per_for->value;
						if (($role->value == $rol_per_for->value) || ( $resta > 700) || ($rol_per_for->value == 0) )
						{
							$encontrado = TRUE;
						}
					}
					$array[$foro->id][$permiso->name] = $encontrado;
				}
		
			}
		}
		else  // if ($for == 0)
		{
			$permisos = new $this->Permission();
			$permisos->get();
			foreach ($permisos as $permiso)
			{
				$encontrado = FALSE;
				$perForum = new $this->Pforum();
				$perForum->where('forum_id', $for);
				$perForum->where('permission_id', $permiso->id)->get();
				$rol_per_for = new $this->Role();
				$rol_per_for->get_by_id($perForum->role_id);
				foreach ($roles_usu->all as $role)
				{
					$resta = $role->value - $rol_per_for->value;
					if (($role->value == $rol_per_for->value) || ( $resta > 700) || ($rol_per_for->value == 0) )
					{
						$encontrado = TRUE;
					}
				}
				$array[$permiso->name] = $encontrado;
			}
			
		}
		return $array;
	// Post: devuelve un array con los permisos	
	}
	
	function id()
	{
		$nick = urldecode($this->uri->segment(3));
		if ($nick == false)
		{}
		else {
			$usuario = new $this->User();
			$usuario->get_by_nick($nick);
			$data['admin'] = $this->checkadmin();
			$data['titulo'] = 'Perfil de '.$usuario->nick.' @ Elosohormiguero.es';
			$data['location'] = 'profile';
			$data['user'] = $usuario;
			$data['modificar'] = false;
			if ($this->session->userdata('nick') === $nick)
				$data['modificar'] = true;
			$this->load->view('header',$data);
			$this->load->view('profile', $data);
			$this->load->view('sidebar');
			$this->load->view('footer');
		}
	}
	
	function edit()
	{
		$usuario = new $this->User();
		if ($this->session->userdata('nick') != "") {
			$usuario->get_by_nick($this->session->userdata('nick'));
			$data['admin'] = $this->checkadmin();
			$data['titulo'] = 'Perfil de '.$usuario->nick.' @ Elosohormiguero.es';
			$data['location'] = 'profile';
			$data['user'] = $usuario;
			$this->load->view('header',$data);
			$this->load->view('editprofile', $data);
			$this->load->view('sidebar');
			$this->load->view('footer');
		}
		else {
			$data['admin'] = $this->checkadmin();
			$data['titulo'] = 'Error de acceso';
			$data['location'] = 'error';
			$this->load->view('header',$data);
			$this->load->view('error');
			$this->load->view('sidebar');
			$this->load->view('footer');
		}
	}
	
	function control()
	{
		if ($this->input->post('nick') === $this->session->userdata('nick'))
		{
			$this->load->helper('file');
			$user = new $this->User();
			$user->get_by_nick($this->input->post('nick'));
			$config['upload_path'] = './images/avatars/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '20';
			$config['max_width'] = '120';
			$config['max_height'] = '120';
			$config['overwrite'] = TRUE;
			$config['file_name'] = $user->nick.'120.jpg';
			if (htmlspecialchars($this->input->post('name'),ENT_QUOTES)!=="")
				$user->name = htmlspecialchars($this->input->post('name'),ENT_QUOTES);
			if (htmlspecialchars($this->input->post('bio'),ENT_QUOTES) !== "")
				$user->bio = htmlspecialchars($this->input->post('bio'),ENT_QUOTES);
			$this->load->library('upload', $config);
			//$this->upload->do_upload();
			if ($this->upload->do_upload('avatar'))
				{					
					$user->avatar = $user->nick.'120.jpg';
					$user->save();
					redirect(base_url().'profile/id/'.$user->nick);
				}
				else 
				{
					//print_r(array('error' => $this->upload->display_errors()));
					$user->save();
					redirect(base_url().'profile/id/'.$user->nick);
				}
			}
			
		}
}