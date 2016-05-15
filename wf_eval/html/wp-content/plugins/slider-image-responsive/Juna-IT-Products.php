<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
?>
<style type="text/css">
	.JunaIT_Table
	{
		width: 99.5%;
		padding: 2px;
		border:1px solid #0073aa;
		border-radius: 5px;
		margin-top: 15px;
		background-color: #c0c0c0;
	}
	.JunaIT_Table tr:nth-child(odd)
	{
		background:#f0f0f0 !important;
		color:#717171;
		text-align: center;
		font-size: 14px;
	}
	.JunaIT_Table tr:nth-child(even)
	{
		background:#e4e3e3 !important;
		color:#717171;
		text-align: center;
		font-size: 14px;
	}
	.JunaIT_Table td:nth-child(odd)
	{
		width: 20%;
	}
	.JunaIT_Table td:nth-child(even)
	{
		width: 80%;
	}
	.JunaIT_Link
	{
		margin-left: 15px;
	}
	.JunaIT_TableFR
	{
		background-color: #0073aa;
		color: #ffffff;
		font-family: Gabriola;
		font-size:25px;
		padding:5px;
		height: 100px;
		line-height: 100%;
	}
	.JIT_View_More:hover
	{
		color: #ff7700 !important;
		cursor: pointer;
	}
</style>
<table class="JunaIT_Table">
	<tr>
		<td class="JunaIT_TableFR"><img style="height: 70px;" src="<?php echo plugins_url('/Images/logo-white.png',__FILE__);?>"></td>
		<td class="JunaIT_TableFR"><span style="display:block;margin-top: 25px;"> Now You Can buy our 6 plugins at once. It includes Easy Calendar Developer,<br> Event Calendar Developer , Video Gallery Developer, Poll Developer, Photo Slider Developer <br> And Image Gallery Developer. Hurry up. It's not unlimited. <br> <a class="JIT_View_More" style="color:#ffa350;" href="http://juna-it.com/index.php/wordpress-plugins/" target="_blank">View More...</a></span></td>
	</tr>
	<tr>
		<td><a href="http://juna-it.com/index.php/juna-easy-calendar/" target="_blank"><img src="<?php echo plugins_url('/Images/juna-easy-128x128.jpg',__FILE__);?>"></a></td>
		<td>Easy to use for anybody, Easy Calendar provides enormous flexibility for designers and developers needing a custom calendar.<a class="JunaIT_Link" href="http://juna-it.com/index.php/juna-easy-calendar/" target="_blank">View More...</a></td>
	</tr>
	<tr>
		<td><a href="http://juna-it.com/index.php/juna-event-calendar/" target="_blank"><img src="<?php echo plugins_url('/Images/juna-event-128x128.jpg',__FILE__);?>"></a></td>
		<td>JUNA EVENT CALENDAR is very easily used plugin calendar, which has lots of advantages.<a class="JunaIT_Link" href="http://juna-it.com/index.php/juna-event-calendar/" target="_blank">View More...</a></td>
	</tr>
	<tr>
		<td><a href="http://juna-it.com/index.php/video-gallery/" target="_blank"><img src="<?php echo plugins_url('/Images/juna-video-128x128.jpg',__FILE__);?>"></a></td>
		<td>This Video Gallery plugin easy to use. It Helps you to create and show your videos in your web-page how you designed it.<a class="JunaIT_Link" href="http://juna-it.com/index.php/video-gallery/" target="_blank">View More...</a></td>
	</tr>
	<tr>
		<td><a href="http://juna-it.com/index.php/features/elements/juna-it-plugin/" target="_blank"><img src="<?php echo plugins_url('/Images/juna-poll-128x128.jpg',__FILE__);?>"></a></td>
		<td>You can use WordPress Juna IT Poll for explaining what your users think about your web-page or a new page and or about any question.<a class="JunaIT_Link" href="http://juna-it.com/index.php/features/elements/juna-it-plugin/" target="_blank">View More...</a></td>
	</tr>
	<tr>
		<td><a href="http://juna-it.com/index.php/photo-slider/" target="_blank"><img src="<?php echo plugins_url('/Images/juna-slider-128x128.jpg',__FILE__);?>"></a></td>
		<td>Revolutionary slider from Juna IT. This slider is different from all of its charm. In wordpress sliders Our slider gives you many useful functions.<a class="JunaIT_Link" href="http://juna-it.com/index.php/photo-slider/" target="_blank">View More...</a></td>
	</tr>
	<tr>
		<td><a href="http://juna-it.com/index.php/image-gallery/" target="_blank"><img src="<?php echo plugins_url('/Images/juna-gallery-128x128.jpg',__FILE__);?>"></a></td>
		<td>This Image Gallery plugin easy to use. It Helps you to create and show your images in your web-page how you designed it.<a class="JunaIT_Link" href="http://juna-it.com/index.php/image-gallery/" target="_blank">View More...</a></td>
	</tr>
</table>