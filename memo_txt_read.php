<?php
$str = '';
$array = [];

$file = fopen('data/memo.csv', 'r');
flock($file, LOCK_EX);
if ($file) {
    while ($line = fgets($file)) {
        $str .= "<tr><td>{$line}</td></tr>";
        array_push($array, $line);
    }
}

flock($file, LOCK_UN);
fclose($file);
// var_dump($array);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>textファイル書き込み型memoリスト（一覧画面）</title>
</head>

<body>
    <fieldset>
        <legend>Don't Forget</legend>
        <!-- 飛ぶぞこれ -->
        <a href="d219.php">Memory</a>
        <table>
            <thead>
                <tr>
                    <th>List
                    </th>
                </tr>
            </thead>
            <tbody>
                <?= $str ?>
            </tbody>
        </table>
    </fieldset>
    <script>
        // 配列にするやつ
        const array = <?= json_encode($array) ?>;
        const newarray = array.map(x => {
            return {
                'when': x.split(' ')[0],
                'where': x.split(' ')[1],
                'who':x.split(' ')[2],
                'impressions':x.split(' ')[3].split('\n').join(''),
            }
        })
        
  
        console.log(newarray);
 
    </script>
</body>

</html>