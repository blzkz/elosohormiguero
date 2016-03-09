<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Forumrights
{
	public function checkrights ($forum_id)
	{
		if (!$this->session->userdata('nick'))
			return NULL;
		else
		{
			$user = new $this->User();
			$role = new $this->Role();
			$user->get_by_nick($this->session->userdata('nick'));
			$role = $user->role->get();
			$foro = new $this->Forum();
			$foro->get_by_id($forum_id);
					 
		}
	}
	public function identificado()
	{
		if ($this->session->userdata('nick'))
			return true;
		else
			return false;
	}
	public function passEncrypt($password)
	{
		
	}
}