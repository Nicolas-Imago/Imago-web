/******************************************* INIT SCREEN ********************************************/
init_share_content();

function init_share_content() {
	$("a#text_line_1").text("En cliquant sur le bouton 'partager' ci-dessous, le lien de la page sera copié dans le presse-papier.");
	$("a#text_line_2").text("Vous serez ensuite automatiquement redirigé vers votre réseau social préféré.");
	$("a#text_line_3").text("Vous n'aurez plus alors qu'à y copier ce lien (Ctrl+V), puis ajouter votre commentaire et publier.");

	window.Clipboard = (function(window, document, navigator) {
		var textArea,
			copy;

		function isOS() {
			return navigator.userAgent.match(/ipad|iphone/i);
		}

		function createTextArea(text) {
			textArea = document.createElement('textArea');
			textArea.value = text;
			document.body.appendChild(textArea);
		}

		function selectText() {
			var range,
				selection;

			if (isOS()) {
				range = document.createRange();
				range.selectNodeContents(textArea);
				selection = window.getSelection();
				selection.removeAllRanges();
				selection.addRange(range);
				textArea.setSelectionRange(0, 999999);
			} else {
				textArea.select();
			}
		}

		function copyToClipboard() {
			document.execCommand('copy');
			document.body.removeChild(textArea);
		}

		copy = function(text) {
			console.log(text)
			createTextArea(text);
			selectText();
			copyToClipboard();
		};

		return {
			copy: copy
		};
	})(window, document, navigator);

	// Clipboard.copy(url);

	listen_button();
}

/*********************************************** LISTEN *********************************************/
function clearSelection() {
	var sel;
	if ( (sel = document.selection) && sel.empty ) {
		sel.empty();
	} else {
		if (window.getSelection) {
			window.getSelection().removeAllRanges();
		}
		var activeEl = document.activeElement;
		if (activeEl) {
			var tagName = activeEl.nodeName.toLowerCase();
			if ( tagName == "textarea" ||
				(tagName == "input" && activeEl.type == "text") ) {
				// Collapse the selection to the end
				activeEl.selectionStart = activeEl.selectionEnd;
			}
		}
	}
}


function listen_button() {
	// Listen mouse over
	$("a#action").hover(function() {
		$(this).css("cursor","pointer");
		$(this).css("color", "white");
	},function() {
		$(this).css("cursor","auto");
		$(this).css("color", "grey");
	});

	// Listen click on
	$("a#action").click(function() {
		Clipboard.copy(url);

		// var copyText = document.querySelector("#url");
		// copyText.select();
		// document.execCommand("copy");
		// copyText.unselect();

		// clearSelection()

		//      if (window.getSelection) {window.getSelection().removeAllRanges();}
		// else if (document.selection) {document.selection.empty();}

		// document.selection.empty();

		// navigator.permissions.query({name: "clipboard-write"}).then(result => { 
		// 			if (result.state == "granted" || result.state == "prompt") {
		//   			/* write to the clipboard now */
		// 			}
		// });

		// navigator.clipboard.writeText(url).then(function() {
		//   		/* clipboard successfully set */
		// 		}, function() {
		//   		/* clipboard write failed */
		// 		});

		if (social_network == "trombinobooq") {
			open("https://www.facebook.com","_blank")
		}

		if (social_network == "cock_a_doodle_doo") {
			open("https://www.twitter.com","_blank")
		}

	});
}
