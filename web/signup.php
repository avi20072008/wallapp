<?php include 'header.php' ?>
    
      <form id="frmLogin" name="frmLogin" action="/" method="" class="form-signin">
            <div>
              <div class="errText"></div>
            </div>
            <h2 class="form-signin-heading">Sign up</h2>
            <input type="text" id="inputUsername" class="form-control chk-valid" placeholder="Name" required/>
            <input type="email" id="inputEmail" class="form-control chk-valid" placeholder="Email address" required/>
            <input type="password" id="inputPassword" class="form-control chk-valid" placeholder="Password" required/>
            <input type="password" id="inputConfirmPassword" class="form-control chk-valid" placeholder="Confirm Password" required/>
            <input type="button" id="submit" class="btn btn-lg btn-primary btn-block" value="Sign Up" />
      </form>
    </div> <!-- /container -->
</body>
<style type="text/css">
  
</style>
<script type="text/javascript" src="static/js/signup.js"></script>
</html>