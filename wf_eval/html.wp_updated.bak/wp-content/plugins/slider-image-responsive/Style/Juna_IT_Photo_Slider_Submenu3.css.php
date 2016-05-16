<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
?>
<style type="text/css">
	.JIT_PSlider_Submenu1_Div1
	{
		margin-top: 85px;
		display: none;
	}
	.JIT_PSlider_Effect_Table tr:nth-child(odd),.JIT_PSlider_Effect_Table1 tr:nth-child(odd)
	{
		background:#f0f0f0 !important;
		color:#717171;
		text-align: center;
		font-size: 14px;
		height: 30px;	
	}
	.JIT_PSlider_Effect_Table tr:nth-child(even),.JIT_PSlider_Effect_Table1 tr:nth-child(even)
	{
		background:#e4e3e3 !important;
		color:#717171;
		text-align: center;
		font-size: 14px;
		height: 30px;		
	}
	.JIT_PSlider_Effect_Table,.JIT_PSlider_Effect_Table1
	{
		width:99.5% ;
		padding: 2px;
		border:1px solid #0073aa;
		border-radius: 5px;
		margin-top: 1px;
		background-color: #c0c0c0;
	}	
	.JIT_PSlider_Effect_Table1
	{
		display: none;
	}
	.JIT_PSlider_main_id_item1,.JIT_PSlider_id_item1
	{
		width:5%;
	}
	.JIT_PSlider_main_title_item1,.JIT_PSlider_title_item1
	{
		width:35%;
	}
	.JIT_PSlider_main_effect_item1,.JIT_PSlider_effect_item1
	{
		width:30%;
	}
	.JIT_PSlider_main_actions_item1
	{
		width:30%;
	}
	.JIT_PSlider_edit_item1,.JIT_PSlider_delete_item1
	{
		width:15%;
		text-decoration: underline;
		color: #b12201;
	}
	.JIT_PSlider_edit_item1:hover,.JIT_PSlider_delete_item1:hover
	{
		cursor: pointer;
		color: #f68935;
	}
	#PSlider_Effec1,#PSlider_Effec2,#PSlider_Effec3,#PSlider_Effec4,#PSlider_Effec5,#PSlider_Effec6
	{
		display: none;
		width: 60%;
		margin-top: 10px;
	}
	.JIT_PSlider_Button_Div
	{
		margin-top: 15px;
		border-radius: 5px;
		text-align: center;
		padding: 5px;
		width: 99%;
		background-color: #f68935;
	}
	.JIT_PSlider_Full_Version_Image
	{
		height: 50px;
		width: 250px;
		background-image: url("http://juna-it.com/image/full-version.png");
		background-size: 250px 50px;
		background-repeat: no-repeat;
		background-position: center;
		margin: 0 auto;
		transition-duration:1s; 
	}
	.JIT_PSlider_Full_Version_Image:hover
	{
		background-image: url("http://juna-it.com/image/full-version-1.png");
	}
	.JIT_PSlider_Main_Fieldset1
	{
		border:1px solid #0073aa;
		border-radius:10px;
		background-color: #ffffff;
		margin-top: 15px;
		width: 60%;
		padding: 5px;
		display: none;
	}
	.JIT_PSlider_Table_Type
	{
		width: 100%;
	}
	.JIT_PSlider_Table_Type tr:nth-child(odd)
	{
		background-color: #edecec;
		text-align: center;
		font-size: 14px;
		font-family: Consolas;
	}
	.JIT_PSlider_Table_Type tr:nth-child(even)
	{
		background-color: #f5f5f5;
		text-align: center;
	}
	.JIT_PSlider_Table_Type td:nth-child(1)
	{
		width: 50%;
	}
	.JIT_PSlider_Table_Type td:nth-child(2)
	{
		width: 50%;
	}
	.JIT_PSlider_EN
	{
		height: 25px;
		border-radius: 3px;
		width: 200px;
	}
</style>