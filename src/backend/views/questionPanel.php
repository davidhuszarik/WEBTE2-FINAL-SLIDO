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