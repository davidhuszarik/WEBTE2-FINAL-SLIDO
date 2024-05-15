<?php

namespace Services;

use Repositories\AnswerRepository;
use Repositories\QuestionRepository;
use Repositories\PeriodRepository;
use Repositories\PickedStaticOptionRepository;
use Repositories\StaticOptionRepository;

class VotingService
{
    private AnswerRepository $answer_repository;
    private QuestionRepository $question_repository;
    private PeriodRepository $period_repository;
    private PickedStaticOptionRepository $picked_static_option_repository;
    private StaticOptionRepository $static_option_repository;

    public function __construct()
    {
        $this->answer_repository = new AnswerRepository();
        $this->question_repository = new QuestionRepository();
        $this->period_repository = new PeriodRepository();
        $this->picked_static_option_repository = new PickedStaticOptionRepository();
        $this->static_option_repository = new StaticOptionRepository();
    }

    // Retrieve current and archived voting results
    // Retrieve current and archived voting results
    public function getVotingResults(int $question_id)
    {
        $periods = $this->period_repository->getPeriodsByQuestionId($question_id);
        $results = [];
        foreach ($periods as $period) {
            $answers = $this->answer_repository->getAnswersByPeriodId($period->getId());
            $static_options = $this->static_option_repository->getAllStaticOptionsByPeriodId($period->getId());
            $picked_options = [];

            foreach ($answers as $answer) {
                $picked_options[$answer->getId()] = $this->picked_static_option_repository->getPickedOptionsByAnswerId($answer->getId());
            }

            $result = [
                'period' => $period,
                'answers' => $answers,
                'options' => $static_options,
                'picked_options' => $picked_options
            ];
            $results[] = $result;
        }

        return [
            'message' => 'Successfully retrieved voting results',
            'status' => 200,
            'data' => $results
        ];
    }

    // Compare current voting with historical voting
    public function compareVotingResults(int $question_id)
    {
        $periods = $this->period_repository->getPeriodsByQuestionId($question_id);
        $comparison = [];

        foreach ($periods as $period) {
            $answers = $this->answer_repository->getAnswersByPeriodId($period->getId());
            $year = $period->getStartTimestamp()->format('Y');
            $answer_count = count($answers);

            if (!isset($comparison[$year])) {
                $comparison[$year] = ['total' => 0, 'answers' => []];
            }

            $comparison[$year]['total'] += $answer_count;

            foreach ($answers as $answer) {
                if (!isset($comparison[$year]['answers'][$answer->getFreeAnswer()])) {
                    $comparison[$year]['answers'][$answer->getFreeAnswer()] = 0;
                }
                $comparison[$year]['answers'][$answer->getFreeAnswer()]++;
            }
        }

        return [
            'message' => 'Successfully compared voting results',
            'status' => 200,
            'data' => $comparison
        ];
    }

    // Export questions and answers to CSV, JSON, or XML
    public function exportData(string $format)
    {
        $questions = $this->question_repository->getAllQuestions();
        $answers = $this->answer_repository->getAllAnswers();

        $data = [
            'questions' => $questions,
            'answers' => $answers
        ];

        switch (strtolower($format)) {
            case 'csv':
                return $this->exportToCSV($data);
            case 'json':
                return $this->exportToJSON($data);
            case 'xml':
                return $this->exportToXML($data);
            default:
                return [
                    'error' => 'Invalid format specified',
                    'status' => 400
                ];
        }
    }

    private function exportToCSV(array $data)
    {
        $filename = 'export.csv';
        $file = fopen($filename, 'w');

        // Export questions
        fputcsv($file, ['Questions']);
        fputcsv($file, ['ID', 'Title EN', 'Title SK', 'Content EN', 'Content SK', 'Creation Date', 'Type', 'Is Open']);
        foreach ($data['questions'] as $question) {
            fputcsv($file, [
                $question->getId(),
                $question->getTitleEn(),
                $question->getTitleSk(),
                $question->getContentEn(),
                $question->getContentSk(),
                $question->getCreationDate()->format('Y-m-d H:i:s'),
                $question->getQuestionType()->value,
                $question->isIsOpen() ? 'Yes' : 'No'
            ]);
        }

        // Export answers
        fputcsv($file, []);
        fputcsv($file, ['Answers']);
        fputcsv($file, ['ID', 'Period ID', 'User ID', 'Type', 'Free Answer', 'Vote Time']);
        foreach ($data['answers'] as $answer) {
            fputcsv($file, [
                $answer->getId(),
                $answer->getPeriodId(),
                $answer->getUserId(),
                $answer->getQuestionType()->value,
                $answer->getFreeAnswer(),
                $answer->getVoteTime()->format('Y-m-d H:i:s')
            ]);
        }

        fclose($file);

        return [
            'message' => 'Data exported successfully to CSV',
            'status' => 200,
            'file' => $filename
        ];
    }

    private function exportToJSON(array $data)
    {
        $filename = 'export.json';
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));

        return [
            'message' => 'Data exported successfully to JSON',
            'status' => 200,
            'file' => $filename
        ];
    }

    private function exportToXML(array $data)
    {
        $xml = new \SimpleXMLElement('<data/>');

        $questions = $xml->addChild('questions');
        foreach ($data['questions'] as $question) {
            $question_xml = $questions->addChild('question');
            $question_xml->addChild('id', $question->getId());
            $question_xml->addChild('title_en', $question->getTitleEn());
            $question_xml->addChild('title_sk', $question->getTitleSk());
            $question_xml->addChild('content_en', $question->getContentEn());
            $question_xml->addChild('content_sk', $question->getContentSk());
            $question_xml->addChild('creation_date', $question->getCreationDate()->format('Y-m-d H:i:s'));
            $question_xml->addChild('type', $question->getQuestionType()->value);
            $question_xml->addChild('is_open', $question->isIsOpen() ? 'Yes' : 'No');
        }

        $answers = $xml->addChild('answers');
        foreach ($data['answers'] as $answer) {
            $answer_xml = $answers->addChild('answer');
            $answer_xml->addChild('id', $answer->getId());
            $answer_xml->addChild('period_id', $answer->getPeriodId());
            $answer_xml->addChild('user_id', $answer->getUserId());
            $answer_xml->addChild('type', $answer->getQuestionType()->value);
            $answer_xml->addChild('free_answer', $answer->getFreeAnswer());
            $answer_xml->addChild('vote_time', $answer->getVoteTime()->format('Y-m-d H:i:s'));
        }

        $filename = 'export.xml';
        $xml->asXML($filename);

        return [
            'message' => 'Data exported successfully to XML',
            'status' => 200,
            'file' => $filename
        ];
    }
}

?>