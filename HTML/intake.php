<?php
    session_start();
    $username = $_SESSION['username'];
    $name = $_SESSION['name'];
    if(isset($_POST['update'])){

         // Database Connection
        $dbconnect = mysql_connect("localhost", "root", "carbfax411");
        if(!$dbconnect){
            die('Cannot connect: ' . mysql_error());
        }

        $db_selected = mysql_select_db("411_project_db", $dbconnect);

        if(!$db_selected){
            die('Cant use database: ' . mysql_error());
        }

        // Add query to add food item HERE
        if(isset($_POST['addItemID'])){
          $newItemID = $_POST['addItemID'];
          $quantity = $_POST['quantity'];

          $query = "INSERT INTO ate(username, foodID, quantity) VALUES('$username', '$newItemID', '$quantity')";

          $result = mysql_query($query, $dbconnect);

          if(!$result){
            die("Invalid Query: " . mysql_error());
          }
        }
        elseif(isset($_POST['productUPC'])){
          $upc = $_POST['productUPC'];
          $quantity = $_POST['quantity'];

          $query1 = "SELECT foodID FROM products WHERE upc = '$upc'";
          
          $result = mysql_query($query1, $dbconnect);

          if(!$result){
            die("Invalid Query: " . mysql_error());
          }
          $row = mysql_fetch_assoc($result);
          $newItemID = $row['foodID'];

          $query2 = "INSERT INTO ate(username, foodID, quantity) VALUES ('$username', '$newItemID', '$quantity')";

          $result = mysql_query($query2, $dbconnect);

          if(!$result){
            die("Invalid Query: " . mysql_error());
          }

        }


        // Close Database Connection
        mysql_free_result($result);
        mysql_close($dbconnect);
    }

    if(isset($_POST['remove'])){
      // Database Connection
      $dbconnect = mysql_connect("localhost", "root", "carbfax411");
      if(!$dbconnect){
          die('Cannot connect: ' . mysql_error());
      }

      $db_selected = mysql_select_db("411_project_db", $dbconnect);

      if(!$db_selected){
          die('Cant use database: ' . mysql_error());
      }

      // Remove Item
      $foodID = $_POST['removeIDVal'];
      $date = $_POST['removeDateVal'];
      $quan = $_POST['removeQuanVal'];

      $query = "DELETE FROM ate WHERE username = '$username' and foodID = '$foodID' and date LIKE \"$date%\" ";

      $result = mysql_query($query, $dbconnect);

      if(!$result){
        die("Invalid Query: " . mysql_error());
      }

      // Close Database Connection
      mysql_free_result($result);
      mysql_close($dbconnect);
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="blog.css">
    <!-- weekly_log css -->  
    <!-- Latest compiled and minified CSS -->
    <!--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    -->
    <title>Nutrient Intake</title>
    <style>
       .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      #weekly_log_container, #display_item_container {
        height: 100px; 
        width: 350px; 
        overflow: auto;
        background-color: white;
        margin-top: 15px;
        margin-bottom: 30px;
        border: solid;
        border-radius: 5px;
      }

    </style>
  </head>
    <body>
            <div class="container">
                <header class="blog-header py-3">
                    <div class="row flex-nowrap justify-content-between align-items-center">
                        <div class="col-4 pt-1">
                          <a href="profile.php" class="text-primary">Hello, <?php echo $name;?>!</a>
                        </div>
                        <div class="col-md-4 text-center">
                          <a class="blog-header-logo text-dark" href="index.html">Show Me the Carb Fax</a>
                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-center">
                          <a class="text-primary" href="logout.php">Log Out</a>
                        </div>
                    </div>
                </header>

                <div class="nav-scroller py-1 mb-2">
                    <nav class="nav d-flex justify-content-between">
                        <a class="p-2 text-muted" href="intake.php">Nutrient Intake</a>
                        <a class="p-2 text-muted" href="targets.php">Nutrient Targets</a>
                        <a class="p-2 text-muted" href="recipes.php">Recipes</a>
                        <a class="p-2 text-muted" href="createrecipe.php">Create a Recipe</a>
                    </nav>
                </div>

                <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
                    <div class="col-md-6 px-0">
                        <h1 class="display-4 font-italic">Your Nutrient Intake</h1>
                    </div>
                </div>

                <main role="main" class="container">
                    <div class="row mb-2">
                      <div class="col-md-5">
                        <div class="jumbotron">
                            <h4 class="display-4">This Week's Totals</h4>
                            <div class="list-group">
                              <a href="#" class="list-group-item list-group-item-action">Calories: 50000 </a>
                              <a href="#" class="list-group-item list-group-item-action">Protein: 4000 g </a>
                              <a href="#" class="list-group-item list-group-item-action">Carbohydrate: 5000 g </a>
                              <a href="#" class="list-group-item list-group-item-action">Fat: 500 g </a>
                              <a href="#" class="list-group-item list-group-item-action">Sugars:  35 g</a>
                              <a href="#" class="list-group-item list-group-item-action">Dietary Fiber: 29 g</a>
                              <a href="#" class="list-group-item list-group-item-action">Cholesterol: 300 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Sodium: 2300 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Calcium: 1000 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Vitamin A: 800 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Vitamin B6: 1.3 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Vitamin B12: 2.4 &#181g </a>
                              <a href="#" class="list-group-item list-group-item-action">Vitamin C: 85 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Vitamin D: 600 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Vitamin E: 15 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Niacin: 15 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Thiamin: 1.2 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Iron: 13 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Magnesium: 360 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Phosphorus: 700 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Potassium: 4700 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Riboflavin: 1.2 mg</a>
                              <a href="#" class="list-group-item list-group-item-action">Zinc: 9.5 mg</a>
                              <?php
                                 // Database Connection
                                $dbconnect = mysql_connect('localhost', 'root', 'carbfax411');
                                if(!$dbconnect){
                                    die('Cannot connect: ' . mysql_error());
                                }
                                $db_selected = mysql_select_db("411_project_db", $dbconnect);
                                if(!$db_selected){
                                    die('Cant use database: ' . mysql_error());
                                }
                                // TODO: ADD QUERY TO GET NUTRIENT AGGREGATION

                                // TODO: OUTPUT RESULTS 

                                 // Close Database Connection
                                mysql_free_result($result);
                                mysql_close($dbconnect);
                              ?>
                            </div>
                          </div>
                        </div>
                      <div class="col-md-5">
                      <div class="jumbotron">
                      <!--Live search start-->
                      <h3 class="h3 mb-3 font-weight-normal">Search Item IDs</h3>
                      <input type="radio" name="search_option" id="_product" value="product" checked="checked"/> Product<br>	
                      <input type="radio" name="search_option" id="_recipe" value="recipe" /> Recipe<br>
                      <input type="text" id="food_search" placeholder="Enter Item Name">
                      <div id="display_item_container">
                        <div id="food_suggestion"></div>
                      </div>		
                      <!--Live search end-->
                        <form class="form-group" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <h3 class="h3 mb-3 font-weight-normal">Add An Item to Your Food Log</h3>
                            <label for="inputFoodItem">Add Item by ID</label>
                            <input type="number" id="inputFoodItem" class="form-control" name="addItemID" placeholder="Enter Item ID, Use Search Above">
                            <label for="inputProductUPC">Add Item by UPC</label>
                            <input type="number" id="inputProductUPC" class="form-control" name="productUPC" placeholder="Product UPC">
                            <label for="inputItemQuantity">Enter Quantity</label>
                            <input type="number" id="inputItemQuantity" class="form-control form-control-sm" name="quantity" placeholder="Quantity" required>
                            <button name="update" class="btn btn-sm btn-primary btn-block" type="submit">Add Item</button>
                        </form>
                      </div>
                      </div>

                      <aside class="col-md-2 blog-sidebar">
                        <div class="p-4">
                          <h4 class="font-italic">Elsewhere</h4>
                          <ol class="list-unstyled">
                            <li><a href="https://wiki.illinois.edu//wiki/display/cs411changsp19">CS411 Homepage</a></li>
                            <li><a href="https://wiki.illinois.edu/wiki/display/CS411ChangSP19/Project+Show+Me+the+Carb+Fax">Team Project Page</a></li>
                            <li><a href="#">Github</a></li>
                          </ol>
                        </div>
                      </aside>

                    </div><!-- /.row -->
                    <div class="row mb-2">
                      <div class="col-md-6">
                        <div class="jumbotron">
                          <h3 class="h3 mb-3 font-weight-normal">Your Weekly Log</h3>
                          



                          
                          <!-- food item table start -->                    
                          <table class="table table-hover table-dark">
                            <thead>
                              <tr>
                                <th scope="col">Item Name</th>
                                <th scope="col">Item ID</th>
                                <th scope="col">Date</th>
                                <th scope="col">Quantity</th>
                              </tr>
                            </thead>
                            <tbody id="weekly_log_content">
                            <?php include 'weekly_log.php';?>
                            </tbody>
                          </table>
                          <!-- food item table end -->
                          
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="jumbotron">
                          <form class="form-group" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <h3 class="h3 mb-3 font-weight-normal">Remove An Item</h3>
                            <label for="removeItemId">Which Item Would You Like to Remove?</label>
                            <input type="number" id="removeItemID" class="form-control form-control-sm" name="removeIDVal" placeholder="Item ID" required>
                            <label for="removeDate">From Which Date?</label>
                            <input type="date" id="removeDate" class="form-control form-control-sm" name="removeDateVal" placeholder="Date" required>
                            <label for="removeQuantity">Quantity to Remove?</label>
                            <input type="number" id="removeQuantity" class="form-control form-control-sm" name="removeQuanVal" placeholder="Quantity" required>
                            <button name="remove" class="btn btn-sm btn-primary btn-block" type="submit">Remove Item
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>


                  </main><!-- /.container -->
                  <footer class="blog-footer">
                    <p>Copyright &copy; 2019 Team RSMS CS411 Spring 2019 UIUC</p>
                    <p>Food Data Courtesy of the <a href="https://ndb.nal.usda.gov/ndb">USDA Food Composition Databases</a></p>
                    <p>Recipe Data Courtesy of <a href="https://www.kaggle.com/hugodarwood/epirecipes">HugoDarwood's Epicurious Recipe Collection</a></p>
                    <p>
                      <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Back to top</a>
                    </p>
                  </footer>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!-- live food search -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="food_search.js"></script>
        <!-- live food search -->
        <script src="update_weekly_log.js"></script>
    </body>
</html>
