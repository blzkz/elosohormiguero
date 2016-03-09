<div class='row'>
	<div class="eight columns">
	<h3><?php echo $titulo; ?></h3>
			<?php 
			echo $this->prueba->botonera_post();?>	
			<?php echo form_open('/posting/control_edit/control.php', "class='nice'");
			$tamanyo = array (
						'name' => 'respuesta',
						'id' => 'respuesta',
						'style' => 'width:610px',
						'value' => htmlspecialchars_decode($post->content,ENT_QUOTES),
			);
			echo form_hidden('postId', $post->id);
			echo form_textarea($tamanyo);
			echo form_submit('','Enviar',"class='small radius button'");
		?>
	</div>