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
          


    <!-- <form action="#" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-15 u-form-vertical u-inner-form" style="padding: 15px;" source="custom" name="form" redirect="true"> -->
    <?php 
    global $errors;
    foreach ( $errors as $error ) {  ?>
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <h4 class="alert-heading">Warning!</h4>
            <p class="mb-0"><?php echo $error; ?>.</p>
        </div>
        
        <?php } ?>
            
      
<div class="row mt-5">
    <div class="col-md-6 m-auto">
        
        <div class="card text-white bg-dark card-body">
        <h1 class="card-header text-center mb-3"><i class="fas fa-sign-in-alt"></i>  Login</h1>

    <form action="./Login.php" method="POST" redirect="true">

    <div class="form-group">

        
        <label class="col-form-label mt-4" for="name"> Enter your name</label>
        <input class="form-control" type="text" name="name" >

        <label class="col-form-label mt-4" for="name"> Enter your password</label>
        <input class="form-control" type="text" name="password" >
        
        <input class="btn btn-primary mt-4"  type="submit" value="submit" >
        <input type="hidden" value="" name="recaptchaResponse">
    </div>

    </form>

        </div>
        </div>

        <script src="../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
