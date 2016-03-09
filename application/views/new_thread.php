<div class='row'>
	<div class="eight columns">
		<?php
		if (isset($error))
		{?>
			<div class="alert-box error">No tiene privilegios suficientes para realizar la acción.</div>
		<?php }
		else 
		{
			echo '<h3>'.$titulo.' </h3>';
			$this->load->helper('form');
			echo $this->prueba->botonera_post();
			echo form_open('/posting/control_t/control.php', "class='nice'");
			?><strong><?php echo form_label('Título', 'titulo');?></strong><?php 
			echo form_input('titulo','',"class='large input-text'");
			$tamanyo = array (
						'name' => 'contenido',
						'id' => 'respuesta',
						'style' => 'width:610px',
			);
			echo form_hidden('id', $id);
			echo form_textarea($tamanyo);
			echo form_submit('','Enviar',"class='small radius button'");
		}
		?>
	</div>
