               <div class="navbar">
                         <span style="float:left;width:190px">
                               <?php km_previousImage("&lt; previous &lt;");?>
                               | <a href="<?php km_config();?>">actuelle</a>
                               | <?php km_nextImage('&gt; next &gt;'); ?>
                         </span>
                         <span style="float:left;width:405px;text-align:right;">
                              <a href="<?php km_config('archives');?>">archives</a>
                               / <a href="http://aspirantartiste.free.fr/about/about.html">about</a>
                               / <a href="/galleries">Galleries</a>
                               / <a href="mailto:aspirantartiste@free.fr">contact</a>
                         </span>
                    </div>
               <div id="current_image">

                    <a href="#" onclick="javascript:alternate();">
                         <img id="image" src="<?php km_displayImage();?>" width="590" alt="<IMAGE_TITLE>" title="Voir en taille réelle" />
                    </a>
               </div>
               <div id="sub-wrapper">
                    <div class="navbar">
                         <span style="float:left;width:190px">
                               <?php km_previousImage("&lt; previous &lt;");?>
                               | <a href="<?php km_config();?>">actuelle</a>
                               | <?php km_nextImage('&gt; next &gt;'); ?>
                         </span>
                         <span style="float:left;width:405px;text-align:right;">
                              <a href="<?php km_config('archives');?>">archives</a>
                               / <a href="http://aspirantartiste.free.fr/about/about.html">about</a>
                               / <a href="/galleries">Galleries</a>
                               / <a href="mailto:aspirantartiste@free.fr">contact</a>
                         </span>
                    </div>
                    <div class="top-wrapper">
                         <div class="texte">
                              <?php km_imageTitle(); ?>
                              <br/>
                              <?php km_imageBody(); ?>
                         </div>
                         <div class="exif">
                              <h3>Facts:</h3>
                              Date: <?php km_imageDate(); ?> @ <?php km_imageTime();?><br/>
                              Categories: <IMAGE_CATEGORY_ALL><br/>
                              <a href="#exifs" onclick="javascript:flip('exifs');">View Exif</a><br/>
                              <a href="#co" onclick="javascript:flip('commentaires');">View comments</a> (<IMAGE_COMMENTS_NUMBER>)<br/>
                              <!--

                              -->
                         </div>

                         <br />
                         <br /><br /><br />
                    </div>
                    <div style="clear:both;"><hr class="separateur"/></div>
                    <div id="exifs"><a id="exif"/>
                        <h4>Exif:</h4>
                           <EXIF_DATA>
                        <a href="#top" onclick="javascript:flip('exifs');return(true);">Hide</a>
                        <div style="clear:both;"><hr class="separateur"/></div>
                        <script language='javascript' type='text/javascript'>flip('exifs');</script>
                    </div>
                    <div id="commentaires"><a id="co"/>
                    <h4>Commentaires</h4>
                    <span class="comments"><IMAGE_COMMENTS></span>
                    <form method='post' action='index.php?x=save_comment' name='commentform' >
                        <input type='hidden' name='parent_id' value='<IMAGE_ID>' />
                    <fieldset>
                        <legend>Ajouter votre commentaire</legend>
                        <div style="float:right;">
                            <label for="url">Url:</label><br/>
                            <input type='text' name="url" id="url" tabindex="2"/>
                        </div>
                        <label for="name">Pseudo:</label><br/>
                        <input type="text" name="name" value="" id="name" tabindex="1"/>
                        <div style="clear:both;">
                            <label for="message">Commentaire:</label><br/>
                            <textarea name='message' cols="57" rows='5' id="message" tabindex="3"></textarea>
                        </div>
                        <input type="submit" value="Commenter" tabindex="5"/><input type='checkbox' value='set' name='vcookie' tabindex="4"/>Se souvenir de moi
                    </fieldset>
                </form>
                <div style="clear:both;"><hr class="separateur"/></div>
                    <script language='javascript' type='text/javascript'>flip('commentaires');</script>
                    </div>

                <div style="text-align:center">
                    <!-- Thumbnails -->
                    <THUMB_LIST>
                </div>
            </div>

<div id="centered">
        <a href="#" onclick="javascript:alternate();"><img id="imagebig" src="<?php km_displayImage();?>" alt="<IMAGE_TITLE>" title="Retour au photoblog" /></a>
    </div>
    <script language='javascript' type='text/javascript'>flip("centered");</script>