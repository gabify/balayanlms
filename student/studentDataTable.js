//get reference to the table
const table = document.querySelector('#studentTable');
const searchForm = document.querySelector('#studentSearch');
const limit = document.querySelector('#limit');
const keyword = document.querySelector('#keyword');
const page = document.querySelector('#page');

//get data from php
const getStudents = async(keyword, limit) =>{
    const response = await fetch('../balayanlms/student/fetch_student.php?keyword='+keyword+'&limit='+limit);
    const result = await response.json();
    if(result == 'An error occured. Retrieved empty dataset'){
        throw new Error('Sorry. No such student exist.');
    }
    return result;
}

const getTotalStudents = async(keyword, limit) =>{
    const response = await fetch('../balayanlms/student/countStudents.php?keyword='+keyword+'&limit='+limit);
    const result = await response.json();
    return result;
}

const createTable = async(students) =>{
    const tbody = document.createElement('tbody');
    for(const student of students){
        const tr = document.createElement('tr');
        let tds = [];
        for(let i = 0; i <= 5; i++){
            const td = document.createElement('td');
            tds[i] = td;
        }
        
        tds[1].textContent = student['srcode'];
        tds[2].textContent = student['last_name'];
        tds[3].textContent = student['first_name'];
        tds[4].textContent = student['program'];

        tds.forEach(td=>tr.appendChild(td));
        tbody.appendChild(tr);
    }
    return tbody;
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
    preva.setAttribute("href", "../balayanlms/studentDashboard.php?page="+prev+'&keyword='+keyword);
    preva.textContent = 'Previous';
    prevLi.appendChild(preva);
    return prevLi;
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
    nextA.href = "../balayanlms/studentDashboard.php?page="+next+'&keyword='+keyword;
    nextA.textContent = 'Next';
    nextLi.append(nextA);
    return nextLi;
}

const createPagination = async(totalStudentsandPage, currentPage, keyword) => {
    const links = [];
    links.push(createPreviousPage(currentPage, keyword));
    if(totalStudentsandPage['totalPage'] <= 10){
        for(let i = 1; i<= totalStudentsandPage['totalPage']; i++){
            const li = document.createElement('li');
            const a = document.createElement('a');
            li.classList.add("page-item");
            a.classList.add("page-link");
            a.classList.add("text-dark");
            a.textContent = i;
            if(i == currentPage){
                a.classList.add('active');
                a.classList.remove('text-dark')
            }else{
                a.href =  "../balayanlms/studentDashboard.php?page="+i+'&keyword='+keyword;
            }
            li.append(a);
            links.push(li);
        }
    }else if( totalStudentsandPage['totalPage'] > 10){
        if(currentPage < 4){
            for(let i = 1; i<= 8; i++){
                const li = document.createElement('li');
                const a = document.createElement('a');
                li.classList.add("page-item");
                a.classList.add("page-link");
                a.classList.add("text-dark");
                a.textContent = i;
                if(i == currentPage){
                    a.classList.add('active');
                    a.classList.remove('text-dark')
                }else{
                    a.href =  "../balayanlms/studentDashboard.php?page="+i+'&keyword='+keyword;
                }
                li.append(a);
                links.push(li);
            }
            const inBetween = links[1];
            const secondToLast = links[1];
            const secondToLastLink = totalStudentsandPage['totalPage'] - 1;
            const last = links[1];
            inBetween.firstChild.removeAttribute("href");
            inBetween.firstChild.textContent = "...";
            secondToLast.firstChild.href = "../balayanlms/studentDashboard.php?page="+secondToLastLink+'&keyword='+keyword;
            secondToLast.firstChild.textContent = secondToLastLink;
            last.firstChild.href ="../balayanlms/studentDashboard.php?page="+totalStudentsandPage['totalPage']+'&keyword='+keyword;
            last.firstChild.textContent = totalStudentsandPage['totalPage'];
            links.push(inBetween);
            links.push(secondToLast);
            links.push(last);
        }else if(currentPage > 4 && currentPage < totalStudentsandPage['totalpage'] -4){
            const inBetween = links[1];
            const first = links[1];
            const second = links[1];
            inBetween.firstChild.removeAttribute("href");
            inBetween.firstChild.textContent = "...";
            first.firstChild.href = "../balayanlms/studentDashboard.php?page=1"+'&keyword='+keyword;
            first.textContent = "1";
            second.firstChild.href ="../balayanlms/studentDashboard.php?page=2"+'&keyword='+keyword;
            second.firstChild.textContent = "2";
            links.push(first);
            links.push(second);
            links.push(inBetween);
            for(let i = currentPage - 2; i < currentPage + 2; i++){
                const li = document.createElement('li');
                const a = document.createElement('a');
                li.classList.add("page-item");
                a.classList.add("page-link");
                a.classList.add("text-dark");
                a.textContent = i;
                if(i == currentPage){
                    a.classList.add('active');
                    a.classList.remove('text-dark')
                }else{
                    a.href =  "../balayanlms/studentDashboard.php?page="+i+'&keyword='+keyword;
                }
                li.append(a);
                links.push(li);
            }
            const secondToLast = links[1];
            const secondToLastLink = totalStudentsandPage['totalPage'] - 1;
            const last = links[1];
            secondToLast.firstChild.href = "../balayanlms/studentDashboard.php?page="+secondToLastLink+'&keyword='+keyword;
            secondToLast.firstChild.textContent = secondToLastLink;
            last.firstChild.href ="../balayanlms/studentDashboard.php?page="+totalStudentsandPage['totalPage']+'&keyword='+keyword;
            last.firstChild.textContent = totalStudentsandPage['totalPage'];
            links.push(inBetween);
            links.push(secondToLast);
            links.push(last);
        }else{
            const inBetween = links[1];
            const first = links[1];
            const second = links[1];
            inBetween.firstChild.removeAttribute("href");
            inBetween.firstChild.textContent = "...";
            first.firstChild.href = "../balayanlms/studentDashboard.php?page=1"+'&keyword='+keyword;
            first.textContent = "1";
            second.firstChild.href ="../balayanlms/studentDashboard.php?page=2"+'&keyword='+keyword;
            second.firstChild.textContent = "2";
            links.push(first);
            links.push(second);
            links.push(inBetween);
            for(let i = totalStudentsandPage['totalPage'] - 6; i <= totalStudentsandPage['totalPage']; i++){
                const li = document.createElement('li');
                const a = document.createElement('a');
                li.classList.add("page-item");
                a.classList.add("page-link");
                a.classList.add("text-dark");
                a.textContent = i;
                if(i == currentPage){
                    a.classList.add('active');
                    a.classList.remove('text-dark')
                }else{
                    a.href =  "../balayanlms/studentDashboard.php?page="+i+'&keyword='+keyword;
                }
                li.append(a);
                links.push(li);
            }
        }
    }
    links.push(createNextPage(currentPage, totalStudentsandPage['totalPage'], keyword));
    const paginationContainer  =document.querySelector('.pagination');
    if(paginationContainer.hasChildNodes()){
        while(paginationContainer.firstChild){
            paginationContainer.removeChild(paginationContainer.firstChild);
        }
    }
    links.forEach(link=> paginationContainer.append(link));
    if(currentPage > 1){
        const limit = document.querySelector('#limit');
        limit.disabled = true;
    }
}

const displayData = async(keyword, limit, currentPage) =>{
    const students = await getStudents(keyword, limit);
    const totalStudentsandPage = await getTotalStudents(keyword, limit);
    const table = await createTable(students);
    await createPagination(totalStudentsandPage, currentPage, keyword);
    return table;
}

const renderData = (keyword, limit, currentpage) =>{
    keyword = keyword.value == "" ? 'null' : keyword.value;
    displayData(keyword, limit, currentpage).then(result =>{
        table.appendChild(result);
    }).catch(err =>{
        Swal.fire(
            'Error!',
            err.message,
            'error'
          )
    });
}

table.addEventListener("load", renderData(keyword, limit.value, page.value));
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