<?php
class Feed extends CI_Controller
{
	function Feed()
	{
		parent::__construct();
		//$this->load->scaffolding('forums');
	}
	
	function index()
	{
		$noticias = new $this->Notice();
		$noticias->limit(10)->order_by("id","desc")->get();
		$contador = 1;
		$this->load->helper('date');
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
			//$noticias_array[$contador]['date'] = unix_to_human(gmt_to_local(local_to_gmt(mysql_to_unix($noticia->created)),'UP1', TRUE));
			$format = 'DATE_RSS';
			$noticias_array[$contador]['date'] = standard_date($format,mysql_to_unix($noticia->created));
			$contador++;
		}
		$data['noticias']= $noticias_array;
		$this->load->helper('xml');
		header("Content-Type: application/rss+xml; charset=utf-8");
		$this->load->view('feed',$data);
	}
}