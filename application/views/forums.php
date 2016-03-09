<div class='row'>
	<div class="eight columns">
	<h3>Foros</h3>
		<?php		
		foreach ($query->all as $fila)
		{ 
			if ($permisos[$fila->id]['ver_foro'] == 1) {?>
				<?php 
				echo '<h5>'.anchor('foro/viewforum/'.$fila->id, $fila->name).'</h5>';
	        	echo $fila->description;?>
				<hr />
				<?php 
			}
		}
		?>
	</div>
