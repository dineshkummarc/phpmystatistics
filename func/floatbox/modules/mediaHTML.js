Floatbox.prototype.mediaHTML_module = function(href, type, width, height) {
	var t = this;
	type = type.replace('media:', '');
	if (type === 'flash') {
		var classid = 'classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"',
			mime = 'type="application/x-shockwave-flash"',
			data = 'data="' + t.encodeHTML(href) + '"',
			pluginurl = 'http://get.adobe.com/flashplayer/',
			params = { wmode:'window', bgcolor:'', scale:'exactfit', base:'', play:'true',
				allowfullscreen:'true', loop:'true', quality:'high', salign:'' };
		params.flashvars = 'autoplay=1&amp;ap=true&amp;border=0&amp;rel=0';
		if (t.ffOld) params.wmode = t.ffMac ? 'window' : 'opaque';
		if (t.ffNew && href.indexOf('YV_YEP.swf') !== -1) params.wmode = 'window';
	} else if (type === 'silverlight') {
		var mime = 'type="application/x-silverlight-2"',
			data = 'data="data:application/x-silverlight-2,"',
			pluginurl = 'http://go.microsoft.com/fwlink/?LinkID=124807',
			params = { source: t.encodeHTML(href), allowHtmlPopupWindow:'', autoUpgrade:'', background:'', enablehtmlaccess:'',
				initparams:'', maxframerate:'', minRuntimeVersion:'', onerror:'', onfullscreenchanged:'', onload:'', onresize:'',
				onsourcedownloadcomplete:'', onsourcedownloadprogresschanged:'', splashscreensource:'', windowless:'' };
	} else {
		var classid = 'classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"',
			mime = 'type="video/quicktime"',
			data = 'data="' + t.encodeHTML(href) + '"',
			pluginurl = 'http://www.apple.com/quicktime/download/',
			params = { autoplay:'true', controller:'true', showlogo:'false', scale:'tofit' };
	}
	for (var name in params) {
		if (params.hasOwnProperty(name)) {
			var rex = new RegExp('[\\?&]' + name + '=([^&]+)', 'i'),
				match = rex.exec(href);
			if (match) params[name] = match[1];
		}
	}
	var level = fb.children.length ? fb.children.length : '',
		html = '<object id="fbObject' + level + '" width="' + width + '" height="' + height + '" ';
	if (t.ie && type !== 'silverlight') {
		html += classid + '>';
		params[type === 'flash' ? 'movie' : 'src'] = t.encodeHTML(href);
	} else {
		html += mime + ' ' + data + '>';
	}
	for (var name in params) {
		if (params.hasOwnProperty(name) && params[name]) {
			html += '<param name="' + name + '" value="' + params[name] + '" />';
		}
	}
	if (type === 'quicktime' && t.webkitMac) {
		html += '<embed ' + mime + ' src="' + t.encodeHTML(href) + '" width="' + width + '" height="' + height +
			'" autoplay="true" controller="true" showlogo="false" scale="tofit" pluginspage="' +
			pluginurl + '"></embed></object>';
	} else {
		html += '<p style="color:#000; background:#fff; margin:1em; padding:1em;">' +
			type.substr(0, 1).toUpperCase() + type.substr(1) + ' player is required to view this content.' +
			'<br /><a href="' + pluginurl + '">download player</a></p></object>';
	}
	return html;
};