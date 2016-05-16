<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
	global $wpdb;
	wp_enqueue_media();
	wp_enqueue_script( 'custom-header' );

	$table_name3 =  $wpdb->prefix . "juna_it_pslider_effect";

	$JIT_PSlider_Effects=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id>%d",0));
?>
<form method='POST'>
	<div id="JIT_PSlider_main"> 
		<div class="JIT_PSlider_Submenu_Footer_Div">
			<a href="http://juna-it.com" target="_blank" title="Click to Visit"><img src="http://juna-it.com/image/logo-white.png" class="Juna_IT_Logo_Orange"></a>
			<div class="JIT_PSlider_Submenu1_Div">
				<span class="JIT_PSlider_Title_Span">Title:</span> 
				<input type="text"   class="JIT_PSlider_search_text" id="JIT_PSlider_search_text1" onclick="JIT_PSlider_Search1()" placeholder="Search">
				<input type="button" class="JIT_PSlider_Reset_text" value="Reset" onclick="JIT_PSlider_Reset1()">
				<span class="JIT_PSlider_not" id="JIT_PSlider_not1"></span>
			</div>
			<div class="JIT_PSlider_Submenu1_Div1">
				<input type="hidden" id="JIT_PSlider_Hidden_ID1" name="JIT_PSlider_Hidden_ID1" value="">
				<input type="hidden" id="JIT_PSlider_Hidden_E1I" name="JIT_PSlider_Hidden_E1I" value="">
				<input type="hidden" id="JIT_PSlider_Hidden_EN" name="JIT_PSlider_Hidden_EN" value="">
				<input type="button" class="JIT_PSlider_Add_Button" value="Back" onclick="JIT_PSlider_Back_Effect()">
			</div>
		</div>
		<div id="JIT_PSlider_Button_Div" class="JIT_PSlider_Button_Div">
			<a href="http://juna-it.com/index.php/photo-slider" target="_blank"<abbr title="Click to Buy"><div class="JIT_PSlider_Full_Version_Image"></div></a>
			<span style="display:block;color:#ffffff;font-size:16px;">This is the free version of the plugin. Click "GET THE FULL VERSION" for more advanced options.</span><br>
			<span style="display:block;color:#ffffff;font-size:16px;margin-top:-15px;"> We appreciate every customer.</span>
		</div>
		<table class = 'JIT_PSlider_Main_Table1'>
			<tr class="JIT_PSlider_first_row">
				<td class='JIT_PSlider_main_id_item1'><B><I>No</I></B></td>
				<td class='JIT_PSlider_main_title_item1'><B><I>Effect Name</I></B></td>
				<td class='JIT_PSlider_main_effect_item1'><B><I>Effect Type</I></B></td>
				<td class='JIT_PSlider_main_actions_item1'><B><I>Actions</I></B></td>
			</tr>
		</table>
		<table class = 'JIT_PSlider_Effect_Table'>
			<?php for($i=0;$i<count($JIT_PSlider_Effects);$i++) {
				if($i<6){
					?>
					<tr>
						<td class='JIT_PSlider_id_item1'><B><I><?php echo $i+1 ;?></I></B></td>
						<td class='JIT_PSlider_title_item1'><B><I><?php echo $JIT_PSlider_Effects[$i]->JIT_PSlider_EN;?></I></B></td>
						<td class='JIT_PSlider_effect_item1'><B><I><?php echo $JIT_PSlider_Effects[$i]->JIT_PSlider_ET;?></I></B></td>
						<td class='JIT_PSlider_edit_item1' onclick="Edit_JITPSlider_Effect(<?php echo $i;?>)"><B><I>Edit</I></B></td>
						<td><B><I>Delete</I></B></td>
					</tr>
				<?php }}?>
		</table>
		<table class = 'JIT_PSlider_Effect_Table1'></table>
	</div>
	<fieldset class="JIT_PSlider_Main_Fieldset1">
		<table class="JIT_PSlider_Table_Type">
			<tr>
				<td>Effect Name</td>
				<td>Effect Type</td>
			</tr>
			<tr>
				<td>
					<input type="text" class="JIT_PSlider_EN" name="JIT_PSlider_EN" id="JIT_PSlider_EN" placeholder="* Required" required>
				</td>
				<td>
					<select class="JIT_PSlider_EN" name="JIT_PSlider_ET" id="JIT_PSlider_ET" onchange="JIT_PSlider_ET_Changed()">
						<option value="Juna Slider">Juna Slider</option>
						<option value="Full Width Slider">Full Width Slider</option>
						<option value="Different Size Slider">Different Size Slider</option>
						<option value="Vertical Thumbnail">Vertical Thumbnail Slider</option>
						<option value="Horizontal Thumbnail">Horizontal Thumbnail Slider</option>
						<option value="Thumbnail Slider">Thumbnail Slider</option>
					</select>
				</td>
			</tr>			
		</table>
	</fieldset>
	<img id="PSlider_Effec1" src="<?php echo plugins_url('/Images/Juna Slider.png',__FILE__);?>">
	<img id="PSlider_Effec2" src="<?php echo plugins_url('/Images/Full Width Slider.png',__FILE__);?>">
	<img id="PSlider_Effec3" src="<?php echo plugins_url('/Images/Different Size Slider.png',__FILE__);?>">
	<img id="PSlider_Effec4" src="<?php echo plugins_url('/Images/Vertical Thumbnail Slider.png',__FILE__);?>">
	<img id="PSlider_Effec5" src="<?php echo plugins_url('/Images/Horizontal Thumbnail.png',__FILE__);?>">
	<img id="PSlider_Effec6" src="<?php echo plugins_url('/Images/Thumbnail Slider.png',__FILE__);?>">
</form>