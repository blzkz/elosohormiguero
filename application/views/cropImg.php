<div class='row'>
	<div class="eight columns">
	<script src='<?php echo base_url(); ?>js/jquery.min.js'></script>
	<script src='<?php echo base_url(); ?>js/jquery.Jcrop.js'></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.Jcrop.css" type="text/css" />
	<!-- Inicializamos Jcrop -->
	<script language="Javascript">	
	    jQuery(function($) {
	        $('#jcrop').Jcrop({
	        	aspectRatio: 940/450,
	        	minSize: [600,0],
	        	setSelect: [ 0, 0, 600, 50 ],
	            onChange: showCoords,
	            onSelect: showCoords
	        });
	    });	
	    function showCoords(c)
		{
			$('#x').val(c.x);
			$('#Iy').val(c.y);
			$('#fx').val(c.x2);
			$('#fy').val(c.y2);
			$('#width').val(c.w);
			$('#hei').val(c.h);
		};
		</script>
		<!-- fin Jcrop -->
	<h3>Recortar imagen</h3>
	<?php echo form_open('/foro/control_news/control.php');?>
		<div style="width:600px">
			<img src="<?php echo $image_url;?>" id="jcrop" />
		</div>
		<input type="hidden" id="fx" name="fx">
		<input type="hidden" id="Iy" name="Iy">
		<input type="hidden" id="fy" name="fy">
		<input type="hidden" id="width" name="width">
		<input type="hidden" id="hei" name="hei">
		<input type="hidden" id="id_forum" name = "id_forum" value="<?php echo $id_forum;?>">
		<input type="hidden" id="id_thread" name="id_thread" value="<?php echo $id_thread;?>">
		<input type="hidden" id="id_post" name="id_post" value="<?php echo $id_post;?>">
		<input type="hidden" id="title" name="title" value="<?php echo $title;?>">
		<input type="hidden" id="content" name="content" value="<?php echo $content;?>">
		<input type="hidden" id="pagina" name="pagina" value="<?php echo $pagina;?>">
		<?php if ($destacada) {?>
		<input type="hidden" id="destacada" name="destacada" value="y">
		<?php }
		else {?>
		<input type="hidden" id="destacada" name="destacada" value="n">
		<?php } ?>
		<input type="hidden" id="img_src" name = "img_src" value="<?php echo $image_url;?>">
		<?php echo form_submit('','Aceptar',"class='small radius button'");?>
	<?php
	echo form_close(); 
	//print_r(getimagesize($image_url));?>
	</div>