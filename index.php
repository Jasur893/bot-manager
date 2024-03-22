<?php
require_once "config.php";
require_once "function.php";
if (isset($_POST['login_btn']) && $_POST['password']) {
    if (trim($_POST['password']) == $system_pass){
        $_SESSION['pass'] = $system_pass;
    } else {
        $error = "Xatolik, parol xato kiritilgan !";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BotCMS - Botlarni boshqarish  tizimi</title>
    <!--  bootstrap   -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <!--  fontawesome    -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css">
    <!--  fontawesome script  -->
    <script defer src="https://use.fontawesome.com/releases/v6.1.1/js/all.js"></script>

</head>
<body>
    <style>
        .login-form {
            margin: 120px 0;
            padding: 40px 50px;
            border-radius: 8px;
            background: cornsilk;
        }
        .footer {
            text-align: end;
            padding: 20px;
        }

        .form-group {
            padding-bottom: 30px;
        }

        h3.title {
            font-size: larger;
        }

        .errors {
            color: red;
            text-align: center;
        }

        .container-fluid {
            min-height: 90vh;
        }

        p.description {
            background: bisque;
            padding: 10px;
        }

        p.attention-text {
            font-size: small;
            text-align: center;
        }

        .custom-menu a {
            text-decoration: none;
            background: bisque;
            border-radius: 10px;
            padding: 0 5px;
            color: black;
        }

        .col-12.align-middle {
            box-shadow: 0 0 20px 0px grey;
            margin: 30px auto;
            padding: 30px 20px 20px;
            border-radius: 10px;
        }

        pre {
            font-size: 12px;
            border: 1px solid;
            padding: 5px;
        }
        a.attention-text {
            text-decoration: none;
            font-size: small;
        }
        span.small {
            background: antiquewhite;
            padding: 0 7px;
            border-radius: 10px;
            font-size: small;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <?php if(!isset($_SESSION['pass']) || isset($_SESSION['pass']) != $system_pass){ ?>
            <div class="col-md-8 col-lg-5 login-form align-middle">
                <h3 class="title text-center">BotCMS - Botlarni boshqarish  tizimi</h3>
                <p class="errors">
                    <?php if (isset($error)) echo $error;?>
                </p>
                <form method="POST">
                    <div class="form-group">
                        <label for="password">PAROL: <span style="color:red;">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Parolni kiriting">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="login_btn" class="btn btn-primary form-control">Kirish</button>
                    </div>
                    <p class="attention-text">
                        Diqqat, agarda nima qilayotganingizni bilmasangiz tizimdan foydalanish qollanmasini korib chiqing ! <br>
                        <a href="https://www.youtube.com/c/infomiruz/videos">Qollanmani korish</a>
                    </p>
                </form>
            </div>

            <?php }else if($_SESSION['pass'] == $system_pass) {
                $result = '';
                $app_url = str_replace("?reset", "app.php", "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                if (isset($_GET['log'])) {
                    $file = "log.json";
                    $result = file_exists($file) ? file_get_contents($file) : 'log file topilmadi !';
                } elseif (isset($_GET['info'])) {
                    $result = json(bot());
                } elseif (isset($_GET['admin'])) {
                    $result = json(bot("getChat", ['chat_id' => $admin]));
                } elseif (isset($_GET['group_info'])) {
                    $result = json(bot("getChat", ['chat_id' => $my_group]));
                } elseif (isset($_GET['channel_info'])) {
                    $result = json(bot("getChat", ['chat_id' => $my_channel]));
                } elseif (isset($_GET['webhook_info'])) {
                    $result = json(bot("getWebhookInfo"));
                } elseif (isset($_GET['kill'])) {
                    $result = json(bot("deleteWebhook", ['drop_pending_updates' => true]));
                } elseif (isset($_GET['getUpdates'])) {
                    $result = json(bot("getUpdates"));
                } elseif (isset($_GET['reset'])) {
                    $result = json(bot("setWebhook", [
                            'url' => $app_url,
                            'drop_pending_updates' => true,
                            'allowed_updates' => json_encode([
                                    'message'
                            ])
                    ]));
                } elseif (isset($_GET['setComands'])) {
                    foreach ($comands as $comand) {
                        $result .= json(bot("setMyCommands", $comand));
                    }
                } elseif (isset($_GET['clearComands'])) {
                    foreach ($comands as $comand) {
                        $result .= json(bot("deleteMyCommands", $comand));
                    }
                };
            ?>
            <div class="col-12 align-middle">
                <h3>Bot manager menusi:</h3>
                <ul class="custom-menu">
                    <li>
                        <a href="?log"><b>?log</b></a> - Loglarni ko'rish
                    </li>
                    <li>
                        <a href="?info"><b>?info</b></a> - Bot haqida ma'lumot olish
                    </li>
                    <li>
                        <a href="?webhook_info"><b>?webhook_info</b></a> - WebHook haqida ma'lumot olish
                    </li>
                    <li>
                        <a href="?kill"><b>?kill</b></a> - WebHookni bekor qilish, bot ishini to'xtatadi
                    </li>
                    <li>
                        <a href="?reset"><b>?reset</b></a> - Botni ushbu manzilga qayta webhook qilish, manzil: <span class="small"><?=$app_url?></span>
                    </li>
                    <li>
                        <a href="?getUpdates"><b>?getUpdates</b></a> - WebHook qilishdan oldin ishlatib ko'rish
                    </li>
                    <li>
                        Admin va guruh haqida ma'lumot olish, agar config fileda kiritilgan bo'lsa !!!
                    </li>
                    <li>
                        <a href="?admin"><b>?admin</b></a> - Bot haqida ma'lumot olish
                    </li>
                    <li>
                        <a href="?group_info"><b>?group_info</b></a> - Guruh haqida ma'lumot olish
                    </li>
                    <li>
                        <a href="?channel_info"><b>?channel_info</b></a> - Kanal haqida ma'lumot olish
                    </li>
                    <li>
                        <a href="?setComands"><b>?setComands</b></a> - Configda kiritilgan barcha comandalarni o'rnatadi
                    </li>
                    <li>
                        <a href="?clearComands"><b>?clearComands</b></a> - Hamma comandalarni tozalash
                    </li>
                </ul>
                <h5>So'rovlar natijasi (JSON): </h5>

                <code>
                    <pre>
                        <?= $result ?: "Natijani ko'rish uchun kerakli tugmani bosing !";?>
                    </pre>
                </code>
                <a
                   class="attention-text"
                   href="https://www.youtube.com/watch?v=yNXmVukQIHY&list=PLmYtzpKf4ieqwj-NZNu2euI53tdz6Pd7r">
                    Natijalarni tahlil qilish boyicha qo'llanma
                </a>
            </div>
            <?php }; ?>
        </div>
        <div class="footer">Maked by <a href="http://www.youtube.com/c/infomiruz">Infomir.uz</a></div>
    </div>

</body>
</html>
