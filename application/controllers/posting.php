<?php
class Posting extends CI_Controller 
{
	function Posting()
	{
		parent::__construct();
		//$this->load->scaffolding('forums');
	}
private function checkrights($for = 0) 
	{	/** Pre: hay un usuario (registrado o no), unos foros, unos permisos y unos roles */
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
	
	function replay()	
	{
		
		$thread = new $this->Thread();
		$id = $this->uri->segment(3);
		$thread->get_by_id($id);
		$foro = $thread->forum->get();
		$permisos = $this->checkrights($foro->id);
		$pagina = 1;
		$data['location'] = 'foro';
		if ($permisos['nueva_respuesta'])
		{	
			if ($this->uri->segment(4) != NULL)
			{
				$pagina = $this->uri->segment(4);
			}
			
			$data['titulo'] = 'Repuesta - '.$thread->title; 
			$data['id'] = $id;
			$data['titulo'] = 'Repuesta - '.$thread->title;
				// Comprobar si es admin		
			$data['admin'] = $this->checkadmin();
				// Fin de la comprobacion 
			$this->load->view('header',$data);
			$this->load->view('posting_form', $data);
			$this->load->view('sidebar');
			$this->load->view('footer');
		}
		else 
		{
			$data['admin'] = false;
			$data['titulo'] = 'Error de acceso';
			if ($this->session->userdata('nick')) 
			{
				$this->load->view('header',$data);
				$data['error'] = 2;
				$data['pagina'] = $pagina;
				$data['thread'] = $this->prueba->adapta_link($thread->title);
				$data['id'] = $id;
				$this->load->view('header',$data);
				$this->load->view('posting_form',$data);
				$this->load->view('sidebar');
				$this->load->view('footer');
			}
			else 
			{
				$this->load->view('header',$data);
				$data['error'] = 1;
				$data['pagina'] = $pagina;
				$data['thread'] = adapta_link($thread->title);
				$data['id'] = $id;
				$this->load->view('posting_form',$data);
				$this->load->view('footer');
			}
		}
	}
	function edit()
	{
		if ($this->uri->segment(3) !== FALSE)
		{
			
			$post = new $this->Post();
			$post->get_by_id($this->uri->segment(3));
			$thread = $post->thread->get();
			$forum = $thread->forum->get();
			$user = $post->user->get();
			$permisos = $this->checkrights($forum->id);
			if ($permisos['editar_respuesta'] || ($this->session->userdata('nick') === $user->nick))
			{
				$data['titulo'] = "Editando $thread->title @ El Oso Hormiguero";
				$data['admin'] = $this->checkadmin();
				$data['location'] = 'foro';
				$data['post'] = $post;
				$this->load->view('header', $data);
				$this->load->view('edit_post', $data);
				$this->load->view('sidebar');
				$this->load->view('footer');
			}
			else
			{
				$data['titulo'] = "El oso hormiguero - sin permiso";
				$data['admin'] = $this->checkadmin();
				$data['location'] = 'foro';
				$this->load->view('header', $data);
				$this->load->view('error');
				$this->load->view('sidebar');
				$this->load->view('footer');
			}
		}
		else
		{
			$data['titulo'] = "El oso hormiguero - sin permiso";
			$data['admin'] = $this->checkadmin();
			$data['location'] = 'foro';
			$this->load->view('header', $data);
			$this->load->view('error');
			$this->load->view('sidebar');
			$this->load->view('footer');
		}
	}
	
	function control_edit()
	{	
		$post = new $this->Post();
		$post->get_by_id($this->input->post('postId'));
		$user = $post->user->get();
		$thread = $post->thread->get();
		$foro = $thread->forum->get();
		$permisos = $this->checkrights($foro->id);
		if ($permisos['editar_respuesta'] || ($this->session->userdata('nick') === $user->nick)) 
		{
			$string = htmlspecialchars($this->input->post('respuesta'),ENT_QUOTES);
			if (strlen(htmlspecialchars($this->input->post('respuesta'),ENT_QUOTES)) > 3 )
			{
				$post->content = htmlspecialchars($this->input->post('respuesta'),ENT_QUOTES);
				$post->save();
				/*$post_count = $thread->post;
				$post_count->get();
				$post_count->count();
				$post = new $this->Post();
				$post->content = htmlspecialchars($this->input->post('respuesta'),ENT_QUOTES);
				$post->pos_t = $post_count->count()+1;
				$post->save();
				$user = new $this->User();
				$user->get_by_nick($this->session->userdata('nick'));
				$user->post++;
				$user->save($post);
				$thread->reply = $thread->reply +1;
				$pag = ceil($post->pos_t/10);
				$thread->save($post); */
				$pag = ceil($post->pos_t/10);
				redirect('/foro/viewtopic/'.$this->prueba->adapta_link($thread->title).'/'.$thread->id.'/'.$pag.'#'.$post->pos_t);
			}
			else redirect('/foro/error/');
		}
		else redirect('/foro/error/');
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
	function control()
	{		$thread = new $this->Thread();
			$thread->get_by_id($this->input->post('id'));
			$foro = new $this->Forum();
			$foro = $thread->forum->get();
			$permisos = $this->checkrights($foro->id);
		if ($this->input->post('respuesta') != FALSE && $permisos['nueva_respuesta']) 
		{
			$post_count = $thread->post;
			$post_count->get();
			$post_count->count();
			$post = new $this->Post();
			$post->content = htmlspecialchars($this->input->post('respuesta'),ENT_QUOTES);
			$post->pos_t = $post_count->count()+1;
			$post->save();
			$user = new $this->User();
			$user->get_by_nick($this->session->userdata('nick'));
			$user->post++;
			$user->save($post);
			$thread->reply = $thread->reply +1;
			$pag = ceil($post->pos_t/10);
			$thread->save($post);
			redirect('/foro/viewtopic/'.$this->prueba->adapta_link($thread->title).'/'.$this->input->post('id').'/'.$pag.'#'.$post->pos_t);
		}
		else redirect('/foro/error/');
	}
	function thread ()
	{
		$data['location'] = 'foro';
		$id = $this->uri->segment(3);
		$pagina = 1;
		if ($this->uri->segment(4) != NULL)
			$pagina = $this->uri->segment(4);
			$foro = new $this->Forum();
			$foro->get_by_id($id);
			$permisos = $this->checkrights($id);
			$data['titulo']= 'Nuevo Tema - '.$foro->name;
			$data['id'] = $id;
			if ($permisos['nuevo_hilo']) 
			{
				
				$data['admin'] = $this->checkadmin();
				// Fin de la comprobacion
				$this->load->view('header',$data);
				$this->load->view('new_thread', $data);
				$this->load->view('sidebar');
				$this->load->view('footer');
			}
			else 
			{
				$data['admin'] = false;
				$data['error'] = 1;
				$data['titulo'] = $foro->name;
				$this->load->view('header',$data);
				$this->load->view('new_thread', $data);
				$this->load->view('sidebar');
				$this->load->view('footer');
			}
	}
	function control_t()
	{
		$foro = new $this->Forum();
		$foro->get_by_id($this->input->post('id'));
		$permisos = $this->checkrights($foro->id);
		if ($this->input->post('contenido') != FALSE && $permisos['nuevo_hilo']) 
		{
			$post = new $this->Post();
			$post->content = htmlspecialchars($this->input->post('contenido'),ENT_QUOTES);
			$thread = new $this->Thread();
			$thread->title= htmlspecialchars($this->input->post('titulo'),ENT_QUOTES);
			$post->save();
			$thread->save();
			$thread->save($post);
			$thread->reply = 1;
			$user = new $this->User();
			$user->get_by_nick($this->session->userdata('nick'));
			$user->post++;
			$user->save($post);
			$thread->save($user);
			$foro->save($thread);
			redirect('/foro/viewtopic/'.$this->prueba->adapta_link($thread->title).'/'.$thread->id.'/');
		}
		else
		{
			redirect('/foro/error/');
		}
	}
}
?>