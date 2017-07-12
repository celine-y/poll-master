var urlParams;
(window.onpopstate = function () {
    var match,
        pl     = /\+/g,  // Regex for replacing addition symbol with a space
        search = /([^&=]+)=?([^&]*)/g,
        decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
        query  = window.location.search.substring(1);

    urlParams = {};
    while (match = search.exec(query))
       urlParams[decode(match[1])] = decode(match[2]);
})();

$(document).ready(function(){

	//get polls and groups
	groupList();
	pollList();
	
	$('a.navbar-brand').text('Welcome, '+urlParams.user);
	$('#logout').on('click', function(){
		$(location).attr('href', './login.html');
	});

	//table filter
	$('.btn-filter').on('click', function () {
		var $target = $(this).data('target');

		if ($target != 'all') {
			$('.table tr.tr-filter').css('display', 'none');
			$('.table tr.tr-filter[data-status="' + $target + '"]').fadeIn('slow');
		} else {
			$('.table tr.tr-filter').css('display', 'none').fadeIn('slow');
		}
	});

	//update favourite
	$('.table-filter tbody').on('click', '.star', function () {
		var row=$(this);
		if($(this).hasClass('star-checked')){
			var action='delete';
		}else{
			var action='insert';
		}

		var favsid=$(this).closest('tr').data('sid');
		
		$.ajax({
			url: 'php/updateFave.php',
			type: 'POST',
			dataType: 'json',
			data: {
				userid: urlParams.uid,
				sid: favsid,
				action: action
			},
			success: function(r){
				if (r=='success'){
					row.toggleClass('star-checked');					
				}else{
					console.log("error in updateFave.php");
				}
			}
		});
	});

	//add poll
	$('button[data-target="addPoll"]').on('click', function(){
		//pass uid
		var userid=urlParams.uid;
		$.ajax({
			url: 'poll/transfer-variables.php',
			type: 'POST',
			dataType: 'json',
			data: {
				userId: userid
			},
			success: function(r){
				window.location='poll/add-poll.php';
			}
		});
	});

	//add group
	$('button[data-target="addGroup"]').on('click', function(){
		//pass uid
		$(location).attr('href', './group.html?uid='+urlParams.uid+'&user='+urlParams.user);
	});

	//click on a survey
	$('.table-filter tbody#pollQuest').on('click', 'tr td:nth-child(2)', function() {
		//pass sid, uid
		var userid=urlParams.uid;
		var sid=$(this).closest('tr').data('sid');
		$.ajax({
			url: 'poll/transfer-variables.php',
			type: 'POST',
			dataType: 'json',
			data: {
				userId: userid,
				sid: sid
			},
			success: function(r){
				window.location='poll/poll-display.php';
			}
		});
	});

	//click on a group
	$('.table-filter tbody#group').on('click','tr[data-admin="T"]', function(){
		//pass gid, uid
		var gid=$(this).data('gid');
		$(location).attr('href', './editGroup.html?gid='+gid+'&uid='+urlParams.uid+'&user='+urlParams.user);
	});


});

//display pollList on home page
function pollList(){
	//ajax call get all poll questions from specific user
	$.ajax({
		url: 'php/getPolls.php',
		type: 'GET',
		dataType: 'json',
		data: {
			userid: urlParams.uid
		},
		success: function(data){
			var html='';
			$.each(data, function(index,val){
				html+='<tr class="tr-filter" data-status="'+val.status+'" data-sid='+val.sid+'>';
				html+='<td><a href="javascript:;" class="star '+ ((val.fave=='T')?'star-checked':'')+'"><i class="glyphicon glyphicon-star"></i></a></td>';
				html+='<td><div class="media">';
				html+='<a href="#" class="pull-left"><img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo"></a>';
				html+='<div class="media-body">';
				html+='<span class="media-meta pull-right"></span><h4 class="title">'+val.sq;
				html+='<span class="pull-right '+val.status+'">'+val.status+'</span></h4>';
				html+='<p class="summary">'+val.tags+'</p>';
				html+='</div></div></td></tr>';				
			});
			$('tbody#pollQuest').append(html);
		},
		error: function(){
			console.log('error in getPolls.php');
		}
	});
};

//display groupList on home page
function groupList(){
	$.ajax({
		url: 'php/getGroups.php',
		type: 'GET',
		dataType: 'json',
		data: {
			userid: urlParams.uid
		},
		success: function(data){
			var html='';
			groupmem=data.mem;
			$.each(data, function(index,val){
				html+='<tr data-gid='+val.gid+' data-admin='+val.admin+'>';
				html+='<td><div class="media"><div class="media-body">';
				html+='<span class="media-meta pull-right">'+((val.admin=='T')?'(Admin)':'')+'</span>';
				html+='<h4 class="title">'+val.gname+'</h4>';
				html+='<p class="media-meta">'+val.gmem+'</p>';
				html+='</div></div></td></tr>';
			});
			$('tbody#group').append(html);
		},
		error: function(){
			console.log('error in getGroups.php');
		}
	});
};
