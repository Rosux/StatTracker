searchForm = document.querySelector(".admin-search-bar > form");
searchInput = document.querySelector(".admin-search-bar > form > input");
searchResult = document.querySelector(".admin-search-result");

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
        searchResult.replaceChildren();
        console.log(e.responseText); // temp
        result = JSON.parse(e.responseText);
        if(result == 1){
            // display no users found
            return;
        }
        // print users
        result.forEach(e => {
            const wrapper = document.createElement('div');
            const p = document.createElement('p');
            p.innerHTML += e["id"];
            p.innerHTML += e["name"];
            p.innerHTML += e["email"];
            wrapper.classList.add("admin-search-result-row");
            wrapper.appendChild(p);
            searchResult.appendChild(wrapper);



        });











    });
});
