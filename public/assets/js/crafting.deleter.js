$(document).ready(function(){
    $('.deletebutton').click(function(e){
        e.preventDefault();
        let type = $(this).parent().find('input[type=hidden]').filter(':first');
        console.log(type);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to recover this "+type.val() + "!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).parent().submit();
            }
        });
    });
});