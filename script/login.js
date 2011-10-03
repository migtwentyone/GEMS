var fields=new Array();

function bodyLoad(){
	var j,n,k;
	for(j=document.forms[0].elements.length-1,k=0;j>=0;--j){
		n=document.forms[0].elements[j];
		if(n.name!="" && n.type.toLowerCase()!="submit" && n.type.toLowerCase()!="hidden")
			fields[k++]=n;
		if((n.type.toLowerCase()=="text" || n.type.toLowerCase()=="password"))
			n.onfocus=Focus;
	}
	fields[fields.length-1].focus();
}
function Focus(){
	this.select();
}
function loginSubmit(){
	for(var i=fields.length-1;i>=0;--i)
		if(fields[i].value==""){
			breakLogin();
			fields[i].focus();
			return false;
		}
	return true;
}
function breakLogin(){
	alert("empty fields");
}