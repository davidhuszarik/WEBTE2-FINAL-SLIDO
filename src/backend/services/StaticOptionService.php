<?php

namespace Services;
require_once __DIR__ . "/../loader.php";

use Models\StaticOption;
use Models\Option;
use Models\Period;
use Repositories\OptionRepository;
use Repositories\StaticOptionRepository;

class StaticOptionService
{
    private StaticOptionRepository $static_option_repository;
    private OptionRepository $option_repository;

    public function __construct()
    {
        $this->static_option_repository = new StaticOptionRepository();
        $this->option_repository = new OptionRepository();
    }

    // Create new Static options
    public function createStaticOption(int $period_id, $question_id)
    {
        $options = $this->option_repository->getOptionsByQuestionId($question_id);
        if(empty($options)){
            return [
                'error' => 'Options do not exist for this question',
                'status' => 200
            ];
        }
        $inserted_ids = [];
        foreach ($options as $option){
            $new_static_option = new StaticOption($period_id, $option->getValueEn(), $option->getValueSk(), $option->isIsCorrect());
            $temp_id = $this->static_option_repository->createNewStaticOption($new_static_option);
            if ($temp_id == -1) {
                error_log("Failed to create static option for period ID: " . $period_id);
                return [
                    'error' => 'Failed to create static options',
                    'status' => 500
                ];
            }
            $new_static_option->setId($temp_id);
            $inserted_ids[] = $temp_id;
        }

        return [
            'message' => "Successfully created static options",
            'status' => 201,
            'data' => $inserted_ids
        ];
    }

    public function getAllStaticOptionsByPeriodId(int $period_id)
    {
        $static_option_array = $this->static_option_repository->getAllStaticOptionsByPeriodId($period_id);
        if(empty($static_option_array)){
            return [
                'error' => "Did not found any static options by period id",
                'status' => 500,
            ];
        }
        return [
            'message' => "Successfully retrieved static options by period id",
            'status' => 200,
            'data' => $static_option_array
        ];
    }

    public function getStaticOptionById(int $static_option_id)
    {
        $static_option = $this->static_option_repository->getStaticOptionById($static_option_id);
        if($static_option == null){
            return [
                'error' => "Did not found any static option",
                'status' => 500,
            ];
        }
        return [
            'message' => "Successfully retrieved static options by period id",
            'status' => 200,
            'data' => $static_option
        ];
    }

    // Helper functions
    private function checkSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

}

?>
