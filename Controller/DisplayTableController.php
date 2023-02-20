<?php

require_once '../../Model/TableForTest.php';

class DisplayTableController
{
    public function getQuery() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $conf = [];
            if (!empty($_GET)) {
                //TODO: Validation
                if (!empty($_GET['result'])) {
                    $conf['result'] = $_GET['result'];
                }
                if (!empty($_GET['perPage'])) {
                    $conf['perPage'] = $_GET['perPage'];
                }
                if (!empty($_GET['page'])) {
                    $conf['page'] = $_GET['page'];
                }

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

                return $conf;
            }
        }
    }

    public static function rednerTable()
    {
        $conf = self::getQuery();
        $resultMessage = '';
        $link = '../../Controller/DownloadCSVController.php';
        $queryParameters = [];

        if ($conf['result'] == 'all_upload') {
            $resultMessage = 'All datas was uploaded!';
        }
        if ($conf['result'] == 'file_generated') {
            $fileGenerated = true;
        }

        if ($conf['page']  == null ) {
            $conf['page'] = 1;
        }
        if ($conf['perPage'] == null) {
            $conf['perPage'] = 10;
        }

        if (!empty($conf)) {
            $queryParameters = $conf;
        }

        $getDatas = new TableForTest();

        $rows = $getDatas->getDatas($conf);
        $parameters = $getDatas->getParameters();

        $count = $rows['count'];
        $totalPages = (int) ceil($count / $conf['perPage']);
        $page = (int) $conf['page'];

        $queryP = 'client_table.php?category=' . $conf['category'] . '&gender=' . $conf['gender'] . '&age_range_min=' . $conf['age_range_min'] . '&age_range_max=' . $conf['age_range_max'];

        $nextPage = $queryP . '&page=' . ($page + 1) . '&perPage=' . $conf['perPage'];
        $prewPage = $queryP . '&page=' . ($page - 1) . '&perPage=' . $conf['perPage'];

        unset($rows['count']);

        require_once 'table.php';
    }
}






