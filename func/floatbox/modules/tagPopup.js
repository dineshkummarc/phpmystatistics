Floatbox.prototype.tagPopup = function(a) {
	var t = this,
		up = (a.popupType !== 'down'),
		thumb = a.thumb.style;
	a.thumb.id = a.thumb.id || 'fbPop' + (Math.random() + '').substring(2);
	thumb.borderWidth = t.zoomPopBorder + 'px';
	a.anchor.onmouseover = function() {
		thumb.display = 'none';
		var aPos = t.getLeftTop(this, true),
			aLeft = aPos.left,
			aTop = aPos.top;
		aPos = t.getLeftTop(this);
		thumb.display = '';
		var relLeft = (this.offsetWidth - a.thumb.offsetWidth)/2,
			relTop = up ? 2 - a.thumb.offsetHeight : this.offsetHeight,
			scroll = t.getScroll(),
			screenRight = scroll.left + t.getDisplayWidth();
		var spill = aPos.left + relLeft + a.thumb.offsetWidth - screenRight;
		if (spill > 0) relLeft -= spill;
		var spill = aPos.left + relLeft - scroll.left;
		if (spill < 0) relLeft -= spill;
		if (up) {
			if (aPos.top + relTop < scroll.top) relTop = this.offsetHeight;
		} else {
			if (aPos.top + relTop + a.thumb.offsetHeight > scroll.top + t.getDisplayHeight()) relTop = 2 - a.thumb.offsetHeight;
		}
		thumb.left = (aLeft + relLeft) + 'px';
		thumb.top = (aTop + relTop) + 'px';
	};
	a.anchor.onmouseout = function() {
		if (!a.popupLocked) {
			thumb.left = '0';
			thumb.top = '-9999px';
		}
	};
	if (!a.anchor.onclick) a.anchor.onclick = a.anchor.onmouseout;
};
while (fb.popups.length) fb.tagPopup(fb.popups.pop());