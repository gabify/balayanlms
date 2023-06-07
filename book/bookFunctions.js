function toDelete(id){
    const toDelete = {"id": id};
    Swal.fire({
        icon: 'warning',
        title: '<b>Are you sure?</b>',
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) =>{
        if(result.isConfirmed){
            return partialDelete(toDelete)
        }
    }).then(() =>{
        Swal.fire(
            'Deleted',
            'Book has successfully deleted.',
            'success'
        )
        //reload table, still figuring out how to do it
    }).catch(err => {
        Swal.fire(
            'Error',
            err.message,
            'error'
        )
    })
}

const partialDelete = async(id) =>{
    const response = await fetch("../balayanlms/book/partialBookDelete.php", {
        "method" : "PUT",
        "headers" : {"Content-Type" : "application/json; charset=utf-8"},
        "body": JSON.stringify(id) 
    });
    const result = await response.text();
    return result;
}