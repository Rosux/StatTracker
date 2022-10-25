searchForm = document.querySelector(".admin-search-bar > form");
searchInput = document.querySelectorAll(".admin-search-bar > form > input");
searchResult = document.querySelector(".admin-search-result > table > tbody");
searchResultCount = document.querySelector(".current-search-result-count");
searchResultPageNumber = document.querySelector(".current-page-number");
searchResultRowAmmount = document.querySelector(".admin-search-result-row-ammount");

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
                users.updateUserDOM();
                searchResult.replaceChildren();
                error = document.createElement("div");
                error.classList.add("admin-search-result-error-row");
                error.innerText = "No Users Found";
                searchResult.appendChild(error);
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
        if(splitAmmount != undefined){
            this.splitUsers(splitAmmount);
        }else{
            this.splitUsers();
        }
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
            if(editUsers.users.includes(id)){
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
                    editUsers.addUser(Number(e.target.id));
                }else{
                    e.target.closest("tr").classList.remove("selected-row");
                    // remove userid from list
                    editUsers.removeUser(Number(e.target.id));
                }
            })
            // append to tbody
            searchResult.appendChild(tr);
        }
    }
}



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
    removeUser(userid){
        // remove user from list
        const index = this.users.indexOf(userid);
        if(index > -1){
            this.users.splice(index, 1);
        }
    }
    addTeam(userid, teamid){
        // add user to team
    }
    createRandomTeam(teamid, teamPlayerLimit){
        // adds randomly selected users to player (goes untill players empty or teams full)
    }
    editUser(userid, action, value){
        // create post request to edit specific user
    }
    bulkEditUsers(action, value){
        // create post request to edit all users
    }
    deleteUser(userid){
        // deletes user in database
    }
    openOverlay(){
        // opens the overlay to edit users / bulk
    }
    closeOverlay(){
        // closes the overlay
    }
}




const editUsers = new EditUsers();
const users = new Users();

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
    getData("../pages/edituseroverlay.php?userid="+id, (e)=>{
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