const table = document.querySelector('#facultyTable');
const page = document.querySelector('#page');
const limit = document.querySelector('#limit');
const keyword = document.querySelector('#keyword');

const getFaculties = async(keyword, limit, page) =>{
    const response = await fetch('../balayanlms/faculty/fetch_faculty.php?keyword='+keyword
    +'&limit='+limit+'&page='+page);
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
        tds[3].append(createDeleteButton(faculty['id']));
        const th = document.createElement('th');
        th.setAttribute("scope", "row");
        th.textContent = i++;
        const tr = document.createElement('tr');
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

const displayData = async(keyword, limit, page) =>{
    const faculties = await getFaculties(keyword, limit, page);
    const tbody = await createTable(faculties);
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