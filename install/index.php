<!doctype html>
<html lang="fa-IR">
<head>
    <meta charset="utf-8">
    <title>Raspina - Install</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=0.9, user-scalable=no" />
    <link rel="stylesheet" href="../backend/web/css/bootstrap.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        body {font-family: Tahoma; direction: rtl; font-size: 12px;}
        .input-box {}
        .input-box input{width: 100%; padding: 10px; border: 1px solid #cccccc; font-family: Tahoma; border-radius: 2px; margin-bottom: 20px}
        .input-box div{ margin-bottom: 6px;}
        .btn-primary {font-size: 12px;}
        .error {background: #d9534f; color: #ffffff; padding: 15px; margin-bottom: 25px; border-radius: 4px;}
        .success {background: #00a65a; color: #ffffff; padding: 15px; margin-bottom: 25px; border-radius: 4px;}
        .error a{color: #ffffff; font-weight: bold}
        .success a{color: #ffffff; font-weight: bold}
    </style>
</head>
<body>
<div class="container">
    <form action="" method="post">
    <div class="row col-lg-12">
        <br><br>
        <div class="col-lg-12">

        <?php
        if(isset($_POST['data']) && !empty($_POST['data']))
        {
            $data = $_POST['data'];
			
//            foreach ($data as $k => $v)
//            {
//				$v = trim($v); //
//                if(empty($v) && $k != 'db_password')
//                {
//                    echo '<div class="error">تمام فیلد ها اجباری هستند لطفا آنها را با دقت پر کنید. <a href="../install/">صفحه نصب رسپینا</a></div>';
//                    return false;
//                }
//
//                $data[$k] = trim($v);
//            }

            $len = mb_strlen($data['url']);
            $url = $data['url'];
            if($url[$len-1] != '/')
            {
                $data['url'] .= '/';
            }

//             db config
            try
            {
                $db = new PDO("{$data['dbms']}:host={$data['host']};dbname={$data['db_name']}",$data['db_username'],$data['db_password']);
            }
            catch (Exception $e)
            {
                $message = $e->getMessage();
                echo '<div class="error">به دلیل خطای زیر امکان اتصال به پایگاه داده وجود ندارد. <a href="../install/">صفحه نصب رسپینا</a></div>';
                echo '<div class="error" dir="ltr">' . $message . '</div>';
                return false;
            }

            $db_config = '<?php' . "\n";
            $db_config .= "define('DBMS','{$data['dbms']}');\n";
            $db_config .= "define('DB_HOST','{$data['host']}');\n";
            $db_config .= "define('DB_NAME','{$data['db_name']}');\n";
            $db_config .= "define('DB_USER_NAME','{$data['db_username']}');\n";
            $db_config .= "define('DB_PASSWORD','{$data['db_password']}');\n";
            try
            {
                file_put_contents('../common/config/db_config.php',$db_config);
            }
            catch (Exception $e)
            {
                $message = $e->getMessage();
                echo '<div class="error">به دلیل خطای زیر امکان ایجاد فایل db_config.php در مسیر common/config/  . <a href="/install">صفحه نصب رسپینا</a>وجود ندارد</div>';
                echo '<div class="error" dir="ltr">' . $message . '</div>';
                return false;
            }

            // run migrate
            $sql = file_get_contents('raspina.sql');
            $db->query($sql)->execute();

			/*
            $migrate = exec('php yii migrate --interactive=0 --migrationPath=@console/migrations');
            if($migrate != 'Migrated up successfully.')
            {
                echo '<div class="error">به دلیل خطای زیر جداول دیتابیس ایجاد نشده اند. <a href="../install/">صفحه نصب رسپینا</a></div>';
                echo '<div class="error" dir="ltr">' . $migrate . '</div>';
                return false;
            }
			*/
            // add user


            defined('YII_DEBUG') or define('YII_DEBUG', false);
            defined('YII_ENV') or define('YII_ENV', 'prod');
            defined('RASPINA_ENV') or define('RASPINA_ENV', 'prod');

            require('../vendor/autoload.php');
            require('../vendor/yiisoft/yii2/Yii.php');
            require('../common/config/bootstrap.php');
            require('../frontend/config/bootstrap.php');

            $config = yii\helpers\ArrayHelper::merge(
                require('../common/config/main.php'),
                require('../common/config/main-local.php'),
                require('../frontend/config/main.php'),
                require('../frontend/config/main-local.php')
            );
            $application = new yii\web\Application($config);

            $model = new \frontend\models\SignupForm();
//            $signupData = [
//                'username' => $data['username'],
//                'password' => $data['password'],
//                'email' => $data['email'],
//            ];
            if((trim($data['url'])) == 'http://www.')
            {
                echo '<div class="error">آدرس وبسایت وارد شده صحیح نیست</div>';
                return false;
            }

            if(mb_strlen(trim($data['username'])) < 4)
            {
                echo '<div class="error">نام کاربری حداقل باید 5 کاراکتر باشد</div>';
                return false;
            }

            if(mb_strlen(trim($data['password'])) < 5)
            {
                echo '<div class="error">کلمه عبور حداقل باید 6 کاراکتر باشد</div>';
                return false;
            }

            if(mb_strlen(trim($data['last_name'])) < 2 || mb_strlen(trim($data['surname'])) < 2)
            {
                echo '<div class="error">نام و نام خانوادگلی هر کدام حداقل باید 3 کاراکتر باشند</div>';
                return false;
            }

            if(!preg_match("/^[A-Za-z0-9\\.|-|_]*[@]{1}[A-Za-z0-9\\.|-|_]*[.]{1}[a-z]{2,5}$/",($data['email'])))
            {
                echo '<div class="error">ایمیل وارد شده معتبر نیست</div>';
                return false;
            }

            $user = $model->signup($data['username'],$data['password'],$data['email'],$data['last_name'],$data['surname']);
            if(empty($user->username))
            {
                echo '<div class="error">متاسفانه مشکلی در هنگام ایجاد حساب کاربری به وجود آمد، تمام محتوای دیتابیس را پاک کنید و از نو عملیات نصب را انجام دهید</div>';
                return false;
            }

            $link = new \backend\models\Link();
            $link->title = 'انجمن ایران پی اچ پی';
            $link->url = 'http://www.forum.iranphp.org/index.php';
            $link->save();

            $link2 = new \backend\models\Link();
            $link2->title = 'احسان رضایی - توسعه دهنده وب';
            $link2->url = 'http://www.developit.ir';
            $link2->save();

            $setting = new \backend\models\Setting();
            $setting->url = $data['url'];
            $setting->title = $data['title'];
            $setting->template = 'default';
            $setting->page_size = 20;
            $setting->date_format = 'HH:mm - yyyy/MM/dd';
            $setting->sult = substr(md5(time()),0,10);

            if(!$setting->save())
            {
                echo '<div class="error">متاسفانه مشکلی در هنگام ایجاد تنظیمات به وجود آمد، تمام محتوای دیتابیس را پاک کنید و از نو عملیات نصب را انجام دهید</div>';
                return false;
            }

            echo '<div class="success">عملیات نصب با موفقیت انجام شد. جهت حفظ امنیت سایت هر چه سریعتر پوشه ../install/ را از هاست خود حذف کنید. <a href="'.$data['url'].'">مشاهده وبسایت</a></div>';
            return false;
        }

        ?>
        </div>
        <div class="col-lg-12" style="margin: 0px auto">
            <div class="panel panel-default">
                <div class="panel-heading">بررسی نیازمندی ها</div>
                <div class="panel-body">
                    قبل از نصب لطفا
<a href="../requirements.php" target="_blank">نیازمندی های نرم افزار</a>
                     را مشاهده و بررسی کنید.
                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <br>
        <div class="col-lg-12" style="margin: 0px auto">
            <div class="panel panel-default">
                <div class="panel-heading">تنظیمات دیتابیس</div>
                <div class="panel-body">

                    <div class="input-box">
                        <div>سیستم مدیریت پایگاه داده</div>
                        <input type="text" name="data[dbms]" value="mysql" dir="ltr">
                    </div>

                    <div class="input-box">
                        <div>هاست</div>
                        <input type="text" name="data[host]" value="localhost" dir="ltr">
                    </div>

                    <div class="input-box">
                        <div>نام دیتابیس</div>
                        <input type="text" name="data[db_name]" value="" dir="ltr">
                    </div>

                    <div class="input-box">
                        <div>نام کاربری دیتابیس</div>
                        <input type="text" name="data[db_username]" value="" dir="ltr">
                    </div>

                    <div class="input-box">
                        <div>کلمه عبور دیتابیس</div>
                        <input type="password" name="data[db_password]" value="" dir="ltr">
                    </div>

                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <br>
        <div class="col-lg-12" style="margin: 0px auto">
            <div class="panel panel-default">
                <div class="panel-heading">تنظیمات وبسایت</div>
                <div class="panel-body">

                    <div class="input-box">
                        <div>آدرس وبسایت <span>به عنوان مثال: www.site.ir</span></div>
						<?php
							$url = 'http://www.' . $_SERVER['HTTP_HOST'] . '/';
							if($_SERVER['HTTP_HOST'] == 'localhost')
							{
								$url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
							}
						?>
                        <input type="text" name="data[url]" value="<?= $url ?>" dir="ltr">
                    </div>

                    <div class="input-box">
                        <div>عنوان وبسایت</div>
                        <input type="text" name="data[title]" value="">
                    </div>

                    <div class="input-box">
                        <div>نام (حداقل 3 کاراکتر)</div>
                        <input type="text" name="data[last_name]" value="">
                    </div>

                    <div class="input-box">
                        <div>نام خانوادگی(حداقل 3 کاراکتر)</div>
                        <input type="text" name="data[surname]" value="">
                    </div>

                    <div class="input-box">
                        <div>نام کاربری(جهت لاگین در پنل مدیریت، حداقل 5 کاراکتر)</div>
                        <input type="text" name="data[username]" value="" dir="ltr">
                    </div>

					<div class="input-box">
                        <div>کلمه عبور (<span>حداقل 6 کاراکتر، از کلمه های عبور ساده و قابل حدس استفاده نکنید</span>)</div>
                        <input type="password" name="data[password]" value="" dir="ltr">
                    </div>
					
                    <div class="input-box">
                        <div>آدرس ایمیل(<span>جهت بازیابی کلمه عبور آدرس ایمیل حقیقی خود را وارد کنید</span>)</div>
                        <input type="text" name="data[email]" value="" dir="ltr">

                    </div>

                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <br>
        <div class="col-lg-12" style="margin: 0px auto">
            <div class="panel panel-default">
                <div class="panel-heading">شرایط استفاده(قوانین و مقررات)</div>
                <div class="panel-body">
                    <div style="text-align: center; font-weight: bold;">متن حاضر متعلق به سیستم مدیریت محتوای رَسپینا می باشد و علاوه بر مفاد زیر بعنوان یک پروژه ایرانی، قوانین و مقررات جمهوری اسلامی ایران نیز بر آن حاکم است.</div><br>
                    <div style="">1) نباید اطلاعاتی را که دارای حساسیت می باشند برروی سایت قرار دهید و رَسپینا مسئولیتی درخصوص سوء استفاده از این اطلاعات را قبول نمی کنند.</div><br>
                    <div style="">2) مجاز به انتشار اطلاعات محرمانه مملکتی، اطلاعات محرمانه اشخاص ثالث، مطالب نفرت آمیز، ....، غیر اخلاقی و غیر قانونی در وبسایت خود نمی باشید.</div><br>
                    <div style="">3) رَسپینا تحت هیچ شرایطی مسئولیت خسارتهای وارده در اثر اعتماد و اتکا به اطلاعات قرار گرفته در وبسایت شما را نمی پذیرد.</div><br>
                    <div style="">4) رَسپینا یک نرم افزار جهت راه انداری وبلاگ یا وبسایت شماست و مسئولیت کامل مطالب و محتوای قرار داده شده در آن بر عهده صاحب آن وبلاگ یا وبسایت خواهد بود.</div><br>
                    <div style="">5) در صورتیکه کلمه عبور خود را فراموش نمودید با استفاده از لینک "فراموشی کلمه عبور" می توانید آنرا دریافت کنید و رَسپینا مسئولیتی در قبال ارسال این اطلاعات برای شما به طرق دیگر نخواهد داشت.</div><br>
                    <div style="">6) سرویس حاضر به همان شکلی که هست و بدون هر گونه تعهدی ارائه شده و در مورد قطع شدن خدمات، خالی از اشکال بودن آن، رفع اشکالات و یا تطابق آن با نیازهای شما تعهدی ندارد.</div><br>
                    <div style="">7) رَسپینا دارای قسمت پشتیبانی می باشد و تلاش خود را همواره جهت ارائه خدمات مطلوب می نماید ولیکن تعهدی نسبت به سرعت پاسخگوئی، عدم پاسخگوئی به سوالات و غیره ندارد.</div><br>
                    <div style="">8) رَسپینا تمامی تلاش خود جهت حفظ و صیانت از اطلاعات شما بعمل خواهد آورد ولیکن اگر چنانچه به هر دلیل بدون اطلاع و رضایت شما، اطلاعات شما توسط اشخاص ثالث مورد سوء استفاده و یا تخریب گردد رَسپینا مسئولیتی در مورد این اتفاقات نخواهد داشت.</div><br>
                    <div style="">9) مجاز به انتشار هیچ مفهوم و محتوایی که به حقوق انحصاری و تجاری افراد و حق چاپ و نشر (Copy Right) و سایر حقوق دیگران تجاوز نمایند، نمی باشید.</div><br>
                    <div style="">10) نظر به قانون حقوق مولفین و مصنفین عرضه غیر قانونی محصولات فرهنگی از جمله دانلود نمودن آلبوم های موسیقی بدون مجوز ناشر در سایت ممنوع است.</div><br>
                    <div style="">11) بیان عقاید مختلف با احترام به اصول فکری و اخلاقی دیگران و با پرهیز از توهین و فحاشی در وبلاگها مجاز می باشد.</div><br>
                    <div style="">12) بکار بردن کلمات و یا تصاویر خلاف شئونات اخلاقی و مذهبی ممنوع می باشد.</div><br>
                    <div style="">13) مطالب مستهجن، افترا آمیز، دشنام و خارج از اخلاق یا بی حرمتی به مقدسات فرهنگی و مذهبی در هیچ یک از وبلاگها مجاز نمی باشد.</div><br>
                    <div style="">14) بیان لطیفه هائی که منجر به اهانت به هم وطنان و یا اقشار خاص گردد و خلاف شئونات اخلاقی باشد مجاز نمی باشد.</div><br>
                    <div style="">15) پیشنهاد و یا تشویق به هر نوع فعالیت غیر قانونی مجاز نمی باشد.</div><br>
                    <div style="">16) قراردادن لینک به سایتهای غیر قانونی و غیر اخلاقی و مبتذل و همچنین سایتهائی که به اشکال مختلف روابط و رفتارهای فرهنگی و اخلاقی و عرفی و قانونی جامعه را پایمال نماید مجاز نمی باشد.</div><br>
                    <div style="">17) جعل هویت اشخاص حقیقی و یا حقوقی اعم از شرکتها، نهادها و سازمانها و نسبت دادن بیانات و سخنان دروغین به ایشان مجاز نمی باشد.</div><br>
                    <div style="">18) نصب رَسپینا به معنی مطالعه کامل شرایط استفاده(قوانین و مقررات) و قبول موارد آن می باشد.</div><br>
                    <div style="">19) رَسپینا متن باز و تحت مجوز GPL-3.0 منتشر شده است و هیچگونه مسئولیت و تعهدی در قبال نسخه های دیگر آن که توسط اشخاص دیگر تغییر، توسعه و در جایی به جز منبع اصلی رَسپینا منتشر شده است را ندارد.</div><br>
                    <div style="">20) منبع اصلی رَسپینا <a href="https://github.com/rezaei121/raspina" target="_blank">https://github.com/rezaei121/raspina</a> می باشد و باید این نرم افزار را از همین منبع دانلود و نصب کنید.</div><br>
                    <div style="text-align: center; font-weight: bold; color: #973634">در صورتی که با شرایط استفاده(قوانین و مقررات) مخالفت دارید،یعنی مجاز به استفاده از رَسپینا نیستید و باید سیستم مدیریت محتوای رَسپینا را از هاست شخصی خود پاک کنید.</div>
                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <br>
        <div class="col-lg-12" style="margin: 0px auto">
            <div class="panel panel-default">
                <div class="panel-heading">نصب رَسپینا</div>
                <div class="panel-body">
                <div style="text-align: center">ممکن است عملیات نصب کمی طول بکشد، لطفا شکیبا باشید</div><br>
                <div style="text-align: center"><button class="btn btn-primary">نصب</button></div>

                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <br>

        <br><br>
    </div>
    </form>
</div>


</body>
</html>
