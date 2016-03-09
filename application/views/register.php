<div class='row'>
	<div class="eight columns">
	<div class="six columns">
		<h3>Registro</h3>
		<?php
		if ($logged)
		{
			echo 'Ya estas autenticado';
		}
		else 
		{
			if (isset($error))
			{
				if ($error == 1)
				{?>
				<div class="alert-box error">
					Nombre de usuario ya en uso, intente otro.
				</div>
				<?php }
				else if ($error == 2)
				{?>
				<div class="alert-box error">
					Email ya en uso, intente otro.
				</div>
				<?php }
				else if ($error == 3)
				{ ?>
				<div class="alert-box error">
					Email incorrecto, intente otro.
				</div>
				<?php }
				else { ?>
				<div class="alert-box error">
					reCaptcha incorrecto.
				</div>
				<?php 
				}
			}
				echo form_open('/register/control/', "class='nice'");
				echo form_label('Nombre de usuario', 'nickname');
				echo form_input('nickname','', "class='input-text'");
				echo form_label('email', 'email');
				echo form_input('email','', "class='input-text'");
				echo form_label('contraseña','password');
				echo form_password('password','', "class='input-text'");
				//require_once(base_url().'captcha/recaptchalib.php');
				$this->load->view('recaptchalib');
  				$publickey = "6Le1NcwSAAAAAFxe7XqesTB_F-jLr5xM_M-fAk9u"; // you got this from the signup page
  				echo recaptcha_get_html($publickey);
				echo form_submit('','Aceptar',"class='small radius button'");
				echo form_close();
		}
			?>
			<p>Al registrarte aceptas las normas de uso, asi como la <a href="http://www.elosohormiguero.es/legal">información legal</a>.
	</div>
	</div>