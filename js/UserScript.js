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
        else{usererr.style.display = "list-item";}
        if(form.password.value != ""){passerr.style.display = "none";}
        else{passerr.style.display = "list-item";}
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
        if(validateEmail(form.email.value)){
            if(form.usercheckbox.checked == true && form.department.value > 0){
                return true;
            }
            else if(form.usercheckbox.checked == false && form.department.value == 0){
                return true;
            }
            else{
                departmenterr.style.display = "list-item";
                emailerr.style.display = "none";
                return false;
            }
        } 
        else{
            if(form.usercheckbox.checked == true && form.department.value > 0){ departmenterr.style.display = "none";}else{departmenterr.style.display = "list-item";}
            if(form.usercheckbox.checked == false && form.department.value == 0){ departmenterr.style.display = "none";}else{departmenterr.style.display = "list-item";}
            return false;
        }
    }
    else{
        if(form.username.value != ""){usererr.style.display = "none";}else{usererr.style.display = "list-item";}
        if(form.password.value != ""){passerr.style.display = "none";}else{passerr.style.display = "list-item";}
        if(form.fullname.value != ""){fullnameerr.style.display = "none";}else{fullnameerr.style.display = "list-item";}
        if(form.email.value != "" && validateEmail(form.email.value)){emailerr.style.display = "none";}else{emailerr.style.display = "list-item";}
        if(form.usercheckbox.checked == true && form.department.value > 0){ departmenterr.style.display = "none";}else{departmenterr.style.display = "list-item";}

        if(form.usercheckbox.checked == false && form.department.value == 0){ departmenterr.style.display = "none";}else{departmenterr.style.display = "list-item";}
        return false;
    }
}



function checkforgottenpasswordform(form)
{
	var def = document.getElementById("defaulterror");
	var email = document.getElementById("emailerror");
	var adderror = document.getElementById("addresserror");
	
	var err = setuperrvar();

    if(form.email.value != "") 
    {
        if(validateEmail(form.email)){
        	return true;
        } else {
        	setuperr(def,err);
    	
    		adderror.style.display = "list-item";
    	
    		email.style.display = "none";
        
        	return false;

        }
    } else {
    	
    	setuperr(def,err);
    	
    	if(form.email.value != ""){email.style.display = "none";}
    	
    	adderror.style.display = "none";
        
        return false;
    }
}
function checkchangepasswordform(form)
{

	var deferr = document.getElementById("defaulterror");
	var olderr = document.getElementById("oldpassworderror");
	var newerr = document.getElementById("newpassworderror");
	var new1err = document.getElementById("new1passworderror");
	var matcherr = document.getElementById("passwordmatcherror");
    var badpwerr = document.getElementById("badpwerror");
	
	var err = setuperrvar();
	
	if(form.currentpassword.value != "" && passcheck(form.newpassword.value) == 0 && form.confirmpassword.value != "")
	{
		if(form.currentpassword.value != form.newpassword.value){
			//Match Error
			setuperr(deferr,err);
			
			matcherr.style.display = "list-item";
			
			olderr.style.display = "none";
			newerr.style.display = "none";
			new1err.style.display = "none";
            badpwerr.style.display = "none";
			
			return false;
		} else {
			return true;
		}
	} else {
		setuperr(deferr, err);
		
		if(form.currentpassword.value != ""){olderr.style.display = "none";}
		if(form.newpassword.value != "" && form.newpassword.length >= 8){newerr.style.display = "none";}
		if(form.confirmpassword.value != ""){new1err.style.display = "none";}
        if(passcheck(form.newpassword.value) != 2){badpwerr.style.display = "none";}
		
		matcherr.style.display = "none";
		
		return false;
	}

}

function passcheck(val){
    if(val == "password123" || val == "1234567891" || val == "qwertyuiop" || val == "ABCDE12345" || val == "12345ABCDE"){        
        return 2;
    }else{
         if(val != "" && val.length >= 8){
            return 0;
         }else{
            return 1;
         }
    }
}

function checkuserform(form){
    
}


