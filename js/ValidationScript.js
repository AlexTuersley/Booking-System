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
function validatedate(date)
{
    var error;
    if(date.length == 10)
    {
        //lenght ok
        if(date.charAt(2) == "/" && date.charAt(5) == "/"){
            //slashes ok
            var day = date.substr(0,2);
            var month = date.substr(3,2);
            if (day <= 31 && month <= 12)
            {
                //everything ok
                error = false;
            } else {
                error = true;
            }
        } else {
            error = true;
        }
    } else {
        error = true;
    }
    if(error)
    {
        //alert("The date must be in the format DD/MM/YYYY");
        return false;
    } else {
        return true;
    }
}

function validatetime(time)
{
	var error;
	if(time.length == 5)
	{
		//lenght ok
		if(time.charAt(2) == ":"){
			//: ok
			var hour = time.substr(0,2);
			var min = time.substr(3,2);
			if(hour <= 24 && min <= 60)
			{
				//all ok
				error = false;
			} else {
				error = true;
			}
		} else {
			error = true;
		}
	} else {
		error = true;
	}
	if(error)
	{
		//alert("The time must be in the format HH:MM");
		return false;
	} else {
		return true;
	}
}
