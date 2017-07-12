$(document).ready(function() {
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('#options-area .controls:first'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);
        
        newEntry.find('input').val('');
        newEntry.find('input').focus();
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function(e)
    {
        $(this).parents('.entry:first').remove();

        e.preventDefault();
        return false;
    });

    $('#survey-color').on('click', 'button.btn', function(e){
        var parent = $(this).parent();
        $('.active', parent).removeClass('active');
        $(this).addClass('active');
    });

    $('form').submit(function(e){
        e.preventDefault();

        var qName = $("input[id='q-name']").val();
        var options = $("input[name='option[]']")
              .map(function(){return $(this).val();}).get();
        var groupId = $("input[name='group[]']:checked").val();
        var tags = $("input[id='s-tag']").val().split(",");
        var urgency = $("button.btn.active").val();
        
        $.ajax({
            url: "../poll/submit-add-poll.php", 
            type: 'POST',
            data: {
                q_name: qName,
                options: JSON.stringify(options),
                groupId:groupId,
                tags:JSON.stringify(tags),
                urgency:urgency
            },
            dataType: 'json',
            success: function(result){
                if (result == true){
                    responseMsg = '<div class="alert alert-success" role="alert">'+
                        '<strong>Thanks! </strong>'+'Your survey has been submitted. '+
                        '<a href="../home.html" class="alert-link">'+
                        'Click here to go home</a></div>';
                    $('#response').append(responseMsg).slideDown("medium");
                    $('div#add-panel').slideUp("medium");
                }
                else{
                    responseMsg = '<div class="alert alert-danger" role="alert">'+
                        '<strong>Sorry! </strong>'+'Your survey could not be submitted'+'</div>';
                    $('#response').append(responseMsg).slideDown("medium");
                }
            },
            error: function(result){
                console.log("AJAX eror: "+result);
            }
        });
    });
});