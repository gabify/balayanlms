//create list view
//madami pa kulang
const createBookList = async(books)=>{
    for(const book of books){
        //get booklist
        const bookList = document.querySelector(".bookList");
        //create card container
        const cardContainer = document.createElement('div');
        cardContainer.classList.add("col-4");
        cardContainer.classList.add("my-3");
        //create card
        const card = document.createElement('div');
        card.classList.add("card");
        //create card body
        const cardBody = document.createElement('div');
        cardBody.classList.add("card-body");
        cardBody.classList.add("px-3");
        //create card footer
        const cardFooter = document.createElement('div');
        cardFooter.classList.add("card-footer");
        //create card title
        const cardTitle = document.createElement('h5');
        cardTitle.classList.add("card-title");
        cardTitle.classList.add("mb-0");
        cardTitle.textContent = "#"+book["accessnum"];
        //create card subtitle
        const cardSubtitle = document.createElement('h6');
        cardSubtitle.classList.add("card-subtitle");
        cardSubtitle.classList.add("text-secondary");
        cardSubtitle.classList.add("ms-1");
        cardSubtitle.textContent = book["callnum"];
        //create card text
        const cardText= document.createElement('p');
        cardText.classList.add("card-text");
        cardText.classList.add("display-5");
        cardText.classList.add("pt-2");
        cardText.textContent = book["title"];

        //append
        cardBody.appendChild(cardTitle);
        cardBody.appendChild(cardSubtitle);
        cardBody.appendChild(cardText);
        card.appendChild(cardBody);
        cardContainer.appendChild(card);
        bookList.appendChild(cardContainer);    
    }
}

//create DOM
const displayBookList = async(limit, page, keyword)=>{
    const books = await getData(limit, page, keyword);
    await createBookList(books);
}

//render DOM

const bookList = document.querySelector(".bookList");
bookList.addEventListener("load", 
    displayBookList(10, 1, "null"));