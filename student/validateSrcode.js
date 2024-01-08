const form = document.querySelector('.addStudent');
const srcode = document.querySelector('#srcode');
const firstName = document.querySelector('#firstname');
const lastName = document.querySelector('#lastname');
const program = document.querySelector('#program');
const course = document.querySelector('#course');
const submit = document.querySelector('#submitBtn');

srcode.addEventListener('input', e=>{
    const val = e.target.value.trim();
    if(isEmpty(val)){
        setError(e.target, 'Please provide an srcode');
        submit.disabled = true;
    }else{
        if(isValidSrcode(val)){
            isRegistered(val)
            .then(result=>{
                if(result === 'registered'){
                    setError(e.target, "The provided srcode is already registered.");
                    submit.disabled = true;
                }else{
                    setSuccess(e.target);
                    submit.disabled = false;
                }
            });
        }else{
            setError(e.target, "Please provide a valid srcode");
            submit.disabled = true;
        }
    }
})

const isValid = () =>{
    if(isEmpty(firstName.value)){
        setError(firstName, 'Please provide a first name');
        return true; 
    }else{
        setSuccess(firstName);
    }
    if(isEmpty(lastName.value)){
        setError(lastName, 'Please provide a last name');
        return true; 
    }else{
        setSuccess(lastName);
    }
    if(isEmpty(program.value)){
        setError(program, 'Please provide a program');
        return true; 
    }else{
        setSuccess(program);
    }
    return false;
}

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
const isEmpty = (value) =>{
    if(value === ""){
        return true;
    }
    return false;
}
const isValidSrcode = (srcode) =>{
    const regex = /^[\d]{2}-[\d]{5}$/
    return regex.test(srcode);
}
const isRegistered = async (value) =>{
    const response = await fetch('../balayanlms/student/isRegistered.php?srcode='+value);
    const result = await response.text();
    return result;
}

const addStudent = () =>{
    const srcodeVal = srcode.value.trim();
    const firstnameVal = firstName.value.trim();
    const lastnameVal = lastName.value.trim();
    const programVal = program.value.trim();
    const courseVal = course.value.trim();
    const student = {
        srcode: srcodeVal,
        firstname: firstnameVal, 
        lastname: lastnameVal,
        program:  programVal,
        course: courseVal
    }
    
    insertStudent(student)
    .then(result=>{
        if(result === 'success'){
            Swal.fire({
                icon: 'success',
                title: 'Operation Successful',
                text: 'A new student has been registered'
            });
            const modal = bootstrap.Modal.getInstance(document.querySelector('#addStudent'));
            modal.hide();
            srcode.value = "";
            firstName.value = "";
            lastName.value = "";
            program.value = "";
            const tbody = table.lastElementChild;
            if(document.body.contains(tbody)){
                tbody.replaceChildren();
            }
            renderData(keyword, limit.value, page.value);
        }
    }).catch(error=>{
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message
        });
    });

}

const insertStudent = async(student) =>{
    const response = await fetch('../balayanlms/student/create_student.php', {
        method: "POST",
        headers: {
            "Content-Type": "Application/json"
        },
        body: JSON.stringify(student)
    });
    const result = await response.text();
    if( result !== 'success'){
        throw new Error(result);
    }
    return result;
}

form.addEventListener('submit', e=>{
    e.preventDefault();
    e.stopPropagation();
    if(!isValid()){
        addStudent();   
    }
});