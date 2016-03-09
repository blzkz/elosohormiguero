<div class='row'>
	<div class="eight columns">
		<div class='twelve rows'><ul class="pagination">
		<?php
		echo '<li>'.anchor('/foro/', 'Inicio').'</li>';
		?></ul></div><div class='twelve rows'><ul class="pagination"><?php
		if ($permisos['ver_foro'])
		{
			//print_r($query);
			if ($max_pag != 0)
			{
				if ($query != NULL) 
				{
					if ($pagina == 1) {
						?><li class="unavailable"><a href="">&laquo;</a></li>
						<li class="current"><a href="">1</a></li><?php
					}
					else {
						?><li><?php echo anchor('/foro/viewforum/'.$id_for.'/1', '&laquo;');?></li>
						<li><?php echo anchor('/foro/viewforum/'.$id_for.'/1', '1');?></li><?php
						if ($pagina > 3) { ?><li class="unavailable"><a href="">&hellip;</a></li><?php }
					}
					if ($max_pag > 1)
					{
						for ($g=2; $g<=$max_pag; $g++) {
							if ($g == $pagina) {
								?><li class="current"><a href=""><?php echo $g;?></a></li><?php
							}
							elseif (($g>=$pagina-2)&&($g<=$pagina+2)) {
								?><li><?php echo anchor('/foro/viewforum/'.$id_for.'/'.$g,$g);?></li><?php
							}
						}//for
					
						if ($pagina < $max_pag-2){?><li class="unavailable"><a href="">&hellip;</a></li><?php }
						if ($pagina < $max_pag){
							echo '<li>'.anchor('/foro/viewforum/'.$id_for.'/'.$max_pag, '&raquo;').'</li>';
						}
						else {?><li class="unavailable"><a href="">&raquo;</a></li></ul><?php }
					}
					?></div><?php
					echo '<h3>'.$nombre_foro.'</h3>'; 
					foreach ($query as $fila)
					{  
						echo anchor('foro/viewtopic/'.$fila['link'].'/'.$fila['id'], $fila['title']) .'<br />';
						echo 'Autor: '.$fila['user'];
						echo ' Respuestas: '.$fila['n_respuestas'];
						echo '<hr />';
					}
				}
			}
			else {?><div class="alert-box warning">No hay hilos en el foro.</div><?php }
			//if checkrights
			if ($permisos['nuevo_hilo'])
				echo '<br />'.anchor('/posting/thread/'.$id_for, 'Nuevo hilo', "class='small radius button'");
		}
		else {?> <div class="alert-box error">No tiene privilegios para ver este foro.</div><?php }
		?><div class='twelve rows'><ul class="pagination"><?php	
		if ($max_pag != 0)
			{
				if ($query != NULL) 
				{
					if ($pagina == 1) {
						?><li class="unavailable"><a href="">&laquo;</a></li>
						<li class="current"><a href="">1</a></li><?php
					}
					else {
						?><li><?php echo anchor('/foro/viewforum/'.$id_for.'/1', '&laquo;');?></li>
						<li><?php echo anchor('/foro/viewforum/'.$id_for.'/1', '1');?></li><?php
						if ($pagina > 3) { ?><li class="unavailable"><a href="">&hellip;</a></li><?php }
					}
					if ($max_pag > 1)
					{
						for ($g=2; $g<=$max_pag; $g++) {
							if ($g == $pagina) {
								?><li class="current"><a href=""><?php echo $g;?></a></li><?php
							}
							elseif (($g>=$pagina-2)&&($g<=$pagina+2)) {
								?><li><?php echo anchor('/foro/viewforum/'.$id_for.'/'.$g,$g);?></li><?php
							}
						}//for
					
						if ($pagina < $max_pag-2){?><li class="unavailable"><a href="">&hellip;</a></li><?php }
						if ($pagina < $max_pag){
							echo '<li>'.anchor('/foro/viewforum/'.$id_for.'/'.$max_pag, '&raquo;').'</li>';
						}
						else {?><li class="unavailable"><a href="">&raquo;</a></li></ul><?php }
					}
				}
			}	?>
		</div>
		</div>
