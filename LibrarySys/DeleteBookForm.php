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


                <form method="POST" name = "SearchBook" id="SearchBook" action="">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Book ID</label>
                            <input type="text" name="BookSearchInput">
                        </div>
                    </div>

                   

                    <div style="margin-top: 1rem; display:flex; justify-content:flex-end;">
                        <input type="submit" name="SearchBook"value="Serach" class="btn btn-primary">
                    </div>
                </form>
            </div>



            <div class="card">

                <div class="step-header">
                        <div class="step-num">2</div>
                        <span class="step-title">Delete Book</span>
                </div>

                
                <form method="POST" name = "DeleteBook" id="DeleteBook" action="">

                    <div class="form-row">
                        <div class="form-group">
                            <label>Book ID:</label>
                            <input type="text" name="BookidDisplay" value =
                            "<?php if($RetrievedBook != null){echo $RetrievedBook->GetBookID();} ?>" readonly>

                            <input type="hidden" name="BookID" value =
                            "<?php if($RetrievedBook != null){echo $RetrievedBook->GetBookID();} ?>">

                        </div>
                    </div>

                    <div class="form-row col2">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="BookTitle" value=
                            "<?php if($RetrievedBook != null){echo $RetrievedBook->GetBookTitle(); }?>" readonly>

                        </div>  
                        
                        
                        <div class="form-group">
                            <label>Author</label>
                            <input type="text" name="Author" value=
                            "<?php if($RetrievedBook != null){echo $RetrievedBook->GetAuthor(); } ?>" readonly>
                        </div>
                    </div>
  

  

                    <div class="form-row col2">
                        <div class="form-group">
                            <label>GenreCode</label>
                            <input type="text" name="genreOption" value = 
                            "<?php if($RetrievedBook != null){echo $RetrievedBook->GetGenreCode(); }?>" readonly>
                        </div>

                        <div class="form-group">
                            
                            <label>Description</label>
                            <textarea name="BookDesc" rows="5" cols="35" readonly>
                            <?php if($RetrievedBook != null){echo $RetrievedBook->GetDescription(); } ?>
                            </textarea>
                        </div>
                    </div>


                    <div class="form-row col2">
                        <div class="form-group">
                            <Label>Book Status</label>
                            <input type="text" name="Status" value= 
                            "<?php if($RetrievedBook != null){echo $RetrievedBook->GetStatus();} ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Is Deleted Status</label>
                            <input type="text" name="IsDeleted" value= 
                            "<?php if($RetrievedBook != null){echo $RetrievedBook->GetIsDeleted();} ?>" readonly><br>
                        </div>
                    </div>

                    <div style="margin-top: 1rem; display:flex; justify-content:flex-end;">
                        <input type="submit" name="DeleteBook" onclick="return confirmBookDelete()" value="Delete Book" class="btn btn-primary"></input>
                    </div>


                </form>
            </div>

        


        </div>
    </main>



    <script src="JSMain.js"></script>

  </body>
</html>