function ahmed(entered, alertbox)
{
with (entered)
{
apos=value.indexOf("@"); 
dotpos=value.lastIndexOf(".");
lastpos=value.length-1;
if (apos<1 || dotpos-apos<2 || lastpos-dotpos>3 || lastpos-dotpos<2) 
{if (alertbox) {alert(alertbox);} return false;}
else {return true;}
}
} 
function isblank(s)
{
    for(var i = 0; i < s.length; i++) {
        var c = s.charAt(i);
        if ((c != ' ') && (c != '\n') && (c != '\t')) return false;
    }
    return true;
}
function mariam(f)
{
    var msg;
    var empty_fields = "";
    var errors = "";


    for(var i = 0; i < f.length; i++) {
        var e = f.elements[i];
        if (((e.type == "text") || (e.type == "textarea")) && !e.optional) {

            if ((e.value == null) || (e.value == "") || isblank(e.value)) {
                empty_fields += "\n          " + e.name;
                continue;
            }

            if (e.numeric || (e.min != null) || (e.max != null)) { 
                var v = parseFloat(e.value);
                if (isNaN(v) || 
                    ((e.min != null) && (v < e.min)) || 
                    ((e.max != null) && (v > e.max))) {
                    errors += "- ﬁÌ„… " + e.name + " ÌÃ» √‰  ﬂÊ‰ —ﬁ„« ..";
                    if (e.min != null) 
                        errors += " √ﬂ»— „‰ " + e.min;
                    if (e.max != null && e.min != null) 
                        errors += " Ê√’€— „‰ " + e.max;
                    else if (e.max != null)
                        errors += " √’€— „‰ " + e.max;
                    errors += ".\n";
                }
            }
        }
    }
	
	      if (f.«·≈Ì„Ì·.value.indexOf("@") == -1 || f.«·≈Ì„Ì·.value.indexOf(".") == -1 || f.«·≈Ì„Ì·.value.length < 7 ) {
         errors += "„‰ ›÷·ﬂ «ﬂ » ≈Ì„Ì·« ’ÕÌÕ«";
         f.«·≈Ì„Ì·.focus();
          }


     if (!empty_fields && !errors) return true;
    msg  = "______________________________________________________\n\n"
    msg += "·„ Ì„ﬂ‰ ≈—”«· «·—”«·… ..\n";
    msg += "„‰ ›÷·ﬂ ’ÕÕ Â–Â «·√Œÿ«¡ ÊÕ«Ê· «·≈—”«· „—… √Œ—Ï ..\n";
    msg += "______________________________________________________\n\n"
    if (empty_fields) {
        msg += "- ÌÃ» ≈œŒ«·:" 
                + empty_fields + "\n";
        if (errors) msg += "\n";
    }
    msg += errors;
    alert(msg);
    return false;
}
