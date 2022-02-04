<?php
  include_once('../Config.php');
  if ( isset($_SESSION['admin']) ) {
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Admin Tools</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a class="nav-link" href="./Manage Users.php">Manage Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./Manage Companies.php">Manage Companies</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="../LogOut.php">Log Out</a>
          </li> -->
        </ul>

        <a class="btn btn-danger d-flex" href="../LogOut.php">Log Out</a>

      </div>
    </div>
  </nav>
  <?php } else if( isset($_SESSION['id']) ){ ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Storage Manager</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a class="nav-link" href="./Dashboard.php">Dashboard</a>
          </li>
  

        </ul>
          <a class="btn btn-danger d-flex" href="../LogOut.php">Log Out</a>
      </div>
    </div>
  </nav>
    
  <?php } ?>