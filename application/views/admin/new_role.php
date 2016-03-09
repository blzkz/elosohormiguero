<?php
	$tamanyo = array (
					'name' => 'description',
					'rows' => '2',
					'cols' => '30',
				);
	$options = array(
                  '1'  => 'User',
                  '10'    => 'Editor',
                  '100'   => 'Moderador',
                  '1000' => 'Administrador',
                );			
	$this->load->helper('form');
	echo form_open('/admin/new_role/');
	echo 'Nombre :';
	echo form_input('name').'<br />';
	echo 'Descripción: ';
	echo form_textarea($tamanyo).'<br />';
	echo 'Color: ';
	echo form_input('color').'<br />';
	echo 'Tipo: ';
	echo form_dropdown('value', $options);
	echo form_hidden('Done', true);
	echo form_submit('','Aceptar');
	echo form_close(); 
?>