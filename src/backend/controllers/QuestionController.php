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
    private PeriodService $periodService;
    private OptionService $optionService;
    private StaticOptionService $staticOptionService;
    private LoginService $loginService;
    private UserService $userService;

    public function __construct()
    {
        $this->questionService = new QuestionService();
        $this->periodService = new PeriodService();
        $this->optionService = new OptionService();
        $this->staticOptionService = new StaticOptionService();
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
}