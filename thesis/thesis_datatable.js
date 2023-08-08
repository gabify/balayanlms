const table = document.querySelector('#thesisTable');
const limit = document.querySelector('#limit');
const keyword = document.querySelector('#keyword');
const page = document.querySelector('#page');
const searchForm = document.querySelector('#thesisSearch');

const getThesis = async(limit, keyword, page) =>{
    const response = await fetch('../balayanlms/thesis/fetch_thesis.php?keyword='+
    keyword+'&limit='+limit+'&page='+page);
    const result = await response.json();
    return result;
}

const getTotalThesis = async(keyword, limit) =>{
    const response = await fetch('../balayanlms/thesis/countThesis.php?keyword='+keyword+'&limit='+limit);
    const result = await response.text();
    console.log(result)
    return result;
}

const createPagination = async(totalThesis, page, keyword) =>{
    const links= [];
    const totalpages = totalThesis['totalPage'];
    const secondLast = totalpages - 1;
    links.push(createPreviousPage(page, keyword));
    if(totalpages <= 10){
        for(let i = 1; i<=totalpages; i++){
            if(i == page){
                links.push(createPageLink(i, keyword, true));
            }else{
                links.push(createPageLink(i, keyword, false));
            }
        }
    }else if(totalpages > 10){
        if(page < 4){
            for(let i = 1; i<=8; i++){
                if(i == page){
                    links.push(createPageLink(i, keyword, true));
                }else{
                    links.push(createPageLink(i, keyword, false));
                }
            }
            links.push(createInBetween());
            if(page == secondLast){
                links.push(createPageLink(secondLast, keyword, true))
            }else{
                links.push(createPageLink(secondLast, keyword, false))
            }
            if(page == totalpages){
                links.push(createPageLink(totalpages, keyword, true))
            }else{
                links.push(createPageLink(totalpages, keyword, false))
            }
        }else if(page > 4 && page < totalpages - 4){
            if(page == 1){
                links.push(createPageLink(1, keyword, true))
            }else{
                links.push(createPageLink(1, keyword, false))
            }
            if(page == 2){
                links.push(createPageLink(2, keyword, true))
            }else{
                links.push(createPageLink(2, keyword, false))
            }
            links.push(createInBetween());
            for(let i = parseInt(page) - 2; i<=parseInt(page) + 2; i++){
                if(i == page){
                    links.push(createPageLink(i, keyword, true));
                }else{
                    links.push(createPageLink(i, keyword, false));
                }
            }
            links.push(createInBetween());
            if(page == secondLast){
                links.push(createPageLink(secondLast, keyword, true))
            }else{
                links.push(createPageLink(secondLast, keyword, false))
            }
            if(page == totalpages){
                links.push(createPageLink(totalpages, keyword, true))
            }else{
                links.push(createPageLink(totalpages, keyword, false))
            }
        }else{
            if(page == 1){
                links.push(createPageLink(1, keyword, true))
            }else{
                links.push(createPageLink(1, keyword, false))
            }
            if(page == 2){
                links.push(createPageLink(2, keyword, true))
            }else{
                links.push(createPageLink(2, keyword, false))
            }
            links.push(createInBetween());
            for(let i = totalpages - 6; i<=totalpages; i++){
                if(i == page){
                    links.push(createPageLink(i, keyword, true));
                }else{
                    links.push(createPageLink(i, keyword, false));
                }
            }
            links.push(createInBetween());
            if(page == secondLast){
                links.push(createPageLink(secondLast, keyword, true))
            }else{
                links.push(createPageLink(secondLast, keyword, false))
            }
            if(page == totalpages){
                links.push(createPageLink(totalpages, keyword, true))
            }else{
                links.push(createPageLink(totalpages, keyword, false))
            }
        }
    }
    links.push(createNextPage(page, totalpages, keyword));
    const paginationContainer  =document.querySelector('.pagination');
    if(paginationContainer.hasChildNodes()){
        while(paginationContainer.firstChild){
            paginationContainer.removeChild(paginationContainer.firstChild);
        }
    }
    links.forEach(link=> paginationContainer.append(link));
    if(totalThesis['totalThesis'] <= 10){
        const limit = document.querySelector('#limit');
        limit.disabled = true;
    }
}

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

const createPageLink = (pageNum, keyword, isActive) =>{
    const li = document.createElement('li');
    const a = document.createElement('a');

    li.classList.add("page-item");
    a.classList.add("page-link");
    a.textContent = pageNum;

    if(isActive){
        a.classList.add("active")
    }else{
        a.classList.add("text-dark");
        a.href = "../balayanlms/thesisDashboard.php?page="+pageNum+'&keyword='+keyword;
    }

    li.append(a);
    return li;
}

const createNextPage = (currentPage, totalpages, keyword) => {
    const next = parseInt(currentPage) + 1;
    const nextLi = document.createElement('li');
    const nextA = document.createElement('a');
    nextLi.classList.add("page-item");
    if(parseInt(currentPage) === totalpages){
        nextLi.classList.add("disabled");
    }
    nextA.classList.add("page-link");
    nextA.classList.add("text-dark");
    nextA.href = "../balayanlms/thesisDashboard.php?page="+next+'&keyword='+keyword;
    nextA.textContent = 'Next';
    nextLi.append(nextA);
    return nextLi;
}

const createPreviousPage = (currentPage, keyword) =>{
    const prev = currentPage -1;
    const prevLi = document.createElement('li');
    const preva = document.createElement('a');
    prevLi.classList.add("page-item");
    if(currentPage == 1){
        prevLi.classList.add("disabled");
    }
    preva.classList.add("page-link");
    preva.classList.add("text-dark");
    preva.setAttribute("href", "../balayanlms/thesisDashboard.php?page="+prev+'&keyword='+keyword);
    preva.textContent = 'Previous';
    prevLi.appendChild(preva);
    return prevLi;
}

const createTable = async(theses) =>{
    const tbody = document.createElement('tbody');
    for(const thesis of theses){
        const tr = document.createElement('tr');
        tr.id = thesis['id'];
        const tds= [];
        for(let i=0; i<=4; i++){
            const td= document.createElement('td');
            tds.push(td);
        }
        tds[0].textContent = thesis['id'];
        tds[0].classList.add("fw-bold");

        tds[1].textContent= thesis['callnum'];
        tds[2].textContent= thesis['title'];
        tds[3].textContent= thesis['publication_year'];
        tds[4].append(createLink("text-primary", "bi-eye-fill", "../balayanlms/view_student.php?id="+thesis['id']));
        tds[4].append(createDeleteButton(thesis['id']));
        tds.forEach(td=>tr.append(td));
        tbody.append(tr);
    }
    return tbody;
}

const createLink = (color, icon, link) =>{
    const a = document.createElement('a');
    const i = document.createElement('i');

    a.classList.add("btn");
    a.href = link;
    i.classList.add(icon);
    i.classList.add("fs-4");
    i.classList.add(color);
    a.append(i);
    return a;
}

const createDeleteButton = (id) => {
    const btn = document.createElement('button');
    const i = document.createElement('i');
    btn.classList.add('btn');
    btn.setAttribute("onclick", "deleteThesis("+id+")");
    i.classList.add("bi-trash3-fill");
    i.classList.add("fs-4");
    i.classList.add("text-danger");
    btn.append(i);
    return btn;
}

const displayData = async(limit, page, keyword) =>{
    const theses = await getThesis(limit, keyword, page);
    const totalThesis = await getTotalThesis(keyword, limit);
    const table = await createTable(theses);
    await createPagination(totalThesis, page, keyword);
    return table;
}

const renderData = (limit, page, keyword) =>{
    keyword = keyword.value == "" ? 'null' : keyword.value;
    displayData(limit, page, keyword)
    .then(result =>{
        table.append(result);
    }).catch(error=>{
        Swal.fire(
            'Error!',
            error.message,
            'error'
        );
    });
}

table.addEventListener('load', renderData(limit.value, page.value, keyword));
limit.addEventListener('change', e=>{
    const tbody = table.lastElementChild;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    renderData(e.target.value, page.value, keyword)
});
searchForm.addEventListener('submit', e=>{
    e.preventDefault();
    e.stopPropagation();
    const tbody = table.lastElementChild;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    renderData(limit.value, 1, keyword)
});