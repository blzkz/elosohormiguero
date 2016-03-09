<div class='row'>
	<div class="eight columns">
		<?php
		if (isset($error))
		{
			if ($error === 1)
			{ 
				echo 'debe estar autencticado, '.anchor('/foro/viewtopic/'.$thread.'/'.$id.'/'.$pagina, 'Volver');
			}
			elseif ($error === 2)
			{
				echo "No tiene permisos para responder.";
			}
		}
		else 
		{
			?><h3><?php echo $titulo; ?></h3>
			<?php 
			echo $this->prueba->botonera_post();?>	
			<?php echo form_open('/posting/control/control.php', "class='nice'");
			$tamanyo = array (
						'name' => 'respuesta',
						'id' => 'respuesta',
						'style' => 'width:610px',
			);
			echo form_hidden('id', $id);
			echo form_textarea($tamanyo);
			echo form_submit('','Enviar',"class='small radius button'");
		}
		?>
	</div>