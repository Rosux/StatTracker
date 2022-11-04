const searchForm = document.querySelector(".admin-search-bar > form");
const searchInput = document.querySelectorAll(".admin-search-bar > form > input");
const searchResult = document.querySelector(".admin-search-result > table > tbody");
const searchResultCount = document.querySelector(".current-search-result-count");
const searchResultPageNumber = document.querySelector(".current-page-number");
const searchResultRowAmmount = document.querySelector(".admin-search-result-row-ammount");

class Users{
    constructor(users=[], splitAmmount=0){
        this.users = users;
        this.userPages = users;
        this.currentPage = 0;
        if(splitAmmount != undefined){
            this.splitUsers(splitAmmount);
        }else{
            this.splitUsers();
        }
    }
    updateUserData(userData){
        for(let i=0;i<this.users.length;i++){
            if(this.users[i].id == parseInt(userData.id)){
                this.users[i].name = userData.teamName;
                this.users[i].goals = userData.goals;
                this.users[i].assists = userData.assists;
                this.updateUserDOM();
            }
        }
    }
    removeUser(userId){
        for(let i=0;i<this.users.length;i++){
            if(this.users[i].id == userId){this.users.splice(i, 1);}
        }
        this.userPages = this.users;
        const page = this.currentPage;
        this.splitUsers(Number(searchResultRowAmmount.value));
        this.navigate(page);
        // this.updateUserDOM();
    }
    updateNewUsers(users, splitAmmount){
        this.users = users;
        this.userPages = users;
        this.currentPage = 0;
        if(splitAmmount != undefined){
            this.splitUsers(splitAmmount);
        }else{
            this.splitUsers();
        }
    }
    splitUsers(ammount=10){
        // split array in ammount of chunks
        let split = [];
        for(let i=0;i<this.users.length;i+=ammount){
            split.push(this.users.slice(i,i+ammount));
        }
        this.userPages = split;
        this.navigate("min");
    }
    navigate(ammount){
        // i dont know what this does...
        // if(this.userPages[this.currentPage] == undefined){
        //     return;
        // }
        if(ammount === "max"){
            this.currentPage = this.userPages.length-1;
            this.updateUserDOM();
        }else if(ammount === "min"){
            this.currentPage = 0;
            this.updateUserDOM();
        }else if(this.currentPage + ammount < this.userPages.length && this.currentPage + ammount >= 0){
            this.currentPage += ammount;
            this.updateUserDOM();
        }
    }
    updateUserDOM(){
        searchResult.replaceChildren();
        if(this.users.length == 0){
            searchResultCount.style.color = "hsl(0, 60%, 49%)";
        }else{
            searchResultCount.style.color = "";
        }
        searchResultCount.innerText = `Results: ${this.users.length}`;
        searchResultPageNumber.innerText = this.currentPage+1;
        if(this.userPages[this.currentPage] == undefined){
            return;
        }
        for(let i=0;i<this.userPages[this.currentPage].length;i++){
            // making id/name/email/goals/assists easy/short
            let id = this.userPages[this.currentPage][i]["id"];
            let name = this.userPages[this.currentPage][i]["name"];
            let teamgoals = this.userPages[this.currentPage][i]["team_goals"];
            let teamassists = this.userPages[this.currentPage][i]["team_assists"];
            // CREATE ELEMENT AND ADD INTO ROWS
            const tr = document.createElement('tr');
            let td = [];
            for(let i=0;i<6;i++){td.push(document.createElement("td"));}
            // set data
            td[1].innerHTML = "<p>" + id + "</p>"; // id
            td[2].innerHTML = "<p>" + name + "</p>"; // username
            td[3].innerHTML = "<p>" + teamgoals + "</p>"; // goals
            td[4].innerHTML = "<p>" + teamassists + "</p>"; // assists
            td[5].innerHTML = "<button type='button' value="+id+" onclick='editTeam("+id+")'>Edit Team</button>"; // button
            // append to <tr>
            for(let i=0;i<6;i++){
                tr.appendChild(td[i]);
            }
            // append to tbody
            searchResult.appendChild(tr);
        }
    }
}
searchResultRowAmmount.addEventListener("change", (e)=>{
    users.splitUsers(Number(e.target.value));
    users.updateUserDOM();
});
function navigate(ammount){
    users.navigate(ammount);
}

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
        console.log(e.responseText);
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

function postTeamUserForm(e){
    e.preventDefault();
    // return;
    const x = e;
    // post form and data to form-action
    // convert nodelist to array
    const output = [...e.target.querySelectorAll("tbody > tr input")];
    // split array
    let data = [];
    for(let i=0;i<output.length;i+=3){
        data.push(output.slice(i,i+3));
    }
    let formData = [];
    for(let i=0;i<data.length;i++){
        let returndata = {
            "id": data[i][0].id,
            "remove": data[i][0].checked,
            "goals": data[i][1].value,
            "assists": data[i][2].value
        };
        formData.push(returndata);
    }
    // create formdata and form and submit
    sendData = new FormData();
    sendData.append("userData", JSON.stringify(formData));
    sendData.append("adminPass", e.target.querySelector("input[name='adminPass']").value);
    sendData.append("teamid", e.target.querySelector("input[name='teamid']").value);
    sendData.append("internalMethod", e.submitter.name);
    sendData.append("teamname", e.target.querySelector("input[name='teamname']").value);
    console.log(sendData);
    // create form
    const form = document.createElement("form");
    form.action = e.target.action;
    form.method = e.target.method;
    // foreach data add it to new form element
    for(const val of sendData.entries()){
        let i = document.createElement("input");
        i.name = val[0];
        i.value = val[1];
        form.appendChild(i);
    }
    
    postData(form, (e)=>{
        console.log(e.responseText);
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
        if("removedUsers" in result){
            // REMOVE USERS FROM DOM
            const elements = [...x.target.querySelectorAll("tbody > tr input[name='delete[]']")];
            for(let j=0;j<elements.length;j++){
                for(let i=0;i<result.removedUsers.length;i++){
                    if(elements[j].id == result.removedUsers[i]){
                        elements[j].closest("tr").remove();
                    }
                }
            }
            console.log(elements);
        }
        if("newTeamName" in result){
            x.target.querySelector(".current-team-name").innerText = result.newTeamName;
            users.updateUserData({
                id: x.target.querySelector("input[name='teamid']").value,
                teamName: result.newTeamName
            });
        }
        if("newTeamGoals" in result){
            users.updateUserData({
                id: x.target.querySelector("input[name='teamid']").value,
                goals: result.newTeamGoals
            });
        }
        if("newTeamAssists" in result){
            users.updateUserData({
                id: x.target.querySelector("input[name='teamid']").value,
                assists: result.newTeamAssists
            });
        }
        if("updatedUsers" in result){
            // update users stats by requesting new ones
            getData("../pages/admin-team-overlay.php?teamid="+x.target.querySelector("input[name='teamid']").value, (e)=>{
                const res = document.createElement("div");
                res.classList.add("partial-load-element");
                res.innerHTML = e.responseText;
                // get table body and append
                const tbody = res.querySelector("table > tbody");
                realbody = document.querySelector(".bulk-edit-table > tbody")
                realbody.innerHTML = tbody.innerHTML;
            })
        }
        if("deletedTeam" in result){
            users.removeUser(result.deletedTeam);
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


const users = new Users();

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
postData(form, (e)=>{
    const result = JSON.parse(e.responseText);
    users.updateNewUsers(result.teams)
    users.updateUserDOM();
});

searchInput.forEach((item,index)=>{
    item.addEventListener("input", (e)=>{
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
        postData(searchForm, (e)=>{
            var result = JSON.parse(e.responseText);
            if(result.error == true){
                // display no users found
                users.updateNewUsers([],0);
                // users.updateUserDOM(); <-- dont think its needed if(bug){enable.this}
                searchResult.replaceChildren();
                tr = document.createElement("tr");
                td = document.createElement("td");
                td.setAttribute("colspan", "6");
                p = document.createElement("p");
                p.innerText = "No Users Found";
                tr.classList.add("admin-search-result-error-row");
                td.appendChild(p);
                tr.appendChild(td);
                searchResult.appendChild(tr);
                return;
            }
            users.updateNewUsers(result.teams)
            users.updateUserDOM();
        });
    });
});

function editTeam(id){
    // "../pages/edituseroverlay.php?userid="+id
    loadOverlay("../pages/admin-team-overlay.php?teamid="+id);
}