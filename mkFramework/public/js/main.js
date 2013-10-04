function getById(id){
	a=document.getElementById(id);
	if(a){
		return a;
	}
	return null;
}
surbrillanceId='';
function surbrillance(id){
	if(surbrillanceId!=''){
		getById('ligne_'+surbrillanceId).style.background='transparent';
	}
	getById('ligne_'+id).style.background='#ddd';
	surbrillanceId=id;
}
function affiche(id){
	a=document.getElementById(id);
	if(a){
		if(a.style.display=='none'){
			a.style.display='block';
		}else{
			a.style.display='none';
		}
	}
}