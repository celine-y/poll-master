$(document).ready(function(){

	pollList();
	groupList();

	//table filter
	$('.btn-filter').on('click', function () {
		var $target = $(this).data('target');
		if ($target != 'all') {
			$('.table tr').css('display', 'none');
			$('.table tr[data-status="' + $target + '"]').fadeIn('slow');
		} else {
			$('.table tr').css('display', 'none').fadeIn('slow');
		}
	});

	//favourite
	//ADD AJAX TO UPDATE
	$('.star').on('click', function () {
      $(this).toggleClass('star-checked');
    });

});

//global var
var username='';

function pollList(){
	//ajax call get all poll questions from specific user
	$.ajax({
		url: 'php/tk-home.php',
		type: 'GET',
		dataType: 'json',
		data: {
			//userid: global.user.id;
			userid: '1'
		},
		success: function(data){
			var html='';
			$.each(data, function(index,val){
				html+='<tr data-status="'+val.status+'" data-sid='+val.sid+'>';
				html+='<td><a href="javascript:;" class="star '+ ((val.fave=='T')?'star-checked':'')+'"><i class="glyphicon glyphicon-star"></i></a></td>';
				html+='<td><div class="media">';
				html+='<a href="#" class="pull-left"><img src="https://s3.amazonaws.com/uifaces/faces/twitter/fffabs/128.jpg" class="media-photo"></a>';
				html+='<div class="media-body">';
				html+='<span class="media-meta pull-right">Febrero 13, 2016</span><h4 class="title">'+val.sq;
				html+='<span class="pull-right '+val.status+'">'+val.status+'</span></h4>';
				html+='<p class="summary">Group Memebers</p>';
				html+='</div></div></td></tr>';				
			});
			//append
			$('tbody#pollQuest').append(html);
		},
		error: function(){
			console.log('error in tk-home.php');
		}
	});
};

function groupList(){

};
