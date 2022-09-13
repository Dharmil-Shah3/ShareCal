/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referencing this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'77-Essential-Icons\'">' + entity + '</span>' + html;
	}
	var icons = {
		'icon-Plus': '&#x2b;',
		'icon-Attachment': '&#x61;',
		'icon-Reply': '&#x72;',
		'icon-BarGraph': '&#x67;',
		'icon-Book': '&#x52;',
		'icon-Bookmark': '&#x42;',
		'icon-Briefcase': '&#x62;',
		'icon-BrowserWindow': '&#x77;',
		'icon-Calendar': '&#x63;',
		'icon-Camera': '&#x43;',
		'icon-Cancel': '&#x78;',
		'icon-Clock': '&#x74;',
		'icon-CommentwithLines': '&#x6d;',
		'icon-Comment': '&#x4d;',
		'icon-Computer': '&#x31;',
		'icon-Controls': '&#x53;',
		'icon-Conversation': '&#x73;',
		'icon-CreditCard': '&#xa3;',
		'icon-Crosshair': '&#x54;',
		'icon-Diary': '&#x6e;',
		'icon-DownArrow': '&#x64;',
		'icon-Email': '&#x65;',
		'icon-Folder': '&#x66;',
		'icon-Forward': '&#x46;',
		'icon-Heart': '&#x33;',
		'icon-Home': '&#x68;',
		'icon-Inbox': '&#x44;',
		'icon-Layers': '&#x4c;',
		'icon-LeftArrow': '&#x3c;',
		'icon-Link': '&#x6c;',
		'icon-List': '&#x3a;',
		'icon-LocationMarker': '&#x50;',
		'icon-Location': '&#x4b;',
		'icon-Map': '&#x71;',
		'icon-Medal': '&#x48;',
		'icon-Menu': '&#x3d;',
		'icon-Microphone': '&#x41;',
		'icon-Minus': '&#x2d;',
		'icon-Options': '&#x6f;',
		'icon-MoreOptions': '&#x4f;',
		'icon-Music': '&#x4e;',
		'icon-Mute': '&#x58;',
		'icon-Notification': '&#x6a;',
		'icon-Padlock': '&#x6b;',
		'icon-Document': '&#x57;',
		'icon-Phone': '&#x69;',
		'icon-Photo': '&#x70;',
		'icon-PieChart': '&#x47;',
		'icon-Pin': '&#x4a;',
		'icon-View': '&#x531;',
		'icon-Printer': '&#x532;',
		'icon-Profile': '&#x533;',
		'icon-Rearrange': '&#x7a;',
		'icon-Refresh': '&#x7e;',
		'icon-RightArrow': '&#x3e;',
		'icon-Save': '&#x79;',
		'icon-Search': '&#x59;',
		'icon-Settings': '&#x32;',
		'icon-Share': '&#x40;',
		'icon-Shop': '&#x51;',
		'icon-Signals': '&#x7b;',
		'icon-Signal': '&#x7c;',
		'icon-Volume': '&#x5a;',
		'icon-Star': '&#x2a;',
		'icon-iPad': '&#x49;',
		'icon-Tag': '&#x45;',
		'icon-Checkmark': '&#x2f;',
		'icon-Toggle': '&#x60;',
		'icon-Trash': '&#x5f;',
		'icon-Typing': '&#x2e;',
		'icon-UpArrow': '&#x5e;',
		'icon-User': '&#x75;',
		'icon-Users': '&#x55;',
		'icon-VideoCamera': '&#x56;',
		'icon-Video': '&#x76;',
		'icon-Warning': '&#x21;',
		'icon-CreateNew': '&#x7d;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
