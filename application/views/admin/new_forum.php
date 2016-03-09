<?php
	$tamanyo = array (
					'name' => 'Description',
					'rows' => '2',
					'cols' => '30',
				);
	$this->load->helper('form');
	echo form_open('/admin/new_forum_control/');
	echo 'Nombre :';
	echo form_input('Name').'<br />';
	echo 'Descripción: ';
	echo form_textarea($tamanyo).'<br />';
	echo form_submit('','Aceptar');
	echo form_close(); 
?>