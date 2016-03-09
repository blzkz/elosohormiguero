<?php
echo form_open('admin/roles_user_control');
echo form_hidden('modificado', TRUE);
echo form_hidden('user_id', $usuario->id)?>
<div style='position:absolute; margin-top:50px;'>
	<div style='position:relative; width:600px'>
		<div style='width:300px; float:left;'>Usuario</div>
		<div style='width:300px; float:left;'>Rol</div>
		<div style='width:300px';><?php echo $usuario->name.' '; echo form_multiselect('roles[]', $roles);?></div>
	</div>
<?php 
echo form_submit('Submit','Enviar');
?>
</div>
