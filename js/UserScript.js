function checksigninform(form){
    var def = document.getElementById("defaulterror");
    var usererr = document.getElementById("usernameerror");
    var passerr = document.getElementById("passworderror");
    var err = setuperrvar();

    if(form.username.value != "" && form.password.value != ""){
        return true;
    }
    else{
        setuperr(def,err);
        if(form.username.value != ""){usererr.style.display = "none";}
        if(form.password.value != ""){passerr.style.display = "none";}
        return false;
    }
}
function checksignupform(form){
    var usererr = document.getElementById("usernameerror");
    var passerr = document.getElementById("passworderror");
    var fullnameerr = document.getElementById("fullnameerror");
    var emailerr = document.getElementById("emailerror");
    var departmenterr = document.getElementById("departmenterror");
    if(form.username.value != "" && form.password.value != "" && form.fullname.value != "" && form.email.value != ""){
        usererr.style.display = "none";
        passerr.style.display = "none";
        fullnameerr.style.display = "none";
        if(validateemail(form.email.value)){
            if(form.usercheckbox.checked === true && form.department.value > 0){
                return true;
            }
            else if(form.usercheckbox.checked === false && form.department.value === 0){
                return true;
            }
            else{
                emailerr.style.display = "none";
                return false;
            }
        } 
        else{
            if(form.usercheckbox.checked === true && form.department.value > 0){ departmenterr.style.display = "none";}
            if(form.usercheckbox.checked === false && form.department.value === 0){ departmenterr.style.display = "none";}
            return false;
        }
    }
    else{
        if(form.username.value != ""){usererr.style.display = "none";}
        if(form.password.value != ""){passerr.style.display = "none";}
        if(form.fullname.value != ""){fullnameerr.style.display = "none";}
        if(form.email.value != "" && validateemail(form.email.value)){emailerr.style.display = "none";}
        if(form.usercheckbox.checked === true && form.department.value > 0){ departmenterr.style.display = "none";}
        if(form.usercheckbox.checked === false && form.department.value === 0){ departmenterr.style.display = "none";}
        return false;
    }
}
function checkuserform(form){
    
}
