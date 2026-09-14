<?php require "Main.php"?>

<!DOCTYPE html>
<html lang='en'>
  <head>
    <title></title>
    <meta charset='utf-8'>
    <meta name='description' content=''>
    <meta name='keywords' content=''>
    <meta name='author' content=''>
    <meta name='robots' content='all'>
    <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>


  </head>
  <body>

    <header>
        <div class = "logo">
            <div class="logo-icon">
                <a href="Main.html">
                <img src="Images/library_logo.svg" alt="Library Logo">
                </a>
            </div>
            Library System
        </div>
        <span class="header-sub">Manage books & loans</span>
    </header>

<main>
  <div class="page-container">
    <?php
        if(!empty($errors)){
            $showError = "<div class='message-box error-box'><ul>";
            foreach($errors as $error){
                $showError .="<li>" . htmlspecialchars($error) ."</li>";
            }
            $showError .= "</ul></div>";
            echo $showError;
        }
  

        if(!empty($successMsg)){

        $showSuccess = "<div class='message-box success-box'>";
        $showSuccess .= htmlspecialchars($successMsg);
        $showSuccess .= "</div>";
        echo $showSuccess;


        }
    ?>

    <div class="card">

      <div class="step-header">
            <div class="step-num">1</div>
            <span class="step-title">Search Book</span>
      </div>
      
    

  
    
      <form method="POST" name="SearchBookByName" action="">
        <div class="form-row">
          <div class="form-group">
            <label>Book Title</label>
            <input type="text" name="Booktitle">
          </div>
        </div>

            <div style="margin-top: 1rem; display:flex; justify-content:flex-end;">
              <input type="submit" name="SearchBookByName" value="Search" class="btn btn-primary"></input>
            </div>
          
        
      </form>
    </div>

    <div class="card">
        <div class="step-header">
            <div class="step-num">2</div>
            <span class="step-title">Search Results</span>
        </div>  

      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Book ID</th>
              <th>Booktitle</th>
              <th>Author</th>
              <th>GenreCode</th>
              <th>Status</th>
            </tr>
          </thead>

          <tbody>
            <?php
              if($AllBooks != ""){
                  echo $AllBooks;
                }
            ?>
          </tbody>
        </table>
      </div>  
    </div>

  <div class="card">

    <div class="step-header">
        <div class="step-num">3</div>
        <span class="step-title">Enter Loan Details</span>
    </div>

    <form method="POST" name="RetrieveDetails">

      <div class="form-row col2">

        <div class="form-group">
          <label>Book ID:</label>
          <input type="text" name="BookID">
        </div>

        <div class="form-group">
          <label>Member ID</label>
          <input type="text" name="MemberID">
        </div>

      </div>

      <div style="margin-top: 1rem; display:flex; justify-content:flex-end;">
        <input type="submit" name="RetrieveDetails" value="Retrieve Details" class="btn btn-primary">
      </div>
    </form>
  </div>

  <div class="card">

  <div class="step-header">
        <div class="step-num">4</div>
        <span class="step-title">Confirm Loan</span>
    </div>


    <form method="POST" name="LoanBook">
        
        
        <input type="text" name="MemberID" value=
        "<?php if ($RetrievedMember != null){echo $RetrievedMember->GetMemberID();}?>" hidden>

        <input type="text" name="BookID" value= 
        "<?php if ($RetrievedBook != null){echo $RetrievedBook->GetBookID();}?>" hidden>

        <div class="form-row col2">

          <div class="form-group">
            <label>Book Title</label>
            <input type="text" name="BookTitle" value =
            "<?php if ($RetrievedBook != null){echo $RetrievedBook->GetBookTitle();}?>" readonly >
          </div>

          <div class="form-group">
            <label>Author</label>
            <input type="text" name="Author" value = 
            "<?php if ($RetrievedBook != null){echo $RetrievedBook->GetAuthor();}?>" readonly>
          </div>
        </div>

        <div class="form-row col2">

          <div class="form-group">
            <label>Member Name</label>
            <input type="text" name="MemberName" value = 
            "<?php if ($RetrievedMember != null){echo $RetrievedMember->GetFname() ." " .$RetrievedMember->GetSname();}?>" readonly>
          </div>

          <div class="form-group">
            <label>Member Email</label>
            <input type="text" name="MemberEmail" value = 
            "<?php if ($RetrievedMember != null){echo $RetrievedMember->GetEmail();}?>" readonly>
          </div>
        </div>

        <div class="form-row col2">

          <div class="form-group">
            <label>Loan Date</label>
            <!--https://www.sitepoint.com/php-get-current-date/-->
            <input type="date" name="StartDate" value = "<?php echo date('Y-m-d');?>" readonly>
          </div>

          <div class="form-group">
            <label>Due Date</label>
            <input type="date" name="DueDate">
          </div>
        </div>

        
          <div><hr></div>
          <div style="margin-top: 1rem; display:flex; justify-content:flex-end;">
            <input type="submit" name="LoanBook" onclick="return confirmLoan()" value="Confirm loan" class="btn btn-primary">
          </div>
        
    </form>
  </div>
  </div>
</main>
<script src="JSMain.js"></script>

  </body>
</html>