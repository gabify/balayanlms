const form = document.querySelector('.addNewThesis');
const callnum = document.querySelector('#callnum');
const title = document.querySelector('#title');
const author = document.querySelector('#author');
const adivser = document.querySelector('#adviser');
const publicationYear = document.querySelector('#publicationYear');

const setError = (element, message) =>{
    const label = element.previousElementSibling;
    const error = element.nextElementSibling;

    error.textContent = message;

    label.classList.add("text-danger");
    element.classList.add("border-danger");
}

const setSuccess = (element) =>{
    const label = element.previousElementSibling;
    const error = element.nextElementSibling;

    error.textContent = "";

    label.classList.remove("text-danger");
    element.classList.remove("border-danger");
}

const isEmpty = (element) =>{
    if(element.value == ''){
        return true;
    }
    return false;
}

const checkValidity = () =>{
    if(isEmpty(callnum)){
        setError(callnum, 'Please provide a call number');
        return false;
    }else{
        setSuccess(callnum);
    }
    if(isEmpty(title)){
        setError(title, 'Please provide a title');
        return false;
    }else{
        setSuccess(title);
    }
    if(isEmpty(author)){
        setError(author, 'Please provide an author');
        return false;
    }else{
        setSuccess(author);
    }
    if(isEmpty(adivser)){
        setError(adivser, 'Please provide an adviser');
        return false;
    }else{
        setSuccess(adivser);
    }
    if(isEmpty(publicationYear)){
        setError(publicationYear, 'Please provide a publication year');
        return false;
    }else{
        setSuccess(publicationYear);
    }
    return true;
}

const addThesis = () =>{
    const callnumVal = callnum.value.trim();
    const titleVal = title.value.trim();
    const authorVal = author.value.trim();
    const adviserVal = adivser.value.trim();
    const publicationYearVal = publicationYear.value.trim();

    const thesis = {
        callnum: callnumVal,
        title: titleVal,
        author: authorVal,
        adviser: adviserVal,
        publicationYear: publicationYearVal
    }

    createThesis(thesis)
    .then(result =>{
        if(result == 'success'){
            Swal.fire({
                icon: 'success',
                title: 'Operation Successful',
                text: 'A new thesis has been added to the collection'
            });
            const modal = bootstrap.Modal.getInstance(document.querySelector('#addThesis'));
            modal.hide();
            callnum.value = "";
            title.value = "";
            author.value = "";
            adivser.value = "";
            publicationYear.value = "";
            const tbody = table.lastElementChild;
            if(document.body.contains(tbody)){
                tbody.replaceChildren();
            }
            const limit = document.querySelector('#limit');//something wrong with limit. dunno
            const keyword = document.querySelector('#keyword');
            const page = document.querySelector('#page');
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

const createThesis = async thesis =>{
    const response = await fetch('../balayanlms/thesis/create_thesis.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(thesis)
    });
    const result = await response.text();
    if(result != 'success'){
        throw new Error(result);
    }
    return result;
}

form.addEventListener('submit', e=>{
    e.preventDefault();
    e.stopPropagation();
    if(checkValidity()){
        addThesis();
    }
});