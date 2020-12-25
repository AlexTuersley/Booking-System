function checkscheduleform(form){
    var activeawayerr = document.getElementById("defaulterror");
    var stafferr = document.getElementById("stafferror");
    var starttimeerr = document.getElementById("starttimeerror");
    var endtimeerr = document.getElementById("endtimeerror");
    var startdateerr = document.getElementById("starterror");
    var enddateerr = document.getElementById("enderror");
    var dateerr = document.getElementById('dateerror');
    var err = setuperrvar();
    if(form.active.value > 0 || form.away.value > 0 && staff > 0 && validatetime(starttime) && validatetime(endtime)){
        if(form.away > 0){
            if(validatedate(startdate) && validatedate(enddate) && enddate > startdate){
                return true;
              
            }
            if(validatedate(startdate)){startdateerr.style.display = "none";}
            if(validatedate(startdate)){startdateerr.style.display = "none";}
            if(enddate > startdate){dateerr.style.display = "none";}

            return false;
        }
        return true;
    } else {
        setuperr(null,err);
        value.style.display = "list-item";
        
        if(form.value.value != ""){name.style.display = "none";}
                
        return false;
    }
}