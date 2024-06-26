<?php
namespace Controllers;
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../loader.php";

use Models\QuestionType;
use Repositories\AnswerRepository;
use Repositories\PeriodRepository;
use Repositories\UserRepository;
use Services\AnswerService;
use Services\StaticOptionService;
use Services\OptionService;
use Services\PeriodService;


class AnswerController extends Controller
{
    private AnswerService $answerService;
    private PeriodService $periodService;
    private StaticOptionService $staticOptionService;

    public function __construct()
    {
        $this->answerService = new AnswerService();
        $this->periodService = new PeriodService();
        $this->staticOptionService = new StaticOptionService();
    }

    public function index(string $code){
        $result = $this->periodService->getPeriodByCode($code);
        if ($result['status'] !== 200){
            // TODO place something here
            header('Location: index.php');
            return;
        }

        $period = $result['data'];
        if (!$period->isIsOpen()){
            header('Location: index.php');
            return;
        }

        switch ($period->getQuestionType()){
            case QuestionType::Open:
                $this->render("openAnswer", ['period' => $period]);
                break;
            case QuestionType::Single_choice:
                $result = $this->staticOptionService->getAllStaticOptionsByPeriodId($period->getId());
                if ($result['status'] === 200){
                    $options = $result['data'];
                }
                else{
                    $options = [];
                }
                $this->render("singleAnswer", ['period' => $period, 'options' => $options]);
                break;
            case QuestionType::Multi_choice:
                $result = $this->staticOptionService->getAllStaticOptionsByPeriodId($period->getId());
                if ($result['status'] === 200){
                    $options = $result['data'];
                }
                else{
                    $options = [];
                }
                $this->render("multiAnswer", ['period' => $period, 'options' => $options]);
                break;
        }

    }

    public function answer(string $code, array $data)
    {
        $result = $this->periodService->getPeriodByCode($code);
        if ($result['status'] !== 200){
            echo json_encode($result);
            http_response_code($result['status']);
            header("Content-Type: application/json");
            return;
        }
        $period = $result['data'];

        if (!$period->isIsOpen()){
            echo json_encode(
                [
                'message' => 'Period is closed',
                'status' => 400
            ]);
            http_response_code(400);
            header("Content-Type: application/json");
            return;
        }
        $result = $this->answerService->createAnswer($period, $data);
        echo json_encode($result);
        http_response_code($result['status']);
        header("Content-Type: application/json");
    }
}