<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DFP</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="nav">
        <a href="memo_txt_read.php" class="white link"><i class="ion-ios-redo-outline"></i><i class="ion-ios-redo hidden"></i></a>
    </div>
    <div class="container">
        <div class="inner">
            <div class="panel panel-left">
                <div class="panel-content">
                    <div class="image-background">
                    </div>
                </div>
            </div>
            <div class="panel panel-right">
                <div class="panel-content">
                    <form action="memo_txt_create.php" method="POST">
                        <h1>Don't Forget</h1>
                        <div class="group">
                            <input type="date" name="when" required>
                            <span class="highlight"></span>
                        </div>
                        <div class="group">
                            <input type="text" name="who" required>
                            <span class="highlight"></span>
                            <label>with Who</label>
                        </div>
                        <div class="group">
                            <input type="text" input name="where" required>
                            <span class="highlight"></span>
                            <label>to Where</label>
                        </div>
                        <div class="group">
                            <input textarea cols="30" rows="5" input type="text" name="impressions" required>
                            <span class="highlight"></span>
                            <label>Impression</label>
                        </div>
                        <button class="send-btn">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="menu"></div>
    <script>
      
    </script>
</body>

</html>