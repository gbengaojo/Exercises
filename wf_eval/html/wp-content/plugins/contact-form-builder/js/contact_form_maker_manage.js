function remove_whitespace(node) {
  var ttt;
  for (ttt = 0; ttt < node.childNodes.length; ttt++) {
    if (node.childNodes[ttt] && node.childNodes[ttt].nodeType == '3' && !/\S/.test(node.childNodes[ttt].nodeValue)) {
      node.removeChild(node.childNodes[ttt]);
      ttt--;
    }
    else {
      if (node.childNodes[ttt].childNodes.length) {
        remove_whitespace(node.childNodes[ttt]);
      }
    }
  }
  return;
}

function remove_empty_columns() {
	jQuery('.wdform_section').each(function() {
		if (jQuery(this).find('.wdform_column').last().prev().html() == '') {
			if (jQuery(this).children().length > 2) {
				jQuery(this).find('.wdform_column').last().prev().remove();
				remove_empty_columns();
			}
		}
	});
}

function sortable_columns() {
  jQuery( ".wdform_column" ).sortable({
		connectWith: ".wdform_column",
		cursor: 'move',
		placeholder: "highlight",
		start: function(e,ui){
			jQuery('.wdform_column').each(function() {
				if (jQuery(this).html()) {
					jQuery(this).append(jQuery('<div class="wdform_empty_row" style="height:80px;"></div>'));
					jQuery( ".wdform_column" ).sortable("refresh");
				}
			});
		},
		update: function(event, ui) {
      jQuery('.wdform_section .wdform_column:last-child').each(function() {
        if (jQuery(this).html()) {
          jQuery(this).parent().append(jQuery('<div></div>').addClass("wdform_column"));
          sortable_columns();
        }
      });
		},
		stop: function(event, ui) {
			jQuery('.wdform_empty_row').remove();
			remove_empty_columns();
			/*add_border();*/
		}
  });
	/*add_border();*/
}

function all_sortable_events() {
	jQuery(document).on("click", ".wdform_field, .wdform_field_section_break", function() { 
    var this2 = this;
    /*setTimeout(function() {*/
      if (jQuery("#wdform_arrows" + jQuery(this2).parent().attr("wdid")).attr("class") == "wdform_arrows_show") {
        jQuery("#wdform_field" + jQuery(this2).parent().attr("wdid")).css({"background-color":"#fff", "border":"none", "margin-top":""});
        jQuery("#wdform_arrows" + jQuery(this2).parent().attr("wdid")).removeClass("wdform_arrows_show");
        jQuery("#wdform_arrows" + jQuery(this2).parent().attr("wdid")).addClass("wdform_arrows");
        jQuery("#wdform_arrows" + jQuery(this2).parent().attr("wdid")).hide();
      }
      else {
        jQuery(".wdform_arrows_show").addClass("wdform_arrows");
        if (jQuery('#enable_sortable').prop('checked')) {
          jQuery(".wdform_arrows").hide();
        }
        jQuery(".wdform_arrows_show").removeClass("wdform_arrows_show");
        jQuery(".wdform_field, .wdform_field_section_break").css("background-color","#fff");
        jQuery(".wdform_field").css("margin-top", "");
        if (jQuery("#wdform_field" + jQuery(this2).parent().attr("wdid")).attr("type") == 'type_editor') {
          jQuery("#wdform_field" + jQuery(this2).parent().attr("wdid")).css("margin-top", "-5px");
        }
        jQuery("#wdform_field" + jQuery(this2).parent().attr("wdid")).css({"background-color":"#fff"});
        jQuery("#wdform_field"+jQuery(this2).attr("wdid")).css({"border":"none"});
        jQuery("#wdform_arrows" + jQuery(this2).parent().attr("wdid")).removeClass("wdform_arrows");
        jQuery("#wdform_arrows" + jQuery(this2).parent().attr("wdid")).addClass("wdform_arrows_show");
        jQuery("#wdform_arrows" + jQuery(this2).parent().attr("wdid")).show();
      }
    // }, 300)
  });
  jQuery(document).on("hover", ".wdform_tr_section_break", function() {
    jQuery("#wdform_field" + jQuery(this).attr("wdid")).css({"background-color":"#F5F5F5"});
  });
  jQuery(document).on("hover", ".wdform_row", function() {
    jQuery("#wdform_field" + jQuery(this).attr("wdid")).css({"cursor":"move","background-color":"#F5F5F5"});
  });
  jQuery(document).on("mouseleave", ".wdform_row, .wdform_tr_section_break", function() {
    if (jQuery("#wdform_arrows" + jQuery(this).attr("wdid")).attr("class") != "wdform_arrows_show") {
      jQuery("#wdform_field" + jQuery(this).attr("wdid")).css({"background-color":"#fff", "border":"none"});
      jQuery("#wdform_arrows" + jQuery(this).attr("wdid")).addClass("wdform_arrows");
    }
  });
}

jQuery(document).on("dblclick", ".wdform_row, .wdform_tr_section_break", function() {
  edit(jQuery(this).attr("wdid"));
});

function fm_change_radio(elem) {	
	if(jQuery( elem ).hasClass( "fm-yes" )) {
		jQuery( elem ).val('0');
		jQuery( elem ).next().val('0');
		jQuery( elem ).removeClass('fm-yes').addClass('fm-no');
		jQuery(elem).find("span").animate({
			right: parseInt(jQuery( elem ).css( "width")) - 14 + 'px'
		}, 400, function() {
		}); 
	}	
	else {
		jQuery( elem ).val('1');
		jQuery( elem ).next().val('1');
		jQuery(elem).find("span").animate({
			right: 0
		}, 400, function() {
			jQuery( elem ).removeClass('fm-no').addClass('fm-yes');
		}); 
	}	
	if(jQuery( elem ).next().attr('name') == 'mail_verify') {
		show_verify_options(jQuery( elem ).val() == 1 ? true : false);
	}	
}

function enable_drag(elem) {
	if(jQuery('#enable_sortable').val() != 1) {
		jQuery('.wdform_column').sortable( "enable" );
		jQuery( ".wdform_arrows" ).slideUp(700);
		all_sortable_events();
	}
	else {
		jQuery('.wdform_column').sortable( "disable" );	
		jQuery(".wdform_column").css("border","none");		
		jQuery( ".wdform_row, .wdform_tr_section_break" ).die("click");
		jQuery( ".wdform_row" ).die("hover");
		jQuery( ".wdform_tr_section_break" ).die("hover");
		jQuery( ".wdform_field" ).css("cursor","default");
		jQuery( ".wdform_field, .wdform_field_section_break" ).css("background-color","#fff");
		jQuery( ".wdform_field, .wdform_field_section_break" ).css("border","none");
		jQuery( ".wdform_arrows_show" ).hide();
		jQuery( ".wdform_arrows_show" ).addClass("wdform_arrows");
		jQuery( ".wdform_arrows_show" ).removeClass("wdform_arrows_show");
		jQuery( ".wdform_arrows" ).slideDown(600);	
	}
	
	fm_change_radio(elem);
}

function refresh_() {
  document.getElementById('counter').value = gen;
  if (document.getElementById('form_id_tempform_view1')) {
    document.getElementById('form_id_tempform_view1').removeAttribute('style');
  }
	document.getElementById('form_front').value = document.getElementById('take').innerHTML;
}

function form_maker_options_tabs(id) {
  jQuery("#fieldset_id").val(id);
  jQuery(".fm_fieldset_active").removeClass("fm_fieldset_active").addClass("fm_fieldset_deactive");
  jQuery("#" + id + "_fieldset").removeClass("fm_fieldset_deactive").addClass("fm_fieldset_active");
  jQuery(".fm_fieldset_tab").removeClass("active");
  jQuery("#" + id).addClass("active");
  return false;
}

function codemirror_for_javascript() {
  var editor = CodeMirror.fromTextArea(document.getElementById("form_javascript"), {
  lineNumbers: true,
  lineWrapping: true,
  mode: "javascript"
  });
  
  CodeMirror.commands["selectAll"](editor);
  editor.autoFormatRange(editor.getCursor(true), editor.getCursor(false));
  editor.scrollTo(0,0);
}

function set_type(type) {
  switch(type) {
    case 'post':
    document.getElementById('post').removeAttribute('style');
    document.getElementById('page').setAttribute('style','display:none');
    document.getElementById('custom_text').setAttribute('style','display:none');
    document.getElementById('url').setAttribute('style','display:none');
    document.getElementById('none').setAttribute('style','display:none');
    break;
    case 'page':
      document.getElementById('page').removeAttribute('style');
      document.getElementById('post').setAttribute('style','display:none');
      document.getElementById('custom_text').setAttribute('style','display:none');
      document.getElementById('url').setAttribute('style','display:none');
      document.getElementById('none').setAttribute('style','display:none');
      break;
    case 'custom_text':
      document.getElementById('page').setAttribute('style','display:none');
      document.getElementById('post').setAttribute('style','display:none');
      document.getElementById('custom_text').removeAttribute('style');
      document.getElementById('url').setAttribute('style','display:none');
      document.getElementById('none').setAttribute('style','display:none');
      break;
    case 'url':
      document.getElementById('page').setAttribute('style','display:none');
      document.getElementById('post').setAttribute('style','display:none');
      document.getElementById('custom_text').setAttribute('style','display:none');
      document.getElementById('url').removeAttribute('style');
      document.getElementById('none').setAttribute('style','display:none');
      break;
    case 'none':
      document.getElementById('page').setAttribute('style','display:none');
      document.getElementById('post').setAttribute('style','display:none');
      document.getElementById('custom_text').setAttribute('style','display:none');
      document.getElementById('url').setAttribute('style','display:none');
      document.getElementById('none').removeAttribute('style');
      break;
  }
}

function insertAtCursor(id, myValue) {
  var myField = document.getElementById(id);
  if (myField.style.display == "none") {
    var ed = tinymce.get(id);
    if (typeof ed.insertContent == "undefined") {
      tinyMCE.execCommand('mceInsertContent', false, "%" + myValue + "%");
    }
    else {
      ed.insertContent("%" + myValue + "%");
    }
    return;
  }
  if (document.selection) {
    myField.focus();
    sel = document.selection.createRange();
    sel.text = myValue;
  }
  else if (myField.selectionStart || myField.selectionStart == '0') {
    var startPos = myField.selectionStart;
    var endPos = myField.selectionEnd;
    myField.value = myField.value.substring(0, startPos)
      + "%" + myValue + "%"
      + myField.value.substring(endPos, myField.value.length);
  }
  else {
    myField.value += "%" + myValue + "%";
  }
}

function check_isnum(e) {
  var chCode1 = e.which || e.keyCode;
  if (chCode1 > 31 && (chCode1 < 48 || chCode1 > 57)) {
    return false;
  }
  return true;
}

// Check Email.
function spider_check_email(id) {
  if (document.getElementById(id) && jQuery('#' + id).val() != '') {
    var email_array = jQuery('#' + id).val().split(',');
    for (var email_id = 0; email_id < email_array.length; email_id++) {
      var email = email_array[email_id].replace(/^\s+|\s+$/g, '');
      if (email.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) == -1) {
        alert(fmc_objectL10n.fmc_not_valid_email_address);
        jQuery('#' + id).css('border', '1px solid #FF0000');
        jQuery('#' + id).focus();
        jQuery('html, body').animate({
          scrollTop:jQuery('#' + id).offset().top - 200
        }, 500);
        return true;
      }
    }
  }
  return false;
}

function spider_edit_ip(id) {
  var ip = jQuery("#ip" + id).html();
  jQuery("#td_ip_" + id).html('<input id="ip' + id + '" class="input_th' + id + '" type="text" onkeypress="return spider_check_isnum(event)" value="' + ip + '" name="ip' + id + '" />');
  jQuery("#td_edit_" + id).html('<button class="fm-icon add-block-ip-icon" onclick="if (spider_check_required(\'ip' + id + '\', \'IP\')) {return false;} spider_set_input_value(\'task\', \'save\'); spider_set_input_value(\'current_id\', ' + id + '); spider_save_ip(' + id + ')"></button>');
}


function spider_save_ip(id) {
  var ip = jQuery("#ip" + id).val();
  var post_data = {};
  post_data["ip"] = ip;
  post_data["current_id"] = id;
  post_data["task"] = "save";
  jQuery.post(
    jQuery("#blocked_ips").attr("action"),
    post_data,
    function (data) {
      jQuery("#td_ip_" + id).html('<a id="ip' + id + '" class="pointer" title="' + fmc_objectL10n.fmc_Edit + '" onclick="spider_edit_ip(' + id + ')">' + ip + '</a>');
      jQuery("#td_edit_" + id).html('<button class="fm-icon edit-icon" onclick="spider_edit_ip(' + id + ')"></button>');
    }
  ).success(function (data, textStatus, errorThrown) {
    jQuery(".update, .error").hide();
    jQuery("#fm_blocked_ips_message").html("<div class='updated'><strong><p>" + fmc_objectL10n.fmc_Items_succesfully_saved + "</p></strong></div>");
    jQuery("#fm_blocked_ips_message").show();
  });
}

function wdhide(id) {
  document.getElementById(id).style.display = "none";
}

function wdshow(id) {
  document.getElementById(id).style.display = "block";
}

function cfm_create_input(toAdd_id, value_id, parent_id, cfm_url) {
  var value = jQuery("#" + value_id).val();
  if (value) {
    jQuery("#" + value_id).attr("style", "width: 250px;");
    var mail_div = jQuery("<div>").attr("class", "fm_mail_div").prependTo("#" + parent_id).text(value);
    jQuery("<img>").attr("src", cfm_url + "/images/delete.png").attr("class", "fm_delete_img").attr("onclick", "fm_delete_mail(this, '" + value + "')").attr("title", fmc_objectL10n.fmc_Delete_email).appendTo(mail_div);
    jQuery("#" + value_id).val("");
    jQuery("#" + toAdd_id).val(jQuery("#" + toAdd_id).val() + value + ",");
  }
}

function fm_delete_mail(img, value) {
  jQuery(img).parent().remove();
  jQuery("#mail").val(jQuery("#mail").val().replace(value + ',', ''));
}
