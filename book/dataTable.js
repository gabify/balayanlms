//get table element
const table = document.querySelector("#bookTable");

//get select element
const limit = document.querySelector('#limit');

//get book search form
const bookSearchForm = document.querySelector('#bookSearch');

//page info
const pageInfo = document.getElementById("pageInfo");

//get data using fetch
const getData = async(limit, keyword) =>{
    const response = await fetch('../balayanlms/book/fetch_data.php?limit='+limit+'&keyword='+keyword);
    const result = await response.json();
    if(result == 'Some error occurred'){
        throw new Error("No such book exist");
    }
    return result;
}
//get total pages and total books
const getTotal = async(limit, keyword) =>{
    const response = await fetch('../balayanlms/book/countNumRows.php?limit='+limit+'&keyword='+keyword);
    const result = await response.json();
    return result;
}

//render to DOM
const displayData = (limit, keyword) =>{
    getData(limit, keyword).then((books) =>{
        const tbody = document.createElement("tbody");
        for(const book of books){ //for each book
            //create elements
            const tr = document.createElement("tr");
            let tds = [];
            const viewLink = document.createElement("a");
            const editLink = document.createElement("a");
            const deleteBtn = document.createElement("button");
            let icns =[];
            for(i = 0; i < 4; i++){
                const td = document.createElement("td");
                tds[i] = td;
            }
            for(i=0; i<3; i++){
                const icn = document.createElement("i");
                icns[i] = icn;
            }
            //add attributes
            tr.setAttribute("id", book['id']);
            viewLink.setAttribute("class", "btn");
            viewLink.setAttribute("href", "../balayanlms/viewBook.php?id="+book['id']);
            editLink.setAttribute("class", "btn");
            editLink.setAttribute("href", "../balayanlms/editBook.php?id="+book['id']);
            deleteBtn.setAttribute("class", "btn");
            deleteBtn.setAttribute("onclick", "deleteBook("+book['id']+")");
            icns[0].setAttribute("class", "bi-eye-fill fs-4 text-primary");
            icns[1].setAttribute("class", "bi-pencil-fill fs-4 text-warning");
            icns[2].setAttribute("class", "bi-trash3-fill fs-4 text-danger");
            //add data
            tds[0].textContent = book['accessnum'];
            tds[1].textContent = book['callnum'];
            tds[2].textContent = book['title'];
            //append to tr and tbody
            viewLink.appendChild(icns[0]);
            editLink.appendChild(icns[1]);
            deleteBtn.appendChild(icns[2]);
            
            tds[3].appendChild(viewLink);
            tds[3].appendChild(editLink);
            tds[3].appendChild(deleteBtn);
            tds.forEach(td=>{
                tr.appendChild(td);
            });
            tbody.appendChild(tr);
        }
        table.appendChild(tbody);
        pageInfo.textContent = "";
        pageInfo.textContent += "Showing "+tbody.childElementCount+" ";
    }).catch((err) =>{
        Swal.fire(
            'Error!',
            err.message,
            'error'
          )
    });
    getTotal(limit, keyword).then(result =>{
        pageInfo.textContent += "out of " + result['totalBooks']+ " Books"; //naiiwan need idebug
        //pagination naaaaaaa!!!
    }).catch(err=>{
        Swal.fire(
            'Error!',
            err.message,
            'error'
          )
    });
}

//add event listener to the table element
table.addEventListener("onload", 
    displayData(limit.value, document.getElementById("keyword").value == "" ? "null": keyword));
limit.addEventListener("change", ()=>{
    const tbody = table.lastElementChild;
    const keyword = document.getElementById("keyword").value;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    displayData(limit.value, keyword == "" ? "null": keyword);
});
bookSearchForm.addEventListener("submit", (e)=>{
    e.preventDefault();
    const tbody = table.lastElementChild;
    const keyword = document.getElementById("keyword").value;
    if(document.body.contains(tbody)){
        tbody.replaceChildren();
    }
    displayData(limit.value, keyword == "" ? "null": keyword);
});

