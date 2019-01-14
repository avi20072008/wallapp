<?php include 'header.php' ?>
      <form id="frmLogin" name="frmLogin" action="#" method="" class="form-signin" >
          <div>
            <div class="errText"></div>
          </div>
          <h2 class="form-signin-heading">Sign in</h2>
          <label for="inputEmail" class="sr-only">Email</label>
          <input type="email" id="inputEmail" name="email" class="chk-valid form-control" placeholder="Email" value="a@a.com" autofocus required/>
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="inputPassword" value="pass" name="password" class="chk-valid form-control login" placeholder="Password" required>
          <input type="submit" id="submit" class="btn btn-lg btn-primary btn-block" value="Login">
          <div class="text-right">
            <a href="index.php" target="_self" id="guestlink"> No account? No issues, check our timeline </a>
          </div>
      </form>

    </div> <!-- /container -->
</body>
  <script type="text/javascript" src="static/js/login.js"></script>
</html>