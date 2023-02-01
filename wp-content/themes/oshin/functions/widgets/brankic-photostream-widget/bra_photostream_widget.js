/**
 * Function : dump()
 * Arguments: The data - array,hash(associative array),object
 *    The level - OPTIONAL
 * Returns  : The textual representation of the array.
 * This function was inspired by the print_r function of PHP.
 * This will accept some data as the argument and return a
 * text that will be a more readable version of the
 * array/hash/object that is given.
 * Docs: http://www.openjs.com/scripts/others/dump_function_php_print_r.php
 */
function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}

(function($){
    $.fn.extend({
        bra_photostream: function(options) {
 
            var defaults = {
                user: 'brankic1979',
                limit: 10,
				social_network: 'dribbble'
				
            };
            
			
			function create_html(data, container) {
				var feeds = data.feed;
				if (!feeds) {
					return false;
				}
				var html = '';		
				//html +=	'<div class="pinterest_header"><a href="'+feeds.link+'" title="'+ feeds.description +'">'+ feeds.title +'</a></div>';
				html += '<ul class="clearfix photostream">';
					
				for (var i = 0; i < feeds.entries.length; i++) {
					var entry = feeds.entries[i];
					var content = entry.content;
					html += '<li>'+ content +'</li>'		
				}
					
				html += '</ul>';
					
				$(container).html(html);
			
				$(container).find("li").each(function(){
					pin_img_src = $(this).find("img").attr("src");
					pin_url = "http://www.pinterest.com" + $(this).find("a").attr("href");
					pin_desc = $(this).find("p:nth-child(2)").html();
					pin_desc = pin_desc.replace("'", "`");
					$(this).empty();
					$(this).append("<a target='_blank' href='" + pin_url + "' title='" + pin_desc + "'><div class='photostream_overlay'></div><img src='" + pin_img_src + "' alt=''></a>");
					var img_w = $(this).find("img").width();
					var img_h = $(this).find("img").height();
					if (img_w < img_h){
						$(this).find("img").addClass("portrait")
					}
					else {
						$(this).find("img").addClass("landscape")
					}
				});
				//$(container).find("li:nth-child(3n)").addClass('last');
			};
			
			
			

			
						
			
			
			
            var options = $.extend(defaults, options);
         
            return this.each(function() {
				var o = options;
				var obj = $(this); 
				  
				if (o.social_network == "dribbble") {
					  obj.append("<ul class='clearfix'></ul>")
					  $.getJSON("http://dribbble.com/" + o.user + "/shots.json?callback=?", function(data){
							$.each(data.shots, function(i,shot){
								if (i < o.limit) {
								  var img_title = shot.title;
								  img_title = img_title.replace("'", "`")
								  var image = $('<img/>').attr({src: shot.image_teaser_url, alt: img_title});
								  var url = $('<a/>').attr({href: shot.url, target: '_blank', title: img_title});
								  var overlay = $('<div class="photostream_overlay"><div/>');
								  var url2 = $(url).append(image).append(overlay);
								  var li = $('<li/>').append(url2);
								  $("ul", obj).append(li);
								}
							});
							//obj.find('ul.clearfix').find("li:nth-child(3n)").addClass('last');
							$("li img", obj).each(function(){
								var img_w = $(this).width();
								var img_h = $(this).height();
								if (img_w < img_h){
									$(this).addClass("portrait")
								}
								else {
									$(this).addClass("landscape")
								}
							});	
					   });		  
				}
				if (o.social_network == "pinterest") {  
					var url = 'http://pinterest.com/' + o.user + '/feed.rss'
					var api = "http://ajax.googleapis.com/ajax/services/feed/load?v=1.0&callback=?&q=" + encodeURIComponent(url);
					api += "&num=" + o.limit;
					api += "&output=json_xml"
					
					//alert(api);
				
					// Send request
					$.getJSON(api, function(data){	
						// Check for error
						if (data.responseStatus == 200) {
							// Process the feeds
							create_html(data.responseData, obj);
				
							// Optional user callback function
						//	if ($.isFunction(fn)) fn.call(this,$e);
							
						} else {
							alert("wrong user for pinterest");
				
						};
					});	
				}

				if (o.social_network == "flickr") { 
					obj.append("<ul class='clearfix'></ul>")
					$.getJSON("http://api.flickr.com/services/rest/?method=flickr.people.findByUsername&username=" + o.user+ "&format=json&api_key=85145f20ba1864d8ff559a3971a0a033&jsoncallback=?", function(data){
						var nsid = data.user.nsid;
						$.getJSON("http://api.flickr.com/services/rest/?method=flickr.photos.search&user_id=" + nsid + "&format=json&api_key=85145f20ba1864d8ff559a3971a0a033&per_page=" + o.limit + "&page=1&extras=url_sq&jsoncallback=?", function(data){
							//console.log(data);
							$.each(data.photos.photo, function(i,img) {
								var img_owner = img.owner;
								var img_title = img.title;
								var img_src = img.url_sq;
								var img_id = img.id;
								var img_url = "http://www.flickr.com/photos/" + img_owner + "/" + img_id;
								var image = $('<img/>').attr({src: img_src, alt: img_title});
								var url = $('<a/>').attr({href: img_url, target: '_blank', title: img_title});
								var overlay = $('<div class="photostream_overlay"><div/>');
								var url2 = $(url).append(image).append(overlay);
								var li = $('<li/>').append(url2);
								$("ul", obj).append(li);
								//obj.find("li:nth-child(3n)").addClass('last');
							});
						});
					});
				}
				  
				if (o.social_network == "instagram") {
					obj.append("<ul class='clearfix'></ul>")
					var token = "188312888.f79f8a6.1b920e7f642b4693a4cb346162bf7154";						
					url =  "https://api.instagram.com/v1/users/search?q=" + o.user + "&access_token=" + token + "&count=10&callback=?";
					$.getJSON(url, function(data){
						$.each(data.data, function(i,shot) {
							var instagram_username = shot.username;
							if (instagram_username == o.user){
								var user_id = shot.id;
								if (user_id != "") {	
										url =  "https://api.instagram.com/v1/users/" + user_id + "/media/recent/?access_token=" + token + "&count=" + o.limit + "&callback=?";
										$.getJSON(url, function(data){
											$.each(data.data, function(i,shot){
											  var img_src = shot.images.thumbnail.url;
											  
											  var img_url = shot.link;
											  var img_title = "";
											  if (shot.caption != null){
											  img_title = shot.caption.text;
											  }
											  var image = $('<img/>').attr({src: img_src, alt: img_title});
											  var url = $('<a/>').attr({href: img_url, target: '_blank', title: img_title});
											  var overlay = $('<div class="photostream_overlay"><div/>');
											  var url2 = $(url).append(image).append(overlay);
											  var li = $('<li/>').append(url2);
											  $("ul", obj).append(li);
											 // obj.find("li:nth-child(3n)").addClass('last');
											});
										});
									}   
								}
							});
						});						
				}
			}); // return this.each
        }
    });
})(jQuery);