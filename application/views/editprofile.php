<div class='row'>
	<div class="eight columns">
		<h3>Modificar perfil</h3>
		<?php
		echo form_open_multipart('/profile/control/control.php', "class='nice'"); 
		echo form_label('Avatar (máximo 120x120 y 20kb)', 'avatar');
		echo form_upload('avatar','', "class='input-text'");
		echo form_label('Nombre', 'name');
		echo form_input('name',$user->name, "class='input-text'"); 
		echo form_label('Bio', 'Bio');
		$tamanyo = array (
						'name' => 'bio',
						'style' => 'width:610px',
						'value' => $user->bio,
		);
		echo form_textarea($tamanyo);
		echo form_hidden('nick', $user->nick);
		echo form_submit('','Enviar',"class='small radius button'");
		echo form_close();
		?>
	</div>
