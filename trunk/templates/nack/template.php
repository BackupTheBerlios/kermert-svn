<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
     <title><?php km_config('sitename');?></title>
     <link href="<?php km_config('themeurl');?>/style.css" rel="stylesheet" type="text/css" />
     <link rel="alternate" type="application/rss+XML" title="RSS 2.0" href="index.php?x=rss" />
     <script language='javascript' type='text/javascript'>
     <!-- BEGIN
     function flip(rid)
     {
     current=(document.getElementById(rid).style.display == 'none') ? 'block' : 'none';
     document.getElementById(rid).style.display = current;
     }
     function alternate()
     {
     alpha=(document.getElementById('centered').style.display == 'none') ? 'block' : 'none';
     beta=(document.getElementById("wrapper").style.display == 'none') ? 'block' : 'none';
     //alert(alpha);
     document.getElementById("centered").style.display = alpha;
     document.getElementById("wrapper").style.display = beta;
     }
     // End -->
     </script>
</head>
<body>
<div id="wrapper">
     <div id="background">
          <div id="content">
               <a href="<?php km_config();?>"><img src="<?php km_config('themeurl');?>/images/headers/header_inthebox.jpg" width="600" alt="Aspirant Artiste Photoblog"/></a>
               <br />
<?php
if($mode=='image')
{
     include(km_appdir.km_themesdir.km_theme.'/image.php');
}
elseif($mode=='archives')
{
     include(km_appdir.km_themesdir.km_theme.'/archives.php');
}
?>
        </div>
        </div>
        <div id="metabar">
            				<p>
				<a href='http://www.photoblogs.org/'><img src='http://buttons.photoblogs.org/photoblogs.gif' alt='Photoblogs.org' title='Photoblogs.org' border='0' /></a>
				<a href='http://www.photoblogs.org/profile/aspirantartiste.free.fr/'><img src='http://buttons.photoblogs.org/listed.gif' alt='View My Profile' title='View My Profile' border='0' /></a>

				<a href="http://www.photoblogring.org"><img src="http://www.uncommondepth.com/images/photoblogring.gif" alt="Photoblog ring" border="0"/></a>
				<a href="http://www.ringsurf.com/netring?ring=aporeality;action=addform">Join</a> |
				<a href="http://www.ringsurf.com/netring?ring=aporeality;action=rand">Random</a> |
				<a href="http://www.ringsurf.com/netring?ring=aporeality;action=list">List</a>
			</p>
<p>

<a href="http://www.paname-ensemble.com/" title="Blog Metro"><img width=80 src="http://www.paname-ensemble.com/paris-fr/images/metro/mini_ban_pe_moyen.gif" border=0></a>
<a href="http://www.paname-ensemble.com/paris-fr/php/metro/liste_blog_ligne.php?nb_ligne=12"><img src="http://www.paname-ensemble.com/paris-fr/images/metro/ligne12.gif" border=0></a><a href="http://www.paname-ensemble.com/paris-fr/php/metro/liste_blog_ligne.php?nb_ligne=C">
<img src="http://www.paname-ensemble.com/paris-fr/images/metro/rer_c.gif" border=0></a>

<a href="http://www.ebtb.info/parisblog/" target="_blank">
<img src="http://www.ebtb.info/parisblog/img/parisblogdevo.jpg" border=0 width=79></a>
</p>
<p>
<a href="http://eoliens.apinc.org/" hreflang="fr"  title="Eoliens : Un Annuaire Gratuit Et Sans But Lucratif De Sites De Createurs Et D'Artistes">
<img src="http://eoliens.apinc.org/visuels/eoliens80x15.png" alt="[Annuaire Eoliens]" width="80" height="15" />
</a>

Technorati cosmos
<a href="http://www.technorati.com/cosmos/search.html?url=http://aspirantartiste.free.fr/">
<img src="http://static.technorati.com/images/bubble_icon.gif" border=0></a>
<a href="http://www.technorati.com/cosmos/search.html?url=http://aspirantartiste.free.fr/photoblog/">
<img src="http://static.technorati.com/images/bubble_icon.gif" border=0></a>
</p>
<p>
<a href="http://www.spreadfirefox.com/?q=affiliates&amp;id=0&amp;t=179"><img border="0" alt="Get Thunderbird!" title="Get Thunderbird!" src="http://sfx-images.mozilla.org/affiliates/thunderbird/thunderbird_blog2.png"/></a>

<a href="http://www.spreadfirefox.com/?q=affiliates&amp;id=0&amp;t=85"><img border="0" alt="Get Firefox!" title="Get Firefox!" src="http://sfx-images.mozilla.org/affiliates/Buttons/80x15/firefox_80x15.png"/></a>

<a href="http://macroday.com/"><img border="0" alt="Sunday is Macro Day" title="Sunday is Macro Day" src="http://macroday.com/macroday.gif"/></a>

<a href="http://www.photofriday.com/"><img border="0" alt="Photo Friday" title="Photo Friday" src="http://www.photofriday.com/buttons/jojofalk.gif"/></a>
</center>
</ul>
</p>
        </div>
        <div id="footer">
			@spirant @rtiste Photoblog / <a href="./admin/index.php">Admin area</a> /
			<a href="<SITE_REFLINK>">Referers</a> / <SITE_RSS_LINK> /

		</div>
    </div>

</body>
</html>