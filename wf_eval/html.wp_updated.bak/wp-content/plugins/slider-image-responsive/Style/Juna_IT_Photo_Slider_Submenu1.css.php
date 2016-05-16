<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
?>
<style type="text/css">	
	.JIT_PSlider_Submenu_Div1
	{
		margin-top: 85px;
		display: none;
	}	
	.JIT_PSlider_Table,.JIT_PSlider_Table1
	{
		width:99.5% ;
		padding: 2px;
		border:1px solid #0073aa;
		border-radius: 5px;
		margin-top: 1px;
		background-color: #c0c0c0;
	}	
	.JIT_PSlider_Table1
	{
		display: none;
	}
	.JIT_PSlider_Table tr:nth-child(odd),.JIT_PSlider_Table1 tr:nth-child(odd)
	{
		background:#f0f0f0 !important;
		color:#717171;
		text-align: center;
		font-size: 14px;
		height: 30px;	
	}
	.JIT_PSlider_Table tr:nth-child(even),.JIT_PSlider_Table1 tr:nth-child(even)
	{
		background:#e4e3e3 !important;
		color:#717171;
		text-align: center;
		font-size: 14px;
		height: 30px;		
	}
	.JIT_PSlider_id_item,.JIT_PSlider_main_id_item
	{
		width:3%;
	}
	.JIT_PSlider_title_item,.JIT_PSlider_main_title_item
	{
		width:25%;
	}	
	.JIT_PSlider_quantity_video_item,.JIT_PSlider_main_quantity_video_item
	{
		width:7%;
	}
	.JIT_PSlider_type_video_item,.JIT_PSlider_main_type_video_item
	{
		width:20%;
	}
	.JIT_PSlider_views_item,.JIT_PSlider_main_views_item
	{
		width:15%;
	}
	.JIT_PSlider_main_actions_item
	{
		width:10%;
	}
	.JIT_PSlider_delete_item,.JIT_PSlider_edit_item
	{
		width:5%;
		text-decoration: underline;
		color: #b12201;
	}
	.JIT_PSlider_delete_item:hover,.JIT_PSlider_edit_item:hover
	{
		cursor: pointer;
		color: #f68935;
	}
	.JIT_PSlider_delete_item1
	{
		width:5%;
	}
	.JIT_PSlider_Type_Div
	{
		border:1px solid #0073aa; 
		margin-top:15px;
		background-color:#ffffff;
		border-radius:10px; 
		padding:5px;
		width: 60%;
		display: none;
	}
	.JIT_PSlider_Type_Div_Table
	{
		width: 100%;
	}
	.JIT_PSlider_Type_Div_Table tr:nth-child(odd)
	{
		background-color: #edecec;
		text-align: center;
		font-size: 14px;
		font-family: Consolas;
	}
	.JIT_PSlider_Type_Div_Table tr:nth-child(even)
	{
		background-color: #f5f5f5;
		text-align: center;
	}
	.JIT_PSlider_Type_Div_Table td:nth-child(1)
	{
		width: 50%;
	}
	.JIT_PSlider_Type_Div_Table td:nth-child(2)
	{
		width: 50%;
	}	
	.JIT_PSlider_Upload_Photo_Table
	{
		width: 100%;
	}
	.JIT_PSlider_Upload_Photo_Table td:nth-child(odd)
	{
		background-color: #cfcfcf;
		width: 20%;
		text-align: center;
		padding: 5px;
	}
	.JIT_PSlider_Upload_Photo_Table td:nth-child(even)
	{
		width: 80%;
		padding: 5px;
		background-color: #f2f2f2;
	}
	.JIT_PSlider_Upload_Photo_Input
	{
		width: 80%;
		margin-left: 5%;
	}
	.JIT_PSlider_Upload_Photo_Div1
	{
		padding: 10px;
	}
	.JIT_PSlider_Upload_Photo_Button
	{
		cursor: pointer;
		width: 120px;
		background-color: #ffffff;
		color: #0073aa;
		border: 2px solid #0073aa;
		border-radius: 3px;
		box-shadow: 0px 0px 30px #cfcfcf;
		margin-right: 25px;
		float: right;
	}
	.JIT_PSlider_Upload_Photo_Button:hover
	{
		background-color: #0073aa;
		color: #ffffff;
		border-color: #ffffff;
		box-shadow: 0px 0px 30px #0073aa;
	}
	.JIT_PSlider_Upload_Photo_Button:active
	{
		background-color: #ffffff;
		color: #0073aa;
		border-color: #0073aa;
		box-shadow: 0px 0px 30px #cfcfcf;
	}
	.JIT_PSlider_Photos
	{
		border:1px solid #0073aa; 
		margin-top:15px;
		background-color:#ffffff;
		border-radius:10px; 
		padding:5px;
		width: 60%;
		display: none;
	}
	.JIT_PSlider_Photos_Div
	{
		width: 30%;
		position: relative;
		padding: 5px;
	}
	.JIT_PSlider_Photos_Desc_Div
	{
		width: 68%;
		float: right;
	}
	.JIT_PSlider_Photo
	{
		width: 100%;
		height:180px; 
	}
	.JIT_PSlider_Photos_Table
	{
		width: 100%;
	}
	.JIT_PSlider_Photos_Table td:nth-child(odd)
	{
		background-color: #cfcfcf;
		width: 20%;
		text-align: center;
		padding: 5px;
	}
	.JIT_PSlider_Photos_Table td:nth-child(even)
	{
		width: 80%;
		padding: 5px;
		background-color: #f2f2f2;
	}
	.JITPSlidericon_Yes,.JITPSlidericon_No
	{
		cursor: pointer;
	}
	#JIT_PSlider_Photos_Ul li
	{
		cursor: all-scroll;
		height:200px;
	}
	#JIT_PSlider_Photos_Ul li:nth-child(even)
	{
		background-color: #f5f5f5;
	}
	#JIT_PSlider_Photos_Ul li:nth-child(odd)
	{
		background-color: #edecec;
	}
	.JIT_PSlider_Short_Div
	{
		border:1px solid #0073aa;
		margin-top: 10px;
		width: 99.5%;
		background-color: #ffffff;
		padding:1px;
		border-radius: 5px;
	}
	.JIT_PSlider_Short_Table
	{
		width: 100%;
		text-align: center;
		color:#ffffff;
		font-style: bold;
		font-weight: 900;
	}
	.JIT_PSlider_Short_Table td:nth-child(1)
	{
		width: 20%;
		padding: 5px;
		background-color: #0073aa;
	}
	.JIT_PSlider_Short_Table td:nth-child(2)
	{
		width: 40%;
		padding: 5px;
		background-color: #0073aa;
	}
	.JIT_PSlider_Short_Table td:nth-child(3)
	{
		width: 40%;
		padding: 5px;
		background-color: #0073aa;
	}
</style>