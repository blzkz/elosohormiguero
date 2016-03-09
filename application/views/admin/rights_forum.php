<?php
echo form_open('admin/rights_forum');
echo form_hidden('modificado', TRUE);
echo form_hidden('foro_id', $foro->id)?>
<div style='position:absolute; margin-top:50px;'>
	<div style='position:relative; width:600px'>
		<div style='width:300px; float:left;'>Permiso</div>
		<div style='width:300px; float:left;'>Rol</div>
		<?php foreach ($permisos->all as $fila)
		{?>
		<div style='width:300px';><?php echo $fila->name.' '; echo form_multiselect($fila->name.'[]', $roles);?></div>
		<?php 
		} 
		?>
	</div>
<?php 
echo form_submit('Submit','Enviar');
?>
</div>
