function checkloginform(form){
    var usererr = document.getElementById("usernameerror");
    var passerr = document.getElementById("passworderror");
    if(form.username != "" && form.password != ""){
        return true;
    }
    else{
        if(form.username != ""){usererr.style.display = "none";}
        if(form.password != ""){passerr.style.display = "none";}
        return false;
    }
}
function checksignupform(form){
    
}
function checkuserform(form){
    
}
