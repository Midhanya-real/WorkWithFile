<form action="index.php" method="post" enctype="multipart/form-data">
    <input type="file" , name="docs"> <br>
    <textarea name="description"></textarea>><br>
    <input type="submit">
</form>

<?php
function countWord($word)
{
    $result = [];
    $count = 0;
    $countWord = [];

    $masWord = explode(' ', preg_replace("/[^a-z\']+/", ' ', strtolower($word)));
    $filtMasword = array_filter($masWord, fn($elem) => $elem != '');

    foreach ($filtMasword as $value) {
        $countWord[$value]++;
        $count++;
    }

    $result["Count_of_word"] = $count;
    foreach ($countWord as $key => $value) {
        $result[$key] = $value;
    }

    if (!file_exists("csv_results")) {
        mkdir("csv_results", 777);
    }
    $dir = opendir("csv_results");

    $date = date('YmdHisu', microtime(true));
    $handle = fopen("csv_results/" . "Dak" . "$date" . ".csv", 'w');

    foreach ($result as $key => $value) {
        fputcsv($handle, [$key . ';' . $value]);
    }

    fclose($handle);
    closedir($dir);
    sleep(1); // Так нада, пусть котики не плачут
}
if (!empty($_FILES['docs']['name'])) {
    countWord(file_get_contents($_FILES['docs']['tmp_name']));
}
if (!empty($_POST['description'])) {
    countWord($_POST['description']);
}
?>
