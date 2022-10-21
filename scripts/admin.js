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

searchForm.addEventListener('submit', (e) => {
    e.preventDefault();
});

searchInput.forEach((item,index)=>{
    item.addEventListener("input", (e)=>{
        postData(searchForm, (e)=>{
            var result = JSON.parse(e.responseText);
            console.log(result);
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
    constructor(users, splitAmmount){
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
            for(let i=0;i<6;i++){td.push(document.createElement("td"));}
            // set data
            td[0].innerHTML = "<p>" + id + "</p>"; // id
            td[1].innerHTML = "<p>" + name + "</p>"; // username
            td[2].innerHTML = "<p>" + email + "</p>"; // email
            td[3].innerHTML = "<p>" + goals + "</p>"; // goals
            td[4].innerHTML = "<p>" + assists + "</p>"; // assists
            td[5].innerHTML = "<button type='button' value='" + id + "'>Edit user</button>"; // edit button
            // append to <tr>
            for(let i=0;i<6;i++){
                tr.appendChild(td[i]);
                td[i].addEventListener("mouseleave", (e)=>{
                    e.target.firstChild.scrollLeft = 0;
                });
            }
            // append to tbody
            searchResult.appendChild(tr);
        }
    }
}

const users = new Users([],0);

function navigate(ammount){
    users.navigate(ammount);
}

postData(searchForm, (e)=>{
    var result = JSON.parse(e.responseText);
    users.updateNewUsers(result)
    users.updateUserDOM();
});
