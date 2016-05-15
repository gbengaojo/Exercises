
<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
	global $wpdb;
	wp_enqueue_media();
	wp_enqueue_script( 'custom-header' );
	add_filter( 'upload_size_limit', 'PBP_increase_upload' );
	function PBP_increase_upload(  )
	{
	 	return 10240000; // 10MB
	}

	$table_name  =  $wpdb->prefix . "juna_it_slider_manager";
	$table_name1 =  $wpdb->prefix . "juna_it_photo_manager";
	$table_name3 =  $wpdb->prefix . "juna_it_pslider_effect";

	if(isset($_POST['JIT_PSlider_Save_Submit']))
	{
		$JIT_PSlider_Name=sanitize_text_field($_POST['JIT_PSlider_Name']);
		$JIT_PSlider_Type=sanitize_text_field($_POST['JIT_PSlider_Type']);
		$JIT_PSlider_Hidden_Count=sanitize_text_field($_POST['JIT_PSlider_Hidden_Count']);

		$JIT_PSlider_SN_Count=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id>%d",0));

		$JITSNcount=0;

		for($i=0;$i<count($JIT_PSlider_SN_Count);$i++)
		{
			$JIT_PSlider_SN_split=explode(' (', $JIT_PSlider_SN_Count[$i]->JIT_PSlider_Name);
			if($JIT_PSlider_SN_split[0]==$JIT_PSlider_Name)
			{
				$JITSNcount++;
			}
		}

		if($JITSNcount==0)
		{
			$JIT_PSlider_Name=$JIT_PSlider_Name;
		}
		else
		{
			$JIT_PSlider_Name=$JIT_PSlider_Name .' ('. $JITSNcount .')';
		}

		$wpdb->query($wpdb->prepare("INSERT INTO $table_name (id, JIT_PSlider_Name, JIT_PSlider_Type, JIT_PSlider_Count) VALUES (%d, %s, %s, %s)", '', $JIT_PSlider_Name, $JIT_PSlider_Type, $JIT_PSlider_Hidden_Count));

		$Slider_number=$wpdb->get_var($wpdb->prepare("SELECT id FROM $table_name WHERE JIT_PSlider_Name=%s ", $JIT_PSlider_Name));

		if($JIT_PSlider_Hidden_Count!=0)
		{
			for($i=1;$i<=$JIT_PSlider_Hidden_Count;$i++)
			{
				$u = explode('\"', sanitize_text_field($_POST['JITPSLider_Uploaded_Title_'.$i]));
				$y = implode(')*^*(', $u);
				$t = explode("\'", $y);
				$JITPSLider_Uploaded_Title = implode(")*&*(", $t);

				$JITPSLider_Uploaded_Photo=sanitize_text_field($_POST['JITPSLider_Uploaded_Photo_'.$i]);
				$JITPSLider_Uploaded_Link=sanitize_text_field($_POST['JITPSLider_Uploaded_Link_'.$i]);
				$JITPSLider_Uploaded_ONT=sanitize_text_field($_POST['JITPSLider_Uploaded_ONT_'.$i]);

				$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', $JITPSLider_Uploaded_Title, $JITPSLider_Uploaded_Photo, $JITPSLider_Uploaded_Link, $JITPSLider_Uploaded_ONT, $Slider_number));
			}
		}
	}
	else if(isset($_POST['JIT_PSlider_Update_Submit']))
	{
		$JIT_PSlider_Hidden_ID=sanitize_text_field($_POST['JIT_PSlider_Hidden_ID']);
		$JIT_PSlider_Name=sanitize_text_field($_POST['JIT_PSlider_Name']);
		$JIT_PSlider_Type=sanitize_text_field($_POST['JIT_PSlider_Type']);
		$JIT_PSlider_Hidden_Count=sanitize_text_field($_POST['JIT_PSlider_Hidden_Count']);
		$JIT_PSlider_Hidden_SN=sanitize_text_field($_POST['JIT_PSlider_Hidden_SN']);

		$JIT_PSlider_SN_Count=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id>%d",0));

		$JITSNcount=0;

		if($JIT_PSlider_Name!=$JIT_PSlider_Hidden_SN)
		{
			for($i=0;$i<count($JIT_PSlider_SN_Count);$i++)
			{
				$JIT_PSlider_SN_split=explode(' (', $JIT_PSlider_SN_Count[$i]->JIT_PSlider_Name);
				if($JIT_PSlider_SN_split[0]==$JIT_PSlider_Name)
				{
					$JITSNcount++;
				}
			}
		}		

		if($JITSNcount==0)
		{
			$JIT_PSlider_Name=$JIT_PSlider_Name;
		}
		else
		{
			$JIT_PSlider_Name=$JIT_PSlider_Name .' ('. $JITSNcount .')';
		}

		$wpdb->query($wpdb->prepare("UPDATE $table_name set JIT_PSlider_Name=%s, JIT_PSlider_Type=%s, JIT_PSlider_Count=%s WHERE id=%d", $JIT_PSlider_Name, $JIT_PSlider_Type, $JIT_PSlider_Hidden_Count, $JIT_PSlider_Hidden_ID));

		$wpdb->query($wpdb->prepare("DELETE FROM $table_name1 WHERE slider_id=%d", $JIT_PSlider_Hidden_ID));

		if($JIT_PSlider_Hidden_Count!=0)
		{
			for($i=1;$i<=$JIT_PSlider_Hidden_Count;$i++)
			{
				$u = explode('\"', sanitize_text_field($_POST['JITPSLider_Uploaded_Title_'.$i]));
				$y = implode(')*^*(', $u);
				$t = explode("\'", $y);
				$JITPSLider_Uploaded_Title = implode(")*&*(", $t);

				$JITPSLider_Uploaded_Photo=sanitize_text_field($_POST['JITPSLider_Uploaded_Photo_'.$i]);
				$JITPSLider_Uploaded_Link=sanitize_text_field($_POST['JITPSLider_Uploaded_Link_'.$i]);
				$JITPSLider_Uploaded_ONT=sanitize_text_field($_POST['JITPSLider_Uploaded_ONT_'.$i]);

				$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', $JITPSLider_Uploaded_Title, $JITPSLider_Uploaded_Photo, $JITPSLider_Uploaded_Link, $JITPSLider_Uploaded_ONT, $JIT_PSlider_Hidden_ID));
			}
		}

	}
	$JITPSliders=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id > %d",0));
	$JIT_PSlider_Effects=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id>%d",0));
?>
<form method="POST" enctype="multipart/form-data">
	<div id="JIT_PSlider_main"> 
		<div class="JIT_PSlider_Submenu_Footer_Div">
			<a href="http://juna-it.com" target="_blank" title="Click to Visit"><img src="http://juna-it.com/image/logo-white.png" class="Juna_IT_Logo_Orange"></a>
			<div class="JIT_PSlider_Submenu_Div">
				<span class="JIT_PSlider_Title_Span">Name:</span> 
				<input type="text"   class="JIT_PSlider_search_text" id="JIT_PSlider_search_text" onclick="JIT_PSlider_Search()" placeholder="Search">
				<input type="button" class="JIT_PSlider_Reset_text" value="Reset" onclick="JIT_PSlider_Reset()">
				<span class="JIT_PSlider_not" id="JIT_PSlider_not"></span>
				<input type="button" class="JIT_PSlider_Add_Button" value="Create Slider" onclick="JIT_PSlider_Add()">
			</div>
			<div class="JIT_PSlider_Submenu_Div1">
				<input type="hidden" id="JIT_PSlider_Hidden_Count" name="JIT_PSlider_Hidden_Count" value="0">
				<input type="hidden" id="JIT_PSlider_Hidden_ID" name="JIT_PSlider_Hidden_ID" value="">
				<input type="hidden" id="JIT_PSlider_Hidden_SN" name="JIT_PSlider_Hidden_SN" value="">				
				<input type="button" class="JIT_PSlider_Add_Button" value="Back" onclick="JIT_PSlider_Back()">
				<input type="submit" class="JIT_PSlider_Add_Button" id="JIT_PSlider_Save_Submit" name="JIT_PSlider_Save_Submit" value="Save">
				<input type="submit" class="JIT_PSlider_Add_Button" id="JIT_PSlider_Update_Submit" name="JIT_PSlider_Update_Submit" value="Update">
			</div>
		</div>
		<div class="JIT_PSlider_Short_Div">
			<table class="JIT_PSlider_Short_Table">
				<tr>
					<td>Shortcode</td>
					<td>Copy & paste the shortcode directly into any WordPress post or page.</td>
					<td><?php echo 'Example:  [Juna_Photo_Slider id="1"]';?></td>
				</tr>
				<tr>
					<td>Templete Include</td>
					<td>Copy & paste this code into a template file to include the slideshow within your theme.</td>
					<td><input type="text" value='<?php echo 'Example:   <?php echo do_shortcode("[Juna_Photo_Slider id="1"]");?>';?>' style="width:100%;background-color:#0073aa;color:#ffffff;border:none;text-align: center" readonly></td>
				</tr>
			</table>
		</div>
		<table class = 'JIT_PSlider_Main_Table'>
			<tr class="JIT_PSlider_first_row">
				<td class='JIT_PSlider_main_id_item'><B><I>No</I></B></td>
				<td class='JIT_PSlider_main_title_item'><B><I>Slider Title</I></B></td>
				<td class='JIT_PSlider_main_quantity_video_item'><B><I>Quantity</I></B></td>
				<td class='JIT_PSlider_main_type_video_item'><B><I>Type</I></B></td>
				<td class='JIT_PSlider_main_views_item'><B><I>Shortcode</I></B></td>
				<td class='JIT_PSlider_main_actions_item'><B><I>Actions</I></B></td>
			</tr>
		</table>
		<table class = 'JIT_PSlider_Table'>
			<?php for($i=0;$i<count($JITPSliders);$i++) {?>
				<?php if($i==0) {?>
					<tr>
						<td class='JIT_PSlider_id_item'><B><I><?php echo $i+1 ;?></I></B></td>
						<td class='JIT_PSlider_title_item'><B><I><?php echo $JITPSliders[$i]->JIT_PSlider_Name;?></I></B></td>
						<td class='JIT_PSlider_quantity_video_item'><B><I><?php echo $JITPSliders[$i]->JIT_PSlider_Count;?></I></B></td>
						<td class='JIT_PSlider_type_video_item'><B><I><?php echo $JITPSliders[$i]->JIT_PSlider_Type;?></I></B></td>
						<td class='JIT_PSlider_views_item'><?php echo '[Juna_Photo_Slider id="'.$JITPSliders[$i]->id.'"]';?></td>
						<td class='JIT_PSlider_edit_item' onclick="Edit_JITPSlider(<?php echo $JITPSliders[$i]->id;?>)"><B><I>Edit</I></B></td>
						<td class='JIT_PSlider_delete_item1'><B><I>Delete</I></B></td>
					</tr>
				<?php } else {?>
					<tr>
						<td class='JIT_PSlider_id_item'><B><I><?php echo $i+1 ;?></I></B></td>
						<td class='JIT_PSlider_title_item'><B><I><?php echo $JITPSliders[$i]->JIT_PSlider_Name;?></I></B></td>
						<td class='JIT_PSlider_quantity_video_item'><B><I><?php echo $JITPSliders[$i]->JIT_PSlider_Count;?></I></B></td>
						<td class='JIT_PSlider_type_video_item'><B><I><?php echo $JITPSliders[$i]->JIT_PSlider_Type;?></I></B></td>
						<td class='JIT_PSlider_views_item'><?php echo '[Juna_Photo_Slider id="'.$JITPSliders[$i]->id.'"]';?></td>
						<td class='JIT_PSlider_edit_item' onclick="Edit_JITPSlider(<?php echo $JITPSliders[$i]->id;?>)"><B><I>Edit</I></B></td>
						<td class='JIT_PSlider_delete_item' onclick="Delete_JITPSlider(<?php echo $JITPSliders[$i]->id;?>)"><B><I>Delete</I></B></td>
					</tr>
				<?php } ?>
			<?php } ?>
		</table>
		<table class = 'JIT_PSlider_Table1'></table>
	</div>
	<div class="JIT_PSlider_Type_Div">
		<table class="JIT_PSlider_Type_Div_Table">
			<tr>
				<td>Slider Name:</td>
				<td>Slider Effect:</td>
			</tr>
			<tr>
				<td>
					<input type="text" name="JIT_PSlider_Name" id="JIT_PSlider_Name" value="" placeholder="Slider Name" required>
				</td>
				<td>
					<select name="JIT_PSlider_Type" id="JIT_PSlider_Type">
						<?php for($i=0;$i<count($JIT_PSlider_Effects);$i++){?>
							<option value="<?php echo $JIT_PSlider_Effects[$i]->JIT_PSlider_EN;?>"><?php echo $JIT_PSlider_Effects[$i]->JIT_PSlider_EN;?></option>
						<?php }?>
					</select>
				</td>
			</tr>
		</table>			
	</div>
	<div class="JIT_PSlider_Add_Photo_Div" onclick="JIT_PSlider_Add_Photo_Div_Clicked()">
		<table class="JIT_PSlider_Upload_Photo_Table">
			<tr>
				<td><label>Title:</label></td>
				<td><input type="text" class="JIT_PSlider_Upload_Photo_Input" id="JIT_PSlider_Upload_Title" placeholder="* Required"><span class="JIT_PSlider_Span" id="JIT_PSlider_Span_1">*</span></td>
			</tr>
			<tr>
				<td>
					<div id="wp-content-media-buttons" class="wp-media-buttons" >													
						<a href="#" class="button insert-media add_media" style="border:1px solid #0073aa; color:#0073aa; background-color:#f2f2f2" data-editor="JIT_PSlider_Upload_Photo_1" title="Add Image" id="JIT_PSlider_Upload_Photo" onclick="JIT_PSlider_Upload_Photo_Clicked()">
							<span class="wp-media-buttons-icon"></span>Add Image
						</a>
					</div>
					<input type="hidden" id="JIT_PSlider_Upload_Photo_1">									
				</td>
				<td><input type="text" class="JIT_PSlider_Upload_Photo_Input" id="JIT_PSlider_Upload_Photo_2" placeholder="* Required" readonly><span class="JIT_PSlider_Span" id="JIT_PSlider_Span_2">*</span></td>
			</tr>
			<tr>
				<td><label>Link:</label></td>
				<td><input type="text" class="JIT_PSlider_Upload_Photo_Input" id="JIT_PSlider_Upload_Link" placeholder="Optional"></td>
			</tr>
			<tr>
				<td><label>Open In New Tab:</label></td>
				<td><i class="JITPSlidericon_Yes junaiticons-style junaiticons-check" onclick="JIT_PSlider_ONT('Yes')" style="margin-left:5%;margin-right:20px;font-size: 20px; color:#c5c5c5"></i><i class="JITPSlidericon_No junaiticons-style junaiticons-remove" onclick="JIT_PSlider_ONT('No')" style="font-size: 20px; color:#0073aa"></i></td>
			</tr>
		</table>
		<div class="JIT_PSlider_Upload_Photo_Div1">
			<input type="hidden" id="JIT_PSlider_YON" value="No">
			<input type="hidden" id="JIT_PSlider_Lindex" value="">
			<input type="button" class="JIT_PSlider_Upload_Photo_Button" value="Cancel" onclick="JIT_PSlider_Main_Big_Clicked()">
			<input type="button" class="JIT_PSlider_Upload_Photo_Button" id="JIT_PSlider_Button_S" value="Save" onclick="JIT_PSlider_Save_Clicked()">
			<input type="button" class="JIT_PSlider_Upload_Photo_Button" id="JIT_PSlider_Button_U" value="Update" onclick="JIT_PSlider_Up_Clicked()">
		</div>
	</div>
	<div id="JIT_PSlider_Photos" class="JIT_PSlider_Photos">
		<ul id="JIT_PSlider_Photos_Ul">
		</ul>			
	</div>
</form>	