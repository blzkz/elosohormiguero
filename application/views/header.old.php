<?php doctype('html5');?>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $titulo;?></title>
</head>
<body>
<?php
if ($this->session->userdata('nick'))
{?>
	Est� identificado como
	<?php echo $this->session->userdata('nick');?>
	<?php echo ' ('.anchor('/login/logout/','Logout').')<br />';?>
	<?php
}
else
{ ?>
	No est� identificado...
	<?php echo anchor('/login/', 'Login').' '.anchor('/register/', 'Registrarme <br />');?>
	<?php }?>