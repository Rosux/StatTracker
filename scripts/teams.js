// open an overlay with link
function loadOverlay(url){
    getData(url, (e)=>{
        const overlay = document.createElement("div");
        overlay.classList.add("overlay-page");

        const closeButtonWrapper = document.createElement("div");
        const closeButton = document.createElement("div");
        closeButtonWrapper.classList.add("overlay-close-button-wrapper");
        closeButton.classList.add("overlay-close-button");
        closeButton.setAttribute("onclick", "closeOverlay(this);");

        closeButtonWrapper.appendChild(closeButton);
        overlay.appendChild(closeButtonWrapper);
        overlay.innerHTML += e.responseText;
        overlay.style.overflow = "auto";
        document.body.appendChild(overlay);
        document.body.style.overflow = "hidden";


    }, (e)=>{/* error fuction */});
}
// closes all overlays
function closeOverlay(e){
    document.body.style.overflow = "auto";
    e.closest(".overlay-page").remove();
}
// post data to file
function postData(form, callbackFunction, errorFunction){
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
    request.send(new FormData(form));
}
// GET data to file
function getData(url, callbackFunction, errorFunction){
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
    request.open("GET", url, true);
    request.send();
}

// post form to new team page
function postTeamForm(e){
    e.preventDefault();
    // post form and data to form-action
    console.log(e.target);
    postData(e.target, (e)=>{
        const result = JSON.parse(e.responseText);
        if(result.error === false && result.closeOverlay === true){
            closeOverlay(document.querySelector(".overlay-page"));
        }
        // remove previous popups
        const pOverlay = document.querySelectorAll(".update-text-overlay");
        for(let i=0;i<pOverlay.length;i++){
            pOverlay[i].remove();
        }
        if("responseResult" in result){
            // success
            // create p overlay text popup
            const p = document.createElement("p");
            p.innerHTML = result.responseResult;
            p.classList.add("update-text-overlay");
            if(result.error === true){
                p.classList.add("overlay-error");
            }
            document.body.appendChild(p);
            p.fadein();
            setTimeout(()=>{
                p.classList.add("move-up");
                setTimeout(()=>{
                    p.remove();
                }, 1000);
            }, 3000);
        }
    }, (e)=>{
        // error
        const p = document.createElement("p");
        p.innerHTML = "Couldnt make any changes, try again later or contact us.<br>"+e.status+"<br>"+e.statusText;
        p.classList.add("update-text-overlay");
        p.classList.add("overlay-error");
        document.body.appendChild(p);
        p.fadein();
        setTimeout(()=>{
            p.classList.add("move-up");
            setTimeout(()=>{
                p.remove();
            }, 1000);
        }, 3000); 
    });
}



// load initial teams
let formData = new FormData();
formData.append("internalMethod", "getTeams");
const form = document.createElement("form");
form.action = "../php/manage-team.php";
form.method = "POST";
for(const val of formData.entries()){
    let i = document.createElement("input");
    i.name = val[0];
    i.value = val[1];
    form.appendChild(i);
}
console.log(form);
postData(form, (e)=>{
    const result = JSON.parse(e.responseText);
    teams = result.teams;
    console.log(teams);
    // DISPLAY TEAMS SOMEHOW






});