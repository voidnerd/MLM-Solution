

$( "#registerForm" ).submit(function( event ) {
    event.preventDefault();
    
    
    var method = $('input[name=payment_method]:checked').val();

    if(method !== 'paystack') {
        var form = document.createElement("form");
        form.setAttribute("method", 'post');
        form.setAttribute("action", '/upgrade');
        var input = document.createElement("input");
        input.type = "text";
        input.name = "_token";
        input.value= $('meta[name="_token"]').attr('content');
        form.appendChild(input);
        document.body.appendChild(form);

form.submit();
    }else {
        $('#modal').modal('toggle');
        payWithPaystack();
    }
});

