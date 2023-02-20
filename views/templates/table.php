<?php if (!empty($resultMessage)) { ?>
    <div class="success-message">
        <p><?php echo $resultMessage;?></p>
    </div>
<?php } ?>
<form method="get">
<table>
    <thead>
    <tr>
        <th class="cat">Category
            <select id="category" name="category">
                <option value="">All</option>
                <?php foreach($parameters['category'] as $categoty) { ?>
                    <option value="<?php echo $categoty;?>"><?php echo $categoty;?></option>
                <?php } ?>
            </select>
        </th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Gender
            <select id="gender" name="gender">
                <option value="">All</option>
                <?php foreach($parameters['gender'] as $gender) { ?>
                    <option value="<?php echo $gender;?>"><?php echo $gender;?></option>
                <?php } ?>
            </select>
        </th>
        <th>Birthdate
            <select id="age-range-min" name="age_range_min">
                <option value="">All</option>
                <?php foreach($parameters['birthDate'] as $birthDate) { ?>
                    <option value="<?php echo $birthDate;?>"><?php echo $birthDate;?></option>
                <?php } ?>
            </select>
            <select id="age-range-max" name="age_range_max">
                <option value="">All</option>
                <?php foreach($parameters['birthDate'] as $birthDate) { ?>
                    <option value="<?php echo $birthDate;?>"><?php echo $birthDate;?></option>
                <?php } ?>
            </select>
            <button id="filter_submit" type="submit" class="btn">Filter</button>
        </th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td class="cat"><?php echo $row['category']; ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['lastname']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['birthDate']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</form>
<?php if (!empty($rows)) { ?>
    <div class="pagination">
        <?php if ($totalPages > 1) {?>
            <?php if ($page > 1) {?>
                <a href="<?php echo $prewPage;?>">Prev</a>
            <?php } ?>
            <?php for ($i = 1; $i < $totalPages; $i++) {?>
                <?php if ($totalPages <= 5 || ($i == 1 || $i == $totalPages || abs($page - $i) <= 2)) { ?>
                    <?php if ($page == $i) {?>
                        <span class="current-page"><?php echo $i;?></span>
                    <?php } else {?>
                        <?php if ($totalPages !== $i) {?>
                            <a id="<?php echo $i; ?>" href="<?php echo 'client_table.php?page=' . $i . '&perPage=' . $conf['perPage'] . $queryP;?>"><?php echo $i;?></a>
                        <?php }?>
                    <?php } ?>
                <?php } elseif (($i == 2 && $page <= 4) || ($i == $totalPages - 1 && $page >= $totalPages - 3)) { ?>
                    <a href="#">...</a>
                <?php } ?>
            <?php } ?>
            <?php if ($page < $totalPages) {?>
                <a href="<?php echo $nextPage;?>">Next</a>
            <?php }
        }?>
    </div>
<?php } ?>

<form method="get" action="../../Controller/DownloadCSVController.php">
    <?php foreach ($queryParameters as $key => $params) { ?>
        <input type="text" name="<?php echo $key; ?>" value="<?php echo $params; ?>" style="display: none">
    <?php } ?>
    <button  id="generate_file" class="button" type="submit">Generate CSV</button>
    <?php if ($fileGenerated)  { ?>
        <a id="download_csv" href="<?php echo $link; ?>" style="" class="button" download>Download CSV</a>
    <?php } ?>
</form>


<style>
    button:hover {
        background-color: #0056b3;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: left;
        padding-top: 8px;
        padding-bottom: 8px;
    }
    .cat{
        padding-left: 8px;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .success-message {
        background-color: #DFF2BF;
        border: 1px solid #4F8A10;
        color: #4F8A10;
        margin-bottom: 10px;
        padding: 5px 10px;
    }

    .success-message p {
        margin: 0;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .pagination a, .pagination span {
        display: inline-block;
        padding: 10px;
        margin: 0 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        color: #333;
        font-weight: bold;
        text-decoration: none;
    }

    .pagination a:hover {
        background-color: #ccc;
    }

    .pagination span {
        background-color: #ccc;
        cursor: default;
    }

    .pagination .current-page {
        background-color: #333;
        color: #fff;
    }

    label {
        display: inline-block;
        width: 100px;
        font-weight: bold;
    }

    select,
    input[type="number"],
    input[type="date"] {
        width: 150px;
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-shadow: inset 0 1px 3px #ddd;
    }

    select:focus,
    input[type="number"]:focus,
    input[type="date"]:focus {
        outline: none;
        border-color: #2b73b6;
        box-shadow: 0 0 3px #2b73b6;
    }

    .btn {
        display: block;
        width: 100%;
        margin-top: 10px;
        padding: 10px;
        background-color: #2b73b6;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #3c8dbc;
    }

    .btn:active {
        background-color: #285e8e;
    }

    .btn:focus {
        outline: none;
        box-shadow: 0 0 3px #2b73b6;
    }

    ::-webkit-input-placeholder {
        color: #aaa;
    }

    :-moz-placeholder {
        color: #aaa;
    }

    ::-moz-placeholder {
        color: #aaa;
    }

    :-ms-input-placeholder {
        color: #aaa;
    }

    #filter_submit,#age-range-max, #age-range-min {
        display: inline;
    }
    #category, #gender, #age-range-max, #age-range-min {
        width: 135px;
        margin-left: 10px;
    }
    #filter_submit{
        width: 70px;
        margin-left: 10px;
    }
    .button{
        margin-left: 10px;
    }
    .button, #filter_submit {
        display: inline-block;
        padding: 0.5em 1em;
        border: 1px solid #ccc;
        background-color: #f7f7f7;
        text-decoration: none;
        color: #333;
        font-size: 1em;
        border-radius: 0.25em;
    }

    .button:hover {
        background-color: #e0e0e0;
        border-color: #b2b2b2;
        color: #222;
    }

    #generate_file, #download_csv {
        display: inline;
        background-color: #4CAF50;
        color: #fff;
    }

</style>