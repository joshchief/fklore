$(document).ready(function(){
    let attachments = [];
    let attach_box_clicked = null;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.attach_box').click(function(e){
        attach_box_clicked = $(this);
        $('.inv-view').html('');
        $.ajax({
            type: 'GET',
            url: location.protocol + '//' + location.hostname + "/user/messages/compose/invviewer",
            success: function (b)
            {
                $('.inv-view').html(b);
            }
        })
        $('#attachModal').modal();
    });

    $(document).on('click', '.item', function(){
        var uuid = $(this).parent().attr('data-uuid');
        let findAttachBox = attachments.find(a => a.box_id === attach_box_clicked.attr('data-id'));
        let findAttachedItem = attachments.find(i => i.uuid === uuid);
        if(findAttachBox === undefined && findAttachedItem === undefined)
        {
            attachments.push({'uuid': uuid, 'item_id': Number($(this).parent().attr('data-item-id')), 'quantity': Number($(this).parent().attr('data-quantity'))-1, 'box_id': attach_box_clicked.attr('data-id')});
            attach_box_clicked.html(`<img class="attached-item" src="${$(this).attr('src')}" />`);
        }else if(findAttachedItem !== undefined && findAttachedItem.quantity === 0) {
            Swal.fire({
                title: 'Uh oh',
                text: 'That item is already going to be attached.',
                icon: 'error'
            });
        }else if(findAttachBox === undefined && findAttachedItem !== undefined) {
            findAttachedItem.quantity = findAttachedItem.quantity-1;
            attachments.push({'uuid': uuid, 'item_id': Number($(this).parent().attr('data-item-id')), 'quantity': findAttachedItem.quantity, 'box_id': attach_box_clicked.attr('data-id')});
            attach_box_clicked.html(`<img class="attached-item" src="${$(this).attr('src')}" />`);
        }else{
            if(uuid !== findAttachBox.uuid)
            {
                findAttachBox.uuid = uuid;
                attach_box_clicked.html(`<img class="attached-item" src="${$(this).attr('src')}" />`);
            }
        }
        $('#attachModal').modal('hide');
    });

    function getAttachments()
    {
        let p_attachments = [];
        let gold = Number($('#attach_gold').val());
        let silver = Number($('#attach_silver').val());
        if(silver > 0)
        {
            p_attachments.push({'type': 'currency_silver', 'quantity': silver});
        }
        if(gold > 0)
        {
            p_attachments.push({'type': 'currency_gold', 'quantity': gold});
        }
        if(attachments.length > 0)
        {
            attachments.forEach(function(item){
                p_attachments.push({'type': 'item', 'object_id': item.item_id})
            });
        }
        return p_attachments;
    }
    function send(preview = false)
    {
        url = (preview) ? location.protocol + '//' + location.hostname + "/user/messages/compose/preview" : location.protocol + '//' + location.hostname + "/user/messages/compose";
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'to': $('#message_to').val(),
                'message': $('#message_message').val(),
                'attachments': getAttachments(),
                'subject': $('#message_subject').val(),
            },
            success: function(b)
            {
                if(preview)
                {
                    $('#preview_box').html(b);
                    $('#preview_box').fadeIn();
                }else{
                    if(b.t == 'success')
                    {
                        document.location.href = location.protocol + '//' + location.hostname + "/user/messages/";
                    }else{
                        document.location.href = document.location;
                    }
                }
            }
        })
    }

    $('#send').click(function(){
        send();
    });

    $('#preview').click(function(){
        send(true);
    });
});