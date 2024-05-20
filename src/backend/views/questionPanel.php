<?php
// TODO this is a panel for questions
// TODO for admins it includes a tooltip to choose user

if (isset($users)){
    // if admin
    // important not to expose other details than usename and id
    echo json_encode(["questions" => $questions, "users" => $users]);
}
else{
    echo json_encode(["questions" => $questions]);
}
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
     */

</script>
