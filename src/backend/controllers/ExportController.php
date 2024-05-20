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
use Services\VotingService;

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../loader.php";

class ExportController extends Controller{

    private VotingService $voting_service;

    public function __construct()
    {
        $this->voting_service = new VotingService();
    }

    public function export(string $format)
    {
        $result = $this->voting_service->exportData($format);

        if (isset($result['error'])) {
            http_response_code($result['status']);
            echo json_encode($result);
            return;
        }

        http_response_code(200);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $result['file'] . '"');
        readfile($result['file']);
    }
}

?>