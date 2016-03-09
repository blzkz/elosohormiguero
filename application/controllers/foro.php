<?php

class Foro extends CI_Controller
{
	function Foro()
	{
		parent::__construct();
		//$this->load->scaffolding('forums');
	}
	
	private function error()
	{
		$data['titulo'] = "El oso hormiguero - sin permiso";
		$data['admin'] = $this->checkadmin();
		$data['location'] = 'foro';
		$this->load->view('header', $data);
		$this->load->view('error');
		$this->load->view('sidebar');
		$this->load->view('footer');
		
	}
	//Comprobar permisos
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
	function php_info()
	{
		echo phpinfo();
	}
	function prueba ()
	{
		//$dest = base_url().'images/thumbs/jijijiji.png';
		$dest = './images/thumbs/img.jpg';
		$thumb = imagecreatetruecolor(940,450);
		$src = imagecreatefromjpeg("http://i.imgur.com/x7CDV.jpg");
		$im_src = getimagesize("http://i.imgur.com/x7CDV.jpg");
		imagecopyresized($thumb,$src, 0, 0, 0, 0,940, 450,$im_src[0],$im_src[1]);
		imagepng($thumb,$dest);
		/*$config['image_library'] = 'gd2';
		$config['source_image']	= './images/avatars/blzkz120.jpg';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 940;
		$config['new_image'] = $dest;
		$this->load->library('image_lib', $config); 
		echo $this->image_lib->display_errors('<p>', '</p>');*/
		//$this->image_lib->initialize($config); 
		//$this->image_lib->resize();
		echo $dest;
		//print_r(getimagesize("http://i.imgur.com/x7CDV.jpg"));
		/*$data['image_url'] = "http://i.imgur.com/x7CDV.jpg";
		$data['location'] = "sgg";
		$data['titulo'] = "prueba imagen";
		$data['admin'] = $this->checkadmin();
		$this->load->view('header', $data);
		$this->load->view('cropImg');
		$this->load->view('sidebar');
		$this->load->view('footer');
		$video= "http://youtu.be/QmvwWxzg3lc";
		$array = (parse_url($video));
		print_r($array);
		echo $array['path']."\n";
		$video = substr($array['path'], 1,11);
		//$video = substr($array['query'], 2,11);
		echo $video;*/
	}
	/**
	 * Devuelve los permisos de foro de los usuarios.<BR>
	 * Si se le introduce un entero concreo (>0) devuelve los permisos del foro con esa id. Por defecto (=0) devuelve los permisos de todos los foros.
	 * 
	 * @param $for int (0 por defecto)
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
	
	function index()
	{ 
		$data['location']= 'foro';
		$permisos = $this->checkrights();
		$data['titulo'] = "foros";
		// Comprobar si es admin
		$usuario = new $this->User();
		$usuario->get_by_nick($this->session->userdata('nick'));
		$roles = $usuario->role;
		$adm = $this->checkadmin();			
		$data['admin'] = $adm;
		// Fin de la comprobacion
		$this->load->view('header', $data);
		$foro = new $this->Forum();
		$foro->get();
		//$data['query'] = $this->db->get('forums');
		$data['query'] = $foro;
		$data['permisos'] = $permisos;
		$this->load->view('forums', $data);
		$this->load->view('sidebar');
		$this->load->view('footer');
	}
	private function paginador ()
	{
	}
	function viewforum() 
	{
		$data['location']= 'foro';
		$id = $this->uri->segment(3);
		$permisos_usu = $this->checkrights($id);
		//print_r($permisos_usu);		
		$pagina = 0;
		$max_per_page = 10;
		// igualando el segmento al numero de pagina a mostrar
		if ($this->uri->segment(4)!= NULL) 
		{
			$pagina = $this->uri->segment(4);
		}
		else 
			$pagina=1;
		//$query = "SELECT * FROM threads WHERE thread_forum_id = ".$id;
		$this->load->model('Thread');
		$this->load->model('Forum');
		// accediendo a la relaci�n
		$foro = new $this->Forum();
		$foro->get_by_id($id);
		$threads = $foro->thread;
		$max_pags = ceil($threads->count()/$max_per_page);		
		if ( $max_pags > 0 && $max_pags >= $pagina)
		{
			$threads->limit($max_per_page, max(0,(($pagina-1)*$max_per_page)-1))->order_by("updated", "desc")->get();
			// Comprobar si es admin	
			$i = 1;
			//$n_respuestas = $threads->post->get()->count();
			foreach ($threads->all as $fila) 
				{
					$array[$i]['user'] = $fila->user->get()->nick;
					$array[$i]['created'] = $fila->created;
					$array[$i]['n_respuestas'] = $fila->reply;
					$array[$i]['id']= $fila->id;
					$array[$i]['title'] = $fila->title;
					$array[$i]['link'] = $this->prueba->adapta_link($fila->title);
					$i++;
				}
			$data['admin'] = $this->checkadmin();
			// Fin de la comprobacion
			$data['id_for'] = $id;
			$data['max_pag'] = $max_pags;
			$data['pagina'] = $pagina;
			$data['query'] = $array;
			$data['titulo'] = 'Foro - '.$foro->name;
			$data['nombre_foro'] = $foro->name;
			$data['n_respuestas'] = 0;
			$this->load->view('header',$data);
			$data['permisos'] = $permisos_usu;
			$this->load->view('viewforum', $data);
			$this->load->view('sidebar');
			$this->load->view('footer');
			
		}
		else
		{
			$data['id_for'] = $id;
			$data['query'] = NULL;
			$data['max_pag'] = $max_pags;
			$data['pagina'] = $pagina;
			$data['titulo'] = 'Foro - '.$foro->name;
			$data['nombre_foro'] = $foro->name;
			// Comprobar si es admin
			$data['admin'] = $this->checkadmin();
			// Fin de la comprobacion
			
			//print_r($data['permisos']);
			$this->load->view('header', $data);
			$data['permisos'] = $permisos_usu;
			$this->load->view('viewforum', $data);
			$this->load->view('footer');
		}
	}
	function viewtopic()
	{
			$data['location']= 'foro';
			$pagina = 0;
			$max_per_page = 10;
			// igualando el segmento al numero de pagina a mostrar
			if ($this->uri->segment(5)!= NULL) 
			{
				$pagina = $this->uri->segment(5);
			}
			else 
				$pagina=1;
			$thread = new $this->Thread();
			$thread->get_by_id($this->uri->segment(4));
			$post = $thread->post;
			$foro = $thread->forum->get();
			//$post->order_by("id", "asc");
			$max_pags = ceil($post->count()/$max_per_page);
			$data['permisos'] = $this->checkrights($foro->id);
			if ( $max_pags > 0 && $max_pags >= $pagina)
			{
				$post->limit($max_per_page, ($pagina-1)*$max_per_page )->order_by("id","asc")->get();
				$i = 1;
				$this->load->helper('date');
				foreach ($post->all as $fila) 
				{
					$array[$i]['user'] = $fila->user->get();
					$array[$i]['created'] = unix_to_human(gmt_to_local(local_to_gmt(mysql_to_unix($fila->created)),'UP1', TRUE));
					$array[$i]['content'] = $fila->content;
					$array[$i]['id']= $fila->id;
					$array[$i]['pos_t'] = $fila->pos_t;
					$i++;
				}
				$data['id_thread'] = $this->uri->segment(4);
				$data['max_pag'] = $max_pags;
				$data['pagina'] = $pagina;
				$data['query'] = $array;
				$data['titulo'] = $thread->title;
				$data['link'] = $this->prueba->adapta_link($thread->title);
				$data['foro_id'] = $foro->id;
				$data['foro_name'] = $foro->name;
				// Comprobar si es admin
				$adm = $this->checkadmin();		
				$data['admin'] = $adm;
				// Fin de la comprobacion
				$this->load->view('header', $data);
				$this->bbcode->SetAllowAmpersand(true); 
				$this->load->view('viewtopic', $data);
				$this->load->view('sidebar_topic');
				$this->load->view('footer');
			}
			else
			{
				$data['pagina'] = $pagina;
				$data['query'] = NULL;
				$data['titulo'] = $thread->title;
				// Comprobar si es admin
				$adm = $this->checkadmin();			
				$data['admin'] = $adm;
				// Fin de la comprobacion
				$this->load->view('header',$data);
				$this->load->view('viewtopic', $data);
				$this->load->view('sidebar_topic');
				$this->load->view('footer');
			}
	}
	function send_news()
	{
		$permisos = $this->checkrights($this->input->post('id_forum'));	
		if ($permisos['publicar_como_noticia'] == 1)
		{
			$data['location']= 'foro';
			$data['admin'] = $this->checkadmin();
			$data['titulo'] = 'Enviar Noticia';
			$data['id_thread'] = $this->input->post('id_thread');
			$data['pagina'] = $this->input->post('pagina');
			$data['id_forum'] = $this->input->post('id_forum');
			$data['id_post'] = $this->input->post('id_post');
			$this->load->view('header',$data);
			$this->load->view('send_news',$data);
			$this->load->view('sidebar');
			$this->load->view('footer');
		}
		else die();
	}
	
	
	/*
	 * $dest = './images/thumbs/img.jpg';
		$thumb = imagecreatetruecolor(940,450);
		$src = imagecreatefromjpeg("http://i.imgur.com/x7CDV.jpg");
		$im_src = getimagesize("http://i.imgur.com/x7CDV.jpg");
		imagecopyresized($thumb,$src, 0, 0, 0, 0,940, 450,$im_src[0],$im_src[1]);
		imagepng($thumb,$dest);
	 */
	
	function control_news()
	{
		$permisos = $this->checkrights($this->input->post('id_forum'));
		if ($permisos['publicar_como_noticia']==1)
		{
			$im_src = getimagesize(htmlspecialchars($this->input->post('img_src'),ENT_QUOTES));
			$y = ($im_src[0] * $this->input->post('Iy')) / 600;
			$hei = ($im_src[0] * $this->input->post('hei'))/ 600;
			$width = $this->input->post('width');
			/*if ($im_src[0] > 940)
			{
				$width = 940;
				$height = 450;
			}
			else 
			{
				$width = ($im_src[0] * $this->input->post('width'))/600 ;
				$height = ($im_src[0] * $this->input->post('hei'))/600;
			}*/
			$width = 940;
			$height = 450;
			$thumb = imagecreatetruecolor($width,$height);
			$src = imagecreatefromjpeg(htmlspecialchars($this->input->post('img_src'),ENT_QUOTES));
			$post = new $this->Post();
			$post->get_by_id($this->input->post('id_post'));
			$news = new $this->Notice();
			$news->content = htmlspecialchars($this->input->post('content'),ENT_QUOTES);
			$news->title = htmlspecialchars($this->input->post('title'),ENT_QUOTES);
			$dest ='./images/thumbs/'.$this->prueba->adapta_link($this->input->post('title')).time().'.png';
			if (imagecopyresized($thumb,$src, 0, 0, 0, $y,$width, $height,$im_src[0],$hei))
			{
				imagepng($thumb,$dest);
				$news->image = base_url().'images/thumbs/'.$this->prueba->adapta_link($this->input->post('title')).time().'.png';
			}
			else die('mal mal mal');
			if ($this->input->post('destacada') == 'y')
				$news->destacada = 1;
			$news->save();
			$post->save($news);
			
			$thread = new $this->Thread();
			$thread->get_by_id($this->input->post('id_thread'));
			redirect('/foro/viewtopic/'.$this->prueba->adapta_link($thread->title).'/'.$thread->id.'/'.$this->input->post('pagina'));
		}
		else die('Acceso Prohibido');
	}
	function resize_image() 
	{
		$permisos = $this->checkrights($this->input->post('id_forum'));
		if ($permisos['publicar_como_noticia']==1)
		{
			$data['image_url'] = htmlspecialchars($this->input->post('image'),ENT_QUOTES);
			$data['location'] = "Foro";
			$data['titulo'] = "Recorta imagen";
			$data['id_forum'] = $this->input->post('id_forum');
			$data['id_thread'] = $this->input->post('id_thread');
			$data['id_post'] = $this->input->post('id_post');
			$data['title'] = htmlspecialchars($this->input->post('title'),ENT_QUOTES);
			$data['content'] = htmlspecialchars($this->input->post('content'),ENT_QUOTES);
			$data['pagina'] = $this->input->post('pagina');
			$data['destacada'] = $this->input->post('importante');
			$data['admin'] = $this->checkadmin();
			$this->load->view('header', $data);
			$this->load->view('cropImg');
			$this->load->view('sidebar');
			$this->load->view('footer');
		}
		else die ("Acceso Prohibido");
	}
}
?>
