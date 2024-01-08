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
            viewLink.classList.add("btn");
            viewLink.setAttribute("href", "../balayanlms/viewBook.php?id="+book['id']);
            editLink.classList.add("btn");
            deleteBtn.classList.add("btn");
            deleteBtn.setAttribute("onclick", "deleteBook("+book['id']+")");
            icns[0].classList.add("bi-eye-fill");
            icns[0].classList.add("fs-4");
            icns[0].classList.add("text-primary");
            icns[1].classList.add("bi-pencil-fill");
            icns[1].classList.add("fs-4");
            icns[1].classList.add("text-warning");
            icns[2].classList.add("bi-trash3-fill");
            icns[2].classList.add("fs-4");
            icns[2].classList.add("text-danger");
            //add data
            tds[0].textContent = book['id'];
            tds[1].textContent = book['callnum'];
            tds[2].textContent = book['title'];
            //append to tr and tbody
            viewLink.appendChild(icns[0]);
            deleteBtn.appendChild(icns[2]);
            
            tds[3].appendChild(viewLink);
            tds[3].appendChild(deleteBtn);
            tds.forEach(td=>{
                tr.appendChild(td);
            });
            tbody.appendChild(tr);
        }
        return tbody;
}

//create previous link
const createPrev = (page, keyword) =>{
    const prev = page -1;
    const prevLi = document.createElement('li');
    const preva = document.createElement('a');
    prevLi.classList.add("page-item");
    if(page == 1){
        prevLi.classList.add("disabled");
    }
    preva.classList.add("page-link");
    preva.classList.add("text-dark");
    preva.setAttribute("href", "../balayanlms/bookDashboard.php?page="+prev+'&keyword='+keyword);
    preva.textContent = 'Previous';
    prevLi.appendChild(preva);
    return prevLi;
}

//create next link
const createNext = (page, totalPagesAndBooks, keyword)=>{
    const next = parseInt(page) + 1;
    const nextLi = document.createElement('li');
    const nexta = document.createElement('a');
    nextLi.classList.add("page-item");
    if(page == totalPagesAndBooks['totalPages']){
        nextLi.classList.add("disabled");
    }
    nexta.classList.add("page-link");
    nexta.classList.add("text-dark");
    nexta.setAttribute("href", "../balayanlms/bookDashboard.php?page="+next+"&keyword="+keyword);
    nexta.textContent = 'Next';
    nextLi.appendChild(nexta);
    return nextLi;
}

//create page link number
const createPagelink = (pageNum, keyword, isActive) =>{
    const li = document.createElement('li');
    const a = document.createElement('a');
    li.classList.add("page-item");
    a.classList.add("page-link");
    a.textContent = pageNum;
    if(isActive == true){
        a.classList.add("active");
    }else{
        a.classList.add("text-dark");
        a.href =  "../balayanlms/bookDashboard.php?page="+pageNum+'&keyword='+keyword;
    }
    li.append(a);
    return li;
}

//create in between link
const createInBetween = () =>{
    const li = document.createElement('li');
    const a = document.createElement('a');
    li.classList.add("page-item");
    a.classList.add("page-link");
    a.classList.add("text-dark");
    a.textContent = '......';
    li.append(a);
    return li;
}

//create pagination
const createPagination = async(tbody, totalPagesAndBooks, page, keyword) =>{
    pageInfo.textContent = "Showing "+tbody.childElementCount+" books of page "+ page+" out of "+totalPagesAndBooks['totalBooks']+" Books"
    const paginationContainer = document.querySelector('.pagination');
    let links = [];
    links.push(createPrev(page, keyword));
    const totalPage = totalPagesAndBooks['totalPages'];
    const secondLast = totalPage - 1;
    if(totalPage <= 10){
        for(let i = 1; i<=totalPage; i++){
            if(page == i){
                links.push(createPagelink(i, keyword, true));
            }else{
                links.push(createPagelink(i, keyword, false));
            }
        }
    }else if(totalPage > 10){
        if(page <= 4){
            for(let i = 1; i<8; i++){
                if(page == i){
                    links.push(createPagelink(i, keyword, true));
                }else{
                    links.push(createPagelink(i, keyword, false));
                }
            }
            links.push(createInBetween());
            if(page == secondLast){
                links.push(createPagelink(secondLast, keyword, true));
            }else{
                links.push(createPagelink(secondLast, keyword, false));
            }
            if(page == totalPage){
                links.push(createPagelink(totalPage, keyword, true));
            }else{
                links.push(createPagelink(totalPage, keyword, false));
            }
            
        }else if(page > 4 && page < totalPage -4){
            if(page == 1){
                links.push(createPagelink(1, keyword, true));
            }else{
                links.push(createPagelink(1, keyword, false));
            }
            if(page == 2){
                links.push(createPagelink(2, keyword, true));
            }else{
                links.push(createPagelink(2, keyword, false));
            }
            links.push(createInBetween());
            for(let i =  parseInt(page) - 2; i <= parseInt(page) + 2; i++){
                if(page == i){
                    links.push(createPagelink(i, keyword, true));
                }else{
                    links.push(createPagelink(i, keyword, false));
                }
            }
            links.push(createInBetween());
            if(page == secondLast){
                links.push(createPagelink(secondLast, keyword, true));
            }else{
                links.push(createPagelink(secondLast, keyword, false));
            }
            if(page == totalPage){
                links.push(createPagelink(totalPage, keyword, true));
            }else{
                links.push(createPagelink(totalPage, keyword, false));
            }
        }else{
            if(page == 1){
                links.push(createPagelink(1, keyword, true));
            }else{
                links.push(createPagelink(1, keyword, false));
            }
            if(page == 2){
                links.push(createPagelink(2, keyword, true));
            }else{
                links.push(createPagelink(2, keyword, false));
            }
            links.push(createInBetween());
            for(let i = totalPage -6; i <= totalPage; i++){
                if(page == i){
                    links.push(createPagelink(i, keyword, true));
                }else{
                    links.push(createPagelink(i, keyword, false));
                }
            }
        }
    }
    
    links.push(createNext(page, totalPagesAndBooks,keyword));

    if(paginationContainer.hasChildNodes()){
        while(paginationContainer.firstChild){
            paginationContainer.removeChild(paginationContainer.firstChild);
        }
    }
    links.forEach(link => paginationContainer.appendChild(link))
    if(totalPagesAndBooks['totalPages'] <= 10){
        const limit = document.querySelector('#limit');
        limit.disabled = true;
    }
}

// do all the stuffs
const displayData = async(limit, page, keyword) =>{
    const books = await getData(limit, page, keyword);
    const totalPagesAndBooks = await getTotal(limit, keyword);
    const tbody = await createTable(books);
    await createPagination(tbody, totalPagesAndBooks, page, keyword);
    return tbody;
}

//render to DOM
const renderData = (limit, page, keyword) =>{
    displayData(limit, page, keyword.value=="" ? "null":keyword.value)
    .then((result) =>{
        table.appendChild(result);
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
    renderData(limit.value, page.value, document.getElementById("keyword")));
limit.addEventListener("change", ()=>{
    const tbody = table.lastElementChild;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    renderData(limit.value, page.value, document.getElementById("keyword"));
});
bookSearchForm.addEventListener("submit", (e)=>{
    e.preventDefault();
    const tbody = table.lastElementChild;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    renderData(limit.value, 1, document.getElementById("keyword"));
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