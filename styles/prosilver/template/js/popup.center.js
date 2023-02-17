//Open center window
	function popup_center(e) {
		var h = 700,
		w = 700;
		window.open(e, '', 'scrollbars=1, menubar=no, toolbar=no, location=no, height='+Math.min(h, screen.availHeight)+',width='+Math.min(w, screen.availWidth)+',left='+Math.max(0, (screen.availWidth - w)/2)+',top='+Math.max(0, (screen.availHeight - h)/2));
	}

