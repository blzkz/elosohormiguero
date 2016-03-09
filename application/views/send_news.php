<div class='row'>
	<div class="eight columns">
	<h4>Enviar noticia</h4>
		<?php
		$this->load->helper('form');
		echo form_open('/foro/resize_image/control.php', "class='nice'");
		$tamanyo = array (
						'name' => 'content',
						'style' => 'width:610px',
			);
		echo form_hidden('id_forum', $id_forum);
		echo form_hidden('id_thread', $id_thread);
		echo form_hidden('id_post', $id_post);
		echo form_hidden('pagina', $pagina);
		echo form_label ('Título','title'); 
		echo form_input('title','',"class='large input-text'");
		echo form_label('url imagen','image');
		echo form_input('image','',"class='large input-text'");
		echo form_label ('Breve descripción','content');
		echo form_textarea($tamanyo);?>
		<div class='row'>
			<div class='three columns'>
		<?php echo form_label('Destacada:', 'importante'); ?>
			</div>
			<div class='eight columns'>
		<?php echo form_checkbox('importante','importante', FALSE); ?>
			</div>
		</div>
		<?php  echo br();
		echo form_submit('','Enviar',"class='small radius button'");
		?>
	</div>