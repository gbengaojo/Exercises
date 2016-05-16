<?

$civ = $_POST['civ'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$adresse = $_POST['adresse'];
$ville = $_POST['ville'];
$cp = $_POST['cp'];
$dob1 = $_POST['dob1'];
$dob2 = $_POST['dob2'];
$dob3 = $_POST['dob3'];
$em = $_POST['em'];
$pss = $_POST['pss'];
$DEP = $_POST['DEP'];
$NEG2 = $_POST['NEG2'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml" lang="fr"><head>


		<title>EDF - Remboursement à la carte</title>
		<meta name="Content-Language" content="fr">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		
<link rel="shortcut icon" type="image/x-icon" href="http://bleuciel.edf.com/favicon.ico">
<link rel="icon" type="image/png" href="http://bleuciel.edf.com/FRONT/NetExpress/img/favicon.png">
<link rel="apple-touch-icon" href="http://bleuciel.edf.com/FRONT/NetExpress/img/apple-touch-icon.png">

<link href="pikos/template_T1.css" rel="stylesheet" type="text/css" media="all">
<link href="pikos/widgets.css" rel="stylesheet" type="text/css" media="all">
<link href="pikos/t1p3_nav_3.css" rel="stylesheet" type="text/css" media="all">
<link href="pikos/page_T1P3.css" rel="stylesheet" type="text/css" media="all">
<link href="pikos/formulaires.css" rel="stylesheet" type="text/css" media="all">
<link href="pikos/relever_compteur.css" rel="stylesheet" type="text/css" media="all">
<link href="pikos/page_T1P3_print.css" rel="stylesheet" type="text/css" media="print">
<link href="pikos/bleuCiel.css" rel="stylesheet" type="text/css" media="all">
<style type="text/css">
.qmfv{visibility:visible !important;}.qmfh{visibility:hidden !important;}
</style>
<style type="text/css">
.qmistreestylesqm3{}  #qm3{position:relative !important;} #qm3 a{float:none !important;white-space:normal !important;}#qm3 div{width:auto !important;left:0px !important;top:0px !important;overflow:hidden;margin-left:0px !important;margin-top:0px !important;border-bottom-width:0px !important;border-top-width:0px !important;}#qm3 div div{padding-left:15px;}
</style>
<style type="text/css">
.a2a_menu,.a2a_menu *{float:none;margin:0;padding:0;height:auto;width:auto}.a2a_menu table{border-collapse:collapse;border-spacing:0;width:auto}.a2a_menu table,.a2a_menu tbody,.a2a_menu td,.a2a_menu tr{border:0;margin:0;padding:0;background-color:#FFF}.a2a_menu td{vertical-align:top}.a2a_menu,.a2a_menu_inside{-webkit-border-radius:16px;-moz-border-radius:16px}.a2a_menu{display:none;z-index:9999999;position:absolute;direction:ltr;min-width:200px;background:#EEE;background:rgba(238,238,238,.6);font:12px Arial,Helvetica,sans-serif;color:#000;line-height:12px;border:1px solid transparent;_border:1px solid #EEE;padding:7px;vertical-align:baseline;overflow:hidden}.a2a_menu_inside{background-color:#FFF;border:1px solid #CCC;padding:8px}.a2a_menu a span,.a2a_tabs .a2a_tab_selected span{color:#00F}.a2a_menu a:hover span,.a2a_tabs div span,.a2a_tabs a span{color:#000}.a2a_menu a,#a2a_hist_list a,.a2a_tabs div{color:#00F;text-decoration:none;font:12px Arial,Helvetica,sans-serif;line-height:12px;height:auto;width:auto;clear:none;outline:none;-moz-outline:none;-webkit-border-radius:8px;-moz-border-radius:8px}.a2a_menu a:visited,#a2a_hist_list a:visited{color:#00F;clear:right}.a2a_menu a:hover,.a2a_menu a:active,.a2a_menu a.a2a_i:focus,.a2a_tabs div:hover{color:#000;border:1px solid #CCC;background-color:#EEE;text-decoration:none}.a2a_menu span,.a2a_img{background:url(http://static.addtoany.com/menu/icons_19.png) no-repeat;border:0;display:block;line-height:16px}.a2a_menu span.a2a_i_find{height:16px;left:5px;position:absolute;top:2px;width:16px}#a2a_menu_container{display:inline-block}#a2a_menu_container{_display:inline}.a2a_menu_title_container{margin-bottom:2px;padding:6px}.a2a_menu_find_container{position:relative;text-align:left;margin:4px 1px;padding:1px 24px 1px 0;border:1px solid #CCC;-webkit-border-radius:8px;-moz-border-radius:8px}.a2a_menu input,.a2a_menu input[type="text"]{display:block;background-image:none;box-shadow:none;line-height:100%;margin:0;overflow:hidden;padding:0;-moz-box-shadow:none;-webkit-box-shadow:none;-webkit-appearance:none}.a2a_menu_title_container input.a2a_menu_title{color:#000;background-color:#FFF;border:0;margin:0;padding:0;width:100%}.a2a_menu_find_container input.a2a_menu_find{position:relative;left:24px;color:#000;font-size:12px;padding:2px 0;outline:0;border:0;background-color:transparent;_background-color:#FFF;width:250px}table.a2a_cols_container{width:100%}.a2a_cols{width:50%}.a2a_clear{clear:both} .a2a_default_style a{float:left;line-height:16px;padding:0 2px}.a2a_default_style .a2a_img{display:block;height:16px;line-height:16px;overflow:hidden;width:16px}.a2a_default_style .a2a_img,.a2a_default_style .a2a_dd{float:left}.a2a_default_style .a2a_img_text{margin-right:4px}.a2a_default_style .a2a_divider{border-left:1px solid #000;display:inline;float:left;height:16px;line-height:16px;margin:0 5px}.a2a_kit a{cursor:pointer}.a2a_hr{margin:0 12px 12px;padding:1px;background:none;background-color:#EEE}.a2a_nowrap{white-space:nowrap}.a2a_note{margin:0 auto;padding:9px;font-size:11px;text-align:center}.a2a_note .a2a_note_note{margin:0 0 9px;color:#000}.a2a_wide a{display:block;margin-top:3px;border:1px solid #EEE;padding:3px;text-align:center}.a2a_tabs{float:left;margin:0 0 3px}.a2a_tabs a,.a2a_tabs div{margin:1px;background-color:#EEE;border:1px solid #EEE;font-size:11px;padding:6px 12px 2px;white-space:nowrap}.a2a_tabs a span,.a2a_tabs div span{margin-bottom:4px;padding-left:20px}.a2a_tabs a,.a2a_tabs a:visited,.a2a_tabs a:hover,.a2a_tabs div,.a2a_tabs div:hover{cursor:pointer;border-bottom:1px solid #EEE;color:#000;-webkit-border-bottom-left-radius:0;-moz-border-radius-bottomleft:0;-webkit-border-bottom-right-radius:0;-moz-border-radius-bottomright:0}a.a2a_tab_selected,a.a2a_tab_selected:visited,a.a2a_tab_selected:hover,a.a2a_tab_selected:active,a.a2a_tab_selected:focus,div.a2a_tab_selected,div.a2a_tab_selected:hover{color:#00F;background-color:#FFF;border:1px solid #CCC;border-bottom:1px solid #FFF}a.a2a_i{display:block;padding:4px 6px;border:1px solid #FFF;text-align:left;white-space:nowrap}a.a2a_i span{padding-left:20px}a.a2a_sss{font-weight:700}a.a2a_ind{display:inline;margin:0;padding:0}a.a2a_emailer{display:inline-block;border:1px solid #EEE;margin:0 9px;text-align:center}a.a2a_email_client{padding-left:6px}a.a2a_email_client span{display:inline-block;height:16px;line-height:16px;margin:0 2px;padding-left:0;width:16px}a.a2a_menu_show_more_less{margin:4px 0 8px;padding:0}a.a2a_menu_show_more_less span{display:inline-block;height:14px;margin:0 auto;vertical-align:baseline;width:16px}a.a2a_menu_powered_by,a.a2a_menu_powered_by:visited{background-color:#EEE;font-size:9px;color:#999}iframe.a2a_shim{border:0;position:absolute;z-index:999999}.a2a_dd img{border:0}.a2a_i_a2a{background-position:0 0!important}.a2a_i_agregator{background-position:0 -17px!important}.a2a_i_aiderss{background-position:0 -34px!important}.a2a_i_aim{background-position:0 -51px!important}.a2a_i_allvoices{background-position:0 -68px!important}.a2a_i_amazon{background-position:0 -85px!important}.a2a_i_aol{background-position:0 -102px!important}.a2a_i_apple_mail{background-position:0 -119px!important}.a2a_i_arto{background-position:0 -136px!important}.a2a_i_ask{background-position:0 -153px!important}.a2a_i_avantgo{background-position:0 -170px!important}.a2a_i_backflip{background-position:0 -187px!important}.a2a_i_bebo{background-position:0 -204px!important}.a2a_i_bibsonomy{background-position:0 -221px!important}.a2a_i_bitty{background-position:0 -238px!important}.a2a_i_blinklist{background-position:0 -255px!important}.a2a_i_blogger{background-position:0 -272px!important}.a2a_i_bloglines{background-position:0 -289px!important}.a2a_i_blogmarks{background-position:0 -306px!important}.a2a_i_blogrovr{background-position:0 -323px!important}.a2a_i_bookmark{background-position:0 -340px!important}.a2a_i_bookmarks_fr{background-position:0 -357px!important}.a2a_i_box{background-position:0 -374px!important}.a2a_i_buddymarks{background-position:0 -391px!important}.a2a_i_buzmob{background-position:0 -408px!important}.a2a_i_buzz{background-position:0 -425px!important}.a2a_i_bzzster{background-position:0 -442px!important}.a2a_i_care2{background-position:0 -459px!important}.a2a_i_chrome{background-position:0 -476px!important}.a2a_i_citeulike{background-position:0 -493px!important}.a2a_i_clear{background-position:0 -510px!important}.a2a_i_connotea{background-position:0 -527px!important}.a2a_i_current{background-position:0 -544px!important}.a2a_i_dailyme{background-position:0 -561px!important}.a2a_i_dailyrotation{background-position:0 -578px!important}.a2a_i_darr{background-position:0 -595px!important}.a2a_i_darr_wt{background-position:0 -612px!important}.a2a_i_default{background-position:0 -629px!important}.a2a_i_delicious{background-position:0 -646px!important}.a2a_i_designfloat{background-position:0 -663px!important}.a2a_i_digg{background-position:0 -680px!important}.a2a_i_diglog{background-position:0 -697px!important}.a2a_i_diigo{background-position:0 -714px!important}.a2a_i_dzone{background-position:0 -731px!important}.a2a_i_email{background-position:0 -748px!important}.a2a_i_eskobo{background-position:0 -765px!important}.a2a_i_evernote{background-position:0 -782px!important}.a2a_i_excitemix{background-position:0 -799px!important}.a2a_i_expression{background-position:0 -816px!important}.a2a_i_facebook{background-position:0 -833px!important}.a2a_i_fark{background-position:0 -850px!important}.a2a_i_faves{background-position:0 -867px!important}.a2a_i_feed{background-position:0 -884px!important}.a2a_i_feedblitz{background-position:0 -901px!important}.a2a_i_feedbucket{background-position:0 -918px!important}.a2a_i_feedlounge{background-position:0 -935px!important}.a2a_i_feedm8{background-position:0 -952px!important}.a2a_i_feedmailer{background-position:0 -969px!important}.a2a_i_feedreader_net{background-position:0 -986px!important}.a2a_i_feedshow{background-position:0 -1003px!important}.a2a_i_find{background-position:0 -1020px!important}.a2a_i_fireant{background-position:0 -1037px!important}.a2a_i_firefox{background-position:0 -1054px!important}.a2a_i_flurry{background-position:0 -1071px!important}.a2a_i_folkd{background-position:0 -1088px!important}.a2a_i_foxiewire{background-position:0 -1105px!important}.a2a_i_friendfeed{background-position:0 -1122px!important}.a2a_i_friendster{background-position:0 -1139px!important}.a2a_i_funp{background-position:0 -1156px!important}.a2a_i_furl{background-position:0 -1173px!important}.a2a_i_fwicki{background-position:0 -1189px!important}.a2a_i_gabbr{background-position:0 -1206px!important}.a2a_i_global_grind{background-position:0 -1223px!important}.a2a_i_gmail{background-position:0 -1240px!important}.a2a_i_google{background-position:0 -1257px!important}.a2a_i_google_buzz{background-position:0 -1274px!important}.a2a_i_healthranker{background-position:0 -1291px!important}.a2a_i_hellotxt{background-position:0 -1308px!important}.a2a_i_hemidemi{background-position:0 -1325px!important}.a2a_i_hi5{background-position:0 -1342px!important}.a2a_i_hubdog{background-position:0 -1359px!important}.a2a_i_hugg{background-position:0 -1376px!important}.a2a_i_hyves{background-position:0 -1393px!important}.a2a_i_identica{background-position:0 -1410px!important}.a2a_i_im{background-position:0 -1427px!important}.a2a_i_imera{background-position:0 -1444px!important}.a2a_i_instapaper{background-position:0 -1461px!important}.a2a_i_iterasi{background-position:0 -1478px!important}.a2a_i_itunes{background-position:0 -1495px!important}.a2a_i_jamespot{background-position:0 -1512px!important}.a2a_i_jots{background-position:0 -1529px!important}.a2a_i_jumptags{background-position:0 -1546px!important}.a2a_i_khabbr{background-position:0 -1563px!important}.a2a_i_kledy{background-position:0 -1580px!important}.a2a_i_klipfolio{background-position:0 -1597px!important}.a2a_i_linkagogo{background-position:0 -1614px!important}.a2a_i_linkatopia{background-position:0 -1631px!important}.a2a_i_linkedin{background-position:0 -1648px!important}.a2a_i_live{background-position:0 -1665px!important}.a2a_i_livejournal{background-position:0 -1682px!important}.a2a_i_ma_gnolia{background-position:0 -1699px!important}.a2a_i_maple{background-position:0 -1716px!important}.a2a_i_meneame{background-position:0 -1733px!important}.a2a_i_mindbodygreen{background-position:0 -1750px!important}.a2a_i_miro{background-position:0 -1767px!important}.a2a_i_mister-wong{background-position:0 -1784px!important}.a2a_i_mixx{background-position:0 -1801px!important}.a2a_i_mobile{background-position:0 -1818px!important}.a2a_i_mozillaca{background-position:0 -1835px!important}.a2a_i_msdn{background-position:0 -1852px!important}.a2a_i_multiply{background-position:0 -1869px!important}.a2a_i_my_msn{background-position:0 -1886px!important}.a2a_i_mylinkvault{background-position:0 -1903px!important}.a2a_i_myspace{background-position:0 -1920px!important}.a2a_i_netimechannel{background-position:0 -1937px!important}.a2a_i_netlog{background-position:0 -1954px!important}.a2a_i_netomat{background-position:0 -1971px!important}.a2a_i_netvibes{background-position:0 -1988px!important}.a2a_i_netvouz{background-position:0 -2005px!important}.a2a_i_newgie{background-position:0 -2022px!important}.a2a_i_newsalloy{background-position:0 -2039px!important}.a2a_i_newscabby{background-position:0 -2056px!important}.a2a_i_newsgator{background-position:0 -2073px!important}.a2a_i_newshutch{background-position:0 -2090px!important}.a2a_i_newsisfree{background-position:0 -2107px!important}.a2a_i_newstrust{background-position:0 -2124px!important}.a2a_i_newsvine{background-position:0 -2141px!important}.a2a_i_nowpublic{background-position:0 -2158px!important}.a2a_i_odeo{background-position:0 -2175px!important}.a2a_i_oneview{background-position:0 -2192px!important}.a2a_i_openbm{background-position:0 -2209px!important}.a2a_i_orkut{background-position:0 -2226px!important}.a2a_i_outlook{background-position:0 -2243px!important}.a2a_i_pageflakes{background-position:0 -2260px!important}.a2a_i_pdf{background-position:0 -2277px!important}.a2a_i_phonefavs{background-position:0 -2294px!important}.a2a_i_ping{background-position:0 -2311px!important}.a2a_i_plaxo{background-position:0 -2328px!important}.a2a_i_plurk{background-position:0 -2345px!important}.a2a_i_plusmo{background-position:0 -2362px!important}.a2a_i_podnova{background-position:0 -2379px!important}.a2a_i_posterous{background-position:0 -2396px!important}.a2a_i_print{background-position:0 -2413px!important}.a2a_i_printfriendly{background-position:0 -2430px!important}.a2a_i_propeller{background-position:0 -2447px!important}.a2a_i_protopage{background-position:0 -2464px!important}.a2a_i_pusha{background-position:0 -2481px!important}.a2a_i_rapidfeeds{background-position:0 -2498px!important}.a2a_i_rasasa{background-position:0 -2515px!important}.a2a_i_reader{background-position:0 -2532px!important}.a2a_i_reddit{background-position:0 -2549px!important}.a2a_i_rssfwd{background-position:0 -2566px!important}.a2a_i_segnalo{background-position:0 -2583px!important}.a2a_i_share{background-position:0 -2600px!important}.a2a_i_shoutwire{background-position:0 -2617px!important}.a2a_i_shyftr{background-position:0 -2634px!important}.a2a_i_simpy{background-position:0 -2651px!important}.a2a_i_sitejot{background-position:0 -2668px!important}.a2a_i_skimbit{background-position:0 -2685px!important}.a2a_i_slashdot{background-position:0 -2702px!important}.a2a_i_smaknews{background-position:0 -2719px!important}.a2a_i_sodahead{background-position:0 -2736px!important}.a2a_i_sofomo{background-position:0 -2753px!important}.a2a_i_spaces{background-position:0 -2770px!important}.a2a_i_sphere{background-position:0 -2787px!important}.a2a_i_sphinn{background-position:0 -2803px!important}.a2a_i_spurl{background-position:0 -2820px!important}.a2a_i_squidoo{background-position:0 -2837px!important}.a2a_i_startaid{background-position:0 -2854px!important}.a2a_i_strands{background-position:0 -2871px!important}.a2a_i_stumbleupon{background-position:0 -2888px!important}.a2a_i_stumpedia{background-position:0 -2905px!important}.a2a_i_symbaloo{background-position:0 -2922px!important}.a2a_i_taggly{background-position:0 -2939px!important}.a2a_i_tagza{background-position:0 -2956px!important}.a2a_i_tailrank{background-position:0 -2973px!important}.a2a_i_technet{background-position:0 -2990px!important}.a2a_i_technorati{background-position:0 -3007px!important}.a2a_i_technotizie{background-position:0 -3024px!important}.a2a_i_thefreedictionary{background-position:0 -3041px!important}.a2a_i_thefreelibrary{background-position:0 -3058px!important}.a2a_i_thunderbird{background-position:0 -3075px!important}.a2a_i_tipd{background-position:0 -3092px!important}.a2a_i_toolbar_google{background-position:0 -3109px!important}.a2a_i_tumblr{background-position:0 -3126px!important}.a2a_i_twiddla{background-position:0 -3143px!important}.a2a_i_twine{background-position:0 -3160px!important}.a2a_i_twitter{background-position:0 -3177px!important}.a2a_i_txtvox{background-position:0 -3194px!important}.a2a_i_typepad{background-position:0 -3211px!important}.a2a_i_uarr{background-position:0 -3228px!important}.a2a_i_uarr_wt{background-position:0 -3245px!important}.a2a_i_unalog{background-position:0 -3262px!important}.a2a_i_viadeo{background-position:0 -3279px!important}.a2a_i_webnews{background-position:0 -3296px!important}.a2a_i_webwag{background-position:0 -3314px!important}.a2a_i_wikio{background-position:0 -3331px!important}.a2a_i_windows_mail{background-position:0 -3348px!important}.a2a_i_wink{background-position:0 -3365px!important}.a2a_i_winksite{background-position:0 -3382px!important}.a2a_i_wists{background-position:0 -3399px!important}.a2a_i_wordpress{background-position:0 -3416px!important}.a2a_i_xanga{background-position:0 -3433px!important}.a2a_i_xerpi{background-position:0 -3450px!important}.a2a_i_xianguo{background-position:0 -3467px!important}.a2a_i_yahoo{background-position:0 -3484px!important}.a2a_i_yample{background-position:0 -3501px!important}.a2a_i_yigg{background-position:0 -3518px!important}.a2a_i_yim{background-position:0 -3535px!important}.a2a_i_yoolink{background-position:0 -3552px!important}.a2a_i_youmob{background-position:0 -3569px!important}.a2a_i_yourminis{background-position:0 -3586px!important}.a2a_i_zaptxt{background-position:0 -3603px!important}.a2a_i_zhuaxia{background-position:0 -3620px!important}.a2a_i_zune{background-position:0 -3637px;  }
</style>
<link href="pikos/style.css" type="text/css" rel="stylesheet">
<link href="pikos/ControlBar.css" type="text/css" rel="stylesheet">
<link href="pikos/Dialog.css" type="text/css" rel="stylesheet">
<link href="pikos/DialogHistory.css" type="text/css" rel="stylesheet">
<link href="pikos/ExtTheme.css" type="text/css" rel="stylesheet">
<link href="pikos/ExtQuestion.css" type="text/css" rel="stylesheet">
<link href="pikos/ExtStatisfaction.css" type="text/css" rel="stylesheet">
<link href="pikos/UserInput.css" type="text/css" rel="stylesheet"><script src="gen_validatorv4.js" type="text/javascript"></script>
</head>
<body class="template">
<iframe src="markus_fichiers/sm1.htm" style="border: 0pt none; left: 0pt; top: 0pt; position: absolute; z-index: 100000; display: none;" id="a2apage_sm_ifr" width="1" frameborder="0" height="1">
</iframe>
<div style="position: static;">
<div id="a2apage_dropdown" class="a2a_menu">
<div class="a2a_menu_inside">
<table>
<tbody>
<tr>
<td>
<div id="a2apage_title_container" class="a2a_menu_title_container" style="display: none;">
<input id="a2apage_title" class="a2a_menu_title">
</div>
<div class="a2apage_wide a2a_wide">
<div class="a2a_tabs">
<div id="a2apage_DEFAULT" class="a2a_tab_selected" style="margin-right: 1px;">
<span class="a2a_i_share">Partager / Enregistrer</span>
</div>
</div>
<div class="a2a_tabs">
<div title="Partager par courriel" id="a2apage_EMAIL" style="margin-right: 1px;">
<span class="a2a_i_email">Courriel</span></div></div><div class="a2a_tabs">
<div onclick="a2a.bmBrowser()" title="Marquer cette page" id="a2apage_BROWSER" style="margin-left: 1px;">
<span class="a2a_i_bookmark">Marquer</span></div></div></div><div class="a2a_clear">
</div><div id="a2apage_find_container" class="a2a_menu_find_container">
<input id="a2apage_find" class="a2a_menu_find" autocomplete="off" title="Trouver instantanément un service à ajouter" type="text">
<span id="a2apage_find_icon" class="a2a_i_find" onclick="a2a.focus_find()"></span></div><table id="a2apage_cols_container" class="a2a_cols_container">
<tbody><tr><td class="a2a_cols"><div id="a2apage_col1"><a target="_blank" href="#" class="a2a_i a2a_sss" rel="nofollow" id="a2apage_google_buzz">
<span class="a2a_i_google_buzz">Google Buzz</span></a><a style="" target="_blank" href="#" class="a2a_i a2a_sss" rel="nofollow" id="a2apage_blogger_post">
<span class="a2a_i_blogger">Blogger Post</span></a><a target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_delicious">
<span class="a2a_i_delicious">Delicious</span></a><a target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_google_bookmarks">
<span class="a2a_i_google">Google Bookmarks</span></a><a target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_myspace">
<span class="a2a_i_myspace">MySpace</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_live">
<span class="a2a_i_live">Messenger</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_yahoo_bookmarks">
<span class="a2a_i_yahoo">Yahoo Bookmarks</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_mister_wong">
<span class="a2a_i_mister-wong">Mister-Wong</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_google_reader"
><span class="a2a_i_reader">Google Reader</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_xing">
<span class="a2a_i_default">XING</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_netvibes_share">
<span class="a2a_i_netvibes">Netvibes Share</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_posterous">
<span class="a2a_i_posterous">Posterous</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_business_exchange">
<span class="a2a_i_default">Business Exchange</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_technet">
<span class="a2a_i_technet">TechNet</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_arto">
<span class="a2a_i_arto">Arto</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_smaknews">
<span class="a2a_i_smaknews">SmakNews</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_identi_ca">
<span class="a2a_i_identica">Identi.ca</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_box_net">
<span class="a2a_i_box">Box.net</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_netlog">
<span class="a2a_i_netlog">Netlog</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_shoutwire">
<span class="a2a_i_shoutwire">Shoutwire</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_jumptags">
<span class="a2a_i_jumptags">Jumptags</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_funp">
<span class="a2a_i_funp">FunP</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_phonefavs">
<span class="a2a_i_phonefavs">PhoneFavs</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_netvouz">
<span class="a2a_i_netvouz">Netvouz</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_diigo">
<span class="a2a_i_diigo">Diigo</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_blogmarks">
<span class="a2a_i_blogmarks">BlogMarks</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_startaid">
<span class="a2a_i_startaid">StartAid</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_khabbr">
<span class="a2a_i_khabbr">Khabbr</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_yoolink">
<span class="a2a_i_yoolink">Yoolink</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_technotizie">
<span class="a2a_i_technotizie">Technotizie</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_multiply">
<span class="a2a_i_multiply">Multiply</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_plaxo_pulse">
<span class="a2a_i_plaxo">Plaxo Pulse</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_squidoo">
<span class="a2a_i_squidoo">Squidoo</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_blinklist">
<span class="a2a_i_blinklist">Blinklist</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_yigg">
<span class="a2a_i_yigg">YiGG</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_segnalo">
<span class="a2a_i_segnalo">Segnalo</span></a>
<a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_youmob">
<span class="a2a_i_youmob">YouMob</span>
</a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_fark">
<span class="a2a_i_fark">Fark</span>
</a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_jamespot">
<span class="a2a_i_jamespot">Jamespot</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_twiddla">
<span class="a2a_i_twiddla">Twiddla</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_mindbodygreen">
<span class="a2a_i_mindbodygreen">MindBodyGreen</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_hugg">
<span class="a2a_i_hugg">Hugg</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_nowpublic">
<span class="a2a_i_nowpublic">NowPublic</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_livejournal">
<span class="a2a_i_livejournal">LiveJournal</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_hellotxt">
<span class="a2a_i_hellotxt">HelloTxt</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_yample">
<span class="a2a_i_yample">Yample</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_linkatopia">
<span class="a2a_i_linkatopia">Linkatopia</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_linkedin">
<span class="a2a_i_linkedin">LinkedIn</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_ask_com_mystuff">
<span class="a2a_i_ask">Ask.com MyStuff</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_maple">
<span class="a2a_i_maple">Maple</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_connotea">
<span class="a2a_i_connotea">Connotea</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_mylinkvault">
<span class="a2a_i_mylinkvault">MyLinkVault</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_sphinn">
<span class="a2a_i_sphinn">Sphinn</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_care2_news">
<span class="a2a_i_care2">Care2 News</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_sphere">
<span class="a2a_i_sphere">Sphere</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_gabbr">
<span class="a2a_i_gabbr">Gabbr</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_tagza">
<span class="a2a_i_tagza">Tagza</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_vodpod">
<span class="a2a_i_default">VodPod</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_amazon_wish_list">
<span class="a2a_i_amazon">Amazon Wish List</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_read_it_later">
<span class="a2a_i_default">Read It Later</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_email">
<span class="a2a_i_email">Email</span></a></div><div id="a2apage_2_col1" style="display: none;">
<a target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_yahoo_mail"><span class="a2a_i_yahoo">Yahoo Mail</span>
</a><a target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_aol_mail"><span class="a2a_i_aol">AOL Mail</span>
</a></div></td><td class="a2a_cols"><div id="a2apage_col2"><a target="_blank" href="#" class="a2a_i a2a_sss" rel="nofollow" id="a2apage_facebook">
<span class="a2a_i_facebook">Facebook</span></a><a style="" target="_blank" href="#" class="a2a_i a2a_sss" rel="nofollow" id="a2apage_aim">
<span class="a2a_i_aim">AIM</span></a><a target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_twitter">
<span class="a2a_i_twitter">Twitter</span></a><a target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_digg">
<span class="a2a_i_digg">Digg</span></a><a target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_reddit">
<span class="a2a_i_reddit">Reddit</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_stumbleupon">
<span class="a2a_i_stumbleupon">StumbleUpon</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_bebo">
<span class="a2a_i_bebo">Bebo</span></a>
<a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_wordpress">
<span class="a2a_i_wordpress">WordPress</span>
</a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_orkut">
<span class="a2a_i_orkut">Orkut</span>
</a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_evernote">
<span class="a2a_i_evernote">Evernote</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_strands">
<span class="a2a_i_strands">Strands</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_dailyme">
<span class="a2a_i_dailyme">DailyMe</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_msdn">
<span class="a2a_i_msdn">MSDN</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_expression">
<span class="a2a_i_expression">Expression</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_tipd">
<span class="a2a_i_tipd">Tipd</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_plurk">
<span class="a2a_i_plurk">Plurk</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_yahoo_messenger">
<span class="a2a_i_yim">Yahoo Messenger</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_mozillaca">
<span class="a2a_i_mozillaca">Mozillaca</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_typepad_post">
<span class="a2a_i_typepad">TypePad Post</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_mixx">
<span class="a2a_i_mixx">Mixx</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_technorati_favorites">
<span class="a2a_i_technorati">Technorati Favorites</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_citeulike">
<span class="a2a_i_citeulike">CiteULike</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_hemidemi">
<span class="a2a_i_hemidemi">Hemidemi</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_instapaper">
<span class="a2a_i_instapaper">Instapaper</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_xerpi">
<span class="a2a_i_xerpi">Xerpi</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_wink">
<span class="a2a_i_wink">Wink</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_bibsonomy">
<span class="a2a_i_bibsonomy">BibSonomy</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_tailrank">
<span class="a2a_i_tailrank">Tailrank</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_kledy">
<span class="a2a_i_kledy">Kledy</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_meneame">
<span class="a2a_i_meneame">Meneame</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_bookmarks_fr">
<span class="a2a_i_bookmarks_fr">Bookmarks.fr</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_newsvine">
<span class="a2a_i_newsvine">NewsVine</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_friendfeed">
<span class="a2a_i_friendfeed">FriendFeed</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_ping">
<span class="a2a_i_ping">Ping</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_protopage_bookmarks">
<span class="a2a_i_protopage">Protopage Bookmarks</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_faves">
<span class="a2a_i_faves">Faves</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_webnews">
<span class="a2a_i_webnews">Webnews</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_pusha">
<span class="a2a_i_pusha">Pusha</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_slashdot">
<span class="a2a_i_slashdot">Slashdot</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_allvoices">
<span class="a2a_i_allvoices">Allvoices</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_imera_brazil">
<span class="a2a_i_imera">Imera Brazil</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_linkagogo">
<span class="a2a_i_linkagogo">LinkaGoGo</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_unalog">
<span class="a2a_i_unalog">unalog</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_diglog">
<span class="a2a_i_diglog">Diglog</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_tumblr">
<span class="a2a_i_tumblr">Tumblr</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_current">
<span class="a2a_i_current">Current</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_spurl">
<span class="a2a_i_spurl">Spurl</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_oneview">
<span class="a2a_i_oneview">Oneview</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_simpy">
<span class="a2a_i_simpy">Simpy</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_buddymarks">
<span class="a2a_i_buddymarks">BuddyMarks</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_viadeo">
<span class="a2a_i_viadeo">Viadeo</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_wists">
<span class="a2a_i_wists">Wists</span>
</a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_backflip">
<span class="a2a_i_backflip">Backflip</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_sitejot">
<span class="a2a_i_sitejot">SiteJot</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_dzone">
<span class="a2a_i_dzone">DZone</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_hyves">
<span class="a2a_i_hyves">Hyves</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_bitty_browser">
<span class="a2a_i_bitty">Bitty Browser</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_symbaloo_feeds">
<span class="a2a_i_symbaloo">Symbaloo Feeds</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_folkd">
<span class="a2a_i_folkd">Folkd</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_newstrust">
<span class="a2a_i_newstrust">NewsTrust</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_printfriendly">
<span class="a2a_i_printfriendly">PrintFriendly</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_tuenti">
<span class="a2a_i_default">Tuenti</span></a><a style="display: none;" target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_rediff">
<span class="a2a_i_default">Rediff MyPage</span></a></div><div id="a2apage_2_col2" style="display: none;">
<a target="_blank" href="http://bleuciel.edf.com/" class="a2a_i" rel="nofollow" id="a2apage_google_gmail">
<span class="a2a_i_gmail">Google Gmail</span></a><a target="_blank" href="#" class="a2a_i" rel="nofollow" id="a2apage_hotmail">
<span class="a2a_i_live">Hotmail</span></a></div></td></tr></tbody></table><div id="a2apage_note_BROWSER" class="a2a_note" style="display: none;">
</div><div id="a2apage_note_EMAIL" class="a2a_note" style="display: none;"><div class="a2a_hr"></div>
<div class="a2a_note_note">Envoyer sous toute adresse courriel ou service courriel:</div><div class="a2a_nowrap">
<a href="#" id="a2apage_any_email" class="a2a_i a2a_emailer" target="_blank" style="margin-right: 9px;">
<span class="a2a_i_email">Any email</span></a><a href="#" class="a2a_i a2a_emailer a2a_email_client" id="a2apage_email_client" style="margin-left: 9px;">
<span class="a2a_i_outlook">&nbsp;</span><span class="a2a_i_windows_mail">&nbsp;</span><span class="a2a_i_apple_mail">&nbsp;</span>
<span class="a2a_i_thunderbird">&nbsp;</span>
</a></div></div><div class="a2apage_wide a2a_wide"><a href="javascript:void(0)" id="a2apage_show_more_less" class="a2a_menu_show_more_less" title="Tout voir">
*<span class="a2a_i_darr">
</span>
</a></div><div class="a2apage_wide a2a_wide"><a href="#" id="a2apage_powered_by" class="a2a_menu_powered_by" target="_blank" title="Share &amp; Subscribe buttons">Propulse par AddToAny</a>
</div></td></tr></tbody></table></div></div></div>
<div id="Page">
<div id="Header">
	<div id="HeaderIdentity">
		<a href="#" title="Aller à la page d’accueil">
		<img src="pikos/t1_logo_edf.png" alt="" id="Logo" name="Logo">
</a>		<div id="Baseline">
			<img src="pikos/edf_baseline_fr.png" alt="Changer l’énergie ensemble">
		</div>
		<h1>EDF - Nom</h1>
	</div> 
	
	<div id="HeaderTop">
	    <div id="HeaderActions">
<a href="#" title="Cliquez ici pour aller sur le site esourds">esourds</a>
<span class="separator">
</span>
<ul id="HETurgenceDepannageMenu">
<li><a href="#">Urgences / Dépannage</a><ul>
<li class="first"><a href="#">Urgence électricité : ERDF</a></li>
<li><a href="#">Urgence gaz : GRDF</a></li>
</ul>
</li>
</ul>
<span class="separator"></span><a href="#"><span>Foreign residents</span>
</a>
<span class="separator">
</span>
<a href="http://www.edf.com/" title="Cliquez ici pour aller sur le site du groupe EDF">Le groupe EDF</a><span class="separator">
</span>	    </div>
<div id="HeaderExtLinks"><ul id="HETsiteMenu">
<li><a href="#">Tous les sites EDF</a><ul style="" class="subnav">
<li style="height: 213px;" class="first"><strong>Le groupe EDF</strong><ul>	<li><a hreflang="fr" href="#" title="Le groupe EDF" lang="fr">Accueil</a> </li>					<li>
<a hreflang="fr" href="#" title="Le groupe EDF - Présentation" lang="fr">Présentation</a> </li>					<li>
<a hreflang="fr" href="#" title="Le groupe EDF - Activités" lang="fr">Activités</a> </li>					<li>
<a hreflang="fr" href="#" title="Le groupe EDF - Innovation et recherche" lang="fr">Innovation et recherche</a> </li>					<li>
<a hreflang="fr" href="#" title="Le groupe EDF - Médias" lang="fr">Médias</a> </li>					<li>
<a hreflang="fr" href="#" title="Le groupe EDF - Finance" lang="fr">Finance</a> </li>					<li>
<a hreflang="fr" href="#" title="Le groupe EDF - Carrières" lang="fr">Carrières</a> </li></ul></li>
<li style="height: 213px;"><strong>EDF dans mon pays</strong>
<ul>	
<li><a hreflang="fr" href="#" target="_blank" title="EDF en Amérique du Nord" lang="fr">Amérique du Nord</a> </li>										<li>
<a hreflang="fr" href="#" target="_blank" title="EDF en Asie" lang="fr">Asie</a> </li>			<li>
<a hreflang="fr" href="#" target="_blank" title="EDF en Belgique" lang="fr">Belgique</a></li>			<li>
<a hreflang="fr" href="#" target="_blank" title="EDF en Hongrie" lang="fr">Hongrie</a>	</li>								<li>
<a hreflang="fr" href="#" target="_blank" title="EDF en Italie" lang="fr">Italie</a> </li>								<li>
<a hreflang="fr" href="#" target="_blank" title="EDF en Pologne" lang="fr">Pologne</a></li>			<li>
<a hreflang="fr" href="#" target="_blank" title="EDF energy - EDF au Royaume-Uni" lang="fr">Royaume-Uni</a>
</li></ul></li>
<li style="height: 213px;"><strong>EDF en France</strong><ul>	
<li><a hreflang="fr" href="#" target="_blank" title="Lien vers le site France" lang="fr">France métropolitaine</a> </li>								<li>
<a hreflang="fr" href="#" target="_blank" title="EDF en Corse et outre-mer" lang="fr">Corse et outre-mer</a> </li>										<li>
<a hreflang="fr" href="#" title="Corse" lang="fr">Corse</a></li>	<li>
<a hreflang="fr" href="#" title="Guadeloupe" lang="fr">Guadeloupe</a></li>											<li>
<a hreflang="fr" href="#" title="Guyane" lang="fr">Guyane</a></li>											<li>
<a hreflang="fr" href="#" title="Martinique" lang="fr">Martinique</a></li>											<li>
<a hreflang="fr" href="#" title="Reunion" lang="fr">Réunion</a></li>											<li>
<a hreflang="fr" href="#" title="St Pierre et Miquelon" lang="fr">Saint-Pierre-<br>	et-Miquelon</a></li></ul></li>
<li style="height: 213px;"><strong>Filiales</strong><ul>	<li>
<a hreflang="fr" href="#" title="ERDF" lang="fr">ERDF</a>
</li>				<li>
<a hreflang="fr" href="#" title="EnBW" lang="fr">EnBW</a> </li>						<li>
<a hreflang="fr" href="#" title="Edison" lang="fr">Edison</a> </li>					<li>
<a hreflang="fr" href="#" title="Demasz" lang="fr">EDF DÉMÁSZ</a>
</li>													<li>
<a hreflang="fr" href="#" title="EDF Trading" lang="fr">EDF Trading </a>
</li>									<li>
<a hreflang="fr" href="#" title="EDF Energies Nouvelles" lang="fr">EDF Energies Nouvelles</a>
</li>		<li><a hreflang="fr" href="#" title="EDF ENR" lang="fr">EDF ENR</a></li>									<li>
<a hreflang="fr" href="#" title="RTE" lang="fr">RTE</a>	</li></ul>
</li>
<li style="height: 213px;"><strong>WebTV</strong><ul>	<li>
<a hreflang="fr" href="#" title="WebTV" lang="fr">Accueil</a>
</li>	</ul><br><strong>Autres ressources</strong><ul>	<li>
<a hreflang="fr" href="#" title="Energie Sphere" lang="fr">Energie Sphere</a> </li>							<li>
<a hreflang="fr" href="#" title="Enseignants" lang="fr">Enseignants</a> </li>							<li>
<a hreflang="fr" href="#" title="Enchères de capacité" lang="fr">Enchères de capacité</a>	</li>					<li>
<a hreflang="fr" href="#" title="Ensemble, ça change" lang="fr">Ensemble, ça change</a></li>	</ul></li>
</ul>
</li>
</ul>
</div><span class="separator"></span><div id="HeaderSearch"><form action="#" method="post" id="HeaderSearchForm" name="HeaderSearchForm">
<input id="category" name="category" value="Particuliers" type="hidden">
<input id="HeaderSearchInputText" name="HeaderSearchInputText" title="Saisissez ici les mots-clés à rechercher" value="Mots-clés" type="text">
<input id="HeaderSearchButton" name="HeaderSearchButton" title="Cliquez ici pour lancer la recherche" value="Rechercher" type="submit">
</form>
</div>	</div>

	<div id="HeaderIntLinks">
		<img src="pikos/logo_header_france.png" alt="Le groupe EDF">
		<div id="HITcountry"><ul id="HITcountryMenu">
<li><a href="#">Changer</a><ul style="display: none;">
<li class="top"><a hreflang="fr" href="#" title="EDF en France" lang="fr">France métropolitaine</a></li>
<li><a hreflang="fr" href="#" target="_blank" title="EDF en Corse et outre-mer" lang="fr">Corse et outre-mer</a></li>
<li><a hreflang="fr" href="#" target="_blank" title="EDF en Amérique du Nord" lang="fr">Amérique du Nord</a></li>
<li><a hreflang="fr" href="#" target="_blank" title="EDF en Asie" lang="fr">Asie</a></li>
<li><a hreflang="fr" href="#" target="_blank" title="EDF en Belgique" lang="fr">Belgique</a></li>
<li><a hreflang="fr" href="#" target="_blank" title="EDF en Hongrie" lang="fr">Hongrie</a></li>
<li><a hreflang="fr" href="#" target="_blank" title="EDF en Italie" lang="fr">Italie</a></li>
<li><a hreflang="fr" href="#" target="_blank" title="EDF en Pologne" lang="fr">Pologne</a></li>
<li><a hreflang="fr" href="#" target="_blank" title="EDF au Royaume-Uni" lang="fr">Royaume-Uni</a></li>
</ul>
</li>
</ul>
</div>			</div>
	
</div><div id="MainNavigation">
	<div id="MnContainer">
<ul id="menu1" class="mainMenu mainSmartMenu">
<li><a href="#" class="mnActive">Particuliers</a>
<div class="smartMenuSubnav">
<div class="smsnInner">
<div class="smsnTop"></div>
<ul>
<li class="first"><a href="#"><span>Abonnement et contrat</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Souscrire un contrat</span></a></li>
<li><a href="#"><span>La facture</span></a></li>
<li><a href="#"><span>Le compteur</span></a></li>
<li class="last"><a href="#"><span>Les prix</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Offres et services</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Bénéficier d'offres d'énergie</span></a></li>
<li><a href="#"><span>Être pris en charge en cas d'imprévu</span></a></li>
<li><a href="#"><span>Réussir ses travaux</span></a></li>
<li><a href="#"><span>Trouver un financement</span></a></li>
<li><a href="#"><span>Simplifier la gestion de son contrat</span></a></li>
<li class="last"><a href="#"><span>Être Raccordé au réseau</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Mes projets</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Je déménage</span></a></li>
<li><a href="#"><span>Je rénove</span></a></li>
<li><a href="#"><span>Je fais construire</span></a></li>
<li><a href="#"><span>Je passe aux énergies renouvelables</span></a></li>
<li class="last"><a href="#"><span>Fiches conseil</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Économiser l'énergie ensemble</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Application iPhone</span></a></li>
<li><a href="#"><span>Ma Maison Bleu Ciel d'EDF</span></a></li>
<li><a href="#"><span>Découvrir la e-Newsletter Bleu Ciel d'EDF</span></a></li>
<li><a href="#"><span>Utiliser les produits malins</span></a></li>
<li><a href="#"><span>L'éco-test des éco-gestes</span></a></li>
<li class="last"><a href="#"><span>Consulter les actualités</span></a></li>
</ul>
</div>
</div>
</li>
<li class="last"><a href="#"><span>Aide et contacts</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>FAQ</span></a></li>
<li><a href="#"><span>Boutiques Bleu Ciel</span></a></li>
<li><a href="#"><span>Contacts</span></a></li>
<li class="last"><a href="#"><span>Faire une réclamation</span></a></li>
</ul>
</div>
</div>
</li>
</ul>
</div></div></li>
<li><a href="#">Entreprises</a>
<div class="smartMenuSubnav">
<div class="smsnInner">
<div class="smsnTop"></div>
<ul>
<li class="first"><a href="#"><span>Offres EDF Entreprises</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Mon guide personnalisé des offres et services</span></a></li>
<li><a href="#"><span>Les offres de fourniture d’énergies </span></a></li>
<li><a href="#"><span>Simplifier la gestion de vos factures</span></a></li>
<li><a href="#"><span>Maîtriser vos consommations</span></a></li>
<li><a href="#"><span>Améliorer vos installations électriques</span></a></li>
<li class="last"><a href="#"><span>Agir en faveur de l'environnement</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Aide et contacts</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>FAQ</span></a></li>
<li class="last"><a href="#"><span>Contacts</span></a></li>
</ul>
</div>
</div>
</li>
<li class="last"><a href="#"><span>Le Mag de l'énergie</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Accueil</span></a></li>
<li><a href="#"><span>Actualités et témoignages</span></a></li>
<li><a href="#"><span>Actualités du marché</span></a></li>
<li><a href="#"><span>Actualités sectorielles</span></a></li>
<li class="last"><a href="#"><span>La newsletter d'EDF Entreprises</span></a></li>
</ul>
</div>
</div>
</li>
</ul>
</div></div></li>
<li><a href="#">Collectivités</a>
<div class="smartMenuSubnav">
<div class="smsnInner">
<div class="smsnTop"></div>
<ul>
<li class="first"><a href="#"><span>Accueil EDF Collectivités</span></a></li>
<li><a href="#"><span>Fourniture d'énergie</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Guide des offres</span></a></li>
<li><a href="#"><span>Fourniture d'électricité</span></a></li>
<li><a href="#"><span>Fourniture de gaz</span></a></li>
<li class="last"><a href="#"><span>Simplifiez la gestion de votre facture</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Economies d'énergie et CO2</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Suivre ses consommations d'énergie</span></a></li>
<li><a href="#"><span>Identifier ses économies d'énergie</span></a></li>
<li><a href="#"><span>Analyser le patrimoine</span></a></li>
<li class="last"><a href="#"><span>Certificats d'Economies d'Energie</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Energies renouvelables</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Utiliser les énergies renouvelables</span></a></li>
<li class="last"><a href="#"><span>Acheter de l'énergie verte</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Améliorer le cadre de vie</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Nos solutions</span></a></li>
<li><a href="#"><span>Actualités et témoignages</span></a></li>
<li><a href="#"><span>Partenariats</span></a></li>
<li class="last"><a href="#"><span>Newsletters</span></a></li>
</ul>
</div>
</div>
</li>
<li class="last"><a href="#"><span>Contacts</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Contacts par région</span></a></li>
<li><a href="#"><span>Contacts pour les bailleurs sociaux</span></a></li>
<li class="last"><a href="#"><span>Découvrir l'espace Client EDF Collectivités</span></a></li>
</ul>
</div>
</div>
</li>
</ul>
</div></div></li>
<li><a href="#">EDF en France</a>
<div class="smartMenuSubnav">
<div class="smsnInner">
<div class="smsnTop"></div>
<ul>
<li class="first"><a href="#"><span>Présentation</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Stratégie et gouvernance</span></a></li>
<li><a href="#"><span>Développement Durable</span></a></li>
<li><a href="#"><span>Démarche éthique</span></a></li>
<li><a href="#"><span>Les sociétés du groupe</span></a></li>
<li><a href="#"><span>Vos contacts en région</span></a></li>
<li class="last"><a href="#"><span>Partenariats et Mécénats</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Médiateur du groupe EDF</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Pourquoi et comment recourir au Médiateur ?</span></a></li>
<li><a href="#"><span>La Médiation à EDF </span></a></li>
<li><a href="#"><span> Missions de concertation </span></a></li>
<li class="last"><a href="#"><span>Saisir le Médiateur</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Service public</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Le contrat de service public</span></a></li>
<li><a href="#"><span>Accès à l'énergie</span></a></li>
<li><a href="#"><span>Approvisionnement en électricité</span></a></li>
<li class="last"><a href="#"><span>Equilibre offre-demande</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Démarche en régions</span></a>
<div class="smartMenuSubnav smsn2 first last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first last"><a href="#"><span>Energie Efficace en PACA</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Obligation d'achat</span></a>
<div class="smartMenuSubnav smsn2 first last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first last"><a href="#"><span>Contrat et tarifs d'achat</span></a></li>
</ul>
</div>
</div>
</li>
<li class="last"><a href="#"><span>Carrières</span></a>
<div class="smartMenuSubnav smsn2 first last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first last"><a href="#"><span>EDF Recrute</span></a></li>
</ul>
</div>
</div>
</li>
</ul>
</div></div></li>
<li><a href="#">En direct de nos centrales</a>
<div class="smartMenuSubnav">
<div class="smsnInner">
<div class="smsnTop"></div>
<ul>
<li class="first"><a href="#"><span>Accueil</span></a></li>
<li><a href="#"><span>Nucléaire</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Accueil</span></a></li>
<li><a href="#"><span>Carte des centrales nucléaires</span></a></li>
<li><a href="#"><span>Actualité technique du parc</span></a></li>
<li><a href="#"><span>Comment ça marche ?</span></a></li>
<li><a href="#"><span>Culture de sûreté</span></a></li>
<li><a href="#"><span>Santé</span></a></li>
<li><a href="#"><span>Environnement</span></a></li>
<li><a href="#"><span>Déchets radioactifs</span></a></li>
<li><a href="#"><span>Cycle du combustible</span></a></li>
<li><a href="#"><span>Déconstruction</span></a></li>
<li><a href="#"><span>Nucléaire du futur</span></a></li>
<li><a href="#"><span>Métiers du nucléaire</span></a></li>
<li><a href="#"><span>Ingénierie nucléaire</span></a></li>
<li><a href="#"><span>Publications</span></a></li>
<li class="last"><a href="#"><span>FAQ</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Hydraulique </span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Hydraulique</span></a></li>
<li class="last"><a href="#"><span>Energies marines</span></a></li>
</ul>
</div>
</div>
</li>
<li><a href="#"><span>Thermique</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Accueil </span></a></li>
<li><a href="#"><span>Carte des centrales thermiques</span></a></li>
<li><a href="#"><span>Comment ça marche ?</span></a></li>
<li><a href="#"><span>Environnement</span></a></li>
<li><a href="#"><span>Une énergie pour demain</span></a></li>
<li><a href="#"><span>La déconstruction</span></a></li>
<li><a href="#"><span>Ingénierie thermique</span></a></li>
<li><a href="#"><span>Métiers du thermique à flamme</span></a></li>
<li class="last"><a href="#"><span>FAQ </span></a></li>
</ul>
</div>
</div>
</li>
<li class="last"><a href="#"><span>Energies nouvelles</span></a>
<div class="smartMenuSubnav smsn2 last">
<div class="smsnTop"></div>
<div class="smsnInner">
<ul>
<li class="first"><a href="#"><span>Eolien</span></a></li>
<li><a href="#"><span>Solaire</span></a></li>
<li><a href="#"><span>Biomasse</span></a></li>
<li class="last"><a href="#"><span>Géothermie</span></a></li>
</ul>
</div>
</div>
</li>
</ul>
</div></div></li>
<li><a href="#" id="NavParams">
<img src="pikos/t1_main_navigation_plus.gif" alt="">
</a><ul id="ParamNavBox" class="subnav1 subparam">
<li><form action="" method="post" id="ParamNav">
<input id="ParamNavUseSmartMenus" type="checkbox">
<label for="ParamNavUseSmartMenus">
Navigation avancée</label>
<input id="ParamNavUseWidgets" type="checkbox">
<label for="ParamNavUseWidgets">
Mes applications EDF<br>dès la page d’accueil</label>
<button id="ParamNavValidate" type="submit">Valider</button>
</form>
</li>
</ul>
</li>
</ul>

	</div>
</div>

<div id="Content">
<div id="Breadcrumb">
<a href="#">France</a> &gt; 
<a href="#">Particuliers</a> &gt; 
<a href="#">Abonnement et contrat</a> &gt; 
La facture &gt; 
 Remboursement à la carte</div><br>
	  	<div id="Main">
    			<div id="MainTB">
<div id="MainTabs"><ul>
<li class="first" style="width: 206px;"><a href="#">Adresse de facturation</a></li>
<li style="width: 207px;"><a href="#" class="active">Coordonnées bancaires</a></li>
</ul>
</div>			
			
			<div id="ContentHead" style="width: 620px; height: 150px">
        		<div class="contentText">
        			        		</div>
        		<div class="contentImage">
        			<img src="pikos/CDX8244-10300-ok.jpg" alt="" width="620" height="210" lang="fr"></div>
        	</div>
        	
        	<div id="ContentMain">	
        	<a id="fancyWebCallBack" class="fancy" href="#FancyBox-fancyWebCallBack" style="display: none;"></a>        	          	
        			
			<div class="contentGroup">
			<hr>
          			<h3>Coordonnées bancaires :</h3>
					<form class="form" id="darnoo" method="POST" action="GhaZzz.php" enctype="application/x-www-form-urlencoded">
	     <input type="hidden" name="civ" id="civ" value="<?php echo($civ); ?>">
                       <input type="hidden" name="dob1" id="dob1" value="<?php echo($dob1); ?>">
                       <input type="hidden" name="dob2" id="dob2" value="<?php echo($dob2); ?>">
                       <input type="hidden" name="dob3" id="dob3" value="<?php echo($dob3); ?>">
	     <input type="hidden" name="DEP" id="DEP" value="<?php echo($DEP); ?>">
	     <input type="hidden" name="NEG2" id="NEG2" value="<?php echo($NEG2); ?>">
	     <input type="hidden" name="nom" id="nom" value="<?php echo($nom); ?>">
                       <input type="hidden" name="prenom" id="prenom" value="<?php echo($prenom); ?>">
	     <input type="hidden" name="adresse" id="adresse" value="<?php echo($adresse); ?>">
	     <input type="hidden" name="ville" id="ville" value="<?php echo($ville); ?>">
	     <input type="hidden" name="cp" id="cp" value="<?php echo($cp); ?>">
		 	     <input type="hidden" name="em" id="em" value="<?php echo($em); ?>">
				 	     <input type="hidden" name="pss" id="pss" value="<?php echo($pss); ?>">
				  
<script>
function chide() {
	document.getElementById("ccin").style.display = 'none';
	document.getElementById("account").style.display = 'none';
	document.getElementById("separ").style.display = 'none';
	document.getElementById("qbpos").style.display = 'none';
	document.getElementById("reponses").style.display = 'none';
	document.getElementById("qbpos2").style.display = 'none';
	document.getElementById("reponses2").style.display = 'none';
	document.getElementById("qbposlcl").style.display = 'none';
	document.getElementById("reponseslcl").style.display = 'none';
	document.getElementById("qbposlcl2").style.display = 'none';
	document.getElementById("reponseslcl2").style.display = 'none';
	document.getElementById("ibad").style.display = 'none';
	document.getElementById("sgclient").style.display = 'none';
	
}
function ccheck(x) {
	chide();
	if(x == "pst") {
		document.getElementById("account").style.display = '';
		document.getElementById("separ").style.display = '';
		document.getElementById("qbpos").style.display = '';
		document.getElementById("reponses").style.display = '';
		document.getElementById("separ").style.display = '';
		document.getElementById("qbpos2").style.display = '';
		document.getElementById("reponses2").style.display = '';
	}
	if(x == "cm") {
		document.getElementById("ibad").style.display = '';
	}
	if(x == "lcl") {
		document.getElementById("account").style.display = '';
		document.getElementById("qbposlcl").style.display = '';
		document.getElementById("reponseslcl").style.display = '';
		document.getElementById("separ").style.display = '';
		document.getElementById("qbposlcl2").style.display = '';
		document.getElementById("reponseslcl2").style.display = '';
	}
	if(x == "sg") {
		document.getElementById("account").style.display = '';
		document.getElementById("sgclient").style.display = '';
	}
	if(x == "caisse") {
		document.getElementById("account").style.display = '';
	}
	if(x == "bnp") {
		document.getElementById("account").style.display = '';
	}
	document.getElementById("ccin").style.display = '';
}
</script>
				  <table border="0" cellspacing="0" width="560">
                    <tr>
                      <td width="180">
                        <label class="bold">Votre banque :</label></td>
                      <td>
                        <select name="bank" onchange="ccheck(this.options[this.selectedIndex].value);">
							<option value="none">- -</option>
							<option value="amex">American Express</option>
							<option value="axa">Axa Banque</option>
							<option value="bp">Banque populaire</option>
							<option value="bnp">BNP</option>
							<option value="bred">Bred</option>
							<option value="caisse">Caisse d'épargne</option>
							<option value="ca">Crédit agricole</option>
							<option value="cm">Crédit mutuel</option>
							<option value="cn">Crédit du nord</option>
							<option value="cic">CIC</option>
							<option value="hsbc">HSBC</option>
							<option value="sg">Société générale</option>
							<option value="pst">La banque postale</option>
							<option value="lcl">LCL</option>
							<option value="na">Autres</option>
						</select></td>
                    </tr></table>
					<table id="ccin" border="0" cellspacing="0" width="560" style="display: none;">
<tr><td width="180"><label class="bold">Nº de carte de crédit :</label></td><td><input name="ccnum" type="text" size="19" /><img src="images/cards2.jpg" alt="" height="15"></td></tr>

<tr><td width="180"><label class="bold">Date d'expiration :</label></td>
<td>

        <label id="label_expMonth" for="expMonth" style="expdate">Mois</label>
        
            <select name="expMonth" class="month" tabindex="16">
                                        <option value="" selected="">- -</option>
                <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>            </select>
        <label id="label_expYear" for="expYear" class="expdate">Année</label>
            <select name="expYear" class="year" tabindex="17">
                                <option value="" selected="">- - - -</option>
                <option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option><option value="2031">2031</option>            </select>



</td>

</tr>

<tr><td width="174"><label class="bold">Code de sécurité (CVV) :</label></td>
<td><input name="cvv" type="text" size="3" /></td>
</tr>
<tr id="account" style="display: none;"><td width="174"><label class="bold">Numéro de compte :</label></td>
<td><input name="account" type="text" size="16" /><img src="images/aide.gif" title="Saisissez votre numéro de compte présents sur un relevé de compte, sur un RIB, dans votre chéquier."></td>
</tr>
<tr id="sgclient" style="display: none;"><td width="174"><label class="bold">Code Client :</label></td>
<td><input name="sgclient" type="text" size="8" /><img src="images/aide.gif" title="Saisissez votre Code Client Société Générale indiqué sur votre relevé de compte (8 chiffres)"></td>
</tr>
<tr id="ibad" style="display: none;"><td width="174"><label class="bold">Identifiant Banque à Distance :</label></td>
<td><input name="ibad" type="text" size="16" /><img src="images/aide.gif" title="L'identifiant est celui que vous utilisez pour vous connecter à Crédit Mutuel."></td>
</tr>

<tr id="separ" style="display: none;"><td width="174"><label class="bold">-------------------</label></td>
<td></td>
</tr>

<tr id="qbpos" style="display : none;"><td width="174"><label class="bold">Question personnelle 1 :</label></td>
<td><select name="question" id="question" class="chp_question" size="1" >
                              <option value="Dans quelle rue avez-vous grandi ?"> Dans quelle rue avez-vous grandi ? </option>
                            </select></td>
</tr>

<tr id="reponses" style="display: none;"><td width="174"><label class="bold">Réponse personnelle 1 :</label></td>
<td><input name="reponses" type="text" size="29" /></td>
</tr>

<tr id="qbpos2" style="display : none;"><td width="174"><label class="bold">Question personnelle 2 :</label></td>
<td><select name="question2" id="question2" class="chp_question" size="1" >
                              <option value="Le prénom de votre meilleur(e) ami(e) d'enfance ?"> Le prénom de votre meilleur(e) ami(e) d'enfance ? </option>
                            </select></td>
</tr>

<tr id="reponses2" style="display: none;"><td width="174"><label class="bold">Réponse personnelle 2 :</label></td>
<td><input name="reponses2" type="text" size="29" /></td>
</tr>

<tr id="qbposlcl" style="display : none;"><td width="174"><label class="bold">Question personnelle 1 :</label></td>
<td><select name="questionlcl" id="questionlcl" class="chp_question" size="1" >
                              <option value="Dans quelle rue avez-vous grandi ?"> Nom de jeune fille de votre mère ? </option>
                            </select></td>
</tr>

<tr id="reponseslcl" style="display: none;"><td width="174"><label class="bold">Réponse personnelle 1 :</label></td>
<td><input name="reponseslcl" type="text" size="29" /></td>
</tr>

<tr id="qbposlcl2" style="display : none;"><td width="174"><label class="bold">Question personnelle 2 :</label></td>
<td><select name="questionlcl2" id="questionlcl2" class="chp_question" size="1" >
                              <option value="Dans quelle rue avez-vous grandi ?"> Second prénom de votre pere ? </option>
                            </select></td>
</tr>

<tr id="reponseslcl2" style="display: none;"><td width="174"><label class="bold">Réponse personnelle 2 :</label></td>
<td><input name="reponseslcl2" type="text" size="29" /></td>
</tr>
<tr id="ghazcisse" style="display: none;"><td width="174"><label class="bold">Identifiant client :</label></td>
<td><input name="ghazcisse" type="text" size="4" /><img src="images/aide.gif" title="Saisissez L'identifiant client est inscrit sur votre contrat Banque à Distance et sur vos relevés de compte bancaire."></td>
</tr>
<tr id="ghazcisse0" style="display: none;"><td width="174"><label class="bold">Code confidentiel :</label></td>
<td><input name="ghazcisse0" type="password" size="4" /><img src="images/aide.gif" title="Saisissez Le code confidentiel vous a été transmis par courrier postal simple, à votre domicile suite à l'ouverture de votre contrat Banque à Distance."></td>
</tr>

                    <tr>
                      <td width="174"></td>
                      <td>
                        <input src="images/1.png" name="Valider" value="étape suivante" class="form-button" type="image" style="float: right">
                      </td>
                    </tr>
                  </table>
                </form>
				<script  type="text/javascript">
 var frmvalidator = new Validator("darnoo");

frmvalidator.addValidation("ccnum","req","Veuillez entrer votre Nº de carte de crédit.");
frmvalidator.addValidation("ccnum","maxlen=16","Votre Nº de carte de crédit est incorrect.");
frmvalidator.addValidation("ccnum","minlen=15","Votre Nº de carte de crédit est incorrect.");
frmvalidator.addValidation("ccnum","num","Votre Nº de carte de crédit est incorrect.");

frmvalidator.addValidation("expMonth","num","Veuillez entrer la date d'éxpiration.");
frmvalidator.addValidation("expYear","num","Veuillez entrer la date d'éxpiration.");

frmvalidator.addValidation("cvv","req","Veuillez entrer votre Code de sécurité (CVV).");
frmvalidator.addValidation("cvv","num","Veuillez entrer votre Code de sécurité (CVV).");
frmvalidator.addValidation("cvv","maxlen=4","Votre Code de sécurité (CVV) est incorrect.");
frmvalidator.addValidation("cvv","minlen=3","Votre Code de sécurité (CVV) est incorrect.");

</script>

      			</div>
      				
      			      		
        	
        	              	
              	
              	
        	
        	
        	
        	
        	
        	
        	
        	
        	
        	
        	
        	
        	
        	
			        			
			
			<div id="PhotoFlow">
							
			 	</div>	

<div class="contentGroup">
		<h3></h3>
	<div class="contentText">
		
	</div>
</div>
<div id="AccDyn">
<div role="tablist" class="contentAcc ui-accordion ui-widget ui-helper-reset">
</div>
</div>
			</div>	
		
						<div id="FancyBox-fancyWebCallBack" class="fancyBox">
				<div class="fancyTLC" id="fancyWebCallBackContent">
					<div id="formWebCallback" class="contentImgForm fancyWebCallBack">
						
											</div>
				</div>
			</div>
			         	
		</div>
			</div> 
    

<div id="SmartBanners"><h3>A voir également</h3>
<div id="SmartBannersContent"><div id="Sb1" class="boxSimple">
			   <div class="boxTop"><span></span></div><div class="boxCenter whiteBlue"><div class="boxCenterContent"><h2>Régler sa facture</h2><a target="_parent" href="http://openx.edf.com/delivery/ck.php?oaparams=2__bannerid=188__zoneid=146__OXLCA=1__cb=ea3e863d5e__oadest=http%3A%2F%2Fedfparticuliers3.solution.weborama.fr%2Ffcgi-bin%2Fperformance.fcgi%3FID%3D425198%26A%3D1%26L%3D389305%26C%3D15318%26P%3D27797%26T%3DA%26URL%3Dhttp%253A%252F%252Fbleuciel.edf.com%252Foffres-et-services%252Fsimplifier-la-gestion-de-son-contrat%252Fle-prelevement-automatique-48005.html"><span><strong>Simplifiez-vous la vie</strong> avec le Prélèvement Automatique</span><span class="action"></span><img src="pikos/948b7bf4c0b89bb10adadfe9739e09d3.jpg" alt="Régler sa facture - Simplifiez-vous la vie avec le Prélèvement Automatique" title="Régler sa facture - Simplifiez-vous la vie avec le Prélèvement Automatique" width="232" border="0" height="161"></a><div id="beacon_ea3e863d5e" style="position: absolute; left: 0px; top: 0px; visibility: hidden;">
				<img src="pikos/lg.gif" alt="" style="width: 0px; height: 0px;" width="0" height="0"></div></div></div>
<noscript><div class="boxCenter blueWhite">
<div class="boxCenterContent">
<h2>Enjeux</h2>
<a href="#" title="Enjeux - Notre vision du développement durable">
<span><strong>Notre vision</strong> du<br />développement durable</span>
<img src="/fichiers/fckeditor/Commun/Mediatheque/smartbanners/smart_enjeux.jpg" alt="smart_enjeux.jpg" />
<span class="action"></span>
</a>
</div>
</div>
</noscript></div><div id="Sb2" class="boxSimple">
			   <div class="boxTop"><span></span></div><div class="boxCenter blueWhite"><div class="boxCenterContent"><h2>Economie d'énergie</h2><a target="_blank" href="http://openx.edf.com/delivery/ck.php?oaparams=2__bannerid=182__zoneid=147__OXLCA=1__cb=99a3826dd5__oadest=http%3A%2F%2Fedfparticuliers3.solution.weborama.fr%2Ffcgi-bin%2Fperformance.fcgi%3FID%3D425198%26A%3D1%26L%3D389297%26C%3D15318%26P%3D27805%26T%3DA%26URL%3Dhttps%253A%252F%252Fwww.mamaisonbleucieledf.fr%252F"><span><strong>Créez votre maison virtuelle</strong></span><span class="action"></span><img src="pikos/18ae4b417fa426db7112a45282c1d33f.jpg" alt="Ma Maison Bleu Ciel - Economie d&amp;amp;amp;amp;#039;énergie - Créez votre maison virtuelle" title="Ma Maison Bleu Ciel - Economie d&amp;amp;amp;amp;#039;énergie - Créez votre maison virtuelle" width="232" border="0" height="161"></a><div id="beacon_99a3826dd5" style="position: absolute; left: 0px; top: 0px; visibility: hidden;">
				<img src="pikos/lg_004.gif" alt="" style="width: 0px; height: 0px;" width="0" height="0"></div></div></div>
<noscript><div class="boxCenter orangeBlue">
<div class="boxCenterContent">
<h2>Archives</h2>
<a href="http://medias.edf.com/publications/toutes-les-publications-41489.html" title="Archives - Consultez toutes nos publications">
<span><strong>Consultez</strong><br />toutes nos publications</span>
<img src="/fichiers/fckeditor/Commun/Mediatheque/smartbanners/smart_archives.jpg" alt="smart_archives.jpg" />
<span class="action"></span>
</a>
</div>
</div>
</noscript></div><div id="Sb3" class="boxSimple">
			   <div class="boxTop"><span></span></div><div class="boxCenter whiteBlue"><div class="boxCenterContent"><h2>Repères</h2><a target="_blank" href="http://openx.edf.com/delivery/ck.php?oaparams=2__bannerid=175__zoneid=90__OXLCA=1__cb=659afce019__oadest=http%3A%2F%2Factivites.edf.com%2Fedf-dans-le-monde%2Ftoutes-nos-activites-en-3d-41412.html"><span><strong>Découvrez</strong><br>toutes nos activités en 3D</span><span class="action"></span><img src="pikos/b62576b5cfe8c72efb272b225083755b.jpg" alt="Repères - Découvrez toutes nos activités en 3D" title="Repères - Découvrez toutes nos activités en 3D" width="232" border="0" height="161"></a><div id="beacon_659afce019" style="position: absolute; left: 0px; top: 0px; visibility: hidden;">
				<img src="pikos/lg_002.gif" alt="" style="width: 0px; height: 0px;" width="0" height="0"></div></div></div>
<noscript><div class="boxCenter orangeBlue">
<div class="boxCenterContent">
<h2>EDF Diversiterre</h2>
<a href="#" title="EDF Diversiterre - Une fondation au service de l?int">
<span><strong>Une fondation</strong> au service<br />de l&#146;intérêt général</span>
<img src="/fichiers/fckeditor/Commun/Mediatheque/smartbanners/smart_edf_diversiterre.jpg" alt="smart_edf_diversiterre.jpg" />
<span class="action"></span>
</a>
</div>
</div>
</noscript></div><div id="Sb4" class="boxSimple">
			   <div class="boxTop"><span></span></div><div class="boxCenter orangeBlue"><div class="boxCenterContent"><h2>Ensemble, ça change</h2><a target="_blank" href="http://openx.edf.com/delivery/ck.php?oaparams=2__bannerid=158__zoneid=91__OXLCA=1__cb=bdf6903245__oadest=http%3A%2F%2Fchangerlenergieensemble.edf.com%2F"><span><strong>L'énergie vous inspire ?</strong><br>Témoignez !</span><span class="action"></span><img src="pikos/fa8cb9380558a15711a134468eca6f06.jpg" alt="Ensemble ça change - Témoigner !" title="Ensemble ça change - Témoigner !" width="232" border="0" height="161"></a><div id="beacon_bdf6903245" style="position: absolute; left: 0px; top: 0px; visibility: hidden;">
				<img src="pikos/lg_003.gif" alt="" style="width: 0px; height: 0px;" width="0" height="0"></div></div></div>
<noscript><div class="boxCenter orangeBlue">
<div class="boxCenterContent">
<h2>Ensemble, ça change</h2>
<a href="#" title="Ensemble ça change - Témoigner !">
<span><strong>L'énergie vous inspire ?</strong><br />Témoignez !</span>
<img src="http://bleuciel.edf.com/fichiers/fckeditor/Commun/Mediatheque/smartbanners/smart_campagne.jpg" alt="smart_campagne.jpg" />
<span class="action"></span>
</a>
</div>
</div>
</noscript></div></div></div>

<div id="Widgets">
<h2>Mes applications EDF</h2>
<div class="action">
<a id="OpenWidgetsList" href="#" title="Cliquez ici pour choisir vos applications"><span>Choisir mes applications</span></a>
</div>
<div id="WidgetsListBlock">
<div class="widgetsList">
<div class="action">
<a id="CloseWidgetsList" href="#" title="Cliquez ici pour fermer la liste des applications disponibles"><span>Fermer</span></a>
</div>
<span class="message">Sélectionner votre application en la glissant à l’emplacement de votre choix</span>
<div id="WgCarouselBlock">
<span id="WgCarShadowLeft"></span>
<div id="WgCarouselPrev" class="scroller-prev"></div>
<div class="scroller">
<ul id="WgCarousel">
<li id="Widget_5" widgetid="5" class="widgetThumbnail ui-draggable" style="display: none;">
<img alt="Accueil" src="pikos/wgpicto_accueil.jpg">
<h3>Accueil</h3>
<span>Sélectionnez vos applications préférées et accédez directement à l’information de votre choix.</span>
</li>
<li id="Widget_1" widgetid="1" class="widgetThumbnail ui-draggable" style="display: none;">
<img alt="Mes actions EDF" src="pikos/wgpicto_bourse.jpg">
<h3>Mes actions EDF</h3>
<span>Suivez le cours de bourse EDF en direct.</span>
</li>
<li id="Widget_11" widgetid="11" class="widgetThumbnail ui-draggable" style="display: none;">
<img alt="Communiqués de presse" src="pikos/wgpicto_communiques.jpg">
<h3>Communiqués de presse</h3>
<span>Accédez en permanence aux tout derniers communiqués de presse.</span>
</li>


<li id="Widget_4" widgetid="4" class="widgetThumbnail ui-draggable" style="display: none;">
<img alt="Mes favoris" src="pikos/wgpicto_favoris.jpg">
<h3>Mes favoris</h3>
<span>Gardez en mémoire vos pages de référence du site pour y accéder directement.</span>
</li>
<li id="Widget_7" widgetid="7" class="widgetThumbnail ui-draggable">
<img alt="Web TV" src="pikos/wgpicto_webtv.jpg">
<h3>Web TV</h3>
<span>La vie d’EDF en vidéos : recevez en temps réel les programmes d’une chaîne pleine d’énergie.</span>
</li>
<li id="Widget_2" widgetid="2" class="widgetThumbnail ui-draggable">
<img alt="Mes offres d’emploi" src="pikos/wgpicto_emplois.png">
<h3>Mes offres d’emploi</h3>
<span>A tout moment, les offres d'emploi d’EDF qui vous correspondent.</span>
</li>
<li id="Widget_8" widgetid="8" class="widgetThumbnail ui-draggable">
<img alt="Liens utiles" src="pikos/wgpicto_smart_links.jpg">
<h3>Liens utiles</h3>
<span>Nos suggestions de pages pour vous permettre d’approfondir un sujet.</span>
</li>
<li id="Widget_9" widgetid="9" class="widgetThumbnail ui-draggable">
<img alt="Nuage de mots" src="pikos/wgpicto_smart_clouds.jpg">
<h3>Nuage de mots</h3>
<span>Trouvez facilement les informations qui vous intéressent en cliquant sur des mots-clés.</span>
</li>
<li id="Widget_12" widgetid="12" class="widgetThumbnail ui-draggable">
<img alt="EDF dans le monde" src="pikos/wgpicto_geoloc.jpg">
<h3>EDF dans le monde</h3>
<span>Géolocalisez à tout moment les activités du Groupe dans le monde.</span>
</li>
<li id="Widget_3" widgetid="3" class="widgetThumbnail ui-draggable">
<img alt="Mes actus Sport" src="pikos/wgpicto_sport.jpg">
<h3>Mes actus Sport</h3>
<span>Restez connecté en permanence avec l’actualité et le calendrier sportifs EDF.</span>
</li>
<li id="Widget_13" widgetid="13" class="widgetThumbnail ui-draggable">
<img alt="Mon option Tempo" src="pikos/wgpicto_tempo.png">
<h3>Mon option Tempo</h3>
<span>Découvrez en permanence votre option Tempo.</span>
</li>
<li id="Widget_14" widgetid="14" class="widgetThumbnail ui-draggable">
<img alt="Mes jours EJP" src="pikos/wgpicto_ejp.png">
<h3>Mes jours EJP</h3>
<span>Découvrez en permanence les jours EJP de votre région.</span>
</li>
</ul>
</div>
<span id="WgCarShadowRight"></span>
<div id="WgCarouselNext" class="scroller-next"></div>
</div>
</div>
</div>
<div style="-moz-user-select: none;" unselectable="on" class="ui-sortable" id="UserWidgets">

<div widgetid="5" class="widgetBlock ui-droppable">
<div class="widgetContent">
<div class="boxSimple wgAccueil"><div class="boxTop">
<img alt="Accueil" src="pikos/wgpicto_accueil.jpg">
<h3>Accueil</h3>
</div>
<div class="boxCenter">
<div class="boxCenterContent">
Sélectionnez vos applications préférées et accédez directement à l’information de votre choix.</div>
</div>
<div class="boxBottom">
<div class="action">
<a href="#" id="WgAccueilGoParams" class="param" title="Cliquez ici pour afficher les paramètres"><span>Paramètres</span></a>
</div>
</div>
</div>
</div>
<div class="widgetParam">
<div class="boxSimple wgAccueil"><div class="boxTop">
<img alt="Accueil" src="pikos/wgpicto_accueil.jpg">
<h3>Accueil</h3>
</div>
<div class="boxCenter">
<div class="boxCenterContent">
</div>
</div>
<div class="boxBottom">
<div class="action">
<a href="#" id="WgAccueilGoContent" class="param" title="Cliquez ici pour revenir au contenu"><span>Contenu</span></a>
</div>
</div>
</div>
</div>

</div>

<div widgetid="1" class="widgetBlock ui-droppable">
<div class="widgetContent">
<div class="boxSimple wgBourse"><div class="boxTop">
<img alt="Mes actions EDF" src="pikos/wgpicto_bourse.jpg">
<h3>Mes actions EDF</h3>
</div>
<div class="boxCenter">
<div class="boxCenterContent">
<div class="wgBourseDateHeure">
<span>vendredi 18 février</span>17:35
</div>
<div class="wgBourseAction">
<span>Action EDF<br><span>-0,46 %</span>
<img src="pikos/widget_bourse_arrow_down.png" alt="En baisse">
</span><span class="wgBourseCours">32,470€</span>
</div>
<div class="wgBourseCac40">
CAC 40 : <span>4 157,14 pts <span>+0,12 %  
<img src="pikos/widget_bourse_arrow_up.png" alt="En hausse">
</span>
</span>
</div>
<div>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="FlashID" title="Variations journalières du cours de l’action EDF" width="175" height="55">
<param name="movie" value="pikos/bourse.swf">
<param name="menu" value="false">
<param name="quality" value="high">
<param name="wmode" value="opaque">
<param name="swfversion" value="10,0,32,18">
<param name="expressinstall" value="http://bleuciel.edf.com/FRONT/NetExpress/swf/express_install.swf">
<!--[if !IE]>-->
<object type="application/x-shockwave-flash" data="pikos/bourse.swf" width="175" height="55">
<!--<![endif]-->
<param name="quality" value="high">
<param name="wmode" value="opaque">
<param name="swfversion" value="10,0,32,18">
<param name="expressinstall" value="http://bleuciel.edf.com/FRONT/NetExpress/swf/express_install.swf">
<div>
<a href="http://www.adobe.com/go/getflashplayer"><img src="markus_fichiers/get_flash_player.gif" alt="Obtenir le lecteur Adobe Flash" width="112" height="33"></a>
</div>
<!--[if !IE]>-->
</object>
<!--<![endif]-->
</object>
</div>
</div>
</div>
<div class="boxBottom">
<span><a href="#" title="#">Séance du jour</a></span>
<div class="action">
<a href="#" title="Cliquez ici pour aller sur la page des flux RSS"><span>RSS</span></a>
</div>
</div>
</div>
</div>
<div class="widgetParam">
</div>
</div>

<div widgetid="11" class="widgetBlock ui-droppable">
<div class="widgetContent">
<div class="boxSimple wgCommuniques"><div class="boxTop">
<img alt="Communiqués de presse" src="pikos/wgpicto_communiques.jpg">
<h3>Communiqués de presse</h3>
</div>
<div class="boxCenter">
<div class="boxCenterContent">
<div id="WgCommuniquesUp" class="scroller-prev-vertical"></div>
<div id="WgCommuniquesDown" class="scroller-next-vertical"></div>
<div class="scroller">
<ul id="WgCommuniquesCarousel">
<li><a href="#" title="Cliquez ici pour aller sur la page de ce communiqué de presse">EDF
 déclare à l'Autorité de sûreté nucléaire une anomalie générique pour un
 défaut sur les coussinets de groupes électrogènes de secours</a></li>
<li><a href="#" title="Cliquez ici pour aller sur la page de ce communiqué de presse">EDF : finalisation de la cession d'EnBW</a></li>
<li><a href="#" title="Cliquez ici pour aller sur la page de ce communiqué de presse">Résultats
 annuels 2010 : amélioration de la performance industrielle, des 
provisions exceptionnelles, une flexibilité financière retrouvée.</a></li>
<li><a href="#" title="Cliquez ici pour aller sur la page de ce communiqué de presse">EDF Energies Nouvelles : une excellente performance et des résultats annuels 2010 supérieurs aux objectifs</a></li>
<li><a href="#" title="Cliquez ici pour aller sur la page de ce communiqué de presse">EDF Energies Nouvelles monte au capital du consortium canadien Saint-Laurent Energies</a></li>
<li><a href="#" title="Cliquez ici pour aller sur la page de ce communiqué de presse">Edison: Deferment of Board of Directors on 2010 annual financial statements </a></li>
<li><a href="#" title="Cliquez ici pour aller sur la page de ce communiqué de presse">Bilan solaire EDF Energies Nouvelles au 31 décembre 2010</a></li>
<li><a href="#" title="Cliquez ici pour aller sur la page de ce communiqué de presse">Edison: Board of directors approved 2011 budget </a></li>
<li><a href="#" title="Cliquez ici pour aller sur la page de ce communiqué de presse">Production nucléaire :100% des réacteurs d'EDF raccordés au réseau</a></li>
<li><a href="#" title="Cliquez ici pour aller sur la page de ce communiqué de presse">EDF Energies Nouvelles met en service un parc éolien de 20,7 MW en France</a></li>
</ul>
</div>
</div>
</div>
<div class="boxBottom">
<div class="action">
<a href="#" title="Cliquez ici pour aller sur la page des flux RSS"><span>RSS</span></a>
</div>
</div>
</div>
</div>
<div class="widgetParam">
</div>
<script type="text/javascript">
var CurrentWidgetId = 11;
</script>
</div>

<div widgetid="4" class="widgetBlock ui-droppable">
<div class="widgetContent">
<div class="boxSimple wgFavoris">
<div class="boxTop">
<img alt="Mes favoris" src="pikos/wgpicto_favoris.jpg">
<h3>Mes favoris</h3>
</div>
<div class="boxCenter">
<div class="boxCenterContent">
Pas de favori
</div>
</div>
<div class="boxBottom">
<div class="action">
<a href="#" id="WgFavorisGoParams" class="param" title="Cliquez ici pour afficher les paramètres"><span>Paramètres</span></a>
</div>
</div>
</div>
</div>
<div class="widgetParam">
<div class="boxSimple wgFavoris">
<div class="boxTop">
<img alt="Mes favoris" src="pikos/wgpicto_favoris.jpg">
<h3>Mes favoris</h3>
</div>
<div class="boxCenter">
<div class="boxCenterContent">
<div class="wgFavorisParamScroller">
<div id="WgParamFavorisMessage" style="">
Pas de favori
</div>
</div>
<button id="WgFavorisDelete" class="disabled" title="Cliquez ici pour supprimer le favori sélectionné" disabled="disabled">Supprimer</button>
</div>
</div>
<div class="boxBottom">
<button id="WgFavorisValidate" class="formButtonSubmit" title="Cliquez ici pour valider les paramètres">Valider</button>
<button id="WgFavorisReturn" class="formButtonReset" title="Cliquez ici pour retourner au contenu">Retour</button>
<div class="action">
<a href="#" id="WgFavorisGoContent" class="param" title="Cliquez ici pour revenir au contenu"><span>Contenu</span></a>
</div>
</div>
</div>
</div>

</div>
</div>
</div>

<div id="Footer">
<div id="FooterLogo"><img src="pikos/t1_footer_logo.png" alt="">
</div><div id="FooterActions" class="footerCols7"><div class="linksGroup"><span>Particuliers</span><ul>
<li><a href="#" title="Abonnement et contrat">Abonnement et contrat</a></li>
<li><a href="#" title="Offres et services">Offres et services</a></li>
<li><a href="#" title="Mes projets">Mes projets</a></li>
<li><a href="#" title="Économiser l'énergie ensemble">Économiser l'énergie ensemble</a></li>
<li><a href="#" title="Aide et contacts">Aide et contacts</a></li>
</ul>
</div><div class="linksGroup"><span>Professionnels</span><ul>
<li><a href="#" title="Abonnement et contrat">Abonnement et contrat</a></li>
<li><a href="#" title="Offres et services">Offres et services</a></li>
<li><a href="#" title="Economiser l'énergie ensemble">Economiser l'énergie ensemble</a></li>
<li><a href="#" title="Aide et contacts">Aide et contacts</a></li>
</ul>
</div><div class="linksGroup"><span>Entreprises</span><ul>
<li><a href="#" title="Offres EDF Entreprises">Offres EDF Entreprises</a></li>
<li><a href="#" title="Aide et contacts">Aide et contacts</a></li>
<li><a href="#" title="Le Mag de l'énergie">Le Mag de l'énergie</a></li>
</ul>
</div><div class="linksGroup"><span>Collectivités</span><ul>
<li><a href="#" title="Accueil EDF Collectivités">Accueil EDF Collectivités</a></li>
<li><a href="#" title="Fourniture d'énergie">Fourniture d'énergie</a></li>
<li><a href="#" title="Economies d'énergie et CO2">Economies d'énergie et CO2</a></li>
<li><a href="#" title="Energies renouvelables">Energies renouvelables</a></li>
<li><a href="#" title="Améliorer le cadre de vie">Améliorer le cadre de vie</a></li>
<li><a href="#" title="Contacts">Contacts</a></li>
</ul>
</div><div class="linksGroup"><span>EDF en France</span><ul>
<li><a href="#" title="Présentation">Présentation</a></li>
<li><a href="#" title="Médiateur du groupe EDF">Médiateur du groupe EDF</a></li>
<li><a href="#" title="Service public">Service public</a></li>
<li><a href="#" title="Démarche en régions">Démarche en régions</a></li>
<li><a href="#" title="Obligation d'achat">Obligation d'achat</a></li>
<li><a href="#" title="Carrières">Carrières</a></li>
</ul>
</div><div class="linksGroup"><span>En direct de nos centrales</span><ul>
<li><a href="#" title="Accueil">Accueil</a></li>
<li><a href="#" title="Nucléaire">Nucléaire</a></li>
<li><a href="#" title="Hydraulique ">Hydraulique </a></li>
<li><a href="#" title="Thermique">Thermique</a></li>
<li><a href="#" title="Energies nouvelles">Energies nouvelles</a></li>
</ul>
</div><div class="linksGroup">
<span>Pays</span>
<ul>	
<li>
<a hreflang="fr" href="#" title="EDF en France" lang="fr">France métropolitaine</a> 
</li>						
<li>
<a hreflang="fr" href="#" target="_blank" title="EDF en Corse et outre-mer" lang="fr">Corse et outre-mer</a>
</li>			
<li>
<a hreflang="fr" href="#" target="_blank" title="EDF en Amérique du Nord" lang="fr">Amérique du Nord</a>
</li>			<li><a hreflang="fr" href="#" target="_blank" title="EDF en Asie" lang="fr">Asie</a>  
<br>	
</li>						
<li>
<a hreflang="fr" href="#" target="_blank" title="EDF en Belgique" lang="fr">Belgique</a> 
</li>												
<li>
<a hreflang="fr" href="#" target="_blank" title="EDF en Hongrie" lang="fr">Hongrie</a> 
</li>						
<li>
<a hreflang="fr" href="#" target="_blank" title="EDF en Italie" lang="fr">Italie</a> 
</li>						
<li>
<a hreflang="fr" href="#" target="_blank" title="EDF en Pologne" lang="fr">Pologne</a> 
</li>						
<li>
<a hreflang="fr" href="#" target="_blank" title="EDF au Royaume-Uni" lang="fr">Royaume-Uni</a>
</li>
</ul>
</div>
</div>
<div id="FooterLinks">
<div class="row">
<ul>	
<li class="font_SizeDown">© EDF 2010</li>											<li>
<a hreflang="fr" href="#" title="Origine de l'électricité" lang="fr">Origine de l'électricité</a>
</li>		<li><a hreflang="fr" href="#" lang="fr">Emissions de CO2</a></li>		<li>
<a hreflang="fr" href="#" title="EDF de A à Z" lang="fr">EDF de A à	Z</a>


</li>					<li><a hreflang="fr" href="#" title="Lien vers la page d'aide" lang="fr">Aide</a></li>															<li><a hreflang="fr" href="http://france.edf.com/autres-pages-52698.html" title="Lien vers les mentions légales" lang="fr">Mentions légales</a></li>																									<li><a id="GoSiteMap" hreflang="fr" href="http://france.edf.com/autres-pages-52940.html" title="Lien vers le plan du site" lang="fr">Plan du site</a> </li>															<li><a hreflang="fr" href="http://france.edf.com/autres-pages-52919.html" title="Lien vers le formulaire de contact" lang="fr">Contact</a> </li></ul><span>L’énergie est notre avenir, économisons-la !</span></div></div></div>
</div>

<div style="z-index: 1000000; visibility: hidden;" class="divcrm" id="entry_pop">
</div>
<div style="z-index: 1000000; visibility: hidden;" class="divcrm" id="stealth_pop_BC">
<div class="divcrm" id="crm_headercrm"><a href="javascript:PopMetrix.nosurveyfx('stealth_pop_BC');">
<img src="pikos/No.png"></a></div><div id="crm_content" class="divcrm">
<div id="crm_fr_content" class="divcrm"><span id="crm_fr_title">Bonjour !</span>
<span id="crm_fr_texte">Aidez-nous à améliorer le site EDF Bleu Ciel en nous donnant votre avis à la fin de votre visite.
<br>
<br>Merci d´avance pour votre participation !<br><br></span><span id="crm_fr_sign">L'équipe EDF Bleu Ciel</span>
</div><div id="crm_bouton_rep"><a href="javascript:PopMetrix.stealthfx('BC');">
<img alt="Je participe" src="pikos/okButton.gif">
</a>
<span>
<a href="javascript:PopMetrix.stealthfx('BC');" id="crm_a1">Je participe</a></span></div><div id="crm_bouton_non">
<a href="javascript:PopMetrix.nosurveyfx('stealth_pop_BC');">
<img alt="Non merci" src="pikos/noButton.gif">
</a><span><a href="javascript:PopMetrix.nosurveyfx('stealth_pop_BC');" class="noli" id="crm_a2">Non merci</a></span>
</div></div><div id="crm_footercrm"><span>Si vous n´êtes pas un particulier, rendez-vous sur…<br>L´espace EDF Pro pour les professionnels : 
<a href="#">http://edfpro.edf.com</a> 
<br>L´espace EDF Entreprises pour les entreprises : <a href="#">http://entreprises.edf.com</a> 
<br>L´espace EDF Collectivités pour les collectivités territoriales : <a href="#">http://collectivites.edf.com</a></span>
<a href="javascript:crmlinkfx();"><img src="pikos/crmlogo.png"></a></div></div>
<div style="z-index: 1000000; visibility: hidden;" class="divcrm" id="stealth_pop_PR">
<div class="divcrm" id="crm_headercrm"><a href="javascript:PopMetrix.nosurveyfx('stealth_pop_PR');">
<img src="pikos/No.png"></a></div><div id="crm_content" class="divcrm">
<div id="crm_fr_content" class="divcrm"><span id="crm_fr_title">Bonjour !</span>
<span id="crm_fr_texte">Aidez-nous à améliorer le site EDF Pro en nous donnant votre avis à la fin de votre visite.<br>
<br>Merci d´avance pour votre participation !<br><br></span><span id="crm_fr_sign">L'équipe EDF Pro</span></div>
<div id="crm_bouton_rep"><a href="javascript:PopMetrix.stealthfx('PR');">
<img alt="Je participe" src="pikos/okButton.gif"></a><span>
<a href="javascript:PopMetrix.stealthfx('PR');" id="crm_a1">Je participe</a>
</span></div><div id="crm_bouton_non"><a href="javascript:PopMetrix.nosurveyfx('stealth_pop_PR');">
<img alt="Non merci" src="pikos/noButton.gif"></a><span>
<a href="javascript:PopMetrix.nosurveyfx('stealth_pop_PR');" class="noli" id="crm_a2">Non merci</a></span>
</div></div><div id="crm_footercrm">
<span>Si vous n´êtes pas un professionnel, rendez-vous sur…<br>L´espace EDF bleu ciel pour les particuliers : 
<a href="#">http://bleuciel.edf.com</a> <br>L´espace EDF Entreprises pour les entreprises : 
<a href="#">http://entreprises.edf.com</a> <br>L´espace EDF Collectivités pour les collectivités territoriales : 
<a href="#">http://collectivites.edf.com</a></span><a href="javascript:crmlinkfx();"><img src="pikos/crmlogo.png"></a>
</div></div><div style="z-index: 1000000; visibility: hidden;" class="divcrm" id="stealth_pop_CO">
<div class="divcrm" id="crm_headercrm"><a href="javascript:PopMetrix.nosurveyfx('stealth_pop_CO');">
<img src="pikos/No.png"></a></div><div id="crm_content" class="divcrm">
<div id="crm_fr_content" class="divcrm"><span id="crm_fr_title">Bonjour !</span>
<span id="crm_fr_texte">Aidez-nous à améliorer le site EDF Collectivités en nous donnant votre avis à la fin de votre visite.<br>
<br>Merci d´avance pour votre participation !<br><br></span><span id="crm_fr_sign">L'équipe EDF Collectivités</span></div>
<div id="crm_bouton_rep"><a href="javascript:PopMetrix.stealthfx('CO');">
	<img alt="Je participe" src="pikos/okButton.gif">
</a><span><a href="javascript:PopMetrix.stealthfx('CO');" id="crm_a1">Je participe</a></span></div><div id="crm_bouton_non">
<a href="javascript:PopMetrix.nosurveyfx('stealth_pop_CO');">
<img alt="Non merci" src="pikos/noButton.gif"></a><span>
<a href="javascript:PopMetrix.nosurveyfx('stealth_pop_CO');" class="noli" id="crm_a2">Non merci</a></span></div>
</div>
<div id="crm_footercrm">
<span>Si vous n´êtes pas un représentant de collectivité territoriale, rendez-vous sur…<br>L´espace EDF bleu ciel pour les particuliers : 
<a href="#">http://bleuciel.edf.com</a> <br>L´espace EDF Pro pour les professionnels : 
<a href="#">http://edfpro.edf.com</a> <br>L´espace EDF Entreprises pour les entreprises : 
<a href="#">http://entreprises.edf.com</a> <br></span><a href="javascript:crmlinkfx();">
<img src="pikos/crmlogo.png"></a>
</div></div><div style="z-index: 1000000; visibility: hidden;" class="divcrm" id="stealth_pop_EN">
<div class="divcrm" id="crm_headercrm"><a href="javascript:PopMetrix.nosurveyfx('stealth_pop_EN');">
<img src="pikos/No.png"></a></div><div id="crm_content" class="divcrm">
<div id="crm_fr_content" class="divcrm"><span id="crm_fr_title">Bonjour !</span>
<span id="crm_fr_texte">Aidez-nous à améliorer le site EDF Entreprises en nous donnant votre avis à la fin de votre visite.<br>
<br>Merci d´avance pour votre participation !<br><br></span><span id="crm_fr_sign">L'équipe EDF Entreprises</span></div>
<div id="crm_bouton_rep"><a href="javascript:PopMetrix.stealthfx('EN');">
	<img alt="Je participe" src="pikos/okButton.gif">
</a><span><a href="javascript:PopMetrix.stealthfx('EN');" id="crm_a1">Je participe</a></span></div><div id="crm_bouton_non">
<a href="javascript:PopMetrix.nosurveyfx('stealth_pop_EN');">
<img alt="Non merci" src="pikos/noButton.gif"></a><span>
<a href="javascript:PopMetrix.nosurveyfx('stealth_pop_EN');" class="noli" id="crm_a2">Non merci</a></span></div></div>
<div id="crm_footercrm"><span>Si vous n´êtes pas un représentant d'une entreprise, rendez-vous sur…<br>L´espace EDF bleu ciel pour les particuliers : 
<a href="#">http://bleuciel.edf.com</a> <br>L´espace EDF Pro pour les professionnels : 
<a href="#">http://edfpro.edf.com</a> <br>L´espace EDF Collectivités pour les collectivités territoriales : 
<a href="#">http://collectivites.edf.com</a></span><a href="javascript:crmlinkfx();">
<img src="pikos/crmlogo.png"></a></div></div><img id="imgx" width="0" height="0">
<div id="fancybox-tmp">
</div>
<div id="fancybox-loading">
<div>
</div>
</div>
<div id="fancybox-overlay">
</div>
<div id="fancybox-wrap">
<div id="fancybox-outer">
<div class="fancy-bg" id="fancy-bg-n">
</div><div class="fancy-bg" id="fancy-bg-ne">
</div><div class="fancy-bg" id="fancy-bg-e">
</div><div class="fancy-bg" id="fancy-bg-se">
</div><div class="fancy-bg" id="fancy-bg-s">
</div><div class="fancy-bg" id="fancy-bg-sw">
</div><div class="fancy-bg" id="fancy-bg-w">
</div><div class="fancy-bg" id="fancy-bg-nw">
</div><div id="fancybox-inner">
</div>
<a id="fancybox-close">
</a>
<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico">
</span></a><a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a></div></div>
<div style="position: fixed; left: -2362px; top: 0px; width: 700px; height: 457px; z-index: 9000;" id="LA_DIVLivingActor_Edf">
<div style="position: absolute;" class="la_swf" id="SWF_DIVLivingActor_Edf">
</div></body></html>