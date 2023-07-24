//get reference to the table
const table = document.querySelector('#studentTable');
const searchForm = document.querySelector('#studentSearch');
const limit = document.querySelector('#limit');
const keyword = document.querySelector('#keyword');

//get data from php
const getStudents = async(keyword, limit) =>{
    const response = await fetch('../balayanlms/student/fetch_student.php?keyword='+keyword+'&limit='+limit);
    const result = await response.json();
    if(result == 'An error occured. Retrieved empty dataset'){
        throw new Error('Sorry. No such student exist.');
    }
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

const displayData = async(keyword, limit) =>{
    const students = await getStudents(keyword, limit);
    const table = await createTable(students);
    return table;
}

const renderData = (keyword, limit) =>{
    keyword = keyword.value == "" ? 'null' : keyword.value;
    displayData(keyword, limit).then(result =>{
        table.appendChild(result);
    }).catch(err =>{
        Swal.fire(
            'Error!',
            err.message,
            'error'
          )
    });
}

table.addEventListener("load", renderData(keyword, limit.value));
searchForm.addEventListener("submit", e =>{
    e.preventDefault();
    e.stopPropagation();
    const tbody = table.lastElementChild;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    renderData(keyword, limit.value);
});

limit.addEventListener('change', e =>{
    const tbody = table.lastElementChild;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    renderData(keyword, e.target.value);
});