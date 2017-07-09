$(function() {

	$('.form').find('input, textarea').on('keyup blur focus', function (e) {
		var $this = $(this),
		label = $this.prev('label');
		if (e.type === 'keyup') {
			if ($this.val() === '') {
				label.removeClass('active highlight');
			} else {
				label.addClass('active highlight');
			}
		} else if (e.type === 'blur') {
			if( $this.val() === '' ) {
				label.removeClass('active highlight'); 
			} else {
				label.removeClass('highlight');   
			}   
		} else if (e.type === 'focus') {
			if( $this.val() === '' ) {
				label.removeClass('highlight'); 
			} 
			else if( $this.val() !== '' ) {
				label.addClass('highlight');
			}
		}
	});

	$('.tab a').on('click', function (e) {
		e.preventDefault();
		$(this).parent().addClass('active');
		$(this).parent().siblings().removeClass('active');
		target = $(this).attr('href');
		$('.tab-content > div').not(target).hide();
		$(target).fadeIn(600);
	});

	//SIGN UP
	$('#sign-up').on('click', function(){
		var username=$('input#user-new').val();
		var password=$('input#pass-new').val();
		

		if (username=='' || password==''){
			$('#foot-lnk2').text('Please enter both username and password');
			$('#foot-lnk2').effect("shake", { times:2 }, "slow");
		}else{
			$.ajax({
				url: 'php/signup.php',
				type: 'POST',
				dataType: 'json',
				data: {
					uname: username,
					upass: password
				},
				success: function(r){
				//check if any user exist in the table first

				//redirect
				if (r=='sucess'){
					$(location).attr('href', './home.html')
				}
			}
		})		
		}
	});

	//LOG IN
	$('#log-in').on('click', function(){
		var username=$('input#user').val();
		var password=$('input#pass').val();

		if (username=='' || password==''){
			$('#foot-lnk').text('Please enter both username and password');
			$('#foot-lnk').effect("shake", { times:2 }, "slow");
		}else{
			$.ajax({
				url: 'php/login.php',
				type: 'GET',
				dataType: 'json',
				data: {
					uname: username,
					upass: password
				},
				success: function(r){
				//redirect
				if (r=='sucess'){
				
					$(location).attr('href', './home.html?user='+username);
				}else if (r=='error'){
					$('#foot-lnk').text('Username and password do not match');
					$('#foot-lnk').effect("shake", { times:2 }, "slow");
				}
			}
		})		
		}
	});

});
