<?php


include 'Database.php';

    function ValidateBook($book){
        $errors = [];


        if(empty($book['BookTitle'])){
            $errors[] = "Book Title is required!";
        }

        if(strlen($book['BookTitle']) > 255){
            $errors[] = "Book title too long!";
        }

        if(empty($book['Author'])){
            $errors[] = "Author must be entered!";
        }

        if(strlen($book['Author']) > 255){
            $errors[] = "Author name too long";
        }

        if(empty($book['genreOption'])){
            $errors[] = "Genre must be selected";
        }

        $desc = trim($book['BookDesc']);

        if(empty($desc)){
            $errors[] = "Description must be entered";
        }

        if(strlen($book['BookDesc']) > 255){
            $errors[] = "Description too long";
         }

        if(strlen($desc) < 5){
            $errors[] = "Description must be longer than 5 chars";
        }


        return $errors;


    }

    function CheckBookExists(string $title, string $author){
        $errors = [];
        $pdo = DBConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Books WHERE BookTitle = :title AND Author = :author");
        $stmt->execute([
            ':title' => $title,
            ':author' =>$author
        ]);

        if($stmt->fetchColumn() > 0){
            $errors[] = "Book Already Exists";
        };
        return $errors;
    }


    function ValidID($id, $type){
        $errors = [];

        if(empty($id)){
            $errors[]= "Invalid " .$type ." ID - ID Must not be empty!";
        }

        if(!filter_var($id,FILTER_VALIDATE_INT)){
            $errors[] = "Invalid " .$type ." ID - ID Must be a number!";
        }

        return $errors;
    }

    function ValidLoan($Loan){
        $errors = [];

        if(empty($Loan['MemberName'])){
            $errors[] = "No Member Selected";
        }

        if(empty($Loan['BookTitle'])){
            $errors[] = "No Book Selected";
        }

        //https://medium.com/@philippebeck/discover-php-date-time-functions-781876b43b95//

        $startDate = new DateTime($Loan['StartDate']);
        $dueDate = new DateTime($Loan['DueDate']);
        $MaxDueDate = clone $startDate;
        $MaxDueDate->modify('+14 day');

        if($startDate->format('Y-m-d') == $dueDate->format('Y-m-d')){
            $errors[] = "Due Date cannot be today's date";
        }

        if($dueDate->format('Y-m-d') < $startDate->format('Y-m-d')){
            $errors[] = "Due Date cannot be in the past";
        }

        if($dueDate->format('Y-m-d') > $MaxDueDate->format('Y-m-d')){
            $errors[] = "Due Date Cannot be more than 14 days";
        }




        return $errors;
    }
    

?>