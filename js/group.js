//get url parameters, uid, uname
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

 var uid=urlParams.uid;
 var gname='';
 var gmem=[];
 var members='';

 $(function () {
    getMemberList();

    // navbar branding
    $('a.navbar-brand').text('Welcome, '+urlParams.user);
    $('#logout').on('click', function(){
        $(location).attr('href', './login.html');
    });

    $('#home, a.navbar-brand').on('click', function(){
        $(location).attr('href', './home.html?user='+urlParams.user+'&uid='+urlParams.uid);
    });

    //add class when user clicked on it
    $('.list-group.checked-list-box').on('click', '.list-group-item',function () {   
        if ($(this).data('uid')!=uid){
            $(this).toggleClass("list-group-item-info");
        }
    });

    //add group
    $('#create-group').on('click', function(){
        gname=$('input#gname').val();
        gmem=[];
        
        $('.list-group-item-info').each(function(){
            gmem.push($(this).data('uid'));
        });

        members=gmem.join();

        //gname, gmem, userid(admin)
        if (gname=='' || gmem==''){
            $('#warning').text('Please enter all information');
            $('#warning').effect("shake", { times:2 }, "slow");
        }else{
            submitGroup();
        }

    });


});

 //add group info to database
 function submitGroup(){
    $.ajax({
        url: 'php/addGroup.php',
        type: 'POST',
        dataType: 'json',
        data: {
            gname: gname,
            gmem: members,
            admin: uid
        },
        success: function(r){
            if (r=='success'){
                $('#warning').text(gname+' created!');
           }else if (r=='error'){
             $('#warning').text(gname+' already exist');
             $('#warning').effect("shake", { times:2 }, "slow");               
         }
     }
 })
}

//display members list
function getMemberList(){
    $.ajax({
        url: 'php/getMembers.php',
        type: 'GET',
        dataType: 'json',
        data: {
        },
        success: function(data){
            var html='';
            //uid, username
            $.each(data, function(index,val){
                html+='<li class="list-group-item'+((val.uid==uid)?' list-group-item-info':'')+'"'+' data-uid='+val.uid+'>'+val.username+'</li>'     
            });
            $('#check-list-box').append(html);
        },
        error: function(){
            console.log('error in getMembers.php');
        }
    });
}