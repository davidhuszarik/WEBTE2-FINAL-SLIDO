<?php

namespace Controllers;
use Couchbase\PrefixSearchQuery;
use Models\StaticOption;
use Models\UserRole;
use Services\LoginService;
use Services\OptionService;
use Services\PeriodService;
use Services\QuestionService;
use Services\StaticOptionService;
use Services\UserService;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../loader.php";

class QuestionController extends Controller
{
    private QuestionService $questionService;
    private LoginService $loginService;
    private UserService $userService;

    public function __construct()
    {
        $this->questionService = new QuestionService();
        $this->loginService = new LoginService();
        $this->userService = new UserService();
    }

    public function index(?int $userId)
    {
        $this->loginService->updateSessionUser();
        $requester = $this->loginService->getLoggedInUser();
        if ($requester == null){
            $this->render('restricted');
            return;
        }
        if ($requester->getUserRole() != UserRole::Admin || $userId == null){
            $userId = $requester->getId();
        }
        $result = $this->questionService->getAllQuestionsForGivenUserById($userId, $requester);

        if ($result['status'] == 403){
            $this->render('restricted');
            return;
        }
        if($result['status'] == 500){
            $this->render('serverIssue');
            return;
        }
        if($result['status'] == 404){
            $this->render('notExist');
            return;
        }
        if ($result['status'] != 200){
            $this->render('serverIssue');
            return;
        }

        if ($requester->getUserRole() == UserRole::Admin){
            $users = $this->userService->getAllUsers();
            if ($users['status'] != 200){
                $this->render('serverIssue');
                return;
            }
            $this->render('questionPanel', ["questions" => $result['data'], "users" => $users['data']]);
            return;
        }
        $this->render('questionPanel', ["questions" => $result['data']]);
    }

    public function indexId(int $id)
    {
        $result = $this->questionService->getSpecificQuestion($id);

        if ($result['status'] == 403){
            $this->render('restricted');
            return;
        }
        if ($result['status'] == 404){
            $this->render('notExist');
            return;
        }
        if ($result['status'] != 200){
            $this->render('serverIssue');
            return;
        }

        $this->render('questionView', ['question' => $result['data']]);
    }

    public function openById($questionId, string $endTimestamp)
    {
        try{
            $date = new \DateTime($endTimestamp);
        }
        catch (\Exception $e){
            $result = [
                'error' => "Bad date format",
                'status' => 400
            ];
            echo json_encode($result);
            http_response_code($result['status']);
            header("Content-Type: application/json");
            return;
        }

        $result = $this->questionService->open($questionId, $date);
        echo json_encode($result);
        http_response_code($result['status']);
        header("Content-Type: application/json");
    }

    public function closeById($questionId)
    {
        $result = $this->questionService->close($questionId);
        echo json_encode($result);
        http_response_code($result['status']);
        header("Content-Type: application/json");
    }

    public function createNewQuestion(?int $userId, array $data)
    {
        $result = $this->questionService->createNewQuestionForGivenUserId($userId, $data);
        echo json_encode($result);
        http_response_code($result['status']);
        header("Content-Type: application/json");
    }
}