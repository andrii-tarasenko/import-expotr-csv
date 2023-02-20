<?php
if (file_exists('Model/Config.php')) {
    require_once 'Model/Config.php';
} elseif (file_exists('../../Model/Config.php')) {
    require_once '../../Model/Config.php';
} elseif (file_exists('../Model/Config.php')) {
    require_once '../Model/Config.php';
}

class TableForTest
{
    private $db;

    public function __construct()
    {
        $this->db = Config::dBConfig();
    }

    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS clients (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            category VARCHAR(255) NOT NULL,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            gender VARCHAR(10) NOT NULL,
            birthDate DATE NOT NULL
        )";

        $this->db->exec($sql);
    }

    public function setDatas($category, $firstname, $lastname, $email, $gender, $birthdate)
    {
        $SetDatas = "INSERT INTO clients
                (category, firstname, lastname, email, gender, birthdate) VALUES
                ('" . $category . "', '" . $firstname . "', '" . $lastname . "', '" . $email . "', '" . $gender . "', '" . $birthdate . "')";

        if (!$this->db->exec($SetDatas)) {
            return false;
        }

        return true;
    }

    public function getDatas($pageConf = null)
    {
        $conn = mysqli_connect(Config::$host, Config::$userName, Config::$password, Config::$dbname);
        $sqlData = "SELECT * FROM clients";
        $sqlCount = "SELECT COUNT(*) FROM clients";
        $sql = '';

        if ($pageConf !== null) {
            if (!empty($pageConf['category'])
                || !empty($pageConf['gender'])
                || !empty($pageConf['age_range_min'])
                || !empty($pageConf['age_range_max'])) {
                $sql .= " WHERE ";
                if (!empty($pageConf['category'])) {
                    $category = $pageConf['category'];
                    $sql .= "category = '" . $category . "'";
                }
                if (!empty($pageConf['gender'])) {
                    $gender = $pageConf['gender'];
                    if (!empty($pageConf['category'])) {
                        $sql .= " AND ";
                    }
                    $sql .= "gender = '" . $gender . "'";
                }
                if (!empty($pageConf['age_range_min'])) {
                    $ageRangeStart = $pageConf['age_range_min'];
                    if (!empty($pageConf['category'])
                        || !empty($pageConf['gender'])) {
                        $sql .= " AND ";
                    }
                    $sql .= "birthDate >= '" . $ageRangeStart . "'";
                }
                if (!empty($pageConf['age_range_max'])) {
                    $ageRangeEnd = $pageConf['age_range_max'];
                    if (!empty($pageConf['category'])
                        || !empty($pageConf['gender'])
                        || !empty($pageConf['age_range_min'])) {
                        $sql .= " AND ";
                    }
                    $sql .= "birthDate <= '" . $ageRangeEnd . "'";
                }
            }

            $count = $this->db->query($sqlCount . $sql)->fetchColumn();

            if ($pageConf['perPage'] !== null && $pageConf['page'] !== null) {
                $perPage = (int) $pageConf['perPage'];
                $page = (int) $pageConf['page'];
                $offset = ($page - 1) * $perPage;
                $sql .= " LIMIT " . $offset . ', ' . $perPage;
            }
        }

        $result = mysqli_query($conn, $sqlData.$sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            unset($row['id']);
            $rows[] = $row;
        }

        mysqli_close($conn);

        $rows['count'] = $count;

        return $rows;
    }

    public function getParameters() {
        $getParameters = $this->db->query("SELECT `category`, `gender`, `birthDate` FROM clients ORDER BY YEAR(birthDate) ASC")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($getParameters as $param) {

            $categories[] = $param['category'];
            $genders[] = $param['gender'];
            $year = substr($param['birthDate'], 0, 4);
            $birthDates[] = $year;
        }

        $parameters = [];
        $parameters['category'] = array_unique($categories);
        $parameters['gender'] = array_unique($genders);
        $parameters['birthDate'] = array_unique($birthDates);

        return $parameters;
    }
}