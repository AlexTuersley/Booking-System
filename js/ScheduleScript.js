function checkscheduleform(form){
    var dayerr = document.getElementById("dayerror");
    var stafferr = document.getElementById("stafferror");
    var starttimeerr = document.getElementById("starttimeerror");
    var endtimeerr = document.getElementById("endtimeerror");
    var timeerr = document.getElementById("timeerror");
    var err = setuperrvar();

    if(form.active.value > 0 && form.staff.value > 0 && validatetime(form.starttime.value) && validatetime(form.endtime.value) && form.endtime.value > form.starttime.value && form.day.value > 0 && form.day.value <= 7){
        return true;
    } else {
        setuperr(null,err);
        value.style.display = "list-item";
        if(form.day.value > 0 && form.day.value <= 7){dayerr.style.display = "none";}
        if(form.staff.value > 0){stafferr.style.display = "none";}
        if(validatetime(form.starttime.value)){starttimeerr.style.display = "none";}
        if(validatetime(form.endtime.value)){endtimeerr.style.display = "none";}
        if(form.endtime.value > form.starttime.value){timeerr.style.display = "none";}
                
        return false;
    }
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
function checkholidayform(form){
    var stafferr = document.getElementById("stafferror");
    var startdateerr = document.getElementById("starterror");
    var enddateerr = document.getElementById("enderror");
    var dateerr = document.getElementById('dateerror');

    if(form.staff.value > 0 && validatedate(form.startdate.value) && validatedate(form.enddate.value) && form.enddate.value > form.startdate.value){
        return true;
    }
    else{
        if(form.staff.value > 0){stafferr.style.display = "none";}
        if(validatedate(form.startdate.value)){startdateerr.style.display = "none";}
        if(validatedate(form.enddate.value)){enddateerr.style.display = "none";}
        if(form.enddate.value > form.startdate.value){dateerr.style.display = "none";}

        return false;
    }

}