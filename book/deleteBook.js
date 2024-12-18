const deleteBook = (id) =>{
    Swal.fire({
        title: 'Are you sure?',
        text: "This will remove this book in the collection.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b33939',
        cancelButtonColor: '#4f4f4f',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
            return partialDelete(id);
        }
      }).then((result) => {
        if(result == 'success'){  
          Swal.fire(
                'Deleted!',
                'The book has been removed to the collection.',
                'success'
              )
            document.getElementById(id).style.display = "none";
        }
      }).catch((error) =>{
        Swal.fire(
            'Error!',
            error.message,
            'error'
          )
      })
}

const deleteBookOnView = (id) =>{
  Swal.fire({
    title: 'Are you sure?',
    text: "This will remove this book in the collection.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#b33939',
    cancelButtonColor: '#4f4f4f',
    confirmButtonText: 'Yes'
  }).then((result)=>{
    if (result.isConfirmed) {
      return partialDelete(id);
    }
  }).then((result)=>{
    if(result == 'success'){  
      sessionStorage.setItem("status", "ok");
      sessionStorage.setItem("statusIcon", "success");
      sessionStorage.setItem("statusTitle", "Deleted!");
      sessionStorage.setItem("statusText", "The book has been removed to the collection.");
      window.location.replace("../balayanlms/bookDashboard.php");
    }
  }).catch((error) =>{
    Swal.fire(
        'Error!',
        error.message,
        'error'
      )
  })
}

const partialDelete = async (id) =>{
    const response = await fetch('../balayanlms/book/partialDelete.php?id='+id);
    const result = await response.text();
    if(result !== 'success'){
        throw new Error(result);
    }
    return result;
}