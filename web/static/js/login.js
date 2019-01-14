      $(function(){

          isValid = true; 

          $("#submit").click(function(){
              validateForm();

              if(isValid)
              {
                email = $.trim($("#inputEmail").val());
                pass = $.trim($("#inputPassword").val());
                json_obj = {"email": email, "password":pass};
 
                $.ajax({
                    url:'http://localhost:8888/app/api/users/auth',
                    type:'post',
                    data: JSON.stringify(json_obj),
                    // dataType:'json',
                    // contentType: 'application/json',
                    success: function(data){
                        handleMessages(data);
                    },
                    error: function(xhr, status, error){
                      //var err = eval("(" + xhr.responseText + ")");
                      alert(xhr.responseText);
                      //alert(JSON.parse(xhr.responseText));
                    }
                });

              }else{
                $(".errText").text('Enter valid credentials');
              }

              return false;
          });

          function handleMessages(data){

            switch(data["status"])
            {
              case "MSG102": redirect_to_wall();
                             break;
              case "MSG101":
              case "MSG103":
              case "MSG201":$(".errText").text(data["message"]);
                            break;
              default: $(".errText").text('Something went wrong...');
            }
          }

          function redirect_to_wall(){
              url = window.location.href;
              var to = url.lastIndexOf('/'); // returns -1 if not found
              //to = (to == -1) ? url.length : to + 1;
              url = url.substring(0, to);
              window.location.href = url + '/index.php';
          }

          function validateForm(){

            isValid = true;
            $("#frmLogin").find(".chk-valid").each(function(){
                var f_val = $.trim($(this).val());
                if(!f_val){
                    isValid = false;
                }
            });
          }

      });