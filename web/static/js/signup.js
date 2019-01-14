      $(function(){

          isValid = true; 

          function performSignupRequest(){

                username = $.trim($("#inputUsername").val());
                email = $.trim($("#inputEmail").val()); 
                pass = $.trim($("#inputPassword").val());
                json_obj = {"username": username, "email": email,"password": pass};

                $.ajax({
                    url:'http://localhost:8888/app/api/users/signup',
                    type:'post',
                    data: JSON.stringify(json_obj),
                    success: function(data){
                        handleMessages(data)
                    },
                    error: function(xhr, status, error){
                        //alert(xhr.responseText);
                      $(".errText").text('Something went wrong..'); 
                    }
                });
          } // end of performSignupRequest

          function handleMessages(data){
            switch(data["status"])
            {
              case "MSG104": redirect_to_login();
                             break;
              case "MSG105":
              case "MSG202":$(".errText").text(data["message"]);
                            break;
              default: $(".errText").text('Something went wrong..');
            }
          }

          function redirect_to_login(){
              url = window.location.href;
              var to = url.lastIndexOf('/'); // returns -1 if not found
              //to = (to == -1) ? url.length : to + 1;
              url = url.substring(0, to);
              window.location.href = url + '/login.php';
          }

          // Perform validations on signup form.
          function validateForm()
          {
            isValid = true;
            $("#frmLogin").find(".chk-valid").each(function(){
                var f_val = $.trim($(this).val());
                if(!f_val){
                    $(".errText").text("Please enter valid values");
                    isValid = false;
                    return false;
                  }
                });
            }

          // Form submit
          $("#submit").click(function(){

              // check if all fields are entered.
              validateForm();

              if(isValid)
              {
                  var pass = $.trim($("#inputPassword").val());
                  var conf_pass = $.trim($("#inputConfirmPassword").val());
                  var email = $.trim($("#inputEmail").val()); 

                  if(!isEmailValid(email))
                  {
                      $(".errText").text('Enter valid email.');
                      isValid = false;
                      return;
                  }

                  // verify if both passwords match.
                  if(pass != conf_pass){
                       $(".errText").text('Passwords do not match');
                       isValid = false;
                       return;
                  }
              }              

              // If form is valid then send signup request.
              if(isValid)
              {
                  performSignupRequest(); 
              }
          });

          // Function to validate email
          function isEmailValid(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

      });