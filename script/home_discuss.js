function registerComment(){
return true;
//ajax
//add comment
//return false;
}
function registerThread(){
	if(document.forms[0].thread.value==""){
		alert("Enter Thread name");
		return false;
	}
	return true;
}