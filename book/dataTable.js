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

//create previous link
const createPrev = (page) =>{
    const prev = page -1;
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
    return prevLi;
}

//create next link
const createNext = (page, totalPagesAndBooks)=>{
    const next = parseInt(page) + 1;
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
    return nextLi;
}

//create pagination
const createPagination = async(tbody, totalPagesAndBooks, page) =>{
    pageInfo.textContent = "Showing "+tbody.childElementCount+" out of "+totalPagesAndBooks['totalBooks']+" Books"
    const paginationContainer = document.querySelector('.pagination');
    let links = [];
    links[0] = createPrev(page);
    if(totalPagesAndBooks['totalPages'] <= 10){
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
    }else if(totalPagesAndBooks['totalPages'] > 10){
        if(page <= 4){
            for(let i = 1; i<8; i++){
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
            const inBetween = links[1];
            const secondToLast = links[1];
            const secondToLastLink = totalPagesAndBooks['totalPages'] - 1;
            const last = links[1];
            inBetween.firstChild.removeAttribute("href");
            inBetween.firstChild.textContent = "...";
            secondToLast.firstChild.href = "../balayanlms/bookDashboard.php?page="+secondToLastLink;
            secondToLast.firstChild.textContent = secondToLastLink
            last.firstChild.href = "../balayanlms/bookDashboard.php?page="+totalPagesAndBooks['totalPages'];
            last.firstChild.textContent = totalPagesAndBooks['totalPages'];
            links[8] = inBetween;
            links[9] = secondToLast;
            links[10] = last;
            
        }else if(page > 4 && page < totalPagesAndBooks['totalPages'] -4){
            const inBetween = links[1];
            inBetween.firstChild.removeAttribute("href");
            inBetween.firstChild.textContent = "...";
            const first = links[0];
            const second = links[0];
            first.firstChild.href = "../balayanlms/bookDashboard.php?page="+ 1;
            first.firstChild.textContent = "1";
            second.firstChild.href = "../balayanlms/bookDashboard.php?page="+ 2;
            second.firstChild.textContent = "2";
            links[1] = first;
            links[2] = second;
            links[3] = inBetween;
            for(let i = page -2; i <= page + 2; i++){
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
            const secondToLast = links[1];
            const secondToLastLink = totalPagesAndBooks['totalPages'] - 1;
            const last = links[1];
            secondToLast.firstChild.href = "../balayanlms/bookDashboard.php?page="+secondToLastLink;
            secondToLast.firstChild.textContent = secondToLastLink
            last.firstChild.href = "../balayanlms/bookDashboard.php?page="+totalPagesAndBooks['totalPages'];
            last.firstChild.textContent = totalPagesAndBooks['totalPages'];
            links[9] = inBetween;
            links[10] = secondToLast;
            links[11] = last;
        }else{
            const inBetween = links[1];
            inBetween.firstChild.removeAttribute("href");
            inBetween.firstChild.textContent = "...";
            const first = links[0];
            const second = links[0];
            first.firstChild.href = "../balayanlms/bookDashboard.php?page="+ 1;
            first.firstChild.textContent = "1";
            second.firstChild.href = "../balayanlms/bookDashboard.php?page="+ 2;
            second.firstChild.textContent = "2";
            links[1] = first;
            links[2] = second;
            links[3] = inBetween;
            for(let i = totalPagesAndBooks['totalPages'] -6 ; i <= totalPagesAndBooks['totalPages']; i++){
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
        }
    }
    
    links[links.length+1] = createNext(page, totalPagesAndBooks);

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

