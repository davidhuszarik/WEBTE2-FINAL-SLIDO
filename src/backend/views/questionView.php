<?php
// TODO this is page for a specific question
echo json_encode(["question" => $question]);
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

<script>
    /*
    $.ajax({
        url: window.location.href,
        type: 'POST',
        contentType: 'application/json',
        data: {
            is_open: true
            end_timestamp: "2024-06-19 11:58:49"
        },
        success: function(response) {
            console.log('Response:', response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
        }
    });

    $.ajax({
        url: window.location.href,
        type: 'POST',
        contentType: 'application/json',
        data: {
            is_open: false
        },
        success: function(response) {
            console.log('Response:', response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
        }
    });

    $.ajax({
        url: window.location.href,
        type: 'DELETE',
        contentType: 'application/json',
        success: function(response) {
            console.log('Response:', response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
        }
    });

    $.ajax({
        url: window.location.href,
        type: 'PUT',
        contentType: 'application/json',
        data: {
            question: {
                user_id: 1,
                title_en: "asd",
                title_sk: "asd",
                content_en: "asdasdasd",
                content_sk: "asdasdasd",
                type: "single_choice"
            },
            options: [
                {
                    value_en: "asdasdasdasd",
                    value_sk: "asdasdasd",
                    is_correct: true
                },
                {
                    value_en: "sjeriuesrg",
                    value_sk: "diuius",
                    is_correct: false
                }
            ]
        },
        success: function(response) {
            console.log('Response:', response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
        }
    });

    $.ajax({
        url: "https://localhost/question/clone/3",
        type: 'POST',
        contentType: 'application/json',
        success: function(response) {
            console.log('Response:', response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
        }
    });
    */
</script>
