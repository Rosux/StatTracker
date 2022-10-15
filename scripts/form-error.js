formInputs = document.querySelectorAll("[form-validation]");
for(i=0;i<formInputs.length;i++){
    formInputs[i].addEventListener("input", (e)=>{
        input = e.target.value;
        if(input == ""){
            document.querySelectorAll("[form-error="+e.target.getAttribute("form-validation")+"]")[0].innerHTML = "";
            return;
        }
        // checks here
        error = "";
        if(e.target.getAttribute("form-validation") == "username"){
            if(input.length < 4){
                error += "username must be between 4 and 30 characters<br>";
            }
            if(/[^A-Za-z]/.test(input)){
                error += "username can only containt a-z<br>";
            }
        }
        if(e.target.getAttribute("form-validation") == "email"){
            if(!/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test(input)){
                error += "Fill in a valid email<br>";
            }
        }
        if(e.target.getAttribute("form-validation") == "password"){
            if(!/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/.test(input)){
                error += "Password is not strong enough<br>";
            }
            if(input.length < 8 || input.length > 40){
                error += "Password must be between 8 and 40 characters<br>";
            }
        }
        // update error field
        document.querySelectorAll("[form-error="+e.target.getAttribute("form-validation")+"]")[0].innerHTML = "";
        document.querySelectorAll("[form-error="+e.target.getAttribute("form-validation")+"]")[0].innerHTML = error;
        // nice try this gets server verified too
    });
}