<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Upload CSV</title>
        <link rel="stylesheet" type="text/css" href="views/css/style.css">
    </head>
    <body>
        <form method="POST" enctype="multipart/form-data">
            <label for="csv-file">Choose a CSV file:</label>
                    <!--            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />-->
            <input type="file" name="csv-file" id="csv-file">
            <button type="submit">Upload</button>
        </form>
    </body>
</html>
