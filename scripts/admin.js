searchForm = document.querySelector(".admin-search-bar > form");
searchInput = document.querySelector(".admin-search-bar > form > input");
searchResult = document.querySelector(".admin-search-result");
searchResultPageNumber = document.querySelector(".current-page-number");
searchResultRowAmmount = document.querySelector(".admin-search-result-row-ammount");

function postData(form, callbackFunction){
    const request = new XMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState == XMLHttpRequest.DONE && this.status == 200){
            callbackFunction(this);
        }else if(request.readyState == XMLHttpRequest.DONE && request.status != 200){
            console.error("Error: response failed");
            return;
        }
    }
    request.open("POST", form.getAttribute("action"), true);
    request.send(new FormData(form));
}

searchForm.addEventListener('submit', (e) => {
    e.preventDefault();
});

searchInput.addEventListener("input", (e)=>{
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

searchResultRowAmmount.addEventListener("change", (e)=>{
    users.splitUsers(Number(e.target.value));
    users.navigate('min');
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
    }
    navigate(ammount){
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
        searchResultPageNumber.innerText = this.currentPage+1;
        if(this.userPages[this.currentPage] == undefined){
            return;
        }
        for(let i=0;i<this.userPages[this.currentPage].length;i++){

            // making id/name/email easy/short
            let id = this.userPages[this.currentPage][i]["id"];
            let name = this.userPages[this.currentPage][i]["name"];
            let email = this.userPages[this.currentPage][i]["email"];

            // CREATE ELEMENT AND ADD INTO ROWS
            const wrapper = document.createElement('div');
            const p = document.createElement('p');
            p.innerHTML += id;
            p.innerHTML += name;
            p.innerHTML += email;
            wrapper.classList.add("admin-search-result-row");
            wrapper.appendChild(p);
            searchResult.appendChild(wrapper);



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