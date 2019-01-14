	
	$(function(){
		
		$("#submit").click(function(){
			var txtcomment = $.trim($("#txtComment").val());

			if($.trim(txtcomment).length == 0){
				$(".errText").text('Please enter some comment.');
				return false;
			}
			data = {"comment":txtcomment};

			$.ajax({
				type:'POST',
				url:'http://localhost:8888/app/api/wall/save',
				data: JSON.stringify(data),
				success: function(data){
					if(data["status"]=='MSG107')
                    {
                    	$(".errText").text(data['message']);
                    	$("#txtComment").val('').focus();
                    	viewTimeline();
                    }
				},
				error: function(xhr, request, err){
					$(".errText").text('Some error occured.');
					//alert(xhr.responseText);	
				}
			});			
			return false;
		});

		$(".logout").click(function(){
			$.ajax({
				type:'GET',
				url:'http://localhost:8888/app/api/users/logout',
				success: function(){
				},
				error: function(xhr, err){
					$(".errText").text('Some error occured.');
				}
			});
		});

		viewTimeline();

		function viewTimeline(){
			$.ajax({
				type:'GET',
				url:'http://localhost:8888/app/api/wall/timeline',
				success: function(data){
					$(".wall-comments").empty();
					$.each(data, function(index, value){
						var dvComments = "<div><div class='cdate'>";
							dvComments += value.username + " posted on <i>" ;
							dvComments += value.created_at + " </i></div>";
							dvComments += " <div class='comment'>" + value.comment + " </div></div><hr/>";
							
							$(".wall-comments").append(dvComments);
					});
				},
				error: function(xhr, request, err){
					$(".errText").text('Some error occured.');	
				}
			});
		}
	});