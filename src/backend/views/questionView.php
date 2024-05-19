<?php
// TODO this is page for a specific question
echo json_encode(["questions" => $question]);
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

<script>
    /*
    $.ajax({
        url: window.location.href,
        type: 'PATCH',
        contentType: 'application/json',
        data: {
            is_open: true
        },
        success: function(response) {
            console.log('Response:', response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
        }
    });
    */
</script>
