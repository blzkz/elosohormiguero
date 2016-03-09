<?php
//echo anchor('/admin/new_role/', 'Nuevo Rol');
if ($query != NULL)
{ ?><div style="position:absolute;">
	<div style="position:relative;  width: 401px; border:1px solid #000000; font-family:Lucida Grande,Verdana,Arial,Bitstream Vera Sans,sans-serif;">
		<div style="width: 130px;  height: 60px; float:left; padding: 5px 10px 5px 10px;background-color: #f2f2f2;">Permiso</div>
		<div style="width: 230px;  height: 60px; float:left; border-left:1px solid #000000; padding: 5px 10px 5px 10px;background-color: #f2f2f2;">Opciones</div>
	<?php foreach ($query->all as $fila)
	{?>

			<div style="width: 130px; height: 70px; float:left; border-top:1px solid #000000; padding: 5px 10px 5px 10px;"><?php echo $fila->name;?></div>
			<div style="width: 230px; height: 70px; float:left;border-left:1px solid #000000 ;border-top:1px solid #000000; padding: 5px 10px 5px 10px;">Modificar Borrar</div>
	<?php }?>
	</div>
	<?php
	
}
else
	echo 'No hay permisos';
?>
	<div style="position:relative;">
	<?php 
	$this->load->helper('form');
	echo form_open('/admin/new_right/');
	echo form_label('Nombre: ').'<br />';
	echo form_input('name').'<br />';
	echo form_submit('','Enviar');
?>
</div>
</div>
