<?php

require_once '../Model/TableForTest.php';

class DownloadCSVController
{
    public static function createCSV()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $conf = [];
            if (!empty($_GET)) {
                if (!empty($_GET['category'])) {
                    $conf['category'] = $_GET['category'];
                }
                if (!empty($_GET['gender'])) {
                    $conf['gender'] = $_GET['gender'];
                }
                if (!empty($_GET['age_range_min'])) {
                    $conf['age_range_min'] = $_GET['age_range_min'];
                }
                if (!empty($_GET['age_range_max'])) {
                    $conf['age_range_max'] = $_GET['age_range_max'];
                }
            }
            $getDatas = new TableForTest();
            $rows = $getDatas->getDatas($conf);

            $filename = 'clients.csv';

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="'.$filename.'"');

            $output = fopen('php://output', 'w');

            foreach ($rows as $row) {
                fputcsv($output, $row);
            }

            fclose($output);

            $result = 'file_generated';

//            header('Location: ../views/templates/client_table.php?result=' . $result);
//
//            exit();
        }
    }
}

DownloadCSVController::createCSV();