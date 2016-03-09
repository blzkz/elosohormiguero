<?php
class Noticias extends CI_Controller
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
		$data['titulo'] = 'El Oso Hormiguero - Web de series y más';
		$data['admin']= $this->checkadmin();
		$data['location'] = 'portada';
		$pagina = $this->uri->segment(3);
		if ($pagina === FALSE)
		{
			$pagina = 1;
		}
		// DESTACADAS
		$destacadas = new $this->Notice;
		$destacadas->where('destacada', 1);
		$destacadas->limit(5);
		$destacadas->order_by('id', 'desc');
		$destacadas->get();
		
		$cont = 1;
		foreach ($destacadas->all as $destacada)
		{
			$post = new $this->Post();
			$post = $destacada->post;
			$post->get();
			$thread = $post->thread->get();
			$nome = base_url()."foro/viewtopic/".$this->prueba->adapta_link($thread->title)."/".$thread->id."/".ceil(($post->pos_t)/10)."/#".$post->pos_t;
			$dest_array[$cont]['title'] = $destacada->title;
			$dest_array[$cont]['url'] = $nome;
			$dest_array[$cont]['image'] = $destacada->image;
			$dest_array[$cont]['id'] = $destacada->id;
			$cont++;
		}
		//print_r($dest_array);
		$data['destacadas'] = $dest_array;
		// FIN DESTACADAS
		$desde = (($pagina-1)*10);
		$max_per_page = 10;
		$noticias = new $this->Notice();
		$total = $noticias->count();
		$noticias = new $this->Notice();
		$noticias->limit($max_per_page, $desde);
		$noticias->order_by("id", "desc");
		$data['admin']= $this->checkadmin();
		$data['max_pag'] = ceil( ($total/$max_per_page));
		$data['pagina'] = $pagina;
		$noticias->get();
		//print_r($noticias->all);
		//$data['noticias'] = $noticias;
		// PROBAR Y TERMINAR ESTO
		$contador = 1;
		foreach ($noticias->all as $noticia) {
			$post = new $this->Post();
			$post = $noticia->post;
			$post->get();
			$thread = $post->thread->get();
			$autor = $post->user->get();
			$nomejodas = base_url()."foro/viewtopic/".$this->prueba->adapta_link($thread->title)."/".$thread->id."/".ceil(($post->pos_t)/10)."/#".$post->pos_t;
			$noticias_array[$contador]['title'] = $noticia->title;
			$noticias_array[$contador]['content'] = $noticia->content;
			$noticias_array[$contador]['author'] = $autor->nick;
			$noticias_array[$contador]['image'] = $noticia->image;
			$noticias_array[$contador]['url'] = $nomejodas;
			$contador++;
		}
		//print_r($noticias_array);
		$data['noticias'] = $noticias_array;
		$this->load->View('header', $data);
		$this->load->View('news', $data);
		$this->load->View('sidebar');
		$this->load->view('footer');
	}
	
	function pagina()
	{
	$data['titulo'] = 'El Oso Hormiguero - Web de series y más';
		$data['admin']= $this->checkadmin();
		$data['location'] = 'portada';
		$pagina = $this->uri->segment(3);
		if ($pagina === FALSE)
		{
			$pagina = 1;
		}
		// DESTACADAS
		$destacadas = new $this->Notice;
		$destacadas->where('destacada', 1);
		$destacadas->limit(5);
		$destacadas->order_by('id', 'desc');
		$destacadas->get();
		
		$cont = 1;
		foreach ($destacadas->all as $destacada)
		{
			$post = new $this->Post();
			$post = $destacada->post;
			$post->get();
			$thread = $post->thread->get();
			$nome = base_url()."foro/viewtopic/".$this->prueba->adapta_link($thread->title)."/".$thread->id."/".ceil(($post->pos_t)/10)."/#".$post->pos_t;
			$dest_array[$cont]['title'] = $destacada->title;
			$dest_array[$cont]['url'] = $nome;
			$dest_array[$cont]['image'] = $destacada->image;
			$dest_array[$cont]['id'] = $destacada->id;
			$cont++;
		}
		//print_r($dest_array);
		$data['destacadas'] = $dest_array;
		// FIN DESTACADAS
		$desde = (($pagina-1)*10);
		$max_per_page = 10;
		$noticias = new $this->Notice();
		$total = $noticias->count();
		$noticias = new $this->Notice();
		$noticias->limit($max_per_page, $desde);
		$noticias->order_by("id", "desc");
		$data['admin']= $this->checkadmin();
		$data['max_pag'] = ceil( ($total/$max_per_page));
		$data['pagina'] = $pagina;
		$noticias->get();
		//print_r($noticias->all);
		//$data['noticias'] = $noticias;
		// PROBAR Y TERMINAR ESTO
		$contador = 1;
		foreach ($noticias->all as $noticia) {
			$post = new $this->Post();
			$post = $noticia->post;
			$post->get();
			$thread = $post->thread->get();
			$autor = $post->user->get();
			$nomejodas = base_url()."foro/viewtopic/".$this->prueba->adapta_link($thread->title)."/".$thread->id."/".ceil(($post->pos_t)/10)."/#".$post->pos_t;
			$noticias_array[$contador]['title'] = $noticia->title;
			$noticias_array[$contador]['content'] = $noticia->content;
			$noticias_array[$contador]['author'] = $autor->nick;
			$noticias_array[$contador]['image'] = $noticia->image;
			$noticias_array[$contador]['url'] = $nomejodas;
			$contador++;
		}
		//print_r($noticias_array);
		$data['noticias'] = $noticias_array;
		$this->load->View('header', $data);
		$this->load->View('news', $data);
		$this->load->View('sidebar');
		$this->load->view('footer');
	}
}