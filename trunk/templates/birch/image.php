<div id="photo">
		<?php km_PreviousImage('','photo-arrow-left'); ?>

		<?php km_nextImage('','photo-arrow-right'); ?>
		<img src="<?php km_displayImage(); ?>" width="600" height="450" alt="" />
	</div>

	<div id="caption">
		<div id="caption-title"><?php km_ImageDate(); ?> @ <?php km_imageTime(); ?> <?php km_Permalink(); ?><br/>
		<?php km_imageCategories(); ?>
		</div>
		<?php km_imageTitle(); ?>
	</div>

	<div id="previous-photos">

		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_23_59" id="arrow-left"></a>
		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_23_27"><img src="/thumbnails/2005_03_17_14_23_27.jpg" width="66" height="50" alt="" /></a>
		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_23_59"><img src="/thumbnails/2005_03_17_14_23_59.jpg" width="66" height="50" alt="" /></a>
		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_25_01"><img src="/thumbnails/2005_03_17_14_25_01.jpg" width="66" height="50" alt="" class="selected" /></a>
		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_26_00"><img src="/thumbnails/2005_03_17_14_26_00.jpg" width="66" height="50" alt="" /></a>
		<div class="spacer"></div>
		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_26_00" id="arrow-right"></a>
	</div>