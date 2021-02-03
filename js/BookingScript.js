function checkbooking(form){
    var studenterr = document.getElementById("studenterror");
    var stafferr = document.getElementById("stafferror");
    var bookerr = document.getElementById("bookingerror");
    var typeerr = document.getElementById("meetingerror");
    var starterr = document.getElementById("starterror");
    var enderr = document.getElementById("enderror");

    if(form.student.value > 0 && form.staff.value > 0 && form.type.value > 0){
        return true;
    }
    else{
        if(form.staff.value > 0){stafferr.style.display = "none";}else{stafferr.style.display = "list-item";}
        if(form.student.value > 0){studenterr.style.display = "none";}else{studenterr.style.display = "list-item";}
        if(form.type.value > 0){typeerr.style.display = "none";}else{typeerr.style.display = "list-item";}

        return false;
    }
}