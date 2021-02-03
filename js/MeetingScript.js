function checkmeetingform(form){
    var nameerr = document.getElementById("nameerror");
    var durationerr = document.getElementById("durationerror");
    var stafferr = document.getElementById("stafferror");
    var err = setuperrvar();

    if(form.name.value != "" && form.duration.value > 5 && form.duration.value < 121 && form.staff.value > 0){
        return true;
    }
    else{
        setuperr(null,err);
        if(form.name.value != ""){nameerr.style.display = "none";}else{nameerr.style.display = "list-item";}
        if(form.duration.value > 5 && form.duration.value < 121){durationerr.style.display = "none";}else{durationerr.style.display = "list-item";}
        if(form.staff.value > 0){stafferr.style.display = "none";}else{stafferr.style.display = "list-item";}
        return false;
    }

}