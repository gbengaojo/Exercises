<?php
	add_action( 'wp_ajax_Edit_JIT_PSlider', 'Edit_JIT_PSlider_Callback' );
	add_action( 'wp_ajax_nopriv_Edit_JIT_PSlider', 'Edit_JIT_PSlider_Callback' );

	function Edit_JIT_PSlider_Callback()
	{
		$Edit_slider_id = sanitize_text_field($_POST['foobar']);
		
		global $wpdb;
		$table_name  = $wpdb->prefix . "juna_it_slider_manager";
		$table_name1 = $wpdb->prefix . "juna_it_photo_manager";

		$JIT_SLider_Title=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id=%d", $Edit_slider_id));

		$JIT_SLider_Photos_params=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name1 WHERE slider_id=%d order by id", $Edit_slider_id));

		echo $JIT_SLider_Title[0]->JIT_PSlider_Name . '^%^' . $JIT_SLider_Title[0]->JIT_PSlider_Type . '^%^' . $JIT_SLider_Title[0]->JIT_PSlider_Count . '^%^' . $JIT_SLider_Photos_param;
		for($i=0;$i<$JIT_SLider_Title[0]->JIT_PSlider_Count;$i++)
		{
			$u = explode(')*^*(', $JIT_SLider_Photos_params[$i]->photo_title);
			$y = implode('"', $u);
			$t = explode(")*&*(", $y);
			$Photo_Title = implode("'", $t);

			$JIT_SLider_Photos_param = $Photo_Title . '$#$' . $JIT_SLider_Photos_params[$i]->photo_url . '$#$' . $JIT_SLider_Photos_params[$i]->photo_link . '$#$' . $JIT_SLider_Photos_params[$i]->open_NT . ')*(';
			echo $JIT_SLider_Photos_param;
		}
		die();
	}

	add_action( 'wp_ajax_Delete_JITPSlider_Click', 'Delete_JITPSlider_Click_Callback' );
	add_action( 'wp_ajax_nopriv_Delete_JITPSlider_Click', 'Delete_JITPSlider_Click_Callback' );

	function Delete_JITPSlider_Click_Callback()
	{
		$Delete_slider_id = sanitize_text_field($_POST['foobar']);
		
		global $wpdb;
		$table_name  = $wpdb->prefix . "juna_it_slider_manager";
		$table_name1 = $wpdb->prefix . "juna_it_photo_manager";

		$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id=%d", $Delete_slider_id));
		$wpdb->query($wpdb->prepare("DELETE FROM $table_name1 WHERE slider_id=%s", $Delete_slider_id));

		die();
	}

	add_action( 'wp_ajax_Search_JITPSlider_Click', 'Search_JITPSlider_Click_Callback' );
	add_action( 'wp_ajax_nopriv_Search_JITPSlider_Click', 'Search_JITPSlider_Click_Callback' );

	function Search_JITPSlider_Click_Callback()
	{
		$Search_slider =$_POST['foobar'];
		
		global $wpdb;
		$table_name  = $wpdb->prefix . "juna_it_slider_manager";

		$Searched_JITPS=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id>%d",0));

		for($i=0;$i<count($Searched_JITPS);$i++)
		{
			if(stripos(strtolower($Searched_JITPS[$i]->JIT_PSlider_Name),$Search_slider))
			{
				$u = explode(')*^*(', $Searched_JITPS[$i]->JIT_PSlider_Name);
				$y = implode('"', $u);
				$t = explode(")*&*(", $y);
				$JIT_PSlider = implode("'", $t);

				echo $Searched_JITPS[$i]->id . ')&*&(' . $JIT_PSlider . ')&*&(' . $Searched_JITPS[$i]->JIT_PSlider_Type . ')&*&(' . $Searched_JITPS[$i]->JIT_PSlider_Count . ')*^*(';
			}
		}
		die();
	}

	add_action( 'wp_ajax_Search_JITPSlider_Effect_Click', 'Search_JITPSlider_Effect_Click_Callback' );
	add_action( 'wp_ajax_nopriv_Search_JITPSlider_Effect_Click', 'Search_JITPSlider_Effect_Click_Callback' );

	function Search_JITPSlider_Effect_Click_Callback()
	{
		$Search_effect=$_POST['foobar'];
		
		global $wpdb;
		$table_name3 = $wpdb->prefix . "juna_it_pslider_effects";

		$Searched_JITPSE=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id>%d",0));

		for($i=0;$i<count($Searched_JITPSE);$i++)
		{
			if(stripos(strtolower($Searched_JITPSE[$i]->JIT_PSlider_EN),$Search_effect))
			{
				echo $Searched_JITPSE[$i]->id . ')&*&(' . $Searched_JITPSE[$i]->JIT_PSlider_EN . ')&*&(' . $Searched_JITPSE[$i]->JIT_PSlider_ET . ')*^*(';
			}
		}
		die();
	}
?>