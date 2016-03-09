<?php
echo anchor('/admin/new_role/', 'Nuevo Rol');
if ($query != NULL)
{ ?>
	<div style="position:absolute;  width: 975px; border:1px solid #000000; font-family:Lucida Grande,Verdana,Arial,Bitstream Vera Sans,sans-serif;">
		<div style="width: 130px;  height: 60px; float:left; padding: 5px 10px 5px 10px;background-color: #f2f2f2;">Foro</div>
		<div style="width: 380px;  height: 60px; float:left; border-left:1px solid #000000; padding: 5px 10px 5px 10px;background-color: #f2f2f2;">Descripción</div>
		<div style="width: 150px;  height: 60px; float:left; border-left:1px solid #000000; padding: 5px 10px 5px 10px;background-color: #f2f2f2;">Color</div>
		<div style="width: 230px;  height: 60px; float:left; border-left:1px solid #000000; padding: 5px 10px 5px 10px;background-color: #f2f2f2;">Opciones</div>
	<?php foreach ($query->all as $fila)
	{?>

			<div style="width: 130px; height: 70px; float:left; border-top:1px solid #000000; padding: 5px 10px 5px 10px;"><?php echo $fila->name;?></div>
			<div style="width: 380px; height: 70px; float:left;border-left:1px solid #000000; border-top:1px solid #000000; padding: 5px 10px 5px 10px;"><?php echo $fila->description?></div>
			<div style="width: 150px; height: 70px; float:left;border-left:1px solid #000000; border-top:1px solid #000000; padding: 5px 10px 5px 10px;"><?php echo 'Sin color'?></div>
			<div style="width: 230px; height: 70px; float:left;border-left:1px solid #000000 ;border-top:1px solid #000000; padding: 5px 10px 5px 10px;">Modificar Borrar</div>
	<?php }?>
	</div>
	<?php
	
}	
?>