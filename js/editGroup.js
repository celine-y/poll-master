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

    $(function () {
    	getGroupInfo();
        getGroupName();

        $('.list-group.checked-list-box').on('click', '.list-group-item',function () {   
            if ($(this).data('uid')!=uid){
                $(this).toggleClass("list-group-item-info");
            }
        });

    });

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
            $('input#gname').val(data);
        }
    });
    }