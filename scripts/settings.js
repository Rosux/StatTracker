formInputs = document.querySelectorAll("[form-validation]");
for(let i=0;i<formInputs.length;i++){
    formInputs[i].addEventListener("input", (e)=>{
        input = e.target.value;
        submitInput = formInputs[i].parentElement.parentElement.querySelectorAll("*:not(:nth-child(1)):not(:nth-child(2))");
        if(input != ""){
            submitInput.show();
        }else{
            submitInput.hide();
        }
    });
    x = formInputs[i].parentElement.parentElement.querySelectorAll("*:not(:nth-child(1)):not(:nth-child(2))");
    x.hide();
}