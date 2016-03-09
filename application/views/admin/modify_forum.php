<h1>
<?php
echo $titulo.' <br /></h1>';
echo form_open('/admin/applied_forum/'.$foro->id);
foreach ($permisos->all as $permiso)
{
	echo $permiso->name.' ';
	echo form_dropdown($permiso->name, $roles).' ';
}
echo form_hidden('enviado','true');
echo '<br />'.form_submit('','Enviar');
echo form_close();
?>