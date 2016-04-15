$(function(){
	$inputArea = $('#inputMessage');
	$inputArea.keypress(function(key){
         if (key.which === 13) {
         	key.preventDefault();
         	var msg = getMsg();
         	if (!msg) return;
         	clearMsg();
         }
	});
})

function getMsg(){
	return document.getElementById('inputMessage').value;
}

function clearMsg(){
	document.getElementById('inputMessage').value = "";
}
