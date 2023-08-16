//get table element
const table = document.querySelector("#bookTable");
const borrowBook = document.querySelector('#toBorrowedBooks');
const userType = document.querySelector('#userType').value;
const borrowedBooks = document.querySelector('#borrowedBooks').value;

//get book search form
const bookSearchForm = document.querySelector('#bookSearch');

//get page number
const currentPage = document.querySelector('#currentPage');

const getData = async(page, keyword) =>{
    const response = await fetch('../balayanlms/borrow/fetch_book.php?keyword='+keyword+'&page='+page);
    const result = await response.json();
    if(result == 'Some error occurred'){
        throw new Error("No such book exist");
    }
    return result;
}

const getTotal = async keyword =>{
    const response = await fetch('../balayanlms/borrow/count_books.php?keyword='+keyword);
    const result = await response.json();
    return result;
}

const createTable = async(books) =>{
    const tbody = document.createElement("tbody");
    for(const book of books){ //for each book
        //create elements
        const tr = document.createElement("tr");
        const th = document.createElement('th');
        const td = document.createElement('td');
        th.textContent = book['id'];
        th.setAttribute("scope", "row");
        td.textContent = book['title'];
        tr.id = book['id'];
        tr.append(th);
        tr.append(td);
        tbody.append(tr);
        tr.addEventListener('click', e=>{
            const toCopy = tr;
            addToBorrow(toCopy);
        })
    }
        return tbody;
}

const createPagination = async(page, keyword, totalPage) =>{
    console.log(keyword)
    const paginationContainer = document.querySelector('.pagination');
    const links = [];
    links.push(createPreviousLink(page, keyword));
    links.push(createNextLink(page, totalPage, keyword));

    if(paginationContainer.hasChildNodes()){
        while(paginationContainer.firstChild){
            paginationContainer.removeChild(paginationContainer.firstChild);
        }
    }
    links.forEach(link=>paginationContainer.append(link));
}

const createPreviousLink = (page, keyword) =>{
    const pageVal = parseInt(page.value);
    const prev = pageVal - 1;
    if(pageVal !== 1){
        page.value = prev;
    }
    const li = document.createElement('li');
    const a = document.createElement('a');
    
    a.classList.add("page-link");
    a.classList.add("text-dark");
    a.textContent = "Previous";
    li.append(a);

    li.classList.add("page-item");
    if(pageVal == 1){
        li.classList.add("disabled");
    }else{
        li.addEventListener('click', ()=>{
            const tbody = table.lastElementChild;
            if(document.body.contains(tbody)){
                tbody.replaceChildren();
            }
            renderData(currentPage,  document.getElementById("keyword"));
        });
    }
    return li;
}

const createNextLink = (page, totalPage, keyword) =>{
    const pageVal = parseInt(page.value);
    const next = pageVal + 1;
    if(pageVal !== totalPage){
        page.value = next;
    }
    const li = document.createElement('li');
    const a = document.createElement('a');
    
    a.classList.add("page-link");
    a.classList.add("text-dark");
    a.textContent = "Next";
    li.append(a);

    li.classList.add("page-item");
    if(pageVal == totalPage){
        li.classList.add("disabled");
    }else{
        li.addEventListener('click', ()=>{
            const tbody = table.lastElementChild;
            if(document.body.contains(tbody)){
                tbody.replaceChildren();
            }
            renderData(currentPage,  document.getElementById("keyword"));
        });
    }
    return li;
}

const displayData = async(page, keyword) =>{
    console.log(keyword)
    const books = await getData(page.value, keyword);
    const totalPage = await getTotal(keyword);
    const tbody = await createTable(books);
    await createPagination(page, keyword, totalPage);
    return tbody;
}

const renderData = (page, keyword) =>{
    displayData(page, keyword.value=="" ? "null":keyword.value)
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

const addToBorrow = book =>{
    const tbody = borrowBook.lastElementChild;
    const maximumBook = 5 - borrowedBooks;
    if(tbody.childElementCount === maximumBook){
        Swal.fire(
            'Warning!',
            'Sorry, maximum number of borrowed books reach',
            'warning'
        )
    }else{
        tbody.append(book);
    }
}

table.addEventListener("load",
    renderData(currentPage, document.getElementById("keyword")));
bookSearchForm.addEventListener('submit', e=>{
    e.preventDefault();
    e.stopImmediatePropagation();
    const tbody = table.lastElementChild;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    renderData(currentPage,  document.getElementById("keyword"));
})