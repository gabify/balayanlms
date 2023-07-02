const updateForm = document.querySelector('#updateForm');


const updateBook = () =>{
    //get all inputs
    const id = document.getElementById('bookId').value;
    const callnum = document.getElementById('callnum').value;
    const title = document.getElementById('title').value;
    const publisher = document.getElementById('publisher').value;
    const author = document.getElementById('author').value;
    const copyright = document.getElementById('copyright').value;
    const status = document.getElementById('status').value;
    //validate inputs
    //convert to object
    const book_data = {id, callnum, title, publisher,author,copyright, status};
    
    //make put request
    update(book_data).then(()=>{
        sessionStorage.setItem("status", "ok");
        sessionStorage.setItem("statusIcon", "success");
        sessionStorage.setItem("statusTitle", "Operation successful!");
        sessionStorage.setItem("statusText", "The book has been updated.");
        window.location.replace("../balayanlms/bookDashboard.php");
    }).catch(err =>{
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: err
        });
    });
}

const update = async (book_data) =>{
    const response = await fetch('../balayanlms/book/updateBookTransaction.php',{
        method: "PUT",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(book_data)
    });
    const result = await response.text();
    if(result == 'failed'){
        throw new Error('Operation failed. Please try again later.');
    }
    console.log(result);
    return result;
}


updateForm.addEventListener("submit", (e)=>{
    e.preventDefault();
    updateBook();
})