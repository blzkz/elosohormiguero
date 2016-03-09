<?php
if ($this->session->userdata('nick'))
{?>
<?php doctype('html5');?>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $titulo;?></title>
</head>
<body>
	Está identificado como
	<?php echo $this->session->userdata('nick');?>
	<?php echo ' ('.anchor('/login/logout/','Logout').')';?>
	<?php echo ' '.anchor('/foro/', 'Inicio foro').'<br />'?>
	<?php
}
else
	redirect('/foro/');
	?>
<div style="height: 60px;  text-align: center">
	<div style="height: 50px; width: 195px; float: left;">
	<?php echo anchor('/admin/', 'Inicio')?>
	</div>
	<div style="height: 50px; width: 195px; float: left;">
	<?php echo anchor('/admin/users/', 'Usuarios')?>
	</div>
	<div style="height: 50px; width: 195px; float: left;">
	<?php echo anchor('/admin/forums/', 'Foros')?>
	</div>
	<div style="height: 50px; width: 195px; float: left;">
	<?php echo anchor('/admin/permissions/', 'Permisos')?>
	</div>
	<div style="height: 50px; width: 195px; float: left;">
	<?php echo anchor('/admin/roles/', 'Roles')?>
	</div>
</div>