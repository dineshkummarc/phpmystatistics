Floatbox.prototype.getMousedownHandler = function() {
	var t = this;
	return function(e) {
		if (!(t.currentItem && t.fbContent)) return;
		e = e || window.event;
		var target = e.target || e.srcElement,
			item = t.currentItem,
			startX = e.clientX,
			startY = e.clientY,
			box = t.fbBox.style,
			mainDiv = t.fbMainDiv.style,
			content = t.fbContent.style,
			posBox = t.pos.fbBox;
		if (target.id === 'fbDragger') {
			t.proportional = (item.type === 'img' || item.type.indexOf('media') === 0);
			if (typeof item.options.proportionalResize === 'boolean') {
				t.proportional = item.options.proportionalResize;
			}
			if (t.proportional) {
				var w = typeof item.nativeWidth === 'number' ? item.nativeWidth : t.pos.fbMainDiv.width,
					h = typeof item.nativeHeight === 'number' ? item.nativeHeight : t.pos.fbMainDiv.height,
					ratio = w / h;
			}
			startX -= t.dragResizeDx;
			startY -= t.dragResizeDy;
			t.bod.style.cursor = 'nw-resize';
			t.dragResizing = true;
		} else if (/fb(Box|Corner|Canvas|InfoPanel|CaptionDiv|ControlPanel|IndexLinks)/.test(target.id)) {
			var boxX = posBox.left,
				boxY = posBox.top;
			t.bod.style.cursor = 'move';
			t.dragResizing = false;
		} else {
			return;
		}
		var upHandler = function(e) {
			e = e || window.event;
			t.clearTimeout('mouseup');
			if (t.doc.removeEventListener) {
				t.doc.removeEventListener("mouseup", upHandler, true);
				t.doc.removeEventListener("mousemove", moveHandler, true);
			} else if (t.fbBox.detachEvent) {
				t.fbBox.detachEvent("onlosecapture", upHandler);
				t.fbBox.detachEvent("onmouseup", upHandler);
				t.fbBox.detachEvent("onmousemove", moveHandler);
				t.fbBox.releaseCapture();
			}
			if (t.dragResizing) {
				t.dragResizing = false;
			} else if (t.stickyDragMove) {
				t.dragMoveDx += posBox.left - boxX;
				t.dragMoveDy += posBox.top - boxY;
			}
		  	t.leftRatio = t.topRatio = false;
			t.bod.style.cursor = 'default';
			content.visibility = '';
			return t.stopEvent(e);
		};
		var moveHandler = function(e) {
			e = e || window.event;
			if (item.type === 'iframe' && !content.visibility) content.visibility = 'hidden';
			if (t.isSlideshow && !t.isPaused) t.setPause(true);
			var dx = e.clientX - startX,
				dy = e.clientY - startY;
			if (t.dragResizing) {
				if (t.proportional) {
					var dragTotal = dx + dy;
					dy = dragTotal / (ratio + 1);
					dx = dragTotal - dy;
				}
				t.dragResizeDx = dx;
				t.dragResizeDy = dy;
				t.calcSize(false);
			} else {
				box.left = (posBox.left = boxX + dx) + 'px';
				box.top = (posBox.top = boxY + dy) + 'px';
			}
			t.clearTimeout('mouseup');
			t.setTimeout('mouseup', upHandler, 1500);
			return t.stopEvent(e);
		};
		if (t.doc.addEventListener) {
			t.doc.addEventListener("mousemove", moveHandler, true);
			t.doc.addEventListener("mouseup", upHandler, true);
		} else if (t.fbBox.attachEvent) {
			t.fbBox.setCapture();
			t.fbBox.attachEvent("onmousemove", moveHandler);
			t.fbBox.attachEvent("onmouseup", upHandler);
			t.fbBox.attachEvent("onlosecapture", upHandler);
		}
		return t.stopEvent(e);
	};
};
if ((fb.enableDragMove || fb.enableDragResize) && fb.fbBox && !fb.fbBox.onmousedown) fb.fbBox.onmousedown = fb.getMousedownHandler;