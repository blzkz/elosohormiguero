<div class='row'>
	<div class="eight columns">
		<h3>Iniciar sesión</h3>
			<?php
				if ($this->session->userdata('nick'))
				{
					echo 'Ya estas autenticado';
				}
				else 
				{
					if (isset($error))
					{
						echo "Usuario o contraseña incorrectos <br />";
					}
						echo form_open('/login/control/', "class='nice'"); ?>
						<?php echo form_label('Nombre de usuario', 'Nick'); ?>
						<?php echo form_input('Nick','', "class='input-text'"); ?>
						<?php echo form_label('Contraseña', 'Password');
						echo form_password('Password','', "class='input-text'");
						echo form_submit('','Enviar',"class='small radius button'");
						echo form_close();
				}
			?>
	</div>	
