<?php
// テキストファイルの名前
$fileName = "test.dat";
$errMessage = "エラーが発生しました。";
// フォームから送られてきた値
$answer = $_POST['hidden-btn'];

// キャッシュ削除
clearstatcache();

// test.txtが存在するか確認
// 存在すればtrue
$isExist = file_exists($fileName);

if ($isExist) {

    // 値を取得
    // 取得できない場合はfalseが返るので、初期値設定
    $array = unserialize(file_get_contents($fileName));
    //var_dump($array);
    if (!$array) {
        $data = [0, 0, 0];
    } else {
        // 取得できた値を使う
        $data = $array;
    }

    /****** ↓共通化できそう *****/
    if ($answer == "1") {
        // 元々の値を上書き
        $ansResult = $data[0];
        $ansResult++;
        $data[0] = $ansResult;
    } else if ($answer == "2") {
        // 元々の値を上書き
        $ansResult = $data[1];
        $ansResult++;
        $data[1] = $ansResult;
    } else if ($answer == "3") {
        // 元々の値を上書き
        $ansResult = $data[2];
        $ansResult++;
        $data[2] = $ansResult;
    } else {
        // 想定外の値の場合、更新しないで返す。
        //header("Location: ".$uri);
    }

    //var_dump($data);
    // $dataでファイルの中身を置き換える。(排他制御)
    file_put_contents($fileName, serialize($data), LOCK_EX);
    /****** ↑共通化できそう *****/
} else {
    // 存在しない場合は新しく作成
    $result = touch($fileName);
    if (!$result) {
        // 作成失敗
        echo $errMessage . ' : ファイルの新規作成に失敗しました。';
        exit();
    }

    // [0,0,0]の配列を作成
    $data = [0, 0, 0];

    /****** ↓共通化できそう *****/
    // 結果を加算
    if ($answer == "1") {
        // 元々の値を上書き
        $ansResult = $data[0];
        $ansResult++;
        $data[0] = $ansResult;
    } else if ($answer == "2") {
        // 元々の値を上書き
        $ansResult = $data[1];
        $ansResult++;
        $data[1] = $ansResult;
    } else if ($answer == "3") {
        // 元々の値を上書き
        $ansResult = $data[2];
        $ansResult++;
        $data[2] = $ansResult;
    } else {
        // 想定外の値の場合、更新しないで返す。
        //header("Location: ".$uri);
    }
    // ファイルに保存
    file_put_contents($fileName, serialize($data), LOCK_EX);
    /****** ↑共通化できそう *****/
}
// キャッシュ削除
clearstatcache();

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>アンケート</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.0/Chart.min.js"></script>
</head>

<body>
    <h1>SPOTS</h1>
    <p>A.バスケ　B.サッカー　C.テニス</p>
  
    <button class="question-btn">🏀</button>
    <button class="question-btn">⚽️</button>
    <button class="question-btn">🎾</button>
    <form id="question-form" action="index.php" method="post">
        <input type="hidden" id="hidden-btn" name="hidden-btn" value="">
    </form>
    <div id="chart">
        <canvas id="myChart" width="200" height="200"></canvas>
        <p id="noChart">まだ投票がありません。</p>
    </div>
    <!-- いちいちブラウザのdeveloperToolを使うのが面倒なので、ストレージ削除ボタン追加。テスト時のみ実施。 -->
    <button onclick="deleteLocalStorage()">ストレージ削除(テスト用)</button>
</body>
<script>
    $(function() {
        // 投票の選択肢ボタンクリックイベント
        $('.question-btn').click(function() {
            // 投票済みフラグがあれば処理を中断
            var isVote = getLocalStorage();
            console.log(isVote);
            if (isVote != null) {
                alert('すでに投票済みです。');
                return;
            }

            var form1 = document.forms['question-form'];
            var ans = $(this).text();
            $('#hidden-btn').val(ans);
            form1.submit();

            // 投票済みフラグを設定
            setLocalStorage();
            return false;
        });

        // グラフ描画
        drawChart();
    })

    /* 円グラフを描画*/
    var drawChart = function() {
        var array = <?php echo json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

       
        var matchNum = 0;
        for (var i = 0; i < array.length; i++) {
            if (array[i] === 0) {
                matchNum++;
            }
        }

        if (array.length === matchNum) {
            $('#myChart').hide();
            $('#noChart').show();
        } else {
            $('#myChart').show();
            $('#noChart').hide();
        }

        // グラフ描画
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["A:バスケ", "B:サッカー", "C:テニス"],
                datasets: [{
                    label: 'アンケート',
                    data: array,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],

                }]
            }
        });
    }

    /**
     * 投票済みフラグをローカルストレージから取得する。
     */
    var getLocalStorage = function() {
        return JSON.parse(localStorage.getItem('isVote'));
    }

    /**
     * 投票済みフラグをローカルストレージに保存します。
     */
    var setLocalStorage = function() {
        var isVote = JSON.stringify('voted');
        localStorage.setItem('isVote', isVote);
        alert('投票しました。');
    }

    /**
     * 投票済みフラグをローカルストレージから削除します。
     */
    var deleteLocalStorage = function() {
        localStorage.removeItem('isVote');
        alert('ストレージ（isVote）を削除しました。');
    }
</script>
<style>
    #chart {
        width: 400px;
        height: 400px;
    }
</style>

</html>