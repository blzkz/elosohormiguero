<div class='row'>
	<div class="eight columns">
		<div id="featured"> 
		<?php foreach ($destacadas as $destacada) {?>
    		<img src="<?php echo $destacada['image'];?>" alt="Overflow: Hidden No More"  width="940" height="450" data-caption="<?php echo '#'.$destacada['id']; ?>" />
    		<?php }?>
		</div>
		<?php foreach ($destacadas as $destacada) {?>
		<span class="orbit-caption" id="<?php echo $destacada['id'];?>"><strong><?php echo $destacada['title'].'.';?> <a href="<?php echo $destacada['url'];?>">leer más</a></strong></span>
		<?php }?>
		<br /><h4>Recientes: </h4>
		<hr />
		<?php
		foreach ($noticias as $noticia)
		{?>
			
			<div class='row'>
				<div class="three columns">
					<p><div style="max-width:120px"><img src='<?php echo $noticia['image']; ?>' ></div></p>
				</div>
				
				<div class="eight columns">
					<?php
						echo '<h4>'.anchor($noticia['url'],$noticia['title']).'</h4>';
						echo $noticia['content']; 
						echo '<p><i>by '.anchor(base_url().'profile/id/'.$noticia['author'],$noticia['author']).'</i></p>'; 
					?>
				</div>
				<hr />
			</div>
			<?php
			
		}
		?><ul class="pagination"><?php
		if ($pagina == 1) 
		{
			?><li class="unavailable"><a href="">&laquo;</a></li>
			<li class="current"><a href="">1</a></li><?php
		}
		else 
		{anchor('/noticias/pagina/1', ' 1 ');
		?><li><?php echo anchor('/noticias/pagina/1', '&laquo;');?></li>
		<li><?php echo anchor('/noticias/pagina/1', '1');?></li><?php 
			if ($pagina > 3) {?><li class="unavailable"><a href="">&hellip;</a></li><?php }
		}
		
		if ($max_pag > 1)
		{
			for ($g=2; $g<=$max_pag; $g++)
			{
				if ($g == $pagina) 
				{
					?><li class="current"><a href=""><?php echo $g;?></a></li><?php
				}
				elseif (($g>=$pagina-2)&&($g<=$pagina+2)) 
				{?>
					<li><?php echo anchor('/noticias/pagina/'.$g,$g);?></li><?php
				}
			}//for
			if ($pagina < $max_pag-2){?><li class="unavailable"><a href="">&hellip;</a></li><?php }
			if ($pagina < $max_pag)
			{
				echo '<li>'.anchor('/noticias/pagina/'.$max_pag, '&raquo;').'</li>';
			}
			else {?><li class="unavailable"><a href="">&raquo;</a></li></ul><?php }
		}
		?>	
	</div>