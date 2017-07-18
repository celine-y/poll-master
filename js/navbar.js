$(document).ready(function(){
    $('a.navbar-brand').text('Welcome, '+username);

    //LOGOUT
    $('#logout').on('click', function(){
		$(location).attr('href', '../login.html');
	});

    //HOME
    $('#home, a.navbar-brand').on('click', function(){
        $(location).attr('href', '../home.html?user='+username+'&uid='+userid);
    });

    //BACK Button
    $('.navbar #back').on('click', function(){
        $(location).attr('href', '../home.html?user='+username+'&uid='+userid);
    });
});