Floatbox.prototype.printContents_module = function(style) {
	var t = this,
		el = fb.lastChild.fbContent,
		styles = '<style type="text/css">html,body{border:0;margin:0;padding:0;}</style>',
		pos = fb.lastChild.pos.fbMainDiv,
		pwin = window.open('', '', 'width=' + pos.width + ',height=' + pos.height),
		pdoc = pwin && pwin.document;
	if (!pdoc) {
		alert('Popup windows are being blocked by your browser.\nUnable to print.');
		return false;
	}
	t.exec(t.currentItem, 'onPrint');
	t.exec(t.currentItem, 'beforePrint');
	if (el.tagName.toLowerCase() === 'iframe') {
		var idoc = el.contentDocument || (el.contentWindow && el.contentWindow.document);
		var ibod = idoc.getElementsByTagName('body')[0],
			html = '<div style="' + (ibod.getAttribute('style') || '') + '">' + ibod.innerHTML + '</div>';
		for (var tag in {link:'', style:''} ) {
			var els = idoc.getElementsByTagName(tag);
			for (var i = 0, len = els.length; i < len; i++) {
				styles += t.getOuterHTML(els[i]);
			}
		}
	} else {
		var html = '<div>' + t.getOuterHTML(el) + '</div>';
	}
	if (/\.css$/i.test(style)) {
		styles += '<link rel="stylesheet" type="text/css" href="' + style + '" />';
	} else if (style) {
		styles += '<style type="text/css">' + (style || '') + '</style>';
	}
	pdoc.open('text/html');
	pdoc.write('<!DOCTYPE html><html><head>' + styles + '</head><body ' +
		' onload="setTimeout(function(){ document.getElementsByTagName(\'body\')[0].focus(); print(); close(); }, 400);" ' +
		' onunload="window.opener.fb.lastChild.exec(window.opener.fb.lastChild.currentItem, \'afterPrint\');">' +
		html + '</body></html>');
	pdoc.close();
};