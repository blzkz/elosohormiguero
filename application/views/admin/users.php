<?php 
echo 'Total registrados: '.$num_us;
if ($query != NULL)
{ ?>
	<div style="position:absolute; width: 1000px; border:1px solid #000000; font-family:Lucida Grande,Verdana,Arial,Bitstream Vera Sans,sans-serif;">
		<div style="width: 230px;  float:left; padding: 5px 10px 5px 10px;background-color: #f2f2f2;">Usuario</div>
		<div style="width: 478px;  float:left; border-left:1px solid #000000; padding: 5px 10px 5px 10px;background-color: #f2f2f2;">E-mail</div>
		<div style="width: 230px;  float:left; border-left:1px solid #000000; padding: 5px 10px 5px 10px;background-color: #f2f2f2;">Opciones</div>
	<?php foreach ($query->all as $fila)
	{?>

			<div style="width: 230px; float:left; border-top:1px solid #000000; padding: 5px 10px 5px 10px;"><?php echo $fila->nick;?></div>
			<div style="width: 478px; float:left;border-left:1px solid #000000; border-top:1px solid #000000; padding: 5px 10px 5px 10px;"><?php echo $fila->email?></div>
			<div style="width: 230px; float:left;border-left:1px solid #000000 ;border-top:1px solid #000000; padding: 5px 10px 5px 10px;">
			<?php echo anchor('/admin/roles_user/'.$fila->id, 'Roles').' ';?>Modificar Borrar</div>
	<?php }?>
	</div>
	<?php
	
}

?>