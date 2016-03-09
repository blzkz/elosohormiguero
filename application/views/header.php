<?php echo doctype('html5');?>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title><?php echo $titulo;?></title>
	<link rel="shortcut icon" href="<?php echo base_url();?>images/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo base_url()/*.APPPATH*/; ?>css/foundation.css">
	<link rel="stylesheet" href="<?php echo base_url()/*.APPPATH*/; ?>css/app.css">
	<meta name="google-site-verification" content="C_SCgDve4oWancfQeqrJw6-1KLqi2lUBTfg2YfSrG-c" />
	<!--[if lt IE 9]>
		<link rel="stylesheet" href="stylesheets/ie.css">
	<![endif]-->

	
	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src='<?php echo base_url(); ?>js/foundation.js'></script>
	<script src='<?php echo base_url(); ?>js/app.js'></script>
	<script src='<?php echo base_url(); ?>js/oso.js'></script>	
	
	<script type="text/javascript">
     $(window).load(function() {
         $('#featured').orbit({
        	 timer: true,
        	 directionalNav: false
         });
     });
	</script>
	<!-- GOOGLE ANALYTICS -->
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28528224-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!-- GOOGLE ANALYTICS -->

</head>
<body>
<div id="custom" class="container">
	<div class="row">
		<?php
				if ($this->session->userdata('nick'))
				{?>
					Está identificado como
					<?php echo anchor(base_url().'profile/id/'.$this->session->userdata('nick'),
					$this->session->userdata('nick'),"class='small grey button' id='white-link'");?>
					<?php echo anchor('/login/logout/','Logout',"class='small grey button' id='white-link'");?>
					<?php
				}
				else
				{ ?>
					No está identificado...
					<?php echo anchor('/login/', 'Login',"class='small grey button' id='white-link'").' '.anchor('/register/', 'Registrarme',"class='small grey button' id='white-link'");?>
					<?php }?>
	</div>
</div>
	<div id="body" class="container">
		<div class="row">
			<p><div class="row">
				<div class="four columns offset-by-one">
					<img src="<?php echo base_url();?>images/oso_resources/oso.png">
				</div>
			</div></p>
			<div class="twelve columns">
					<dl class="nice tabs">
					  <dd><a href="<?php echo base_url();?>" <?php if ($location === 'portada') { ?>class="active"<?php }?>>Portada</a></dd>
					  <dd><a href="<?php echo base_url();?>foro" <?php if ($location === 'foro') { ?>class="active"<?php }?>>Foro</a></dd>
					  <dd><a href="<?php echo base_url();?>about" <?php if ($location === 'about') { ?>class="active"<?php }?>>About</a></dd>
					  <?php if ($admin) { ?><dd><a href="<?php echo base_url()?>admin" <?php if ($location === 'admin') { ?>class="active"<?php }?>>P.Adm</a></dd> <?php } ?>
					</dl>
