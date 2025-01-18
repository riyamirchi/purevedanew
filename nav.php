<nav>
   <div class="navbar">
      <div class="logo">
         <img src="logo.jpg" alt="img" height="130px" width="120px">
      </div>


      <!-- items -->
      <section class="items">
         <a href="" class="border">Home</a>
         <a href="" class="border">Hair</a>
         <a href="" class="border">Skincare</a>
         <a href="" class="border">Body</a>
         <a href="" class="border">Candles</a>


         <ul class="navbar-nav ">
            <?php
            // Start session
            session_start();

            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
               // Check if the user is an admin
               if ($_SESSION['role'] == 'admin') {
                  // If user is admin, show Admin Panel link
                  echo '<li  class="nav-item">
                            <a class="nav-link" href="admin_panel.php">Admin Panel</a>
                          </li>';
               } else {
                  // If user is a regular user, show Index page link
                  echo '<li  class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                          </li>';
               }

               // Show Cart link for all logged-in users
               echo '<li  class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                      </li>';

               // Show Logout link for logged-in users
               echo '<li  class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                     </li> ';
            } else {
               // If not logged in, show Login and Sign Up links
               echo '<li  class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                      </li>
                     <li  class="nav-item">
                        <a class="nav-link" href="register.php">Sign Up</a>
                     </li>';
            }
            ?>
         </ul>
      </section>
   </div>
</nav>