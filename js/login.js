/**
 *  by leo 2011/2/13 11:34
 */
$(function(){
	$("#operator_user").focus();
	$("#login_error").hide();
	$(".submit input").click(function(){
		$("#login_error").slideUp("slow");
		var user =$("#operator_user"),
			pass =$("#operator_pass");
		user.removeClass("inputerror");pass.removeClass("inputerror");
		if(user.val()==""){
			user.addClass("inputerror");
			return false;
		}
		if(pass.val()==""){
			pass.addClass("inputerror");
			return false;
		}
		var d = $("#loginform").serialize();
		$.ajax({
			   type: "POST",
			   url: "dologin.php",
			   data: d,
			   cache: false,
			   dataType: "script",
			   beforeSend: function(){
				   $(".loading").fadeIn("slow"); 
			   },
			   success: function(data, textStatus){				   
			   },
			   error: function(XMLHttpRequest, textStatus, errorThrown){
				   $("#login_error").html("<strong>请求出现错误</strong>:"+textStatus+"<br />").slideDown("slow");
			   },
			   complete: function(XMLHttpRequest, textStatus){
				   $(".loading").fadeOut("slow");;
			   }
			});		
		return false;
	});
})