//get reference to the table
const table = document.querySelector('#studentTable');

//get data from php
const getStudents = async() =>{
    const response = await fetch('../balayanlms/student/fetch_student.php');
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

const displayData = async() =>{
    const students = await getStudents();
    const table = await createTable(students);
    return table;
}

const renderData = () =>{
    displayData().then(result =>{
        table.appendChild(result);
    }).catch(err =>{
        Swal.fire(
            'Error!',
            err.message,
            'error'
          )
    });
}

table.addEventListener("load", renderData());