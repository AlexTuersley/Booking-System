function checkscheduleform(form){
    var dayerr = document.getElementById("dayerror");
    var stafferr = document.getElementById("stafferror");
    var starttimeerr = document.getElementById("starttimeerror");
    var endtimeerr = document.getElementById("endtimeerror");
    var timeerr = document.getElementById("timeerror");
    var err = setuperrvar();
   

    if(form.staff.value > 0 && form.starttime.value != "" && form.endtime.value != "" && form.endtime.value > form.starttime.value && form.day.value > 0 && form.day.value <= 7){
        if(validatetime(form.starttime.value) && validatetime(form.endtime.value)){
            return true;
        }
        else{
            if(validatetime(form.starttime.value)){starttimeerr.style.display = "none";}else{starttimeerr.style.display = "list-item";}
            if(validatetime(form.endtime.value)){endtimeerr.style.display = "none";}{endtimeerr.style.display = "list-item";}
            return false;
        }
       
      
    } else {
        if(form.endtime.value > form.starttime.value){
            setuperr(null,err);
        }
        else{
            setuperr(timeerr,err);
        }
        if(form.day.value > 0 && form.day.value <= 7){dayerr.style.display = "none";}else{dayerr.style.display = "list-item";}
        if(form.staff.value > 0){stafferr.style.display = "none";}else{stafferr.style.display = "list-item";}
        if(form.starttime.value != ""){if(validatetime(form.starttime.value)){starttimeerr.style.display = "none";}else{starttimeerr.style.display = "list-item";}}else{starttimeerr.style.display = "list-item";}
        if(form.endtime.value != ""){if(validatetime(form.endtime.value)){endtimeerr.style.display = "none";}{endtimeerr.style.display = "list-item";}}else{endtimeerr.style.display = "list-item";}
        return false;
    }
}
function checkholidayform(form){
    var stafferr = document.getElementById("stafferror");
    var startdateerr = document.getElementById("startdateerror");
    var enddateerr = document.getElementById("enddateerror");
    var dateerr = document.getElementById('dateerror');
    var err = setuperrvar();
    var parts = form.startdate.value.split(/[/]/);
    var parts2 = form.enddate.value.split(/[/]/);
    var startdate = `${parts[1]}/${parts[0]}/${parts[2]}`;
    var enddate = `${parts2[1]}/${parts2[0]}/${parts2[2]}`;

    if(form.staff.value > 0 && validatedate(startdate) && validatedate(enddate) && form.enddate.value > form.startdate.value){
        return true;
    }
    else{
        if(form.enddate.value > form.startdate.value){
            setuperr(dateerr,err);
        }
        else{
            setuperr(null,err);
        }
       
        if(form.staff.value > 0){stafferr.style.display = "none";}else{stafferr.style.display = "list-item";}
        if(validatedate(startdate)){startdateerr.style.display = "none";}else{startdateerr.style.display = "list-item";}
        if(validatedate(enddate)){enddateerr.style.display = "none";}else{enddateerr.style.display = "list-item";}
        if(form.enddate.value > form.startdate.value){dateerr.style.display = "none";}else{dateerr.style.display = "list-item";}

        return false;
    }

}