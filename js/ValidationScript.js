function setuperrvar(){
	var err = document.getElementById("errors");
	
	if (!err){
		err = document.getElementById("errorsshow");
	}
	
	return err;
}

function setuperr(def,err){
	if(def){def.style.display = "none";}

    err.style.display = "block";
}
function validateEmail(email) {
    atpos = email.indexOf("@");
    dotpos = email.lastIndexOf(".");
    if (atpos < 1 || ( dotpos - atpos < 2 )) {
       return false;
    }
    return( true );
}

function validatetimedate(dateTime){
    return true;
}

function validatephone(phone){
    var phone_pattern = /\s*(([+](\s?\d)([-\s]?\d)|0)?(\s?\d)([-\s]?\d){9}|[(](\s?\d)([-\s]?\d)+\s*[)]([-\s]?\d)+)\s*/.test(phone);
    if(phone_pattern){
        return true;
    }
    return false;
}

function validatetime(time){
    var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(time);
    if (isValid) {
      return true
    }
    return false;
}
function validatedate(date){
    var re = /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-.\/])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;
    var flag = re.test(date);
    if(flag){
        return true;
    }
    return false;
}
