(function() {
  tinymce.create('tinymce.plugins.contact_form_maker_mce', {
    init : function(ed, url) {
      ed.addCommand('mceconact_Form_Maker_mce', function() {
        ed.windowManager.open({
          file : contact_form_maker_admin_ajax,
					width : 400 + ed.getLang('contact_form_maker_mce.delta_width', 0),
					height : 250 + ed.getLang('contact_form_maker_mce.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url /* Plugin absolute URL.*/
				});
			});
      ed.addButton('contact_form_maker_mce', {
        title : 'Insert Contact Form',
        cmd : 'mceconact_Form_Maker_mce',
        image: url + '/images/contact_form_maker_logo20.png'
      });
    }
  });
  tinymce.PluginManager.add('contact_form_maker_mce', tinymce.plugins.contact_form_maker_mce);
})();