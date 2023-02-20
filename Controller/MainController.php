<?php

require_once 'Controller/CsvLoaderController.php';

require_once 'Model/TableForTest.php';

class MainController
{
    private static $displayMessage;
    private static $period;
    private static $perPage;
    private static $page;

    public  function init ($displayMessage, $period, $perPage, $page) {
        self::$displayMessage = $displayMessage;
        self::$period = $period;
        self::$perPage = $perPage;
        self::$page = $page;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->postProces();
        } else {
            $this->renderForm();
        }
    }

    public function postProces ()
    {
            $loader = new CsvLoaderController($_FILES['csv-file']['tmp_name']);
            $dataCSV = $loader->loadCsv();

            $tableForTest = new TableForTest();
            $dataFromDb = $tableForTest->getDatas();
            if (!empty($dataFromDb)) {
                foreach ($dataFromDb as $tableData) {
                    foreach ($dataCSV as $key => $row) {
                        if ($tableData['category'] == $row['category'] &&  $tableData['email'] == $row['email']) {
                            unset($dataCSV[$key]);
                        }
                    }
                }
            }
            if (!empty($dataCSV)) {
                $newDb = new TableForTest();
                $newDb->createTable();
                foreach ($dataCSV as $row) {
                    //  запис в базу даних
                    $newDb->setDatas($row['category'], $row['firstname'], $row['lastname'], $row['email'], $row['gender'], $row['birthdate']);
                }
                $result = "all_upload";
                header('Location: views/templates/client_table.php?perPage=' . self::$perPage . '&page=' . self::$page . '&result=' . $result);

                exit();
            }
    }

    public function renderForm () {
        require_once 'views/templates/csv_form.php';
    }
}