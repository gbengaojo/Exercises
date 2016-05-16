jQuery(document).ready(function($) {

    $('.switch_options').each(function() {
        //This object
        var obj = $(this);

        var enb = obj.children('.switch_enable'); //cache first element, this is equal to ON
        var dsb = obj.children('.switch_disable'); //cache first element, this is equal to OFF
        var input = obj.children('input'); //cache the element where we must set the value
        var input_val = obj.children('input').val(); //cache the element where we must set the value

        /* Check selected */
        if (0 == input_val) {
            dsb.addClass('selected');
        }
        else if (1 == input_val) {
            enb.addClass('selected');
        }

        //Action on user's click(ON)
        enb.on('click', function() {
            $(dsb).removeClass('selected'); //remove "selected" from other elements in this object class(OFF)
            $(this).addClass('selected'); //add "selected" to the element which was just clicked in this object class(ON) 
            $(input).val(1).change(); //Finally change the value to 1
        });

        //Action on user's click(OFF)
        dsb.on('click', function() {
            $(enb).removeClass('selected'); //remove "selected" from other elements in this object class(ON)
            $(this).addClass('selected'); //add "selected" to the element which was just clicked in this object class(OFF) 
            $(input).val(0).change(); // //Finally change the value to 0
        });

    });

    $('#accordion-panel-general_setups').prepend(
        '<div class="user_sticky_note">'+
        '<h3 class="sticky_title">Need help?</h3>'+
        '<span class="sticky_info_row"><label class="row-element">View demo: </label> <a href="http://8degreethemes.com/demo/eightstore-lite/" target="_blank">here</a>'+
        '<span class="sticky_info_row"><label class="row-element">View documentation: </label><a href="http://8degreethemes.com/documentation/eightstore-lite/" target="_blank">here</a></span>'+
        '<span class="sticky_info_row"><label class="row-element">Support forum: </label><a href="https://8degreethemes.com/support/forum/eightstore-lite/" target="_blnak">here</a></span>'+
        '<span class="sticky_info_row"><label class="row-element">Email us: </label><a href="mailto:support@8degreethemes.com">support@8degreethemes.com<a/></span>'+
        '<span class="sticky_info_row"><label class="more-detail row-element">More Details: </label><a href="https://8degreethemes.com/wordpress-themes/" target="_blank">here</a></span>'+
        '</div>'
        );

    var upgrade_notice = '<div class="notice-up"><a class="upgrade-pro" target="_blank" href="https://8degreethemes.com/wordpress-themes/eightstore-pro/"><img src="http://8degreethemes.com/demo/upgrade-eightstore-lite.jpg" alt="UPGRADE TO EIGHTSTORE PRO" /></a>';
    upgrade_notice += '<a class="upgrade-pro-demo" target="_blank" href="http://8degreethemes.com/demos/?theme=eightstore-pro">EIGHTSTORE PRO DEMO</a></div>';
    jQuery('#customize-info').append(upgrade_notice);

});//document.ready close