<?php doctype('html5');?>
<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
		<title>login</title>
	</head>
	<body>
	<h3>Login</h3>
	<?php
	if ($this->session->userdata('nick'))
	{
		echo 'Ya estas autenticado';
	}
	else 
	{
		if (isset($error))
		{
			echo "Usuario o contrase�a incorrectos <br />";
		}
		$this->load->helper('form');
		echo form_open('/admin/control/');
		echo form_input('Nick').'<br />';
		echo form_password('Password').'<br />';
		echo form_submit('','Aceptar');
		echo anchor('/register/', 'Registrarse');
		echo form_close();
	}
	?>
	</body>
</html>