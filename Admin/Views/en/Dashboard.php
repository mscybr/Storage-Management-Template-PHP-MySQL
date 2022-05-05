<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://bootswatch.com/5/lux/bootstrap.min.css" rel="stylesheet">
    <title> Log in </title>
</head>
<body>
    
    <?php require_once $_SERVER['DOCUMENT_ROOT']."/assets/html/nav bar.php"; ?>

    <div class="row mt-5">
    <div class="col-md-6 m-auto">
        
    <div class="card text-white bg-primary" style="max-width: 50rem;padding-left:10px;padding-right:10px">
        <h1 class="card-header m-auto">Admin Tools</h1>

        <div class="d-grid gap-2">
            <a class="btn btn-lg btn-success" href="./Manage Users.php" > Manage Users </a>
           
            <a class="btn btn-lg btn-warning" href="./Manage Companies.php" > Manage Companies </a>
  
            <a class="btn btn-lg btn-danger" href="./Manage Items.php" > Manage Items </a>
            <br>
        </div>
</div>
</div>
      

</body>
</html>
