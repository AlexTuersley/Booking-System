function checkdepartmentform(form){
    var nam = document.getElementById("nameerror");
    var err = setuperrvar();
    if(form.name.value != ""){
        return true;
    } else {
        setuperr(null,err);
        value.style.display = "list-item";
        
        if(form.value.value != ""){name.style.display = "none";}
                
        return false;
    }
}