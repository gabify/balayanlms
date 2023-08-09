const employeeNum = document.querySelector('#employeeNum');
const firstName = document.querySelector('#firstname');
const lastName = document.querySelector('#lastname');
const form = document.querySelector('#addFaculty');

const setError = (element, message) =>{
    const label = element.previousElementSibling;
    const error = element.nextElementSibling;

    label.classList.add("text-danger");
    element.classList.add("border-danger");

    error.textContent = message;
}

const setSuccess = (element) =>{
    const label = element.previousElementSibling;
    const error = element.nextElementSibling;

    label.classList.remove("text-danger");
    element.classList.remove("border-danger");

    error.textContent = "";
}

const isEmpty = element =>{
    if(element.value == ''){
        return true;
    }
    return false;
}

const checkValidity = () =>{
    if(isEmpty(employeeNum)){
        setError(employeeNum, 'Please provide an employee number');
        return true;
    }else{
        setSuccess(employeeNum);
    }
    if(isEmpty(firstName)){
        setError(firstName, 'Please provide a first name');
        return true;
    }else{
        setSuccess(firstName);
    }
    if(isEmpty(lastName)){
        setError(lastName, 'Please provide a last name');
        return true;
    }else{
        setSuccess(lastName);
    }
    return false;
}

const createFaculty = async faculty =>{
    const response = await fetch('../balayanlms/faculty/create_faculty.php', {
        method: "POST",
        headers: {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify(faculty)
    });
    const result = await response.text();
    if(result !== 'success'){
        throw new Error(result);
    }
    return result;
}

const addNewFaculty = () =>{
    const employeeNumVal = employeeNum.value;
    const firstNameVal = firstName.value;
    const lastNameVal = lastName.value;

    const facultyData = {
        employeeNum: employeeNumVal,
        firstname: firstNameVal,
        lastname: lastNameVal
    }

    createFaculty(facultyData)
    .then(result=>{
        if(result === 'success'){
            Swal.fire(
                'Operation Successful!',
                'A new faculty has been registered',
                'success'
            );
            const modal = bootstrap.Modal.getInstance(document.querySelector('#addFaculty'));
            modal.hide();
            employeeNum.value = "";
            firstName.value = "";
            lastName.value = "";
            const tbody = table.lastElementChild;
            if(document.body.contains(tbody)){
                tbody.replaceChildren();
            }
            renderData(keyword, limit.value, page.value);
        }
    }).catch(error=>{
        Swal.fire(
            'Error!',
            error.message,
            'error'
        );
    });
}

form.addEventListener('submit', e=>{
    e.preventDefault();
    e.stopPropagation();
    if(!checkValidity()){
        addNewFaculty();
    }
})