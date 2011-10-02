var fields=new Array();

function bodyLoad(){
	var j,n,k;
	for(j=document.forms[0].elements.length-1,k=0;j>=0;--j){
		n=document.forms[0].elements[j];
		if(n.name!="")
			fields[k++]=n;
		if((n.type=="text" || n.type=="password") && n.tagName.toLowerCase()=="input")
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