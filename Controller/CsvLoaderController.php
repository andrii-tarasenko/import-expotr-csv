<?php

class CsvLoaderController
{
    private $filename;
    private $delimiter;

    public function __construct($filename, $delimiter = ',')
    {
        $this->filename = $filename;
        $this->delimiter = $delimiter;
    }

    public function loadCsv()
    {
        $data = [];
        if (($handle = fopen($this->filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $this->delimiter)) !== false) {
                $filename = $_FILES['csv-file']['name'];
                $extension = pathinfo($filename, PATHINFO_EXTENSION);

                $newArray = $row;

                if ($extension == 'csv') {
                    $newArray = explode(',', $row[0]);
                }
                if ($newArray[0] == 'category') {
                    continue;
                }
                    $data[] = [
                        'category' => $newArray[0],
                        'firstname' => $newArray[1],
                        'lastname' => $newArray[2],
                        'email' => $newArray[3],
                        'gender' => $newArray[4],
                        'birthdate' => $newArray[5],
                    ];
            }
            fclose($handle);
        } else {
            throw new Exception("Could not read file");
        }

        return $data;
    }
}























