function postData(form, submitter, callbackFunction, errorFunction){
    const request = new XMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState == XMLHttpRequest.DONE && this.status == 200){
            callbackFunction(this);
        }else if(request.readyState == XMLHttpRequest.DONE && request.status != 200){
            console.error("Error: response failed");
            if (typeof errorFunction === "function") { 
                errorFunction(this);
            }
            return;
        }
    }
    request.open("POST", form.getAttribute("action"), true);
    // add submitter to data
    let data = new FormData(form);
    data.append(submitter.name, submitter.value);
    request.send(data);
}


function postForm(e){
    e.preventDefault();
    postData(e.target, e.submitter, (e)=>{
        console.log(e.responseText);
    }, (e)=>{
        // error
    });
}