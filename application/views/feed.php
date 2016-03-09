<?php 
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
?>
<rss version="2.0"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">
<channel>
		<title>El Oso Hormiguero</title>
		<link>http://www.elosohormiguero.es/</link>
		<description>Web de series, peliculas y música</description>
		<language>es</language>
		<sy:updatePeriod>hourly</sy:updatePeriod>
		<sy:updateFrequency>1</sy:updateFrequency>
		<atom:link href="http://www.elosohormiguero.es/feed" rel="self" type="application/rss+xml" />

<?php  foreach ($noticias as $noticia) {?>
	<item>
		<title><?php echo xml_convert(htmlspecialchars_decode($noticia['title'], ENT_QUOTES));?></title>
		<guid><?php echo $noticia['url'];?></guid>
		<dc:creator><?php echo xml_convert($noticia['author']);?></dc:creator>
		<pubDate><?php echo $noticia['date'];?></pubDate>
		<description><![CDATA[
		<img src="<?php echo $noticia['image'];?>">
		<?php echo "<br>".xml_convert($noticia['content']);?>
		]]></description>
		
		
	</item>
<?php }?>

</channel>
</rss>