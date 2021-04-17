$(document).ready(function(){


	//On clicking signup, hide login and show registration
	$("#signup").click(function(){
		$("#first").slideUp("slow",function(){
			$("#second").slideDown("slow");
		});
	});


	//On clicking signup, hide registration and show login form
	$("#signin").click(function(){
		$("#second").slideUp("slow",function(){
			$("#first").slideDown("slow");
		});
	});



});