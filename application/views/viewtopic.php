<div class='row'>
	<div class='nine columns'>
		<ul class="pagination">
		 <li><?php echo anchor('/foro/', 'Inicio');?></li>
		 <li class="unavailable"><a href="">&raquo;</a></li>
		 <li> <?php echo anchor('/foro/viewforum/'.$foro_id,$foro_name);?></li></ul>
		<div class='twelve rows'><ul class="pagination"><?php
		if ($permisos['ver_foro'])
		{
			//print_r($query);
			$i = 1+(($pagina-1)*10);
			if ($query != NULL) {
					if ($pagina == 1) {
						?><li class="unavailable"><a href="">&laquo;</a></li>
						<li class="current"><a href="">1</a></li><?php
					}
					else {
						?><li><?php echo anchor('/foro/viewtopic/'.$link.'/'.$id_thread.'/1', '&laquo;');?></li>
						<li><?php echo anchor('/foro/viewtopic/'.$link.'/'.$id_thread.'/1', '1');?></li><?php 
						if ($pagina > 3) {?><li class="unavailable"><a href="">&hellip;</a></li><?php }
					}
				if ($max_pag > 1)
				{
					for ($g=2; $g<=$max_pag; $g++) {
						if ($g == $pagina) {
							?><li class="current"><a href=""><?php echo $g;?></a></li><?php
						}
						elseif (($g>=$pagina-2)&&($g<=$pagina+2)) {?>
						
							<li><?php echo anchor('/foro/viewtopic/'.$link.'/'.$id_thread.'/'.$g,$g);?></li><?php
						}
					}//for
					if ($pagina < $max_pag-2){?><li class="unavailable"><a href="">&hellip;</a></li><?php }
					if ($pagina < $max_pag){
							echo '<li>'.anchor('/foro/viewtopic/'.$link.'/'.$id_thread.'/'.$max_pag, '&raquo;').'</li>';
					}
					else {?><li class="unavailable"><a href="">&raquo;</a></li></ul><?php }
				}
				?></div>
				<h2><?php echo $titulo;?></h2><?php
			 foreach ($query as $fila)
			 { ?>
			<div class='panel'>
				<div class='row'>
					<div class='three columns'>
						<p><?php echo anchor(base_url().'profile/id/'.$fila['user']->nick,$fila['user']->nick);?></p>
						<p><img src="<?php if ($fila['user']->avatar == NULL) {
						echo base_url().'images/avatars/no_AV_120.png';}
						else {echo base_url().'images/avatars/'.$fila['user']->avatar; }?>"></p>
					</div>
					<div class='nine columns'>
						<div class='row'>
						<div class='eight columns'>
						<a name="<?php echo $fila['pos_t']; ?>">
						<?php echo '#'.$fila['pos_t'];?></a><?php echo '  '.$fila['created'];?>
						</div>
						<?php if ($permisos['publicar_como_noticia']) 
						{
							echo form_open('/foro/send_news/');
							echo form_hidden('id_post', $fila['id']);
							echo form_hidden('id_thread', $id_thread);
							echo form_hidden('id_forum', $foro_id);
							echo form_hidden('pagina', $pagina);?>
							<a onclick="javascript:this.parentNode.submit();"><img alt="Enviar noticia" src="<?php echo base_url();?>/images/oso_resources/news_icon.jpg"></a>
							<?php //echo form_submit('','Enviar noticia',"class='small radius button'");
							echo form_close();
						}?>
						<?php 
						if ($permisos['editar_respuesta'] || ($fila['user']->nick === ($this->session->userdata('nick'))))
						{?>
							<a alt="editar" href="<?php echo base_url();?>posting/edit/<?php echo $fila['id'];?>"><img alt="editar" src="<?php echo base_url();?>/images/oso_resources/edit_icon.jpg"></a>
						<?php }
						?>
						</div>
						<?php  					 
						echo '<hr><p>'.$this->bbcode->Parse($fila['content']).'</p>';
					  	
						?>
					</div>
				</div> 
			</div>
				<?php 
				$i++;
			 } 
			 if ($permisos['nueva_respuesta'])
			 {
			 	echo anchor('/posting/replay/'.$id_thread, 'Responder', "class='small radius button'");
			 }
			}
		}
		else 
		{?> <div class="alert-box error">No tiene privilegios para ver este foro.</div><?php }?>
		<div class='twelve rows'><ul class="pagination"><?php
		if ($permisos['ver_foro'])
		{
			//print_r($query);
			$i = 1+(($pagina-1)*10);
			if ($query != NULL) {
					if ($pagina == 1) {
						?><li class="unavailable"><a href="">&laquo;</a></li>
						<li class="current"><a href="">1</a></li><?php
					}
					else {
						?><li><?php echo anchor('/foro/viewtopic/'.$link.'/'.$id_thread.'/1', '&laquo;');?></li>
						<li><?php echo anchor('/foro/viewtopic/'.$link.'/'.$id_thread.'/1', '1');?></li><?php 
						if ($pagina > 3) {?><li class="unavailable"><a href="">&hellip;</a></li><?php }
					}
				if ($max_pag > 1)
				{
					for ($g=2; $g<=$max_pag; $g++) {
						if ($g == $pagina) {
							?><li class="current"><a href=""><?php echo $g;?></a></li><?php
						}
						elseif (($g>=$pagina-2)&&($g<=$pagina+2)) {?>
						
							<li><?php echo anchor('/foro/viewtopic/'.$link.'/'.$id_thread.'/'.$g,$g);?></li><?php
						}
					}//for
					if ($pagina < $max_pag-2){?><li class="unavailable"><a href="">&hellip;</a></li><?php }
					if ($pagina < $max_pag){
							echo '<li>'.anchor('/foro/viewtopic/'.$link.'/'.$id_thread.'/'.$max_pag, '&raquo;').'</li>';
					}
					else {?><li class="unavailable"><a href="">&raquo;</a></li></ul><?php }
				}
			}
		}
				?></div>
	</div>	