<?php
class Genre{
    private $GenreCode;
    private $GenreDesc;
    
    public function __construct(string $code, string $desc){
        $this->setGenreCode($code);
        $this->setGenreDesc($desc);
    }

    public function GetGenreCode(){
        return $this->GenreCode;
    }

    public function setGenreCode($code){
        $this->GenreCode = $code;
    }

    public function GetGenreDesc(){
        return $this->GenreDesc;
    }

    public function setGenreDesc($desc){
        $this->GenreDesc = $desc;
    }

    public function GetGenres(){
        $pdo = DBConnection();
        $GenresArray = [];
            
        $sql = "SELECT * FROM GENRES ORDER BY GENRECODE;";
        $result = $pdo->prepare($sql);
        $result->execute();
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $genre = new Genre($row['GenreCode'],$row['GenreDesc']);
            $GenresArray[] = $genre;
        }
        return $GenresArray;
    }

}


//----------------Book Class-----------------

class Book{
    private int $bookID;
    private string $GenreCode;
    private string $BookTitle;
    private string $Author;
    private string $Description;
    private string $Status;
    private string $IsDeleted;
    
    public function __construct(int $id,string $title,string $genre, string $author, string $des){
        $this->bookID = $id;
        $this->SetBookTitle($title);
        $this->SetGenreCode($genre);
        $this->SetAuthor($author);
        $this->SetDescription($des);
        $this->SetStatus("A");
        $this->SetDeleted("N");
    
    }

    public function GetBookID(){
        return $this->bookID;
    }
    public function GetGenreCode(){
        return $this->GenreCode;
    }

    public function GetBookTitle(){
        return $this->BookTitle;
    }

    public function GetAuthor(){
        return $this->Author;
    }

    public function GetDescription(){
        return $this->Description;
    }

    public function GetStatus(){
        return $this->Status;
    }

    public function GetIsDeleted(){
        return $this->IsDeleted;
    }

    public function SetBookTitle($title){
        $this->BookTitle = $title;
    }

    public function SetGenreCode($genre){
        $this->GenreCode = $genre;
    }

    public function SetAuthor($author){
        $this->Author = $author;
    }

    public function SetDescription($desc){
        $this->Description = $desc;
    }

    public function SetStatus($status){
        $this->Status = $status;
    }

    public function SetDeleted($del){
        $this->IsDeleted = $del;
    }

    

     public function AddBook(){
     $pdo = DBConnection();
     $stmt = $pdo->prepare("INSERT INTO Books (BookTitle, Author, GenreCode, Description, Status, IsDeleted)
                            Values (:title, :author, :genre, :desc, :status, :isdeleted)");
    $stmt->execute([
        ':title' => $this->GetBookTitle(),
        ':author' => $this->GetAuthor(),
        ':genre' => $this->GetGenreCode(),
        ':desc' => $this->GetDescription(),
        ':status' => $this->GetStatus(),
        ':isdeleted' => $this->GetIsDeleted()
    ]);
        return "Book '{$this->GetBookTitle()}' added successfully";   
    }


    public static function FindBookByID(int $id){

        $pdo = DBConnection();
        $stmt = $pdo->prepare("SELECT * FROM BOOKS WHERE BOOKID = :id AND ISDELETED = 'N'");
        $stmt->execute([
            ':id' => $id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result !== false){

            $book = new Book(
            $result['BookID'],
            $result['BookTitle'],
            $result['GenreCode'],
            $result['Author'],
            $result['Description']);

            $book->SetStatus($result['Status']);

            return $book;
        }else{
            return null;
        }
    }

    public function UpdateBook(){
        
        $pdo = DBConnection();

        $stmt = $pdo->prepare("UPDATE Books SET
         BookTitle = :title,
         Author = :author,
         GenreCode = :genre,
         Description = :desc,
         Status = :status,
         IsDeleted = :isdeleted
         WHERE BookID = :id");

         $stmt->execute([    
        ':title' => $this->GetBookTitle(),
        ':author' => $this->GetAuthor(),
        ':genre' => $this->GetGenreCode(),
        ':desc' => $this->GetDescription(),
        ':status' => $this->GetStatus(),
        ':isdeleted' => $this->GetIsDeleted(),
        ':id' => $this->GetBookID()
         ]);

         return "Book Updated Successfully";

    }

    public function RemoveBook(){
        $pdo = DBConnection();

        $stmt = $pdo->prepare("UPDATE Books SET
        IsDeleted = 'Y'
        WHERE BookID =:id");

        $stmt->execute([
            ':id' => $this->GetBookID()
        ]);

        return "Book Removed Successfully";
    }

    public static function BookExistsForUpdate($title, $author, $id){
        $errors = [];
        $pdo = DBConnection();

        $stmt = $pdo->prepare("SELECT COUNT(*) AS Total FROM Books 
                                WHERE BookTitle = :title AND Author = :author AND BookID != :id");

        $stmt->execute([
            ':title' =>$title,
            ':author' =>$author,
            ':id' => $id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $count = $result['Total'];
        

        if($count > 0){
            $errors[] = "Book Already Exists - No duplicate books allowed!";
        }

        return $errors;
    }

    public static function FindAllBooks(string $input){
        $pdo = DBConnection();
        $Books = [];
            
        $sql = "SELECT * FROM BOOKS WHERE BOOKTITLE LIKE :booktitle AND Status = 'A' ORDER BY BOOKTITLE;";
        $result = $pdo->prepare($sql);
        $result->execute([
            ':booktitle' => "%$input%"
        ]);
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $book = new Book($row['BookID'],$row['BookTitle'],$row['GenreCode'],$row['Author'],$row['Description']);
            $Books[] = $book;
        }

        $table = "";

        foreach($Books as $book){
            $badge = "";
            $status = "";
            if($book->GetStatus() == "A"){
                $badge = "badge-available";
                $status = "Available";
            }else{
                $badge = "badge-onloan";
                $status = "On Loan";
            }
            $table .= "<tr>
            <td>{$book->GetBookID()}</td>
            <td>{$book->GetBookTitle()}</td>
            <td>{$book->GetAuthor()}</td>
            <td>{$book->GetGenreCode()}</td>
            <td><span class='badge {$badge}'>{$status}</span></td>
            </tr>";
        }

        $table .= "</table>";

        if(count($Books) == 0){
            return "";
        }else{
            return $table;
        }


        
    }


}



//-----------Member Class
class Member{
    private int $MemberID;
    private string $Fname;
    private string $Sname;
    private string $Phone;
    private string $Email;
    private string $IsDeleted;

    public function __construct(int $id ,string $fname,string $sname, string $phone, string $email){
        $this->SetMemberID($id);
        $this->SetFname($fname);
        $this->SetSname($sname);
        $this->SetPhone($phone);
        $this->SetEmail($email);
        $this->SetStatus();
    
    }

    public function GetMemberID(){
        return $this->MemberID;
    }

    public function GetFname(){
        return $this->Fname;
    }

    public function GetSname(){
        return $this->Sname;
    }

    public function GetPhone(){
        return $this->Phone;
    }

    public function GetEmail(){
        return $this->Email;
    }

    public function GetStatus(){
        return $this->Status;
    }

    public function SetMemberID($ID){
         $this->MemberID = $ID;
    }

    public function SetFname($fname){
        $this->Fname = $fname;
    }

    public function SetSname($sname){
        $this->Sname = $sname;
    }

    public function SetPhone($phone){
        $this->Phone = $phone;
    }

    public function SetEmail($email){
        $this->Email = $email;
    }

    public function SetStatus(){
        $this->IsDeleted = 'N';
    }

    public function __toString(){
        $str = "Member Details:\n\n
        Member ID: {$this->MemberID}\n
        First Name: {$this->Fname}\n
        Surname: {$this->Sname}\n
        Phone: {$this->phone}\n
        Email: {$this->Email}";

        return $str;
    }

    public static function GetMemberByID(int $id){
        
        $pdo = DBConnection();
        $stmt = $pdo->prepare("SELECT * FROM MEMBERS WHERE MEMID = :id");
        $stmt->execute([
            ':id' => $id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result !== false){

            $member = new Member(
            $result['MemID'],
            $result['Fname'],
            $result['Sname'],
            $result['Phone'],
            $result['Email'],
            $result['IsDeleted']);

            return $member;
        }else{
            return null;
        }

    }
}


class Loan{
    private int $LoanID;
    private int $MemID;
    private int $BookID;
    private string $StartDate;
    private string $DueDate;
    private string $ReturnedDate;

    public function __construct(int $loanId = null, int $memID, int $bookID, string $startDate, string $dueDate ){
        $this->SetLoanID($loanId);
        $this->SetMemID($memID);
        $this->SetBookID($bookID);
        $this->SetStartDate($startDate);
        $this->SetDueDate($dueDate);

    }

    public function GetLoanID(){
        return $this->LoanID;
    }

    public function GetMemID(){
        return $this->MemID;
    }

    public function GetBookID(){
        return $this->BookID;
    }

    public function GetStartDate(){
        return $this->StartDate;
    }

    public function GetDueDate(){
        return $this->DueDate;
    }

    public function GetReturnedDate(){
        return $this->ReturnedDate;
    }

    public function SetLoanID($loanId){
        $this->LoanID = $loanId;
    }

    public function SetMemID($memID){
        $this->MemID = $memID;
    }

    public function SetBookID($bookID){
        $this->BookID = $bookID;
    }

    public function SetStartDate($startDate){
        $this->StartDate = $startDate;
    }

    public function SetDueDate($dueDate){
        $this->DueDate = $dueDate;
    }

    public function SetReturnedDate($returnedDate){
        $this->ReturnedDate = $returnedDate;
    }

    public function __toString(){
        $str = "Loan Details:\n\n
        Loan ID: {$this->LoanID}\n
        Member ID: {$this->MemID}\n
        Book ID: {$this->BookID}\n
        StartDate : {$this->StartDate}\n
        Due Date : {$this->DueDate}\n
        Returned Date: {$this->ReturnedDate}";

        return $str;
    }

    public static function NextLoanID(): int{


        $pdo = DBConnection();
        $stmt = $pdo->prepare("SELECT MAX(LoanID) AS MaxID FROM Loans");
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result['MaxID'] == null ){

            return 1;
        }else{
  
            return $result['MaxID'] + 1;
        }
        

    }

    public function AddLoan(){

        $pdo = DBConnection();

        $stmt_Book = $pdo->prepare("UPDATE Books SET STATUS = 'L' WHERE BookID = :bookid");
        $stmt_Book->execute([
            ':bookid' =>$this->GetBookID()
        ]);

        $stmt = $pdo->prepare("INSERT INTO Loans (LoanID, MemID, BookID, StartDate, DueDate)
                            Values (:loanID, :memberID, :bookID, :startDate, :dueDate)");

        $stmt->execute([
        ':loanID' => $this->GetLoanID(),
        ':memberID' => $this->GetMemID(),
        ':bookID' => $this->GetBookID(),
        ':startDate' => $this->GetStartDate(),
        ':dueDate' => $this->GetDueDate()
    ]);


        return "Loan Added Successfully";
    }

    public static function NoLoans($bookid){
        $errors = [];
        $pdo = DBConnection();

        $stmt = $pdo->prepare("SELECT COUNT(*) AS loan_count FROM LOANS WHERE MemID = :id AND ReturnedDate IS NULL");
        $stmt->execute([
            ':id' =>$bookid
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $count = $result['loan_count'];


        if($count > 5){
            $errors[] = "Cannot have more than 5 Loans!";
        }

        return $errors;
    }
}
?>