function postForm(e){
    e.preventDefault();
    // get data and add submitter button
    let formData = new FormData(e.target);
    formData.append(e.submitter.name, e.submitter.value);
    // create form
    const form = document.createElement("form");
    form.action = e.target.action;
    form.method = e.target.method;
    // foreach data add it to new form element
    for(const val of formData.entries()){
        let i = document.createElement("input");
        i.name = val[0];
        i.value = val[1];
        form.appendChild(i);
    }
    // post form + submitter included
    postData(form, (e)=>{
        console.log(e.responseText);
        var result = JSON.parse(e.responseText);
        console.log(result);
        if(result.newUserData !== undefined){
            // update user row
            users.updateUserData(result.newUserData);
        }
        if(result.postMethod === "delete" && result.error === false){
            users.removeUser(parseInt(result.UUID));
            // close overlay
            closeOverlay(document.querySelector(".overlay-page"));
        }
        // remove previous popups
        const pOverlay = document.querySelectorAll(".update-text-overlay");
        for(let i=0;i<pOverlay.length;i++){
            pOverlay[i].remove();
        }
        if("updateStatus" in result){
            // success
            // show green success bar on top
            const successText = result.updateStatus;
            const newUserData = result.newUserData;
            const error = result.error;
            if(newUserData != undefined){
                // update dom
                const el = document.querySelectorAll("p.title > span");
                el[0].innerText = newUserData["name"];
                el[1].innerText = newUserData["email"];
                el[2].innerText = newUserData["goals"];
                el[3].innerText = newUserData["assists"];
                el[4].innerText = newUserData["admin"];
            }
            const iel = document.querySelectorAll(".user-overlay-wrapper-card > input");
            for(let i=0;i<iel.length;i++){iel[i].value="";}
            // create p overlay text popup
            const p = document.createElement("p");
            p.innerHTML = successText;
            p.classList.add("update-text-overlay");
            if(error){
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
        if("undeletedUsers" in result){
            // delete all users except result.undeletedUsers from dom
            users.editUsers.clearUsers();
            for(let i=0;i<result.undeletedUsers.length;i++){
                users.editUsers.addUser(Number(result.undeletedUsers[i]));
            }
            for(let i=0;i<users.editUsers.users.length;i++){
                // add bulk delete things
                const el = document.querySelector(".bulk-edit-table > tbody > tr > input[value='" + users.editUsers.users[i] + "']");
                el.closest("tr").remove();
            }
            users.updateUserDOM();
        }
        users.updateUserDOM();
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