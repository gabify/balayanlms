const form = document.getElementById('addForm');
const insertBook = () =>{
    //get all inputs
    const callnum = document.getElementById('callnum').value;
    const title = document.getElementById('title').value;
    const publisher = document.getElementById('publisher').value;
    const author = document.getElementById('author').value;
    const copyright = document.getElementById('copyright').value;

    //convert to object
    const book_data = {callnum, title, publisher,author,copyright};

    //make post request
    insert(book_data).then(()=>{ //If request ok
        //show suucess alert
        Swal.fire({
            icon: 'success',
            title: 'Operation Successful',
            text: 'A new book has been added to the collection'
        });
        //hide the modal
        const modal = bootstrap.Modal.getInstance(document.querySelector('#addBook'));
        modal.hide();
        //remove text on the text field
        document.querySelector('#callnum').value = "";
        document.querySelector('#title').value = "";
        document.querySelector('#publisher').value = "";
        document.querySelector('#author').value = "";
        document.querySelector('#copyright').value = "";
        //update table
        //get page number
        const page = document.querySelector('#page');
        //get select element
        const limit = document.querySelector('#limit');
        renderData(limit.value, page.value, document.getElementById("keyword"));
    }).catch((err)=>{//If some error occured
        //display error message
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: err
        });
    });
}

const insert = async (book_data) =>{
    const response = await fetch('../balayanlms/book/addBookTransaction.php',{
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(book_data)
    });
    const result = await response.text();
    console.log(result);
    if(result == 'Aborted'){
        throw new Error('An error occured while processing the data.');
    }
    return result;
}

form.addEventListener("submit", (e)=>{
    e.preventDefault();
    //add form validation here
    insertBook();
});