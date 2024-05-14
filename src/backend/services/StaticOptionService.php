<?php

namespace Service;
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

    // TODO:  get static options, get specific static option, delete static option

    // Create new Static options
    public function createStaticOption(int $period_id, $question_id)
    {
        $options = $this->option_repository->getOptionsByQuestionId($question_id);
        if(empty($options)){
            return [
                'error' => 'Options do not exist for this question',
                'status' => 500
            ];
        }
        $inserted_ids = [];
        foreach ($options as $option){
            $new_static_option = new StaticOption($period_id, $option->getValueEn(), $option->getValueSk(), $option->isIsCorrect());
            $temp_id = $this->static_option_repository->createNewStaticOption($new_static_option);
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
