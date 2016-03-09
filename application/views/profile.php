<div class='row'>
	<div class="eight columns">
		<h4>Perfil de <?php echo $user->nick; ?></h4>
		<div class="row">
			<div class="three columns">
				<img src="<?php if ($user->avatar == NULL) {
					echo base_url().'images/avatars/no_AV_120.png';}
					else {echo base_url().'images/avatars/'.$user->avatar; }?>">
			</div>
			<div class="six columns">
				<p>Nombre: <?php echo $user->name; ?></p>
				<p>Respuestas: <?php echo $user->post;?></p>
				<p>Noticias: </p>
				<?php if($modificar) echo anchor(base_url().'profile/edit','Modificar',"class='small radius button'");?>
			</div>
		</div>
		<div class="panel">
			<h5>Bio</h5>
			<p><?php echo $user->bio;?></p>
		</div>
	</div>