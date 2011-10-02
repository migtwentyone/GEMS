var fields=new Array();

function bodyLoad(){
	var i,j,n,k;
	for(i=document.forms.length-1;i>=0;--i){
		fields[i]=new Array();
		for(j=document.forms[i].elements.length-1,k=0;j>=0;--j){
			n=document.forms[i].elements[j];
			if(n.name!="")
				fields[i][k++]=n;
			if((n.type=="text" || n.type=="password") && n.tagName.toLowerCase()=="input")
				n.onfocus=Focus;
		}
	}
	fields[0][fields[0].length-1].focus();
}
function Focus(){
	this.select();
}
function loginSubmit(){
	for(var i=fields[0].length-1;i>=0;--i)
		if(fields[0][i].value==""){
			breakLogin();
			fields[0][i].focus();
			return false;
		}
	return true;
}
function breakLogin(){
	alert("empty fields");
}