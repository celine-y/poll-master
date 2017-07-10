$(document).ready(function() {
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('#options-area .controls:first'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);
        
        newEntry.find('input').val('');
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

    

    $('form').submit(function(e){
        e.preventDefault();

        var qName = $("input[id='q-name']").val();
        var options = $("input[name='option[]']")
              .map(function(){return $(this).val();}).get();
        var groupId = $("input[name='group[]']:checked").val();
        var tags = $("input[id='s-tag']").val().split(",");
        // console.log(qName, options, groupId, tags);

        //TODO: pass this info to PHP to insert
        $.ajax({
            url: "../poll/submit-add-poll.php", 
            type: 'POST',
            data: {
                q_name: qName,
                options: JSON.stringify(options),
                groupId:groupId,
                tags:JSON.stringify(tags)
            },
            dataType: 'json',
            success: function(result){
                // $("#response").html(result);
                console.log(result);
            },
            error: function(result){
                console.log("AJAX eror: "+result);
            }
        });
    });
});