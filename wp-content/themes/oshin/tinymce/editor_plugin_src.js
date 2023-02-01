/*******************
Author:
Brand Exponent Team
*******************/
;(function() {
	tinymce.PluginManager.requireLangPack('tinyplugin');
	tinymce.create('tinymce.plugins.tinypluginPlugin', {
		/**
		* Initializes the plugin, this will be executed after the plugin has been created.
		* This call is done before the editor instance has finished it's initialization so use the onInit event
		* of the editor instance to intercept that event.
		*
		* @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		* @param {string} url Absolute URL to where the plugin is located.
		*/
		init : function(ed, url) {
			/******* TEXT SHADOW ********/
			ed.addCommand('ShadowFormat', function(ui, v) {
				ed.formatter.toggle("ShadowFormat");
			});
			ed.addButton('text-shadow', {
				title : 'Text Shadow',
				cmd   : 'ShadowFormat',
				image : url + '/img/tinyplugin.png'
			});
			ed.onNodeChange.add(function(ed, cm, n) {
				active = ed.formatter.match('ShadowFormat');
				if(active == true) {
					cm.setActive('text-shadow', true);
				} else {
					cm.setActive('text-shadow', false);
				}
			});
			ed.onInit.add(function(ed, e) {
				ed.formatter.register('ShadowFormat', 
				{inline: 'span', classes : ['text-shadow'] } );
			});
			ed.addCommand('ShadowFormattest', function(ui, v) {
				ed.formatter.toggle("ShadowFormat");
			});
		},
		/**
		* Creates control instances based in the incomming name. This method is normally not
		* needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		* but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		* method can be used to create those.
		*
		* @param {String} n Name of the control to create.
		* @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		* @return {tinymce.ui.Control} New control instance or null if no control was created.
		*/
		createControl : function(n, cm) {
			return null;
		},
		/**
		* Returns information about the plugin as a name/value array.
		* The current keys are longname, author, authorurl, infourl and version.
		*
		* @return {Object} Name/value array containing information about the plugin.
		*/
		getInfo : function() {
			return {
				longname  : 'tinyplugin plugin',
				author    : 'Brand Exponent Team',
				authorurl : 'http://www.brandexponents.com',
				infourl   : 'http://www.brandexponents.com',
				version   : "1.1"
			};
		}
	});
	// Register plugin
	tinymce.PluginManager.add('tinyplugin', tinymce.plugins.tinypluginPlugin);
})();