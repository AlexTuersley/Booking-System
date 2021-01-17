function checkmeetingform(form){
    var nameerr = document.getElementById();
    var durationerr = document.getElementById();

    if(form.name.value != "" && form.duration.value > 5 && form.duration.value < 121){
        return true;
    }
    else{
        if(form.name.value != ""){nameerr.style.display = "none";}
        if(form.duration.value > 5 && form.duration.value < 121){durationerr.style.display = "none";}
        return false;
    }

}