function confirmAddBook(){

        let title = document.querySelector('input[name="BookTitle"]').value;
        let author = document.querySelector('input[name="Author"]').value;
        let genre = document.querySelector('select[name="genreOption"]').value;
        let desc = document.querySelector('textarea[name="BookDesc"]').value;

        let message = `Are you sure you want to update this book?\n\n
        Title: ${title}\n 
        Author: ${author}\n 
        Genre: ${genre}\n  
        Description: ${desc}`;

        return confirm(message);
}

function confirmBookUpdate(){

        let id = document.querySelector('input[name="BookID"]').value;
        let title = document.querySelector('input[name="BookTitle"]').value;
        let author = document.querySelector('input[name="Author"]').value;
        let genre = document.querySelector('select[name="genreOption"]').value;
        let desc = document.querySelector('textarea[name="BookDesc"]').value;

        let message = `Are you sure you want to update this book?\n\n
        BookID: ${id}\n
        Title: ${title}\n 
        Author: ${author}\n 
        Genre: ${genre}\n  
        Description: ${desc}`;

        return confirm(message);

}

function confirmBookDelete(){

        let id = document.querySelector('input[name="BookID"]').value;
        let title = document.querySelector('input[name="BookTitle"]').value;
        let author = document.querySelector('input[name="Author"]').value;
        let genre = document.querySelector('input[name="genreOption"]').value;
        let desc = document.querySelector('textarea[name="BookDesc"]').value;
        let status = document.querySelector('input[name="Status"]').value;
        let isDeleted = document.querySelector('input[name="IsDeleted"]').value;

        let message = `Are you sure you want to remove this book?\n\n
        BookID: ${id}\n
        Title: ${title}\n 
        Author: ${author}\n 
        Genre: ${genre}\n  
        Description: ${desc}\n
        Status: ${status}\n
        IsDeleted: ${isDeleted}`;

        return confirm(message);

}

function confirmLoan(){
        let title = document.querySelector('input[name="BookTitle"]').value;
        let author = document.querySelector('input[name="Author"]').value;
        let memberName = document.querySelector('input[name="MemberName"]').value;
        let memberEmail = document.querySelector('input[name="MemberEmail"]').value;
        let Sdate = document.querySelector('input[name="StartDate"]').value;
        let Ddate = document.querySelector('input[name="DueDate"]').value;

        let message = `Are you sure you want to add this loan?\n\n
        Book Title : ${title}\n 
        Author : ${author}\n 
        Member Name : ${memberName}\n  
        Member Email : ${memberEmail}\n
        Start Date : ${Sdate}\n
        Due Date : ${Ddate}`;

        return confirm(message);
}