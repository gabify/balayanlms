//get table element
const table = document.querySelector("#bookTable");

//get data using fetch
const getData = async() =>{
    const response = await fetch('../balayanlms/book/fetch_data.php');
    const result = await response.json();
    return result;
}

//render to DOM
const displayData = () =>{
    getData().then((books) =>{
        const tbody = document.createElement("tbody");
        for(const book of books){ //for each book
            //create elements
            const tr = document.createElement("tr");
            let tds = [];
            let btns = [];
            const viewLink = document.createElement("a");
            let icns =[];
            for(i = 0; i < 4; i++){
                const td = document.createElement("td");
                tds[i] = td;
            }
            for(i = 0; i<2; i++){
                const btn = document.createElement("button");
                btns[i] = btn;
            }
            for(i=0; i<3; i++){
                const icn = document.createElement("i");
                icns[i] = icn;
            }
            //add attributes
            tr.setAttribute("id", book['id']);
            btns.forEach(btn=>{btn.setAttribute("class", "btn")});
            viewLink.setAttribute("class", "btn");
            viewLink.setAttribute("href", "../balayanlms/book/view?id="+book['id']);
            btns[1].setAttribute("onclick", "deleteBook("+book['id']+")");
            icns[0].setAttribute("class", "bi-eye-fill fs-4 text-primary");
            icns[1].setAttribute("class", "bi-pencil-fill fs-4 text-warning");
            icns[2].setAttribute("class", "bi-trash3-fill fs-4 text-danger");
            //add data
            tds[0].textContent = book['accessnum'];
            tds[1].textContent = book['callnum'];
            tds[2].textContent = book['title'];
            //append to tr and tbody
            viewLink.appendChild(icns[0]);
            btns[0].appendChild(icns[1]);
            btns[1].appendChild(icns[2]);
            
            tds[3].appendChild(viewLink);
            btns.forEach(btn=>tds[3].appendChild(btn));
            tds.forEach(td=>{
                tr.appendChild(td);
            });
            tbody.appendChild(tr);
        }
        table.appendChild(tbody);
    }).catch((err) =>{
        console.log(err);
    });
}

//add event listener to the table element
table.addEventListener("onload", displayData());

