<?php
    include 'Validation.php';
    include 'Classes.php';

    $errors = [];
    $submittedBook = [];
    $successMsg = '';

    $RetrievedBook = null;
    $RetrievedMember = null;

    $AllBooks = "";



    

    
    function populateGenres($selectedGenre = null){ 
    $genreTemp = new Genre("","");
    $Array = $genreTemp->GetGenres();

    if(empty($Array)){
        echo "No Genres found!";
    }else{
    
    foreach($Array as $genre){
        $selected = "";
        $code = $genre->GetGenreCode();
        if($selectedGenre == $code){
            $selected = "selected";
        }

        echo "<option value='{$genre->GetGenreCode()}' $selected>{$genre->GetGenreCode()} - {$genre->GetGenreDesc()}</option>";
        
        
            }       
        }
    }
    
    
    
    
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['AddBook'])){
            
            $submittedBook = $_POST;
            $errors = ValidateBook($submittedBook);

            if(empty($errors)){
                $errors = CheckBookExists($submittedBook['BookTitle'],$submittedBook['Author']);

                if(empty($errors)){

                $book = new Book(
                0,
                $submittedBook['BookTitle'],
                $submittedBook['genreOption'],
                $submittedBook['Author'],
                $submittedBook['BookDesc']
                    );
                $successMsg = $book->AddBook();
                $submittedBook = [];
            }
            
               
            } 
        }

        if(isset($_POST['SearchBook'])){
            $Input = $_POST['BookSearchInput'];

            $errors = ValidID($Input, "Book");
            
            if(empty($errors)){
                
                $Input = (int)($Input);
                //running static methods from a class - https://www.w3schools.com/php/php_oop_static_methods.asp
                $GetBook =Book::FindBookByID($Input);
                $RetrievedBook = $GetBook;

                if(!$RetrievedBook){
                    $errors[] = "Book Not Found!";
                }
            }
           
            

        }

        if(isset($_POST['UpdateBook'])){
            
            $Input = $_POST;
            $errors = ValidateBook($Input);
            
            if(empty($errors)){
                $errors = Book::BookExistsForUpdate($Input['BookTitle'],$Input['Author'],$Input['BookID']);

                if(empty($errors)){
                $book = new Book(
                    $Input['BookID'],
                    $Input['BookTitle'],
                    $Input['genreOption'],
                    $Input['Author'],
                    $Input['BookDesc']

                    

                );

                $book->SetStatus($Input['Status']);
                $book->SetDeleted($Input['IsDeleted']);



                $successMsg = $book->UpdateBook();
                $RetrievedBook = null;
            }

            
                
            }
            
        
            
        }

        if(isset($_POST['DeleteBook'])){
            $Input = $_POST;
            $book = new Book(
                    $Input['BookID'],
                    $Input['BookTitle'],
                    $Input['genreOption'],
                    $Input['Author'],
                    $Input['BookDesc']


            );

            $book->SetStatus($Input['Status']);
            $book->SetDeleted($Input['IsDeleted']);

            

            if($book->GetStatus() == "L"){
                $errors[] = "Cannot Remove Loaned Book";
                return;
            }

            

            $successMsg = $book->RemoveBook();
            $RetrievedBook = null;
        }

        if(isset($_POST['SearchBookByName'])){
            $Input = $_POST['Booktitle'];
            $AllBooks = "";

            $output = Book::FindAllBooks($Input);

            if($output !== ""){
                $AllBooks = $output;
            }else{
                $errors[] = "No Books Found";
            }

        }

        if(isset($_POST['RetrieveDetails'])){

            $Input = $_POST;
            $errors = ValidID($Input['BookID'],"Book");

            if(empty($errors)){
                $errors = ValidID($Input['MemberID'], "Member");

                if(empty($errors)){
                    
                    $GetBook =Book::FindBookByID($Input['BookID']);
                    $RetrievedBook = $GetBook;

                    if($RetrievedBook == null){
                        $errors[] = "Book Not Found";

                    }

                    $GetMember = Member::GetMemberByID($Input['MemberID']);
                    $RetrievedMember = $GetMember;

                    if($RetrievedMember == null){
                        $errors[] = "Member Not Found";

                    }


                }
            }

            


            
        }

        if(isset($_POST['LoanBook'])){
            $Input = $_POST;
            $errors = ValidLoan($Input);


            if(empty($errors)){
                $errors = Loan::NoLoans($Input['MemberID']);


                if(empty($errors)){
                    $nextLoanID = Loan::NextLoanID();

               
                    $Loan = new Loan(
                    $nextLoanID,
                    $Input['MemberID'],
                    $Input['BookID'],
                    $Input['StartDate'],
                    $Input['DueDate']
                );

                    $successMsg = $Loan->AddLoan();
                    $RetrievedBook = null;
                    $RetrievedMember = null;
                }
            }
            

        }

        
    }

        
    
    
    

    
?>