j = 2;
var c;
var need_enable = true;;
var a = new Array();
if (ajaxurl.indexOf("://") != -1) {
  var url_for_ajax = ajaxurl;
}
else {
  var url_for_ajax = location.protocol + '//' + location.host + ajaxurl;
}

function active_reset(val, id) {
	if (val) {
		document.getElementById(id+'_element_resetform_id_temp').style.display = "inline";
	}
	else {
		document.getElementById(id+'_element_resetform_id_temp').style.display = "none";
	}
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function chnage_icons_src(img,icon) {
  if (img.src.indexOf("hover") != -1) {
    img.src =  contact_form_maker_plugin_url + "/images/" + icon + ".png";
  }
  else {
    img.src =  contact_form_maker_plugin_url + "/images/" + icon + "_hover.png";
  }
}

function return_attributes(id) {
	attr_names = new Array();
	attr_values = new Array();
	var input = document.getElementById(id);
	if (input) {
		atr = input.attributes;
    for (i = 0; i < 30; i++) {
      if (atr[i]) {
        if (atr[i].name.indexOf("add_") == 0) {
          attr_names.push(atr[i].name.replace('add_', ''));
          attr_values.push(atr[i].value);
        }
      }
    }
	}
	return Array(attr_names, attr_values);
}

function refresh_attr(x,type) {
	switch(type) {
		case "type_text": {
			id_array=Array();
			id_array[0]=x+'_elementform_id_temp';
			break;
		}

		case "type_name": {
			id_array=Array();
			id_array[0]=x+'_element_firstform_id_temp';
			id_array[1]=x+'_element_lastform_id_temp';
			id_array[2]=x+'_element_titleform_id_temp';
			id_array[3]=x+'_element_middleform_id_temp';
			break;
		}
		
		case "type_address":
			
		{
			id_array=Array();
			id_array[0]=x+'_street1form_id_temp';
			id_array[1]=x+'_street2form_id_temp';
			id_array[2]=x+'_cityform_id_temp';
			id_array[3]=x+'_stateform_id_temp';
			id_array[4]=x+'_postalform_id_temp';
			id_array[5]=x+'_countryform_id_temp';
			break;
		}
		
		case "type_checkbox":
			
		{
			id_array=Array();
			for(z=0;z<50;z++)
				id_array[z]=x+'_elementform_id_temp'+z;
			break;
		}
		
		case "type_captcha":
			
		{
			id_array=Array();
			id_array[0]='_wd_captchaform_id_temp';
			id_array[1]='_wd_captcha_inputform_id_temp';
			id_array[2]='_element_refreshform_id_temp';
			break;
		}
		
		case "type_recaptcha":
			
		{
			id_array=Array();
			id_array[0]='wd_recaptchaform_id_temp';
			break;
		}
		
		case "type_submit_reset":
			
		{
			id_array=Array();
			id_array[0]=x+'_element_submitform_id_temp';
			id_array[1]=x+'_element_resetform_id_temp';
			break;
		}
		
	}
		
	for(q=0; q<id_array.length;q++)
	{
		id=id_array[q];
		var input=document.getElementById(id);
		if(input)
		{
			atr=input.attributes;
			for(i=0;i<30;i++)
				if(atr[i])
					{
						if(atr[i].name.indexOf("add_")==0)
						{
							input.removeAttribute(atr[i].name);
							i--;
						}
					}
				
			for(i=0;i<10;i++)
				if(document.getElementById("attr_name"+i))
				{
					try{input.setAttribute("add_"+document.getElementById("attr_name"+i).value, document.getElementById("attr_value"+i).value)}
					catch(err)
					{
						alert(fmc_objectL10n.fmc_Only_letters);
					}
				}
		}
	}
}

function add_attr(i, type) {
	var el_attr_table=document.getElementById('attributes');
	j=parseInt(el_attr_table.lastChild.getAttribute('idi'))+1;
	w_attr_name[j]="attribute";
	w_attr_value[j]="value";
	var el_attr_tr = document.createElement('tr');
		el_attr_tr.setAttribute("id", "attr_row_"+j);
		el_attr_tr.setAttribute("idi", j);
	var el_attr_td_name = document.createElement('td');
		el_attr_td_name.style.cssText = 'width:100px';
	var el_attr_td_value = document.createElement('td');
		el_attr_td_value.style.cssText = 'width:100px';
	
	var el_attr_td_X = document.createElement('td');
	var el_attr_name = document.createElement('input');
		el_attr_name.setAttribute("type", "text");
		el_attr_name.style.cssText = "width:100px";
		el_attr_name.setAttribute("value", w_attr_name[j]);
		el_attr_name.setAttribute("id", "attr_name"+j);
		el_attr_name.setAttribute("onChange", "change_attribute_name('"+i+"', this, '"+type+"')");	
		
	var el_attr_value = document.createElement('input');
		el_attr_value.setAttribute("type", "text");
		el_attr_value.style.cssText = "width:100px";
		el_attr_value.setAttribute("value", w_attr_value[j]);
		el_attr_value.setAttribute("id", "attr_value"+j);
		el_attr_value.setAttribute("onChange", "change_attribute_value('"+i+"', "+j+", '"+type+"')");
	
	var el_attr_remove = document.createElement('img');
		el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
		el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
		el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
		
		el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", '"+type+"')");
	el_attr_table.appendChild(el_attr_tr);
	el_attr_tr.appendChild(el_attr_td_name);
	el_attr_tr.appendChild(el_attr_td_value);
	el_attr_tr.appendChild(el_attr_td_X);
	el_attr_td_name.appendChild(el_attr_name);
	el_attr_td_value.appendChild(el_attr_value);
	el_attr_td_X.appendChild(el_attr_remove);
  refresh_attr(i, type);
}

function change_attribute_value(id, x, type) {
	if (!document.getElementById("attr_name" + x).value) {
		alert(fmc_objectL10n.fmc_name_attribute_required);
		return
	}
	if (document.getElementById("attr_name" + x).value.toLowerCase() == "style") {
		alert(fmc_objectL10n.fmc_cannot_add_style_attribute);
		return
	}
	refresh_attr(id, type);
}

function change_attribute_name(id, x, type) {
	value = x.value;
	if (!value) {
		alert(fmc_objectL10n.fmc_name_attribute_required);
		return;
	}
	if (value.toLowerCase() == "style") {
		alert(fmc_objectL10n.fmc_cannot_add_style_attribute);
		return;
	}
	if (value == parseInt(value)) {
		alert(fmc_objectL10n.fmc_name_attribute_cannotbe_number);
		return;
	}
	if (value.indexOf(" ") != -1) {
		var regExp = /\s+/g;
		value=value.replace(regExp,'');
		x.value = value;
		alert(fmc_objectL10n.fmc_name_attribute_cannot_containspace);
		refresh_attr(id, type);
		return;
	}
	refresh_attr(id, type);
}

function remove_attr(id, el_id, type) {
	tr=document.getElementById("attr_row_"+id);
	tr.parentNode.removeChild(tr);
	refresh_attr(el_id, type);
}

function change_attributes(id, attr) {
  var div = document.createElement('div');
  var element = document.getElementById(id);
	element.setAttribute(attr, '');
}

function change_class(x,id) {
	if(document.getElementById(id+'_label_sectionform_id_temp'))
	document.getElementById(id+'_label_sectionform_id_temp').setAttribute("class",x);
	if(document.getElementById(id+'_element_sectionform_id_temp'))
	document.getElementById(id+'_element_sectionform_id_temp').setAttribute("class",x);
}

function set_required(id) {	
	if(document.getElementById(id+"form_id_temp").value=="yes")
	{
		document.getElementById(id+"form_id_temp").setAttribute("value", "no");
		document.getElementById(id+"_elementform_id_temp").innerHTML="";
	}	
	else
	{
		document.getElementById(id+"form_id_temp").setAttribute("value", "yes")
		document.getElementById(id+"_elementform_id_temp").innerHTML=" *";
	}
}

function disable_fields(id,field)
{	
	var div = document.getElementById(id+"_div_address");
	
		
	if(field)
	{
		if(document.getElementById("el_"+field).checked==true)
			document.getElementById(id+"_disable_fieldsform_id_temp").setAttribute(field, "yes");
		else
			document.getElementById(id+"_disable_fieldsform_id_temp").setAttribute(field, "no");
	}
	
	
	if(document.getElementById(id+"_disable_fieldsform_id_temp").getAttribute("state")=='yes')
	{
		document.getElementById("el_us_states").disabled =true;
	}	
	else
	{
		document.getElementById("el_us_states").disabled =false;
		if(field=='us_states')
		{		
			change_state_input(id,'form_id_temp');
			return;
		}
		
	}
	
		div.innerHTML='';
	

		var hidden_labels = new Array();
		var address_fields =['street1','street2','city','state','postal','country']
		var left_right=0;
		
		for(l=0; l<6; l++)
		{
			if(document.getElementById(id+'_disable_fieldsform_id_temp').getAttribute(address_fields[l])=='no')	
			{
				if(address_fields[l]=='street1' || address_fields[l]=='street2')    
				{  
					var street = document.createElement('input');
						street.setAttribute("type", 'text');
						street.style.cssText = "width:100%";
						street.setAttribute("id", id+"_"+address_fields[l]+"form_id_temp");
						street.setAttribute("name", (parseInt(id)+l)+"_"+address_fields[l]+"form_id_temp");
						street.setAttribute("onChange", "change_value('"+id+"_"+address_fields[l]+"form_id_temp')");
							
					var street_label = document.createElement('label');
						street_label.setAttribute("class", "mini_label");	
						street_label.setAttribute("id", id+"_mini_label_"+address_fields[l]);
						street_label.style.cssText = "display:block;";
						street_label.innerHTML=document.getElementById('el_'+address_fields[l]+"_label").innerHTML;
						w_mini_labels[l] = document.getElementById('el_'+address_fields[l]+"_label").innerHTML;
						
					var span_addres = document.createElement('span');
						span_addres.style.cssText = "float:left; width:100%;  padding-bottom: 8px; display:block";	
					
					span_addres.appendChild(street);
					span_addres.appendChild(street_label);
					div.appendChild(span_addres);				
						
				}	
				else
				{
				left_right++;
				
					if(address_fields[l]!='country')
					{

					
						var field = document.createElement('input');
							field.setAttribute("type", 'text');
							field.style.cssText = "width:100%";
							field.setAttribute("id", id+"_"+address_fields[l]+"form_id_temp");
							field.setAttribute("name", (parseInt(id)+l)+"_"+address_fields[l]+"form_id_temp");
							field.setAttribute("onChange", "change_value('"+id+"_"+address_fields[l]+"form_id_temp')");

						var field_label = document.createElement('label');
							field_label.setAttribute("class", "mini_label");		
							field_label.setAttribute("id", id+"_mini_label_"+address_fields[l]);
							field_label.style.cssText = "display:block;";
							field_label.innerHTML=document.getElementById('el_'+address_fields[l]+"_label").innerHTML;
							w_mini_labels[l] = document.getElementById('el_'+address_fields[l]+"_label").innerHTML;
							
						
					}
					else
					{
							var field = document.createElement('select');
								field.setAttribute("type", 'text');
								field.style.cssText = "width:100%";
								field.setAttribute("id", id+"_countryform_id_temp");
								field.setAttribute("name", (parseInt(id)+l)+"_countryform_id_temp");
								field.setAttribute("onChange", "change_state_input('"+id+"', 'form_id_temp')");

							var field_label = document.createElement('label');
								field_label.setAttribute("class", "mini_label");	
								field_label.setAttribute("id", id+"_mini_label_country");
								field_label.style.cssText = "display:block;";
								field_label.innerHTML=document.getElementById('el_'+address_fields[l]+"_label").innerHTML;
								w_mini_labels[l] = document.getElementById('el_'+address_fields[l]+"_label").innerHTML;
								
							var option_ = document.createElement('option');
								option_.setAttribute("value", "");
								option_.innerHTML="";
							field.appendChild(option_);
							
							coutries=[fmc_objectL10n.fmc_Afghanistan,fmc_objectL10n.fmc_Albania,fmc_objectL10n.fmc_Algeria,fmc_objectL10n.fmc_Andorra,fmc_objectL10n.fmc_Angola,fmc_objectL10n.fmc_AntiguaandBarbuda,fmc_objectL10n.fmc_Argentina,fmc_objectL10n.fmc_Armenia,fmc_objectL10n.fmc_Australia,fmc_objectL10n.fmc_Austria,fmc_objectL10n.fmc_Azerbaijan,fmc_objectL10n.fmc_Bahamas,fmc_objectL10n.fmc_Bahrain,fmc_objectL10n.fmc_Bangladesh,fmc_objectL10n.fmc_Barbados,fmc_objectL10n.fmc_Belarus,fmc_objectL10n.fmc_Belgium,fmc_objectL10n.fmc_Belize,fmc_objectL10n.fmc_Benin,fmc_objectL10n.fmc_Bhutan,fmc_objectL10n.fmc_Bolivia,fmc_objectL10n.fmc_BosniaandHerzegovina,fmc_objectL10n.fmc_Botswana,fmc_objectL10n.fmc_Brazil,fmc_objectL10n.fmc_Brunei,fmc_objectL10n.fmc_Bulgaria,fmc_objectL10n.fmc_BurkinaFaso,fmc_objectL10n.fmc_Burundi,fmc_objectL10n.fmc_Cambodia,fmc_objectL10n.fmc_Cameroon,fmc_objectL10n.fmc_Canada,fmc_objectL10n.fmc_CapeVerde,fmc_objectL10n.fmc_CentralAfricanRepublic,fmc_objectL10n.fmc_Chad,fmc_objectL10n.fmc_Chile,fmc_objectL10n.fmc_China,fmc_objectL10n.fmc_Colombi,fmc_objectL10n.fmc_Comoros,fmc_objectL10n.fmc_CongoBrazzaville,fmc_objectL10n.fmc_Congo,fmc_objectL10n.fmc_CostaRica,fmc_objectL10n.fmc_CotedIvoire,fmc_objectL10n.fmc_Croatia,fmc_objectL10n.fmc_Cuba,fmc_objectL10n.fmc_Cyprus,fmc_objectL10n.fmc_CzechRepublic,fmc_objectL10n.fmc_Denmark,fmc_objectL10n.fmc_Djibouti,fmc_objectL10n.fmc_Dominica,fmc_objectL10n.fmc_DominicanRepublic,fmc_objectL10n.fmc_EastTimorTimorTimur,fmc_objectL10n.fmc_Ecuador,fmc_objectL10n.fmc_Egypt,fmc_objectL10n.fmc_ElSalvador,fmc_objectL10n.fmc_EquatorialGuinea,fmc_objectL10n.fmc_Eritrea,fmc_objectL10n.fmc_Estonia,fmc_objectL10n.fmc_Ethiopia,fmc_objectL10n.fmc_Fiji,fmc_objectL10n.fmc_Finland,fmc_objectL10n.fmc_France,fmc_objectL10n.fmc_Gabon,fmc_objectL10n.fmc_GambiaThe,fmc_objectL10n.fmc_Georgia,fmc_objectL10n.fmc_Germany,fmc_objectL10n.fmc_Ghana,fmc_objectL10n.fmc_Greece,fmc_objectL10n.fmc_Grenada,fmc_objectL10n.fmc_Guatemala,fmc_objectL10n.fmc_Guinea,fmc_objectL10n.fmc_GuineaBissau,fmc_objectL10n.fmc_Guyana,fmc_objectL10n.fmc_Haiti,fmc_objectL10n.fmc_Honduras,fmc_objectL10n.fmc_Hungary,fmc_objectL10n.fmc_Iceland,fmc_objectL10n.fmc_India,fmc_objectL10n.fmc_Indonesia,fmc_objectL10n.fmc_Iran,fmc_objectL10n.fmc_Iraq,fmc_objectL10n.fmc_Ireland,fmc_objectL10n.fmc_Israel,fmc_objectL10n.fmc_Italy,fmc_objectL10n.fmc_Jamaica,fmc_objectL10n.fmc_Japan,fmc_objectL10n.fmc_Jordan,fmc_objectL10n.fmc_Kazakhstan,fmc_objectL10n.fmc_Kenya,fmc_objectL10n.fmc_Kiribati,fmc_objectL10n.fmc_KoreaNorth,fmc_objectL10n.fmc_KoreaSouth,fmc_objectL10n.fmc_Kuwait,fmc_objectL10n.fmc_Kyrgyzstan,fmc_objectL10n.fmc_Laos,fmc_objectL10n.fmc_Latvia,fmc_objectL10n.fmc_Lebanon,fmc_objectL10n.fmc_Lesotho,fmc_objectL10n.fmc_Liberia,fmc_objectL10n.fmc_Libya,fmc_objectL10n.fmc_Liechtenstein,fmc_objectL10n.fmc_Lithuania,fmc_objectL10n.fmc_Luxembourg,fmc_objectL10n.fmc_Macedonia,fmc_objectL10n.fmc_Madagascar,fmc_objectL10n.fmc_Malawi,fmc_objectL10n.fmc_Malaysia,fmc_objectL10n.fmc_Maldives,fmc_objectL10n.fmc_Mali,fmc_objectL10n.fmc_Malta,fmc_objectL10n.fmc_MarshallIslands,fmc_objectL10n.fmc_Mauritania,fmc_objectL10n.fmc_Mauritius,fmc_objectL10n.fmc_Mexico,fmc_objectL10n.fmc_Micronesia,fmc_objectL10n.fmc_Moldova,fmc_objectL10n.fmc_Monaco,fmc_objectL10n.fmc_Mongolia,fmc_objectL10n.fmc_Morocco,fmc_objectL10n.fmc_Mozambique,fmc_objectL10n.fmc_Myanmar,fmc_objectL10n.fmc_Namibia,fmc_objectL10n.fmc_Nauru,fmc_objectL10n.fmc_Nepa,fmc_objectL10n.fmc_Netherlands,fmc_objectL10n.fmc_NewZealand,fmc_objectL10n.fmc_Nicaragua,fmc_objectL10n.fmc_Niger,fmc_objectL10n.fmc_Nigeria,fmc_objectL10n.fmc_Norway,fmc_objectL10n.fmc_Oman,fmc_objectL10n.fmc_Pakistan,fmc_objectL10n.fmc_Palau,fmc_objectL10n.fmc_Panama,fmc_objectL10n.fmc_PapuaNewGuinea,fmc_objectL10n.fmc_Paraguay,fmc_objectL10n.fmc_Peru,fmc_objectL10n.fmc_Philippines,fmc_objectL10n.fmc_Poland,fmc_objectL10n.fmc_Portugal,fmc_objectL10n.fmc_Qatar,fmc_objectL10n.fmc_Romania,fmc_objectL10n.fmc_Russia,fmc_objectL10n.fmc_Rwanda,fmc_objectL10n.fmc_SaintKittsandNevis,fmc_objectL10n.fmc_SaintLucia,fmc_objectL10n.fmc_SaintVincent,fmc_objectL10n.fmc_Samoa,fmc_objectL10n.fmc_SanMarino,fmc_objectL10n.fmc_SaoTomeandPrincipe,fmc_objectL10n.fmc_SaudiArabia,fmc_objectL10n.fmc_Senegal,fmc_objectL10n.fmc_SerbiandMontenegro,fmc_objectL10n.fmc_Seychelles,fmc_objectL10n.fmc_SierraLeone,fmc_objectL10n.fmc_Singapore,fmc_objectL10n.fmc_Slovakia,fmc_objectL10n.fmc_Slovenia,fmc_objectL10n.fmc_SolomonIslands,fmc_objectL10n.fmc_Somalia,fmc_objectL10n.fmc_SouthAfrica,fmc_objectL10n.fmc_Spain,fmc_objectL10n.fmc_SriLanka,fmc_objectL10n.fmc_Sudan,fmc_objectL10n.fmc_Suriname,fmc_objectL10n.fmc_Swaziland,fmc_objectL10n.fmc_Sweden,fmc_objectL10n.fmc_Switzerland,fmc_objectL10n.fmc_Syria,fmc_objectL10n.fmc_Taiwan,fmc_objectL10n.fmc_Tajikistan,fmc_objectL10n.fmc_Tanzania,fmc_objectL10n.fmc_Thailand,fmc_objectL10n.fmc_Togo,fmc_objectL10n.fmc_Tonga,fmc_objectL10n.fmc_TrinidadandTobago,fmc_objectL10n.fmc_Tunisia,fmc_objectL10n.fmc_Turkey,fmc_objectL10n.fmc_Turkmenistan,fmc_objectL10n.fmc_Tuvalu,fmc_objectL10n.fmc_Uganda,fmc_objectL10n.fmc_Ukraine,fmc_objectL10n.fmc_UnitedArabEmirates,fmc_objectL10n.fmc_UnitedKingdom,fmc_objectL10n.fmc_UnitedStates,fmc_objectL10n.fmc_Uruguay,fmc_objectL10n.fmc_Uzbekistan,fmc_objectL10n.fmc_Vanuatu,fmc_objectL10n.fmc_VaticanCity,fmc_objectL10n.fmc_Venezuela,fmc_objectL10n.fmc_Vietnam,fmc_objectL10n.fmc_Yemen,fmc_objectL10n.fmc_Zambia,fmc_objectL10n.fmc_Zimbabwe];	
							for(r=0;r<coutries.length;r++)
							{
							var option_ = document.createElement('option');
								option_.setAttribute("value", coutries[r]);
								option_.innerHTML=coutries[r];
							field.appendChild(option_);
							}
					
					}	

					if(left_right%2!=0)	
					{
						var span_addres = document.createElement('span');
							span_addres.style.cssText = "float:left; width:48%; padding-bottom: 8px;";
					}
					else
					{
						var span_addres = document.createElement('span');
							span_addres.style.cssText = "float:right; width:48%; padding-bottom: 8px;";
					}	
						
					span_addres.appendChild(field);
					span_addres.appendChild(field_label);
					div.appendChild(span_addres);
					
				}
			}
			else
			{
				var hidden_field = document.createElement('input');
					hidden_field.setAttribute("type", 'hidden');
					hidden_field.setAttribute("id", id+"_"+address_fields[l]+"form_id_temp");
					hidden_field.setAttribute("value", document.getElementById("el_"+address_fields[l]+"_label").innerHTML);
					hidden_field.setAttribute("id_for_label", parseInt(id)+l); 
					
					hidden_labels.push(hidden_field);
			
			}
			
			
			for(k=0; k<hidden_labels.length; k++)
			{
			div.appendChild(hidden_labels[k]);

			}
			
		}
		
		
		if(document.getElementById(id+"_disable_fieldsform_id_temp").getAttribute("state")=='no' && document.getElementById(id+"_disable_fieldsform_id_temp").getAttribute("country")=='yes')
			change_state_input(id,'form_id_temp');
		
		jQuery(document).ready(function() {		
	jQuery("label#"+id+"_mini_label_street1").click(function() {			

	if (jQuery(this).children('input').length == 0) {				
	var street1 = "<input type='text' class='street1' style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
		jQuery(this).html(street1);					
		jQuery("input.street1").focus();		
		jQuery("input.street1").blur(function() {	
	var value = jQuery(this).val();			
		jQuery("#"+id+"_mini_label_street1").text(value);		
		document.getElementById('el_street1_label').innerHTML=	value;	
	});		
	}	
	});		
	
	jQuery("label#"+id+"_mini_label_street2").click(function() {		
	if (jQuery(this).children('input').length == 0) {		
	var street2 = "<input type='text' class='street2'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
		jQuery(this).html(street2);					
		jQuery("input.street2").focus();		
		jQuery("input.street2").blur(function() {	
	var value = jQuery(this).val();			
		jQuery("#"+id+"_mini_label_street2").text(value);
		document.getElementById('el_street2_label').innerHTML=	value;		
	});		
	}	
	});	
	
	
	jQuery("label#"+id+"_mini_label_city").click(function() {	
	if (jQuery(this).children('input').length == 0) {	
	var city = "<input type='text' class='city'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
		jQuery(this).html(city);			
		jQuery("input.city").focus();				
		jQuery("input.city").blur(function() {			
	var value = jQuery(this).val();		
		jQuery("#"+id+"_mini_label_city").text(value);	
		document.getElementById('el_city_label').innerHTML=	value;		
	});		
	}	
	});	
	
	jQuery("label#"+id+"_mini_label_state").click(function() {		
	if (jQuery(this).children('input').length == 0) {	
	var state = "<input type='text' class='state'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";	
		jQuery(this).html(state);		
		jQuery("input.state").focus();		
		jQuery("input.state").blur(function() {		
	var value = jQuery(this).val();			
		jQuery("#"+id+"_mini_label_state").text(value);
		document.getElementById('el_state_label').innerHTML=	value;		
	});	
	}
	});		

	jQuery("label#"+id+"_mini_label_postal").click(function() {		
	if (jQuery(this).children('input').length == 0) {			
	var postal = "<input type='text' class='postal'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
		jQuery(this).html(postal);			
		jQuery("input.postal").focus();			
		jQuery("input.postal").blur(function() {			
	var value = jQuery(this).val();		
		jQuery("#"+id+"_mini_label_postal").text(value);	
		document.getElementById('el_postal_label').innerHTML=	value;		
	});	
	}
	});	
	
	
	jQuery("label#"+id+"_mini_label_country").click(function() {		
		if (jQuery(this).children('input').length == 0) {		
		var country = "<input type='text' class='country'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
			jQuery(this).html(country);		
			jQuery("input.country").focus();	
			jQuery("input.country").blur(function() {		
		var value = jQuery(this).val();			
			jQuery("#"+id+"_mini_label_country").text(value);
			document.getElementById('el_country_label').innerHTML=	value;				
			});	
		}	
	});
	});	

refresh_attr(id,type);

	
}


function set_unique(id)
{	
	if(document.getElementById(id).value=="yes")
	{
		document.getElementById(id).setAttribute("value", "no");
	}	
	else
	{
		document.getElementById(id).setAttribute("value", "yes")
	}
}

function set_randomize(id)
{	
	if(document.getElementById(id).value=="yes")
	{
		document.getElementById(id).setAttribute("value", "no");
	}	
	else
	{
		document.getElementById(id).setAttribute("value", "yes")
	}
}
function show_other_input(num)
{
		for(k=0;k<50;k++)
			if(	document.getElementById(num+"_elementform_id_temp"+k)) 
				if(	document.getElementById(num+"_elementform_id_temp"+k).getAttribute('other')) 
					if(	document.getElementById(num+"_elementform_id_temp"+k).getAttribute('other')==1)
					{
						element_other=document.getElementById(num+"_elementform_id_temp"+k);
						break;
					}



	parent=element_other.parentNode;

	var br = document.createElement('br');
		br.setAttribute("id", num+"_other_brform_id_temp");
		
	var el_other = document.createElement('input');
		el_other.setAttribute("id", num+"_other_inputform_id_temp");
		el_other.setAttribute("name", num+"_other_inputform_id_temp");
		el_other.setAttribute("type", "text");
		el_other.setAttribute("class", "other_input");
	parent.appendChild(br);
	parent.appendChild(el_other);
}

function set_allow_other(num, type)
{	
	if(document.getElementById(num+'_allow_otherform_id_temp').value=="yes")
	{
	
		document.getElementById(num+'_allow_otherform_id_temp').setAttribute("value", "no");
		for(k=0;k<50;k++)
			if(	document.getElementById("el_choices"+k)) 
				if(	document.getElementById("el_choices"+k).getAttribute('other')) 
					if(	document.getElementById("el_choices"+k).getAttribute('other')==1)
					{
				
						remove_choise(k,num,type);
						break;
					}
					
	}	
	else
	{
		document.getElementById(num+'_allow_otherform_id_temp').setAttribute("value", "yes");
		j++;

				
				var choices_td= document.getElementById('choices');
				var br = document.createElement('br');
				br.setAttribute("id", "br"+j);
				var el_choices = document.createElement('input');
					el_choices.setAttribute("id", "el_choices"+j);
					el_choices.setAttribute("type", "text");
					el_choices.setAttribute("value", "other");
					el_choices.setAttribute("other", "1");
					el_choices.style.cssText =   "width:100px; margin:0; padding:0; border-width: 1px";
					el_choices.setAttribute("onKeyUp", "change_label('"+num+"_label_element"+j+"', this.value); change_in_value('"+num+"_elementform_id_temp"+j+"', this.value)");
			
				var el_choices_remove = document.createElement('img');
					el_choices_remove.setAttribute("id", "el_choices"+j+"_remove");
					el_choices_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
					el_choices_remove.style.cssText =  'cursor:pointer;vertical-align:middle; margin:3px; display:none';
					el_choices_remove.setAttribute("align", 'top');
					el_choices_remove.setAttribute("onClick", "remove_choise('"+j+"','"+num+"','"+type+"')");
			
				choices_td.appendChild(br);
				choices_td.appendChild(el_choices);
				choices_td.appendChild(el_choices_remove);
				
			if(type=='checkbox')
			refresh_attr(num, 'type_checkbox');
				

			if(type=='radio')
			refresh_attr(num, 'type_radio');

			
			refresh_rowcol(num, type);
	}

}

function check_isnum_3_10(e)
{
	
   	var chCode1 = e.which || e.keyCode;
    	if (chCode1 > 31 && (chCode1 < 51 || chCode1 > 57))
        return false
	else if((document.getElementById('captcha_digit').value+(chCode1-48))>9)
        return false;
	return true;
}

function change_captcha_digit(digit)
{
	captcha=document.getElementById('_wd_captchaform_id_temp');
	if(document.getElementById('captcha_digit').value)
	{	
		captcha.setAttribute("digit", digit);
	
		captcha.setAttribute("src", url_for_ajax + "?action=ContactFormmakerwdcaptcha&digit="+digit+"&i=form_id_temp");
		document.getElementById('_wd_captcha_inputform_id_temp').style.width=(document.getElementById('captcha_digit').value*10+15)+"px";
	}
	else
	{
		captcha.setAttribute("digit", "6");
		captcha.setAttribute("src", url_for_ajax + "?action=ContactFormmakerwdcaptcha&digit=6"+"&i=form_id_temp");
		document.getElementById('_wd_captcha_inputform_id_temp').style.width=(6*10+15)+"px";
	}
}


function check_isnum(e)
{
	
   	var chCode1 = e.which || e.keyCode;
    	if (chCode1 > 31 && (chCode1 < 48 || chCode1 > 57))
        return false;
	return true;
}

function check_isnum_or_minus(e)
{
	
   	var chCode1 = e.which || e.keyCode;
	if (chCode1 != 45 )
	{
    	if (chCode1 > 31 && (chCode1 < 48 || chCode1 > 57))
        return false;
	}	
	return true;
}


function change_w_style(id, w)
{
	if(document.getElementById(id))
	document.getElementById(id).style.width=w+"px";
}

function change_w_label(id, w)
{
	if(document.getElementById(id))
	document.getElementById(id).innerHTML=w;
}

function change_h_style(id, h)
{
	document.getElementById(id).style.height=h+"px";
}


function change_key(value, attribute)
{
	document.getElementById('wd_recaptchaform_id_temp').setAttribute(attribute, value);
}

function captcha_refresh(id)
{	
	srcArr=document.getElementById(id+"form_id_temp").src.split("&r=");
	document.getElementById(id+"form_id_temp").src=srcArr[0]+'&r='+Math.floor(Math.random()*100);
	document.getElementById(id+"_inputform_id_temp").value='';
}

function up_row(id)
{
	wdform_field=document.getElementById("wdform_field"+id);
	wdform_row=wdform_field.parentNode;
	wdform_column=wdform_row.parentNode;
	wdform_section=wdform_column.parentNode;
	wdform_page=wdform_section.parentNode;

	k=0;
	
	while(wdform_column.childNodes[k])
	{
		if(wdform_column.childNodes[k].getAttribute("wdid"))
			if(id==wdform_column.childNodes[k].getAttribute("wdid"))
				break;
		k++;
	}

	if(k!=0)
	{
		up=wdform_column.childNodes[k-1];
		down=wdform_column.childNodes[k];
		wdform_column.removeChild(down);
		wdform_column.insertBefore(down, up);
		return;
	}
	
	/*en depqum yerb section breaka*/
	
	if(wdform_section.previousSibling)
	{
		if(wdform_section.previousSibling.getAttribute('type'))
		{
			wdform_section.previousSibling.previousSibling.firstChild.appendChild(wdform_row);
			return;
		}
	}


}

function down_row(id)
{
	wdform_field=document.getElementById("wdform_field"+id);
	wdform_row=wdform_field.parentNode;
	wdform_column=wdform_row.parentNode;
	wdform_section=wdform_column.parentNode;
	wdform_page=wdform_section.parentNode;

	l=wdform_column.childNodes.length;
	
	/*
	form=wdform_column
	*/
	k=0;
	
	while(wdform_column.childNodes[k])
	{
		if(wdform_column.childNodes[k].getAttribute("wdid"))
			if(id==wdform_column.childNodes[k].getAttribute("wdid"))
				break;
		k++;
	}

	if(k!=l-1)
	{
	/*ira mej*/
		up=wdform_column.childNodes[k];
		down=wdform_column.childNodes[k+2];
		wdform_column.removeChild(up);
		
		if(!down)
			down=null;

		wdform_column.insertBefore(up, down);
		return;
	}
	/*en depqum yerb section breaka*/
	
	if(wdform_section.nextSibling.getAttribute('type'))
	{
		wdform_section.nextSibling.nextSibling.firstChild.appendChild(wdform_row);
		return;
	}

}

function right_row(id)
{
	wdform_field=document.getElementById("wdform_field"+id);
	wdform_row=wdform_field.parentNode;
	wdform_column=wdform_row.parentNode;
	wdform_section=wdform_column.parentNode;
	if(wdform_column.nextSibling!=null)
	{
		wdform_column_next=wdform_column.nextSibling;
		wdform_column_next.appendChild(wdform_row);
	
	}
	else
	{
	    var wdform_column_new = document.createElement('div');
			wdform_column_new.setAttribute("class", "wdform_column");
	
	   /*tr_big.appendChild(new_td);*/
	
	    wdform_section.appendChild(wdform_column_new);
	
	    wdform_column_new.appendChild(wdform_row);
	
	    
	}
	//  if(wdform_column.firstChild==null)
  //  wdform_section.removeChild(wdform_column);	

	sortable_columns();
	remove_empty_columns();

	if (document.getElementById("enable_sortable").value == 0) {
		jQuery('.wdform_column').sortable("disable");
  }
}

function left_row(id) {
	wdform_field = document.getElementById("wdform_field" + id);
	wdform_row = wdform_field.parentNode;
	wdform_column=wdform_row.parentNode;
	wdform_section=wdform_column.parentNode;
	if (wdform_column.previousSibling != null) {
		wdform_column_next = wdform_column.previousSibling;
		wdform_column_next.appendChild(wdform_row);
	}
  //  if(wdform_column.firstChild==null)
  //  wdform_section.removeChild(wdform_column);
	sortable_columns();
	remove_empty_columns();
	if (document.getElementById("enable_sortable").value == 0) {
		jQuery('.wdform_column').sortable("disable");
  }
}

function remove_whitespace(node) {
  var ttt;
	for (ttt=0; ttt < node.childNodes.length; ttt++) {
    if (node.childNodes[ttt] && node.childNodes[ttt].nodeType == '3' && !/\S/.test(  node.childNodes[ttt].nodeValue )) {
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


function set_checked(id,j) {
	var checking = document.getElementById(id + "_elementform_id_temp" + j);
	if(checking.checked)
		checking.setAttribute("checked", "checked");
	if(!checking.checked) {
		checking.removeAttribute("checked");
		if(checking.getAttribute('other'))
			if(checking.getAttribute('other')==1) {
				if(document.getElementById(id+"_other_inputform_id_temp")) {
					document.getElementById(id+"_other_inputform_id_temp").parentNode.removeChild(document.getElementById(id+"_other_brform_id_temp"));
					document.getElementById(id+"_other_inputform_id_temp").parentNode.removeChild(document.getElementById(id+"_other_inputform_id_temp"));
				}
				return false;
			}
	}
	return true;
}

function set_default(id, j) {
	for(k=0; k<100; k++)
		if(document.getElementById(id+"_elementform_id_temp"+k))
			if(!document.getElementById(id+"_elementform_id_temp"+k).checked)
				document.getElementById(id+"_elementform_id_temp"+k).removeAttribute("checked");
			else
				document.getElementById(id+"_elementform_id_temp"+j).setAttribute("checked", "checked");
	
	if(document.getElementById(id+"_other_inputform_id_temp"))
	{
		document.getElementById(id+"_other_inputform_id_temp").parentNode.removeChild(document.getElementById(id+"_other_brform_id_temp"));
		document.getElementById(id+"_other_inputform_id_temp").parentNode.removeChild(document.getElementById(id+"_other_inputform_id_temp"));
	}
}

function set_select(select_)
{
	for (p = select_.length - 1; p>=0; p--) 
	    if (select_.options[p].selected) 
		select_.options[p].setAttribute("selected", "selected");
	    else
  		select_.options[p].removeAttribute("selected");
}

function label_top(num)
{	
	document.getElementById(num+'_label_sectionform_id_temp').style.display="block";
	document.getElementById(num+'_element_sectionform_id_temp').style.display="block";
}

function label_left(num)
{
	document.getElementById(num+'_label_sectionform_id_temp').style.display="table-cell";
	document.getElementById(num+'_element_sectionform_id_temp').style.display="table-cell";
}

function delete_value(id)
{
	ofontStyle=document.getElementById(id).className;
	if(ofontStyle=="input_deactive")
	{
		document.getElementById(id).value="";
		destroyChildren(document.getElementById(id));
		document.getElementById(id).setAttribute("class", "input_active");
		document.getElementById(id).className='input_active';
	}
}


function return_value(id)
{
	input=document.getElementById(id);
	if(input.value=="")
	{
		input.value=input.title;
		input.className='input_deactive';
		input.setAttribute("class", 'input_deactive');
	}
}

function change_state_input(id,form_id)
{

	if((document.getElementById(id+"_country"+form_id) && document.getElementById(id+"_country"+form_id).value=="United States" && document.getElementById(id+"_disable_fieldsform_id_temp").getAttribute('us_states')=='yes') || (document.getElementById(id+"_disable_fieldsform_id_temp").getAttribute('country')=='yes' && document.getElementById(id+"_disable_fieldsform_id_temp").getAttribute('us_states')=='yes'))
	{	

		state_input=document.getElementById(id+"_state"+form_id);
		
		
		var state = document.createElement('select');
			state.setAttribute("type", 'text');
			state.style.cssText = "width: 100%; box-sizing: content-box;";
			state.setAttribute("id", id+"_state"+form_id);
			state.setAttribute("name", (parseInt(id)+3)+"_state"+form_id);
			state.setAttribute("onChange", "change_value('"+id+"_state"+form_id+"')");

	
		
		var option_ = document.createElement('option');
			option_.setAttribute("value", "");
			option_.innerHTML="";
		state.appendChild(option_);
		
		states=[fmc_objectL10n.fmc_Alabama,fmc_objectL10n.fmc_Alaska,fmc_objectL10n. fmc_Arizona,fmc_objectL10n.fmc_Arkansas,fmc_objectL10n.fmc_California,fmc_objectL10n.fmc_Colorado,fmc_objectL10n.fmc_Connecticut,fmc_objectL10n.fmc_Delaware,fmc_objectL10n.fmc_DistrictOfColumbia,fmc_objectL10n.fmc_Florida,fmc_objectL10n.fmc_Georgia,fmc_objectL10n.fmc_Hawaii,fmc_objectL10n.fmc_Idaho,fmc_objectL10n.fmc_Illinois,fmc_objectL10n.fmc_Indiana,fmc_objectL10n.fmc_Iowa,fmc_objectL10n.fmc_Kansas,fmc_objectL10n.fmc_Kentucky,fmc_objectL10n.fmc_Louisiana,fmc_objectL10n.fmc_Maine,fmc_objectL10n.fmc_Maryland,fmc_objectL10n.fmc_Massachusetts,fmc_objectL10n.fmc_Michigan,fmc_objectL10n.fmc_Minnesota,fmc_objectL10n.fmc_Mississippi,fmc_objectL10n.fmc_Missouri,fmc_objectL10n.fmc_Montana,fmc_objectL10n.fmc_Nebraska,fmc_objectL10n.fmc_Nevada,fmc_objectL10n.fmc_NewHampshire,fmc_objectL10n.fmc_NewJersey,fmc_objectL10n.fmc_NewMexico,fmc_objectL10n.fmc_NewYork,fmc_objectL10n.fmc_NorthCarolina,fmc_objectL10n.fmc_NorthDakota,fmc_objectL10n.fmc_Ohio,fmc_objectL10n.fmc_Oklahoma,fmc_objectL10n.fmc_Oregon,fmc_objectL10n.fmc_Pennsylvania,fmc_objectL10n.fmc_RhodeIsland,fmc_objectL10n.fmc_SouthCarolina,fmc_objectL10n.fmc_SouthDakota,fmc_objectL10n.fmc_Tennessee,fmc_objectL10n.fmc_Texas,fmc_objectL10n.fmc_Utah,fmc_objectL10n.fmc_Vermont,fmc_objectL10n.fmc_Virginia,fmc_objectL10n.fmc_Washington,fmc_objectL10n.fmc_WestVirginia,fmc_objectL10n.fmc_Wisconsin,fmc_objectL10n.fmc_Wyoming];	
		for(r=0;r<states.length;r++)
		{
		var option_ = document.createElement('option');
			option_.setAttribute("value", states[r]);
			option_.innerHTML=states[r];
		state.appendChild(option_);
		}
		
		var state_input_parent = state_input.parentNode;
		state_input_parent.removeChild(state_input);
		state_input_parent.insertBefore(state,state_input_parent.firstChild);

	}
	else
	{

		if(document.getElementById(id+"_state"+form_id).tagName=='SELECT')
		{
				
				var state_input = document.createElement('input');
					state_input.setAttribute("type", 'text');
					state_input.style.cssText = "width: 100%; box-sizing: content-box;";
					state_input.setAttribute("id", id+"_state"+form_id);
					state_input.setAttribute("name", (parseInt(id)+3)+"_state"+form_id);
					state_input.setAttribute("onChange", "change_value('"+id+"_state"+form_id+"')");
									
					
					state = document.getElementById(id+"_state"+form_id);
					
					var state_parent = state.parentNode;
						state_parent.removeChild(state);
						state_parent.insertBefore(state_input,state_parent.firstChild);
					
		}
	
	}


}

function change_value(id)
{
	input=document.getElementById(id);
	 
	tag=input.tagName;
	if(tag=="TEXTAREA")
	{
/* destroyChildren(input)*/
	input.innerHTML=input.value;
	}
	else
	input.setAttribute("value", input.value);

}

function change_input_value(first_value, id)
{	
	input=document.getElementById(id);
	input.title=first_value;
	
if( window.getComputedStyle ) 
{
  ofontStyle = window.getComputedStyle(input,null).fontStyle;
} else if( input.currentStyle ) {
  ofontStyle = input.currentStyle.fontStyle;
}
	if(ofontStyle=="italic")
	{	
		input.value=first_value;
		input.setAttribute("value", first_value);
	}
}

function disable_form_field(id) {
	var wdform_field = document.getElementById('wdform_field'+id);
	if(id==28 && !document.getElementById( "disable_field29").parentNode.getAttribute("disabled"))
	{
		document.getElementById( "disable_field29").checked = false;
		document.getElementById( "disable_field29").parentNode.setAttribute("disabled","yes");
		document.getElementById( "disable_field29").parentNode.style.cssText = 'opacity:0.4;';
	}
	else
	{
		if(id==29 && !document.getElementById( "wdform_field28").parentNode.getAttribute("disabled"))
		{
			document.getElementById( "wdform_field28").checked = false;
			document.getElementById( "wdform_field28").parentNode.setAttribute("disabled","yes");
			document.getElementById( "wdform_field28").parentNode.style.cssText = 'opacity:0.4;';
		}
	}
	
	if(document.getElementById('edit_for_disable').checked==false)
	{
		wdform_field.parentNode.setAttribute('disabled','yes');
		if(wdform_field.getAttribute("type")!='type_section_break')
			wdform_field.style.cssText = 'display:table-cell;';

		document.getElementById("disable_field"+id).checked=false;
		wdform_field.parentNode.style.cssText = 'opacity:0.4;';	
	}
	else
	{
		document.getElementById("disable_field"+id).checked=true;
		wdform_field.parentNode.removeAttribute('disabled');
		wdform_field.parentNode.style.cssText = 'opacity:1;';
	}
}



function close_window() {
  if (need_enable) {
    enable();
  }
	need_enable = true;
  document.getElementById('edit_table').innerHTML = "";
  document.getElementById('show_table').innerHTML = "";
  document.getElementById('main_editor').style.display = "none";
  if (document.getElementById("form_maker_editor_ifr")) {
    ifr_id = "form_maker_editor_ifr";
    ifr = getIFrameDocument(ifr_id);
    ifr.body.innerHTML = "";
  }
  document.getElementById('form_maker_editor').value = "";
  document.getElementById('editing_id').value = "";
  document.getElementById('element_type').value = "";
}

function change_label(id, label) {
  label = label.replace(/(<([^>]+)>)/ig, "");
	document.getElementById(id).innerHTML = label;
	document.getElementById(id).value = label;
}

function change_in_value(id, label) {
  label = label.replace(/(<([^>]+)>)/ig, "");
  label = label.replace(/"/g, "&quot;");
	document.getElementById(id).setAttribute("value", label);
}

function add_choise(type, num) {
	j++;
	if (type == 'radio' || type == 'checkbox') {
		var choices_td= document.getElementById('choices');
		var br = document.createElement('br');
		br.setAttribute("id", "br"+j);
		var el_choices = document.createElement('input');
		el_choices.setAttribute("id", "el_choices"+j);
		el_choices.setAttribute("type", "text");
		el_choices.setAttribute("value", "");
		el_choices.style.cssText =   "width:100px; margin:0; padding:0; border-width: 1px";
		el_choices.setAttribute("onKeyUp", "change_label('"+num+"_label_element"+j+"', this.value); change_in_value('"+num+"_elementform_id_temp"+j+"', this.value)");
	
		var el_choices_remove = document.createElement('img');
			el_choices_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_choices_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_choices_remove.style.cssText =  'cursor:pointer;vertical-align:middle; margin:3px';
			el_choices_remove.setAttribute("align", 'top');
			el_choices_remove.setAttribute("onClick", "remove_choise('"+j+"','"+num+"','"+type+"')");
	
	    choices_td.appendChild(br);
	    choices_td.appendChild(el_choices);
	    choices_td.appendChild(el_choices_remove);
		
		
		
		refresh_rowcol(num, type);
		
		
		if(type=='checkbox')
		{	
			refresh_attr(num, 'type_checkbox');
		}
			
		if(type=='radio')
		{
			refresh_attr(num, 'type_radio');
		}
		
    
	
	
	}
	
	if(type=='select')
	{
		var select_ = document.getElementById(num+'_elementform_id_temp');
		var option = document.createElement('option');
			option.setAttribute("id", num+"_option"+j);
			
		    select_.appendChild(option);
		
		var choices_td= document.getElementById('choices');
		var br = document.createElement('br');
		br.setAttribute("id", "br"+j);
		var el_choices = document.createElement('input');
			el_choices.setAttribute("id", "el_option"+j);
			el_choices.setAttribute("type", "text");
			el_choices.setAttribute("value", "");
			el_choices.style.cssText =   "width:100px; margin:0; padding:0; border-width: 1px";
			el_choices.setAttribute("onKeyUp", "change_label('"+num+"_option"+j+"', this.value)");
			
		var el_choices_remove = document.createElement('img');
			el_choices_remove.setAttribute("id", "el_option"+j+"_remove");
			el_choices_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_choices_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			el_choices_remove.setAttribute("align", 'top');
			el_choices_remove.setAttribute("onClick", "remove_option('"+j+"','"+num+"')");
			
		var el_choices_dis = document.createElement('input');
			el_choices_dis.setAttribute("type", 'checkbox');
			el_choices_dis.setAttribute("id", "el_option"+j+"_dis");
			el_choices_dis.setAttribute("onClick", "dis_option('"+num+"_option"+j+"', this.checked)");	
			el_choices_dis.style.cssText ="vertical-align: middle; margin-left:24px; margin-right:24px;";
	    choices_td.appendChild(br);
	    choices_td.appendChild(el_choices);
	    choices_td.appendChild(el_choices_dis);
	    choices_td.appendChild(el_choices_remove);
    }


}

function refresh_rowcol(num, type)
{
	if(document.getElementById('edit_for_rowcol').value)
	{
		document.getElementById(num+'_rowcol_numform_id_temp').value = document.getElementById('edit_for_rowcol').value;

		var table = document.getElementById(num+'_table_little');
			table.removeAttribute("for_hor");
			table.innerHTML="";
			
		var choeices=0;

		if(document.getElementById('edit_for_flow_vertical').checked==true)
		{
			var columns = document.getElementById('edit_for_rowcol').value;

			for(i=0;i<=100;i++)	
			{
				if(document.getElementById('el_choices'+i))
				choeices++;
			} 

			element='input';
			rows = parseInt((choeices+1)/columns);
			
			var gago=0;
				var vaxo=1;
				
				var tr_row = document.createElement('div');
					tr_row.setAttribute("id", num+"_element_tr0");
					tr_row.style.display = 'table-row';
				for(i=0;i<=100;i++)	
				{
					if(document.getElementById('el_choices'+i))
					{
				
										
						if(gago >= columns)
						{  
								gago=0;
								
								var tr_row = document.createElement('div');
									tr_row.setAttribute("id", num+"_element_tr"+vaxo);
									tr_row.style.display = 'table-row';								
								
								vaxo++;
						}								
									
								var td = document.createElement('div');
									td.setAttribute("valign", "top");
									td.setAttribute("id", num+"_td_little"+i);
									td.setAttribute("idi", i);
									td.style.display = 'table-cell';	
								
								
								var adding = document.createElement(element);
								adding.setAttribute("type", type);
								adding.setAttribute("value", document.getElementById("el_choices"+i).value);
								if(document.getElementById("el_choices"+i).getAttribute("checked")=="true")
									adding.setAttribute("checked", "checked");									
								adding.setAttribute("id", num+"_elementform_id_temp"+i);
								if(type=='checkbox')
								{
									if(document.getElementById(num+"_allow_otherform_id_temp").value=="yes" && document.getElementById("el_choices"+i).getAttribute('other')=='1')
									{
										adding.setAttribute("other", "1");
										adding.setAttribute("onclick", "if(set_checked('"+num+"','"+i+"','form_id_temp')) show_other_input('"+num+"','form_id_temp');");
									}
									else
										adding.setAttribute("onclick", "set_checked('"+num+"','"+i+"','form_id_temp')");
			
										adding.setAttribute("name", num+"_elementform_id_temp"+i);
								}
									
								if(type=='radio')
								{
								adding.setAttribute("name", num+"_elementform_id_temp");
									if(document.getElementById(num+"_allow_otherform_id_temp").value=="yes" && document.getElementById("el_choices"+i).getAttribute('other')=='1')
									{
										adding.setAttribute("other", "1");
										adding.setAttribute("onClick", "set_default('"+num+"','"+i+"','form_id_temp'); show_other_input('"+num+"','form_id_temp');");
									}
									else
									adding.setAttribute("onClick", "set_default('"+num+"','"+i+"','form_id_temp')");
								}
								
								var label_adding = document.createElement('label');
									label_adding.setAttribute("id", num+"_label_element"+i);
									label_adding.setAttribute("class", "ch-rad-label");
									label_adding.setAttribute("for",num+"_elementform_id_temp"+i);
									label_adding.innerHTML=document.getElementById("el_choices"+i).value;
									
									td.appendChild(adding);
									td.appendChild(label_adding);
									
								tr_row.appendChild(td);	
								table.appendChild(tr_row);	
						
						
						gago++;
						
				
					}
				

				
				}

				
		}

		else{

				var rows = document.getElementById('edit_for_rowcol').value;

				for(i=0;i<=100;i++)	
				{
					if(document.getElementById('el_choices'+i))
					choeices++;
				} 

				element='input';
				columns = parseInt((choeices+1)/rows);

				
				var gago=0;
				var vaxo=0;
				for(i=0;i<=100;i++)	
				{
					if(document.getElementById('el_choices'+i))
					{
				
						if(gago < rows)
						{
							var tr_row = document.createElement('div');
								tr_row.setAttribute("id", num+"_element_tr"+i);
								tr_row.style.display = 'table-row';
								
						}
						  
								var td = document.createElement('div');
									td.setAttribute("valign", "top");
									td.setAttribute("id", num+"_td_little"+i);
									td.setAttribute("idi", i);
									td.style.display = 'table-cell';
								
								
								var adding = document.createElement(element);
								adding.setAttribute("type", type);
								adding.setAttribute("value", document.getElementById("el_choices"+i).value);
								if(document.getElementById("el_choices"+i).getAttribute("checked")=="true")
									adding.setAttribute("checked", "checked");									
								adding.setAttribute("id", num+"_elementform_id_temp"+i);
								if(type=='checkbox')
								{
									if(document.getElementById(num+"_allow_otherform_id_temp").value=="yes" && document.getElementById("el_choices"+i).getAttribute('other')=='1')
									{
										adding.setAttribute("other", "1");
										adding.setAttribute("onclick", "if(set_checked('"+num+"','"+i+"','form_id_temp')) show_other_input('"+num+"','form_id_temp');");
									}
									else
										adding.setAttribute("onclick", "set_checked('"+num+"','"+i+"','form_id_temp')");
			
										adding.setAttribute("name", num+"_elementform_id_temp"+i);
								}
									
								if(type=='radio')
								{
								adding.setAttribute("name", num+"_elementform_id_temp");
									if(document.getElementById(num+"_allow_otherform_id_temp").value=="yes" && document.getElementById("el_choices"+i).getAttribute('other')=='1')
									{
										adding.setAttribute("other", "1");
										adding.setAttribute("onClick", "set_default('"+num+"','"+i+"','form_id_temp'); show_other_input('"+num+"','form_id_temp')");
										
									}
									else
									adding.setAttribute("onClick", "set_default('"+num+"','"+i+"','form_id_temp')");
								}
								
								var label_adding = document.createElement('label');
									label_adding.setAttribute("id", num+"_label_element"+i);
									label_adding.setAttribute("class", "ch-rad-label");
									label_adding.setAttribute("for",num+"_elementform_id_temp"+i);
									label_adding.innerHTML=document.getElementById("el_choices"+i).value;
									td.appendChild(adding);
									td.appendChild(label_adding);
							
							
								if(gago < rows)
								{
									tr_row.appendChild(td);	
									table.appendChild(tr_row);
								}
								else
								{
									if(vaxo==rows)
									vaxo=0;
									
									tr_row = document.getElementById(num+'_table_little').childNodes[vaxo];
									tr_row.appendChild(td);	
									vaxo++;
								}					
									
								
								gago++;
							
						
						
						
				
					}
				

				
				}
				table.setAttribute("for_hor", num+"_hor");
			}
		}
	else
	{
		document.getElementById(num+'_rowcol_numform_id_temp').value = '';

		var table = document.getElementById(num+'_table_little');
			table.innerHTML="";
		
		var tr0 = document.createElement('div');
			tr0.setAttribute("id", num+"_hor");
			tr0.style.display = 'table-row';
			
			
			for(i=0;i<=100;i++)	
				{
					if(document.getElementById('el_choices'+i))
					{
			
						element='input';
		
				if(document.getElementById('edit_for_flow_vertical').checked==true)
				{
				var tr = document.createElement('div');
					tr.setAttribute("id", num+"_element_tr"+i);
					tr.style.display = 'table-row';
				var td = document.createElement('div');
					td.setAttribute("valign", "top");
					td.setAttribute("id", num+"_td_little"+i);
					td.setAttribute("idi", i);
					td.style.display = 'table-cell';
				
				var adding = document.createElement(element);
					adding.setAttribute("type", type);
					adding.setAttribute("value", document.getElementById("el_choices"+i).value);
								if(document.getElementById("el_choices"+i).getAttribute("checked")=="true")
									adding.setAttribute("checked", "checked");									
					adding.setAttribute("id", num+"_elementform_id_temp"+i);
									if(type=='checkbox')
									{
										if(document.getElementById(num+"_allow_otherform_id_temp").value=="yes" && document.getElementById("el_choices"+i).getAttribute('other')=='1')
										{
											adding.setAttribute("other", "1");
											adding.setAttribute("onclick", "if(set_checked('"+num+"','"+i+"','form_id_temp')) show_other_input('"+num+"','form_id_temp');");
										}
										else
											adding.setAttribute("onclick", "set_checked('"+num+"','"+i+"','form_id_temp')");
				
											adding.setAttribute("name", num+"_elementform_id_temp"+i);
									}
										
									if(type=='radio')
									{
										adding.setAttribute("name", num+"_elementform_id_temp");
									
										if(document.getElementById(num+"_allow_otherform_id_temp").value=="yes" && document.getElementById("el_choices"+i).getAttribute('other')=='1')
										{
											adding.setAttribute("other", "1");
											adding.setAttribute("onClick", "set_default('"+num+"','"+i+"','form_id_temp'); show_other_input('"+num+"','form_id_temp')");
											
										}
										else
										adding.setAttribute("onClick", "set_default('"+num+"','"+i+"','form_id_temp')");
									}
				
				
				var label_adding = document.createElement('label');
					label_adding.setAttribute("id", num+"_label_element"+i);
					label_adding.setAttribute("class", "ch-rad-label");
					label_adding.setAttribute("for",num+"_elementform_id_temp"+i);
					label_adding.innerHTML=document.getElementById("el_choices"+i).value;
					td.appendChild(adding);
					td.appendChild(label_adding);
					tr.appendChild(td);
					table.appendChild(tr);
					}
					
				else
				{
					var td = document.createElement('div');
						td.setAttribute("valign", "top");
						td.setAttribute("id", num+"_td_little"+i);
						td.setAttribute("idi", i);
						td.style.display = 'table-cell';
					
					var adding = document.createElement(element);
						adding.setAttribute("type", type);
						adding.setAttribute("value", document.getElementById("el_choices"+i).value);
						adding.setAttribute("id", num+"_elementform_id_temp"+i);
								if(document.getElementById("el_choices"+i).getAttribute("checked")=="true")
									adding.setAttribute("checked", "checked");									
					
								if(type=='checkbox')
									{
										if(document.getElementById(num+"_allow_otherform_id_temp").value=="yes" && document.getElementById("el_choices"+i).getAttribute('other')=='1')
										{
											adding.setAttribute("other", "1");
											adding.setAttribute("onclick", "if(set_checked('"+num+"','"+i+"','form_id_temp')) show_other_input('"+num+"','form_id_temp');");
										}
										else
											adding.setAttribute("onclick", "set_checked('"+num+"','"+i+"','form_id_temp')");
				
											adding.setAttribute("name", num+"_elementform_id_temp"+i);
									}
										
									if(type=='radio')
									{
									adding.setAttribute("name", num+"_elementform_id_temp");
										if(document.getElementById(num+"_allow_otherform_id_temp").value=="yes" && document.getElementById("el_choices"+i).getAttribute('other')=='1')
										{
											adding.setAttribute("other", "1");
											adding.setAttribute("onClick", "set_default('"+num+"','"+i+"','form_id_temp'); show_other_input('"+num+"','form_id_temp')");	
										}
										else
										adding.setAttribute("onClick", "set_default('"+num+"','"+i+"','form_id_temp')");
									}
					
					
					var label_adding = document.createElement('label');
						label_adding.setAttribute("id", num+"_label_element"+i);
						label_adding.setAttribute("class", "ch-rad-label");
						label_adding.setAttribute("for",num+"_elementform_id_temp"+i);
						label_adding.innerHTML=document.getElementById("el_choices"+i).value;
						
						td.appendChild(adding);
						td.appendChild(label_adding);
						tr0.appendChild(td);
						table.appendChild(tr0);
					
				
				}
					
				
				}
			}
			
						
	}
}



function remove_choise(id, num, type)
{

	var choices_td= document.getElementById('choices');
		var el_choices = document.getElementById('el_choices'+id);
		var el_choices_remove = document.getElementById('el_choices'+id+'_remove');
		var br = document.getElementById('br'+id);
		
		choices_td.removeChild(el_choices);
		choices_td.removeChild(el_choices_remove);
		choices_td.removeChild(br);
		

refresh_rowcol(num,type);
}


function remove_option(id, num)
{
		var select_ = document.getElementById(num+'_elementform_id_temp');
		var option = document.getElementById(num+'_option'+id);
			
		select_.removeChild(option);
		
		var choices_td= document.getElementById('choices');
		var el_choices = document.getElementById('el_option'+id);
		var el_choices_dis = document.getElementById('el_option'+id+'_dis');
		var el_choices_remove = document.getElementById('el_option'+id+'_remove');
		var br = document.getElementById('br'+id);
		
		choices_td.removeChild(el_choices);
		choices_td.removeChild(el_choices_dis);
		choices_td.removeChild(el_choices_remove);
		choices_td.removeChild(br);
}

function getIFrameDocument(aID) { 
  var rv = null; 
  if (document.getElementById(aID) && document.getElementById(aID).contentDocument){ 
    /* if contentDocument exists, W3C compliant (Mozilla) */
    rv = document.getElementById(aID).contentDocument; 
  }
  else if (document.getElementById(aID)) {
    /* IE */
    rv = document.frames[aID].document; 
  } 
  return rv;
}

function delete_last_child() {
  if (document.getElementById("form_maker_editor_ifr")) {
    ifr_id = "form_maker_editor_ifr";
    ifr = getIFrameDocument(ifr_id);
    ifr.body.innerHTML = "";
  }
	document.getElementById('main_editor').style.display = "none";
	document.getElementById('form_maker_editor').value = "";
	if (document.getElementById('show_table').lastChild) {
		var del1 = document.getElementById('show_table').lastChild;
		var del2 = document.getElementById('edit_table').lastChild;
		var main1 = document.getElementById('show_table');
		var main2 = document.getElementById('edit_table');
		main1.removeChild(del1);
		main2.removeChild(del2);
	}
}

function format_extended(num,w_title_value,w_middle_value,w_title_title,w_middle_title) {
	w_size=document.getElementById(num+'_element_firstform_id_temp').style.width;
    	tr_name1 = document.getElementById(num+'_tr_name1');
    	tr_name2 = document.getElementById(num+'_tr_name2');
	
   	var td_name_input1 = document.createElement('div');
        	td_name_input1.setAttribute("id", num+"_td_name_input_title");
			td_name_input1.style.display='table-cell';
		
   	var td_name_input4 = document.createElement('div');
        	td_name_input4.setAttribute("id", num+"_td_name_input_middle");
			td_name_input4.style.display='table-cell';
		
   	var td_name_label1 = document.createElement('div');
        	td_name_label1.setAttribute("id", num+"_td_name_label_title");
        	td_name_label1.setAttribute("align", "left");
			td_name_label1.style.display='table-cell';
		
   	var td_name_label4 = document.createElement('div');
        	td_name_label4.setAttribute("id", num+"_td_name_label_middle");
        	td_name_label4.setAttribute("align", "left");
			td_name_label4.style.display='table-cell';
		
	var title = document.createElement('input');
        title.setAttribute("type", 'text');
		
		
		
	    title.style.cssText = "margin: 0px 10px 0px 0px; padding: 0px; width:40px";
	    title.setAttribute("id", num+"_element_titleform_id_temp");
	    title.setAttribute("name", num+"_element_titleform_id_temp");
		if(w_title_value==w_title_title)
		{
		title.setAttribute("value", w_title_title);
		title.setAttribute("class", "input_deactive");
		}
		else
		{
		title.setAttribute("value", w_title_value);
		title.setAttribute("class", "input_active");
		}
		title.setAttribute("title", w_title_title);
		title.setAttribute("onFocus", 'delete_value("'+num+'_element_titleform_id_temp")');
		title.setAttribute("onBlur", 'return_value("'+num+'_element_titleform_id_temp")');
	    title.setAttribute("onChange", "change_value('"+num+"_element_titleform_id_temp')");
		
	var title_label = document.createElement('label');
	    title_label.setAttribute("class", "mini_label");
	    title_label.setAttribute("id", num+"_mini_label_title");
	    title_label.innerHTML= w_mini_labels[0];
		
	var middle = document.createElement('input');
		middle.setAttribute("type", 'text');
		middle.style.cssText = "padding: 0px; width:"+w_size;
		middle.setAttribute("id", num+"_element_middleform_id_temp");
		middle.setAttribute("name", num+"_element_middleform_id_temp");
		if(w_middle_value==w_middle_title)
		{
		middle.setAttribute("value", w_middle_title);
		middle.setAttribute("class", "input_deactive");
		}
		else
		{
		middle.setAttribute("value", w_middle_value);
		middle.setAttribute("class", "input_active");
		}
		middle.setAttribute("title", w_middle_title);
		middle.setAttribute("onFocus", 'delete_value("'+num+'_element_middleform_id_temp")');
		middle.setAttribute("onBlur", 'return_value("'+num+'_element_middleform_id_temp")');
	    middle.setAttribute("onChange", "change_value('"+num+"_element_middleform_id_temp')");
			
	var middle_label = document.createElement('label');
		middle_label.setAttribute("class", "mini_label");
		middle_label.setAttribute("id", num+"_mini_label_middle");
		middle_label.innerHTML=w_mini_labels[3];
		
    	first_input = document.getElementById(num+'_td_name_input_first');
    	last_input = document.getElementById(num+'_td_name_input_last');
    	first_label = document.getElementById(num+'_td_name_label_first');
    	last_label = document.getElementById(num+'_td_name_label_last');
	
      	td_name_input1.appendChild(title);
      	td_name_input4.appendChild(middle);
		
		tr_name1.insertBefore(td_name_input1, first_input);
		tr_name1.insertBefore(td_name_input4, null);
		
      	td_name_label1.appendChild(title_label);
      	td_name_label4.appendChild(middle_label);
		tr_name2.insertBefore(td_name_label1, first_label);
		tr_name2.insertBefore(td_name_label4, null);
		
	var gic1 = document.createTextNode("-");
	var gic2 = document.createTextNode("-");

	var el_first_value_title = document.createElement('input');
                el_first_value_title.setAttribute("id", "el_first_value_title");
                el_first_value_title.setAttribute("type", "text");
                el_first_value_title.setAttribute("value", w_title_title);
                el_first_value_title.style.cssText = "width:50px; margin-left:4px; margin-right:4px";
                el_first_value_title.setAttribute("onKeyUp", "change_input_value(this.value,'"+num+"_element_titleform_id_temp')");

	var el_first_value_middle = document.createElement('input');
                el_first_value_middle.setAttribute("id", "el_first_value_middle");
                el_first_value_middle.setAttribute("type", "text");
                el_first_value_middle.setAttribute("value", w_middle_title);
                el_first_value_middle.style.cssText = "width:100px; margin-left:4px";
                el_first_value_middle.setAttribute("onKeyUp", "change_input_value(this.value,'"+num+"_element_middleform_id_temp')");
				
    el_first_value_first = document.getElementById('el_first_value_first');
	parent=el_first_value_first.parentNode;
	parent.insertBefore(gic1, el_first_value_first);
	parent.insertBefore(el_first_value_title, gic1);
    parent.appendChild(gic2);
    parent.appendChild(el_first_value_middle);
		
refresh_attr(num, 'type_name');


jQuery(document).ready(function() {	
	jQuery("label#"+num+"_mini_label_title").click(function() {		
		if (jQuery(this).children('input').length == 0) {				
			var title = "<input type='text' class='title' size='10' style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";	
				jQuery(this).html(title);							
				jQuery("input.title").focus();			
				jQuery("input.title").blur(function() {	
			var value = jQuery(this).val();			


		jQuery("#"+num+"_mini_label_title").text(value);		
		});	
	}	
	});		


	jQuery("label#"+num+"_mini_label_middle").click(function() {	
	if (jQuery(this).children('input').length == 0) {		
		var middle = "<input type='text' class='middle'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";	
			jQuery(this).html(middle);			
			jQuery("input.middle").focus();					
			jQuery("input.middle").blur(function() {			
			var value = jQuery(this).val();			
			
			jQuery("#"+num+"_mini_label_middle").text(value);	
		});	
	}	
	});
	});	


}

function format_normal(num)
{
    	tr_name1 = document.getElementById(num+'_tr_name1');
    	tr_name2 = document.getElementById(num+'_tr_name2');
   	 	td_name_input1 = document.getElementById(num+'_td_name_input_title');
		
   		td_name_input4 = document.getElementById(num+'_td_name_input_middle');
		
   		td_name_label1 = document.getElementById(num+'_td_name_label_title');
		
   	 	td_name_label4 =document.getElementById(num+'_td_name_label_middle');
		
		tr_name1.removeChild(td_name_input1);
		tr_name1.removeChild(td_name_input4);
		tr_name2.removeChild(td_name_label1);
		tr_name2.removeChild(td_name_label4);
		
		el_first_value_first = document.getElementById('el_first_value_first');
		parent=el_first_value_first.parentNode;
		
		parent.removeChild( document.getElementById('el_first_value_title').nextSibling);
		parent.removeChild( document.getElementById('el_first_value_title'));
		parent.removeChild( document.getElementById('el_first_value_middle').previousSibling);
		parent.removeChild( document.getElementById('el_first_value_middle'));
refresh_attr(num, 'type_name');


}


function type_section_break(i, w_editor){
	
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		edit_main_table.style.cssText= "margin-left:23px";

	var edit_main_tr1  = document.createElement('tr');
	
	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
	
	
	
	document.getElementById("element_type").value="type_section_break";
	delete_last_child();
/* edit table	*/
	oElement=document.getElementById('table_editor');
	var iReturnTop = 0;
	var iReturnLeft = 0;
	while( oElement != null ) 
	{
	iReturnTop += oElement.offsetTop;
	iReturnLeft += oElement.offsetLeft;
	oElement = oElement.offsetParent;
	}
	
		document.getElementById('main_editor').style.display="block";
		document.getElementById('main_editor').style.left=iReturnLeft+30+"px";
		document.getElementById('main_editor').style.top=iReturnTop+45+"px";
    if (document.getElementById("form_maker_editor_ifr") && document.getElementById('form_maker_editor').style.display == "none") {
      ifr_id = "form_maker_editor_ifr";
      ifr = getIFrameDocument(ifr_id);
      ifr.body.innerHTML = w_editor;
    }
    else {
      document.getElementById('form_maker_editor').value = w_editor;
    }
		element = 'div';
		edit_main_td1.appendChild(el_label_disable);
		edit_main_td1_1.appendChild(el_input_disable);
		
		edit_main_tr1.appendChild(edit_main_td1);
		edit_main_tr1.appendChild(edit_main_td1_1);
	
		edit_main_table.appendChild(edit_main_tr1);
		
		
		
     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");		
      	var main_td  = document.getElementById('show_table');
      	main_td.appendChild(div);
		
     	var div = document.createElement('div');
      	    div.style.width="500px";		

		div.appendChild(edit_main_table);	
		document.getElementById('edit_table').appendChild(div);				
}

function type_editor(i, w_editor){

	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		edit_main_table.style.cssText= "margin-left:23px";

	var edit_main_tr1  = document.createElement('tr');
	
	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
	
	
    document.getElementById("element_type").value="type_editor";
	delete_last_child();
	
	oElement=document.getElementById('table_editor');
	var iReturnTop = 0;
	var iReturnLeft = 0;
	while( oElement != null ) 
	{
	iReturnTop += oElement.offsetTop;
	iReturnLeft += oElement.offsetLeft;
	oElement = oElement.offsetParent;
	}
	
		document.getElementById('main_editor').style.display="block";
		document.getElementById('main_editor').style.left=iReturnLeft+30+"px";
		document.getElementById('main_editor').style.top=iReturnTop+45+"px";

    if (document.getElementById("form_maker_editor_ifr") && document.getElementById('form_maker_editor').style.display == "none") {
      ifr_id = "form_maker_editor_ifr";
			ifr = getIFrameDocument(ifr_id);
			ifr.body.innerHTML = w_editor;
		}
		else {
			document.getElementById('form_maker_editor').value = w_editor;
		}
		element='div';
		edit_main_td1.appendChild(el_label_disable);
		edit_main_td1_1.appendChild(el_input_disable);
		
		edit_main_tr1.appendChild(edit_main_td1);
		edit_main_tr1.appendChild(edit_main_td1_1);
	
		edit_main_table.appendChild(edit_main_tr1);
		
		
     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");		
      	var main_td  = document.getElementById('show_table');
		
      	main_td.appendChild(div);
		
     	var div = document.createElement('div');
      	    div.style.width="500px";	

		div.appendChild(edit_main_table);		
		document.getElementById('edit_table').appendChild(div);
		
		
}

function type_submit_reset(i, w_submit_title , w_reset_title , w_class, w_act, w_attr_name, w_attr_value){

    document.getElementById("element_type").value="type_submit_reset";
    
	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');

	var edit_main_tr7  = document.createElement('tr');

	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var el_submit_title_label = document.createElement('label');
	                el_submit_title_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
			el_submit_title_label.innerHTML = fmc_objectL10n.fmc_Submit_button_label;
	
	var el_submit_title_textarea = document.createElement('input');
                el_submit_title_textarea.setAttribute("id", "edit_for_title");
                el_submit_title_textarea.setAttribute("type", "text");
                el_submit_title_textarea.style.cssText = "width:160px";
                el_submit_title_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_submitform_id_temp', this.value)");
		el_submit_title_textarea.value = w_submit_title;
	var el_submit_func_label = document.createElement('label');
	                el_submit_func_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
			el_submit_func_label.innerHTML = fmc_objectL10n.fmc_Submit_function;
	var el_submit_func_textarea = document.createElement('input');
                el_submit_func_textarea.setAttribute("type", "text");
                el_submit_func_textarea.setAttribute("disabled", "disabled");
                el_submit_func_textarea.style.cssText = "width:160px";
		el_submit_func_textarea.value = "check_required('submit', 'form_id_temp')";

	var el_reset_title_label = document.createElement('label');
	                el_reset_title_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
			el_reset_title_label.innerHTML = fmc_objectL10n.fmc_Reset_button_label;
	
	var el_reset_title_textarea = document.createElement('input');
                el_reset_title_textarea.setAttribute("id", "edit_for_title");
                el_reset_title_textarea.setAttribute("type", "text");
                el_reset_title_textarea.style.cssText = "width:160px";
                el_reset_title_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_resetform_id_temp', this.value)");
		el_reset_title_textarea.value = w_reset_title;
	
	
	var el_reset_active = document.createElement('input');
                el_reset_active.setAttribute("type", "checkbox");
                el_reset_active.style.cssText = "";
				el_reset_active.setAttribute("onClick", "active_reset(this.checked, "+i+")");
	if(w_act)
				el_reset_active.setAttribute("checked", "checked");

				
	var el_reset_active_label = document.createElement('label');
	                el_reset_active_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
					el_reset_active_label.innerHTML = fmc_objectL10n.fmc_Display_reset_button;
	
	
	
	
	var el_reset_func_label = document.createElement('label');
	                el_reset_func_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
			el_reset_func_label.innerHTML = fmc_objectL10n.fmc_Reset_function;
	var el_reset_func_textarea = document.createElement('input');
                el_reset_func_textarea.setAttribute("type", "text");
                el_reset_func_textarea.setAttribute("disabled", "disabled");
                el_reset_func_textarea.style.cssText = "width:160px";
		el_reset_func_textarea.value = "check_required('reset')";

	var el_style_label = document.createElement('label');
	        el_style_label.setAttribute("for", "el_style_textarea");
		el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
                el_style_textarea.setAttribute("id", "el_style_textarea");
		el_style_textarea.setAttribute("type", "text");
		el_style_textarea.setAttribute("value", w_class);
                el_style_textarea.style.cssText = "width:200px;";
                el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");
	var el_attr_label = document.createElement('label');
	                
			el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
	var el_attr_add = document.createElement('img');
                
           	el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
            	el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_submit_reset')");
	var el_attr_table = document.createElement('table');
                el_attr_table.setAttribute("id", 'attributes');
                el_attr_table.setAttribute("border", '0');
        	el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
                el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
            	el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
            	el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
            	el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	                el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
			
	var el_attr_value_label = document.createElement('label');
	                el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
	
			el_attr_name.setAttribute("type", "text");
	
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_submit_reset')");
			
		var el_attr_value = document.createElement('input');
	
			el_attr_value.setAttribute("type", "text");
	
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_submit_reset')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_submit_reset')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}

	var t  = document.getElementById('edit_table');
	
	var hr = document.createElement('hr');
	var br = document.createElement('br');
	var br1 = document.createElement('br');
	var br2 = document.createElement('br');
	var br3 = document.createElement('br');
	var br4 = document.createElement('br');
	var br5 = document.createElement('br');
	var br6 = document.createElement('br');
	var br7 = document.createElement('br');
	var br8 = document.createElement('br');
	var br9 = document.createElement('br');
	edit_main_td1.appendChild(el_submit_title_label);
	edit_main_td1.appendChild(br7);
	edit_main_td1.appendChild(el_submit_func_label);
	edit_main_td1_1.appendChild(el_submit_title_textarea);
	edit_main_td1_1.appendChild(br1);
	edit_main_td1_1.appendChild(el_submit_func_textarea);
	
	
	edit_main_td2.appendChild(el_reset_active_label);
	edit_main_td2.appendChild(br5);
	edit_main_td2.appendChild(el_reset_title_label);
	edit_main_td2.appendChild(br8);
	edit_main_td2.appendChild(el_reset_func_label);
	edit_main_td2_1.appendChild(el_reset_active);
	edit_main_td2_1.appendChild(br9);
	edit_main_td2_1.appendChild(el_reset_title_textarea);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_reset_func_textarea);

	edit_main_td3.appendChild(el_style_label);
	edit_main_td3_1.appendChild(el_style_textarea);
	
	edit_main_td4.appendChild(el_attr_label);
	edit_main_td4.appendChild(el_attr_add);
	edit_main_td4.appendChild(br3);
	edit_main_td4.appendChild(el_attr_table);
	edit_main_td4.setAttribute("colspan", "2");

	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr6.appendChild(edit_main_td6_1);

	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr4);
/*	edit_main_table.appendChild(edit_main_tr5);
  	edit_main_table.appendChild(edit_main_tr6);*/
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);
	
/*show table*/

	element='button';	type1='button';   	type2='button'; 
	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_submit_reset");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
	    
	var adding_submit = document.createElement(element);
		    adding_submit.setAttribute("type", type1);
		
			adding_submit.setAttribute("class", "button-submit");
			
			adding_submit.setAttribute("id", i+"_element_submitform_id_temp");
			adding_submit.setAttribute("value", w_submit_title);
			adding_submit.innerHTML=w_submit_title;
			adding_submit.setAttribute("onClick", "check_required('submit', 'form_id_temp');");

	var adding_reset = document.createElement(element);
		    adding_reset.setAttribute("type", type2);
		
			adding_reset.setAttribute("class", "button-reset");
			if(!w_act)
				adding_reset.style.display="none";
				
			adding_reset.setAttribute("id", i+"_element_resetform_id_temp");
			adding_reset.setAttribute("value", w_reset_title );
			adding_reset.setAttribute("onClick", "check_required('reset');");
			adding_reset.innerHTML=w_reset_title;

     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
					
      	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");
			
      	var br1 = document.createElement('br');
      	var br2 = document.createElement('br');
     	var br3 = document.createElement('br');
      	var br4 = document.createElement('br');
      

	    
      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.style.cssText = 'display:none';
			label.innerHTML = "type_submit_reset_"+i;
      	var main_td  = document.getElementById('show_table');
      
      	div_label.appendChild(label);
      	div_element.appendChild(adding_type);
      	div_element.appendChild(adding_submit);
      	div_element.appendChild(adding_reset);
	
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
 
      
      	div.appendChild(div_field);
      	div.appendChild(br3);
      	main_td.appendChild(div);
change_class(w_class, i);
refresh_attr(i, 'type_submit_reset');
}

function type_send_copy(i, w_field_label, w_field_label_size, w_field_label_pos, w_first_val, w_required, w_attr_name, w_attr_value) {

    document.getElementById("element_type").value="type_send_copy";
	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");

	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
	var edit_main_tr7  = document.createElement('tr');
	var edit_main_tr8  = document.createElement('tr');
	var edit_main_tr9  = document.createElement('tr');
	var edit_main_tr10  = document.createElement('tr');
	var edit_main_tr11  = document.createElement('tr');

	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');

	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
		
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
		
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');
		  
	var edit_main_td9 = document.createElement('td');
	var edit_main_td9_1 = document.createElement('td');

	var edit_main_td10 = document.createElement('td');
	var edit_main_td10_1 = document.createElement('td');
	var edit_main_td11 = document.createElement('td');
	var edit_main_td11_1 = document.createElement('td');
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
		
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
	
	var el_label_label = document.createElement('label');
	    el_label_label.setAttribute("for", "edit_for_label");
		el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
        el_label_textarea.setAttribute("id", "edit_for_label");
        el_label_textarea.setAttribute("rows", "4");
        el_label_textarea.style.cssText = "width:200px";
        el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
		el_label_textarea.innerHTML = w_field_label;
		
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
		
	var el_label_position_label = document.createElement('label');
		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
        el_label_position1.setAttribute("id", "edit_for_label_position_top");
        el_label_position1.setAttribute("type", "radio");
		el_label_position1.setAttribute("name", "edit_for_label_position");
        el_label_position1.setAttribute("onchange", "label_left("+i+")");
	Left = document.createTextNode(fmc_objectL10n.fmc_Left);

	var el_label_position2 = document.createElement('input');
        el_label_position2.setAttribute("id", "edit_for_label_position_left");
        el_label_position2.setAttribute("type", "radio");
        el_label_position2.setAttribute("name", "edit_for_label_position");
        el_label_position2.setAttribute("onchange", "label_top("+i+")");
	Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
		el_label_position2.setAttribute("checked", "checked");
	else
		el_label_position1.setAttribute("checked", "checked");

	var el_required_label = document.createElement('label');
	    el_required_label.setAttribute("for", "el_required");
		el_required_label.innerHTML = fmc_objectL10n.fmc_Required;

	var el_required = document.createElement('input');
        el_required.setAttribute("id", "el_required");
        el_required.setAttribute("type", "checkbox");
        el_required.setAttribute("onclick", "set_required('"+i+"_required')");
	if(w_required=="yes")
        el_required.setAttribute("checked", "checked");
			
	var el_attr_label = document.createElement('label');
		el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
			
	var el_attr_add = document.createElement('img');
		el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
		el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
		el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
		el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_send_copy')");
		
	var el_attr_table = document.createElement('table');
		el_attr_table.setAttribute("id", 'attributes');
		el_attr_table.setAttribute("border", '0');
		el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
		el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
		el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
		el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
		el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
		el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
			
	var el_attr_value_label = document.createElement('label');
	    el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
			el_attr_name.setAttribute("type", "text");
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_send_copy')");
			
		var el_attr_value = document.createElement('input');
			el_attr_value.setAttribute("type", "text");
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_send_copy')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_send_copy')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
	}

		
	var t  = document.getElementById('edit_table');
	
	var br = document.createElement('br');
	var br1 = document.createElement('br');
	var br2 = document.createElement('br');
	
	edit_main_td11.appendChild(el_label_disable);
	edit_main_td11_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);
	
	edit_main_td10.appendChild(el_label_size_label);
	edit_main_td10_1.appendChild(el_label_size);

	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2.appendChild(br);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br1);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	
	edit_main_td6.appendChild(el_required_label);
	edit_main_td6_1.appendChild(el_required);
		
	edit_main_td7.appendChild(el_attr_label);
	edit_main_td7.appendChild(el_attr_add);
	edit_main_td7.appendChild(br2);
	edit_main_td7.appendChild(el_attr_table);
	edit_main_td7.setAttribute("colspan", "2");

	edit_main_tr11.appendChild(edit_main_td11);
	edit_main_tr11.appendChild(edit_main_td11_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr10.appendChild(edit_main_td10);
	edit_main_tr10.appendChild(edit_main_td10_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr6.appendChild(edit_main_td6_1);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_table.appendChild(edit_main_tr11);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr10);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr6);
	edit_main_table.appendChild(edit_main_tr7);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);
	
	
/*show table*/

	element='input';	type='checkbox'; 
	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_send_copy");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
	    
	var adding_required= document.createElement("input");
            adding_required.setAttribute("type", "hidden");
            adding_required.setAttribute("value", w_required);
            adding_required.setAttribute("name", i+"_requiredform_id_temp");
            adding_required.setAttribute("id", i+"_requiredform_id_temp");
			
	var adding = document.createElement(element);
        adding.setAttribute("type", type);
		if(w_first_val)
			adding.setAttribute("checked", "checked");
		adding.setAttribute("id", i+"_elementform_id_temp");
		adding.setAttribute("name", i+"_elementform_id_temp");
		adding.setAttribute("onclick", "set_checked('"+i+"','','form_id_temp')");

	 
     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
			
		var div_for_editable_labels = document.createElement('div');
			div_for_editable_labels.setAttribute("style", "margin-left:4px; color:red;");
			
      	edit_labels = document.createTextNode(fmc_objectL10n.fmc_Use_field_allow);

		div_for_editable_labels.appendChild(edit_labels);  


			
      	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width= w_field_label_size+'px';
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");
			
      	var br1 = document.createElement('br');
      	var br2 = document.createElement('br');
     	var br3 = document.createElement('br');
      	var br4 = document.createElement('br');
      

	    
      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";

	    
      	var required = document.createElement('span');
			required.setAttribute("id", i+"_required_elementform_id_temp");
			required.innerHTML = "";
			required.setAttribute("class", "required");
			required.style.verticalAlign="top";
	if(w_required=="yes")
			required.innerHTML = " *";
      	var main_td  = document.getElementById('show_table');
      
      	div_label.appendChild(label);
      	div_label.appendChild(required);
      	div_element.appendChild(adding_type);
      	div_element.appendChild(adding_required);
      	div_element.appendChild(adding);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
      
      	div.appendChild(div_field);
      	div.appendChild(br3);
      	div.appendChild(div_for_editable_labels);
		
      	main_td.appendChild(div);
	if(w_field_label_pos=="top")
				label_top(i);
refresh_attr(i, 'type_text');
}


function type_text(i, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_first_val, w_title, w_required, w_regExp_status, w_regExp_value, w_regExp_common, w_regExp_arg, w_regExp_alert, w_unique, w_attr_name, w_attr_value) {

    document.getElementById("element_type").value="type_text";
    
	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");

	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
	var edit_main_tr7  = document.createElement('tr');
	var edit_main_tr8  = document.createElement('tr');
	var edit_main_tr9  = document.createElement('tr');
	var edit_main_tr10  = document.createElement('tr');
	var edit_main_tr11  = document.createElement('tr');
  var edit_main_tr12 = document.createElement('tr');
	var edit_main_tr13 = document.createElement('tr');
		edit_main_tr13.setAttribute("id", "edit_main_tr13");
	var edit_main_tr14 = document.createElement('tr');
		edit_main_tr14.setAttribute("id", "edit_main_tr14");
	var edit_main_tr15 = document.createElement('tr');
		edit_main_tr15.setAttribute("id", "edit_main_tr15");
	var edit_main_tr16 = document.createElement('tr');
		edit_main_tr16.setAttribute("id", "edit_main_tr16");
	if (w_regExp_status == 'no' || w_regExp_status == "") {
		edit_main_tr13.style.cssText = 'display: none;';
		edit_main_tr14.style.cssText = 'display: none;';
		edit_main_tr15.style.cssText = 'display: none;';
		edit_main_tr16.style.cssText = 'display: none;';
	}
	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');

	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
		
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
		
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');
		  
	var edit_main_td9 = document.createElement('td');
	var edit_main_td9_1 = document.createElement('td');

	var edit_main_td10 = document.createElement('td');
	var edit_main_td10_1 = document.createElement('td');
	
	var edit_main_td11 = document.createElement('td');
	var edit_main_td11_1 = document.createElement('td');

  var edit_main_td12 = document.createElement('td');
	var edit_main_td12_1 = document.createElement('td');
	var edit_main_td13 = document.createElement('td');	  
	var	edit_main_td13_1 = document.createElement('td');	  
	var edit_main_td14 = document.createElement('td');
	var edit_main_td14_1 = document.createElement('td');
	var edit_main_td15 = document.createElement('td');
	var edit_main_td15_1 = document.createElement('td');
	var edit_main_td16 = document.createElement('td');
	var edit_main_td16_1 = document.createElement('td');
	
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
		
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
		
	var el_label_label = document.createElement('label');
	    el_label_label.setAttribute("for", "edit_for_label");
		el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
        el_label_textarea.setAttribute("id", "edit_for_label");
        el_label_textarea.setAttribute("rows", "4");
        el_label_textarea.style.cssText = "width:200px";
        el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
		el_label_textarea.innerHTML = w_field_label;
		
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
		
	var el_label_position_label = document.createElement('label');
		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
        el_label_position1.setAttribute("id", "edit_for_label_position_top");
        el_label_position1.setAttribute("type", "radio");
		el_label_position1.setAttribute("name", "edit_for_label_position");
        el_label_position1.setAttribute("onchange", "label_left("+i+")");
	Left = document.createTextNode(fmc_objectL10n.fmc_Left);

	var el_label_position2 = document.createElement('input');
        el_label_position2.setAttribute("id", "edit_for_label_position_left");
        el_label_position2.setAttribute("type", "radio");
        el_label_position2.setAttribute("name", "edit_for_label_position");
        el_label_position2.setAttribute("onchange", "label_top("+i+")");
	Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
		el_label_position2.setAttribute("checked", "checked");
	else
		el_label_position1.setAttribute("checked", "checked");

	var el_size_label = document.createElement('label');
	    el_size_label.setAttribute("for", "edit_for_input_size");
		el_size_label.innerHTML = fmc_objectL10n.fmc_Field_size;

	var el_size = document.createElement('input');
		el_size.setAttribute("id", "edit_for_input_size");
		el_size.setAttribute("type", "text");
		el_size.setAttribute("value", w_size);
		el_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_size.setAttribute("onKeyUp", "change_w_style('"+i+"_elementform_id_temp', this.value)");

	var el_first_value_label = document.createElement('label');
	    el_first_value_label.setAttribute("for", "el_first_value_input");
		el_first_value_label.innerHTML = fmc_objectL10n.fmc_Value_empty;
	
	var el_first_value_input = document.createElement('input');
        el_first_value_input.setAttribute("id", "el_first_value_input");
        el_first_value_input.setAttribute("type", "text");
        el_first_value_input.setAttribute("value", w_title);
        el_first_value_input.style.cssText = "width:200px;";
        el_first_value_input.setAttribute("onKeyUp", "change_input_value(this.value,'"+i+"_elementform_id_temp')");
	
	var el_required_label = document.createElement('label');
	    el_required_label.setAttribute("for", "el_required");
		el_required_label.innerHTML = fmc_objectL10n.fmc_Required;

	var el_required = document.createElement('input');
        el_required.setAttribute("id", "el_required");
        el_required.setAttribute("type", "checkbox");
        el_required.setAttribute("onclick", "set_required('"+i+"_required')");
	if(w_required=="yes")
        el_required.setAttribute("checked", "checked");
		
  /********************** REGULAR EXPRESSION ************************/
	var el_add_regExp_label = document.createElement('label');
	    el_add_regExp_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_add_regExp_label.setAttribute("for", "el_regExp_"+i);
		el_add_regExp_label.innerHTML = fmc_objectL10n.fmc_Validation;

	var el_add_regExp = document.createElement('input');
        el_add_regExp.setAttribute("id", "el_regExp_"+i);
        el_add_regExp.setAttribute("type", "checkbox");
        el_add_regExp.setAttribute("onclick", "set_regExpStatus('"+i+"_regExpStatus')");
	if(w_regExp_status == "yes")
        el_add_regExp.setAttribute("checked", "checked");

	var el_reg_value_label = document.createElement('label');
		el_reg_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_reg_value_label.setAttribute("class","regExp_cell");
		el_reg_value_label.innerHTML = fmc_objectL10n.fmc_reg_exp;
	
	var el_reg_value = document.createElement('textarea');
		el_reg_value.style.cssText = "width:205px";
		el_reg_value.setAttribute("id", "regExp_value"+i);
		el_reg_value.setAttribute("class","regExp_cell");
		el_reg_value.setAttribute("onKeyUp", "change_regExpValue('"+i+"', this.value ,'"+i+"_regExp_valueform_id_temp','')");
		el_reg_value.innerHTML = w_regExp_value;
	
	var count = 0;
	var common_val_arr = [];
		common_val_arr[fmc_objectL10n.fmc_select] = "";
		common_val_arr[fmc_objectL10n.fmc_name_latin_letters] = "^[a-zA-Z'-'\\s]+$";
		common_val_arr[fmc_objectL10n.fmc_phone_number] = "^(\\+)?[0-9]+(-[0-9]+)?(-[0-9]+)?(-[0-9]+)?$";
		common_val_arr[fmc_objectL10n.fmc_integer_number] = "^(-)?[0-9]+$";
		common_val_arr[fmc_objectL10n.fmc_decimal_number] = "^(-)?[0-9]+(\\.[0-9]+)?$";
		common_val_arr[fmc_objectL10n.fmc_latin_letters_and_numbers] = "^[a-z&A-Z0-9]*$";
		common_val_arr[fmc_objectL10n.fmc_credit_card] = "^([0-9](\\.)?){15}[0-9]$";
		common_val_arr[fmc_objectL10n.fmc_zip_code] = "^(\\d{5}-\\d{4}|\\d{5}|\\d{9})$|^([a-zA-Z]\\d[a-zA-Z] \\d[a-zA-Z]\\d)$";
		common_val_arr[fmc_objectL10n.fmc_IP_address] = "^((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\\.){3}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})$";
		common_val_arr[fmc_objectL10n.fmc_date_mdy] = "^([0-9]|1[0,1,2])/([0-9]|[0,1,2][0-9]|3[0,1])/[0-9]{4}$";
		common_val_arr[fmc_objectL10n.fmc_date_dmy] = "^([0-9]|[0,1,2][0-9]|3[0,1])\\.([0-9]|1[0,1,2])\\.[0-9]{4}$";
		common_val_arr[fmc_objectL10n.fmc_date_format] = "^\\d{4}-(0[0-9]|1[0,1,2])-([0,1,2][0-9]|3[0,1])$";
				
	var el_reg_com_val_label = document.createElement('label');
		el_reg_com_val_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_reg_com_val_label.setAttribute("class","regExp_cell");
		el_reg_com_val_label.innerHTML = fmc_objectL10n.fmc_common_reg_exp;
				
	var el_reg_com_val = document.createElement('select');
		el_reg_com_val.setAttribute("id", "common_RegExp"+i);
		el_reg_com_val.setAttribute("name", "common_RegExp"+i);
		el_reg_com_val.setAttribute("onChange", "change_regExpValue('"+i+"','"+w_regExp_value+"','"+i+"_regExp_valueform_id_temp', this.value)");
				
	for (var keys  in common_val_arr) {
		if (!common_val_arr.hasOwnProperty(keys)) {
			continue;
    }
		var el_option_common = "el_com_val"+count;
			el_option_common = document.createElement('option');
			el_option_common.setAttribute("id", "edit_for_label_common"+count);
			el_option_common.setAttribute("value",common_val_arr[keys]);
			if (w_regExp_common == count)
				el_option_common.setAttribute("selected", "selected");
			el_option_common.innerHTML = keys;
			
		el_reg_com_val.appendChild(el_option_common);
		count++;
	}

	var el_reg_arg_label = document.createElement('label');
		el_reg_arg_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_reg_arg_label.setAttribute("class","regExp_cell");
		el_reg_arg_label.innerHTML = fmc_objectL10n.fmc_case_insensitive;
			
	var el_reg_arg = document.createElement('input');
		el_reg_arg.setAttribute("id", "el_regArg_"+i+" ");
		el_reg_arg.setAttribute("type", "checkbox");
		el_reg_arg.setAttribute("onclick", "set_regExpArgument('"+i+"_regArgument')");
	if(w_regExp_arg == 'i')
		el_reg_arg.setAttribute("checked", "checked");
					
	var el_reg_alert_label = document.createElement('label');
		el_reg_alert_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_reg_alert_label.innerHTML = fmc_objectL10n.fmc_alert_message;
		el_reg_alert_label.setAttribute("class","regExp_cell");
			
	var el_reg_alert = document.createElement('textarea');
		el_reg_alert.setAttribute("type", "text");
		el_reg_alert.style.cssText = "width:205px";
		el_reg_alert.setAttribute("id", "regExp_alert"+i);
		el_reg_alert.setAttribute("class","regExp_cell");
		el_reg_alert.setAttribute("onKeyUp", "change_regExpAlert(this.value,'"+i+"_regExp_alertform_id_temp')");
		el_reg_alert.innerHTML = w_regExp_alert;
	/**************************************************************************/	    
	
	var el_unique_label = document.createElement('label');
	    el_unique_label.setAttribute("for", "el_unique");
		el_unique_label.innerHTML = fmc_objectL10n.fmc_Allow_only_unique_values;

	var el_unique = document.createElement('input');
        el_unique.setAttribute("id", "el_unique");
        el_unique.setAttribute("type", "checkbox");
        el_unique.setAttribute("onclick", "set_unique('"+i+"_uniqueform_id_temp')");
	if(w_unique=="yes")
                el_unique.setAttribute("checked", "checked");
				
	var el_style_label = document.createElement('label');
		el_style_label.innerHTML = fmc_objectL10n.fmc_Deactive_class_name;
	
	var el_style_textarea = document.createElement('input');
		el_style_textarea.setAttribute("type", "text");
		el_style_textarea.setAttribute("value", "input_deactive");
		el_style_textarea.setAttribute("disabled", "disabled");
        el_style_textarea.style.cssText = "width:200px;";
        el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");

	var el_style_label2 = document.createElement('label');
	    el_style_label2.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_style_label2.innerHTML = fmc_objectL10n.fmc_Active_class_name;
	
	var el_style_textarea2 = document.createElement('input');
		el_style_textarea2.setAttribute("type", "text");
		el_style_textarea2.setAttribute("value", "input_active");
		el_style_textarea2.setAttribute("disabled", "disabled");
        el_style_textarea2.style.cssText = "width:200px;";
        el_style_textarea2.setAttribute("onChange", "change_class(this.value,'"+i+"')");

	var el_attr_label = document.createElement('label');
		el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
			
	var el_attr_add = document.createElement('img');
		el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
		el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
		el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
		el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_text')");
		
	var el_attr_table = document.createElement('table');
		el_attr_table.setAttribute("id", 'attributes');
		el_attr_table.setAttribute("border", '0');
		el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
		el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
		el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
		el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
		el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
		el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
			
	var el_attr_value_label = document.createElement('label');
	    el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
			el_attr_name.setAttribute("type", "text");
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_text')");
			
		var el_attr_value = document.createElement('input');
			el_attr_value.setAttribute("type", "text");
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_text')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_text')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
	}

		
	var t  = document.getElementById('edit_table');
	
	var br = document.createElement('br');
	var br1 = document.createElement('br');
	var br2 = document.createElement('br');

	edit_main_td11.appendChild(el_label_disable);
	edit_main_td11_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);
	
	edit_main_td10.appendChild(el_label_size_label);
	edit_main_td10_1.appendChild(el_label_size);

  edit_main_td12.appendChild(el_add_regExp_label);
	edit_main_td12_1.appendChild(el_add_regExp);
	
	edit_main_td13.appendChild(el_reg_value_label);
	edit_main_td13_1.appendChild(el_reg_value);
	
	edit_main_td14.appendChild(el_reg_com_val_label);
	edit_main_td14_1.appendChild(el_reg_com_val);
	
	edit_main_td15.appendChild(el_reg_arg_label);
	edit_main_td15_1.appendChild(el_reg_arg);
	
	edit_main_td16.appendChild(el_reg_alert_label);
	edit_main_td16_1.appendChild(el_reg_alert);
	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2.appendChild(br);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br1);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	edit_main_td3.appendChild(el_size_label);
	edit_main_td3_1.appendChild(el_size);
	
	edit_main_td4.appendChild(el_first_value_label);
	edit_main_td4_1.appendChild(el_first_value_input);
	
	edit_main_td5.appendChild(el_style_label);
	edit_main_td5_1.appendChild(el_style_textarea);
	
	edit_main_td9.appendChild(el_style_label2);
	edit_main_td9_1.appendChild(el_style_textarea2);
	
	edit_main_td6.appendChild(el_required_label);
	edit_main_td6_1.appendChild(el_required);
	
	edit_main_td8.appendChild(el_unique_label);
	edit_main_td8_1.appendChild(el_unique);
	
	edit_main_td7.appendChild(el_attr_label);
	edit_main_td7.appendChild(el_attr_add);
	edit_main_td7.appendChild(br2);
	edit_main_td7.appendChild(el_attr_table);
	edit_main_td7.setAttribute("colspan", "2");

	edit_main_tr11.appendChild(edit_main_td11);
	edit_main_tr11.appendChild(edit_main_td11_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr10.appendChild(edit_main_td10);
	edit_main_tr10.appendChild(edit_main_td10_1);
  edit_main_tr12.appendChild(edit_main_td12);
	edit_main_tr12.appendChild(edit_main_td12_1);
	
	edit_main_tr13.appendChild(edit_main_td13);
	edit_main_tr13.appendChild(edit_main_td13_1);
	
	edit_main_tr14.appendChild(edit_main_td14);
	edit_main_tr14.appendChild(edit_main_td14_1);
	
	edit_main_tr15.appendChild(edit_main_td15);
	edit_main_tr15.appendChild(edit_main_td15_1);
	
	edit_main_tr16.appendChild(edit_main_td16);
	edit_main_tr16.appendChild(edit_main_td16_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr6.appendChild(edit_main_td6_1);
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_tr9.appendChild(edit_main_td9);
	edit_main_tr9.appendChild(edit_main_td9_1);
	edit_main_table.appendChild(edit_main_tr11);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr10);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr4);
	edit_main_table.appendChild(edit_main_tr5);
	edit_main_table.appendChild(edit_main_tr9);
	edit_main_table.appendChild(edit_main_tr6);
  edit_main_table.appendChild(edit_main_tr12);
	edit_main_table.appendChild(edit_main_tr13);
	edit_main_table.appendChild(edit_main_tr14);
	edit_main_table.appendChild(edit_main_tr15);
	edit_main_table.appendChild(edit_main_tr16);
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr7);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);
	
/*show table*/

	element='input';	type='text'; 
	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_text");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
	    
	var adding_required= document.createElement("input");
            adding_required.setAttribute("type", "hidden");
            adding_required.setAttribute("value", w_required);
            adding_required.setAttribute("name", i+"_requiredform_id_temp");
            adding_required.setAttribute("id", i+"_requiredform_id_temp");
			
	var adding_unique= document.createElement("input");
            adding_unique.setAttribute("type", "hidden");
            adding_unique.setAttribute("value", w_unique);
            adding_unique.setAttribute("name", i+"_uniqueform_id_temp");
            adding_unique.setAttribute("id", i+"_uniqueform_id_temp");
			
	var adding = document.createElement(element);
            adding.setAttribute("type", type);
		
		if(w_title==w_first_val)
		{
			adding.style.cssText = "width:"+w_size+"px;";
			adding.setAttribute("class", "input_deactive");
		}
		else
		{
			adding.style.cssText = "width:"+w_size+"px;";
			adding.setAttribute("class", "input_active");
		}
			adding.setAttribute("id", i+"_elementform_id_temp");
			adding.setAttribute("name", i+"_elementform_id_temp");
			adding.setAttribute("value", w_first_val);
			adding.setAttribute("title", w_title);
			adding.setAttribute("onFocus", 'delete_value("'+i+'_elementform_id_temp")');
			adding.setAttribute("onBlur", 'return_value("'+i+'_elementform_id_temp")');
			adding.setAttribute("onChange", 'change_value("'+i+'_elementform_id_temp")');
			
    var adding_regExp_status = document.createElement("input");
			adding_regExp_status.setAttribute("type", "hidden");
			adding_regExp_status.setAttribute("value", w_regExp_status);
			adding_regExp_status.setAttribute("name", i+"_regExpStatusform_id_temp");
			adding_regExp_status.setAttribute("id", i+"_regExpStatusform_id_temp");

		var adding_regArg = document.createElement("input");
			adding_regArg.setAttribute("type", "hidden");
			adding_regArg.setAttribute("value", w_regExp_arg);
			adding_regArg.setAttribute("name", i+"_regArgumentform_id_temp");
			adding_regArg.setAttribute("id", i+"_regArgumentform_id_temp");

		var adding_regExp_common = document.createElement("input");
			adding_regExp_common.setAttribute("type", "hidden");
			adding_regExp_common.setAttribute("value", w_regExp_common);
			adding_regExp_common.setAttribute("name", i+"_regExp_commonform_id_temp");
			adding_regExp_common.setAttribute("id", i+"_regExp_commonform_id_temp");

		var adding_regExp_value = document.createElement("input");
			adding_regExp_value.setAttribute("type", "hidden");
			adding_regExp_value.setAttribute("value", escape(w_regExp_value));
			adding_regExp_value.setAttribute("name", i+"_regExp_valueform_id_temp");
			adding_regExp_value.setAttribute("id", i+"_regExp_valueform_id_temp");

		var adding_regExp_alert = document.createElement("input");
			adding_regExp_alert.setAttribute("type", "hidden");
			adding_regExp_alert.setAttribute("value", w_regExp_alert);
			adding_regExp_alert.setAttribute("name", i+"_regExp_alertform_id_temp");
			adding_regExp_alert.setAttribute("id", i+"_regExp_alertform_id_temp");	

    var div = document.createElement('div');
      div.setAttribute("id", "main_div");
					
    var div_field = document.createElement('div');
      div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
    var div_label = document.createElement('div');
      div_label.setAttribute("align", 'left');
      div_label.style.display="table-cell";
			div_label.style.width= w_field_label_size+'px';
      div_label.setAttribute("id", i+"_label_sectionform_id_temp");

    var div_element = document.createElement('div');
      div_element.setAttribute("align", 'left');
      div_element.style.display="table-cell";
      div_element.setAttribute("id", i+"_element_sectionform_id_temp");

    var br1 = document.createElement('br');
    var br2 = document.createElement('br');
    var br3 = document.createElement('br');
    var br4 = document.createElement('br');

    var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";

  	var required = document.createElement('span');
			required.setAttribute("id", i+"_required_elementform_id_temp");
			required.innerHTML = "";
			required.setAttribute("class", "required");
			required.style.verticalAlign="top";
    if(w_required=="yes")
			required.innerHTML = " *";
      	var main_td  = document.getElementById('show_table');
      
      	div_label.appendChild(label);
      	div_label.appendChild(required);
      	div_element.appendChild(adding_type);
      	div_element.appendChild(adding_required);
        div_element.appendChild(adding_regExp_status);
	    	div_element.appendChild(adding_regExp_value); 
		    div_element.appendChild(adding_regExp_common); 
		    div_element.appendChild(adding_regExp_alert);
	    	div_element.appendChild(adding_regArg); 
      	div_element.appendChild(adding_unique);
      	div_element.appendChild(adding);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
      
      	div.appendChild(div_field);
      	div.appendChild(br3);
      	main_td.appendChild(div);
	if(w_field_label_pos=="top")
				label_top(i);
refresh_attr(i, 'type_text');
}

function set_regExpStatus(id) {
	jQuery('#edit_main_tr13, #edit_main_tr14, #edit_main_tr15, #edit_main_tr16').toggle(200);
  if (document.getElementById(id+"form_id_temp").value == "yes") {
		document.getElementById(id+"form_id_temp").setAttribute("value", "no");
  }
	else {
		document.getElementById(id + "form_id_temp").setAttribute("value", "yes");
  }
}

function set_regExpArgument(id) {
	if (document.getElementById(id + "form_id_temp").value.length <= 0) {
		document.getElementById(id + "form_id_temp").setAttribute("value", "i");
  }
	else {
		document.getElementById(id+"form_id_temp").setAttribute("value", "");
  }
}

function change_regExpValue(i, regValue, regVal_id, com_option) {
	if (com_option.length > 0) {
		document.getElementById("regExp_value" + i).value = com_option;
		document.getElementById(regVal_id).value = com_option;
		document.getElementById(i + "_regExp_commonform_id_temp").value = document.getElementById("common_RegExp" + i).selectedIndex;
	}
	else {
		document.getElementById(regVal_id).value = regValue;
		document.getElementById(i + "_regExp_commonform_id_temp").value = regValue;
	}
}

function change_regExpAlert(regAlert, id) {
	document.getElementById(id).value = regAlert;
}

function type_number(i, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_first_val, w_title, w_required, w_unique, w_class, w_attr_name, w_attr_value) {
  document.getElementById("element_type").value = "type_number";
	delete_last_child();
  /* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
	var edit_main_tr7  = document.createElement('tr');
	var edit_main_tr8  = document.createElement('tr');
	var edit_main_tr9  = document.createElement('tr');
	var edit_main_tr10  = document.createElement('tr');
			
	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
	
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
		
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');
	var edit_main_td9 = document.createElement('td');
	var edit_main_td9_1 = document.createElement('td');
	var edit_main_td10 = document.createElement('td');
	var edit_main_td10_1 = document.createElement('td');
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
		
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
	
	var el_label_label = document.createElement('label');
	    el_label_label.setAttribute("for", "edit_for_label");
		el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
                el_label_textarea.setAttribute("id", "edit_for_label");
                el_label_textarea.setAttribute("rows", "4");
                el_label_textarea.style.cssText = "width:200px";
                el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
		el_label_textarea.innerHTML = w_field_label;
	

	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
	
	var el_label_position_label = document.createElement('label');
	    		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
                el_label_position1.setAttribute("id", "edit_for_label_position_top");
                el_label_position1.setAttribute("type", "radio");
				el_label_position1.setAttribute("name", "edit_for_label_position");
                el_label_position1.setAttribute("onchange", "label_left("+i+")");
	Left = document.createTextNode(fmc_objectL10n.fmc_Left);
		
	var el_label_position2 = document.createElement('input');
                el_label_position2.setAttribute("id", "edit_for_label_position_left");
                el_label_position2.setAttribute("type", "radio");
                el_label_position2.setAttribute("name", "edit_for_label_position");
                el_label_position2.setAttribute("onchange", "label_top("+i+")");
	Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
				el_label_position2.setAttribute("checked", "checked");
	else
				el_label_position1.setAttribute("checked", "checked");

	var el_size_label = document.createElement('label');
	    el_size_label.setAttribute("for", "edit_for_input_size");
		el_size_label.innerHTML = fmc_objectL10n.fmc_Field_size;
	var el_size = document.createElement('input');
		el_size.setAttribute("id", "edit_for_input_size");
		el_size.setAttribute("type", "text");
		el_size.setAttribute("value", w_size);
		el_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_size.setAttribute("onKeyUp", "change_w_style('"+i+"_elementform_id_temp', this.value)");

	var el_first_value_label = document.createElement('label');
	    el_first_value_label.setAttribute("for", "el_first_value_input");
		el_first_value_label.innerHTML = fmc_objectL10n.fmc_Value_empty;
	
	var el_first_value_input = document.createElement('input');
        el_first_value_input.setAttribute("id", "el_first_value_input");
		el_first_value_input.setAttribute("type", "text");
		el_first_value_input.setAttribute("value", w_title);
		el_first_value_input.style.cssText = "width:200px;";
	/*	el_first_value_input.setAttribute("onKeyPress", "return check_isnum(event)");*/
		el_first_value_input.setAttribute("onKeyUp", "change_input_value(this.value,'"+i+"_elementform_id_temp');");
		
	var el_required_label = document.createElement('label');
	    el_required_label.setAttribute("for", "el_required");
		el_required_label.innerHTML = fmc_objectL10n.fmc_Required;
	
	var el_required = document.createElement('input');
		el_required.setAttribute("id", "el_required");
		el_required.setAttribute("type", "checkbox");
		el_required.setAttribute("onclick", "set_required('"+i+"_required')");
	if(w_required=="yes")
		el_required.setAttribute("checked", "checked");
	
	var el_unique_label = document.createElement('label');
	    el_unique_label.setAttribute("for", "el_unique");
		el_unique_label.innerHTML = fmc_objectL10n.fmc_Allow_only_unique_values;
	
	var el_unique = document.createElement('input');
		el_unique.setAttribute("id", "el_unique");
		el_unique.setAttribute("type", "checkbox");
		el_unique.setAttribute("onclick", "set_unique('"+i+"_uniqueform_id_temp')");
	if(w_unique=="yes")
        el_unique.setAttribute("checked", "checked");
							
	var el_style_label = document.createElement('label');
	    el_style_label.setAttribute("for", "el_style_textarea");
		el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;

	var el_style_textarea = document.createElement('input');
        el_style_textarea.setAttribute("id", "el_style_textarea");
		el_style_textarea.setAttribute("type", "text");
		el_style_textarea.setAttribute("value", w_class);
        el_style_textarea.style.cssText = "width:200px;";
        el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");

	var el_attr_label = document.createElement('label');
		el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
			
	var el_attr_add = document.createElement('img');
      	el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
        el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
        el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
        el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_text')");
		
	var el_attr_table = document.createElement('table');
        el_attr_table.setAttribute("id", 'attributes');
        el_attr_table.setAttribute("border", '0');
        el_attr_table.style.cssText = 'margin-left:0px';
		
	var el_attr_tr_label = document.createElement('tr');
        el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
        el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
        el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
        el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	    el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
	var el_attr_value_label = document.createElement('label');
	    el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
			el_attr_name.setAttribute("type", "text");
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_text')");
			
		var el_attr_value = document.createElement('input');
			el_attr_value.setAttribute("type", "text");
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_text')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_text')");
	
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}

	var t  = document.getElementById('edit_table');
	
	var br2 = document.createElement('br');
	var br6 = document.createElement('br');
	
	edit_main_td10.appendChild(el_label_disable);
	edit_main_td10_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);

	edit_main_td9.appendChild(el_label_size_label);
	edit_main_td9_1.appendChild(el_label_size);
	
	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	edit_main_td3.appendChild(el_size_label);
	edit_main_td3_1.appendChild(el_size);
	
	edit_main_td4.appendChild(el_first_value_label);
	edit_main_td4_1.appendChild(el_first_value_input);
	
	edit_main_td5.appendChild(el_style_label);
	edit_main_td5_1.appendChild(el_style_textarea);
	edit_main_td6.appendChild(el_required_label);
	edit_main_td6_1.appendChild(el_required);
				
	edit_main_td8.appendChild(el_unique_label);
	edit_main_td8_1.appendChild(el_unique);
	
	
	edit_main_td7.appendChild(el_attr_label);
	edit_main_td7.appendChild(el_attr_add);
	edit_main_td7.appendChild(br6);
	edit_main_td7.appendChild(el_attr_table);
	edit_main_td7.setAttribute("colspan", "2");

	edit_main_tr10.appendChild(edit_main_td10);
	edit_main_tr10.appendChild(edit_main_td10_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr9.appendChild(edit_main_td9);
	edit_main_tr9.appendChild(edit_main_td9_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr6.appendChild(edit_main_td6_1);
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_table.appendChild(edit_main_tr10);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr9);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr4);
	edit_main_table.appendChild(edit_main_tr5);
	edit_main_table.appendChild(edit_main_tr6);
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr7);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);
	
	
/*show table*/

	element='input';	type='text'; 
	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_number");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
	    
	var adding_required= document.createElement("input");
            adding_required.setAttribute("type", "hidden");
            adding_required.setAttribute("value", w_required);
            adding_required.setAttribute("name", i+"_requiredform_id_temp");
            adding_required.setAttribute("id", i+"_requiredform_id_temp");
			
	var adding_unique= document.createElement("input");
            adding_unique.setAttribute("type", "hidden");
            adding_unique.setAttribute("value", w_unique);
            adding_unique.setAttribute("name", i+"_uniqueform_id_temp");
            adding_unique.setAttribute("id", i+"_uniqueform_id_temp");
			
			
	var adding = document.createElement(element);
			adding.setAttribute("type", type);
		
		if(w_title==w_first_val)
		{
			adding.style.cssText = "width:"+w_size+"px;";
			adding.setAttribute("class", "input_deactive");
		}
		else
		{
			adding.style.cssText = "width:"+w_size+"px;";
			adding.setAttribute("class", "input_active");
		}
			adding.setAttribute("id", i+"_elementform_id_temp");
			adding.setAttribute("name", i+"_elementform_id_temp");
			adding.setAttribute("value", w_first_val);
			adding.setAttribute("title", w_title);
			adding.setAttribute("onKeyPress", "return check_isnum(event)");
			adding.setAttribute("onFocus", 'delete_value("'+i+'_elementform_id_temp")');
			adding.setAttribute("onBlur", 'return_value("'+i+'_elementform_id_temp")');
			adding.setAttribute("onChange", 'change_value("'+i+'_elementform_id_temp")');
			
	 
     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
					
      	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width=w_field_label_size+"px";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");
			
      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";
	    
      	var required = document.createElement('span');
			required.setAttribute("id", i+"_required_elementform_id_temp");
			required.innerHTML = "";
			required.setAttribute("class", "required");
			required.style.verticalAlign="top";
	if(w_required=="yes")
			required.innerHTML = " *";
      	var main_td  = document.getElementById('show_table');
      
      	div_label.appendChild(label);
      	div_label.appendChild(required);
      	div_element.appendChild(adding_type);
      	div_element.appendChild(adding_required);
      	div_element.appendChild(adding_unique);
      	div_element.appendChild(adding);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
      	
      
      	div.appendChild(div_field);
      	main_td.appendChild(div);
		
		if(w_field_label_pos=="top")
			label_top(i);
			
		change_class(w_class, i);
		refresh_attr(i, 'type_text');
}

function type_password(i, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_required, w_unique, w_class, w_attr_name, w_attr_value) {

    document.getElementById("element_type").value="type_password";

	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
	var edit_main_tr7  = document.createElement('tr');
	var edit_main_tr8  = document.createElement('tr');
	var edit_main_tr9  = document.createElement('tr');
	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');
	var edit_main_td9 = document.createElement('td');
	var edit_main_td9_1 = document.createElement('td');

	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
	
	var el_label_label = document.createElement('label');
		el_label_label.setAttribute("for", "edit_for_label");
		el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
        el_label_textarea.setAttribute("id", "edit_for_label");
        el_label_textarea.setAttribute("rows", "4");
        el_label_textarea.style.cssText = "width:200px;";
        el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
		el_label_textarea.innerHTML = w_field_label;
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
		
		
	var el_label_position_label = document.createElement('label');
		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
        el_label_position1.setAttribute("id", "edit_for_label_position_top");
        el_label_position1.setAttribute("type", "radio");
        el_label_position1.setAttribute("name", "edit_for_label_position");
        el_label_position1.setAttribute("onchange", "label_left("+i+")");
	Left = document.createTextNode(fmc_objectL10n.fmc_Left);
		
	var el_label_position2 = document.createElement('input');
        el_label_position2.setAttribute("id", "edit_for_label_position_left");
        el_label_position2.setAttribute("type", "radio");
		el_label_position2.setAttribute("name", "edit_for_label_position");
		el_label_position2.setAttribute("onchange", "label_top("+i+")");
	Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
		el_label_position2.setAttribute("checked", "checked");
	else
		el_label_position1.setAttribute("checked", "checked");

	var el_size_label = document.createElement('label');
	    el_size_label.setAttribute("for", "edit_for_input_size");
		el_size_label.innerHTML = fmc_objectL10n.fmc_Field_size;
	
	var el_size = document.createElement('input');
		el_size.setAttribute("id", "edit_for_input_size");
		el_size.setAttribute("type", "text");
		el_size.setAttribute("value", w_size);
		el_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_size.setAttribute("onKeyUp", "change_w_style('"+i+"_elementform_id_temp', this.value)");

	var el_required_label = document.createElement('label');
	    el_required_label.setAttribute("for", "el_required");
		el_required_label.innerHTML = fmc_objectL10n.fmc_Required;
	
	var el_required = document.createElement('input');
        el_required.setAttribute("id", "el_required");
        el_required.setAttribute("type", "checkbox");
        el_required.setAttribute("onclick", "set_required('"+i+"_required')");
	if(w_required=="yes")
		el_required.setAttribute("checked", "checked");
			
	var el_unique_label = document.createElement('label');
	    el_unique_label.setAttribute("for", "el_unique");
		el_unique_label.innerHTML = fmc_objectL10n.fmc_Allow_only_unique_values;
	
	var el_unique = document.createElement('input');
        el_unique.setAttribute("id", "el_unique");
        el_unique.setAttribute("type", "checkbox");
        el_unique.setAttribute("onclick", "set_unique('"+i+"_uniqueform_id_temp')");
	if(w_unique=="yes")
        el_unique.setAttribute("checked", "checked");
				
	var el_style_label = document.createElement('label');
	    el_style_label.setAttribute("for", "el_style_textarea");
		el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
        el_style_textarea.setAttribute("id", "el_style_textarea");
		el_style_textarea.setAttribute("type", "text");
		el_style_textarea.setAttribute("value", w_class);
        el_style_textarea.style.cssText = "width:200px;";
        el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");
		
	var el_attr_label = document.createElement('label');
		el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
		
	var el_attr_add = document.createElement('img');
        el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
        el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
        el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
        el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_text')");
	var el_attr_table = document.createElement('table');
        el_attr_table.setAttribute("id", 'attributes');
        el_attr_table.setAttribute("border", '0');
        el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
        el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
      	el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
       	el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
      	el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	    el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
	var el_attr_value_label = document.createElement('label');
	    el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
			el_attr_name.setAttribute("type", "text");
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_text')");
			
		var el_attr_value = document.createElement('input');
			el_attr_value.setAttribute("type", "text");
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_text')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_text')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}

	var t  = document.getElementById('edit_table');
	
	var br2 = document.createElement('br');
	var br3 = document.createElement('br');
	
	edit_main_td9.appendChild(el_label_disable);
	edit_main_td9_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);

	edit_main_td8.appendChild(el_label_size_label);
	edit_main_td8_1.appendChild(el_label_size);
	
	
	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	edit_main_td3.appendChild(el_size_label);
	edit_main_td3_1.appendChild(el_size);
	
	edit_main_td4.appendChild(el_style_label);
	edit_main_td4_1.appendChild(el_style_textarea);
	
	edit_main_td5.appendChild(el_required_label);
	edit_main_td5_1.appendChild(el_required);
	
	edit_main_td7.appendChild(el_unique_label);
	edit_main_td7_1.appendChild(el_unique);

	edit_main_td6.appendChild(el_attr_label);
	edit_main_td6.appendChild(el_attr_add);
	edit_main_td6.appendChild(br3);
	edit_main_td6.appendChild(el_attr_table);
	edit_main_td6.setAttribute("colspan", "2");

	edit_main_tr9.appendChild(edit_main_td9);
	edit_main_tr9.appendChild(edit_main_td9_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_tr7.appendChild(edit_main_td7_1);
	edit_main_table.appendChild(edit_main_tr9);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr4);
	edit_main_table.appendChild(edit_main_tr5);
	edit_main_table.appendChild(edit_main_tr7);
	edit_main_table.appendChild(edit_main_tr6);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);
	

/*show table*/

	element='input';	type='password'; 
	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_password");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
	var adding_required= document.createElement("input");
            adding_required.setAttribute("type", "hidden");
            adding_required.setAttribute("value", w_required);
            adding_required.setAttribute("name", i+"_requiredform_id_temp");
            adding_required.setAttribute("id", i+"_requiredform_id_temp");
			
	var adding_unique= document.createElement("input");
            adding_unique.setAttribute("type", "hidden");
            adding_unique.setAttribute("value", w_unique);
            adding_unique.setAttribute("name", i+"_uniqueform_id_temp");
            adding_unique.setAttribute("id", i+"_uniqueform_id_temp");

	var adding = document.createElement(element);
			adding.setAttribute("type", type);
			adding.setAttribute("id", i+"_elementform_id_temp");
			adding.setAttribute("name", i+"_elementform_id_temp");
			adding.style.cssText = "width:"+w_size+"px;";
		
			
     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
		
      	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width= w_field_label_size+"px";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");

      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";
	    
      	var required = document.createElement('span');
			required.setAttribute("id", i+"_required_elementform_id_temp");
			required.innerHTML = "";
			required.setAttribute("class", "required");
			required.style.verticalAlign="top";
	if(w_required=="yes")
			required.innerHTML = " *";
      	var main_td  = document.getElementById('show_table');
	
      
      	div_label.appendChild(label);
      	div_label.appendChild(required);
      	div_element.appendChild(adding_type);
      	div_element.appendChild(adding_required);
       	div_element.appendChild(adding_unique);
     	div_element.appendChild(adding);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
		
      	div.appendChild(div_field);
      	main_td.appendChild(div);
	if(w_field_label_pos=="top")
				label_top(i);
change_class(w_class, i);
refresh_attr(i, 'type_text');
}

function type_textarea(i, w_field_label, w_field_label_size, w_field_label_pos, w_size_w, w_size_h, w_first_val, w_title, w_required, w_unique, w_class, w_attr_name, w_attr_value){
    
	document.getElementById("element_type").value="type_textarea";

	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
	var edit_main_tr7  = document.createElement('tr');
	var edit_main_tr8  = document.createElement('tr');
	var edit_main_tr9  = document.createElement('tr');
	var edit_main_tr10  = document.createElement('tr');
	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');
	var edit_main_td9 = document.createElement('td');
	var edit_main_td9_1 = document.createElement('td');
	var edit_main_td10 = document.createElement('td');
	var edit_main_td10_1 = document.createElement('td');
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
	
	var el_label_label = document.createElement('label');
		el_label_label.setAttribute("for", "edit_for_label");
		el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
        el_label_textarea.setAttribute("id", "edit_for_label");
        el_label_textarea.setAttribute("rows", "4");
        el_label_textarea.style.cssText = "width:200px;";
        el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
		el_label_textarea.innerHTML = w_field_label;
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
	
	var el_label_position_label = document.createElement('label');
		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
        el_label_position1.setAttribute("id", "edit_for_label_position_top");
        el_label_position1.setAttribute("type", "radio");
        el_label_position1.setAttribute("name", "edit_for_label_position");
        el_label_position1.setAttribute("onchange", "label_left("+i+")");
	Left = document.createTextNode(fmc_objectL10n.fmc_Left);
		
	var el_label_position2 = document.createElement('input');
        el_label_position2.setAttribute("id", "edit_for_label_position_left");
        el_label_position2.setAttribute("type", "radio");
        el_label_position2.setAttribute("name", "edit_for_label_position");
        el_label_position2.setAttribute("onchange", "label_top("+i+")");
	Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
		el_label_position2.setAttribute("checked", "checked");
	else
		el_label_position1.setAttribute("checked", "checked");

	var el_size_label = document.createElement('label');
	    el_size_label.setAttribute("for", "edit_for_input_size");
		el_size_label.innerHTML = fmc_objectL10n.fmc_Field_size;
		
	var el_size_w = document.createElement('input');
		el_size_w.setAttribute("id", "edit_for_input_size");
		el_size_w.setAttribute("type", "text");
		el_size_w.setAttribute("value", w_size_w);
		el_size_w.style.cssText = "margin-right:2px; width: 60px";
		el_size_w.setAttribute("onKeyPress", "return check_isnum(event)");
        el_size_w.setAttribute("onKeyUp", "change_w_style('"+i+"_elementform_id_temp', this.value)");
		   
		X = document.createTextNode("x");
		
	var el_size_h = document.createElement('input');
		el_size_h.setAttribute("id", "edit_for_input_size");
		el_size_h.setAttribute("type", "text");
		el_size_h.setAttribute("value", w_size_h);
		el_size_h.style.cssText = "margin-left:2px;  width:60px";
		el_size_h.setAttribute("onKeyPress", "return check_isnum(event)");
        el_size_h.setAttribute("onKeyUp", "change_h_style('"+i+"_elementform_id_temp', this.value)");
		
	var el_first_value_label = document.createElement('label');
	    el_first_value_label.setAttribute("for", "el_first_value_input");
		el_first_value_label.innerHTML = fmc_objectL10n.fmc_Value_empty;
	
	var el_first_value_input = document.createElement('input');
                el_first_value_input.setAttribute("id", "el_first_value_input");
                el_first_value_input.setAttribute("type", "text");
                el_first_value_input.setAttribute("value", w_title);
                el_first_value_input.style.cssText = "width:200px;";
                el_first_value_input.setAttribute("onKeyUp", "change_input_value(this.value,'"+i+"_elementform_id_temp')");
				
	var el_required_label = document.createElement('label');
	    el_required_label.setAttribute("for", "el_required");
		el_required_label.innerHTML = fmc_objectL10n.fmc_Required;
	
	var el_required = document.createElement('input');
                el_required.setAttribute("id", "el_required");
                el_required.setAttribute("type", "checkbox");
                el_required.setAttribute("onclick", "set_required('"+i+"_required')");
	if(w_required=="yes")
			    el_required.setAttribute("checked", "checked");
		
	var el_unique_label = document.createElement('label');
	    el_unique_label.setAttribute("for", "el_unique");
		el_unique_label.innerHTML = fmc_objectL10n.fmc_Allow_only_unique_values;
	
	var el_unique = document.createElement('input');
                el_unique.setAttribute("id", "el_unique");
                el_unique.setAttribute("type", "checkbox");
                el_unique.setAttribute("onclick", "set_unique('"+i+"_uniqueform_id_temp')");
	if(w_unique=="yes")
                el_unique.setAttribute("checked", "checked");
		
	var el_style_label = document.createElement('label');
	        el_style_label.setAttribute("for", "el_style_textarea");
			el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
                el_style_textarea.setAttribute("id", "el_style_textarea");
				el_style_textarea.setAttribute("type", "text");
				el_style_textarea.setAttribute("value", w_class);
                el_style_textarea.style.cssText = "width:200px;";
                el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");

	var el_attr_label = document.createElement('label');
			el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
			
	var el_attr_add = document.createElement('img');
           	el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
            	el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_text')");
	var el_attr_table = document.createElement('table');
                el_attr_table.setAttribute("id", 'attributes');
                el_attr_table.setAttribute("border", '0');
        	el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
                el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
            	el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
            	el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
            	el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	                el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
	var el_attr_value_label = document.createElement('label');
	                el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
			el_attr_name.setAttribute("type", "text");
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_text')");
			
		var el_attr_value = document.createElement('input');
			el_attr_value.setAttribute("type", "text");
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_text')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_text')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}

	var t  = document.getElementById('edit_table');
	
	var br2 = document.createElement('br');
	var br6 = document.createElement('br');
	
	edit_main_td10.appendChild(el_label_disable);
	edit_main_td10_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);
	
	edit_main_td9.appendChild(el_label_size_label);
	edit_main_td9_1.appendChild(el_label_size);

	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	edit_main_td3.appendChild(el_size_label);
	edit_main_td3_1.appendChild(el_size_w);
	edit_main_td3_1.appendChild(X);
	edit_main_td3_1.appendChild(el_size_h);
	
	edit_main_td4.appendChild(el_first_value_label);
	edit_main_td4_1.appendChild(el_first_value_input);
	
	edit_main_td5.appendChild(el_style_label);
	edit_main_td5_1.appendChild(el_style_textarea);
	
	edit_main_td6.appendChild(el_required_label);
	edit_main_td6_1.appendChild(el_required);
	
	edit_main_td8.appendChild(el_unique_label);
	edit_main_td8_1.appendChild(el_unique);

	edit_main_td7.appendChild(el_attr_label);
	edit_main_td7.appendChild(el_attr_add);
	edit_main_td7.appendChild(br6);
	edit_main_td7.appendChild(el_attr_table);
	edit_main_td7.setAttribute("colspan", "2");

	
	edit_main_tr10.appendChild(edit_main_td10);
	edit_main_tr10.appendChild(edit_main_td10_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr9.appendChild(edit_main_td9);
	edit_main_tr9.appendChild(edit_main_td9_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr6.appendChild(edit_main_td6_1);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_tr7.appendChild(edit_main_td7_1);
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_table.appendChild(edit_main_tr10);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr9);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr4);
	edit_main_table.appendChild(edit_main_tr5);
	edit_main_table.appendChild(edit_main_tr6);
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr7);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);


/*show table*/

	element='textarea';
	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_textarea");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
	var adding_required= document.createElement("input");
            adding_required.setAttribute("type", "hidden");
            adding_required.setAttribute("value", w_required);
            adding_required.setAttribute("name", i+"_requiredform_id_temp");			
            adding_required.setAttribute("id", i+"_requiredform_id_temp");
			
	var adding_unique= document.createElement("input");
            adding_unique.setAttribute("type", "hidden");
            adding_unique.setAttribute("value", w_unique);
            adding_unique.setAttribute("name", i+"_uniqueform_id_temp");
            adding_unique.setAttribute("id", i+"_uniqueform_id_temp");
			
		var div = document.createElement('div');
			div.setAttribute("id", "main_div");
			
      	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width=w_field_label_size+"px";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
         	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");
			
      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";
	    
      	var required = document.createElement('span');
			required.setAttribute("id", i+"_required_elementform_id_temp");
			required.innerHTML = "";
			required.setAttribute("class", "required");
			required.style.verticalAlign="top";
	if(w_required=="yes")
			required.innerHTML = " *";
	var adding = document.createElement(element);
		if(w_title==w_first_val)
		{
			adding.style.cssText = "width:"+w_size_w+"px; height:"+w_size_h+"px;";
			adding.setAttribute("class", "input_deactive");
		}
		else
		{
			adding.style.cssText = "width:"+w_size_w+"px; height:"+w_size_h+"px;";
			adding.setAttribute("class", "input_active");
		}
		adding.setAttribute("id", i+"_elementform_id_temp");
		adding.setAttribute("name", i+"_elementform_id_temp");
		adding.setAttribute("title", w_title);
		adding.setAttribute("value",w_first_val);
		adding.setAttribute("onFocus", "delete_value('"+i+"_elementform_id_temp')");
		adding.setAttribute("onBlur", "return_value('"+i+"_elementform_id_temp')");
		adding.setAttribute("onChange", "change_value('"+i+"_elementform_id_temp')");
		adding.innerHTML=w_first_val;
		
		var main_td  = document.getElementById('show_table');
      
      	div_label.appendChild(label);
      	div_label.appendChild(required);
      	div_element.appendChild(adding_type);
      	div_element.appendChild(adding_required);
      	div_element.appendChild(adding_unique);
      	div_element.appendChild(adding);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
      
      	div.appendChild(div_field);
      	main_td.appendChild(div);
	if(w_field_label_pos=="top")
				label_top(i);
change_class(w_class, i);
refresh_attr(i, 'type_text');
}

function type_phone(i, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_first_val, w_title, w_mini_labels, w_required, w_unique, w_class, w_attr_name, w_attr_value) {
	document.getElementById("element_type").value="type_phone";

	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
	var edit_main_tr7  = document.createElement('tr');
	var edit_main_tr8  = document.createElement('tr');
	var edit_main_tr9  = document.createElement('tr');
	var edit_main_tr10  = document.createElement('tr');
	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');
	var edit_main_td9 = document.createElement('td');
	var edit_main_td9_1 = document.createElement('td');
	var edit_main_td10 = document.createElement('td');
	var edit_main_td10_1 = document.createElement('td');
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
	
	var el_label_label = document.createElement('label');
			    el_label_label.setAttribute("for", "edit_for_label");
				el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
                el_label_textarea.setAttribute("id", "edit_for_label");
                el_label_textarea.setAttribute("rows", "4");
                el_label_textarea.style.cssText = "width:200px;";
                el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
				el_label_textarea.innerHTML = w_field_label;
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");

	
	var el_label_position_label = document.createElement('label');
		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
                el_label_position1.setAttribute("id", "edit_for_label_position_top");
                el_label_position1.setAttribute("type", "radio");
                el_label_position1.setAttribute("name", "edit_for_label_position");
                el_label_position1.setAttribute("onchange", "label_left("+i+")");
		Left = document.createTextNode(fmc_objectL10n.fmc_Left);
		
	var el_label_position2 = document.createElement('input');
                el_label_position2.setAttribute("id", "edit_for_label_position_left");
                el_label_position2.setAttribute("type", "radio");
                el_label_position2.setAttribute("name", "edit_for_label_position");
                el_label_position2.setAttribute("onchange", "label_top("+i+")");
		Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
				el_label_position2.setAttribute("checked", "checked");
	else
				el_label_position1.setAttribute("checked", "checked");

	var el_size_label = document.createElement('label');
	        el_size_label.setAttribute("for", "edit_for_input_size");
			el_size_label.innerHTML = fmc_objectL10n.fmc_Field_size;
	var el_size = document.createElement('input');
			el_size.setAttribute("id", "edit_for_input_size");
			el_size.setAttribute("type", "text");
			el_size.setAttribute("value", w_size);			
			el_size.setAttribute("onKeyPress", "return check_isnum(event)");
            el_size.setAttribute("onKeyUp", "change_w_style('"+i+"_element_lastform_id_temp', this.value);");

	var gic = document.createTextNode("-");

	var el_first_value_label = document.createElement('label');
		el_first_value_label.innerHTML = fmc_objectL10n.fmc_Value_empty;
	
	var el_first_value_area = document.createElement('input');
                el_first_value_area.setAttribute("id", "el_first_value_area");
                el_first_value_area.setAttribute("type", "text");
                el_first_value_area.setAttribute("value", w_title[0]);
                el_first_value_area.style.cssText = "width:50px; margin-right:4px";
	/*			el_first_value_area.setAttribute("onKeyPress", "return check_isnum(event)");*/
                el_first_value_area.setAttribute("onKeyUp", "change_input_value(this.value,'"+i+"_element_firstform_id_temp')");

	var el_first_value_phone = document.createElement('input');
                el_first_value_phone.setAttribute("id", "el_first_value_phone");
                el_first_value_phone.setAttribute("type", "text");
                el_first_value_phone.setAttribute("value", w_title[1]);
                el_first_value_phone.style.cssText = "width:100px; margin-left:4px";
	/*			el_first_value_phone.setAttribute("onKeyPress", "return check_isnum(event)");*/
                el_first_value_phone.setAttribute("onKeyUp", "change_input_value(this.value,'"+i+"_element_lastform_id_temp')");


	var el_required_label = document.createElement('label');
	        el_required_label.setAttribute("for", "el_required");
			el_required_label.innerHTML = fmc_objectL10n.fmc_Required;
	
	var el_required = document.createElement('input');
                el_required.setAttribute("id", "el_required");
                el_required.setAttribute("type", "checkbox");
                el_required.setAttribute("onclick", "set_required('"+i+"_required')");
	if(w_required=="yes")
                el_required.setAttribute("checked", "checked");	

	var el_unique_label = document.createElement('label');
				el_unique_label.setAttribute("for", "el_unique");
				el_unique_label.innerHTML = fmc_objectL10n.fmc_Allow_only_unique_values;
	
	var el_unique = document.createElement('input');
                el_unique.setAttribute("id", "el_unique");
                el_unique.setAttribute("type", "checkbox");
                el_unique.setAttribute("onclick", "set_unique('"+i+"_uniqueform_id_temp')");
	if(w_unique=="yes")
                el_unique.setAttribute("checked", "checked");
				
	var el_style_label = document.createElement('label');
	        el_style_label.setAttribute("for", "el_style_textarea");
			el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
                el_style_textarea.setAttribute("id", "el_style_textarea");
				el_style_textarea.setAttribute("type", "text");
				el_style_textarea.setAttribute("value", w_class);
                el_style_textarea.style.cssText = "width:200px;";
                el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");

	var el_attr_label = document.createElement('label');
				el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
	var el_attr_add = document.createElement('img');
				el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
            	el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_name')");
	var el_attr_table = document.createElement('table');
                el_attr_table.setAttribute("id", 'attributes');
                el_attr_table.setAttribute("border", '0');
				el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
                el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
            	el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
            	el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
            	el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	                el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
	var el_attr_value_label = document.createElement('label');
	                el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
			el_attr_name.setAttribute("type", "text");
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_name')");
			
		var el_attr_value = document.createElement('input');
			el_attr_value.setAttribute("type", "text");
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_name')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_name')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}

		
	var t  = document.getElementById('edit_table');
	
	var br1 = document.createElement('br');
	var br2 = document.createElement('br');
	var br3 = document.createElement('br');
	
	edit_main_td10.appendChild(el_label_disable);
	edit_main_td10_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);

	edit_main_td9.appendChild(el_label_size_label);
	edit_main_td9_1.appendChild(el_label_size);
	
	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	edit_main_td3.appendChild(el_first_value_label);
	edit_main_td3_1.appendChild(el_first_value_area);
	edit_main_td3_1.appendChild(gic);
	edit_main_td3_1.appendChild(el_first_value_phone);
	
	
	edit_main_td7.appendChild(el_size_label);
	edit_main_td7_1.appendChild(el_size);
	
	edit_main_td4.appendChild(el_style_label);
	edit_main_td4_1.appendChild(el_style_textarea);
	
	edit_main_td5.appendChild(el_required_label);
	edit_main_td5_1.appendChild(el_required);
	
	edit_main_td8.appendChild(el_unique_label);
	edit_main_td8_1.appendChild(el_unique);
	
	edit_main_td6.appendChild(el_attr_label);
	edit_main_td6.appendChild(el_attr_add);
	edit_main_td6.appendChild(br3);
	edit_main_td6.appendChild(el_attr_table);
	edit_main_td6.setAttribute("colspan", "2");
	
	edit_main_tr10.appendChild(edit_main_td10);
	edit_main_tr10.appendChild(edit_main_td10_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr9.appendChild(edit_main_td9);
	edit_main_tr9.appendChild(edit_main_td9_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_tr7.appendChild(edit_main_td7_1);
	edit_main_table.appendChild(edit_main_tr10);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr9);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr7);
	edit_main_table.appendChild(edit_main_tr4);
	edit_main_table.appendChild(edit_main_tr5);
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr6);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);


/*show table*/

	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_phone");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
			
	var adding_required= document.createElement("input");
            adding_required.setAttribute("type", "hidden");
            adding_required.setAttribute("value", w_required);
            adding_required.setAttribute("name", i+"_requiredform_id_temp");
            adding_required.setAttribute("id", i+"_requiredform_id_temp");
			
	var adding_unique= document.createElement("input");
            adding_unique.setAttribute("type", "hidden");
            adding_unique.setAttribute("value", w_unique);
            adding_unique.setAttribute("name", i+"_uniqueform_id_temp");
            adding_unique.setAttribute("id", i+"_uniqueform_id_temp");
	    
     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
			
		var div_for_editable_labels = document.createElement('div');
			div_for_editable_labels.setAttribute("style", "margin-left:4px; color:red; float: left; clear: both;");
			
      	edit_labels = document.createTextNode(fmc_objectL10n.fmc_labels_fields_editable);

		div_for_editable_labels.appendChild(edit_labels);  
		
      	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width=w_field_label_size+"px";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");
			
      	var table_name = document.createElement('div');
		    table_name.style.display="table";
           	table_name.setAttribute("id", i+"_table_name");
			
      	var tr_name1 = document.createElement('div');
 		    tr_name1.style.display="table-row";
          	tr_name1.setAttribute("id", i+"_tr_name1");
			
      	var tr_name2 = document.createElement('div');
 		    tr_name2.style.display="table-row";
           	tr_name2.setAttribute("id", i+"_tr_name2");
			
      	var td_name_input1 = document.createElement('div');
  		    td_name_input1.style.display="table-cell";
          	td_name_input1.setAttribute("id", i+"_td_name_input_first");
			
      	var td_name_input2 = document.createElement('div');
  		    td_name_input2.style.display="table-cell";
          	td_name_input2.setAttribute("id", i+"_td_name_input_last");
		
      	var td_name_label1 = document.createElement('div');
 		    td_name_label1.style.display="table-cell";
           	td_name_label1.setAttribute("id", i+"_td_name_label_first");
           	td_name_label1.setAttribute("align", "left");
			
      	var td_name_label2 = document.createElement('div');
  		    td_name_label2.style.display="table-cell";
          	td_name_label2.setAttribute("id", i+"_td_name_label_last");
           	td_name_label2.setAttribute("align", "left");
			
      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";
	    
      	var required = document.createElement('span');
			required.setAttribute("id", i+"_required_elementform_id_temp");
			required.innerHTML = "";
			required.setAttribute("class", "required");
	if(w_required=="yes")
			required.innerHTML = " *";	
			
	var first = document.createElement('input');
        first.setAttribute("type", 'text');
		if(w_title[0]==w_first_val[0])
			first.setAttribute("class", "input_deactive");
		else
			first.setAttribute("class", "input_active");
	    first.style.cssText = "width:50px";
	    first.setAttribute("id", i+"_element_firstform_id_temp");
	    first.setAttribute("name", i+"_element_firstform_id_temp");
		first.setAttribute("value", w_first_val[0]);
		first.setAttribute("title", w_title[0]);
		first.setAttribute("onFocus", 'delete_value("'+i+'_element_firstform_id_temp")');
		first.setAttribute("onBlur", 'return_value("'+i+'_element_firstform_id_temp")');
	    first.setAttribute("onChange", "change_value('"+i+"_element_firstform_id_temp')");
		first.setAttribute("onKeyPress", "return check_isnum(event)");
		
	var gic = document.createElement('span');
	    gic.setAttribute("class", "wdform_line");
		gic.style.cssText = "margin: 0px 4px 0px 4px; padding: 0px;";
		gic.innerHTML = "-";	

	var first_label = document.createElement('label');
	    first_label.setAttribute("class", "mini_label");
	    first_label.setAttribute("id", i+"_mini_label_area_code");
	    first_label.innerHTML= w_mini_labels[0];
			
	var last = document.createElement('input');
        last.setAttribute("type", 'text');
 		if(w_title[1]==w_first_val[1])
			last.setAttribute("class", "input_deactive");
		else
			last.setAttribute("class", "input_active");
	    last.style.cssText = "width:"+w_size+"px";
		last.setAttribute("id", i+"_element_lastform_id_temp");
	   	last.setAttribute("name", i+"_element_lastform_id_temp");
		last.setAttribute("value", w_first_val[1]);
		last.setAttribute("title", w_title[1]);
		last.setAttribute("onFocus", 'delete_value("'+i+'_element_lastform_id_temp")');
		last.setAttribute("onBlur", 'return_value("'+i+'_element_lastform_id_temp")');
		last.setAttribute("onChange", "change_value('"+i+"_element_lastform_id_temp')");
		last.setAttribute("onKeyPress", "return check_isnum(event)");

	var last_label = document.createElement('label');
		last_label.setAttribute("class", "mini_label");
		last_label.setAttribute("id", i+"_mini_label_phone_number");
		last_label.innerHTML=w_mini_labels[1];
			
    var main_td  = document.getElementById('show_table');
      
      	div_label.appendChild(label);
      	div_label.appendChild(required );
		
      	td_name_input1.appendChild(first);
      	td_name_input1.appendChild(gic);
      	td_name_input2.appendChild(last);
      	tr_name1.appendChild(td_name_input1);
      	tr_name1.appendChild(td_name_input2);
      	td_name_label1.appendChild(first_label);
      	td_name_label2.appendChild(last_label);
      	tr_name2.appendChild(td_name_label1);
      	tr_name2.appendChild(td_name_label2);
      	table_name.appendChild(tr_name1);
      	table_name.appendChild(tr_name2);
       	div_element.appendChild(adding_type);
       	div_element.appendChild(adding_required);
       	div_element.appendChild(adding_unique);
    	div_element.appendChild(table_name);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
      	div.appendChild(div_field);
		div.appendChild(br1);
		div.appendChild(div_for_editable_labels);
      	main_td.appendChild(div);
		
	if(w_field_label_pos=="top")
				label_top(i);

change_class(w_class, i);
refresh_attr(i, 'type_name');

jQuery(document).ready(function() {	
	jQuery("label#"+i+"_mini_label_area_code").click(function() {		
	if (jQuery(this).children('input').length == 0) {		

		var area_code = "<input type='text' class='area_code' size='10' style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";		

		jQuery(this).html(area_code);		
		jQuery("input.area_code").focus();		
		jQuery("input.area_code").blur(function() {	

		var value = jQuery(this).val();			
		jQuery("#"+i+"_mini_label_area_code").text(value);		
		});		
	}	
	});	

	
	jQuery("label#"+i+"_mini_label_phone_number").click(function() {		

	if (jQuery(this).children('input').length == 0) {			
		var phone_number = "<input type='text' class='phone_number'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";						

		jQuery(this).html(phone_number);					

		jQuery("input.phone_number").focus();			
		jQuery("input.phone_number").blur(function() {		
		
		var value = jQuery(this).val();			
		jQuery("#"+i+"_mini_label_phone_number").text(value);		
		});	
	}	
	});
	
	});


}


function type_name(i, w_field_label, w_field_label_size, w_field_label_pos, w_first_val, w_title, w_mini_labels, w_size, w_name_format, w_required, w_unique, w_class, w_attr_name, w_attr_value) {
	document.getElementById("element_type").value="type_name";

	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
	var edit_main_tr7  = document.createElement('tr');
	var edit_main_tr8  = document.createElement('tr');
	var edit_main_tr9  = document.createElement('tr');
	var edit_main_tr10  = document.createElement('tr');
	var edit_main_tr11  = document.createElement('tr');
	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');
	var edit_main_td9 = document.createElement('td');
	var edit_main_td9_1 = document.createElement('td');
	var edit_main_td10 = document.createElement('td');
	var edit_main_td10_1 = document.createElement('td');
	var edit_main_td11 = document.createElement('td');
	var edit_main_td11_1 = document.createElement('td');
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
		
	var el_label_label = document.createElement('label');
			        el_label_label.setAttribute("for", "edit_for_label");
			el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
                el_label_textarea.setAttribute("id", "edit_for_label");
                el_label_textarea.setAttribute("rows", "4");
                el_label_textarea.style.cssText = "width:200px;";
                el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
				el_label_textarea.innerHTML = w_field_label;
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
	
	var el_label_position_label = document.createElement('label');
			    		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
                el_label_position1.setAttribute("id", "edit_for_label_position_top");
                el_label_position1.setAttribute("type", "radio");
                el_label_position1.setAttribute("name", "edit_for_label_position");
                el_label_position1.setAttribute("onchange", "label_left("+i+")");
		Left = document.createTextNode(fmc_objectL10n.fmc_Left);
		
	var el_label_position2 = document.createElement('input');
                el_label_position2.setAttribute("id", "edit_for_label_position_left");
                el_label_position2.setAttribute("type", "radio");
                el_label_position2.setAttribute("name", "edit_for_label_position");
                el_label_position2.setAttribute("onchange", "label_top("+i+")");
		Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
				el_label_position2.setAttribute("checked", "checked");
	else
				el_label_position1.setAttribute("checked", "checked");

	var gic = document.createTextNode("-");

	var el_first_value_label = document.createElement('label');
	    el_first_value_label.setAttribute("for", "el_first_value_input");
		el_first_value_label.innerHTML = fmc_objectL10n.fmc_Value_empty;
	
	var el_first_value_first = document.createElement('input');
                el_first_value_first.setAttribute("id", "el_first_value_first");
                el_first_value_first.setAttribute("type", "text");
                el_first_value_first.setAttribute("value", w_title[0]);
                el_first_value_first.style.cssText = "width:80px; margin-left:4px; margin-right:4px";
                el_first_value_first.setAttribute("onKeyUp", "change_input_value(this.value,'"+i+"_element_firstform_id_temp')");

	var el_first_value_last = document.createElement('input');
                el_first_value_last.setAttribute("id", "el_first_value_last");
                el_first_value_last.setAttribute("type", "text");
                el_first_value_last.setAttribute("value", w_title[1]);
                el_first_value_last.style.cssText = "width:80px; margin-left:4px; margin-right:4px";
                el_first_value_last.setAttribute("onKeyUp", "change_input_value(this.value,'"+i+"_element_lastform_id_temp')");

	var el_size_label = document.createElement('label');
	        el_size_label.setAttribute("for", "edit_for_input_size");
			el_size_label.innerHTML = fmc_objectL10n.fmc_Field_size;
	var el_size = document.createElement('input');
			el_size.setAttribute("id", "edit_for_input_size");
			el_size.setAttribute("type", "text");
			el_size.setAttribute("value", w_size);
			
			
			el_size.setAttribute("onKeyPress", "return check_isnum(event)");
            el_size.setAttribute("onKeyUp", "change_w_style('"+i+"_element_firstform_id_temp', this.value); change_w_style('"+i+"_element_lastform_id_temp', this.value); change_w_style('"+i+"_element_middleform_id_temp', this.value)");


	var el_format_label = document.createElement('label');
	        el_format_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_format_label.innerHTML = fmc_objectL10n.fmc_Name_format;
	
	var el_format_normal = document.createElement('input');
                el_format_normal.setAttribute("id", "el_format_normal");
                el_format_normal.setAttribute("type", "radio");
                el_format_normal.setAttribute("value", "normal");
		el_format_normal.setAttribute("name", "edit_for_name_format");
                el_format_normal.setAttribute("onchange", "format_normal("+i+")");
		el_format_normal.setAttribute("checked", "checked");
		Normal = document.createTextNode(fmc_objectL10n.fmc_Normal);
		
	var el_format_extended = document.createElement('input');
                el_format_extended.setAttribute("id", "el_format_extended");
                el_format_extended.setAttribute("type", "radio");
                el_format_extended.setAttribute("value", "extended");
		el_format_extended.setAttribute("name", "edit_for_name_format");
                el_format_extended.setAttribute("onchange", "format_extended("+i+",'','','','')");
		Extended = document.createTextNode(fmc_objectL10n.fmc_Extended);
		
	if(w_name_format=="normal")
	
				el_format_normal.setAttribute("checked", "checked");
	else
				el_format_extended.setAttribute("checked", "checked");

	var el_required_label = document.createElement('label');
	        el_required_label.setAttribute("for", "el_required");
		el_required_label.innerHTML = fmc_objectL10n.fmc_Required;
	
	var el_required = document.createElement('input');
                el_required.setAttribute("id", "el_required");
                el_required.setAttribute("type", "checkbox");
                
                el_required.setAttribute("onclick", "set_required('"+i+"_required')");
	if(w_required=="yes")
                el_required.setAttribute("checked", "checked");	

	var el_unique_label = document.createElement('label');
	    el_unique_label.setAttribute("for", "el_unique");
		el_unique_label.innerHTML = fmc_objectL10n.fmc_Allow_only_unique_values;
	
	var el_unique = document.createElement('input');
                el_unique.setAttribute("id", "el_unique");
                el_unique.setAttribute("type", "checkbox");
                
                el_unique.setAttribute("onclick", "set_unique('"+i+"_uniqueform_id_temp')");
	if(w_unique=="yes")
                el_unique.setAttribute("checked", "checked");
				
	var el_style_label = document.createElement('label');
	        el_style_label.setAttribute("for", "el_style_textarea");
			el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
                el_style_textarea.setAttribute("id", "el_style_textarea");
				el_style_textarea.setAttribute("type", "text");
				el_style_textarea.setAttribute("value", w_class);
                el_style_textarea.style.cssText = "width:200px;";
                el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");

	var el_attr_label = document.createElement('label');
	                
			el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
	var el_attr_add = document.createElement('img');
                
           	el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
            	el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_name')");
	var el_attr_table = document.createElement('table');
                el_attr_table.setAttribute("id", 'attributes');
                el_attr_table.setAttribute("border", '0');
        	el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
                el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
            	el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
            	el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
            	el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	                el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
			
	var el_attr_value_label = document.createElement('label');
	                el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
	
			el_attr_name.setAttribute("type", "text");
	
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_name')");
			
		var el_attr_value = document.createElement('input');
	
			el_attr_value.setAttribute("type", "text");
	
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_name')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_name')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}

		
	var t  = document.getElementById('edit_table');
	
	var br = document.createElement('br');
	var br1 = document.createElement('br');
	var br2 = document.createElement('br');
	var br3 = document.createElement('br');
	var br4 = document.createElement('br');
	var br5 = document.createElement('br');
	var br6 = document.createElement('br');
	
	edit_main_td11.appendChild(el_label_disable);
	edit_main_td11_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);

	edit_main_td10.appendChild(el_label_size_label);
	edit_main_td10_1.appendChild(el_label_size);
	
	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	edit_main_td9.appendChild(el_first_value_label);
	edit_main_td9_1.appendChild(el_first_value_first);
	edit_main_td9_1.appendChild(gic);
	edit_main_td9_1.appendChild(el_first_value_last);
	
	
	
	edit_main_td7.appendChild(el_size_label);
	edit_main_td7_1.appendChild(el_size);
	
	edit_main_td3.appendChild(el_format_label);

	edit_main_td3_1.appendChild(el_format_normal);
	edit_main_td3_1.appendChild(Normal);
	edit_main_td3_1.appendChild(br6);
	edit_main_td3_1.appendChild(el_format_extended);
	edit_main_td3_1.appendChild(Extended);
	
	edit_main_td4.appendChild(el_style_label);
	edit_main_td4_1.appendChild(el_style_textarea);
	
	edit_main_td5.appendChild(el_required_label);
	edit_main_td5_1.appendChild(el_required);
	
	edit_main_td8.appendChild(el_unique_label);
	edit_main_td8_1.appendChild(el_unique);
	
	edit_main_td6.appendChild(el_attr_label);
	edit_main_td6.appendChild(el_attr_add);
	edit_main_td6.appendChild(br3);
	edit_main_td6.appendChild(el_attr_table);
	edit_main_td6.setAttribute("colspan", "2");
	
	edit_main_tr11.appendChild(edit_main_td11);
	edit_main_tr11.appendChild(edit_main_td11_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr10.appendChild(edit_main_td10);
	edit_main_tr10.appendChild(edit_main_td10_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_tr7.appendChild(edit_main_td7_1);
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr6.appendChild(edit_main_td6_1);
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_tr9.appendChild(edit_main_td9);
	edit_main_tr9.appendChild(edit_main_td9_1);
	edit_main_table.appendChild(edit_main_tr11);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr10);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr9);
	edit_main_table.appendChild(edit_main_tr7);
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr4);
	edit_main_table.appendChild(edit_main_tr5);
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr6);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);
	
	
/*show table*/

	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_name");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
	var adding_required= document.createElement("input");
            adding_required.setAttribute("type", "hidden");
            adding_required.setAttribute("value", w_required);
            adding_required.setAttribute("name", i+"_requiredform_id_temp");
            adding_required.setAttribute("id", i+"_requiredform_id_temp");
			
	var adding_unique= document.createElement("input");
            adding_unique.setAttribute("type", "hidden");
            adding_unique.setAttribute("value", w_unique);
            adding_unique.setAttribute("name", i+"_uniqueform_id_temp");
            adding_unique.setAttribute("id", i+"_uniqueform_id_temp");
	    
     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
		var div_for_editable_labels = document.createElement('div');
			div_for_editable_labels.setAttribute("style", "margin-left:4px; color:red; float: left; clear: both;");
			
      	edit_labels = document.createTextNode(fmc_objectL10n.fmc_labels_fields_editable);

		div_for_editable_labels.appendChild(edit_labels);  

		
					
      	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width=w_field_label_size +"px";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");
			
      	var table_name = document.createElement('div');
 		    table_name.style.display="table";
          	table_name.setAttribute("id", i+"_table_name");
           	table_name.setAttribute("cellpadding", '0');
           	table_name.setAttribute("cellspacing", '0');
			
      	var tr_name1 = document.createElement('div');
 		    tr_name1.style.display="table-row";
          	tr_name1.setAttribute("id", i+"_tr_name1");
			
      	var tr_name2 = document.createElement('div');
  		    tr_name2.style.display="table-row";
          	tr_name2.setAttribute("id", i+"_tr_name2");
			
      	var td_name_input1 = document.createElement('div');
 		    td_name_input1.style.display="table-cell";
           	td_name_input1.setAttribute("id", i+"_td_name_input_first");
			
      	var td_name_input2 = document.createElement('div');
  		    td_name_input2.style.display="table-cell";
          	td_name_input2.setAttribute("id", i+"_td_name_input_last");
		
      	var td_name_label1 = document.createElement('div');
  		    td_name_label1.style.display="table-cell";
          	td_name_label1.setAttribute("id", i+"_td_name_label_first");
           	td_name_label1.setAttribute("align", "left");
			
      	var td_name_label2 = document.createElement('div');
  		    td_name_label2.style.display="table-cell";
          	td_name_label2.setAttribute("id", i+"_td_name_label_last");
           	td_name_label2.setAttribute("align", "left");
			
      	var br1 = document.createElement('br');
      	var br2 = document.createElement('br');
     	var br3 = document.createElement('br');
      	var br4 = document.createElement('br');
      
	    
      	var label = document.createElement('span');
		label.setAttribute("id", i+"_element_labelform_id_temp");
		label.innerHTML = w_field_label;
		label.setAttribute("class", "label");
		label.style.verticalAlign="top";
	    
      	var required = document.createElement('span');
			required.setAttribute("id", i+"_required_elementform_id_temp");
			required.innerHTML = "";
			required.setAttribute("class", "required");
			required.style.verticalAlign="top";
	if(w_required=="yes")
			required.innerHTML = " *";			
	var first = document.createElement('input');
        first.setAttribute("type", 'text');
		if(w_title[0]==w_first_val[0])
			first.setAttribute("class", "input_deactive");
		else
			first.setAttribute("class", "input_active");
		
	    first.style.cssText = "margin-right: 10px; width:"+w_size+"px";
	    first.setAttribute("id", i+"_element_firstform_id_temp");
	    first.setAttribute("name", i+"_element_firstform_id_temp");
		first.setAttribute("value", w_first_val[0]);
		first.setAttribute("title", w_title[0]);
		first.setAttribute("onFocus", 'delete_value("'+i+'_element_firstform_id_temp")');
		first.setAttribute("onBlur", 'return_value("'+i+'_element_firstform_id_temp")');
	    first.setAttribute("onChange", "change_value('"+i+"_element_firstform_id_temp')");
			
	var first_label = document.createElement('label');
	    first_label.setAttribute("class", "mini_label");
	    first_label.setAttribute("id", i+"_mini_label_first");
	    first_label.innerHTML= w_mini_labels[1];
			
	var last = document.createElement('input');
        last.setAttribute("type", 'text');
		
 		if(w_title[1]==w_first_val[1])
			last.setAttribute("class", "input_deactive");
		else
			last.setAttribute("class", "input_active");
			
		last.style.cssText = "margin-right: 10px; width:"+w_size+"px";
		last.setAttribute("id", i+"_element_lastform_id_temp");
	   	last.setAttribute("name", i+"_element_lastform_id_temp");
		last.setAttribute("value", w_first_val[1]);
		last.setAttribute("title", w_title[1]);
		last.setAttribute("onFocus", 'delete_value("'+i+'_element_lastform_id_temp")');
		last.setAttribute("onBlur", 'return_value("'+i+'_element_lastform_id_temp")');
		last.setAttribute("onChange", "change_value('"+i+"_element_lastform_id_temp')");


	var last_label = document.createElement('label');
		last_label.setAttribute("class", "mini_label");
		last_label.setAttribute("id", i+"_mini_label_last");
		last_label.innerHTML= w_mini_labels[2];
			
      	var main_td  = document.getElementById('show_table');
      
      	div_label.appendChild(label);
      	div_label.appendChild(required );
		
      	td_name_input1.appendChild(first);
      	td_name_input2.appendChild(last);
      	tr_name1.appendChild(td_name_input1);
      	tr_name1.appendChild(td_name_input2);
		
      	td_name_label1.appendChild(first_label);
      	td_name_label2.appendChild(last_label);
      	tr_name2.appendChild(td_name_label1);
      	tr_name2.appendChild(td_name_label2);
      	table_name.appendChild(tr_name1);
      	table_name.appendChild(tr_name2);
		
       	div_element.appendChild(adding_type);
       	div_element.appendChild(adding_required);
       	div_element.appendChild(adding_unique);
    	div_element.appendChild(table_name);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
      
      	div.appendChild(div_field);
      	div.appendChild(br3);
 		div.appendChild(div_for_editable_labels);
     	main_td.appendChild(div);
		
	if(w_field_label_pos=="top")
				label_top(i);
	
	if(w_name_format=="extended")
				format_extended(i,w_first_val[2],w_first_val[3],w_title[2],w_title[3]);
change_class(w_class, i);
refresh_attr(i, 'type_name');
jQuery(document).ready(function() {	
	jQuery("label#"+i+"_mini_label_first").click(function() {		
		if (jQuery(this).children('input').length == 0) {				
			var first = "<input type='text' class='first' style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";	
				jQuery(this).html(first);							
				jQuery("input.first").focus();			
				jQuery("input.first").blur(function() {	
			var value = jQuery(this).val();			


		jQuery("#"+i+"_mini_label_first").text(value);		
		});	
	}	
	});		


	jQuery("label#"+i+"_mini_label_last").click(function() {	
	if (jQuery(this).children('input').length == 0) {		
		var last = "<input type='text' class='last'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";	
			jQuery(this).html(last);			
			jQuery("input.last").focus();					
			jQuery("input.last").blur(function() {			
			var value = jQuery(this).val();			
			
			jQuery("#"+i+"_mini_label_last").text(value);	
		});	
	}	
	});
	});	

}

function type_address(i, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_mini_labels, w_disabled_fields, w_required, w_class, w_attr_name, w_attr_value) {

	document.getElementById("element_type").value="type_address";

	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
	var edit_main_tr7  = document.createElement('tr');
	var edit_main_tr8  = document.createElement('tr');
	var edit_main_tr9  = document.createElement('tr');
	var edit_main_tr10  = document.createElement('tr');
	var edit_main_tr11  = document.createElement('tr');
	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');
	var edit_main_td9 = document.createElement('td');
	var edit_main_td9_1 = document.createElement('td');
	var edit_main_td10 = document.createElement('td');
	var edit_main_td10_1 = document.createElement('td');
	var edit_main_td11 = document.createElement('td');
	var edit_main_td11_1 = document.createElement('td');
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
	
	var el_label_label = document.createElement('label');
			        el_label_label.setAttribute("for", "edit_for_label");
			el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
                el_label_textarea.setAttribute("id", "edit_for_label");
                el_label_textarea.setAttribute("rows", "4");
                el_label_textarea.style.cssText = "width:200px;";
                el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
				el_label_textarea.innerHTML = w_field_label;
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
	
	var el_label_position_label = document.createElement('label');
			    		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
                el_label_position1.setAttribute("id", "edit_for_label_position_top");
                el_label_position1.setAttribute("type", "radio");
                el_label_position1.setAttribute("name", "edit_for_label_position");
                el_label_position1.setAttribute("onchange", "label_left("+i+")");
		Left = document.createTextNode(fmc_objectL10n.fmc_Left);
		
	var el_label_position2 = document.createElement('input');
                el_label_position2.setAttribute("id", "edit_for_label_position_left");
                el_label_position2.setAttribute("type", "radio");
                el_label_position2.setAttribute("name", "edit_for_label_position");
                el_label_position2.setAttribute("onchange", "label_top("+i+")");
		Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
				el_label_position2.setAttribute("checked", "checked");
	else
				el_label_position1.setAttribute("checked", "checked");

	var el_size_label = document.createElement('label');
	        el_size_label.setAttribute("for", "edit_for_input_size");
		el_size_label.innerHTML = fmc_objectL10n.fmc_Overall_size;
	var el_size = document.createElement('input');
		   el_size.setAttribute("id", "edit_for_input_size");
		   el_size.setAttribute("type", "text");
		   el_size.setAttribute("value", w_size);
		   
			
			el_size.setAttribute("onKeyPress", "return check_isnum(event)");
            el_size.setAttribute("onKeyUp", "change_w_style('"+i+"_div_address', this.value);");

			
	var el_disable_field_label = document.createElement('label');
	        el_disable_field_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_disable_field_label.innerHTML = fmc_objectL10n.fmc_Disable_field;
	
	
	var el_disable_address1 = document.createElement('input');
            el_disable_address1.setAttribute("id", "el_street1");
            el_disable_address1.setAttribute("type", "checkbox");
            el_disable_address1.setAttribute("value", "no");
            el_disable_address1.setAttribute("onclick", "disable_fields('"+i+"','street1')");
	if(w_disabled_fields[0]=="yes")
                el_disable_address1.setAttribute("checked", "checked");	
	
	var el_disable_address2 = document.createElement('input');
            el_disable_address2.setAttribute("id", "el_street2");
            el_disable_address2.setAttribute("type", "checkbox");
            el_disable_address2.setAttribute("value", "no");
            el_disable_address2.setAttribute("onclick", "disable_fields('"+i+"','street2')");
	if(w_disabled_fields[1]=="yes")
                el_disable_address2.setAttribute("checked", "checked");	
	
	var el_disable_city = document.createElement('input');
            el_disable_city.setAttribute("id", "el_city");
            el_disable_city.setAttribute("type", "checkbox");
            el_disable_city.setAttribute("value", "no");
            el_disable_city.setAttribute("onclick", "disable_fields('"+i+"','city')");
	if(w_disabled_fields[2]=="yes")
                el_disable_city.setAttribute("checked", "checked");	
	
	var el_disable_state = document.createElement('input');
            el_disable_state.setAttribute("id", "el_state");
            el_disable_state.setAttribute("type", "checkbox");
            el_disable_state.setAttribute("value", "no");
            el_disable_state.setAttribute("onclick", "disable_fields('"+i+"','state')");
	if(w_disabled_fields[3]=="yes")
                el_disable_state.setAttribute("checked", "checked");

					
	
	var el_disable_postal = document.createElement('input');
            el_disable_postal.setAttribute("id", "el_postal");
            el_disable_postal.setAttribute("type", "checkbox");
            el_disable_postal.setAttribute("value", "no");
            el_disable_postal.setAttribute("onclick", "disable_fields('"+i+"','postal')");
	if(w_disabled_fields[4]=="yes")
                el_disable_postal.setAttribute("checked", "checked");
	
	var el_disable_country = document.createElement('input');
                el_disable_country.setAttribute("id", "el_country");
                el_disable_country.setAttribute("type", "checkbox");
                el_disable_country.setAttribute("value", "no");
                el_disable_country.setAttribute("onclick", "disable_fields('"+i+"','country')");
	if(w_disabled_fields[5]=="yes")
                el_disable_country.setAttribute("checked", "checked");			
			
		
	var el_required_label = document.createElement('label');
	        el_required_label.setAttribute("for", "el_required");
		el_required_label.innerHTML = fmc_objectL10n.fmc_Required;
	
	var el_required = document.createElement('input');
                el_required.setAttribute("id", "el_required");
                el_required.setAttribute("type", "checkbox");
                
                el_required.setAttribute("onclick", "set_required('"+i+"_required')");
	if(w_required=="yes")
                el_required.setAttribute("checked", "checked");	

	var el_style_label = document.createElement('label');
	        el_style_label.setAttribute("for", "el_style_textarea");
			el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
                el_style_textarea.setAttribute("id", "el_style_textarea");
				el_style_textarea.setAttribute("type", "text");
				el_style_textarea.setAttribute("value", w_class);
                el_style_textarea.style.cssText = "width:200px;";
                el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");

	var el_attr_label = document.createElement('label');
	                
			el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
	var el_attr_add = document.createElement('img');
                
           	el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
            	el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_address')");
	var el_attr_table = document.createElement('table');
                el_attr_table.setAttribute("id", 'attributes');
                el_attr_table.setAttribute("border", '0');
        	el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
                el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
            	el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
            	el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
            	el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	                el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
			
	var el_attr_value_label = document.createElement('label');
	                el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
	
			el_attr_name.setAttribute("type", "text");
	
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_address')");
			
		var el_attr_value = document.createElement('input');
	
			el_attr_value.setAttribute("type", "text");
	
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_address')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_address')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}
		var el_us_states_label = document.createElement('label');
	        el_us_states_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
			el_us_states_label.innerHTML = fmc_objectL10n.fmc_Use_list_US_states;
	
		var el_disable_us_states = document.createElement('input');
            el_disable_us_states.setAttribute("id", "el_us_states");
            el_disable_us_states.setAttribute("type", "checkbox");
            el_disable_us_states.setAttribute("value", "yes");
			el_disable_us_states.setAttribute("onclick", "disable_fields('"+i+"','us_states')");
		  
		  if(w_disabled_fields[6]=="yes")
                el_disable_us_states.setAttribute("checked", "checked"); 
	
	var el_street1 = document.createTextNode(w_mini_labels[0]);
	var el_street2 = document.createTextNode(w_mini_labels[1]);
	var el_city = document.createTextNode(w_mini_labels[2]);
	var el_state = document.createTextNode(w_mini_labels[3]);
	var el_us_states = document.createTextNode(fmc_objectL10n.fmc_Use_US_states);
	var el_postal = document.createTextNode(w_mini_labels[4]);
	var el_country = document.createTextNode(w_mini_labels[5]);
	
	var el_street1_label = document.createElement('label');
		el_street1_label.setAttribute("id", "el_street1_label");
	
	var el_street2_label = document.createElement('label');
		el_street2_label.setAttribute("id", "el_street2_label");
	
	var el_city_label = document.createElement('label');
		el_city_label.setAttribute("id", "el_city_label");
	
	var el_state_label = document.createElement('label');
		el_state_label.setAttribute("id", "el_state_label");
		
	
	var el_postal_label = document.createElement('label');
		el_postal_label.setAttribute("id", "el_postal_label");
	
	var el_country_label = document.createElement('label');
		el_country_label.setAttribute("id", "el_country_label");
	
	el_street1_label.appendChild(el_street1);
	el_street2_label.appendChild(el_street2);
	el_city_label.appendChild(el_city);
	el_state_label.appendChild(el_state);

	el_postal_label.appendChild(el_postal);
	el_country_label.appendChild(el_country);
	
	var br_ = document.createElement('br');
	var br1_ = document.createElement('br');
	var br2_ = document.createElement('br');
	var br3_ = document.createElement('br');
	var br4_ = document.createElement('br');
	var br5_ = document.createElement('br');
	var br6_ = document.createElement('br');
		
	var t  = document.getElementById('edit_table');
	
	var br = document.createElement('br');

	var br2 = document.createElement('br');
	var br3 = document.createElement('br');
	
	edit_main_td11.appendChild(el_label_disable);
	edit_main_td11_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);

	edit_main_td9.appendChild(el_label_size_label);
	edit_main_td9_1.appendChild(el_label_size);
	
	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	edit_main_td7.appendChild(el_size_label);
	edit_main_td7_1.appendChild(el_size);
	
	/*edit_main_td3.appendChild(el_format_label);
	edit_main_td3.appendChild(br5);
	edit_main_td3.appendChild(el_format_normal);
	edit_main_td3.appendChild(Normal);
	edit_main_td3.appendChild(br6);
	edit_main_td3.appendChild(el_format_extended);
	edit_main_td3.appendChild(Extended);*/
	
	edit_main_td4.appendChild(el_style_label);
	edit_main_td4_1.appendChild(el_style_textarea);
	
	edit_main_td5.appendChild(el_required_label);
	edit_main_td5_1.appendChild(el_required);
	
edit_main_td8.appendChild(el_disable_field_label);
	edit_main_td8_1.appendChild(el_disable_address1);
	edit_main_td8_1.appendChild(el_street1_label);
	edit_main_td8_1.appendChild(br_);
	edit_main_td8_1.appendChild(el_disable_address2);
	edit_main_td8_1.appendChild(el_street2_label);
	edit_main_td8_1.appendChild(br1_);
	edit_main_td8_1.appendChild(el_disable_city);
	edit_main_td8_1.appendChild(el_city_label);
	edit_main_td8_1.appendChild(br2_);
	edit_main_td8_1.appendChild(el_disable_state);
	edit_main_td8_1.appendChild(el_state_label);
	edit_main_td8_1.appendChild(br3_);

	edit_main_td8_1.appendChild(el_disable_postal);
	edit_main_td8_1.appendChild(el_postal_label);
	edit_main_td8_1.appendChild(br4_);
	edit_main_td8_1.appendChild(el_disable_country);
	edit_main_td8_1.appendChild(el_country_label);
	edit_main_td8_1.appendChild(br5_);
	
	edit_main_td10.appendChild(el_us_states_label);
	edit_main_td10_1.appendChild(el_disable_us_states);
	
	edit_main_td6.appendChild(el_attr_label);
	edit_main_td6.appendChild(el_attr_add);
	edit_main_td6.appendChild(br3);
	edit_main_td6.appendChild(el_attr_table);
	edit_main_td6.setAttribute("colspan", "2");
	
	edit_main_tr11.appendChild(edit_main_td11);
	edit_main_tr11.appendChild(edit_main_td11_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr9.appendChild(edit_main_td9);
	edit_main_tr9.appendChild(edit_main_td9_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_tr7.appendChild(edit_main_td7_1);
	/*edit_main_tr3.appendChild(edit_main_td3);*/
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr6.appendChild(edit_main_td6_1);
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_tr10.appendChild(edit_main_td10);
	edit_main_tr10.appendChild(edit_main_td10_1);
	edit_main_table.appendChild(edit_main_tr11);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr9);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr7);
	/*edit_main_table.appendChild(edit_main_tr3);*/
	edit_main_table.appendChild(edit_main_tr4);
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr10);
	edit_main_table.appendChild(edit_main_tr5);
	edit_main_table.appendChild(edit_main_tr6);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);
	

/*show table*/

	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_address");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
			
	var adding_country= document.createElement("input");
            adding_country.setAttribute("type", "hidden");
			adding_country.setAttribute("name", i+"_disable_fieldsform_id_temp");
            adding_country.setAttribute("id", i+"_disable_fieldsform_id_temp");	
			adding_country.setAttribute("street1", w_disabled_fields[0]);
			adding_country.setAttribute("street2", w_disabled_fields[1]);
			adding_country.setAttribute("city", w_disabled_fields[2]);
			adding_country.setAttribute("state", w_disabled_fields[3]);
			adding_country.setAttribute("us_states", w_disabled_fields[6]);
            adding_country.setAttribute("postal", w_disabled_fields[4]);
			adding_country.setAttribute("country", w_disabled_fields[5]);
            		
	var adding_required= document.createElement("input");
            adding_required.setAttribute("type", "hidden");
            adding_required.setAttribute("value", w_required);
            adding_required.setAttribute("name", i+"_requiredform_id_temp");
            adding_required.setAttribute("id", i+"_requiredform_id_temp");
			
	    
     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
		
		var div_for_editable_labels = document.createElement('div');
			div_for_editable_labels.setAttribute("style", "margin-left:4px; color:red; float: left; clear: both;");
			
      	edit_labels = document.createTextNode(fmc_objectL10n.fmc_labels_fields_editable);

		div_for_editable_labels.appendChild(edit_labels);  	
					
      	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width=w_field_label_size+"px";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");
			
      	var div_address = document.createElement('div');
           	div_address.setAttribute("id", i+"_div_address");
			div_address.style.cssText = "width:"+w_size+"px";
		
      	var span_addres1 = document.createElement('span');
			span_addres1.style.cssText = "float:left; width:100%;  padding-bottom: 8px; display:block";
			
      	var span_addres2 = document.createElement('span');
			span_addres2.style.cssText = "float:left; width:100%;  padding-bottom: 8px; display:block";
			
      	var span_addres3_1 = document.createElement('span');
			span_addres3_1.style.cssText = "float:left; width:48%; padding-bottom: 8px;";
		
      	var span_addres3_2 = document.createElement('span');
			span_addres3_2.style.cssText = "float:right; width:48%; padding-bottom: 8px;";
		
      	var span_addres4_1 = document.createElement('span');
			span_addres4_1.style.cssText = "float:left; width:48%; padding-bottom: 8px;";
		
      	var span_addres4_2 = document.createElement('span');
			span_addres4_2.style.cssText = "float:right; width:48%; padding-bottom: 8px;";
		
	
      	var br1 = document.createElement('br');
      	var br2 = document.createElement('br');
     	var br3 = document.createElement('br');
      	var br4 = document.createElement('br');
      
	    
      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";
	    
      	var required = document.createElement('span');
			required.setAttribute("id", i+"_required_elementform_id_temp");
			required.innerHTML = "";
			required.setAttribute("class", "required");
			required.style.verticalAlign="top";
		if(w_required=="yes")
			required.innerHTML = " *";	
			
	var street1 = document.createElement('input');
        street1.setAttribute("type", 'text');
	    street1.style.cssText = "width:100%";
	    street1.setAttribute("id", i+"_street1form_id_temp");
	    street1.setAttribute("name", i+"_street1form_id_temp");
	    street1.setAttribute("onChange", "change_value('"+i+"_street1form_id_temp')");
			
	var street1_label = document.createElement('label');
	    street1_label.setAttribute("class", "mini_label");
		street1_label.setAttribute("id", i+"_mini_label_street1");
	    street1_label.style.cssText = "display:block;";
	    street1_label.innerHTML=w_mini_labels[0];
			
	var street2 = document.createElement('input');
        street2.setAttribute("type", 'text');
		street2.style.cssText = "width:100%";
		street2.setAttribute("id", i+"_street2form_id_temp");
	   	street2.setAttribute("name", (parseInt(i)+1)+"_street2form_id_temp");
		street2.setAttribute("onChange", "change_value('"+i+"_street2form_id_temp')");

	var street2_label = document.createElement('label');
		street2_label.setAttribute("class", "mini_label");
	    street2_label.setAttribute("id", i+"_mini_label_street2");
	    street2_label.style.cssText = "display:block;";
		street2_label.innerHTML=w_mini_labels[1];
		
		
	var city = document.createElement('input');
        city.setAttribute("type", 'text');
		city.style.cssText = "width:100%";
		city.setAttribute("id", i+"_cityform_id_temp");
	   	city.setAttribute("name", (parseInt(i)+2)+"_cityform_id_temp");
		city.setAttribute("onChange", "change_value('"+i+"_cityform_id_temp')");

	var city_label = document.createElement('label');
		city_label.setAttribute("class", "mini_label");
	    city_label.setAttribute("id", i+"_mini_label_city");
	    city_label.style.cssText = "display:block;";
		city_label.innerHTML= w_mini_labels[2];
			
	var state = document.createElement('input');
        state.setAttribute("type", 'text');
		state.style.cssText = "width:100%";
		state.setAttribute("id", i+"_stateform_id_temp");
	   	state.setAttribute("name", (parseInt(i)+3)+"_stateform_id_temp");
		state.setAttribute("onChange", "change_value('"+i+"_stateform_id_temp')");

	var state_label = document.createElement('label');
		state_label.setAttribute("class", "mini_label");
	    state_label.setAttribute("id", i+"_mini_label_state");
	    state_label.style.cssText = "display:block;";
		state_label.innerHTML=w_mini_labels[3];
			

	var postal = document.createElement('input');
        postal.setAttribute("type", 'text');
		postal.style.cssText = "width:100%";
		postal.setAttribute("id", i+"_postalform_id_temp");
	   	postal.setAttribute("name", (parseInt(i)+4)+"_postalform_id_temp");
		postal.setAttribute("onChange", "change_value('"+i+"_postalform_id_temp')");

	var postal_label = document.createElement('label');
		postal_label.setAttribute("class", "mini_label");
	    postal_label.setAttribute("id", i+"_mini_label_postal");
	    postal_label.style.cssText = "display:block;";
		postal_label.innerHTML=w_mini_labels[4];
			
	var country = document.createElement('select');
        country.setAttribute("type", 'text');
		country.style.cssText = "width:100%";
		country.setAttribute("id", i+"_countryform_id_temp");
	   	country.setAttribute("name", (parseInt(i)+5)+"_countryform_id_temp");
		country.setAttribute("onChange", "change_state_input('"+i+"','form_id_temp')");

	var country_label = document.createElement('label');
		country_label.setAttribute("class", "mini_label");
	    country_label.setAttribute("id", i+"_mini_label_country");
	    country_label.style.cssText = "display:block;";
		country_label.innerHTML=w_mini_labels[5];
			
		
		var option_ = document.createElement('option');
			option_.setAttribute("value", "");
			option_.innerHTML="";
		country.appendChild(option_);
		
		coutries=[fmc_objectL10n.fmc_Afghanistan,fmc_objectL10n.fmc_Albania,fmc_objectL10n.fmc_Algeria,fmc_objectL10n.fmc_Andorra,fmc_objectL10n.fmc_Angola,fmc_objectL10n.fmc_AntiguaandBarbuda,fmc_objectL10n.fmc_Argentina,fmc_objectL10n.fmc_Armenia,fmc_objectL10n.fmc_Australia,fmc_objectL10n.fmc_Austria,fmc_objectL10n.fmc_Azerbaijan,fmc_objectL10n.fmc_Bahamas,fmc_objectL10n.fmc_Bahrain,fmc_objectL10n.fmc_Bangladesh,fmc_objectL10n.fmc_Barbados,fmc_objectL10n.fmc_Belarus,fmc_objectL10n.fmc_Belgium,fmc_objectL10n.fmc_Belize,fmc_objectL10n.fmc_Benin,fmc_objectL10n.fmc_Bhutan,fmc_objectL10n.fmc_Bolivia,fmc_objectL10n.fmc_BosniaandHerzegovina,fmc_objectL10n.fmc_Botswana,fmc_objectL10n.fmc_Brazil,fmc_objectL10n.fmc_Brunei,fmc_objectL10n.fmc_Bulgaria,fmc_objectL10n.fmc_BurkinaFaso,fmc_objectL10n.fmc_Burundi,fmc_objectL10n.fmc_Cambodia,fmc_objectL10n.fmc_Cameroon,fmc_objectL10n.fmc_Canada,fmc_objectL10n.fmc_CapeVerde,fmc_objectL10n.fmc_CentralAfricanRepublic,fmc_objectL10n.fmc_Chad,fmc_objectL10n.fmc_Chile,fmc_objectL10n.fmc_China,fmc_objectL10n.fmc_Colombi,fmc_objectL10n.fmc_Comoros,fmc_objectL10n.fmc_CongoBrazzaville,fmc_objectL10n.fmc_Congo,fmc_objectL10n.fmc_CostaRica,fmc_objectL10n.fmc_CotedIvoire,fmc_objectL10n.fmc_Croatia,fmc_objectL10n.fmc_Cuba,fmc_objectL10n.fmc_Cyprus,fmc_objectL10n.fmc_CzechRepublic,fmc_objectL10n.fmc_Denmark,fmc_objectL10n.fmc_Djibouti,fmc_objectL10n.fmc_Dominica,fmc_objectL10n.fmc_DominicanRepublic,fmc_objectL10n.fmc_EastTimorTimorTimur,fmc_objectL10n.fmc_Ecuador,fmc_objectL10n.fmc_Egypt,fmc_objectL10n.fmc_ElSalvador,fmc_objectL10n.fmc_EquatorialGuinea,fmc_objectL10n.fmc_Eritrea,fmc_objectL10n.fmc_Estonia,fmc_objectL10n.fmc_Ethiopia,fmc_objectL10n.fmc_Fiji,fmc_objectL10n.fmc_Finland,fmc_objectL10n.fmc_France,fmc_objectL10n.fmc_Gabon,fmc_objectL10n.fmc_GambiaThe,fmc_objectL10n.fmc_Georgia,fmc_objectL10n.fmc_Germany,fmc_objectL10n.fmc_Ghana,fmc_objectL10n.fmc_Greece,fmc_objectL10n.fmc_Grenada,fmc_objectL10n.fmc_Guatemala,fmc_objectL10n.fmc_Guinea,fmc_objectL10n.fmc_GuineaBissau,fmc_objectL10n.fmc_Guyana,fmc_objectL10n.fmc_Haiti,fmc_objectL10n.fmc_Honduras,fmc_objectL10n.fmc_Hungary,fmc_objectL10n.fmc_Iceland,fmc_objectL10n.fmc_India,fmc_objectL10n.fmc_Indonesia,fmc_objectL10n.fmc_Iran,fmc_objectL10n.fmc_Iraq,fmc_objectL10n.fmc_Ireland,fmc_objectL10n.fmc_Israel,fmc_objectL10n.fmc_Italy,fmc_objectL10n.fmc_Jamaica,fmc_objectL10n.fmc_Japan,fmc_objectL10n.fmc_Jordan,fmc_objectL10n.fmc_Kazakhstan,fmc_objectL10n.fmc_Kenya,fmc_objectL10n.fmc_Kiribati,fmc_objectL10n.fmc_KoreaNorth,fmc_objectL10n.fmc_KoreaSouth,fmc_objectL10n.fmc_Kuwait,fmc_objectL10n.fmc_Kyrgyzstan,fmc_objectL10n.fmc_Laos,fmc_objectL10n.fmc_Latvia,fmc_objectL10n.fmc_Lebanon,fmc_objectL10n.fmc_Lesotho,fmc_objectL10n.fmc_Liberia,fmc_objectL10n.fmc_Libya,fmc_objectL10n.fmc_Liechtenstein,fmc_objectL10n.fmc_Lithuania,fmc_objectL10n.fmc_Luxembourg,fmc_objectL10n.fmc_Macedonia,fmc_objectL10n.fmc_Madagascar,fmc_objectL10n.fmc_Malawi,fmc_objectL10n.fmc_Malaysia,fmc_objectL10n.fmc_Maldives,fmc_objectL10n.fmc_Mali,fmc_objectL10n.fmc_Malta,fmc_objectL10n.fmc_MarshallIslands,fmc_objectL10n.fmc_Mauritania,fmc_objectL10n.fmc_Mauritius,fmc_objectL10n.fmc_Mexico,fmc_objectL10n.fmc_Micronesia,fmc_objectL10n.fmc_Moldova,fmc_objectL10n.fmc_Monaco,fmc_objectL10n.fmc_Mongolia,fmc_objectL10n.fmc_Morocco,fmc_objectL10n.fmc_Mozambique,fmc_objectL10n.fmc_Myanmar,fmc_objectL10n.fmc_Namibia,fmc_objectL10n.fmc_Nauru,fmc_objectL10n.fmc_Nepa,fmc_objectL10n.fmc_Netherlands,fmc_objectL10n.fmc_NewZealand,fmc_objectL10n.fmc_Nicaragua,fmc_objectL10n.fmc_Niger,fmc_objectL10n.fmc_Nigeria,fmc_objectL10n.fmc_Norway,fmc_objectL10n.fmc_Oman,fmc_objectL10n.fmc_Pakistan,fmc_objectL10n.fmc_Palau,fmc_objectL10n.fmc_Panama,fmc_objectL10n.fmc_PapuaNewGuinea,fmc_objectL10n.fmc_Paraguay,fmc_objectL10n.fmc_Peru,fmc_objectL10n.fmc_Philippines,fmc_objectL10n.fmc_Poland,fmc_objectL10n.fmc_Portugal,fmc_objectL10n.fmc_Qatar,fmc_objectL10n.fmc_Romania,fmc_objectL10n.fmc_Russia,fmc_objectL10n.fmc_Rwanda,fmc_objectL10n.fmc_SaintKittsandNevis,fmc_objectL10n.fmc_SaintLucia,fmc_objectL10n.fmc_SaintVincent,fmc_objectL10n.fmc_Samoa,fmc_objectL10n.fmc_SanMarino,fmc_objectL10n.fmc_SaoTomeandPrincipe,fmc_objectL10n.fmc_SaudiArabia,fmc_objectL10n.fmc_Senegal,fmc_objectL10n.fmc_SerbiandMontenegro,fmc_objectL10n.fmc_Seychelles,fmc_objectL10n.fmc_SierraLeone,fmc_objectL10n.fmc_Singapore,fmc_objectL10n.fmc_Slovakia,fmc_objectL10n.fmc_Slovenia,fmc_objectL10n.fmc_SolomonIslands,fmc_objectL10n.fmc_Somalia,fmc_objectL10n.fmc_SouthAfrica,fmc_objectL10n.fmc_Spain,fmc_objectL10n.fmc_SriLanka,fmc_objectL10n.fmc_Sudan,fmc_objectL10n.fmc_Suriname,fmc_objectL10n.fmc_Swaziland,fmc_objectL10n.fmc_Sweden,fmc_objectL10n.fmc_Switzerland,fmc_objectL10n.fmc_Syria,fmc_objectL10n.fmc_Taiwan,fmc_objectL10n.fmc_Tajikistan,fmc_objectL10n.fmc_Tanzania,fmc_objectL10n.fmc_Thailand,fmc_objectL10n.fmc_Togo,fmc_objectL10n.fmc_Tonga,fmc_objectL10n.fmc_TrinidadandTobago,fmc_objectL10n.fmc_Tunisia,fmc_objectL10n.fmc_Turkey,fmc_objectL10n.fmc_Turkmenistan,fmc_objectL10n.fmc_Tuvalu,fmc_objectL10n.fmc_Uganda,fmc_objectL10n.fmc_Ukraine,fmc_objectL10n.fmc_UnitedArabEmirates,fmc_objectL10n.fmc_UnitedKingdom,fmc_objectL10n.fmc_UnitedStates,fmc_objectL10n.fmc_Uruguay,fmc_objectL10n.fmc_Uzbekistan,fmc_objectL10n.fmc_Vanuatu,fmc_objectL10n.fmc_VaticanCity,fmc_objectL10n.fmc_Venezuela,fmc_objectL10n.fmc_Vietnam,fmc_objectL10n.fmc_Yemen,fmc_objectL10n.fmc_Zambia,fmc_objectL10n.fmc_Zimbabwe];	
		for(r=0;r<coutries.length;r++)
		{
		var option_ = document.createElement('option');
			option_.setAttribute("value", coutries[r]);
			option_.innerHTML=coutries[r];
		country.appendChild(option_);
		}









	var main_td  = document.getElementById('show_table');
      
      	div_label.appendChild(label);
      	div_label.appendChild(required );
		

      	span_addres1.appendChild(street1);
      	span_addres1.appendChild(street1_label);
		
       	span_addres2.appendChild(street2);
      	span_addres2.appendChild(street2_label);
		
    	span_addres3_1.appendChild(city);		
      	span_addres3_1.appendChild(city_label);
    	span_addres3_2.appendChild(state);		
      	span_addres3_2.appendChild(state_label);
		
		
    	span_addres4_1.appendChild(postal);		
      	span_addres4_1.appendChild(postal_label);
    	span_addres4_2.appendChild(country);		
      	span_addres4_2.appendChild(country_label);
		
				
		div_address.appendChild(span_addres1);
		div_address.appendChild(span_addres2);	
		div_address.appendChild(span_addres3_1);	
		div_address.appendChild(span_addres3_2);
		div_address.appendChild(span_addres4_1);
		div_address.appendChild(span_addres4_2);
				
		
		
       	div_element.appendChild(adding_type);
       	div_element.appendChild(adding_required);
		div_element.appendChild(adding_country);
    	div_element.appendChild(div_address);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
      
      	div.appendChild(div_field);
		div.appendChild(br3);
		div.appendChild(div_for_editable_labels);
      	main_td.appendChild(div);
		
	if(w_field_label_pos=="top")
				label_top(i);
change_class(w_class, i);
refresh_attr(i, 'type_address');

		if(w_disabled_fields[0]=="yes")
			disable_fields(i,'street1');
		if(w_disabled_fields[1]=="yes")
			disable_fields(i,'street2');
		if(w_disabled_fields[2]=="yes")
			disable_fields(i,'city');
		if(w_disabled_fields[3]=="yes")
			disable_fields(i,'state');
		if(w_disabled_fields[4]=="yes")
			disable_fields(i,'postal');
		if(w_disabled_fields[5]=="yes")		
			disable_fields(i,'country');
		if(w_disabled_fields[6]=="yes")		
			disable_fields(i,'us_states');
				
		

jQuery(document).ready(function() {		
jQuery("label#"+i+"_mini_label_street1").click(function() {			

	if (jQuery(this).children('input').length == 0) {				
	var street1 = "<input type='text' class='street1' style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
	jQuery(this).html(street1);					
	jQuery("input.street1").focus();		
	jQuery("input.street1").blur(function() {	
	var value = jQuery(this).val();			
	jQuery("#"+i+"_mini_label_street1").text(value);		
	document.getElementById('el_street1_label').innerHTML=	value;	
	});		
	}	
	});		
	
	jQuery("label#"+i+"_mini_label_street2").click(function() {		
	if (jQuery(this).children('input').length == 0) {		
	var street2 = "<input type='text' class='street2'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
	jQuery(this).html(street2);					
	jQuery("input.street2").focus();		
	jQuery("input.street2").blur(function() {	
	var value = jQuery(this).val();			
	jQuery("#"+i+"_mini_label_street2").text(value);
	document.getElementById('el_street2_label').innerHTML=	value;		
	});		
	}	
	});	
	
	
	jQuery("label#"+i+"_mini_label_city").click(function() {	
	if (jQuery(this).children('input').length == 0) {	
	var city = "<input type='text' class='city'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
	jQuery(this).html(city);			
	jQuery("input.city").focus();				
	jQuery("input.city").blur(function() {			
	var value = jQuery(this).val();		
	jQuery("#"+i+"_mini_label_city").text(value);	
	document.getElementById('el_city_label').innerHTML=	value;		
	});		
	}	
	});	
	
	jQuery("label#"+i+"_mini_label_state").click(function() {		
	if (jQuery(this).children('input').length == 0) {	
	var state = "<input type='text' class='state'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";	
	jQuery(this).html(state);		
	jQuery("input.state").focus();		
	jQuery("input.state").blur(function() {		
	var value = jQuery(this).val();			
	jQuery("#"+i+"_mini_label_state").text(value);
	document.getElementById('el_state_label').innerHTML=	value;		
	});	
	}
	});		

	jQuery("label#"+i+"_mini_label_postal").click(function() {		
	if (jQuery(this).children('input').length == 0) {			
	var postal = "<input type='text' class='postal'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
	jQuery(this).html(postal);			
	jQuery("input.postal").focus();			
	jQuery("input.postal").blur(function() {			
	var value = jQuery(this).val();		
	jQuery("#"+i+"_mini_label_postal").text(value);	
	document.getElementById('el_postal_label').innerHTML=	value;		
	});	
	}
	});	
	
	
	jQuery("label#"+i+"_mini_label_country").click(function() {		
		if (jQuery(this).children('input').length == 0) {		
			var country = "<input type='text' class='country'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
			jQuery(this).html(country);		
			jQuery("input.country").focus();	
			jQuery("input.country").blur(function() {		
			var value = jQuery(this).val();			
			jQuery("#"+i+"_mini_label_country").text(value);
			document.getElementById('el_country_label').innerHTML=	value;				
			});	
		}	
	});
	});	


}

function type_submitter_mail(i, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_first_val, w_title, w_required, w_unique, w_class, w_attr_name, w_attr_value){
    document.getElementById("element_type").value="type_submitter_mail";

	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
	var edit_main_tr7  = document.createElement('tr');

	var edit_main_tr8  = document.createElement('tr');
      		

	var edit_main_tr9  = document.createElement('tr');
      		
			
	var edit_main_tr10  = document.createElement('tr');
	var edit_main_tr11  = document.createElement('tr');
      				

	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');
	
		
	var edit_main_td9 = document.createElement('td');
	var edit_main_td9_1 = document.createElement('td');
		
	var edit_main_td10 = document.createElement('td');
	var edit_main_td10_1 = document.createElement('td');
	var edit_main_td11 = document.createElement('td');
	var edit_main_td11_1 = document.createElement('td');
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
	
	var el_label_label = document.createElement('label');
	                el_label_label.setAttribute("for", "edit_for_label");
			el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
                el_label_textarea.setAttribute("id", "edit_for_label");
                el_label_textarea.setAttribute("rows", "4");
                el_label_textarea.style.cssText = "width:200px";
                el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
		el_label_textarea.innerHTML = w_field_label;
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
	
	var el_label_position_label = document.createElement('label');
	    		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
                el_label_position1.setAttribute("id", "edit_for_label_position_top");
                el_label_position1.setAttribute("type", "radio");
                
                
		el_label_position1.setAttribute("name", "edit_for_label_position");
                el_label_position1.setAttribute("onchange", "label_left("+i+")");
	Left = document.createTextNode(fmc_objectL10n.fmc_Left);
		
	var el_label_position2 = document.createElement('input');
                el_label_position2.setAttribute("id", "edit_for_label_position_left");
                el_label_position2.setAttribute("type", "radio");
                
		
                el_label_position2.setAttribute("name", "edit_for_label_position");
                el_label_position2.setAttribute("onchange", "label_top("+i+")");
	Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
				el_label_position2.setAttribute("checked", "checked");
	else
				el_label_position1.setAttribute("checked", "checked");

	var el_size_label = document.createElement('label');
	        el_size_label.setAttribute("for", "edit_for_input_size");
		el_size_label.innerHTML = fmc_objectL10n.fmc_Field_size;
	var el_size = document.createElement('input');
		   el_size.setAttribute("id", "edit_for_input_size");
		   el_size.setAttribute("type", "text");
		   el_size.setAttribute("value", w_size);
		   
			
			el_size.setAttribute("onKeyPress", "return check_isnum(event)");
            el_size.setAttribute("onKeyUp", "change_w_style('"+i+"_elementform_id_temp', this.value)");

	var el_first_value_label = document.createElement('label');
	        el_first_value_label.setAttribute("for", "el_first_value_input");
		el_first_value_label.innerHTML = fmc_objectL10n.fmc_Value_empty;
	
	var el_first_value_input = document.createElement('input');
                el_first_value_input.setAttribute("id", "el_first_value_input");
                el_first_value_input.setAttribute("type", "text");
                el_first_value_input.setAttribute("value", w_title);
                el_first_value_input.style.cssText = "width:150px;";
                el_first_value_input.setAttribute("onKeyUp", "change_input_value(this.value,'"+i+"_elementform_id_temp')");
				
	var el_style_label = document.createElement('label');
	        el_style_label.setAttribute("for", "el_style_textarea");
		el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
                el_style_textarea.setAttribute("id", "el_style_textarea");
		el_style_textarea.setAttribute("type", "text");
 		el_style_textarea.setAttribute("value", w_class);
                el_style_textarea.style.cssText = "width:200px;";
                el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");
	
	
	var el_required_label = document.createElement('label');
	        el_required_label.setAttribute("for", "el_required");
		el_required_label.innerHTML = fmc_objectL10n.fmc_Required;
	
	var el_required = document.createElement('input');
                el_required.setAttribute("id", "el_required");
                el_required.setAttribute("type", "checkbox");
                
                el_required.setAttribute("onclick", "set_required('"+i+"_required')");
	if(w_required=="yes")
			
                el_required.setAttribute("checked", "checked");

	var el_unique_label = document.createElement('label');
	    el_unique_label.setAttribute("for", "el_unique");
		el_unique_label.innerHTML = fmc_objectL10n.fmc_Allow_only_unique_values;
	
	var el_unique = document.createElement('input');
                el_unique.setAttribute("id", "el_unique");
                el_unique.setAttribute("type", "checkbox");
                
                el_unique.setAttribute("onclick", "set_unique('"+i+"_uniqueform_id_temp')");
	if(w_unique=="yes")
                el_unique.setAttribute("checked", "checked");
			
	var el_attr_label = document.createElement('label');
	                
			el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
	var el_attr_add = document.createElement('img');
                
           	el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
            	el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_text')");
	var el_attr_table = document.createElement('table');
                el_attr_table.setAttribute("id", 'attributes');
                el_attr_table.setAttribute("border", '0');
        	el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
                el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
            	el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
            	el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
            	el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	                el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
			
	var el_attr_value_label = document.createElement('label');
	                el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
	
			el_attr_name.setAttribute("type", "text");
	
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_text')");
			
		var el_attr_value = document.createElement('input');
	
			el_attr_value.setAttribute("type", "text");
	
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_text')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_text')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}

	var t  = document.getElementById('edit_table');
	
	var br = document.createElement('br');
	var br1 = document.createElement('br');
	var br2 = document.createElement('br');
	var br3 = document.createElement('br');
	var br4 = document.createElement('br');
	var br5 = document.createElement('br');
	var br6 = document.createElement('br');
	
	edit_main_td11.appendChild(el_label_disable);
	edit_main_td11_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);

	edit_main_td10.appendChild(el_label_size_label);
	edit_main_td10_1.appendChild(el_label_size);
	
	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	edit_main_td3.appendChild(el_size_label);
	edit_main_td3_1.appendChild(el_size);
	
	edit_main_td4.appendChild(el_first_value_label);
	edit_main_td4_1.appendChild(el_first_value_input);

	edit_main_td5.appendChild(el_style_label);
	edit_main_td5_1.appendChild(el_style_textarea);
	edit_main_td7.appendChild(el_required_label);
	edit_main_td7_1.appendChild(el_required);
	
	edit_main_td9.appendChild(el_unique_label);
	edit_main_td9_1.appendChild(el_unique);
	
	edit_main_td8.appendChild(el_attr_label);
	edit_main_td8.appendChild(el_attr_add);
	edit_main_td8.appendChild(br4);
	edit_main_td8.appendChild(el_attr_table);
	edit_main_td8.setAttribute("colspan", "2");
	
	edit_main_tr11.appendChild(edit_main_td11);
	edit_main_tr11.appendChild(edit_main_td11_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	
	edit_main_tr10.appendChild(edit_main_td10);
	edit_main_tr10.appendChild(edit_main_td10_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_tr7.appendChild(edit_main_td7_1);
	edit_main_tr9.appendChild(edit_main_td9);
	edit_main_tr9.appendChild(edit_main_td9_1);
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_table.appendChild(edit_main_tr11);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr10);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr4);
	edit_main_table.appendChild(edit_main_tr5);
	edit_main_table.appendChild(edit_main_tr7);
	edit_main_table.appendChild(edit_main_tr9);
	edit_main_table.appendChild(edit_main_tr8);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);

/*show table*/

	element='input';	type='text'; 
	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_submitter_mail");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
	    
	var adding_required = document.createElement("input");
            adding_required.setAttribute("type", "hidden");
            adding_required.setAttribute("value", w_required);
            adding_required.setAttribute("name", i+"_requiredform_id_temp");
            adding_required.setAttribute("id", i+"_requiredform_id_temp");
	    
	var adding_unique= document.createElement("input");
            adding_unique.setAttribute("type", "hidden");
            adding_unique.setAttribute("value", w_unique);
            adding_unique.setAttribute("name", i+"_uniqueform_id_temp");
            adding_unique.setAttribute("id", i+"_uniqueform_id_temp");
			
	var adding = document.createElement(element);
            adding.setAttribute("type", type);
		
		
		if(w_title==w_first_val)
		{
			adding.style.cssText = "width:"+w_size+"px;";
			adding.setAttribute("class", "input_deactive");
		}
		else
		{
			adding.style.cssText = "width:"+w_size+"px;";
			adding.setAttribute("class", "input_active");
		}
			adding.setAttribute("id", i+"_elementform_id_temp");
			adding.setAttribute("name", i+"_elementform_id_temp");
			adding.setAttribute("value", w_first_val);
			adding.setAttribute("title", w_title);
			
			adding.setAttribute("onFocus", "delete_value('"+i+"_elementform_id_temp')");
			adding.setAttribute("onBlur", "return_value('"+i+"_elementform_id_temp')");
			adding.setAttribute("onChange", "change_value('"+i+"_elementform_id_temp')");
			

     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
					
      
      	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width=w_field_label_size+"px";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");

      	var br1 = document.createElement('br');
      	var br2 = document.createElement('br');
     	var br3 = document.createElement('br');
      	var br4 = document.createElement('br');
      

	    
      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";
	    
      	var required = document.createElement('span');
			required.setAttribute("id", i+"_required_elementform_id_temp");
			required.innerHTML = "";
			required.setAttribute("class", "required");
			required.style.verticalAlign="top";
	if(w_required=="yes")
			required.innerHTML = " *";
      	var main_td  = document.getElementById('show_table');
      
      	div_label.appendChild(label);
      	div_label.appendChild(required);
      	div_element.appendChild(adding_type);
      	div_element.appendChild(adding_required);
      	div_element.appendChild(adding_unique);
      	div_element.appendChild(adding);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
      	
      
      	div.appendChild(div_field);
      	div.appendChild(br3);
      	main_td.appendChild(div);
	if(w_field_label_pos=="top")
				label_top(i);
change_class(w_class, i);
refresh_attr(i, 'type_text');
}

function type_recaptcha(i,w_field_label, w_field_label_size, w_field_label_pos, w_public, w_private, w_theme, w_class, w_attr_name, w_attr_value){
    document.getElementById("element_type").value="type_recaptcha";

	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');

	var edit_main_tr7  = document.createElement('tr');

	var edit_main_tr8  = document.createElement('tr');
	var edit_main_tr9 = document.createElement('tr');
	var edit_main_tr10 = document.createElement('tr');   				

	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');
		  
	var edit_main_td9 = document.createElement('td');
	var edit_main_td9_1 = document.createElement('td');
	var edit_main_td10 = document.createElement('td');
	var edit_main_td10_1 = document.createElement('td');
			  
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");

	
	var el_label_label = document.createElement('label');
	    el_label_label.setAttribute("for", "edit_for_label");
		el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
                el_label_textarea.setAttribute("id", "edit_for_label");
                el_label_textarea.setAttribute("rows", "4");
                el_label_textarea.style.cssText = "width:200px";
                el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
		el_label_textarea.innerHTML = w_field_label;
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
	
	var el_label_position_label = document.createElement('label');
	    		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
                el_label_position1.setAttribute("id", "edit_for_label_position_top");
                el_label_position1.setAttribute("type", "radio");
                
                
		el_label_position1.setAttribute("name", "edit_for_label_position");
                el_label_position1.setAttribute("onchange", "label_left("+i+")");
	Left = document.createTextNode(fmc_objectL10n.fmc_Left);
		
	var el_label_position2 = document.createElement('input');
                el_label_position2.setAttribute("id", "edit_for_label_position_left");
                el_label_position2.setAttribute("type", "radio");
                
		
                el_label_position2.setAttribute("name", "edit_for_label_position");
                el_label_position2.setAttribute("onchange", "label_top("+i+")");
	Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
				el_label_position2.setAttribute("checked", "checked");
	else
				el_label_position1.setAttribute("checked", "checked");

	var el_style_label = document.createElement('label');
	    el_style_label.setAttribute("for", "el_style_textarea");
		el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
        el_style_textarea.setAttribute("id", "el_style_textarea");
		el_style_textarea.setAttribute("type", "text");
		el_style_textarea.setAttribute("value", w_class);
        el_style_textarea.style.cssText = "width:200px;";
        el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");

	var el_public_label = document.createElement('label');
	    el_public_label.style.cssText ="color:#BA0D0D; font-weight:bold; font-size: 13px;text-decoration:underline";
		el_public_label.innerHTML = fmc_objectL10n.fmc_Public_key;
	
	var el_public_textarea = document.createElement('input');
        el_public_textarea.setAttribute("id", "public_key");
		el_public_textarea.setAttribute("type", "text");
		el_public_textarea.setAttribute("value", w_public);
        el_public_textarea.style.cssText = "width:200px;";
        el_public_textarea.setAttribute("onChange", "change_key(this.value, 'public_key')");


	var el_private_label = document.createElement('label');
	    el_private_label.style.cssText ="color:#BA0D0D; font-weight:bold; font-size: 13px; text-decoration:underline";
		el_private_label.innerHTML = fmc_objectL10n.fmc_Private_key;
	
	var el_private_textarea = document.createElement('input');
        el_private_textarea.setAttribute("id", "private_key");
		el_private_textarea.setAttribute("type", "text");
		el_private_textarea.setAttribute("value", w_private);
        el_private_textarea.style.cssText = "width:200px;";
        el_private_textarea.setAttribute("onChange", "change_key(this.value, 'private_key')");


	var el_theme_label = document.createElement('label');
	    el_theme_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_theme_label.innerHTML = fmc_objectL10n.fmc_Recaptcha_theme;
	
	var el_theme_select = document.createElement('select');
        el_theme_select.style.cssText = "width:100px;";
        el_theme_select.setAttribute("onChange", "change_key(this.value, 'theme')");
		
	var el_theme_option1 = document.createElement('option');
		el_theme_option1.value="red";
		el_theme_option1.innerHTML= fmc_objectL10n.fmc_Red;
		
	var el_theme_option2= document.createElement('option');
		el_theme_option2.value="white";
		el_theme_option2.innerHTML= fmc_objectL10n.fmc_White;
		
	var el_theme_option3= document.createElement('option');
		el_theme_option3.value="blackglass";
		el_theme_option3.innerHTML= fmc_objectL10n.fmc_Blackglass;
	
	var el_theme_option4= document.createElement('option');
		el_theme_option4.value="clean";
		el_theme_option4.innerHTML= fmc_objectL10n.fmc_Clean;
	
	el_theme_select.appendChild(el_theme_option1);
	el_theme_select.appendChild(el_theme_option2);
	el_theme_select.appendChild(el_theme_option3);
	el_theme_select.appendChild(el_theme_option4);
	
	el_theme_select.value=w_theme;
	
		
		
		

	var el_attr_label = document.createElement('label');
	                
			el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
	var el_attr_add = document.createElement('img');
                
           	el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
            	el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_recaptcha')");
	var el_attr_table = document.createElement('table');
                el_attr_table.setAttribute("id", 'attributes');
                el_attr_table.setAttribute("border", '0');
        	el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
                el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
            	el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
            	el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
            	el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	                el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
			
	var el_attr_value_label = document.createElement('label');
	                el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
	
			el_attr_name.setAttribute("type", "text");
	
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_recaptcha')");
			
		var el_attr_value = document.createElement('input');
	
			el_attr_value.setAttribute("type", "text");
	
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_recaptcha')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_recaptcha')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}
		
	var t  = document.getElementById('edit_table');
	
	var br = document.createElement('br');
	var br1 = document.createElement('br');
	var br2 = document.createElement('br');
	var br3 = document.createElement('br');
	var br4 = document.createElement('br');
	var br5 = document.createElement('br');
	var br6 = document.createElement('br');
	
	edit_main_td10.appendChild(el_label_disable);
	edit_main_td10_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);
	
	edit_main_td9.appendChild(el_label_size_label);
	edit_main_td9_1.appendChild(el_label_size);

	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	edit_main_td4.appendChild(el_style_label);
	edit_main_td4_1.appendChild(el_style_textarea);
	
	edit_main_td6.appendChild(el_public_label);
	edit_main_td6_1.appendChild(el_public_textarea);
	
	edit_main_td7.appendChild(el_private_label);
	edit_main_td7_1.appendChild(el_private_textarea);
	
	edit_main_td8.appendChild(el_theme_label);
	edit_main_td8_1.appendChild(el_theme_select);
	
	edit_main_td5.appendChild(el_attr_label);
	edit_main_td5.appendChild(el_attr_add);
	edit_main_td5.appendChild(br3);
	edit_main_td5.appendChild(el_attr_table);
	edit_main_td5.setAttribute("colspan", "2");

	/*edit_main_td4.appendChild(el_first_value_label);
	edit_main_td4.appendChild(br3);
	edit_main_td4.appendChild(el_first_value_input);*/
	
/*	edit_main_td5.appendChild(el_guidelines_label);
	edit_main_td5.appendChild(br4);
	edit_main_td5.appendChild(el_guidelines_textarea);
*/	

	edit_main_tr10.appendChild(edit_main_td10);
	edit_main_tr10.appendChild(edit_main_td10_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr9.appendChild(edit_main_td9);
	edit_main_tr9.appendChild(edit_main_td9_1);
	
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr6.appendChild(edit_main_td6_1);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_tr7.appendChild(edit_main_td7_1);
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_table.appendChild(edit_main_tr10);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr9);
	edit_main_table.appendChild(edit_main_tr2);
/*	edit_main_table.appendChild(edit_main_tr3);*/
	edit_main_table.appendChild(edit_main_tr6);
	edit_main_table.appendChild(edit_main_tr7);
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr4);
	edit_main_table.appendChild(edit_main_tr5);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);

/*show table*/

	element='img';	type='captcha'; 
		var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_recaptcha");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");

		var adding = document.createElement('div');
      	    adding.setAttribute("id", "wd_recaptchaform_id_temp");
      	    adding.setAttribute("public_key", w_public);
      	    adding.setAttribute("private_key", w_private);
      	    adding.setAttribute("theme", w_theme);
			
		var adding_text = document.createElement('span');
			adding_text.style.color="red";
			adding_text.style.fontStyle="italic";
			adding_text.innerHTML= fmc_objectL10n.fmc_Recaptcha_doesnt_display_backend;
			
		adding.appendChild(adding_text);
		
		var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
					
      	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width=w_field_label_size+"px";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");
			
		
	
      	var br1 = document.createElement('br');
      	var br2 = document.createElement('br');
     	var br3 = document.createElement('br');
      	var br4 = document.createElement('br');
      

      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";
	    
      	var main_td  = document.getElementById('show_table');
      
      	div_label.appendChild(label);
      	div_element.appendChild(adding_type);
      	div_element.appendChild(adding);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
   
      	div.appendChild(div_field);
      	div.appendChild(br3);
      	main_td.appendChild(div);
	if(w_field_label_pos=="top")
				label_top(i);
change_class(w_class, i);
refresh_attr(i, 'type_recaptcha');
}

function type_captcha(i,w_field_label, w_field_label_size, w_field_label_pos, w_digit, w_class, w_attr_name, w_attr_value){
    document.getElementById("element_type").value="type_captcha";

	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
      	
		
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
			
	var edit_main_tr7  = document.createElement('tr');
	var edit_main_tr8  = document.createElement('tr');
      				

	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
		
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
		edit_main_td7_1.style.cssText = "padding-top:10px";	
		
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');	
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
	
	var el_label_label = document.createElement('label');
	    el_label_label.setAttribute("for", "edit_for_label");
		el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
        el_label_textarea.setAttribute("id", "edit_for_label");
        el_label_textarea.setAttribute("rows", "4");
        el_label_textarea.style.cssText = "width:200px";
        el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
		el_label_textarea.innerHTML = w_field_label;
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
	
	var el_label_position_label = document.createElement('label');
		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
        el_label_position1.setAttribute("id", "edit_for_label_position_top");
        el_label_position1.setAttribute("type", "radio");
        
        
		el_label_position1.setAttribute("name", "edit_for_label_position");
        el_label_position1.setAttribute("onchange", "label_left("+i+")");
		
	Left = document.createTextNode(fmc_objectL10n.fmc_Left);
		
	var el_label_position2 = document.createElement('input');
        el_label_position2.setAttribute("id", "edit_for_label_position_left");
        el_label_position2.setAttribute("type", "radio");
        
		
        el_label_position2.setAttribute("name", "edit_for_label_position");
        el_label_position2.setAttribute("onchange", "label_top("+i+")");
	Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
		el_label_position2.setAttribute("checked", "checked");
	else
		el_label_position1.setAttribute("checked", "checked");

	var el_size_label = document.createElement('label');
	    el_size_label.setAttribute("for", "edit_for_input_size");
		el_size_label.innerHTML = fmc_objectL10n.fmc_Captcha_size;
	
	var el_captcha_digit = document.createElement('input');
        el_captcha_digit.setAttribute("id", "captcha_digit");
        el_captcha_digit.setAttribute("type", "text");
        el_captcha_digit.setAttribute("value", w_digit);
		el_captcha_digit.setAttribute("name", "captcha_digit");
 		el_captcha_digit.setAttribute("onKeyPress", "return check_isnum_3_10(event)");
        el_captcha_digit.setAttribute("onKeyUp", "change_captcha_digit(this.value, '"+i+"')");
	    el_captcha_digit.style.cssText ="margin-right:18px";

	Digits = document.createTextNode("Digits (3 - 9)");
	
	var el_style_label = document.createElement('label');
	    el_style_label.setAttribute("for", "el_style_textarea");
		el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
        el_style_textarea.setAttribute("id", "el_style_textarea");
		el_style_textarea.setAttribute("type", "text");
		el_style_textarea.setAttribute("value", w_class);
        el_style_textarea.style.cssText = "width:200px;";
        el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");

	var el_attr_label = document.createElement('label');
	    
		el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
		
	var el_attr_add = document.createElement('img');
        
        el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
        el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
        el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
        el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_captcha')");
		
	var el_attr_table = document.createElement('table');
        el_attr_table.setAttribute("id", 'attributes');
        el_attr_table.setAttribute("border", '0');
        el_attr_table.style.cssText = 'margin-left:0px';
		
	var el_attr_tr_label = document.createElement('tr');
        el_attr_tr_label.setAttribute("idi", '0');
		
	var el_attr_td_name_label = document.createElement('th');
        el_attr_td_name_label.style.cssText = 'width:100px';
		
	var el_attr_td_value_label = document.createElement('th');
        el_attr_td_value_label.style.cssText = 'width:100px';
		
	var el_attr_td_X_label = document.createElement('th');
        el_attr_td_X_label.style.cssText = 'width:10px';
		
	var el_attr_name_label = document.createElement('label');
	    el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
			
	var el_attr_value_label = document.createElement('label');
	    el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
		el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
	
			el_attr_name.setAttribute("type", "text");
	
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_captcha')");
			
		var el_attr_value = document.createElement('input');
	
			el_attr_value.setAttribute("type", "text");
	
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_captcha')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_captcha')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}
		
	var t  = document.getElementById('edit_table');
	
	var br = document.createElement('br');
	var br1 = document.createElement('br');
	var br2 = document.createElement('br');
	var br3 = document.createElement('br');
	var br4 = document.createElement('br');
	var br5 = document.createElement('br');
	var br6 = document.createElement('br');
	
	edit_main_td8.appendChild(el_label_disable);
	edit_main_td8_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);
	
	edit_main_td7.appendChild(el_label_size_label);
	edit_main_td7_1.appendChild(el_label_size);

	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	edit_main_td3.appendChild(el_size_label);
	edit_main_td3_1.appendChild(el_captcha_digit);
	edit_main_td3_1.appendChild(Digits);
	
	edit_main_td4.appendChild(el_style_label);
	edit_main_td4_1.appendChild(el_style_textarea);
	
	edit_main_td5.appendChild(el_attr_label);
	edit_main_td5.appendChild(el_attr_add);
	edit_main_td5.appendChild(br3);
	edit_main_td5.appendChild(el_attr_table);
	edit_main_td5.setAttribute("colspan", "2");

	/*edit_main_td4.appendChild(el_first_value_label);
	edit_main_td4.appendChild(br3);
	edit_main_td4.appendChild(el_first_value_input);*/
	
/*	edit_main_td5.appendChild(el_guidelines_label);
	edit_main_td5.appendChild(br4);
	edit_main_td5.appendChild(el_guidelines_textarea);
*/	

	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_tr7.appendChild(edit_main_td7_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr7);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr4);
	edit_main_table.appendChild(edit_main_tr5);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);

	
/*show table*/

	element='img';	type='captcha'; 
		var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_captcha");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");


	var adding = document.createElement(element);
           	adding.setAttribute("type", type);
           	adding.setAttribute("digit", w_digit);
           	adding.setAttribute("src", url_for_ajax + "?action=ContactFormmakerwdcaptcha&digit="+w_digit+"&i=form_id_temp");
			adding.setAttribute("id", "_wd_captchaform_id_temp");
			adding.setAttribute("class", "captcha_img");
			adding.setAttribute("onClick", "captcha_refresh('_wd_captcha','form_id_temp')");
			
   
		
	var refresh_captcha = document.createElement("div");
			refresh_captcha.setAttribute("class", "captcha_refresh");
			refresh_captcha.setAttribute("id", "_element_refreshform_id_temp");
			refresh_captcha.setAttribute("onClick", "captcha_refresh('_wd_captcha','form_id_temp')");

	var input_captcha = document.createElement("input");
           	input_captcha.setAttribute("type", "text");
			input_captcha.style.cssText = "width:"+(w_digit*10+15)+"px;";
			input_captcha.setAttribute("class", "captcha_input");
			input_captcha.setAttribute("id", "_wd_captcha_inputform_id_temp");
			input_captcha.setAttribute("name", "captcha_input");

     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
					
      	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width=w_field_label_size+"px";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");
			
	var captcha_table = document.createElement('div');
		captcha_table.style.display="table";
	
      	var captcha_tr1 = document.createElement('div');
			captcha_tr1.style.display="table-row";
      	var captcha_tr2 = document.createElement('div');
			captcha_tr2.style.display="table-row";

      	var captcha_td1 = document.createElement('div');
		captcha_td1.setAttribute("valign", 'middle');
		captcha_td1.style.display="table-cell";

      	var captcha_td2 = document.createElement('div');
  		captcha_td2.setAttribute("valign", 'middle');
		captcha_td2.style.display="table-cell";
    	var captcha_td3 = document.createElement('div');
		captcha_td3.style.display="table-cell";
	
	captcha_table.appendChild(captcha_tr1);
      	captcha_table.appendChild(captcha_tr2);
      	captcha_tr1.appendChild(captcha_td1);
      	captcha_tr1.appendChild(captcha_td2);
      	captcha_tr2.appendChild(captcha_td3);
	
      	captcha_td1.appendChild(adding);
      	captcha_td2.appendChild(refresh_captcha);
      	captcha_td3.appendChild(input_captcha);

	
	
	
      	var br1 = document.createElement('br');
      	var br2 = document.createElement('br');
     	var br3 = document.createElement('br');
      	var br4 = document.createElement('br');
      

      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";
	    
      	var main_td  = document.getElementById('show_table');
      
      	div_label.appendChild(label);
      	div_element.appendChild(adding_type);
      	div_element.appendChild(captcha_table);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);

      
      	div.appendChild(div_field);
      	div.appendChild(br3);
      	main_td.appendChild(div);
	if(w_field_label_pos=="top")
				label_top(i);
change_class(w_class, i);
refresh_attr(i, 'type_captcha');
}

function type_checkbox(i, w_field_label, w_field_label_size, w_field_label_pos, w_flow, w_choices, w_choices_checked, w_rowcol,  w_required, w_randomize, w_allow_other,w_allow_other_num, w_class, w_attr_name, w_attr_value) {

	document.getElementById("element_type").value="type_checkbox";

	delete_last_child();
/* edit table*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
	var edit_main_tr7  = document.createElement('tr');

	var edit_main_tr8  = document.createElement('tr');   		

	var edit_main_tr9  = document.createElement('tr');
			
	var edit_main_tr10 = document.createElement('tr');
	var edit_main_tr11 = document.createElement('tr');      				
	var edit_main_tr12 = document.createElement('tr');
	
	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');

		
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
		edit_main_td4_1.style.cssText = "padding-top:10px; vertical-align:top;";
      	edit_main_td4.setAttribute("id", "choices");
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
		
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');
		  
	var edit_main_td9 = document.createElement('td');
	var edit_main_td9_1 = document.createElement('td');
		
	var edit_main_td10 = document.createElement('td');
	var edit_main_td10_1 = document.createElement('td');
	
	var edit_main_td11 = document.createElement('td');
	var edit_main_td11_1 = document.createElement('td');

	var edit_main_td12 = document.createElement('td');
	var edit_main_td12_1 = document.createElement('td');
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");

	
	var el_label_label = document.createElement('label');
			        el_label_label.setAttribute("for", "edit_for_label");
			el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
                el_label_textarea.setAttribute("id", "edit_for_label");
                el_label_textarea.setAttribute("rows", "4");
                el_label_textarea.style.cssText = "width:200px;";
                el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
				el_label_textarea.innerHTML = w_field_label;
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
	
	var el_label_position_label = document.createElement('label');
			    		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
                el_label_position1.setAttribute("id", "edit_for_label_position_top");
                el_label_position1.setAttribute("type", "radio");
                
                
                el_label_position1.setAttribute("name", "edit_for_label_position");
                el_label_position1.setAttribute("onchange", "label_left("+i+")");
		Left = document.createTextNode(fmc_objectL10n.fmc_Left);
		
	var el_label_position2 = document.createElement('input');
                el_label_position2.setAttribute("id", "edit_for_label_position_left");
                el_label_position2.setAttribute("type", "radio");
                
			
                el_label_position2.setAttribute("name", "edit_for_label_position");
                el_label_position2.setAttribute("onchange", "label_top("+i+")");
		Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
	
				el_label_position2.setAttribute("checked", "checked");
	else
				el_label_position1.setAttribute("checked", "checked");
	var el_label_flow = document.createElement('label');
			        el_label_flow.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_label_flow.innerHTML = fmc_objectL10n.fmc_Relative_position;
	
	var el_flow_vertical = document.createElement('input');
                el_flow_vertical.setAttribute("id", "edit_for_flow_vertical");
                el_flow_vertical.setAttribute("type", "radio");
                el_flow_vertical.setAttribute("value", "ver");
                el_flow_vertical.setAttribute("name", "edit_for_flow");
                el_flow_vertical.setAttribute("onchange", "refresh_rowcol("+i+",'checkbox')");
		Vertical = document.createTextNode(fmc_objectL10n.fmc_Vertical);
		
	var el_flow_horizontal = document.createElement('input');
                el_flow_horizontal.setAttribute("id", "edit_for_flow_horizontal");
                el_flow_horizontal.setAttribute("type", "radio");
                el_flow_horizontal.setAttribute("value", "hor");
                el_flow_horizontal.setAttribute("name", "edit_for_flow");
                el_flow_horizontal.setAttribute("onchange", "refresh_rowcol("+i+",'checkbox')");
		Horizontal = document.createTextNode(fmc_objectL10n.fmc_Horizontal);
		
	if(w_flow=="hor")
				el_flow_horizontal.setAttribute("checked", "checked");
	else
				el_flow_vertical.setAttribute("checked", "checked");
				
	var el_rowcol_label = document.createElement('label');
	        el_rowcol_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_rowcol_label.innerHTML = fmc_objectL10n.fmc_Rows_columns;
	
	var el_rowcol_textarea = document.createElement('input');
                el_rowcol_textarea.setAttribute("id", "edit_for_rowcol");
		el_rowcol_textarea.setAttribute("type", "text");
 		el_rowcol_textarea.setAttribute("value", w_rowcol);
                el_rowcol_textarea.style.cssText = "width:200px;";
                el_rowcol_textarea.setAttribute("onChange", "refresh_rowcol('"+i+"','checkbox')");	

	
	var el_style_label = document.createElement('label');
	        el_style_label.setAttribute("for", "el_style_textarea");
		el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
                el_style_textarea.setAttribute("id", "el_style_textarea");
		el_style_textarea.setAttribute("type", "text");
 		el_style_textarea.setAttribute("value", w_class);
                el_style_textarea.style.cssText = "width:200px;";
                el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");

	var el_required_label = document.createElement('label');
	        el_required_label.setAttribute("for", "el_required");
		el_required_label.innerHTML = fmc_objectL10n.fmc_Required;
	
	var el_required = document.createElement('input');
                el_required.setAttribute("id", "el_required");
                el_required.setAttribute("type", "checkbox");
                
                el_required.setAttribute("onclick", "set_required('"+i+"_required')");
	if(w_required=="yes")
			
                el_required.setAttribute("checked", "checked");
		
		
				
	var el_randomize_label = document.createElement('label');
				el_randomize_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
				el_randomize_label.innerHTML = fmc_objectL10n.fmc_Randomize_frontend;
	
	var el_randomize = document.createElement('input');
                el_randomize.setAttribute("id", "el_randomize");
                el_randomize.setAttribute("type", "checkbox");
                el_randomize.setAttribute("value", "yes");
                el_randomize.setAttribute("onclick", "set_randomize('"+i+"_randomizeform_id_temp')");
	if(w_randomize=="yes")
			    el_randomize.setAttribute("checked", "checked");

	var el_allow_other_label = document.createElement('label');
				el_allow_other_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
				el_allow_other_label.innerHTML = fmc_objectL10n.fmc_Allow_other;
	
	var el_allow_other = document.createElement('input');
                el_allow_other.setAttribute("id", "el_allow_other");
                el_allow_other.setAttribute("type", "checkbox");
                el_allow_other.setAttribute("value", "yes");
                el_allow_other.setAttribute("onclick", "set_allow_other('"+i+"','checkbox')");
	if(w_allow_other=="yes")
			    el_allow_other.setAttribute("checked", "checked");



		
	
	var el_attr_label = document.createElement('label');
	                
			el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
	var el_attr_add = document.createElement('img');
                
           	el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
            	el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_checkbox')");
	var el_attr_table = document.createElement('table');
                el_attr_table.setAttribute("id", 'attributes');
                el_attr_table.setAttribute("border", '0');
        	el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
                el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
            	el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
            	el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
            	el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	                el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
			
	var el_attr_value_label = document.createElement('label');
	                el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
	
			el_attr_name.setAttribute("type", "text");
	
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_checkbox')");
			
		var el_attr_value = document.createElement('input');
	
			el_attr_value.setAttribute("type", "text");	
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_checkbox')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_checkbox')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
	}

	var el_choices_label = document.createElement('label');
			        el_choices_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_choices_label.innerHTML = fmc_objectL10n.fmc_Options;
	var el_choices_add = document.createElement('img');
                el_choices_add.setAttribute("id", "el_choices_add");
           		el_choices_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_choices_add.style.cssText = 'cursor:pointer;';
            	el_choices_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_choices_add.setAttribute("onClick", "add_choise('checkbox',"+i+")");
	
	var t  = document.getElementById('edit_table');
	
	var br = document.createElement('br');
	var br1 = document.createElement('br');
	var br2 = document.createElement('br');
	var br3 = document.createElement('br');
	var br4 = document.createElement('br');
	var br5 = document.createElement('br');
	var br6 = document.createElement('br');
	
	edit_main_td12.appendChild(el_label_disable);
	edit_main_td12_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);
	
	edit_main_td10.appendChild(el_label_size_label);
	edit_main_td10_1.appendChild(el_label_size);

	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);

	edit_main_td3.appendChild(el_label_flow);
	edit_main_td3_1.appendChild(el_flow_vertical);
	edit_main_td3_1.appendChild(Vertical);
	edit_main_td3_1.appendChild(br4);
	edit_main_td3_1.appendChild(el_flow_horizontal);
	edit_main_td3_1.appendChild(Horizontal);
	
	edit_main_td5.appendChild(el_required_label);
	edit_main_td5_1.appendChild(el_required);
	
	edit_main_td8.appendChild(el_randomize_label);
	edit_main_td8_1.appendChild(el_randomize);
	
	edit_main_td9.appendChild(el_allow_other_label);
	edit_main_td9_1.appendChild(el_allow_other);
	
	edit_main_td11.appendChild(el_rowcol_label);
	edit_main_td11_1.appendChild(el_rowcol_textarea);
	
	edit_main_td6.appendChild(el_style_label);
	edit_main_td6_1.appendChild(el_style_textarea);
	
	edit_main_td7.appendChild(el_attr_label);
	edit_main_td7.appendChild(el_attr_add);
	edit_main_td7.appendChild(br6);
	edit_main_td7.appendChild(el_attr_table);
	edit_main_td7.setAttribute("colspan", "2");
	
	edit_main_td4.appendChild(el_choices_label);
	edit_main_td4_1.appendChild(el_choices_add);
	
	aaa=false;
	n=w_choices.length;
	for(j=0; j<n; j++)
	{	
		var br = document.createElement('br');
			br.setAttribute("id", "br"+j);
			
		var el_choices = document.createElement('input');
			el_choices.setAttribute("id", "el_choices"+j);
			el_choices.setAttribute("type", "text");
			if(w_allow_other=="yes" && j==w_allow_other_num)
			el_choices.setAttribute("other", '1');
			el_choices.setAttribute("value", w_choices[j]);
			el_choices.setAttribute("checked", w_choices_checked[j]);
			el_choices.style.cssText =   "width:100px; margin:0; padding:0; border-width: 1px";
			el_choices.setAttribute("onKeyUp", "change_label('"+i+"_label_element"+j+"', this.value); change_in_value('"+i+"_elementform_id_temp"+j+"', this.value)");
	
		var el_choices_remove = document.createElement('img');
			el_choices_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_choices_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
		if(w_allow_other=="yes" && j==w_allow_other_num)
			el_choices_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px; display:none';
		else			
			el_choices_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			el_choices_remove.setAttribute("align", 'top');
			el_choices_remove.setAttribute("onClick", "remove_choise("+j+","+i+",'checkbox')");
			
		edit_main_td4.appendChild(br);
		edit_main_td4.appendChild(el_choices);
		edit_main_td4.appendChild(el_choices_remove);
		if(w_choices_checked[j]=='1')
			if(w_allow_other=="yes" && j==w_allow_other_num)
				aaa=true;
	
	}

	edit_main_tr12.appendChild(edit_main_td12);
	edit_main_tr12.appendChild(edit_main_td12_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr10.appendChild(edit_main_td10);
	edit_main_tr10.appendChild(edit_main_td10_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr6.appendChild(edit_main_td6_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_tr9.appendChild(edit_main_td9);
	edit_main_tr9.appendChild(edit_main_td9_1);
	edit_main_tr11.appendChild(edit_main_td11);
	edit_main_tr11.appendChild(edit_main_td11_1);
	edit_main_table.appendChild(edit_main_tr12);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr10);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr11);
	edit_main_table.appendChild(edit_main_tr6);
	edit_main_table.appendChild(edit_main_tr5);
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr9);
	edit_main_table.appendChild(edit_main_tr4);
	edit_main_table.appendChild(edit_main_tr7);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);
	
/*show table*/

	element='input';	type='checkbox'; 
	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_checkbox");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
	var adding_required = document.createElement("input");
            adding_required.setAttribute("type", "hidden");
            adding_required.setAttribute("value", w_required);
            adding_required.setAttribute("name", i+"_requiredform_id_temp");
            adding_required.setAttribute("id", i+"_requiredform_id_temp");
			
 	var adding_randomize = document.createElement("input");
            adding_randomize.setAttribute("type", "hidden");
            adding_randomize.setAttribute("value", w_randomize);
            adding_randomize.setAttribute("name", i+"_randomizeform_id_temp");			
            adding_randomize.setAttribute("id", i+"_randomizeform_id_temp");
	    
	var adding_allow_other= document.createElement("input");
            adding_allow_other.setAttribute("type", "hidden");
            adding_allow_other.setAttribute("value", w_allow_other);
            adding_allow_other.setAttribute("name", i+"_allow_otherform_id_temp");			
            adding_allow_other.setAttribute("id", i+"_allow_otherform_id_temp");
	    
	var adding_allow_other_id= document.createElement("input");
            adding_allow_other_id.setAttribute("type", "hidden");
            adding_allow_other_id.setAttribute("value", w_allow_other_num);
            adding_allow_other_id.setAttribute("name", i+"_allow_other_numform_id_temp");			
            adding_allow_other_id.setAttribute("id", i+"_allow_other_numform_id_temp");
			
	var adding_rowcol= document.createElement("input");
            adding_rowcol.setAttribute("type", "hidden");
            adding_rowcol.setAttribute("value", w_rowcol);
            adding_rowcol.setAttribute("name", i+"_rowcol_numform_id_temp");			
            adding_rowcol.setAttribute("id", i+"_rowcol_numform_id_temp");		
	    
   var div = document.createElement('div');
       	div.setAttribute("id", "main_div");
/*tbody sarqac*/
		
		
	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width=w_field_label_size+"px";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");

      	var br1 = document.createElement('br');
      	var br2 = document.createElement('br');
     	var br3 = document.createElement('br');
      	var br4 = document.createElement('br');
	/*table_little -@ sarqaca tbody table_little darela table_little_t*/
	var table_little_t = document.createElement('div');
		table_little_t.style.display="table";
			
	var table_little = document.createElement('div');
           	table_little.setAttribute("id", i+"_table_little");
			table_little.style.display="table-row-group";
	table_little_t.appendChild(table_little);
	

	    
      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";

	    
      	var required = document.createElement('span');
			required.setAttribute("id", i+"_required_elementform_id_temp");
			required.innerHTML = "";
			required.setAttribute("class", "required");
			required.style.verticalAlign="top";
	if(w_required=="yes")
			required.innerHTML = " *";

	  	var main_td  = document.getElementById('show_table');
	
      
      	div_label.appendChild(label);
      	div_label.appendChild(required);
        div_element.appendChild(adding_type);
  
        div_element.appendChild(adding_required);
        div_element.appendChild(adding_randomize);
       	div_element.appendChild(adding_allow_other);
       	div_element.appendChild(adding_allow_other_id);
		div_element.appendChild(adding_rowcol);
		div_element.appendChild(table_little_t);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
      

      	div.appendChild(div_field);
      	div.appendChild(br3);
      	main_td.appendChild(div);

		
	if(w_field_label_pos=="top")
				label_top(i);
				

change_class(w_class, i);
refresh_attr(i, 'type_checkbox');

refresh_rowcol(i, 'checkbox');

if(aaa)
{
	show_other_input(i);
}

}

function type_radio(i, w_field_label, w_field_label_size, w_field_label_pos, w_flow, w_choices, w_choices_checked, w_rowcol, w_required, w_randomize, w_allow_other, w_allow_other_num, w_class, w_attr_name, w_attr_value ){

	document.getElementById("element_type").value="type_radio";

	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
			
	var edit_main_tr7  = document.createElement('tr');
			
	var edit_main_tr8  = document.createElement('tr');
      		
	var edit_main_tr9  = document.createElement('tr');
      				
	var edit_main_tr10  = document.createElement('tr');
	var edit_main_tr11  = document.createElement('tr');
	var edit_main_tr12  = document.createElement('tr');
      				

	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');

	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
		edit_main_td4_1.style.cssText = "padding-top:10px; vertical-align:top;";
		
		edit_main_td4.setAttribute("id", "choices");
		
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
		
	var edit_main_td7 = document.createElement('td');
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');
		  
	var edit_main_td9 = document.createElement('td');
	var edit_main_td9_1 = document.createElement('td');
		
	var edit_main_td10 = document.createElement('td');
	var edit_main_td10_1 = document.createElement('td');
	
	var edit_main_td11 = document.createElement('td');
	var edit_main_td11_1 = document.createElement('td');
	
	var edit_main_td12 = document.createElement('td');
	var edit_main_td12_1 = document.createElement('td');
			
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
	
	var el_label_label = document.createElement('label');
			        el_label_label.setAttribute("for", "edit_for_label");
			el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
                el_label_textarea.setAttribute("id", "edit_for_label");
                el_label_textarea.setAttribute("rows", "4");
                el_label_textarea.style.cssText = "width:200px;";
                el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
				el_label_textarea.innerHTML = w_field_label;
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
	
	var el_label_position_label = document.createElement('label');
			    		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
                el_label_position1.setAttribute("id", "edit_for_label_position_top");
                el_label_position1.setAttribute("type", "radio");
                
                

                el_label_position1.setAttribute("name", "edit_for_label_position");
                el_label_position1.setAttribute("onchange", "label_left("+i+")");
				el_label_position1.setAttribute("checked", "checked");
		Left = document.createTextNode(fmc_objectL10n.fmc_Left);
		
	var el_label_position2 = document.createElement('input');
                el_label_position2.setAttribute("id", "edit_for_label_position_left");
                el_label_position2.setAttribute("type", "radio");

                
	

                el_label_position2.setAttribute("name", "edit_for_label_position");
                el_label_position2.setAttribute("onchange", "label_top("+i+")");
		Top = document.createTextNode(fmc_objectL10n.fmc_Top);
		
	if(w_field_label_pos=="top")
	
				el_label_position2.setAttribute("checked", "checked");
	else
				el_label_position1.setAttribute("checked", "checked");
	
	var el_label_flow = document.createElement('label');
			        el_label_flow.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_label_flow.innerHTML = fmc_objectL10n.fmc_Relative_position;

	var el_flow_vertical = document.createElement('input');
                el_flow_vertical.setAttribute("id", "edit_for_flow_vertical");
                el_flow_vertical.setAttribute("type", "radio");
                el_flow_vertical.setAttribute("value", "ver");
                el_flow_vertical.setAttribute("name", "edit_for_flow");
                el_flow_vertical.setAttribute("onchange", "refresh_rowcol("+i+",'radio')");
		Vertical = document.createTextNode(fmc_objectL10n.fmc_Vertical);
		
	var el_flow_horizontal = document.createElement('input');
            el_flow_horizontal.setAttribute("id", "edit_for_flow_horizontal");
            el_flow_horizontal.setAttribute("type", "radio");
            el_flow_horizontal.setAttribute("value", "hor");
            el_flow_horizontal.setAttribute("name", "edit_for_flow");
            el_flow_horizontal.setAttribute("onchange", "refresh_rowcol("+i+",'radio')");
		Horizontal = document.createTextNode(fmc_objectL10n.fmc_Horizontal);
		
	if(w_flow=="hor")
				el_flow_horizontal.setAttribute("checked", "checked");
	else
				el_flow_vertical.setAttribute("checked", "checked");
	

	var el_rowcol_label = document.createElement('label');
	        el_rowcol_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_rowcol_label.innerHTML = fmc_objectL10n.fmc_Rows_columns;
	
	var el_rowcol_textarea = document.createElement('input');
        el_rowcol_textarea.setAttribute("id", "edit_for_rowcol");
		el_rowcol_textarea.setAttribute("type", "text");
 		el_rowcol_textarea.setAttribute("value", w_rowcol);
        el_rowcol_textarea.style.cssText = "width:200px;";
                el_rowcol_textarea.setAttribute("onChange", "refresh_rowcol('"+i+"','radio')");	

	
	var el_style_label = document.createElement('label');
	    el_style_label.setAttribute("for", "el_style_textarea");
		el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
        el_style_textarea.setAttribute("id", "el_style_textarea");
		el_style_textarea.setAttribute("type", "text");
		el_style_textarea.setAttribute("value", w_class);
        el_style_textarea.style.cssText = "width:200px;";
        el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");
	
	var el_required_label = document.createElement('label');
	        el_required_label.setAttribute("for", "el_required");
		el_required_label.innerHTML = fmc_objectL10n.fmc_Required;
	
	var el_required = document.createElement('input');
                el_required.setAttribute("id", "el_required");
                el_required.setAttribute("type", "checkbox");
                
                el_required.setAttribute("onclick", "set_required('"+i+"_required')");
	if(w_required=="yes")
			
                el_required.setAttribute("checked", "checked");

				
	var el_randomize_label = document.createElement('label');
				el_randomize_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
				el_randomize_label.innerHTML = fmc_objectL10n.fmc_Randomize_frontend;
	
	var el_randomize = document.createElement('input');
                el_randomize.setAttribute("id", "el_randomize");
                el_randomize.setAttribute("type", "checkbox");
                el_randomize.setAttribute("value", "yes");
                el_randomize.setAttribute("onclick", "set_randomize('"+i+"_randomizeform_id_temp')");
	if(w_randomize=="yes")
			    el_randomize.setAttribute("checked", "checked");

	var el_allow_other_label = document.createElement('label');
				el_allow_other_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
				el_allow_other_label.innerHTML = fmc_objectL10n.fmc_Allow_other;
	
	var el_allow_other = document.createElement('input');
                el_allow_other.setAttribute("id", "el_allow_other");
                el_allow_other.setAttribute("type", "checkbox");
                el_allow_other.setAttribute("value", "yes");
                el_allow_other.setAttribute("onclick", "set_allow_other('"+i+"','radio')");
	if(w_allow_other=="yes")
			    el_allow_other.setAttribute("checked", "checked");




	var el_attr_label = document.createElement('label');
	                
			el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
	var el_attr_add = document.createElement('img');
                
           	el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
            	el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_checkbox')");
	var el_attr_table = document.createElement('table');
                el_attr_table.setAttribute("id", 'attributes');
                el_attr_table.setAttribute("border", '0');
        	el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
                el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
            	el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
            	el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
            	el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	                el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
			
	var el_attr_value_label = document.createElement('label');
	                el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
	
			el_attr_name.setAttribute("type", "text");
	
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_checkbox')");
			
		var el_attr_value = document.createElement('input');
	
			el_attr_value.setAttribute("type", "text");
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_checkbox')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_checkbox')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}

	var el_choices_label = document.createElement('label');
			        el_choices_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_choices_label.innerHTML = fmc_objectL10n.fmc_Options;

	
	var el_choices_add = document.createElement('img');
                el_choices_add.setAttribute("id", "el_choices_add");
           	el_choices_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_choices_add.style.cssText = 'cursor:pointer;';
            	el_choices_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_choices_add.setAttribute("onClick", "add_choise('radio',"+i+")");
				
	var t  = document.getElementById('edit_table');
	
	var br = document.createElement('br');
	var br1 = document.createElement('br');
	var br2 = document.createElement('br');
	var br3 = document.createElement('br');
	var br4 = document.createElement('br');
	var br5 = document.createElement('br');
	var br6 = document.createElement('br');
	
	edit_main_td12.appendChild(el_label_disable);
	edit_main_td12_1.appendChild(el_input_disable);
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);
	
	edit_main_td10.appendChild(el_label_size_label);
	edit_main_td10_1.appendChild(el_label_size);

	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	edit_main_td3.appendChild(el_label_flow);
	edit_main_td3_1.appendChild(el_flow_vertical);
	edit_main_td3_1.appendChild(Vertical);
	edit_main_td3_1.appendChild(br4);
	edit_main_td3_1.appendChild(el_flow_horizontal);
	edit_main_td3_1.appendChild(Horizontal);
	
	edit_main_td11.appendChild(el_rowcol_label);
	edit_main_td11_1.appendChild(el_rowcol_textarea);

	edit_main_td6.appendChild(el_style_label);
	edit_main_td6_1.appendChild(el_style_textarea);
	
	edit_main_td5.appendChild(el_required_label);
	edit_main_td5_1.appendChild(el_required);
	
	edit_main_td8.appendChild(el_randomize_label);
	edit_main_td8_1.appendChild(el_randomize);
	
	edit_main_td9.appendChild(el_allow_other_label);
	edit_main_td9_1.appendChild(el_allow_other);
	
	edit_main_td7.appendChild(el_attr_label);
	edit_main_td7.appendChild(el_attr_add);
	edit_main_td7.appendChild(br6);
	edit_main_td7.appendChild(el_attr_table);
	edit_main_td7.setAttribute("colspan", "2");
	
	edit_main_td4.appendChild(el_choices_label);
	edit_main_td4_1.appendChild(el_choices_add);

				aaa=false;
	
	n=w_choices.length;
	for(j=0; j<n; j++)
	{	
		var br = document.createElement('br');
			br.setAttribute("id", "br"+j);
			
		var el_choices = document.createElement('input');
			el_choices.setAttribute("id", "el_choices"+j);
			el_choices.setAttribute("type", "text");
			if(w_allow_other=="yes" && j==w_allow_other_num)
			el_choices.setAttribute("other", '1');
			el_choices.setAttribute("value", w_choices[j]);
			el_choices.setAttribute("checked", w_choices_checked[j]);
			el_choices.style.cssText =   "width:100px; margin:0; padding:0; border-width: 1px";
			el_choices.setAttribute("onKeyUp", "change_label('"+i+"_label_element"+j+"', this.value); change_in_value('"+i+"_elementform_id_temp"+j+"', this.value)");
	
		var el_choices_remove = document.createElement('img');
			el_choices_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_choices_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
		if(w_allow_other=="yes" && j==w_allow_other_num)
			el_choices_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px; display:none';
		else			
			el_choices_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			el_choices_remove.setAttribute("align", 'top');
			el_choices_remove.setAttribute("onClick", "remove_choise("+j+","+i+",'radio')");
			
		edit_main_td4.appendChild(br);
		edit_main_td4.appendChild(el_choices);
		edit_main_td4.appendChild(el_choices_remove);
		if(w_choices_checked[j]=='1')
			if(w_allow_other=="yes" && j==w_allow_other_num)
				aaa=true;
	
	}

	edit_main_tr12.appendChild(edit_main_td12);
	edit_main_tr12.appendChild(edit_main_td12_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr10.appendChild(edit_main_td10);
	edit_main_tr10.appendChild(edit_main_td10_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr6.appendChild(edit_main_td6_1);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_tr9.appendChild(edit_main_td9);
	edit_main_tr9.appendChild(edit_main_td9_1);
	edit_main_tr11.appendChild(edit_main_td11);
	edit_main_tr11.appendChild(edit_main_td11_1);
	edit_main_table.appendChild(edit_main_tr12);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr10);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr11);
	edit_main_table.appendChild(edit_main_tr6);
	edit_main_table.appendChild(edit_main_tr5);
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr9);
	edit_main_table.appendChild(edit_main_tr4);
	edit_main_table.appendChild(edit_main_tr7);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);
	
/*show table*/

	element='input';	type='radio'; 
		var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_radio");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
	var adding_required = document.createElement("input");
            adding_required.setAttribute("type", "hidden");
            adding_required.setAttribute("value", w_required);
            adding_required.setAttribute("name", i+"_requiredform_id_temp");			
            adding_required.setAttribute("id", i+"_requiredform_id_temp");
	    
	var adding_randomize = document.createElement("input");
            adding_randomize.setAttribute("type", "hidden");
            adding_randomize.setAttribute("value", w_randomize);
            adding_randomize.setAttribute("name", i+"_randomizeform_id_temp");			
            adding_randomize.setAttribute("id", i+"_randomizeform_id_temp");
	    
	var adding_allow_other= document.createElement("input");
            adding_allow_other.setAttribute("type", "hidden");
            adding_allow_other.setAttribute("value", w_allow_other);
            adding_allow_other.setAttribute("name", i+"_allow_otherform_id_temp");			
            adding_allow_other.setAttribute("id", i+"_allow_otherform_id_temp");
	 
	var adding_rowcol= document.createElement("input");
            adding_rowcol.setAttribute("type", "hidden");
            adding_rowcol.setAttribute("value", w_rowcol);
            adding_rowcol.setAttribute("name", i+"_rowcol_numform_id_temp");			
            adding_rowcol.setAttribute("id", i+"_rowcol_numform_id_temp");
	
	 
     var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
			
	var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width=w_field_label_size+"px";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");

      	var br1 = document.createElement('br');
      	var br2 = document.createElement('br');
     	var br3 = document.createElement('br');
      	var br4 = document.createElement('br');
/*tbody sarqac*/
		var table_little_t = document.createElement('div');
			table_little_t.style.display="table";
			
		var table_little = document.createElement('div');
           	table_little.setAttribute("id", i+"_table_little");
			table_little.style.display="table-row-group";
			
		table_little_t.appendChild(table_little);
	
      	var tr_little1 = document.createElement('div');
	        tr_little1.setAttribute("id", i+"_element_tr1");
			tr_little1.style.display="table-row";
		
      	var tr_little2 = document.createElement('div');
 	        tr_little2.setAttribute("id", i+"_element_tr2");
			tr_little2.style.display="table-row";
			
      	var td_little1 = document.createElement('div');
         	td_little1.setAttribute("valign", 'top');
           	td_little1.setAttribute("id", i+"_td_little1");
			td_little1.style.display="table-cell";
			
      	var td_little2 = document.createElement('div');
        	td_little2.setAttribute("valign", 'top');
           	td_little2.setAttribute("id", i+"_td_little2");
			td_little2.style.display="table-cell";
			

	    
      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";
	    
      	var required = document.createElement('span');
			required.setAttribute("id", i+"_required_elementform_id_temp");
			required.innerHTML = "";
			required.setAttribute("class", "required");
			required.style.verticalAlign="top";
	if(w_required=="yes")
			required.innerHTML = " *";
	    
      	var main_td  = document.getElementById('show_table');
	
      
      	div_label.appendChild(label);
      	div_label.appendChild(required);
       	div_element.appendChild(adding_type);
	
       	div_element.appendChild(adding_required);
       	div_element.appendChild(adding_randomize);
       	div_element.appendChild(adding_allow_other);
		div_element.appendChild(adding_rowcol);
		div_element.appendChild(table_little_t);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
  
      
      	div.appendChild(div_field);
      	div.appendChild(br3);
      	main_td.appendChild(div);


		if(w_field_label_pos=="top")
					label_top(i);
		
				
change_class(w_class, i);
refresh_attr(i, 'type_checkbox');

refresh_rowcol(i, 'radio');

if(aaa)
{
	show_other_input(i);
}
}



function type_own_select(i, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_choices, w_choices_checked, w_required, w_class, w_attr_name, w_attr_value, w_choices_disabled){
	document.getElementById("element_type").value="type_own_select";
	delete_last_child();
/* edit table	*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');
	var edit_main_tr7  = document.createElement('tr');
	var edit_main_tr8  = document.createElement('tr');
	var edit_main_tr9  = document.createElement('tr');
	
	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');
	var edit_main_td2_1 = document.createElement('td');
	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
		edit_main_td3_1.style.cssText = "padding-top:10px; vertical-align:top;";
		edit_main_td3.setAttribute("id", "choices");
		
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
	var edit_main_td7 = document.createElement('td');
		edit_main_td7.style.cssText = "padding-top:10px;";
	var edit_main_td7_1 = document.createElement('td');
	var edit_main_td8 = document.createElement('td');
		edit_main_td8.style.cssText = "padding-top:10px;";
	var edit_main_td8_1 = document.createElement('td');
		edit_main_td8_1.style.cssText = "padding-top:10px";	
		
	var edit_main_td9 = document.createElement('td');
		edit_main_td9.style.cssText = "padding-top:10px;";
	var edit_main_td9_1 = document.createElement('td');
		edit_main_td9_1.style.cssText = "padding-top:10px";	
		
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
		
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");
	
		  
	var el_label_label = document.createElement('label');
			        el_label_label.setAttribute("for", "edit_for_label");
			el_label_label.innerHTML = fmc_objectL10n.fmc_Field_label;
	
	var el_label_textarea = document.createElement('textarea');
                el_label_textarea.setAttribute("id", "edit_for_label");
                el_label_textarea.setAttribute("rows", "4");
                el_label_textarea.style.cssText = "width:200px;";
                el_label_textarea.setAttribute("onKeyUp", "change_label('"+i+"_element_labelform_id_temp', this.value)");
				el_label_textarea.innerHTML = w_field_label;
	
	var el_label_size_label = document.createElement('label');
	    el_label_size_label.setAttribute("for", "edit_for_label_size");
		el_label_size_label.innerHTML = fmc_objectL10n.fmc_Field_label_size;
		
	var el_label_size = document.createElement('input');
	    el_label_size.setAttribute("id", "edit_for_label_size");
	    el_label_size.setAttribute("type", "text");
	    el_label_size.setAttribute("value", w_field_label_size);
		
		el_label_size.setAttribute("onKeyPress", "return check_isnum(event)");
        el_label_size.setAttribute("onKeyUp", "change_w_style('"+i+"_label_sectionform_id_temp', this.value)");
	
	var el_label_position_label = document.createElement('label');
			    		el_label_position_label.innerHTML = fmc_objectL10n.fmc_Field_label_position;
	
	var el_label_position1 = document.createElement('input');
                el_label_position1.setAttribute("id", "edit_for_label_position_top");
                el_label_position1.setAttribute("type", "radio");
                
                

                el_label_position1.setAttribute("name", "edit_for_label_position");
                el_label_position1.setAttribute("onchange", "label_left("+i+")");
		el_label_position1.setAttribute("checked", "checked");
		Left = document.createTextNode(fmc_objectL10n.fmc_Left);
		
	var el_label_position2 = document.createElement('input');
                el_label_position2.setAttribute("id", "edit_for_label_position_left");
                el_label_position2.setAttribute("type", "radio");
                
	

                el_label_position2.setAttribute("name", "edit_for_label_position");
                el_label_position2.setAttribute("onchange", "label_top("+i+")");
		Top = document.createTextNode(fmc_objectL10n.fmc_Top);
	
	if(w_field_label_pos=="top")
	
				el_label_position2.setAttribute("checked", "checked");
	else
				el_label_position1.setAttribute("checked", "checked");
	
	var el_size_label = document.createElement('label');
	        el_size_label.setAttribute("for", "edit_for_input_size");
		el_size_label.innerHTML = fmc_objectL10n.fmc_Field_size;
	var el_size = document.createElement('input');
		   el_size.setAttribute("id", "edit_for_input_size");
		   el_size.setAttribute("type", "text");
		   el_size.setAttribute("value", w_size);
		   
			
			el_size.setAttribute("onKeyPress", "return check_isnum(event)");
            el_size.setAttribute("onKeyUp", "change_w_style('"+i+"_elementform_id_temp', this.value)");
	
	
	var el_style_label = document.createElement('label');
	        el_style_label.setAttribute("for", "el_style_textarea");
		el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
                el_style_textarea.setAttribute("id", "el_style_textarea");
		el_style_textarea.setAttribute("type", "text");
		el_style_textarea.setAttribute("value", w_class);
                el_style_textarea.style.cssText = "width:200px;";
                el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");
	
	var el_required_label = document.createElement('label');
	        el_required_label.setAttribute("for", "el_required");
		el_required_label.innerHTML = fmc_objectL10n.fmc_Required;
	
	var el_required = document.createElement('input');
                el_required.setAttribute("id", "el_required");
                el_required.setAttribute("type", "checkbox");
                
                el_required.setAttribute("onclick", "set_required('"+i+"_required')");
	if(w_required=="yes")
			
                el_required.setAttribute("checked", "checked");
	
	var el_attr_label = document.createElement('label');
	                
			el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
	var el_attr_add = document.createElement('img');
                
           	el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
            	el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_text')");
	var el_attr_table = document.createElement('table');
                el_attr_table.setAttribute("id", 'attributes');
                el_attr_table.setAttribute("border", '0');
        	el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
                el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
            	el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
            	el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
            	el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	                el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
			
	var el_attr_value_label = document.createElement('label');
	                el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
	
			el_attr_name.setAttribute("type", "text");
	
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_text')");
			
		var el_attr_value = document.createElement('input');
	
			el_attr_value.setAttribute("type", "text");
	
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_text')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_text')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}
		
	var el_choices_label = document.createElement('label');
	        el_choices_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_choices_label.innerHTML = fmc_objectL10n.fmc_Options;
	var el_choices_add = document.createElement('img');
                el_choices_add.setAttribute("id", "el_choices_add");
           	el_choices_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_choices_add.style.cssText = 'cursor:pointer;';
            	el_choices_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_choices_add.setAttribute("onClick", "add_choise('select',"+i+")");

	var el_choices_important = document.createElement('div');			
	    el_choices_important.style.cssText = 'color:red; padding:14px';
		el_choices_important.innerHTML = fmc_objectL10n.fmc_Check_emptyvalue_checkbox;




	var t  = document.getElementById('edit_table');
	
	var br = document.createElement('br');
	var br1 = document.createElement('br');
	var br2 = document.createElement('br');
	var br3 = document.createElement('br');
        br3.setAttribute("id", "br1");
	var br4 = document.createElement('br');
        br4.setAttribute("id", "br2");
	var br5 = document.createElement('br');
	var br6 = document.createElement('br');
	
	edit_main_td9.appendChild(el_label_disable);
	edit_main_td9_1.appendChild(el_input_disable);
	
	edit_main_td1.appendChild(el_label_label);
	edit_main_td1_1.appendChild(el_label_textarea);
	
	edit_main_td8.appendChild(el_label_size_label);
	edit_main_td8_1.appendChild(el_label_size);

	edit_main_td2.appendChild(el_label_position_label);
	edit_main_td2_1.appendChild(el_label_position1);
	edit_main_td2_1.appendChild(Left);
	edit_main_td2_1.appendChild(br2);
	edit_main_td2_1.appendChild(el_label_position2);
	edit_main_td2_1.appendChild(Top);
	
	edit_main_td6.appendChild(el_style_label);
	edit_main_td6_1.appendChild(el_style_textarea);
	
	edit_main_td7.appendChild(el_attr_label);
	edit_main_td7.appendChild(el_attr_add);
	edit_main_td7.appendChild(br3);
	edit_main_td7.appendChild(el_attr_table);
	edit_main_td7.setAttribute("colspan", "2");
	edit_main_td4.appendChild(el_required_label);
	edit_main_td4_1.appendChild(el_required);
	
	edit_main_td5.appendChild(el_size_label);
	edit_main_td5_1.appendChild(el_size);
	
	edit_main_td3.appendChild(el_choices_label);
	edit_main_td3_1.appendChild(el_choices_add);
	edit_main_td3_1.appendChild(el_choices_important);
	
	var div_ = document.createElement('div');
			div_.style.cssText = 'border-bottom:1px dotted black; width: 248px;';
		var br = document.createElement('br');
		
		var el_choices_mini_label = document.createElement('b');
			el_choices_mini_label.innerHTML= fmc_objectL10n.fmc_Option_name;
			el_choices_mini_label.style.cssText='padding-right: 20px; padding-left: 20px; font-size:9px';
			
		var el_choices_price_mini_label = document.createElement('b');
			el_choices_price_mini_label.innerHTML= fmc_objectL10n.fmc_Price;
			el_choices_price_mini_label.style.cssText='padding-right: 15px; padding-left: 15px;  font-size:9px';
	
		var el_choices_remove_mini_label = document.createElement('b');
			el_choices_remove_mini_label.innerHTML= fmc_objectL10n.fmc_Empty_value;
			el_choices_remove_mini_label.style.cssText='padding-right: 2px; padding-left: 2px; font-size:9px';
			
		var el_choices_dis_mini_label = document.createElement('b');
			el_choices_dis_mini_label.innerHTML= fmc_objectL10n.fmc_Delete;
			el_choices_dis_mini_label.style.cssText='padding-left: 2px; padding-right: 2px; font-size:9px';
			
		div_.appendChild(br);
		div_.appendChild(el_choices_mini_label);
		
		div_.appendChild(el_choices_remove_mini_label);
		div_.appendChild(el_choices_dis_mini_label);
		edit_main_td3.appendChild(div_);

	
	
	n=w_choices.length;
	for(j=0; j<n; j++)
	{	
		var br = document.createElement('br');
		br.setAttribute("id", "br"+j);
		var el_choices = document.createElement('input');
			el_choices.setAttribute("id", "el_option"+j);
			el_choices.setAttribute("type", "text");
			el_choices.setAttribute("value", w_choices[j]);
			el_choices.style.cssText =   "width:100px; margin:0; padding:0; border-width: 1px";
			el_choices.setAttribute("onKeyUp", "change_label('"+i+"_option"+j+"', this.value)");
	
		var el_choices_remove = document.createElement('img');
			el_choices_remove.setAttribute("id", "el_option"+j+"_remove");
			el_choices_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_choices_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			el_choices_remove.setAttribute("align", 'top');
			el_choices_remove.setAttribute("onClick", "remove_option("+j+","+i+")");
			
		var el_choices_dis = document.createElement('input');
			el_choices_dis.setAttribute("type", 'checkbox');
			el_choices_dis.setAttribute("title", fmc_objectL10n.fmc_Empty_value);
			el_choices_dis.setAttribute("id", "el_option"+j+"_dis");
			el_choices_dis.setAttribute("onClick", "dis_option('"+i+"_option"+j+"', this.checked)");
			el_choices_dis.style.cssText ="vertical-align: middle; margin-left:24px; margin-right:24px;";
			if(w_choices_disabled[j])
				el_choices_dis.setAttribute("checked", "checked");
			
		edit_main_td3.appendChild(br);
		edit_main_td3.appendChild(el_choices);
		edit_main_td3.appendChild(el_choices_dis);
		edit_main_td3.appendChild(el_choices_remove);
	
	}

	edit_main_tr9.appendChild(edit_main_td9);
	edit_main_tr9.appendChild(edit_main_td9_1);
	edit_main_tr1.appendChild(edit_main_td1);
	edit_main_tr1.appendChild(edit_main_td1_1);
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_tr2.appendChild(edit_main_td2);
	edit_main_tr2.appendChild(edit_main_td2_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr6.appendChild(edit_main_td6_1);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr7.appendChild(edit_main_td7);
	edit_main_tr7.appendChild(edit_main_td7_1);
	
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	edit_main_table.appendChild(edit_main_tr9);
	edit_main_table.appendChild(edit_main_tr1);
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr5);
	edit_main_table.appendChild(edit_main_tr6);
	edit_main_table.appendChild(edit_main_tr4);
	
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr7);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);
	
/*show table*/
	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_own_select");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
	    
	var adding_required = document.createElement("input");
            adding_required.setAttribute("type", "hidden");
            adding_required.setAttribute("value", w_required);
            adding_required.setAttribute("name", i+"_requiredform_id_temp");
			
            adding_required.setAttribute("id", i+"_requiredform_id_temp");
	    
     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
			
		var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
			div_label.style.width=w_field_label_size+"px";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			

      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");

      	var br1 = document.createElement('br');
      	var br2 = document.createElement('br');
     	var br3 = document.createElement('br');
      	var br4 = document.createElement('br');
		
	var table_little = document.createElement('div');
           	table_little.setAttribute("id", i+"_table_little");
			table_little.style.display="table";
			
      	var tr_little1 = document.createElement('div');
	        tr_little1.setAttribute("id", i+"_element_tr1");
			tr_little1.style.display="table-row";
		
      	var tr_little2 = document.createElement('div');
 	        tr_little2.setAttribute("id", i+"_element_tr2");
			tr_little2.style.display="table-row";
			
      	var td_little1 = document.createElement('div');
         	td_little1.setAttribute("valign", 'top');
           	td_little1.setAttribute("id", i+"_td_little1");
			td_little1.style.display="table-cell";
			
      	var td_little2 = document.createElement('div');
        	td_little2.setAttribute("valign", 'top');
           	td_little2.setAttribute("id", i+"_td_little2");
			td_little2.style.display="table-cell";
			
   
      	var label = document.createElement('span');
			label.setAttribute("id", i+"_element_labelform_id_temp");
			label.innerHTML = w_field_label;
			label.setAttribute("class", "label");
			label.style.verticalAlign="top";
	    
      	var required = document.createElement('span');
			required.setAttribute("id", i+"_required_elementform_id_temp");
			required.innerHTML = "";
			required.setAttribute("class", "required");
			required.style.verticalAlign="top";
	if(w_required=="yes")
			required.innerHTML = " *";
	var select_ = document.createElement('select');
		select_.setAttribute("id", i+"_elementform_id_temp");
		select_.setAttribute("name", i+"_elementform_id_temp");
		select_.style.cssText = "width:"+w_size+"px";
		select_.setAttribute("onchange", "set_select(this)");
		
	for(j=0; j<n; j++)
	{      	
		var option = document.createElement('option');
		option.setAttribute("id", i+"_option"+j);
	if(w_choices_disabled[j])
		option.value="";
	else
		option.setAttribute("value", w_choices[j]);
		
		option.setAttribute("onselect", "set_select('"+i+"_option"+j+"')");
           	option.innerHTML = w_choices[j];
	if(w_choices_checked[j]==1)
		option.setAttribute("selected", "selected");
		select_.appendChild(option);
	}			
	
    
      	var main_td  = document.getElementById('show_table');
	
      
      	div_label.appendChild(label);
      	div_label.appendChild(required);
	div_element.appendChild(adding_type);
	
	div_element.appendChild(adding_required);
      	div_element.appendChild(select_);
      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
      	
      
      	div.appendChild(div_field);
      	div.appendChild(br3);
      	main_td.appendChild(div);
	
	if(w_field_label_pos=="top")
				label_top(i);
change_class(w_class, i);
refresh_attr(i, 'type_text');
}





function type_map(i, w_center_x, w_center_y, w_long, w_lat, w_zoom, w_width, w_height, w_class, w_info, w_attr_name, w_attr_value){
    document.getElementById("element_type").value="type_map";
	delete_last_child();
/*edit table*/
	var edit_div  = document.createElement('div');
		edit_div.setAttribute("id", "edit_div");
		edit_div.setAttribute("style", "padding-left:25px; padding-right:10px;  padding-top:0px; padding-bottom:0px; margin-top:10px;");
		
	var edit_main_table  = document.createElement('table');
		edit_main_table.setAttribute("id", "edit_main_table");
		edit_main_table.setAttribute("cellpadding", "0");
		edit_main_table.setAttribute("cellspacing", "0");
		
	var edit_main_tr1  = document.createElement('tr');
	var edit_main_tr2  = document.createElement('tr');
	var edit_main_tr3  = document.createElement('tr');
	var edit_main_tr4  = document.createElement('tr');
	var edit_main_tr5  = document.createElement('tr');
	var edit_main_tr6  = document.createElement('tr');

	var edit_main_tr7  = document.createElement('tr');
	var edit_main_tr8  = document.createElement('tr');

	var edit_main_td1 = document.createElement('td');
	var edit_main_td1_1 = document.createElement('td');
	var edit_main_td2 = document.createElement('td');


	var edit_main_td3 = document.createElement('td');
	var edit_main_td3_1 = document.createElement('td');
	var edit_main_td4 = document.createElement('td');
	var edit_main_td4_1 = document.createElement('td');
	var edit_main_td5 = document.createElement('td');
	var edit_main_td5_1 = document.createElement('td');
	var edit_main_td6 = document.createElement('td');
	var edit_main_td6_1 = document.createElement('td');
		
				
	var edit_main_td7 = document.createElement('td');
		edit_main_td7.setAttribute("colspan", "4");
		edit_main_td7.setAttribute("id", "markers");
		
	var edit_main_td8 = document.createElement('td');
	var edit_main_td8_1 = document.createElement('td');	
		
	
	
	var center1 = document.createElement('p');
        center1.setAttribute("id", "center1");
		center1.innerHTML= fmc_objectL10n.fmc_Drag_change_position;
	
	var el_label_disable = document.createElement('label');
	    el_label_disable.setAttribute("for", "edit_for_disable");
		el_label_disable.innerHTML = fmc_objectL10n.fmc_Enable_field;
		
	var el_input_disable = document.createElement('input');
        el_input_disable.setAttribute("id", "edit_for_disable");
        el_input_disable.setAttribute("type", "checkbox");
		el_input_disable.setAttribute("name", "edit_for_disable");
        el_input_disable.setAttribute("onchange", "disable_form_field("+i+")");
	
	if(!document.getElementById('wdform_field'+i).parentNode.getAttribute('disabled'))
		el_input_disable.setAttribute("checked", "checked");	
		  
	var el_label_location = document.createElement('label');
	    el_label_location.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_label_location.innerHTML = fmc_objectL10n.fmc_Location;
		
	var el_img_add_marker = document.createElement('img');
        el_img_add_marker.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
	    el_img_add_marker.style.cssText ="cursor:pointer";
        el_img_add_marker.setAttribute("onClick", "add_marker('"+i+"', -1)");
		
	/*var el_info_label = document.createElement('label');
	    el_info_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_info_label.innerHTML = "Marker Info";
	*/
	var el_label_map_size = document.createElement('label');
	    el_label_map_size.style.cssText ="color:#00aeef; font-weight:bold; font-size: 13px";
		el_label_map_size.innerHTML = fmc_objectL10n.fmc_Map_size;
	
	var el_map_width = document.createElement('input');
        el_map_width.setAttribute("type", "text");
        el_map_width.setAttribute("value", w_width);
        el_map_width.style.cssText ="margin-left:18px";
 		el_map_width.setAttribute("onKeyPress", "return check_isnum(event)");
        el_map_width.setAttribute("onKeyUp", "change_w_style('"+i+"_elementform_id_temp', this.value);");

	Width = document.createTextNode(fmc_objectL10n.fmc_Width);
		
	var el_map_height = document.createElement('input');
        el_map_height.setAttribute("type", "text");
        el_map_height.setAttribute("value", w_height);
		el_map_height.style.cssText = "margin-left:15px";
      	el_map_height.setAttribute("onKeyPress", "return check_isnum(event)");
	    el_map_height.setAttribute("onKeyUp", "change_h_style('"+i+"_elementform_id_temp', this.value);");
	
	Height = document.createTextNode(fmc_objectL10n.fmc_Height);
	
	var el_style_label = document.createElement('label');
	        el_style_label.setAttribute("for", "el_style_textarea");
		el_style_label.innerHTML = fmc_objectL10n.fmc_Class_name;
	
	var el_style_textarea = document.createElement('input');
                el_style_textarea.setAttribute("id", "el_style_textarea");
		el_style_textarea.setAttribute("type", "text");
 		el_style_textarea.setAttribute("value", w_class);
                el_style_textarea.style.cssText = "width:200px;";
                el_style_textarea.setAttribute("onChange", "change_class(this.value,'"+i+"')");

	var el_attr_label = document.createElement('label');
	                
			el_attr_label.innerHTML = fmc_objectL10n.fmc_Additional_attributes;
	var el_attr_add = document.createElement('img');
                
           	el_attr_add.setAttribute("src", contact_form_maker_plugin_url + '/images/add.png');
            	el_attr_add.style.cssText = 'cursor:pointer; margin-left:68px';
            	el_attr_add.setAttribute("title", fmc_objectL10n.fmc_add);
                el_attr_add.setAttribute("onClick", "add_attr("+i+", 'type_text')");
	var el_attr_table = document.createElement('table');
                el_attr_table.setAttribute("id", 'attributes');
                el_attr_table.setAttribute("border", '0');
        	el_attr_table.style.cssText = 'margin-left:0px';
	var el_attr_tr_label = document.createElement('tr');
                el_attr_tr_label.setAttribute("idi", '0');
	var el_attr_td_name_label = document.createElement('th');
            	el_attr_td_name_label.style.cssText = 'width:100px';
	var el_attr_td_value_label = document.createElement('th');
            	el_attr_td_value_label.style.cssText = 'width:100px';
	var el_attr_td_X_label = document.createElement('th');
            	el_attr_td_X_label.style.cssText = 'width:10px';
	var el_attr_name_label = document.createElement('label');
	                el_attr_name_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_name_label.innerHTML = fmc_objectL10n.fmc_Name;
			
	var el_attr_value_label = document.createElement('label');
	                el_attr_value_label.style.cssText ="color:#00aeef; font-weight:bold; font-size: 11px";
			el_attr_value_label.innerHTML = fmc_objectL10n.fmc_Value;
			
	el_attr_table.appendChild(el_attr_tr_label);
	el_attr_tr_label.appendChild(el_attr_td_name_label);
	el_attr_tr_label.appendChild(el_attr_td_value_label);
	el_attr_tr_label.appendChild(el_attr_td_X_label);
	el_attr_td_name_label.appendChild(el_attr_name_label);
	el_attr_td_value_label.appendChild(el_attr_value_label);
	
	n=w_attr_name.length;
	for(j=1; j<=n; j++)
	{	
		var el_attr_tr = document.createElement('tr');
			el_attr_tr.setAttribute("id", "attr_row_"+j);
			el_attr_tr.setAttribute("idi", j);
		var el_attr_td_name = document.createElement('td');
			el_attr_td_name.style.cssText = 'width:100px';
		var el_attr_td_value = document.createElement('td');
			el_attr_td_value.style.cssText = 'width:100px';
		
		var el_attr_td_X = document.createElement('td');
		var el_attr_name = document.createElement('input');
	
			el_attr_name.setAttribute("type", "text");
	
			el_attr_name.style.cssText = "width:100px";
			el_attr_name.setAttribute("value", w_attr_name[j-1]);
			el_attr_name.setAttribute("id", "attr_name"+j);
			el_attr_name.setAttribute("onChange", "change_attribute_name("+i+", this, 'type_text')");
			
		var el_attr_value = document.createElement('input');
	
			el_attr_value.setAttribute("type", "text");
	
			el_attr_value.style.cssText = "width:100px";
			el_attr_value.setAttribute("value", w_attr_value[j-1]);
			el_attr_value.setAttribute("id", "attr_value"+j);
			el_attr_value.setAttribute("onChange", "change_attribute_value("+i+", "+j+", 'type_text')");
	
		var el_attr_remove = document.createElement('img');
			el_attr_remove.setAttribute("id", "el_choices"+j+"_remove");
			el_attr_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_attr_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			
			el_attr_remove.setAttribute("onClick", "remove_attr("+j+", "+i+", 'type_text')");
		el_attr_table.appendChild(el_attr_tr);
		el_attr_tr.appendChild(el_attr_td_name);
		el_attr_tr.appendChild(el_attr_td_value);
		el_attr_tr.appendChild(el_attr_td_X);
		el_attr_td_name.appendChild(el_attr_name);
		el_attr_td_value.appendChild(el_attr_value);
		el_attr_td_X.appendChild(el_attr_remove);
		
	}
		
	var t  = document.getElementById('edit_table');
	var br = document.createElement('br');
	var br1 = document.createElement('br');
	var br2 = document.createElement('br');
	var br3 = document.createElement('br');
	var br4 = document.createElement('br');
	var br5 = document.createElement('br');
	var br6 = document.createElement('br');
	var br7 = document.createElement('br');
	var br8 = document.createElement('br');
	var br9 = document.createElement('br');
	var br10 = document.createElement('br');
	var br11 = document.createElement('br');
	
	edit_main_td2.appendChild(el_label_location);
	edit_main_td2.appendChild(center1);
	edit_main_td2.appendChild(el_img_add_marker);
	edit_main_td2.setAttribute("colspan", "2");
	
	/*edit_main_td7.appendChild(Address);
	edit_main_td7.appendChild(br9);
	edit_main_td7.appendChild(Longitude);
	edit_main_td7.appendChild(br8);
	edit_main_td7.appendChild(Latitude);
	edit_main_td7.appendChild(br11);
	edit_main_td7.appendChild(Marker_info);
	edit_main_td7_1.appendChild(el_map_address);
	edit_main_td7_1.appendChild(br7);
	edit_main_td7_1.appendChild(el_map_longitude);
	edit_main_td7_1.appendChild(br2);
	edit_main_td7_1.appendChild(el_map_latitude);
	edit_main_td7_1.appendChild(br10);
	edit_main_td7_1.appendChild(el_info_textarea);*/
	
/*	edit_main_td2.appendChild(br3);*/

	edit_main_td8.appendChild(el_label_disable);
	edit_main_td8_1.appendChild(el_input_disable);

	edit_main_td3.appendChild(el_label_map_size);
	edit_main_td3_1.appendChild(Width);
	edit_main_td3_1.appendChild(el_map_width);
	edit_main_td3_1.appendChild(br5);
	edit_main_td3_1.appendChild(Height);
	edit_main_td3_1.appendChild(el_map_height);

	
	edit_main_td5.appendChild(el_style_label);
	edit_main_td5_1.appendChild(el_style_textarea);
	
	edit_main_td6.appendChild(el_attr_label);
	edit_main_td6.appendChild(el_attr_add);
	edit_main_td6.appendChild(br6);
	edit_main_td6.appendChild(el_attr_table);
	edit_main_td6.setAttribute("colspan", "2");
	
/*	edit_main_td5.appendChild(el_guidelines_label);
	edit_main_td5.appendChild(br4);
	edit_main_td5.appendChild(el_guidelines_textarea);
*/	
	edit_main_tr8.appendChild(edit_main_td8);
	edit_main_tr8.appendChild(edit_main_td8_1);
	edit_main_tr2.appendChild(edit_main_td2);
	
	edit_main_tr7.appendChild(edit_main_td7);
	/*edit_main_tr7.appendChild(edit_main_td7_1);*/
	
	edit_main_tr3.appendChild(edit_main_td3);
	edit_main_tr3.appendChild(edit_main_td3_1);
	edit_main_tr4.appendChild(edit_main_td4);
	edit_main_tr4.appendChild(edit_main_td4_1);
	edit_main_tr5.appendChild(edit_main_td5);
	edit_main_tr5.appendChild(edit_main_td5_1);
	edit_main_tr6.appendChild(edit_main_td6);
	edit_main_tr6.appendChild(edit_main_td6_1);
	
	edit_main_table.appendChild(edit_main_tr8);
	edit_main_table.appendChild(edit_main_tr3);
	edit_main_table.appendChild(edit_main_tr2);
	edit_main_table.appendChild(edit_main_tr7);
/*	edit_main_table.appendChild(edit_main_tr4);*/
	edit_main_table.appendChild(edit_main_tr5);
	edit_main_table.appendChild(edit_main_tr6);
	edit_div.appendChild(edit_main_table);
	
	t.appendChild(edit_div);
	
/*show table*/

	element='div';
	var adding_type = document.createElement("input");
            adding_type.setAttribute("type", "hidden");
            adding_type.setAttribute("value", "type_map");
            adding_type.setAttribute("name", i+"_typeform_id_temp");
            adding_type.setAttribute("id", i+"_typeform_id_temp");
	
	var adding = document.createElement('div');
		adding.setAttribute("id", i+"_elementform_id_temp");
		adding.style.cssText = "width:"+w_width+"px; height: "+w_height+"px";
		adding.setAttribute("zoom", w_zoom);
		adding.setAttribute("center_x", w_center_x);
		adding.setAttribute("center_y", w_center_y);
		
	var label = document.createElement('span');
		label.setAttribute("id", i+"_element_labelform_id_temp");
		label.innerHTML = "map_"+i;
            	label.style.cssText = 'display:none';
		
     	var div = document.createElement('div');
      	    div.setAttribute("id", "main_div");
					
      var div_field = document.createElement('div');
           	div_field.setAttribute("id", i+"_elemet_tableform_id_temp");
						
      	var div_label = document.createElement('div');
         	div_label.setAttribute("align", 'left');
         	div_label.style.display="table-cell";
           	div_label.setAttribute("id", i+"_label_sectionform_id_temp");
			
      	var div_element = document.createElement('div');
         	div_element.setAttribute("align", 'left');
          	div_element.style.display="table-cell";
          	div_element.setAttribute("id", i+"_element_sectionform_id_temp");
			
      	var br1 = document.createElement('br');
      	var br2 = document.createElement('br');
     	var br3 = document.createElement('br');
      	var br4 = document.createElement('br');
      

      	var main_td  = document.getElementById('show_table');
      
      	div_label.appendChild(label);
      	div_element.appendChild(adding_type);
      	div_element.appendChild(adding);

      	div_field.appendChild(div_label);
      	div_field.appendChild(div_element);
   
      
      	div.appendChild(div_field);
      	div.appendChild(br3);
      	main_td.appendChild(div);
change_class(w_class, i);
refresh_attr(i, 'type_text');
if_gmap_init(i);

		
	n=w_long.length;
	for(j=0; j<n; j++)
	{	
		add_marker(i,j, w_long[j], w_lat[j], w_info[j]);
 	}
    
}


function add_marker(id, i, w_long, w_lat, w_info)
{

	edit_main_td7=document.getElementById('markers');
	
	if(i==-1)
	{
		if(edit_main_td7.lastChild)
			i=parseInt(edit_main_td7.lastChild.getAttribute("idi"))+1;
		else
			i=0;
		w_long=null;
		w_lat=null;
		w_info='';

	}
	
		var table_marker = document.createElement('table');
			table_marker.setAttribute("width", "100%");
			table_marker.setAttribute("border", "0");
			table_marker.setAttribute("id", "marker_opt"+i);
			table_marker.setAttribute("idi", i);
			/*table_marker.style.cssText = "border-top: 1px dotted #D1C8C8;";*/
	

		var tr_marker = document.createElement('tr');
		var tr_hr = document.createElement('tr');
		
		var td_marker = document.createElement('td');
		var td_X = document.createElement('td');
		var td_hr = document.createElement('td');
		    td_hr.setAttribute("colspan", "3");
		tr_hr.appendChild(td_hr);
		tr_marker.appendChild(td_marker);
		tr_marker.appendChild(td_X);
		table_marker.appendChild(tr_marker);
		
		var br1 = document.createElement('br');
		var br2 = document.createElement('br');
		var br3 = document.createElement('br');
		
		var hr = document.createElement('hr');
		hr.setAttribute("id", "br"+i);
		
		var el_info_textarea = document.createElement('textarea');
			el_info_textarea.setAttribute("id", "info"+i);
			el_info_textarea.setAttribute("rows", "3");
			el_info_textarea.setAttribute("value", w_info);
			el_info_textarea.style.cssText = "width:200px;";
			el_info_textarea.setAttribute("onKeyUp", "change_info(this.value,'"+id+"','"+i+"')");
			el_info_textarea.innerHTML=w_info;
		
		var Marker_info = document.createElement('label');
			Marker_info.style.cssText =" font-size: 11px; vertical-align:top; margin-right:43px";
			Marker_info.innerHTML = fmc_objectL10n.fmc_Marker_info;
	
		var el_map_address = document.createElement('input');
			el_map_address.setAttribute("id", "addrval"+i);
			el_map_address.setAttribute("type", "text");
			el_map_address.setAttribute("value", "");
			el_map_address.setAttribute("size", "40");
			el_map_address.setAttribute("onchange", "changeAddress("+id+","+i+")");
	
		var Address = document.createElement('label');
			Address.style.cssText =" font-size: 11px; vertical-align:top; margin-right:59px";
			Address.innerHTML = fmc_objectL10n.fmc_Address;
	
		var el_map_longitude = document.createElement('input');
			el_map_longitude.setAttribute("id", "longval"+i);
			el_map_longitude.setAttribute("type", "text");
			el_map_longitude.setAttribute("value", w_long);
			el_map_longitude.setAttribute("size", "10");
			el_map_longitude.setAttribute("onkeyup", "update_position("+id+", "+i+");");
		
	
		var Longitude = document.createElement('label');
			Longitude.style.cssText =" font-size: 11px; vertical-align:top; margin-right:51px";
			Longitude.innerHTML = fmc_objectL10n.fmc_Longitude;
			
		var el_map_latitude = document.createElement('input');
			el_map_latitude.setAttribute("id", "latval"+i);
			el_map_latitude.setAttribute("type", "text");
			el_map_latitude.setAttribute("value", w_lat);
			el_map_latitude.setAttribute("size", "10");
			el_map_latitude.setAttribute("onkeyup", "update_position("+id+", "+i+");");
		
		var Latitude = document.createElement('label');
			Latitude.style.cssText =" font-size: 11px; vertical-align:top; margin-right:62px";
			Latitude.innerHTML = fmc_objectL10n.fmc_Latitude;
			

		
		var el_choices_remove = document.createElement('img');
			el_choices_remove.setAttribute("id", "el_button"+i+"_remove");
			el_choices_remove.setAttribute("src", contact_form_maker_plugin_url + '/images/delete.png');
			el_choices_remove.style.cssText = 'cursor:pointer; vertical-align:middle; margin:3px';
			el_choices_remove.setAttribute("align", 'top');
			el_choices_remove.setAttribute("onClick", "remove_map("+id+","+i+")");
			
		td_hr.appendChild(hr);
		
		
		td_marker.appendChild(Address);
		td_marker.appendChild(el_map_address);
		td_marker.appendChild(br1);
		td_marker.appendChild(Longitude);
		td_marker.appendChild(el_map_longitude);
		td_marker.appendChild(br2);
		td_marker.appendChild(Latitude);
		td_marker.appendChild(el_map_latitude);
		td_marker.appendChild(br3);
		td_marker.appendChild(Marker_info);
		td_marker.appendChild(el_info_textarea);
		td_X.appendChild(el_choices_remove);
		edit_main_td7.appendChild(table_marker);
	
	var adding = document.getElementById(id+"_elementform_id_temp")
		adding.setAttribute("long"+i, w_long);
		adding.setAttribute("lat"+i, w_lat);
 		adding.setAttribute("info"+i, w_info);
   

add_marker_on_map(id, i, w_long, w_lat, w_info, true);
}

function remove_map(id,i)
{
	table=document.getElementById('marker_opt'+i);
	table.parentNode.removeChild(table);
	map=document.getElementById(id+"_elementform_id_temp");
	map.removeAttribute("long"+i);
	map.removeAttribute("lat"+i);
 	map.removeAttribute("info"+i);

	reomve_marker(id,i);
}



function set_checkable(type)
{
	document.getElementById("_div_between").setAttribute(type+'_checkable',document.getElementById("el_check_"+type+"_input").checked);
}


function remove_section_break(id)
{
	var wdform_section_break=document.getElementById( "wdform_field"+id).parentNode;
	

	move=wdform_section_break.nextSibling;
	to=wdform_section_break.previousSibling;
	
	
	l=move.childNodes.length;
	for(k=0;k<l;k++)
	{
		if(to.childNodes[k])
		{
			while(move.childNodes[k].firstChild)
				to.childNodes[k].appendChild(move.childNodes[k].firstChild);
		}
		else
			to.appendChild(move.childNodes[k]);			
	}
	
	wdform_section_break.parentNode.removeChild(wdform_section_break.nextSibling);
		
	wdform_section_break.parentNode.removeChild(wdform_section_break);
	
}

function remove_row(id) {
	var wdform_field=document.getElementById( "wdform_field"+id);
	var	wdform_row = wdform_field.parentNode;
	
	if(id==28 && !document.getElementById( "wdform_field29").parentNode.getAttribute("disabled"))
	{
		document.getElementById( "disable_field29").checked = false;
		document.getElementById( "wdform_field29").parentNode.setAttribute("disabled","yes");
		document.getElementById( "wdform_field29").parentNode.style.cssText = 'opacity:0.4;';
	}
	else
	{
		if(id==29 && !document.getElementById( "wdform_field28").parentNode.getAttribute("disabled"))
		{
			document.getElementById( "disable_field28").checked = false;
			document.getElementById( "wdform_field28").parentNode.setAttribute("disabled","yes");
			document.getElementById( "wdform_field28").parentNode.style.cssText = 'opacity:0.4;';
		}
	}

	if(wdform_row.getAttribute("disabled"))
	{
		wdform_row.removeAttribute("disabled");
		document.getElementById( "disable_field"+id).setAttribute("title", fmc_objectL10n.fmc_Disable_thefield);
		wdform_field.parentNode.style.cssText = 'opacity:1;';
	}
	else
	{
		wdform_row.setAttribute("disabled","yes");	
		if(wdform_field.getAttribute("type")!='type_section_break')
			wdform_field.style.cssText = 'display:table-cell;';
		
			document.getElementById( "disable_field"+id).setAttribute("title", fmc_objectL10n.fmc_Enable_thefield);
			wdform_field.parentNode.style.cssText = ' opacity:0.4;';
	}

	
}

function destroyChildren(node)
{
  while (node.firstChild)
      node.removeChild(node.firstChild);
}


function remove_add_(id)
{
			attr_name= new Array();
			attr_value= new Array();
			var input = document.getElementById(id); 
			atr=input.attributes;
			for(v=0;v<30;v++)
				if(atr[v] )
				{
					if(atr[v].name.indexOf("add_")==0)
					{
						attr_name.push(atr[v].name.replace('add_',''));
						attr_value.push(atr[v].value);
						input.removeAttribute(atr[v].name);
						v--;
					}
				}
			for(v=0;v<attr_name.length; v++)
			{
				input.setAttribute(attr_name[v],attr_value[v])
			}
}

function add(key) {
	if (document.getElementById("element_type").value == "type_section_break") {
		form_view = 1;
		if (document.getElementById('editing_id').value) {
			i=document.getElementById('editing_id').value;		
			document.getElementById('editing_id').value = "";
			wdform_field_in_editor=document.getElementById(i+"_element_sectionform_id_temp");
      if (document.getElementById("form_maker_editor_ifr") && document.getElementById('form_maker_editor').style.display == "none") {
        ifr_id = "form_maker_editor_ifr";
        ifr = getIFrameDocument(ifr_id);
        wdform_field_in_editor.innerHTML = ifr.body.innerHTML;
      }
      else {
        wdform_field_in_editor.innerHTML = document.getElementById('form_maker_editor').value;
      }
		}
		else
		{
			i=gen;
			gen++;
			
			
			var wdform_row = document.createElement('div');
				wdform_row.setAttribute("wdid", i);
				wdform_row.setAttribute("type", "type_section_break");
				wdform_row.setAttribute("class", "wdform_tr_section_break");
		
			var wdform_field = document.createElement('div');
				wdform_field.setAttribute("id", "wdform_field"+i);
				wdform_field.setAttribute("type", "type_section_break");
				wdform_field.setAttribute("class", "wdform_field_section_break");
				
			var wdform_arrows = document.createElement('div');
				wdform_arrows.setAttribute("id", "wdform_arrows"+i);
				wdform_arrows.setAttribute("class", "wdform_arrows");
				
			wdform_row.appendChild(wdform_field);
			wdform_row.appendChild(wdform_arrows);
				
			wdform_page=document.getElementById('form_id_tempform_view'+form_view);

			var img_X = document.createElement("input");
				img_X.setAttribute("id", "disable_field"+i);
				img_X.setAttribute("title", fmc_objectL10n.fmc_Disable_thefield);
				img_X.setAttribute("type", "checkbox");
				img_X.setAttribute("onclick", 'remove_row("'+i+'")');
				
			var td_X = document.createElement("div");
					td_X.setAttribute("id", "X_"+i);
					td_X.setAttribute("class", "element_toolbar");
					td_X.appendChild(img_X);
/*image pah@*/
			var img_EDIT = document.createElement("img");
					img_EDIT.setAttribute("src", contact_form_maker_plugin_url + "/images/edit.png");
					img_EDIT.setAttribute("title", fmc_objectL10n.fmc_Edit_field);
					img_EDIT.setAttribute("onclick", 'edit("'+i+'")');
					img_EDIT.setAttribute("onmouseover", 'chnage_icons_src(this,"edit")');
					img_EDIT.setAttribute("onmouseout", 'chnage_icons_src(this,"edit")');
					
			var td_EDIT = document.createElement("div");
					td_EDIT.setAttribute("id", "edit_"+i);
					td_EDIT.setAttribute("class", "element_toolbar");
					td_EDIT.appendChild(img_EDIT);
		
			var img_DUBLICATE = document.createElement("img");
					img_DUBLICATE.setAttribute("src", contact_form_maker_plugin_url + "/images/dublicate.png");
					img_DUBLICATE.setAttribute("title", fmc_objectL10n.fmc_Dublicate_field);
					img_DUBLICATE.setAttribute("onclick", 'dublicate("'+i+'")');
					img_DUBLICATE.setAttribute("onmouseover", 'chnage_icons_src(this,"dublicate")');
					img_DUBLICATE.setAttribute("onmouseout", 'chnage_icons_src(this,"dublicate")');
					
			var td_DUBLICATE = document.createElement("div");
					td_DUBLICATE.setAttribute("id", "dublicate_"+i);
					td_DUBLICATE.setAttribute("class", "element_toolbar");
					td_DUBLICATE.appendChild(img_DUBLICATE);
					
			var in_editor = document.createElement("div");
					in_editor.setAttribute("id", i+"_element_sectionform_id_temp");
         			in_editor.setAttribute("align", 'left');
         			in_editor.setAttribute("class", 'wdform_section_break');

      if (document.getElementById("form_maker_editor_ifr") && document.getElementById('form_maker_editor').style.display == "none") {
        ifr_id = "form_maker_editor_ifr";
        ifr = getIFrameDocument(ifr_id);
        in_editor.innerHTML = ifr.body.innerHTML;
      }
      else {
        in_editor.innerHTML = document.getElementById('form_maker_editor').value;
      }
			var label = document.createElement('span');
					label.setAttribute("id", i+"_element_labelform_id_temp");
					label.innerHTML = "custom_"+i;
					label.style.cssText = 'display:none';
					
			wdform_field.appendChild(in_editor);
			td_EDIT.appendChild(label);

			wdform_arrows.appendChild(td_X);
			wdform_arrows.appendChild(td_EDIT);
			wdform_arrows.appendChild(td_DUBLICATE);

			
			beforeTr=wdform_page.lastChild;
			wdform_page.insertBefore(wdform_row, beforeTr);
				
			wdform_section_new=document.createElement('div');
				wdform_section_new.setAttribute('class','wdform_section');
				
			wdform_column_new=document.createElement('div');
				wdform_column_new.setAttribute('class','wdform_column');
				
			wdform_section_new.appendChild(wdform_column_new);
			
			beforeTr=wdform_page.lastChild;
			wdform_page.insertBefore(wdform_section_new, beforeTr);
				
			j=2;
			
		}
    sortable_columns();
    if(document.getElementById('enable_sortable').value==0)
      jQuery('.wdform_column').sortable( "disable" );			
    else
      jQuery( ".wdform_arrows" ).hide();

	close_window();
	return;
	}

	form_view=1;

	if(document.getElementById('main_editor').style.display=="block")
	{
		if(document.getElementById('editing_id').value)
		{
			i=document.getElementById('editing_id').value;		
				document.getElementById('editing_id').value="";
			wdform_field=document.getElementById("wdform_field"+i);
			destroyChildren(wdform_field);
      if (document.getElementById("form_maker_editor_ifr") && document.getElementById('form_maker_editor').style.display == "none") {
        ifr_id = "form_maker_editor_ifr";
        ifr = getIFrameDocument(ifr_id);
        wdform_field.innerHTML = ifr.body.innerHTML;
      }
      else {
        wdform_field.innerHTML = document.getElementById('form_maker_editor').value;
      }
			j = 2;
		}
		else {
			i=gen;
			gen++;
			l=document.getElementById('form_id_tempform_view'+form_view).childNodes.length;
			wdform_column=document.getElementById('form_id_tempform_view'+form_view).childNodes[l-2].firstChild;

			var wdform_row = document.createElement('div');
				wdform_row.setAttribute("wdid", i);
				wdform_row.setAttribute("class", "wdform_row");
		
			var wdform_field = document.createElement('div');
				wdform_field.setAttribute("id", "wdform_field"+i);
				wdform_field.setAttribute("type", "type_editor");
				wdform_field.setAttribute("class", "wdform_field");
				wdform_field.style.display="table-cell";
				
			var wdform_arrows = document.createElement('div');
				wdform_arrows.setAttribute("id", "wdform_arrows"+i);
				wdform_arrows.setAttribute("class", "wdform_arrows");
				wdform_arrows.style.display="table-cell";
				
			wdform_row.appendChild(wdform_field);
			wdform_row.appendChild(wdform_arrows);
			
			var img_X = document.createElement("input");
				img_X.setAttribute("id", "disable_field"+i);
				img_X.setAttribute("title", fmc_objectL10n.fmc_Disable_thefield);
				img_X.setAttribute("type", "checkbox");
				img_X.setAttribute("onclick", 'remove_row("'+i+'")');
					
			var td_X = document.createElement("div");
					td_X.setAttribute("id", "X_"+i);
					td_X.setAttribute("valign", "middle");
					td_X.setAttribute("align", "right");
					td_X.setAttribute("class", "element_toolbar");
					td_X.appendChild(img_X);
/*image pah@*/
			var img_UP = document.createElement("img");
					img_UP.setAttribute("src", contact_form_maker_plugin_url + "/images/up.png");
					img_UP.setAttribute("title", fmc_objectL10n.fmc_Move_fieldup);
					img_UP.setAttribute("onclick", 'up_row("'+i+'")');
					img_UP.setAttribute("onmouseover", 'chnage_icons_src(this,"up")');
					img_UP.setAttribute("onmouseout", 'chnage_icons_src(this,"up")');
					
			var td_UP = document.createElement("div");
					td_UP.setAttribute("id", "up_"+i);
					td_UP.setAttribute("valign", "middle");
					td_UP.setAttribute("class", "element_toolbar");
					td_UP.appendChild(img_UP);
					
			var img_DOWN = document.createElement("img");
					img_DOWN.setAttribute("src", contact_form_maker_plugin_url + "/images/down.png");
					img_DOWN.setAttribute("title", fmc_objectL10n.fmc_Move_fielddown);
					img_DOWN.setAttribute("onclick", 'down_row("'+i+'")');
					img_DOWN.setAttribute("onmouseover", 'chnage_icons_src(this,"down")');
					img_DOWN.setAttribute("onmouseout", 'chnage_icons_src(this,"down")');
					
			var td_DOWN = document.createElement("div");
					td_DOWN.setAttribute("id", "down_"+i);
					td_DOWN.setAttribute("valign", "middle");
					td_DOWN.setAttribute("class", "element_toolbar");
					td_DOWN.appendChild(img_DOWN);
					
			var img_RIGHT = document.createElement("img");
					img_RIGHT.setAttribute("src", contact_form_maker_plugin_url + "/images/right.png");
					img_RIGHT.setAttribute("title", fmc_objectL10n.fmc_Move_fieldright);
					img_RIGHT.setAttribute("onclick", 'right_row("'+i+'")');
					img_RIGHT.setAttribute("onmouseover", 'chnage_icons_src(this,"right")');
					img_RIGHT.setAttribute("onmouseout", 'chnage_icons_src(this,"right")');
					
			var td_RIGHT = document.createElement("div");
					td_RIGHT.setAttribute("id", "right_"+i);
					td_RIGHT.setAttribute("valign", "middle");
					td_RIGHT.setAttribute("class", "element_toolbar");
					td_RIGHT.appendChild(img_RIGHT);
					
			var img_LEFT = document.createElement("img");
					img_LEFT.setAttribute("src", contact_form_maker_plugin_url + "/images/left.png");
					img_LEFT.setAttribute("title", fmc_objectL10n.fmc_Move_fieldleft);
					img_LEFT.setAttribute("onclick", 'left_row("'+i+'")');
					img_LEFT.setAttribute("onmouseover", 'chnage_icons_src(this,"left")');
					img_LEFT.setAttribute("onmouseout", 'chnage_icons_src(this,"left")');
					
			var td_LEFT = document.createElement("div");
					td_LEFT.setAttribute("id", "left_"+i);
					td_LEFT.setAttribute("valign", "middle");
					td_LEFT.setAttribute("class", "element_toolbar");
					td_LEFT.appendChild(img_LEFT);
					
			var img_EDIT = document.createElement("img");
					img_EDIT.setAttribute("src", contact_form_maker_plugin_url + "/images/edit.png");
					img_EDIT.setAttribute("title", fmc_objectL10n.fmc_Edit_field);
					img_EDIT.setAttribute("onclick", 'edit("'+i+'")');
					img_EDIT.setAttribute("onmouseover", 'chnage_icons_src(this,"edit")');
					img_EDIT.setAttribute("onmouseout", 'chnage_icons_src(this,"edit")');
					
			var td_EDIT = document.createElement("div");
					td_EDIT.setAttribute("id", "edit_"+i);
					td_EDIT.setAttribute("valign", "middle");
					td_EDIT.setAttribute("class", "element_toolbar");
					td_EDIT.appendChild(img_EDIT);
		
			

    if (document.getElementById("form_maker_editor_ifr") && document.getElementById('form_maker_editor').style.display == "none") {
      ifr_id = "form_maker_editor_ifr";
      ifr = getIFrameDocument(ifr_id);
      wdform_field.innerHTML = ifr.body.innerHTML;
    }
    else {
      wdform_field.innerHTML = document.getElementById('form_maker_editor').value;
    }
			
			
			
			var label = document.createElement('span');
				label.setAttribute("id", i+"_element_labelform_id_temp");
				label.innerHTML = "custom_"+i;
				label.style.cssText = 'display:none';
					
			td_EDIT.appendChild(label);

			wdform_arrows.appendChild(td_X);
			wdform_arrows.appendChild(td_LEFT);
			wdform_arrows.appendChild(td_UP);
			wdform_arrows.appendChild(td_DOWN);
			wdform_arrows.appendChild(td_RIGHT);
			wdform_arrows.appendChild(td_EDIT);
		

			j=2;
			
		}

	close_window();
	}
	else
	if(document.getElementById('show_table').innerHTML)
	{
		
		if(document.getElementById('editing_id').value)
			i=document.getElementById('editing_id').value;		
		else
			i=gen;
			
		type=document.getElementById("element_type").value;
		
		
		if(type=="type_map")
		{
			if_gmap_updateMap(i);
		}
		
	
	
		if(document.getElementById(i+'_element_labelform_id_temp').innerHTML)
		{

		if(document.getElementById('editing_id').value)
		{
			
			i=document.getElementById('editing_id').value;		
			in_lab=false;
			labels_array=new Array();
			for(w=0; w<gen;w++)
			{	
				if(w!=i)
				if(document.getElementById(w+'_element_labelform_id_temp'))
					labels_array.push(document.getElementById(w+'_element_labelform_id_temp').innerHTML);
			}			
	
			for(t=0; t<labels_array.length;t++)
			{	
			if(document.getElementById(i+'_element_labelform_id_temp').innerHTML==labels_array[t])
				{
					in_lab=true;
					break;
				}
			}
			if(in_lab)
			{
				alert(fmc_objectL10n.fmc_labels_mustbe_unique);
				return;
			}
			else
			{
				document.getElementById('editing_id').value="";
	
				wdform_field=document.getElementById("wdform_field"+i);
	
				destroyChildren(wdform_field);
	
	
						var add1 = document.getElementById(i+'_label_sectionform_id_temp');
						var add2 = document.getElementById(i+'_element_sectionform_id_temp');
						
						wdform_field.appendChild(add1);
						wdform_field.appendChild(add2);
	
	
				j=2;
	
				close_window() ;
				
			call(i,key);
			}
		}
		else
		{	
		i=gen;
		in_lab=false;
		labels_array=new Array();
		for(w=0; w<gen;w++)
		{	
			if(document.getElementById(w+'_element_labelform_id_temp'))
				labels_array.push(document.getElementById(w+'_element_labelform_id_temp').innerHTML);
		}			
		for(t=0; t<labels_array.length;t++)
		{	
		if(document.getElementById(i+'_element_labelform_id_temp').innerHTML==labels_array[t])
			{
				in_lab=true;
				break;
			}
		}
		if(in_lab)
		{
			alert(fmc_objectL10n.fmc_labels_mustbe_unique);
			return
		}
		else
		{
			
			if(type=="type_address")
				gen=gen+6;
			else
				gen++;			
				
			l=document.getElementById('form_id_tempform_view'+form_view).childNodes.length;
			
			wdform_column=document.getElementById('form_id_tempform_view'+form_view).childNodes[l-2].firstChild;
					
			var wdform_row = document.createElement('div');
				wdform_row.setAttribute("wdid", i);
				wdform_row.setAttribute("class", "wdform_row");
		
			var wdform_field = document.createElement('div');
				wdform_field.setAttribute("id", "wdform_field"+i);
				wdform_field.setAttribute("type", type);
				wdform_field.setAttribute("class", "wdform_field");
				wdform_field.style.display="table-cell";
				
			var wdform_arrows = document.createElement('div');
				wdform_arrows.setAttribute("id", "wdform_arrows"+i);
				wdform_arrows.setAttribute("class", "wdform_arrows");
				wdform_arrows.style.display="table-cell";
				
			wdform_row.appendChild(wdform_field);
			wdform_row.appendChild(wdform_arrows);
			
			
			var img_X = document.createElement("input");
				img_X.setAttribute("id", "disable_field"+i);
				img_X.setAttribute("title", fmc_objectL10n.fmc_Disable_thefield);
				img_X.setAttribute("type", "checkbox");
				img_X.setAttribute("onclick", 'remove_row("'+i+'")');
					
			var td_X = document.createElement("div");
					td_X.setAttribute("id", "X_"+i);
					td_X.setAttribute("valign", "middle");
					td_X.setAttribute("align", "right");
					td_X.setAttribute("class", "element_toolbar");
					td_X.appendChild(img_X);
/*image pah@*/
			var img_UP = document.createElement("img");
					img_UP.setAttribute("src", contact_form_maker_plugin_url + "/images/up.png");
					img_UP.setAttribute("title", fmc_objectL10n.fmc_Move_fieldup);
					img_UP.setAttribute("onclick", 'up_row("'+i+'")');
					img_UP.setAttribute("onmouseover", 'chnage_icons_src(this,"up")');
					img_UP.setAttribute("onmouseout", 'chnage_icons_src(this,"up")');
					
			var td_UP = document.createElement("div");
					td_UP.setAttribute("id", "up_"+i);
					td_UP.setAttribute("valign", "middle");
					td_UP.setAttribute("class", "element_toolbar");
					td_UP.appendChild(img_UP);
					
			var img_DOWN = document.createElement("img");
					img_DOWN.setAttribute("src", contact_form_maker_plugin_url + "/images/down.png");
					img_DOWN.setAttribute("title", fmc_objectL10n.fmc_Move_fielddown);
					img_DOWN.setAttribute("onclick", 'down_row("'+i+'")');
					img_DOWN.setAttribute("onmouseover", 'chnage_icons_src(this,"down")');
					img_DOWN.setAttribute("onmouseout", 'chnage_icons_src(this,"down")');
					
			var td_DOWN = document.createElement("div");
					td_DOWN.setAttribute("id", "down_"+i);
					td_DOWN.setAttribute("valign", "middle");
					td_DOWN.setAttribute("class", "element_toolbar");
					td_DOWN.appendChild(img_DOWN);
					
			var img_RIGHT = document.createElement("img");
					img_RIGHT.setAttribute("src", contact_form_maker_plugin_url + "/images/right.png");
					img_RIGHT.setAttribute("title", fmc_objectL10n.fmc_Move_fieldright);
					img_RIGHT.setAttribute("onclick", 'right_row("'+i+'")');
					img_RIGHT.setAttribute("onmouseover", 'chnage_icons_src(this,"right")');
					img_RIGHT.setAttribute("onmouseout", 'chnage_icons_src(this,"right")');
					
			var td_RIGHT = document.createElement("div");
					td_RIGHT.setAttribute("id", "right_"+i);
					td_RIGHT.setAttribute("valign", "middle");
					td_RIGHT.setAttribute("class", "element_toolbar");
					td_RIGHT.appendChild(img_RIGHT);
					
			var img_LEFT = document.createElement("img");
					img_LEFT.setAttribute("src", contact_form_maker_plugin_url + "/images/left.png");
					img_LEFT.setAttribute("title", fmc_objectL10n.fmc_Move_fieldleft);
					img_LEFT.setAttribute("onclick", 'left_row("'+i+'")');
					img_LEFT.setAttribute("onmouseover", 'chnage_icons_src(this,"left")');
					img_LEFT.setAttribute("onmouseout", 'chnage_icons_src(this,"left")');
					
			var td_LEFT = document.createElement("div");
					td_LEFT.setAttribute("id", "left_"+i);
					td_LEFT.setAttribute("valign", "middle");
					td_LEFT.setAttribute("class", "element_toolbar");
					td_LEFT.appendChild(img_LEFT);
					
			var img_EDIT = document.createElement("img");
					img_EDIT.setAttribute("src", contact_form_maker_plugin_url + "/images/edit.png");
					img_EDIT.setAttribute("title", fmc_objectL10n.fmc_Edit_field);
					img_EDIT.setAttribute("onclick", 'edit("'+i+'")');
					img_EDIT.setAttribute("onmouseover", 'chnage_icons_src(this,"edit")');
					img_EDIT.setAttribute("onmouseout", 'chnage_icons_src(this,"edit")');
					
			var td_EDIT = document.createElement("div");
					td_EDIT.setAttribute("id", "edit_"+i);
					td_EDIT.setAttribute("valign", "middle");
					td_EDIT.setAttribute("class", "element_toolbar");
					td_EDIT.appendChild(img_EDIT);
		
		
			
						var add1 = document.getElementById(i+'_label_sectionform_id_temp');
						var add2 = document.getElementById(i+'_element_sectionform_id_temp');
						
						wdform_field.appendChild(add1);
						wdform_field.appendChild(add2);
	
			wdform_arrows.appendChild(td_X);
			wdform_arrows.appendChild(td_LEFT);
			wdform_arrows.appendChild(td_UP);
			wdform_arrows.appendChild(td_DOWN);
			wdform_arrows.appendChild(td_RIGHT);
			wdform_arrows.appendChild(td_EDIT);
			
			
		
			j=2;
			close_window() ;
			
		call(i,key);
		
		}
	}	
	}
		else
		{
			alert(fmc_objectL10n.fmc_field_label_required);
			return;
		}
	
/*	undo_redo.push(document.getElementById('take').innerHTML);
	undo_redo_num++;*/
	}			
	else alert(fmc_objectL10n.fmc_select_element_add);
  if(document.getElementById('enable_sortable').value==1)
		jQuery( ".wdform_arrows" ).hide();
}

function call(i,key)
{
	need_enable=false;
	if(key==0)
	{
		edit(i);
		add('1');
	}
	need_enable=true;
}


function edit(id) {
	if (need_enable) {
		enable2();
  }
	document.getElementById('editing_id').value=id;
	type=document.getElementById("wdform_field"+id).getAttribute('type');

	/*parameter take*/
	k=0;
	
	w_choices=new Array();	
	w_choices_checked=new Array();
	w_choices_disabled=new Array();
	w_allow_other_num=0;
	w_property=new Array();	

	w_property_values=new Array();
	w_choices_price=new Array();

	t=0;
	
	/*shat handipox*/
	if (document.getElementById(id+'_element_labelform_id_temp').innerHTML) {
		w_field_label = document.getElementById(id+'_element_labelform_id_temp').innerHTML;
  }
  else {
    w_field_label = " ";
  }
	if(document.getElementById(id+'_label_sectionform_id_temp'))
	if(document.getElementById(id+'_label_sectionform_id_temp').style.display=="block")
		w_field_label_pos="top";
	else
		w_field_label_pos="left";
		
	if(document.getElementById(id+"_elementform_id_temp"))
	{
		s=document.getElementById(id+"_elementform_id_temp").style.width;
		 w_size=s.substring(0,s.length-2);
	}
	
	if(document.getElementById(id+"_label_sectionform_id_temp"))
	{
		s=document.getElementById(id+"_label_sectionform_id_temp").style.width;
		w_field_label_size=s.substring(0,s.length-2);
	}
	
	if(document.getElementById(id+"_requiredform_id_temp"))
	  	w_required=document.getElementById(id+"_requiredform_id_temp").value;
		
	if(document.getElementById(id+"_uniqueform_id_temp"))
	  	w_unique=document.getElementById(id+"_uniqueform_id_temp").value;
		
	if(document.getElementById(id+'_label_sectionform_id_temp'))
	{
		w_class=document.getElementById(id+'_label_sectionform_id_temp').getAttribute("class");
		if(!w_class)
			w_class="";
	}
		

	switch(type)
		{
			case 'type_editor':
			{
				w_editor=document.getElementById("wdform_field"+id).innerHTML;
				type_editor(id, w_editor); break;
			}
			case 'type_section_break':
			{
				w_editor=document.getElementById(id+"_element_sectionform_id_temp").innerHTML;
				type_section_break(id, w_editor); break;
			}
			case 'type_send_copy':
			{

				w_first_val=document.getElementById(id+"_elementform_id_temp").checked;
				atrs=return_attributes(id+'_elementform_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_send_copy(id, w_field_label, w_field_label_size, w_field_label_pos, w_first_val, w_required, w_attr_name, w_attr_value); break;
			}
			case 'type_text':
			{
				w_first_val=document.getElementById(id+"_elementform_id_temp").value;
				w_title=document.getElementById(id+"_elementform_id_temp").title;
        w_regExp_status = document.getElementById(id+"_regExpStatusform_id_temp").value;
				w_regExp_value = unescape(document.getElementById(id+"_regExp_valueform_id_temp").value);
				w_regExp_common = document.getElementById(id+"_regExp_commonform_id_temp").value;
				w_regExp_arg = document.getElementById(id+"_regArgumentform_id_temp").value;
				w_regExp_alert = document.getElementById(id+"_regExp_alertform_id_temp").value;
				atrs=return_attributes(id+'_elementform_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_text(id, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_first_val, w_title, w_required,w_regExp_status, w_regExp_value, w_regExp_common, w_regExp_arg, w_regExp_alert, w_unique,  w_attr_name, w_attr_value); break;
			}
			case 'type_number':
			{
				w_first_val=document.getElementById(id+"_elementform_id_temp").value;
				w_title=document.getElementById(id+"_elementform_id_temp").title;
				atrs=return_attributes(id+'_elementform_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_number(id, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_first_val, w_title, w_required, w_unique, w_class,  w_attr_name, w_attr_value); break;
			}
			case 'type_password':
			{
				atrs=return_attributes(id+'_elementform_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_password(id, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_required, w_unique, w_class, w_attr_name, w_attr_value); break;
			}
			case 'type_textarea':
			{
				w_first_val=document.getElementById(id+"_elementform_id_temp").value;
				w_title=document.getElementById(id+"_elementform_id_temp").title;
				s=document.getElementById(id+"_elementform_id_temp").style.height;
				w_size_h=s.substring(0,s.length-2);

				atrs=return_attributes(id+'_elementform_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_textarea(id, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_size_h, w_first_val, w_title, w_required, w_unique, w_class, w_attr_name, w_attr_value); break;
			}
			case 'type_phone':
			{
				w_first_val=[document.getElementById(id+"_element_firstform_id_temp").value, document.getElementById(id+"_element_lastform_id_temp").value];
				w_title=[document.getElementById(id+"_element_firstform_id_temp").title, document.getElementById(id+"_element_lastform_id_temp").title];
				s=document.getElementById(id+"_element_lastform_id_temp").style.width;
				w_size=s.substring(0,s.length-2);

				w_mini_labels= [document.getElementById(id+"_mini_label_area_code").innerHTML, document.getElementById(id+"_mini_label_phone_number").innerHTML];

				atrs=return_attributes(id+'_element_firstform_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_phone(id, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_first_val, w_title, w_mini_labels, w_required, w_unique, w_class, w_attr_name, w_attr_value); break;
			}
			case 'type_name':
			{
				if(document.getElementById(id+'_element_middleform_id_temp'))
					w_name_format="extended";
				else
					w_name_format="normal";

				if(w_name_format=="normal")	
				{
				w_first_val=[document.getElementById(id+"_element_firstform_id_temp").value, document.getElementById(id+"_element_lastform_id_temp").value];
				w_title=[document.getElementById(id+"_element_firstform_id_temp").title, document.getElementById(id+"_element_lastform_id_temp").title];
				}
				else
				{
				w_first_val=[document.getElementById(id+"_element_firstform_id_temp").value, document.getElementById(id+"_element_lastform_id_temp").value, document.getElementById(id+"_element_titleform_id_temp").value, document.getElementById(id+"_element_middleform_id_temp").value];
				w_title=[document.getElementById(id+"_element_firstform_id_temp").title, document.getElementById(id+"_element_lastform_id_temp").title, document.getElementById(id+"_element_titleform_id_temp").title,
				document.getElementById(id+"_element_middleform_id_temp").title];

				}
					
				if(document.getElementById(id+"_mini_label_title"))
				w_mini_title = document.getElementById(id+"_mini_label_title").innerHTML;
				else
				w_mini_title = "Title";
				
				
				
				if(document.getElementById(id+"_mini_label_middle"))
				w_mini_middle = document.getElementById(id+"_mini_label_middle").innerHTML;
				else
				w_mini_middle = "Middle";
				
				w_mini_labels = [w_mini_title, document.getElementById(id+"_mini_label_first").innerHTML,document.getElementById(id+"_mini_label_last").innerHTML, w_mini_middle]; 	       
				
				
				s=document.getElementById(id+"_element_firstform_id_temp").style.width;
				w_size=s.substring(0,s.length-2);
				atrs=return_attributes(id+'_element_firstform_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_name(id, w_field_label, w_field_label_size, w_field_label_pos,w_first_val, w_title, w_mini_labels,  w_size, w_name_format, w_required, w_unique, w_class, w_attr_name, w_attr_value); break;
			}			
			case 'type_address':
			{
				s=document.getElementById(id+"_div_address").style.width;
				w_size=s.substring(0,s.length-2);


				if(document.getElementById(id+"_mini_label_street1"))
					w_street1= document.getElementById(id+"_mini_label_street1").innerHTML; 
				else
					w_street1 = document.getElementById(id+"_street1form_id_temp").value;
					
					
				if(document.getElementById(id+"_mini_label_street2"))
					w_street2= document.getElementById(id+"_mini_label_street2").innerHTML;
				else
					w_street2 = document.getElementById(id+"_street2form_id_temp").value;	
					
				if(document.getElementById(id+"_mini_label_city"))
					w_city= document.getElementById(id+"_mini_label_city").innerHTML;
				else
					w_city = document.getElementById(id+"_cityform_id_temp").value;					
					
				if(document.getElementById(id+"_mini_label_state"))
					w_state= document.getElementById(id+"_mini_label_state").innerHTML; 
				else
					w_state = document.getElementById(id+"_stateform_id_temp").value;	
					
				if(document.getElementById(id+"_mini_label_postal"))
					w_postal= document.getElementById(id+"_mini_label_postal").innerHTML; 
				else
					w_postal = document.getElementById(id+"_postalform_id_temp").value;	
					
				if(document.getElementById(id+"_mini_label_country"))
					w_country= document.getElementById(id+"_mini_label_country").innerHTML; 
				else
					w_country = document.getElementById(id+"_countryform_id_temp").value;					
					
				w_mini_labels=[w_street1, w_street2, w_city, w_state, w_postal, w_country];


				var disabled_input = document.getElementById(id+"_disable_fieldsform_id_temp");
				
					w_street1_dis= disabled_input.getAttribute('street1');
					w_street2_dis= disabled_input.getAttribute('street2');
					w_city_dis= disabled_input.getAttribute('city');
					w_state_dis= disabled_input.getAttribute('state');
					w_us_states_dis= disabled_input.getAttribute('us_states');
					w_postal_dis= disabled_input.getAttribute('postal');
					w_country_dis= disabled_input.getAttribute('country');
				
						
				w_disabled_fields=[w_street1_dis, w_street2_dis, w_city_dis, w_state_dis,  w_postal_dis, w_country_dis,w_us_states_dis];
				
				atrs=return_attributes(id+'_street1form_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_address(id, w_field_label, w_field_label_size, w_field_label_pos, w_size,  w_mini_labels, w_disabled_fields, w_required, w_class, w_attr_name, w_attr_value); break;
			}
			case 'type_submitter_mail':
			{
				w_first_val=document.getElementById(id+"_elementform_id_temp").value;
				w_title=document.getElementById(id+"_elementform_id_temp").title;
		
				atrs=return_attributes(id+'_elementform_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_submitter_mail(id, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_first_val, w_title, w_required, w_unique, w_class, w_attr_name, w_attr_value); break;
			}			
			case 'type_captcha':
			{
				w_digit=document.getElementById("_wd_captchaform_id_temp").getAttribute("digit");
				atrs=return_attributes('_wd_captchaform_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				
				type_captcha(id, w_field_label, w_field_label_size, w_field_label_pos, w_digit, w_class,  w_attr_name, w_attr_value); break;
			}
			case 'type_recaptcha':
			{
				w_public  = document.getElementById("wd_recaptchaform_id_temp").getAttribute("public_key");
				w_private  = document.getElementById("wd_recaptchaform_id_temp").getAttribute("private_key");
				w_theme  = document.getElementById("wd_recaptchaform_id_temp").getAttribute("theme");
				
				atrs=return_attributes('wd_recaptchaform_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_recaptcha(id, w_field_label, w_field_label_size, w_field_label_pos, w_public, w_private, w_theme, w_class,  w_attr_name, w_attr_value); break;
			}
			case 'type_checkbox':
			{	

				w_randomize=document.getElementById(id+"_randomizeform_id_temp").value;
				w_allow_other=document.getElementById(id+"_allow_otherform_id_temp").value;
		
				v=0;
				for(k=0;k<100;k++)
					if(document.getElementById(id+"_elementform_id_temp"+k))
					{
						if(document.getElementById(id+"_elementform_id_temp"+k).getAttribute('other'))
							if(document.getElementById(id+"_elementform_id_temp"+k).getAttribute('other')=='1')
								w_allow_other_num=t;
						w_choices[t]=document.getElementById(id+"_elementform_id_temp"+k).value;
						w_choices_checked[t]=document.getElementById(id+"_elementform_id_temp"+k).checked;

						t++;
						v=k;
					}

				if(document.getElementById(id+"_rowcol_numform_id_temp").value)	
				{
				
                if(document.getElementById(id+'_table_little').getAttribute('for_hor'))
					w_flow="hor"	
				else
					w_flow="ver";				
				w_rowcol = 	document.getElementById(id+"_rowcol_numform_id_temp").value;
				}
				else
				{
				if(document.getElementById(id+'_hor'))
					w_flow="hor"	
				else
					w_flow="ver";
				
				w_rowcol = '';
				}
				atrs=return_attributes(id+'_elementform_id_temp'+v);
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_checkbox(id, w_field_label,w_field_label_size, w_field_label_pos, w_flow, w_choices, w_choices_checked, w_rowcol, w_required, w_randomize, w_allow_other, w_allow_other_num, w_class, w_attr_name, w_attr_value); break;
			}
			case 'type_radio':
			{	
		
				w_randomize=document.getElementById(id+"_randomizeform_id_temp").value;
				w_allow_other=document.getElementById(id+"_allow_otherform_id_temp").value;

				v=0;
				for(k=0;k<100;k++)
					if(document.getElementById(id+"_elementform_id_temp"+k))
					{
						if(document.getElementById(id+"_elementform_id_temp"+k).getAttribute('other'))
							if(document.getElementById(id+"_elementform_id_temp"+k).getAttribute('other')=='1')
								w_allow_other_num=t;
						w_choices[t]=document.getElementById(id+"_elementform_id_temp"+k).value;
						w_choices_checked[t]=document.getElementById(id+"_elementform_id_temp"+k).checked;
						t++;
						v=k;
					}

				if(document.getElementById(id+"_rowcol_numform_id_temp").value)	
				{
				
                if(document.getElementById(id+'_table_little').getAttribute('for_hor'))
					w_flow="hor"	
				else
					w_flow="ver";				
				w_rowcol = 	document.getElementById(id+"_rowcol_numform_id_temp").value;
				}
				else
				{
                if(document.getElementById(id+'_table_little').getAttribute('for_hor'))
					w_flow="hor"	
				else
					w_flow="ver";
				
				w_rowcol = '';
				}
				atrs=return_attributes(id+'_elementform_id_temp'+v);
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];

				type_radio(id, w_field_label, w_field_label_size, w_field_label_pos, w_flow, w_choices, w_choices_checked, w_rowcol, w_required, w_randomize, w_allow_other, w_allow_other_num, w_class, w_attr_name, w_attr_value); break;
			}
			
			case 'type_own_select':
			{	
				for(k=0;k<100;k++)
					if(document.getElementById(id+"_option"+k))
					{
						w_choices[t]=document.getElementById(id+"_option"+k).innerHTML;
						w_choices_checked[t]=document.getElementById(id+"_option"+k).selected;
						if(document.getElementById(id+"_option"+k).value=="")
							w_choices_disabled[t]=true;
						else
							w_choices_disabled[t]=false;
						t++;
					}
					
				atrs=return_attributes(id+'_elementform_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_own_select(id, w_field_label, w_field_label_size, w_field_label_pos, w_size, w_choices, w_choices_checked, w_required, w_class, w_attr_name, w_attr_value, w_choices_disabled); break;
			}
			
			case 'type_map':
			{
				w_lat=[];
				w_long=[];
				w_info=[];
				
				w_center_x  = document.getElementById(id+"_elementform_id_temp").getAttribute("center_x");
				w_center_y  = document.getElementById(id+"_elementform_id_temp").getAttribute("center_y");
				w_zoom  = document.getElementById(id+"_elementform_id_temp").getAttribute("zoom");
				w_width = parseInt(document.getElementById(id+"_elementform_id_temp").style.width);
				w_height= parseInt(document.getElementById(id+"_elementform_id_temp").style.height);
				
				
				
				for(j=0; j<=20; j++)
					if( document.getElementById(id+"_elementform_id_temp").getAttribute("lat"+j))
					{
						w_lat.push(document.getElementById(id+"_elementform_id_temp").getAttribute("lat"+j));
						w_long.push(document.getElementById(id+"_elementform_id_temp").getAttribute("long"+j));
						w_info.push(document.getElementById(id+"_elementform_id_temp").getAttribute("info"+j));
					}

				atrs=return_attributes(id+'_elementform_id_temp');
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				type_map(id, w_center_x, w_center_y, w_long, w_lat, w_zoom, w_width, w_height, w_class, w_info, w_attr_name, w_attr_value); break;
			}
			case 'type_submit_reset':
			{
				atrs=return_attributes(id+'_element_submitform_id_temp');
				w_act=!(document.getElementById(id+"_element_resetform_id_temp").style.display=="none");
				w_attr_name=atrs[0];
				w_attr_value=atrs[1];
				w_submit_title = document.getElementById(id+"_element_submitform_id_temp").value;
				w_reset_title  = document.getElementById(id+"_element_resetform_id_temp").value;
				type_submit_reset(id, w_submit_title , w_reset_title , w_class, w_act, w_attr_name, w_attr_value); break;
			}
			

		}
	
}


function gen_form_fields()
{
	switch(wdtype)
	{
		case 'type_editor':
		{
			w_editor=document.getElementById("wdform_field"+id).innerHTML;
									
			form_fields+=w_field_label+"*:*w_field_label*:*";
			form_fields+=w_editor+"*:*w_editor*:*";
			form_fields+="*:*new_field*:*";
		
			break;
		}
			case 'type_send_copy':
		{
			w_first_val=document.getElementById(id+"_elementform_id_temp").checked;
			atrs=return_attributes(id+'_elementform_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];

			form_fields+=w_field_label+"*:*w_field_label*:*";
			form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
			form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
			form_fields+=w_first_val+"*:*w_first_val*:*";
			form_fields+=w_required+"*:*w_required*:*";
									
			for(j=0; j<w_attr_name.length; j++)
			{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
			}
			form_fields+="*:*new_field*:*";
			break;
			}
		
		case 'type_text':
		{
			w_first_val=document.getElementById(id+"_elementform_id_temp").value;
			w_title=document.getElementById(id+"_elementform_id_temp").title;
      w_regExp_status = document.getElementById(id+"_regExpStatusform_id_temp").value;
			w_regExp_value = document.getElementById(id+"_regExp_valueform_id_temp").value;
			w_regExp_common = document.getElementById(id+"_regExp_commonform_id_temp").value;
			w_regExp_arg = document.getElementById(id+"_regArgumentform_id_temp").value;
			w_regExp_alert = document.getElementById(id+"_regExp_alertform_id_temp").value;
			atrs=return_attributes(id+'_elementform_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
									
			form_fields+=w_field_label+"*:*w_field_label*:*";
			form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
			form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
			form_fields+=w_size+"*:*w_size*:*";
			form_fields+=w_first_val+"*:*w_first_val*:*";
			form_fields+=w_title+"*:*w_title*:*";
			form_fields+=w_required+"*:*w_required*:*";
      form_fields+=w_regExp_status+"*:*w_regExp_status*:*";
			form_fields+=w_regExp_value+"*:*w_regExp_value*:*";
			form_fields+=w_regExp_common+"*:*w_regExp_common*:*";
			form_fields+=w_regExp_arg+"*:*w_regExp_arg*:*";
			form_fields+=w_regExp_alert+"*:*w_regExp_alert*:*";
			form_fields+=w_unique+"*:*w_unique*:*";
									
			for(j=0; j<w_attr_name.length; j++)
			{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
			}
			form_fields+="*:*new_field*:*";
			break;
		}
		case 'type_number':
		{
			w_first_val=document.getElementById(id+"_elementform_id_temp").value;
			w_title=document.getElementById(id+"_elementform_id_temp").title;
			atrs=return_attributes(id+'_elementform_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
			
			form_fields+=w_field_label+"*:*w_field_label*:*";
			form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
			form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
			form_fields+=w_size+"*:*w_size*:*";
			form_fields+=w_first_val+"*:*w_first_val*:*";
			form_fields+=w_title+"*:*w_title*:*";
			form_fields+=w_required+"*:*w_required*:*";
			form_fields+=w_unique+"*:*w_unique*:*";
			form_fields+=w_class+"*:*w_class*:*";
			
			for(j=0; j<w_attr_name.length; j++)
			{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
			}
			form_fields+="*:*new_field*:*";	
			break;
			
		}
		case 'type_password':
		{
			atrs=return_attributes(id+'_elementform_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
			
		
			form_fields+=w_field_label+"*:*w_field_label*:*";
			form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
			form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
			form_fields+=w_size+"*:*w_size*:*";
			form_fields+=w_required+"*:*w_required*:*";
			form_fields+=w_unique+"*:*w_unique*:*";
			form_fields+=w_class+"*:*w_class*:*";
			
			for(j=0; j<w_attr_name.length; j++)
			{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
			}
			form_fields+="*:*new_field*:*";	
			break;
				
		}
		case 'type_textarea':
		{
			w_first_val=document.getElementById(id+"_elementform_id_temp").value;
			w_title=document.getElementById(id+"_elementform_id_temp").title;
			s=document.getElementById(id+"_elementform_id_temp").style.height;
			w_size_h=s.substring(0,s.length-2);

			atrs=return_attributes(id+'_elementform_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
		
			form_fields+=w_field_label+"*:*w_field_label*:*";
			form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
			form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
			form_fields+=w_size+"*:*w_size_w*:*";
			form_fields+=w_size_h+"*:*w_size_h*:*";
			form_fields+=w_first_val+"*:*w_first_val*:*";
			form_fields+=w_title+"*:*w_title*:*";
			form_fields+=w_required+"*:*w_required*:*";
			form_fields+=w_unique+"*:*w_unique*:*";
			form_fields+=w_class+"*:*w_class*:*";
			
			for(j=0; j<w_attr_name.length; j++)
			{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
			}
			form_fields+="*:*new_field*:*";	
			break;
			}
		case 'type_phone':
		{
			w_first_val=[document.getElementById(id+"_element_firstform_id_temp").value, document.getElementById(id+"_element_lastform_id_temp").value];
			w_title=[document.getElementById(id+"_element_firstform_id_temp").title, document.getElementById(id+"_element_lastform_id_temp").title];
			s=document.getElementById(id+"_element_lastform_id_temp").style.width;
			w_size=s.substring(0,s.length-2);

			w_mini_labels= [document.getElementById(id+"_mini_label_area_code").innerHTML, document.getElementById(id+"_mini_label_phone_number").innerHTML];
			
			
			atrs=return_attributes(id+'_element_firstform_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
			
				form_fields+=w_field_label+"*:*w_field_label*:*";
				form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
				form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
				form_fields+=w_size+"*:*w_size*:*";
				form_fields+=w_first_val.join('***')+"*:*w_first_val*:*";
				form_fields+=w_title.join('***')+"*:*w_title*:*";
				form_fields+=w_mini_labels.join('***')+"*:*w_mini_labels*:*";
				form_fields+=w_required+"*:*w_required*:*";
				form_fields+=w_unique+"*:*w_unique*:*";
				form_fields+=w_class+"*:*w_class*:*";
				
				for(j=0; j<w_attr_name.length; j++)
				{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
				}
				form_fields+="*:*new_field*:*";	
				break;
				}
		case 'type_name':
		{
			if(document.getElementById(id+'_element_middleform_id_temp'))
				w_name_format="extended";
			else
				w_name_format="normal";

				
			if(w_name_format=="normal")	
			{
				w_first_val=[document.getElementById(id+"_element_firstform_id_temp").value, document.getElementById(id+"_element_lastform_id_temp").value];
				w_title=[document.getElementById(id+"_element_firstform_id_temp").title, document.getElementById(id+"_element_lastform_id_temp").title];
			}
			else
			{
				w_first_val=[document.getElementById(id+"_element_titleform_id_temp").value,document.getElementById(id+"_element_firstform_id_temp").value, document.getElementById(id+"_element_lastform_id_temp").value, document.getElementById(id+"_element_middleform_id_temp").value];
				w_title=[document.getElementById(id+"_element_titleform_id_temp").title,document.getElementById(id+"_element_firstform_id_temp").title, document.getElementById(id+"_element_lastform_id_temp").title,
				document.getElementById(id+"_element_middleform_id_temp").title];

			}
				
				if(document.getElementById(id+"_mini_label_title"))
				w_mini_title = document.getElementById(id+"_mini_label_title").innerHTML;
				else
				w_mini_title = "Title";
				
				if(document.getElementById(id+"_mini_label_middle"))
				w_mini_middle = document.getElementById(id+"_mini_label_middle").innerHTML;
				else
				w_mini_middle = "Middle";
				
				w_mini_labels = [ w_mini_title, document.getElementById(id+"_mini_label_first").innerHTML,document.getElementById(id+"_mini_label_last").innerHTML, w_mini_middle]; 	
				
			
					
			s=document.getElementById(id+"_element_firstform_id_temp").style.width;
			w_size=s.substring(0,s.length-2);
			atrs=return_attributes(id+'_element_firstform_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
			
			
				form_fields+=w_field_label+"*:*w_field_label*:*";
				form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
				form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
				form_fields+=w_first_val.join('***')+"*:*w_first_val*:*";
				form_fields+=w_title.join('***')+"*:*w_title*:*";
				form_fields+=w_mini_labels.join('***')+"*:*w_mini_labels*:*";
				form_fields+=w_size+"*:*w_size*:*";
				form_fields+=w_name_format+"*:*w_name_format*:*";
				form_fields+=w_required+"*:*w_required*:*";
				form_fields+=w_unique+"*:*w_unique*:*";
				form_fields+=w_class+"*:*w_class*:*";
				
				for(j=0; j<w_attr_name.length; j++)
				{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
				}
				form_fields+="*:*new_field*:*";	
				break;
			}
		
		
		case 'type_address':
		{
			s=document.getElementById(id+"_div_address").style.width;
			w_size=s.substring(0,s.length-2);
			
			if(document.getElementById(id+"_mini_label_street1"))
					w_street1= document.getElementById(id+"_mini_label_street1").innerHTML; 
				else
					w_street1 = document.getElementById(id+"_street1form_id_temp").value;
					
					
				if(document.getElementById(id+"_mini_label_street2"))
					w_street2= document.getElementById(id+"_mini_label_street2").innerHTML;
				else
					w_street2 = document.getElementById(id+"_street2form_id_temp").value;	
					
				if(document.getElementById(id+"_mini_label_city"))
					w_city= document.getElementById(id+"_mini_label_city").innerHTML;
				else
					w_city = document.getElementById(id+"_cityform_id_temp").value;					
					
				if(document.getElementById(id+"_mini_label_state"))
					w_state= document.getElementById(id+"_mini_label_state").innerHTML; 
				else
					w_state = document.getElementById(id+"_stateform_id_temp").value;	
					
				if(document.getElementById(id+"_mini_label_postal"))
					w_postal= document.getElementById(id+"_mini_label_postal").innerHTML; 
				else
					w_postal = document.getElementById(id+"_postalform_id_temp").value;	
					
				if(document.getElementById(id+"_mini_label_country"))
					w_country= document.getElementById(id+"_mini_label_country").innerHTML; 
				else
					w_country = document.getElementById(id+"_countryform_id_temp").value;					
					
				w_mini_labels=[w_street1, w_street2, w_city, w_state, w_postal, w_country];

				
				var disabled_input = document.getElementById(id+"_disable_fieldsform_id_temp");
				
					w_street1_dis= disabled_input.getAttribute('street1');
					w_street2_dis= disabled_input.getAttribute('street2');
					w_city_dis= disabled_input.getAttribute('city');
					w_state_dis= disabled_input.getAttribute('state');
					w_us_states_dis= disabled_input.getAttribute('us_states');
					w_postal_dis= disabled_input.getAttribute('postal');
					w_country_dis= disabled_input.getAttribute('country');
				
						
			w_disabled_fields=[w_street1_dis, w_street2_dis, w_city_dis, w_state_dis,  w_postal_dis, w_country_dis, w_us_states_dis];
			
			atrs=return_attributes(id+'_street1form_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
			
			
				form_fields+=w_field_label+"*:*w_field_label*:*";
				form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
				form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
				form_fields+=w_size+"*:*w_size*:*";
				form_fields+=w_mini_labels.join('***')+"*:*w_mini_labels*:*";
				form_fields+=w_disabled_fields.join('***')+"*:*w_disabled_fields*:*";
				form_fields+=w_required+"*:*w_required*:*";
				form_fields+=w_class+"*:*w_class*:*";
				
				for(j=0; j<w_attr_name.length; j++)
				{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
				}
				
				form_fields+="*:*new_field*:*";	
				break;
			}

		case 'type_submitter_mail':
		{
			w_first_val=document.getElementById(id+"_elementform_id_temp").value;
			w_title=document.getElementById(id+"_elementform_id_temp").title;
	
			atrs=return_attributes(id+'_elementform_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
			
				form_fields+=w_field_label+"*:*w_field_label*:*";
				form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
				form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
				form_fields+=w_size+"*:*w_size*:*";
				form_fields+=w_first_val+"*:*w_first_val*:*";
				form_fields+=w_title+"*:*w_title*:*";
				form_fields+=w_required+"*:*w_required*:*";
				form_fields+=w_unique+"*:*w_unique*:*";
				form_fields+=w_class+"*:*w_class*:*";
				
				for(j=0; j<w_attr_name.length; j++)
				{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
				}
				
				form_fields+="*:*new_field*:*";	
				break;
			}
		
		case 'type_captcha':
		{
			w_digit=document.getElementById("_wd_captchaform_id_temp").getAttribute("digit");
			atrs=return_attributes('_wd_captchaform_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
			
			
				form_fields+=w_field_label+"*:*w_field_label*:*";
				form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
				form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
				form_fields+=w_digit+"*:*w_digit*:*";
				form_fields+=w_class+"*:*w_class*:*";
				
				for(j=0; j<w_attr_name.length; j++)
				{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
				}
				form_fields+="*:*new_field*:*";	
				break;

		}
		case 'type_recaptcha':
		{
			w_public  = document.getElementById("wd_recaptchaform_id_temp").getAttribute("public_key");
			w_private  = document.getElementById("wd_recaptchaform_id_temp").getAttribute("private_key");
			w_theme  = document.getElementById("wd_recaptchaform_id_temp").getAttribute("theme");
			
			atrs=return_attributes('wd_recaptchaform_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
			
			form_fields+=w_field_label+"*:*w_field_label*:*";
			form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
			form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
			form_fields+=w_public+"*:*w_public*:*";
			form_fields+=w_private+"*:*w_private*:*";
			form_fields+=w_theme+"*:*w_theme*:*";
			form_fields+=w_class+"*:*w_class*:*";
			
			for(j=0; j<w_attr_name.length; j++)
			{
			form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
			}
			form_fields+="*:*new_field*:*";	
			document.getElementById("public_key").value = document.getElementById("wd_recaptchaform_id_temp").getAttribute("public_key");
			document.getElementById("private_key").value= document.getElementById("wd_recaptchaform_id_temp").getAttribute("private_key");

			break;

		}
		case 'type_checkbox':
		{	
		
		
			w_randomize=document.getElementById(id+"_randomizeform_id_temp").value;
			w_allow_other=document.getElementById(id+"_allow_otherform_id_temp").value;
			tt=0
			v=0;
			for(k=0;k<100;k++)
				if(document.getElementById(id+"_elementform_id_temp"+k))
				{
					if(document.getElementById(id+"_elementform_id_temp"+k).getAttribute('other'))
						if(document.getElementById(id+"_elementform_id_temp"+k).getAttribute('other')=='1')
							w_allow_other_num=tt;
					w_choices[tt]=document.getElementById(id+"_elementform_id_temp"+k).value;
          w_choices[tt] = w_choices[tt].replace(/"/g, "&quot;");
					if(w_choices[tt][w_choices[tt].length-1]==' ')
						w_choices[tt]=w_choices[tt].substring(0, w_choices[tt].length-1);
					w_choices_checked[tt]=document.getElementById(id+"_elementform_id_temp"+k).checked;
					tt++;
					v=k;
				}
				
			if(document.getElementById(id+"_rowcol_numform_id_temp").value)	
			{
				
                if(document.getElementById(id+'_table_little').getAttribute('for_hor'))
					w_flow="hor"	
				else
					w_flow="ver";				
				w_rowcol = 	document.getElementById(id+"_rowcol_numform_id_temp").value;
			}
			else
			{
				if(document.getElementById(id+'_hor'))
					w_flow="hor"	
				else
					w_flow="ver";
				
				w_rowcol = '';
			}	
				
				
			atrs=return_attributes(id+'_elementform_id_temp'+v);
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
			
				form_fields+=w_field_label+"*:*w_field_label*:*";
				form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
				form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
				form_fields+=w_flow+"*:*w_flow*:*";
				form_fields+=w_choices.join('***')+"*:*w_choices*:*";
				form_fields+=w_choices_checked.join('***')+"*:*w_choices_checked*:*";
				form_fields+=w_rowcol+"*:*w_rowcol*:*";
				form_fields+=w_required+"*:*w_required*:*";
				form_fields+=w_randomize+"*:*w_randomize*:*";
				form_fields+=w_allow_other+"*:*w_allow_other*:*";
				form_fields+=w_allow_other_num+"*:*w_allow_other_num*:*";
				form_fields+=w_class+"*:*w_class*:*";
				
				for(j=0; j<w_attr_name.length; j++)
				{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
				}
				
				form_fields+="*:*new_field*:*";	
				break;
			}
		
		case 'type_radio':
		{	
			w_randomize=document.getElementById(id+"_randomizeform_id_temp").value;
			w_allow_other=document.getElementById(id+"_allow_otherform_id_temp").value;

			v=0;
			tt=0;
			for(k=0;k<100;k++)
				if(document.getElementById(id+"_elementform_id_temp"+k))
				{
					if(document.getElementById(id+"_elementform_id_temp"+k).getAttribute('other'))
						if(document.getElementById(id+"_elementform_id_temp"+k).getAttribute('other')=='1')
							w_allow_other_num=tt;
					w_choices[tt]=document.getElementById(id+"_elementform_id_temp"+k).value;
					if(w_choices[tt][w_choices[tt].length-1]==' ')
						w_choices[tt]=w_choices[tt].substring(0, w_choices[tt].length-1);
					w_choices_checked[tt]=document.getElementById(id+"_elementform_id_temp"+k).checked;
				
			
					tt++;
					v=k;
				}
			
								
				if(document.getElementById(id+"_rowcol_numform_id_temp").value)	
				{
				
					if(document.getElementById(id+'_table_little').getAttribute('for_hor'))
						w_flow="hor"	
					else
						w_flow="ver";				
					w_rowcol = 	document.getElementById(id+"_rowcol_numform_id_temp").value;
				}
				else
				{
					if(document.getElementById(id+'_hor'))
						w_flow="hor"	
					else
						w_flow="ver";
					
					w_rowcol = '';
				}
				
			
			atrs=return_attributes(id+'_elementform_id_temp'+v);
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
			
				form_fields+=w_field_label+"*:*w_field_label*:*";
				form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
				form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
				form_fields+=w_flow+"*:*w_flow*:*";
				form_fields+=w_choices.join('***')+"*:*w_choices*:*";
				form_fields+=w_choices_checked.join('***')+"*:*w_choices_checked*:*";
				form_fields+=w_rowcol+"*:*w_rowcol*:*";
				form_fields+=w_required+"*:*w_required*:*";
				form_fields+=w_randomize+"*:*w_randomize*:*";
				form_fields+=w_allow_other+"*:*w_allow_other*:*";
				form_fields+=w_allow_other_num+"*:*w_allow_other_num*:*";
				form_fields+=w_class+"*:*w_class*:*";
				
				for(j=0; j<w_attr_name.length; j++)
				{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
				}
				
				form_fields+="*:*new_field*:*";	
				break;
			}
		
		
		case 'type_own_select':
		{	
			tt=0;
			for(k=0;k<100;k++)
				if(document.getElementById(id+"_option"+k))
				{
					w_choices[tt]=document.getElementById(id+"_option"+k).innerHTML;
					w_choices_checked[tt]=document.getElementById(id+"_option"+k).selected;
					if(document.getElementById(id+"_option"+k).value=="")
						w_choices_disabled[tt]=true;
					else
						w_choices_disabled[tt]=false;
					tt++;
				}
				
			atrs=return_attributes(id+'_elementform_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];


				form_fields+=w_field_label+"*:*w_field_label*:*";
				form_fields+=w_field_label_size+"*:*w_field_label_size*:*";
				form_fields+=w_field_label_pos+"*:*w_field_label_pos*:*";
				form_fields+=w_size+"*:*w_size*:*";
				form_fields+=w_choices.join('***')+"*:*w_choices*:*";
				form_fields+=w_choices_checked.join('***')+"*:*w_choices_checked*:*";
				form_fields+=w_choices_disabled.join('***')+"*:*w_choices_disabled*:*";
				form_fields+=w_required+"*:*w_required*:*";
				form_fields+=w_class+"*:*w_class*:*";
				
				for(j=0; j<w_attr_name.length; j++)
				{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
				}
				form_fields+="*:*new_field*:*";	
				break;


		}
		
		case 'type_map':
		{
			w_lat=[];
			w_long=[];
			w_info=[];
			
			w_center_x  = document.getElementById(id+"_elementform_id_temp").getAttribute("center_x");
			w_center_y  = document.getElementById(id+"_elementform_id_temp").getAttribute("center_y");
			w_zoom  = document.getElementById(id+"_elementform_id_temp").getAttribute("zoom");
			w_width = parseInt(document.getElementById(id+"_elementform_id_temp").style.width);
			w_height= parseInt(document.getElementById(id+"_elementform_id_temp").style.height);
			
			
			
			for(j=0; j<=20; j++)
				if( document.getElementById(id+"_elementform_id_temp").getAttribute("lat"+j))
				{
					w_lat.push(document.getElementById(id+"_elementform_id_temp").getAttribute("lat"+j));
					w_long.push(document.getElementById(id+"_elementform_id_temp").getAttribute("long"+j));
					w_info.push(document.getElementById(id+"_elementform_id_temp").getAttribute("info"+j));
				}

			atrs=return_attributes(id+'_elementform_id_temp');
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];


				form_fields+=w_field_label+"*:*w_field_label*:*";
				form_fields+=w_center_x+"*:*w_center_x*:*";
				form_fields+=w_center_y+"*:*w_center_y*:*";
				form_fields+=w_long.join('***')+"*:*w_long*:*";
				form_fields+=w_lat.join('***')+"*:*w_lat*:*";
				form_fields+=w_zoom+"*:*w_zoom*:*";
				form_fields+=w_width+"*:*w_width*:*";
				form_fields+=w_height+"*:*w_height*:*";
				form_fields+=w_info.join('***')+"*:*w_info*:*";
				form_fields+=w_class+"*:*w_class*:*";
				
				for(j=0; j<w_attr_name.length; j++)
				{
				form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
				}
				form_fields+="*:*new_field*:*";	
				break;


		}
		case 'type_submit_reset':
		{
			atrs=return_attributes(id+'_element_submitform_id_temp');
			w_act=!(document.getElementById(id+"_element_resetform_id_temp").style.display=="none");
			w_attr_name=atrs[0];
			w_attr_value=atrs[1];
			w_submit_title = document.getElementById(id+"_element_submitform_id_temp").value;
			w_reset_title  = document.getElementById(id+"_element_resetform_id_temp").value;
			
			form_fields+=w_field_label+"*:*w_field_label*:*";
			form_fields+=w_submit_title+"*:*w_submit_title*:*";
			form_fields+=w_reset_title+"*:*w_reset_title*:*";
			form_fields+=w_class+"*:*w_class*:*";
			form_fields+=w_act+"*:*w_act*:*";
			
			for(j=0; j<w_attr_name.length; j++)
			{
			form_fields+=w_attr_name[j]+"="+w_attr_value[j]+"*:*w_attr_name*:*";
			}
			form_fields+="*:*new_field*:*";	
			break;
		}

	}
}
