const searchForm = document.querySelector(".admin-search-bar > form");
const searchInput = document.querySelectorAll(".admin-search-bar > form > input");
const searchResult = document.querySelector(".admin-search-result > table > tbody");
const searchResultCount = document.querySelector(".current-search-result-count");
const searchResultPageNumber = document.querySelector(".current-page-number");
const searchResultRowAmmount = document.querySelector(".admin-search-result-row-ammount");
const bulkEditButton = document.querySelector(".bulkUserButton");

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

searchForm.addEventListener('submit', (e) => {
    e.preventDefault();
});

searchInput.forEach((item,index)=>{
    item.addEventListener("input", (e)=>{
        postData(searchForm, (e)=>{
            var result = JSON.parse(e.responseText);
            if(result == 1){
                // display no users found
                users.updateNewUsers([],0);
                // users.updateUserDOM(); <-- dont think its needed if(bug){enable.this}
                searchResult.replaceChildren();
                tr = document.createElement("tr");
                td = document.createElement("td");
                td.setAttribute("colspan", "7");
                p = document.createElement("p");
                p.innerText = "No Users Found";
                tr.classList.add("admin-search-result-error-row");
                td.appendChild(p);
                tr.appendChild(td);
                searchResult.appendChild(tr);
                return;
            }
            users.updateNewUsers(result)
            users.updateUserDOM();
        });
    });
});

searchResultRowAmmount.addEventListener("change", (e)=>{
    users.splitUsers(Number(e.target.value));
    users.updateUserDOM();
})


class Users{
    constructor(users=[], splitAmmount=0){
        this.users = users;
        this.userPages = users;
        this.currentPage = 0;
        this.editUsers = new EditUsers(users);
        if(splitAmmount != undefined){
            this.splitUsers(splitAmmount);
        }else{
            this.splitUsers();
        }
    }
    updateUserData(userData){
        for(let i=0;i<this.users.length;i++){
            if(this.users[i].id == userData.id){
                this.users[i].name = userData.name;
                this.users[i].email = userData.email;
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
        this.editUsers.removeUser(Number(userId));
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
            let email = this.userPages[this.currentPage][i]["email"];
            let goals = this.userPages[this.currentPage][i]["goals"];
            let assists = this.userPages[this.currentPage][i]["assists"];
            // CREATE ELEMENT AND ADD INTO ROWS
            const tr = document.createElement('tr');
            let td = [];
            for(let i=0;i<7;i++){td.push(document.createElement("td"));}
            // set data
            if(this.editUsers.users.includes(id)){
                tr.classList.add("selected-row");
                td[0].innerHTML = "<p>" + '<input type="checkbox" id="' + id + '" name="bulkSelectedUsers" checked>' + '<label for="' + id + '"></label>' + "</p>"; // bulk select
            }else{
                td[0].innerHTML = "<p>" + '<input type="checkbox" id="' + id + '" name="bulkSelectedUsers">' + '<label for="' + id + '"></label>' + "</p>"; // bulk select
            }
            td[1].innerHTML = "<p>" + id + "</p>"; // id
            td[2].innerHTML = "<p>" + name + "</p>"; // username
            td[3].innerHTML = "<p>" + email + "</p>"; // email
            td[4].innerHTML = "<p>" + goals + "</p>"; // goals
            td[5].innerHTML = "<p>" + assists + "</p>"; // assists
            td[6].innerHTML = "<button onclick='editUserPage(" + id + ")' type='button'>Edit user</button>"; // edit button
            // append to <tr>
            for(let i=0;i<7;i++){
                tr.appendChild(td[i]);
                td[i].addEventListener("mouseleave", (e)=>{
                    e.target.firstChild.scrollLeft = 0;
                });
            }
            // make buttons add user id to list
            td[0].querySelector("p > input").addEventListener("change", (e)=>{
                const val = e.target.checked;
                if(val){
                    e.target.closest("tr").classList.add("selected-row");
                    // add userid to list
                    this.editUsers.addUser(Number(e.target.id));
                }else{
                    e.target.closest("tr").classList.remove("selected-row");
                    // remove userid from list
                    this.editUsers.removeUser(Number(e.target.id));
                }
                if(this.editUsers.users.length > 0){
                    bulkEditButton.show();
                }else{
                    bulkEditButton.hide();
                }
            })
            // append to tbody
            searchResult.appendChild(tr);
        }
    }
}


// for bulk editing
class EditUsers{
    constructor(users=[]){
        // users = list of user id's
        this.users = users;
    }
    addUser(userid){
        // adds user id to bulk edit list
        if(typeof userid === "object"){
            for(let i=0;i<userid.length;i++){
                this.users.push(userid[i]);
            }
        }else{
            this.users.push(userid);
        }
    }
    clearUsers(){
        for(let i=0;i<this.users.length;i++){
            users.removeUser(this.users[i]);
        }
        bulkEditButton.hide();
        users.updateUserDOM();
    }
    removeUser(userid, e){
        // remove user from list
        const index = this.users.indexOf(userid);
        if(index > -1){
            this.users.splice(index, 1);
        }
        if(this.users.length > 0){
            bulkEditButton.show();
        }else{
            bulkEditButton.hide();
            if(e !== undefined){
                closeOverlay(e);
            }
        }
        // IMPORTANT
        // if overlay is on remove it from the table
        // ALSO UPDATE HTML
        if(e !== undefined){
            e.closest("tr").remove();
        }
    }
    addTeam(userid, teamid){
        // add user to team
    }
    createRandomTeam(teamid, teamPlayerLimit){
        // adds randomly selected users to teams (goes untill players empty or teams full)
    }
    bulkEditUsers(action, value){
        // create post request to edit all users
    }
    openOverlay(){
        // opens the overlay to edit users / bulk
        let data = new FormData();
        data.append("bulkUserIds", JSON.stringify(this.users));
        // JSON.parse(data.get("bulkUserIds")); // <------- these are the id's being sent
        // create form
        const form = document.createElement("form");
        form.action = "../pages/edituseroverlay.php"; // <---------- URL OF PAGE
        form.method = "POST";
        // foreach data add it to new form element
        for(const val of data.entries()){
            let i = document.createElement("input");
            i.name = val[0];
            i.value = val[1];
            form.appendChild(i);
        }
        postData(form, (e)=>{
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
        });
    }
}

const users = new Users();

bulkEditButton.hide();

function navigate(ammount){
    users.navigate(ammount);
}

postData(searchForm, (e)=>{
    var result = JSON.parse(e.responseText);
    users.updateNewUsers(result)
    users.updateUserDOM();
});




// opens new page popup with user data from id
function editUserPage(id){
    // "../pages/edituseroverlay.php?userid="+id
    loadOverlay("../pages/edituseroverlay.php?userid="+id);
}

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