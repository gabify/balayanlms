const table = document.querySelector('#facultyTable');
const page = document.querySelector('#page');
const limit = document.querySelector('#limit');
const keyword = document.querySelector('#keyword');
const searchForm = document.querySelector('#facultySearch');

const getFaculties = async(keyword, limit, page) =>{
    const response = await fetch('../balayanlms/faculty/fetch_faculty.php?keyword='+keyword
    +'&limit='+limit+'&page='+page);
    const result = await response.json();
    return result;
}

const getTotalFaculty = async(keyword, limit) =>{
    const response = await fetch('../balayanlms/faculty/count_faculty.php?keyword='+keyword+'&limit='+limit);
    const result = await response.json();
    return result;
}

const createTable = async faculties =>{
    const tbody = document.createElement('tbody');
    let i = 1;
    for(const faculty of faculties){
        const tds = [];
        for(let i = 0; i<=3; i++){
            const td = document.createElement('td');
            tds.push(td);
        }
        tds[0].textContent = faculty['employee_num'];
        tds[1].textContent = faculty['last_name'];
        tds[2].textContent = faculty['first_name'];
        tds[3].append(createLink("text-primary", "bi-eye-fill", '../balayanlms/view_faculty.php?id='+faculty['id']));
        tds[3].append(createLink("text-warning", "bi-bag-plus-fill", '../balayanlms/borrow_book.php?user_type=faculty&id='+faculty['id']));
        tds[3].append(createDeleteButton(faculty['id']));
        const th = document.createElement('th');
        th.setAttribute("scope", "row");
        th.textContent = i++;
        const tr = document.createElement('tr');
        tr.id = faculty['id'];
        tr.append(th);
        tds.forEach(td=>{tr.append(td)});
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
        a.href = "../balayanlms/facultyDashboard.php?page="+pageNum+'&keyword='+keyword;
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
    nextA.href = "../balayanlms/facultyDashboard.php?page="+next+'&keyword='+keyword;
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
    preva.setAttribute("href", "../balayanlms/facultyDashboard.php?page="+prev+'&keyword='+keyword);
    preva.textContent = 'Previous';
    prevLi.appendChild(preva);
    return prevLi;
}

const createPagination = async(totalFacultyandPage, currentPage, keyword) => {
    const links = [];
    const totalPage = totalFacultyandPage['totalPage'];
    const secondLast = totalPage - 1;
    links.push(createPreviousPage(currentPage, keyword));
    if(totalPage <= 10){
        for(let i = 1; i<= totalPage; i++){
            if(currentPage == i){
                links.push(createPageLink(i, keyword, true));
            }else{
                links.push(createPageLink(i, keyword, false));
            }
        }
    }else if( totalPage > 10){
        if(currentPage < 4){
            for(let i = 1; i<= 8; i++){
                if(currentPage == i){
                    links.push(createPageLink(i, keyword, true));
                }else{
                    links.push(createPageLink(i, keyword, false));
                }
            }
            links.push(createInBetween());
            if(currentPage == secondLast){
                links.push(createPageLink(secondLast, keyword, true));
            }else{
                links.push(createPageLink(secondLast, keyword, false));
            }
            if(currentPage == totalPage){
                links.push(createPageLink(totalPage, keyword, true));
            }else{
                links.push(createPageLink(totalPage, keyword, false));
            }
        }else if(currentPage > 4 && currentPage < totalPage - 4){
            if(currentPage == 1){
                links.push(createPageLink(1, keyword, true));
            }else{
                links.push(createPageLink(2, keyword, false));
            }
            if(currentPage == 2){
                links.push(createPageLink(2, keyword, true));
            }else{
                links.push(createPageLink(2, keyword, false));
            }
            links.push(createInBetween());

            for(let i = parseInt(currentPage) - 2; i < parseInt(currentPage) + 2; i++){
                if(currentPage == i){
                    links.push(createPageLink(i, keyword, true));
                }else{
                    links.push(createPageLink(i, keyword, false));
                }
            }

            links.push(createInBetween());
            if(currentPage == secondLast){
                links.push(createPageLink(secondLast, keyword, true));
            }else{
                links.push(createPageLink(secondLast, keyword, false));
            }
            if(currentPage == totalPage){
                links.push(createPageLink(totalPage, keyword, true));
            }else{
                links.push(createPageLink(totalPage, keyword, false));
            }
        }else{
            if(currentPage == 1){
                links.push(createPageLink(1, keyword, true));
            }else{
                links.push(createPageLink(2, keyword, false));
            }
            if(currentPage == 2){
                links.push(createPageLink(2, keyword, true));
            }else{
                links.push(createPageLink(2, keyword, false));
            }
            links.push(createInBetween());

            for(let i = totalPage - 6; i <= totalPage; i++){
                if(currentPage == i){
                    links.push(createPageLink(i, keyword, true));
                }else{
                    links.push(createPageLink(i, keyword, false));
                }
            }
        }
    }
    links.push(createNextPage(currentPage, totalPage, keyword));
    const paginationContainer  =document.querySelector('.pagination');
    if(paginationContainer.hasChildNodes()){
        while(paginationContainer.firstChild){
            paginationContainer.removeChild(paginationContainer.firstChild);
        }
    }
    links.forEach(link=> paginationContainer.append(link));
    if(totalFacultyandPage['totalFaculty'] <= 10){
        const limit = document.querySelector('#limit');
        limit.disabled = true;
    }
}

const createDeleteButton = (id) => {
    const btn = document.createElement('button');
    const i = document.createElement('i');
    btn.classList.add('btn');
    btn.setAttribute("onclick", "deleteFaculty("+id+")");
    i.classList.add("bi-trash3-fill");
    i.classList.add("fs-4");
    i.classList.add("text-danger");
    btn.append(i);
    return btn;
}

const asyncDelete = async id =>{
    const response = await fetch('../balayanlms/faculty/delete_faculty.php?id='+id);
    const result = response.text();
    if(result == 'error'){
        throw new Error('An error occured. Please try again later.');
    }
    return result;
}

const deleteFaculty = id =>{
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if(result.isConfirmed) {
          asyncDelete(id)
          .then(result =>{
            if(result == 'success'){
                Swal.fire(
                    'Deleted!',
                    'The faculty has been deleted.',
                    'success'
                  );
                document.getElementById(id).style.display = "none";
            }
          });
        }
      }).catch(e =>{
        Swal.fire(
            'Error!',
            e.message,
            'error'
          );
      })
}

const displayData = async(keyword, limit, page) =>{
    const faculties = await getFaculties(keyword, limit, page);
    const totalFaculty = await getTotalFaculty(keyword, limit);
    const tbody = await createTable(faculties);
    await createPagination(totalFaculty, page, keyword);
    return tbody;
}

const renderData = (keyword, limit, page) =>{
    keyword = keyword.value == "" ? 'null' : keyword.value;
    displayData(keyword, limit, page)
    .then(result=>{
        table.append(result);
    }).catch(error =>{
        Swal.fire(
            'Error!',
            error.message,
            'error'
        )
    });
}

table.addEventListener('load', renderData(keyword, limit.value, page.value));
searchForm.addEventListener("submit", e =>{
    e.preventDefault();
    e.stopPropagation();
    const tbody = table.lastElementChild;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    renderData(keyword, limit.value, 1);
});
limit.addEventListener('change', e =>{
    const tbody = table.lastElementChild;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    renderData(keyword, e.target.value, page.value);
});