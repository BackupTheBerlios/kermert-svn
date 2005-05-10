<div id="recent">
		<h3>Recent Photos</h3>

		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_26_00"><img src="/thumbnails/2005_03_17_14_26_00.jpg" width="66" height="50" alt="" /></a>
		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_25_01"><img src="/thumbnails/2005_03_17_14_25_01.jpg" width="66" height="50" alt="" /></a>
		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_23_59"><img src="/thumbnails/2005_03_17_14_23_59.jpg" width="66" height="50" alt="" /></a>
		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_23_27"><img src="/thumbnails/2005_03_17_14_23_27.jpg" width="66" height="50" alt="" /></a>
		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_22_34"><img src="/thumbnails/2005_03_17_14_22_34.jpg" width="66" height="50" alt="" /></a>
		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_22_03"><img src="/thumbnails/2005_03_17_14_22_03.jpg" width="66" height="50" alt="" /></a>
		<a href="/cgi-bin/frame.cgi?date=2005_03_17_14_21_26"><img src="/thumbnails/2005_03_17_14_21_26.jpg" width="66" height="50" alt="" /></a>
		<a href="/cgi-bin/frame.cgi?date=2004_12_30_07_55_34"><img src="/thumbnails/2004_12_30_07_55_34.jpg" width="66" height="50" alt="" /></a>
		<a href="/cgi-bin/frame.cgi?date=2004_07_09_07_33_50"><img src="/thumbnails/2004_07_09_07_33_50.jpg" width="66" height="50" alt="" /></a>

		<a href="/cgi-bin/frame.cgi?date=2004_07_09_07_33_11"><img src="/thumbnails/2004_07_09_07_33_11.jpg" width="66" height="50" alt="" /></a>
		<a href="/cgi-bin/frame.cgi?date=2004_07_09_07_32_18"><img src="/thumbnails/2004_07_09_07_32_18.jpg" width="66" height="50" alt="" /></a>
		<a href="/cgi-bin/frame.cgi?date=2004_07_09_07_31_34"><img src="/thumbnails/2004_07_09_07_31_34.jpg" width="66" height="50" alt="" /></a>
	</div>

	<div id="dates">
		<h3>Older Photos</h3>

		<h4>2005</h4>
		<ul>

			<li><a href="/archives/?date=200503">March</a><span></span><span></span><span></span><span></span><span></span><span></span><span></span></li>
		</ul>

		<h4>2004</h4>
		<ul>
			<li><a href="/archives/?date=200412">December</a><span></span></li>
			<li><a href="/archives/?date=200407">July</a><span></span><span></span><span></span><span></span><span></span><span></span></li>

		</ul>

		<ul>
		<?php km_monthList('<span></span>'); ?>
		</ul>



		<h4><a href="/archives/?date=all">Show All</a></h4>
		<?php print_r($photoblog->imageslist); ?>
	</div>