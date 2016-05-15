<?php
	global $wpdb;

	$table_name  = $wpdb->prefix . "juna_it_slider_manager";
	$table_name1 = $wpdb->prefix . "juna_it_photo_manager";
	$table_name2 = $wpdb->prefix . "juna_it_pslider_font_family";
	$table_name3 = $wpdb->prefix . "juna_it_pslider_effect";
	// $table_name4 = $wpdb->prefix . "juna_it_video_effect2";
	// $table_name5 = $wpdb->prefix . "juna_it_video_effect3";
	// $table_name6 = $wpdb->prefix . "juna_it_video_effect4";
	// $table_name7 = $wpdb->prefix . "juna_it_video_effect5";

	$sql='CREATE TABLE IF NOT EXISTS ' .$table_name.' (
		id INTEGER(10) UNSIGNED AUTO_INCREMENT,
		JIT_PSlider_Name VARCHAR(255) NOT NULL,
		JIT_PSlider_Type VARCHAR(255) NOT NULL,
		JIT_PSlider_Count VARCHAR(255) NOT NULL,
		PRIMARY KEY (id))';
	$sql1='CREATE TABLE IF NOT EXISTS ' .$table_name1.' (
		id INTEGER(10) UNSIGNED AUTO_INCREMENT,
		photo_title VARCHAR(255) NOT NULL, 
		photo_url LONGTEXT NOT NULL,
		photo_link VARCHAR(255) NOT NULL,
		open_NT VARCHAR(255) NOT NULL,
		slider_id INTEGER(10) NOT NULL,
		PRIMARY KEY (id))';
	$sql2 = 'CREATE TABLE IF NOT EXISTS ' .$table_name2 . '(
		id INTEGER(10) UNSIGNED AUTO_INCREMENT,
		Font_family VARCHAR(255) NOT NULL,
		PRIMARY KEY  (id) )';
	$sql3 = 'CREATE TABLE IF NOT EXISTS ' .$table_name3 . '(
		id INTEGER(10) UNSIGNED AUTO_INCREMENT,
		JIT_PSlider_EN VARCHAR(255) NOT NULL,
		JIT_PSlider_ET VARCHAR(255) NOT NULL,
		JIT_PSlider_AutoPlay VARCHAR(255) NOT NULL,
		JIT_PSlider_SD VARCHAR(255) NOT NULL,
		JIT_PSlider_APS VARCHAR(255) NOT NULL,
		JIT_PSlider_CS VARCHAR(255) NOT NULL,
		JIT_PSlider_PT VARCHAR(255) NOT NULL,
		JIT_PSlider_SS VARCHAR(255) NOT NULL,
		JIT_PSlider_AS VARCHAR(255) NOT NULL,
		JIT_PSlider_SSC VARCHAR(255) NOT NULL,
		JIT_PSlider_SBC VARCHAR(255) NOT NULL,
		JIT_PSlider_CW VARCHAR(255) NOT NULL,
		JIT_PSlider_CH VARCHAR(255) NOT NULL,
		JIT_PSlider_SW VARCHAR(255) NOT NULL,
		JIT_PSlider_SH VARCHAR(255) NOT NULL,
		JIT_PSlider_CBW VARCHAR(255) NOT NULL,
		JIT_PSlider_CBS VARCHAR(255) NOT NULL,
		JIT_PSlider_CBC VARCHAR(255) NOT NULL,
		JIT_PSlider_CBR VARCHAR(255) NOT NULL,
		JIT_PSlider_SC VARCHAR(255) NOT NULL,
		JIT_PSlider_IR VARCHAR(255) NOT NULL,
		JIT_PSlider_ShowTitle VARCHAR(255) NOT NULL,
		JIT_PSlider_TC VARCHAR(255) NOT NULL,
		JIT_PSlider_TFS VARCHAR(255) NOT NULL,
		JIT_PSlider_TBC VARCHAR(255) NOT NULL,
		JIT_PSlider_TFF VARCHAR(255) NOT NULL,
		JIT_PSlider_TO VARCHAR(255) NOT NULL,
		JIT_PSlider_TTA VARCHAR(255) NOT NULL,
		JIT_PSlider_TPFT VARCHAR(255) NOT NULL,
		JIT_PSlider_ShowNav VARCHAR(255) NOT NULL,
		JIT_PSlider_NC VARCHAR(255) NOT NULL,
		JIT_PSlider_NBR VARCHAR(255) NOT NULL,
		JIT_PSlider_NHC VARCHAR(255) NOT NULL,
		JIT_PSlider_NP VARCHAR(255) NOT NULL,
		JIT_PSlider_NCC VARCHAR(255) NOT NULL,
		JIT_PSlider_NPFL VARCHAR(255) NOT NULL,
		JIT_PSlider_NBC VARCHAR(255) NOT NULL,
		JIT_PSlider_NS VARCHAR(255) NOT NULL,		
		JIT_PSlider_ShowArr VARCHAR(255) NOT NULL,
		JIT_PSlider_Hidden_E1I VARCHAR(255) NOT NULL,
		JIT_PSlider_AFS VARCHAR(255) NOT NULL,
		JIT_PSlider_AC VARCHAR(255) NOT NULL,
		JIT_PSlider_APFT VARCHAR(255) NOT NULL,
		JIT_PSlider_LI VARCHAR(255) NOT NULL,
		PRIMARY KEY (id))';

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	dbDelta($sql1);
	dbDelta($sql2);
	dbDelta($sql3);

	$Psfamily = array('Abadi MT Condensed Light','Aharoni','Aldhabi','Andalus','Angsana New',' AngsanaUPC','Aparajita','Arabic Typesetting','Arial',
		'Arial Black','Batang','BatangChe','Browallia New','BrowalliaUPC','Calibri','Calibri Light','Calisto MT','Cambria','Candara','Century Gothic',
		'Comic Sans MS','Consolas','Constantia','Copperplate Gothic','Copperplate Gothic Light','Corbel','Cordia New','CordiaUPC','Courier New',
		'DaunPenh','David','DFKai-SB','DilleniaUPC','DokChampa','Dotum','DotumChe','Ebrima','Estrangelo Edessa','EucrosiaUPC','Euphemia','FangSong',
		'Franklin Gothic Medium','FrankRuehl','FreesiaUPC','Gabriola','Gadugi','Gautami','Georgia','Gisha','Gulim','GulimChe','Gungsuh','GungsuhChe',
		'Impact','IrisUPC','Iskoola Pota','JasmineUPC','KaiTi','Kalinga','Kartika','Khmer UI','KodchiangUPC','Kokila','Lao UI','Latha','Leelawadee',
		'Levenim MT','LilyUPC','Lucida Console','Lucida Handwriting Italic','Lucida Sans Unicode','Malgun Gothic','Mangal','Manny ITC','Marlett',
		'Meiryo','Meiryo UI','Microsoft Himalaya','Microsoft JhengHei','Microsoft JhengHei UI','Microsoft New Tai Lue','Microsoft PhagsPa',
		'Microsoft Sans Serif','Microsoft Tai Le','Microsoft Uighur','Microsoft YaHei','Microsoft YaHei UI','Microsoft Yi Baiti','MingLiU_HKSCS',
		'MingLiU_HKSCS-ExtB','Miriam','Mongolian Baiti','MoolBoran','MS UI Gothic','MV Boli','Myanmar Text','Narkisim','Nirmala UI','News Gothic MT',
		'NSimSun','Nyala','Palatino Linotype','Plantagenet Cherokee','Raavi','Rod','Sakkal Majalla','Segoe Print','Segoe Script','Segoe UI Symbol',
		'Shonar Bangla','Shruti','SimHei','SimKai','Simplified Arabic','SimSun','SimSun-ExtB','Sylfaen','Tahoma','Times New Roman','Traditional Arabic',
		'Trebuchet MS','Tunga','Utsaah','Vani','Vijaya');

	$Juna_IT_PSlider_Count_Fonts=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name2 WHERE id>%d",0));
	if(count($Juna_IT_PSlider_Count_Fonts)==0)
	{
		for($i=0;$i<count($Psfamily);$i++)
		{
			$wpdb->query($wpdb->prepare("INSERT INTO $table_name2 (id, Font_family) VALUES (%d, %s)", '', $Psfamily[$i]));
		}
	}
	$JIT_PSlider_PS=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id>%d",0));
	if(count($JIT_PSlider_PS)==0)
	{
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name (id, JIT_PSlider_Name, JIT_PSlider_Type, JIT_PSlider_Count) VALUES (%d, %s, %s, %s)", '', 'Best Cars', 'Juna-IT Slider', '11'));
	}
	$JIT_PSlider_PSP=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name1 WHERE id>%d",0));
	if(count($JIT_PSlider_PSP)==0)
	{
		$JIT_PSlider_PSC=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id>%d",0));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', 'Mercedes S Class Lorinser', 'http://www.axt.ru/data/pictures/1411731222.jpg', '', 'No', $JIT_PSlider_PSC[0]->id));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', 'Lamborghini Aventador', 'http://www.futurecarmodel.com/wp-content/uploads/2014/11/2016-Lamborghini-Aventador-best-edition-cars.jpg', '', 'No', $JIT_PSlider_PSC[0]->id));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', 'Mercedes Benz G65 Hamann', 'http://www.sub5zero.com/wp-content/uploads/2013/04/Hamann-Mercedes-G65-AMG-SPYRIDON-2.jpg', '', 'No', $JIT_PSlider_PSC[0]->id));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', 'Ferrari-488GTB-Exterior', 'http://sportcarlist.com/wp-content/uploads/2015/03/2016-Ferrari-488GTB-Exterior.jpg', '', 'No', $JIT_PSlider_PSC[0]->id));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', 'Hyundai Azera', 'http://www.futurecarmodel.com/wp-content/uploads/2014/10/2016-hyundai-azera-white-color-best-cars.jpg', '', 'No', $JIT_PSlider_PSC[0]->id));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', 'Mazda 6 Coupe', 'http://2016bestcars.com/wp-content/uploads/2014/10/Mazda6-Coupe.jpg', '', 'No', $JIT_PSlider_PSC[0]->id));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', 'Chevrolet Camaro', 'http://st.motortrend.com/uploads/sites/5/2015/05/2016-Chevrolet-Camaro-promo1.jpg', '', 'No', $JIT_PSlider_PSC[0]->id));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', 'Chevrolet Corvette', 'http://blog.caranddriver.com/wp-content/uploads/2015/11/Chevrolet-Corvette1.jpg', '', 'No', $JIT_PSlider_PSC[0]->id));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', 'Dodge Challenger', 'http://carsreview2016.com/wp-content/uploads/2014/09/2015-Dodge-Challenger-front.jpg', '', 'No', $JIT_PSlider_PSC[0]->id));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', 'BMW i8 Concept', 'http://www.bmwusa.com/bmw/api/assets/images/BMWi/BMWi8/BMWi_i8_module4_B4.jpg?v=5fc09bfa5efbb09cf3cd0e73e2d9aad7', '', 'No', $JIT_PSlider_PSC[0]->id));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, photo_title, photo_url, photo_link, open_NT, slider_id) VALUES (%d, %s, %s, %s, %s, %s)", '', 'Mini Cooper S', 'http://a2goos.com/data_images/models/mini-cooper-s/mini-cooper-s-04.jpg', '', 'No', $JIT_PSlider_PSC[0]->id));
	}
	$JIT_PSlider_PSE=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id>%d",0));
	if(count($JIT_PSlider_PSE)<6)
	{
		$wpdb->query($wpdb->prepare("DELETE FROM $table_name3 WHERE id>%d",0));

		$wpdb->query($wpdb->prepare("INSERT INTO $table_name3 (id, JIT_PSlider_EN, JIT_PSlider_ET, JIT_PSlider_AutoPlay, JIT_PSlider_SD, JIT_PSlider_APS, JIT_PSlider_CS, JIT_PSlider_PT, JIT_PSlider_SS, JIT_PSlider_AS, JIT_PSlider_SSC, JIT_PSlider_SBC, JIT_PSlider_CW, JIT_PSlider_CH, JIT_PSlider_SW, JIT_PSlider_SH, JIT_PSlider_CBW, JIT_PSlider_CBS, JIT_PSlider_CBC, JIT_PSlider_CBR, JIT_PSlider_SC, JIT_PSlider_IR, JIT_PSlider_ShowTitle, JIT_PSlider_TC, JIT_PSlider_TFS, JIT_PSlider_TBC, JIT_PSlider_TFF, JIT_PSlider_TO, JIT_PSlider_TTA, JIT_PSlider_TPFT, JIT_PSlider_ShowNav, JIT_PSlider_NC, JIT_PSlider_NBR, JIT_PSlider_NHC, JIT_PSlider_NP, JIT_PSlider_NCC, JIT_PSlider_NPFL, JIT_PSlider_NBC, JIT_PSlider_NS, JIT_PSlider_ShowArr, JIT_PSlider_Hidden_E1I, JIT_PSlider_AFS, JIT_PSlider_AC, JIT_PSlider_APFT, JIT_PSlider_LI) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', 'Juna-IT Slider', 'Juna Slider', 'true', '600', '1', '800', '800', '15', '1', '#ffffff', '#ffffff', '690px', '400px', '650', '300px', '0px', 'solid', '#ffffff', '1%', '2', '0%', 'Yes', '#ffffff', '39px', '#dd9933', 'Arial', '0.6', 'center', '2%', 'Yes', '#dd9933', '7px', '#c47c00', 'bottom', '#ffffff', '35%', '#dd9933', '10px', 'Yes', '7', '39px', '#dd9933', '83%', 'http://juna-it.com/image/photo-slider/juna-it-slider/loading_1.gif'));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name3 (id, JIT_PSlider_EN, JIT_PSlider_ET, JIT_PSlider_AutoPlay, JIT_PSlider_SD, JIT_PSlider_APS, JIT_PSlider_CS, JIT_PSlider_PT, JIT_PSlider_SS, JIT_PSlider_AS, JIT_PSlider_SSC, JIT_PSlider_SBC, JIT_PSlider_CW, JIT_PSlider_CH, JIT_PSlider_SW, JIT_PSlider_SH, JIT_PSlider_CBW, JIT_PSlider_CBS, JIT_PSlider_CBC, JIT_PSlider_CBR, JIT_PSlider_SC, JIT_PSlider_IR, JIT_PSlider_ShowTitle, JIT_PSlider_TC, JIT_PSlider_TFS, JIT_PSlider_TBC, JIT_PSlider_TFF, JIT_PSlider_TO, JIT_PSlider_TTA, JIT_PSlider_TPFT, JIT_PSlider_ShowNav, JIT_PSlider_NC, JIT_PSlider_NBR, JIT_PSlider_NHC, JIT_PSlider_NP, JIT_PSlider_NCC, JIT_PSlider_NPFL, JIT_PSlider_NBC, JIT_PSlider_NS, JIT_PSlider_ShowArr, JIT_PSlider_Hidden_E1I, JIT_PSlider_AFS, JIT_PSlider_AC, JIT_PSlider_APFT, JIT_PSlider_LI) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', 'Full Width Version', 'Full Width Slider', 'true', '5100', '1', '5100', '4000', '0', '3', '#ffffff', '#ffffff', '690px', '400px', '650', '300px', '3px', 'none', '#ffffff', '0%', '2', '0%', 'Yes', '#ffffff', '27px', '#494949', 'Vijaya', '1', 'left', '68%', 'Yes', '#ffffff', '10px', '#494949', 'bottom', '#000000', '5%', '#ffffff', '10px', 'Yes', '8', '35px', '#e0e0e0', '3%', 'http://juna-it.com/image/photo-slider/juna-it-slider/loading_1.gif'));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name3 (id, JIT_PSlider_EN, JIT_PSlider_ET, JIT_PSlider_AutoPlay, JIT_PSlider_SD, JIT_PSlider_APS, JIT_PSlider_CS, JIT_PSlider_PT, JIT_PSlider_SS, JIT_PSlider_AS, JIT_PSlider_SSC, JIT_PSlider_SBC, JIT_PSlider_CW, JIT_PSlider_CH, JIT_PSlider_SW, JIT_PSlider_SH, JIT_PSlider_CBW, JIT_PSlider_CBS, JIT_PSlider_CBC, JIT_PSlider_CBR, JIT_PSlider_SC, JIT_PSlider_IR, JIT_PSlider_ShowTitle, JIT_PSlider_TC, JIT_PSlider_TFS, JIT_PSlider_TBC, JIT_PSlider_TFF, JIT_PSlider_TO, JIT_PSlider_TTA, JIT_PSlider_TPFT, JIT_PSlider_ShowNav, JIT_PSlider_NC, JIT_PSlider_NBR, JIT_PSlider_NHC, JIT_PSlider_NP, JIT_PSlider_NCC, JIT_PSlider_NPFL, JIT_PSlider_NBC, JIT_PSlider_NS, JIT_PSlider_ShowArr, JIT_PSlider_Hidden_E1I, JIT_PSlider_AFS, JIT_PSlider_AC, JIT_PSlider_APFT, JIT_PSlider_LI) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', 'Different Size Version', 'Different Size Slider', 'true', '600', '1', '800', '1300', '0', '1', '#ffffff', '#e5e5e5', '690px', '400px', '650', '300px', '0px', 'solid', '#ffffff', '1%', '2', '4%', 'Yes', '#000000', '39px', '#ffffff', 'Arial', '0.81', 'center', '53%', 'No', '#ffffff', '0px', '#c5c5c5', 'bottom', '#c0c0c0', '98%', '#000000', '14px', 'Yes', '2', '39px', '#8c8c8c', '55%', 'http://juna-it.com/image/photo-slider/juna-it-slider/loading_1.gif'));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name3 (id, JIT_PSlider_EN, JIT_PSlider_ET, JIT_PSlider_AutoPlay, JIT_PSlider_SD, JIT_PSlider_APS, JIT_PSlider_CS, JIT_PSlider_PT, JIT_PSlider_SS, JIT_PSlider_AS, JIT_PSlider_SSC, JIT_PSlider_SBC, JIT_PSlider_CW, JIT_PSlider_CH, JIT_PSlider_SW, JIT_PSlider_SH, JIT_PSlider_CBW, JIT_PSlider_CBS, JIT_PSlider_CBC, JIT_PSlider_CBR, JIT_PSlider_SC, JIT_PSlider_IR, JIT_PSlider_ShowTitle, JIT_PSlider_TC, JIT_PSlider_TFS, JIT_PSlider_TBC, JIT_PSlider_TFF, JIT_PSlider_TO, JIT_PSlider_TTA, JIT_PSlider_TPFT, JIT_PSlider_ShowNav, JIT_PSlider_NC, JIT_PSlider_NBR, JIT_PSlider_NHC, JIT_PSlider_NP, JIT_PSlider_NCC, JIT_PSlider_NPFL, JIT_PSlider_NBC, JIT_PSlider_NS, JIT_PSlider_ShowArr, JIT_PSlider_Hidden_E1I, JIT_PSlider_AFS, JIT_PSlider_AC, JIT_PSlider_APFT, JIT_PSlider_LI) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', 'Vertical Thumbnail', 'Vertical Thumbnail', 'true', '600', '1', '5000', '400', '15', '1', '#ffa350', '#ffffff', '890px', '400px', '650', '300px', '2px', 'solid', '#ffa350', '1%', '2', '10%', 'Yes', '#ffffff', '39px', '#dd9933', 'Arial', '0.6', 'center', '12%', 'Yes', '#dd9933', '7px', '#c47c00', 'bottom', '#ffffff', '35%', '#dd9933', '10px', 'Yes', '6', '39px', '#dd9933', '83%', 'http://juna-it.com/image/photo-slider/juna-it-slider/loading_1.gif'));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name3 (id, JIT_PSlider_EN, JIT_PSlider_ET, JIT_PSlider_AutoPlay, JIT_PSlider_SD, JIT_PSlider_APS, JIT_PSlider_CS, JIT_PSlider_PT, JIT_PSlider_SS, JIT_PSlider_AS, JIT_PSlider_SSC, JIT_PSlider_SBC, JIT_PSlider_CW, JIT_PSlider_CH, JIT_PSlider_SW, JIT_PSlider_SH, JIT_PSlider_CBW, JIT_PSlider_CBS, JIT_PSlider_CBC, JIT_PSlider_CBR, JIT_PSlider_SC, JIT_PSlider_IR, JIT_PSlider_ShowTitle, JIT_PSlider_TC, JIT_PSlider_TFS, JIT_PSlider_TBC, JIT_PSlider_TFF, JIT_PSlider_TO, JIT_PSlider_TTA, JIT_PSlider_TPFT, JIT_PSlider_ShowNav, JIT_PSlider_NC, JIT_PSlider_NBR, JIT_PSlider_NHC, JIT_PSlider_NP, JIT_PSlider_NCC, JIT_PSlider_NPFL, JIT_PSlider_NBC, JIT_PSlider_NS, JIT_PSlider_ShowArr, JIT_PSlider_Hidden_E1I, JIT_PSlider_AFS, JIT_PSlider_AC, JIT_PSlider_APFT, JIT_PSlider_LI) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', 'Horizontal Thumbnail', 'Horizontal Thumbnail', 'true', '600', '1', '5000', '400', '15', '1', '#ffa350', '#ffa350', '500px', '400px', '650', '300px', '2px', 'solid', '#ffa350', '1%', '2', '0%', 'Yes', '#ffffff', '39px', '#dd9933', 'Arial', '0.6', 'center', '12%', 'Yes', '#dd9933', '7px', '#c47c00', 'bottom', '#ffffff', '35%', '#ffffff', '10px', 'Yes', '8', '39px', '#dd9933', '33%', 'http://juna-it.com/image/photo-slider/juna-it-slider/loading_1.gif'));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name3 (id, JIT_PSlider_EN, JIT_PSlider_ET, JIT_PSlider_AutoPlay, JIT_PSlider_SD, JIT_PSlider_APS, JIT_PSlider_CS, JIT_PSlider_PT, JIT_PSlider_SS, JIT_PSlider_AS, JIT_PSlider_SSC, JIT_PSlider_SBC, JIT_PSlider_CW, JIT_PSlider_CH, JIT_PSlider_SW, JIT_PSlider_SH, JIT_PSlider_CBW, JIT_PSlider_CBS, JIT_PSlider_CBC, JIT_PSlider_CBR, JIT_PSlider_SC, JIT_PSlider_IR, JIT_PSlider_ShowTitle, JIT_PSlider_TC, JIT_PSlider_TFS, JIT_PSlider_TBC, JIT_PSlider_TFF, JIT_PSlider_TO, JIT_PSlider_TTA, JIT_PSlider_TPFT, JIT_PSlider_ShowNav, JIT_PSlider_NC, JIT_PSlider_NBR, JIT_PSlider_NHC, JIT_PSlider_NP, JIT_PSlider_NCC, JIT_PSlider_NPFL, JIT_PSlider_NBC, JIT_PSlider_NS, JIT_PSlider_ShowArr, JIT_PSlider_Hidden_E1I, JIT_PSlider_AFS, JIT_PSlider_AC, JIT_PSlider_APFT, JIT_PSlider_LI) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', 'Thumbnail Slider', 'Thumbnail Slider', 'true', '600', '1', '600', '400', '15', '1', '#ffa350', '#ffffff', '500px', '330px', '650', '300px', '1px', 'solid', '#ffa350', '1%', '2', '0%', 'Yes', '#ffa350', '35px', '#ffffff', 'Arial', '0.7', 'left', '5%', 'Yes', '#dd9933', '7px', '#ffffff', 'bottom', '#ffffff', '35%', '#ffffff', '10px', 'Yes', '14', '39px', '#dd9933', '40%', 'http://juna-it.com/image/photo-slider/juna-it-slider/loading_1.gif'));
	}
?>