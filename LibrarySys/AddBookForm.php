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
    <!-- <meta http-equiv='X-UA-Compatible' content='IE=edge'> -->
    <link href='/favicon.png' rel='shortcut icon' type='image/png'>
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
            <span class="step-title">Add New Book</span>
        </div>

    
    <form method="POST" id="AddBook" name="AddBook" action="">
        
            <div class="form-row col2">

                <div class="form-group">
                    <label>Book Title</label>
                    <input type="text" name="BookTitle">
                </div>


                <div class="form-group">
                    <label>Author</label>
                    <input type="text" name="Author">
                </div>
            </div>

            <div class="form-row col2">

                <div class="form-group">
                    <label>Genre</label>
                    <select name="genreOption" id="genreOption">
                        <?php
                            populateGenres();
                        ?>
                    </select>
                </div>

            </div>


            <div class="form-row">
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="BookDesc" rows="5" cols="35"></textarea>
                </div>
            </div>

            <div style="margin-top: 1rem; display:flex; justify-content:flex-end;">
                <input type="submit" name="AddBook" onclick="return confirmAddBook()" value="Add Book" class="btn btn-primary">
            </div>





        
    </form>
  </div>
</div>
</main>
    
    <script src="JSMain.js"></script>
  
  

  </body>
</html>