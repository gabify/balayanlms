//get table element
const table = document.querySelector("#bookTable");

//get select element
const limit = document.querySelector('#limit');

//get book search form
const bookSearchForm = document.querySelector('#bookSearch');

//get page number
const page = document.querySelector('#page');

//page info
const pageInfo = document.getElementById("pageInfo");

//get data using fetch
const getData = async(limit, page, keyword) =>{
    const response = await fetch('../balayanlms/book/fetch_data.php?limit='+limit+'&keyword='+keyword+'&page='+page);
    const result = await response.json();
    if(result == 'Some error occurred'){
        throw new Error("No such book exist");
    }
    return result;
}
//get total pages and total books
const getTotal = async(limit, keyword) =>{
    const response = await fetch('../balayanlms/book/countNumRows.php?limit='+limit+'&keyword='+keyword);
    const result = await response.json();
    return result;
}
//create table
const createTable = async(books) =>{
    const tbody = document.createElement("tbody");
    for(const book of books){ //for each book
            //create elements
            const tr = document.createElement("tr");
            let tds = [];
            const viewLink = document.createElement("a");
            const editLink = document.createElement("a");
            const deleteBtn = document.createElement("button");
            let icns =[];
            for(i = 0; i < 4; i++){
                const td = document.createElement("td");
                tds[i] = td;
            }
            for(i=0; i<3; i++){
                const icn = document.createElement("i");
                icns[i] = icn;
            }
            //add attributes
            tr.setAttribute("id", book['id']);
            viewLink.setAttribute("class", "btn");
            viewLink.setAttribute("href", "../balayanlms/viewBook.php?id="+book['id']);
            editLink.setAttribute("class", "btn");
            editLink.setAttribute("href", "../balayanlms/editBook.php?id="+book['id']);
            deleteBtn.setAttribute("class", "btn");
            deleteBtn.setAttribute("onclick", "deleteBook("+book['id']+")");
            icns[0].setAttribute("class", "bi-eye-fill fs-4 text-primary");
            icns[1].setAttribute("class", "bi-pencil-fill fs-4 text-warning");
            icns[2].setAttribute("class", "bi-trash3-fill fs-4 text-danger");
            //add data
            tds[0].textContent = book['accessnum'];
            tds[1].textContent = book['callnum'];
            tds[2].textContent = book['title'];
            //append to tr and tbody
            viewLink.appendChild(icns[0]);
            editLink.appendChild(icns[1]);
            deleteBtn.appendChild(icns[2]);
            
            tds[3].appendChild(viewLink);
            tds[3].appendChild(editLink);
            tds[3].appendChild(deleteBtn);
            tds.forEach(td=>{
                tr.appendChild(td);
            });
            tbody.appendChild(tr);
        }
        return tbody;
}

//create pagination
const createPagination = async(tbody, totalPagesAndBooks, page) =>{
    const paginationContainer = document.querySelector('.pagination');
    const prev = page -1;
    const next = parseInt(page) + 1;
    let links = [];
    pageInfo.textContent = "Showing "+tbody.childElementCount+" out of "+totalPagesAndBooks['totalBooks']+" Books"
    const prevLi = document.createElement('li');
    const preva = document.createElement('a');
    prevLi.classList.add("page-item");
    if(page == 1){
        prevLi.classList.add("disabled");
    }
    preva.classList.add("page-link");
    preva.classList.add("text-dark");
    preva.setAttribute("href", "../balayanlms/bookDashboard.php?page="+prev);
    preva.textContent = 'Previous';
    prevLi.appendChild(preva);
    links[0] = prevLi;
    for(let i = 1; i<=totalPagesAndBooks['totalPages']; i++){
        const li = document.createElement('li');
        const a = document.createElement('a');
        li.classList.add("page-item");
        a.classList.add("page-link");
        a.classList.add("text-dark");
        a.textContent = i;
        if(i == page){
            a.classList.add("active")
            a.classList.remove("text-dark")
        }else{
            a.setAttribute("href", "../balayanlms/bookDashboard.php?page="+i);
        }
        li.appendChild(a);
        links[i] = li;
    }
    const nextLi = document.createElement('li');
    const nexta = document.createElement('a');
    nextLi.classList.add("page-item");
    if(page == totalPagesAndBooks['totalPages']){
        nextLi.classList.add("disabled");
    }
    nexta.classList.add("page-link");
    nexta.classList.add("text-dark");
    nexta.setAttribute("href", "../balayanlms/bookDashboard.php?page="+next);
    nexta.textContent = 'Next';
    nextLi.appendChild(nexta);
    links[links.length+1] = nextLi;

    if(paginationContainer.hasChildNodes()){
        while(paginationContainer.firstChild){
            paginationContainer.removeChild(paginationContainer.firstChild);
        }
    }
    links.forEach(link => paginationContainer.appendChild(link))
    if(page > 1){
        const limit = document.querySelector('#limit');
        limit.disabled = true;
    }
}

// do all the stuffs
const displayData = async(limit, page, keyword) =>{
    const books = await getData(limit, page, keyword);
    const totalPagesAndBooks = await getTotal(limit, keyword);
    const tbody = await createTable(books);
    await createPagination(tbody, totalPagesAndBooks, page);
    return tbody;
}

//render to DOM
const renderData = (limit, page, keyword) =>{
    displayData(limit, page, keyword)
    .then((tbody) =>{
        table.appendChild(tbody);
    }).catch((err) =>{
        Swal.fire(
            'Error!',
            err.message,
            'error'
          )
    });
}

//add event listener to the table element
table.addEventListener("load", 
    renderData(limit.value, page.value, document.getElementById("keyword").value == "" ? "null": keyword));
limit.addEventListener("change", ()=>{
    const tbody = table.lastElementChild;
    const keyword = document.getElementById("keyword").value;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    renderData(limit.value, page.value, keyword == "" ? "null": keyword);
});
bookSearchForm.addEventListener("submit", (e)=>{
    e.preventDefault();
    const tbody = table.lastElementChild;
    const keyword = document.getElementById("keyword").value;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    renderData(limit.value, page.value, keyword == "" ? "null": keyword);
});

/* const search = document.querySelector('#keyword');
search.addEventListener("input", (e)=>{
    const tbody = table.lastElementChild;
    const val = e.target.value;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    renderData(limit.value, val == "" ? "null": val);
}); */
