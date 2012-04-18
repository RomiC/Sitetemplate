ADM.init.page = function() {
	ADM.UI.modal();
	ADM.init.modal = function() {
		ADM.utils.formPost();
		ADM.utils.textEditor("textarea.tinymce", "bold,italic,underline,|,bullist,numlist,|,link,unlink,|,images,image,media,|,undo,redo,|,pagebreak,nonbreaking,|,visualchars", "advimage,images,media,nonbreaking,noneditable,pagebreak,paste,visualchars");
	};
}