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
    var gid=urlParams.gid;
    var gname='';
    var gnameOld='';
    var gmem=[];
    var members='';

    $(function () {
    	getGroupInfo();
        getGroupName();

        $('a.navbar-brand').text('Welcome, '+urlParams.user);
        $('#logout').on('click', function(){
            $(location).attr('href', './login.html');
        });

        $('#home, a.navbar-brand').on('click', function(){
            $(location).attr('href', './home.html?user='+urlParams.user+'&uid='+urlParams.uid);
        });

            $('.list-group.checked-list-box').on('click', '.list-group-item',function () {   
                if ($(this).data('uid')!=uid){
                    $(this).toggleClass("list-group-item-info");
                }
            });

            $('#save-group').on('click', function(){
                gname=$('input#gname').val();
                gmem=[];

                $('.list-group-item-info').each(function(){
                    gmem.push($(this).data('uid'));
                });

                members=gmem.join();

                if(gnameOld!=gname){
                    saveGroupName();
                }else{
                    saveGroupInfo();
                }

                if (gname=='' || gmem==''){
                    $('#warning').text('Please enter all information');
                    $('#warning').effect("shake", { times:2 }, "slow");
                }else{
                //saveGroupInfo();
            }


        });

        });

        function saveGroupName(){
            $.ajax({
                url: 'php/saveGroupName.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    gname: gname,
                    gid: gid
                },
                success: function(r){
                 if (r=='error'){
                   $('#warning').text(gname+' already exist');
                   $('#warning').effect("shake", { times:2 }, "slow");               
               }else if (r=='success'){
                gnameOld=gname;
                saveGroupInfo();
            }
        }
    })
        }

        function saveGroupInfo(){
            $.ajax({
                url: 'php/saveGroupInfo.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    gname: gname,
                    gmem: members,
                    admin: uid,
                    gid: gid
                },
                success: function(r){
                    if (r=='success'){
                        $('#warning').text('Saved!');
                        $('#warning').effect("shake", { times:2 }, "slow"); 
                    }
                }
            })
        }

        function getGroupInfo(){
           $.ajax({
              url: 'php/getGroupInfo.php',
              type: 'GET',
              dataType: 'json',
              data: {
                gid: urlParams.gid,
                uid: urlParams.uid
            },
            success: function(data){
             var html='';
            //gname, members, selected mem (T/F)
            $.each(data, function(index,val){
            	html+='<li class="list-group-item'+((val.mem=='T')?' list-group-item-info':'')+'"'+' data-uid='+val.uid+'>'+val.uname+'</li>'     
            });
            $('#check-list-box').append(html);
        }
    });
       }

       function getGroupName(){
        $.ajax({
            url: 'php/getGroupName.php',
            type: 'GET',
            dataType: 'json',
            data: {
                gid: urlParams.gid
            },
            success: function(data){
                gnameOld=data;
                $('input#gname').val(data);
            }
        });
    }