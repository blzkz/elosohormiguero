<?php

class Admin extends CI_Controller
{
	function Admin()
	{
		parent::__construct();
		//$this->load->scaffolding('forums');
	}
	private function checkadmin()
	{
		$usuario = new $this->User();
		$nombre = $this->session->userdata('nick');
		if ($nombre == '' ) {return false;}
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
		if ($this->checkadmin())
		{
			echo "buena esa \n";
			$data['titulo'] = 'Panel de administración';
			$this->load->View('admin/header', $data);
			$this->load->view('admin/admin');			
		}
		else 
			redirect('/foro/');
	}
	function users()
	{
		if ($this->checkadmin())
		{
			$data['titulo']= 'Panel de administración - Usuarios';
			$user = new $this->User();
			$user = $user->get();
			$data['query'] = $user;
			$data['num_us'] = $user->count();
			$this->load->view('admin/header', $data);
			$this->load->view('admin/users',$data);
			$this->load->view('admin/footer');
		}
		else
			echo 'Acceso prohibido';
	}
	
	function roles_user()
	{
		
		if ($this->checkadmin())
		{
			
			$usuario = new $this->User();
			$usuario->get_by_id($this->uri->segment(3));
			$data['titulo'] = 'Panel de administración - Modificar roles del usuario '.$usuario->nick;
			$roles = new $this->Role();
			$roles = $usuario->role->get();
			//print_r($roles);
			$data['roles_usuario'] = $roles;
			$roles_all = new $this->Role();
			$roles_all->get();
			
			$data['usuario'] = $usuario;
			foreach ($roles_all->all as $fil)
			{
				$array[$fil->id] = $fil->name;
			}
			$data['roles'] = $array;
			$this->load->view('admin/header', $data);
			$this->load->view('admin/roles_user', $data);
			$this->load->view('admin/footer');
			
		}
		else
			die('Acceso denegado');
	}
	function roles_user_control()
	{
		$user = new $this->User();
		$user->get_by_id($this->input->post('user_id'));
		$troll = $user->roles->get();
		$user->delete($troll);
		$roles = $this->input->post('roles');
		//print_r($roles);
		foreach ($roles as $rol)
		{
			$rolu = new $this->Role();
			$rolu->get_by_id($rol);
			$user->save($rolu);
		}
		redirect(base_url().'admin/users');
	}
	// FIN USERS
	function forums()
	{
		if ($this->checkadmin())
		{
			$data['titulo']= 'Panel de administración - Foros';
			$this->load->view('admin/header', $data);
			$forums = new $this->Forum();
			$forums->get();
			$forumData['query']= $forums;
			$this->load->view('admin/forums', $forumData);
			$this->load->view('admin/footer');
		}
		else echo 'Acceso prohibido';
	}
		
	function permissions()
	{
		if ($this->checkadmin())
		{
			$data['titulo'] = 'Panel de administración - Permisos';
			$permisos = new $this->Permission();
			$permisos->get();
			$data['query'] = $permisos;
			$this->load->view('admin/header', $data);
			$this->load->view('admin/permissions', $data);
			$this->load->view('admin/footer');
		}
		else echo 'Acceso prohibido';
		
	}
	
	// NUEVO FORO
	
	function new_forum() 
	{
		if ($this->checkadmin())
		{
			$data['titulo'] = 'Panel de administración - Crear foro';
			$this->load->view('admin/header', $data);
			$this->load->view('admin/new_forum');
			$this->load->view('admin/footer');
		}
		else echo 'Acceso prohibido';
		
	}
	
	// CONTROL NUEVO FORO
	
	function new_forum_control()
	{
		if ($this->checkadmin())
		{
			if ($this->input->post('Name') && $this->input->post('Description'))
			{
				$foro = new $this->Forum();
				$foro->name= $this->input->post('Name');
				$foro->description = $this->input->post('Description');
				$foro->save();
				redirect('/admin/forums');
			}
		}
		else die('Acceso prohibido');
	}
	
	function rights_forum()
	{
		if ($this->checkadmin())
		{
			if (!$this->input->post('modificado'))
			{ // Si no se está modificando un foro
				$id_foro = $this->uri->segment(3);
				$foro = new $this->Forum();
				$foro->get_by_id($id_foro);
				$per_for = new $this->Pforum();
				$per_for = $foro->pforum;
				$per_for->get()->order_by('permission_id', 'asc');
				if ($per_for->result_count() == 0) 
				{
						$data['permisos_foro'] = 0;
				}
				else
				{			
					$data['permisos_foro'] = $per_for;
				}
				//
				$permisos = new $this->Permission();
				$permisos->get();
				$roles = new $this->Role();
				$roles->get();
				$count = $roles->result_count();
				$roles_arr=0;
				$i = 0 ;
				
				foreach ($roles->all as $fil)
				{
					$array[$fil->id] = $fil->name;
				}
				$data['permisos'] = $permisos;
				$data['roles'] = $array;
				$data['titulo'] = 'Modificando foro: '.$foro->name;
				$data['foro'] = $foro;
				$this->load->view('admin/header', $data);
				$this->load->view('admin/modify_forum', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$foro = new $this->Forum();
				$foro->get_by_id($this->input->post('foro_id'));
				$pforo = new $this->Pforum();
				$pforo = $foro->pforum;
				$pforo->get()->order_by('id_permission','asc');
				$permisos = new $this->Permission();
				$permisos->get();
				$i = 0;
				if ($pforo->result_count() == 0) // Si no hay permisos para ese foro
				{
					foreach ($permisos->all as $permiso)
					{	
						$array_roles = $this->input->post($permiso->name);						
						print_r($array_roles);
						foreach ($array_roles as $role_momento)
						{
							$pforo = new $this->Pforum();
							$roles = new $this->Role();
							$roles->get_by_id($role_momento);
							$pforo->save($foro);
							$pforo->save($permiso);
							$pforo->save($roles);
						}
					}
				}
				else
				{
					$pforo = new $this->Pforum();
					$pforo->get_by_forum_id($foro->id);
					$pforo->delete_all();
					foreach ($permisos->all as $permiso)
					{	
						$array_roles = $this->input->post($permiso->name);						
						foreach ($array_roles as $role_momento)
						{
							echo 'borrando';
							$pforo = new $this->Pforum();
							$roles = new $this->Role();
							$roles->get_by_id($role_momento);
							$pforo->save($foro);
							$pforo->save($permiso);
							$pforo->save($roles);
						}
					}
				}
				
			  	redirect('admin/forums');
			}
		}
		else die('Acceso prohibido');
	}
	
	function applied_forum () 
	{ //función de vuelta después de modificar un foro
		if ($this->checkadmin())
		{
			if ($this->input->post('enviado'))
			{
				$foro = new $this->Forum();
				$foro->get_by_id($this->uri->segment(3));
				$rol = new $this->Role();
				$permisos = new $this->Permission();
				$n_permisos = $permisos->count();
				$permisos = new $this->Permission();
				$permisos->get();
				$pf = new $this->Pforum();
				$pf->get_by_forum_id($this->uri->segment(3));
				$pf->delete_all();
				$i =1;
				foreach ($permisos->all as $per)
				{
					$pforo = new $this->Pforum();
					$role = new $this->Role();
					$role->get_by_id($this->input->post($per->name));
					$pforo->save($foro);
					$pforo->save($per);
					$pforo->save($role);
					//echo $i++;
					//redirect(base_url().'admin/forums');
				}
			}
			else {die();}
		}
		else {die();}
	}
	
	///////////////////////
	// FIN FOROS
	///////////////////////
	
	//////////////////////
	// ROLES
	//////////////////////
	function roles()
	{
		if ($this->checkadmin())
		{
			$roles = new $this->Role();
			$roles->get();
			$data['query'] = $roles;
			$data['titulo']= 'Panel de administración - Roles';
			$this->load->view('admin/header', $data);
			$this->load->view('admin/roles');
			$this->load->view('admin/footer');
		}
		else
			die('Acceso prohibido');
	}
	function new_role()
	{
		if ($this->checkadmin())
		{
			if ($this->input->post('Done'))
			{
				$rol = new $this->Role();
				$rol->name = $this->input->post('name');
				$rol->description = $this->input->post('description');
				$rol->color = $this->input->post('color');
				$rol->value = ($this->input->post('value') + $rol->count());
				$rol->save();
				$rol->get();
				$data['query'] = $rol;
				$data['done']=true;
				$data['titulo']= 'Panel de administración - Rol añadido';
				$this->load->view('admin/header', $data);
				$this->load->view('admin/roles');
				$this->load->view('admin/footer');
				
				
			}
			else
			{
				$data['titulo']= 'Panel de administración - Nuevo rol';
				$this->load->view('admin/header', $data);
				$this->load->view('admin/new_role');
				$this->load->view('admin/footer');
			}
		}
		else
			die('Acceso prohibido');
	}
	function new_right()
	{
		if ($this->checkadmin()) 
		{
			echo 'something';
			if ($this->input->post('name') != '')
			{
				echo 'like that';
				$permiso = new $this->Permission();
				$permiso->name = $this->input->post('name');
				$permiso->save();
				redirect('/admin/permissions/');
				echo 'bien';
			}
		}			
		else
			die('Acceso prohibido');
	}
	/*function control()
	{
		if ($this->input->post('Nick') != FALSE) 
		{
			$usuario = new $this->User();
			$usuario->get_by_nick($this->input->post('Nick'));
			if ($usuario != NULL && $usuario->password === $this->input->post('Password'))
			{
				$roles = new $this->Role();
				$roles = $usuario->role->get_by_name('Admin');
				if ($roles->name === 'Admin')
				{
					$usuario_array['nick'] = $usuario->nick;
					$usuario_array['email'] = $usuario->email;
					$usuario_array['id'] = $usuario->id;
					$usuario_array['adm'] = TRUE;
					$usuario_array['role'] = $usuario->role;
					$this->session->set_userdata($usuario_array);
					//redirect('/admin/');
					echo $roles->name; echo $this->session->userdata('nick');
				}
				else 
				{
					$data['error'] = TRUE;
					$this->load->view('admin/login', $data);
				}
			}
			else
			{ 
				//echo 'Usuario/contrase�a no v�lido';
				$data['error'] = TRUE; 
				$this->load->view('admin/login',$data);
			}
		}
		else
		{
			$data['error'] = TRUE; 
			$this->load->view('admin/login',$data);
		}
	}*/
};