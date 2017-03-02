<!doctype html>
<html lang="fa-IR">
<head>
    <meta charset="utf-8">
    <title>Raspina - Install</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=0.9, user-scalable=no" />
    <link rel="stylesheet" href="../backend/web/css/bootstrap.min.css">
    <link rel="stylesheet" href="../backend/web/css/font-awesome.min.css">
    <link rel="stylesheet" href="../backend/web/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/install.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="../backend/web/js/jquery-2.2.3.min.js"></script>
    <script src="../backend/web/js/bootstrap.min.js"></script>
    <script src="assets/js/install.js"></script>
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
                echo '<div class="error" dir="ltr">' . $message . '</div>';
                echo '<div class="info-box"><a href="../install/">Install Page</a></div>';
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
                echo '<div class="error">can not create db_config.php file to common/config/</div>';
                echo '<div class="error" dir="ltr">' . $message . '</div>';
                echo '<div class="info-box"><a href="../install/">Install Page</a></div>';
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

            $model = new \common\models\SignupForm();
//            $signupData = [
//                'username' => $data['username'],
//                'password' => $data['password'],
//                'email' => $data['email'],
//            ];
            if((trim($data['url'])) == 'http://www.')
            {
                echo '<div class="error">url not valid</div>';
                return false;
            }

            if(mb_strlen(trim($data['username'])) < 4)
            {
                echo '<div class="error">username must least 3 character</div>';
                return false;
            }

            if(mb_strlen(trim($data['password'])) < 5)
            {
                echo '<div class="error">password must least 6 character</div>';
                return false;
            }

            if(mb_strlen(trim($data['last_name'])) < 2 || mb_strlen(trim($data['surname'])) < 2)
            {
                echo '<div class="error">name or last name must least 3 character</div>';
                return false;
            }

            if(!preg_match("/^[A-Za-z0-9\\.|-|_]*[@]{1}[A-Za-z0-9\\.|-|_]*[.]{1}[a-z]{2,5}$/",($data['email'])))
            {
                echo '<div class="error">email not valid</div>';
                return false;
            }

            $user = $model->signup($data['username'],$data['password'],$data['email'],$data['last_name'],$data['surname']);
            if(empty($user->username))
            {
                echo '<div class="error">sorry there was a problem when creating an account, all tables database to delete and re-do the installation</div>';
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
                echo '<div class="error">sorry there was a problem when creating settings, all tables database to delete and re-do the installation</div>';
                return false;
            }

            echo '<div class="success">The installation has been completed successfully. In order to secure the site as soon as possible remove folders ../install/ from your host. <a href="'.$data['url'].'">view blog</a></div>';
            return false;
        }

        ?>
        </div>
        <div class="col-lg-12" style="margin: 0px auto">
            <div class="panel panel-default">
                <div class="panel-heading shadow"><h3>1) Raspina Application Requirement Checker</h3></div>
                <div class="panel-body">
                    <?php
                    require_once(dirname(__FILE__) . '/requirements/YiiRequirementChecker.php');
                    $requirementsChecker = new YiiRequirementChecker();

                    $gdMemo = $imagickMemo = 'Either GD PHP extension with FreeType support or ImageMagick PHP extension with PNG support is required for image CAPTCHA.';
                    $gdOK = $imagickOK = false;

                    if (extension_loaded('imagick')) {
                        $imagick = new Imagick();
                        $imagickFormats = $imagick->queryFormats('PNG');
                        if (in_array('PNG', $imagickFormats)) {
                            $imagickOK = true;
                        } else {
                            $imagickMemo = 'Imagick extension should be installed with PNG support in order to be used for image CAPTCHA.';
                        }
                    }

                    if (extension_loaded('gd')) {
                        $gdInfo = gd_info();
                        if (!empty($gdInfo['FreeType Support'])) {
                            $gdOK = true;
                        } else {
                            $gdMemo = 'GD extension should be installed with FreeType support in order to be used for image CAPTCHA.';
                        }
                    }

                    /**
                     * Adjust requirements according to your application specifics.
                     */
                    $requirements = array(
                        // Database :
                        array(
                            'name' => 'PDO extension',
                            'mandatory' => true,
                            'condition' => extension_loaded('pdo'),
                            'by' => 'All DB-related classes',
                        ),
                        array(
                            'name' => 'PDO SQLite extension',
                            'mandatory' => false,
                            'condition' => extension_loaded('pdo_sqlite'),
                            'by' => 'All DB-related classes',
                            'memo' => 'Required for SQLite database.',
                        ),
                        array(
                            'name' => 'PDO MySQL extension',
                            'mandatory' => false,
                            'condition' => extension_loaded('pdo_mysql'),
                            'by' => 'All DB-related classes',
                            'memo' => 'Required for MySQL database.',
                        ),
                        array(
                            'name' => 'PDO PostgreSQL extension',
                            'mandatory' => false,
                            'condition' => extension_loaded('pdo_pgsql'),
                            'by' => 'All DB-related classes',
                            'memo' => 'Required for PostgreSQL database.',
                        ),
                        // Cache :
                        array(
                            'name' => 'Memcache extension',
                            'mandatory' => false,
                            'condition' => extension_loaded('memcache') || extension_loaded('memcached'),
                            'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-caching-memcache.html">MemCache</a>',
                            'memo' => extension_loaded('memcached') ? 'To use memcached set <a href="http://www.yiiframework.com/doc-2.0/yii-caching-memcache.html#$useMemcached-detail">MemCache::useMemcached</a> to <code>true</code>.' : ''
                        ),
                        array(
                            'name' => 'APC extension',
                            'mandatory' => false,
                            'condition' => extension_loaded('apc'),
                            'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-caching-apccache.html">ApcCache</a>',
                        ),
                        // CAPTCHA:
                        array(
                            'name' => 'GD PHP extension with FreeType support',
                            'mandatory' => false,
                            'condition' => $gdOK,
                            'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
                            'memo' => $gdMemo,
                        ),
                        array(
                            'name' => 'ImageMagick PHP extension with PNG support',
                            'mandatory' => false,
                            'condition' => $imagickOK,
                            'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
                            'memo' => $imagickMemo,
                        ),
                        // PHP ini :
                        'phpExposePhp' => array(
                            'name' => 'Expose PHP',
                            'mandatory' => false,
                            'condition' => $requirementsChecker->checkPhpIniOff("expose_php"),
                            'by' => 'Security reasons',
                            'memo' => '"expose_php" should be disabled at php.ini',
                        ),
                        'phpAllowUrlInclude' => array(
                            'name' => 'PHP allow url include',
                            'mandatory' => false,
                            'condition' => $requirementsChecker->checkPhpIniOff("allow_url_include"),
                            'by' => 'Security reasons',
                            'memo' => '"allow_url_include" should be disabled at php.ini',
                        ),
                        'phpSmtp' => array(
                            'name' => 'PHP mail SMTP',
                            'mandatory' => false,
                            'condition' => strlen(ini_get('SMTP')) > 0,
                            'by' => 'Email sending',
                            'memo' => 'PHP mail SMTP server required',
                        ),
                        'phpIntl' => array(
                            'name' => 'PHP Intl Date Formatter',
                            'mandatory' => true,
                            'condition' => extension_loaded('intl'),
                            'by' => 'Date Formatter',
                            'memo' => '"php_intl" should be disabled at php.ini',
                        ),
                        'mod_rewrite' => array(
                            'name' => 'Rewrite Mode',
                            'mandatory' => true,
                            'condition' => in_array('mod_rewrite', apache_get_modules()),
                            'by' => 'Url',
                            'memo' => '"mod_rewrite" should be disabled',
                        ),
                    );
                    $requirementsChecker->checkYii()->check($requirements)->render();
                    ?>
                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <br>
        <div class="col-lg-12" style="margin: 0px auto">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>2) DB Config</h3></div>
                <div class="panel-body">

                    <div class="input-box">
                        <div>database management system</div>
                        <input type="text" name="data[dbms]" value="mysql" dir="ltr" readonly="readonly">
                    </div>

                    <div class="input-box">
                        <div>host</div>
                        <input type="text" name="data[host]" value="localhost" dir="ltr">
                    </div>

                    <div class="input-box">
                        <div>database name</div>
                        <input type="text" name="data[db_name]" value="" dir="ltr">
                    </div>

                    <div class="input-box">
                        <div>database username</div>
                        <input type="text" name="data[db_username]" value="" dir="ltr">
                    </div>

                    <div class="input-box">
                        <div>database password</div>
                        <input type="password" name="data[db_password]" value="" dir="ltr">
                    </div>

                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <br>
        <div class="col-lg-12" style="margin: 0px auto">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>3) Blog Settings</h3></div>
                <div class="panel-body">

                    <div class="input-box">
                        <div>url, for example: www.myblog.mydomain</div>
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
                        <div>title</div>
                        <input type="text" name="data[title]" value="">
                    </div>

                    <div class="input-box">
                        <div>your name, least 3 character</div>
                        <input type="text" name="data[last_name]" value="">
                    </div>

                    <div class="input-box">
                        <div>your last name, least 3 character</div>
                        <input type="text" name="data[surname]" value="">
                    </div>

                    <div class="input-box">
                        <div>username, least 5 character</div>
                        <input type="text" name="data[username]" value="" dir="ltr">
                    </div>

					<div class="input-box">
                        <div>password, least 5 character</div>
                        <input type="password" name="data[password]" value="" dir="ltr">
                    </div>
					
                    <div class="input-box">
                        <div>email</div>
                        <input type="text" name="data[email]" value="" dir="ltr">

                    </div>

                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <br>
        <div class="col-lg-12" style="margin: 0px auto">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>4) Privacy Policy And Terms of Service</h3></div>
                <div class="panel-body rtl">
                    <div style="">1) رَسپینا یک نرم افزار جهت راه انداری وبلاگ یا وبسایت است و مسئولیت کامل مطالب و محتوای قرار داده شده در آن بر عهده صاحب آن وبلاگ یا وبسایت خواهد بود.</div><br>
                    <div style="">2) رَسپینا تحت هیچ شرایطی مسئولیت خسارتهای وارده در اثر اعتماد و اتکا به اطلاعات قرار گرفته در وبسایت شما را نمی پذیرد.</div><br>
                    <div style="">3) در صورتیکه کلمه عبور خود را فراموش نمودید با استفاده از لینک "فراموشی کلمه عبور" می توانید آنرا دریافت کنید و رَسپینا مسئولیتی در قبال ارسال این اطلاعات برای شما به طرق دیگر نخواهد داشت.</div><br>
                    <div style="">4) سرویس حاضر به همان شکلی که هست و بدون هر گونه تعهدی ارائه شده و در مورد قطع شدن خدمات، خالی از اشکال بودن آن، رفع اشکالات و یا تطابق آن با نیازهای شما تعهدی ندارد.</div><br>
                    <div style="">5) رَسپینا دارای قسمت پشتیبانی می باشد و تلاش خود را همواره جهت ارائه خدمات مطلوب می نماید ولیکن تعهدی نسبت به سرعت پاسخگوئی، عدم پاسخگوئی به سوالات و غیره ندارد.</div><br>
                    <div style="">6) رَسپینا تمامی تلاش خود جهت حفظ و صیانت از اطلاعات شما بعمل خواهد آورد ولیکن اگر چنانچه به هر دلیل بدون اطلاع و رضایت شما، اطلاعات شما توسط اشخاص ثالث مورد سوء استفاده و یا تخریب گردد رَسپینا مسئولیتی در مورد این اتفاقات نخواهد داشت.</div><br>
                    <div style="">7) نصب رَسپینا به معنی مطالعه کامل Privacy Policy And Terms of Service و قبول موارد آن می باشد.</div><br>
                    <div style="">8) رَسپینا متن باز و تحت مجوز GPL-3.0 منتشر شده است و هیچگونه مسئولیت و تعهدی در قبال نسخه های دیگر آن که توسط اشخاص دیگر تغییر، توسعه و در جایی به جز منبع اصلی رَسپینا منتشر شده است را ندارد.</div><br>
                    <div style="">9) منبع اصلی رَسپینا <a href="https://github.com/rezaei121/raspina" target="_blank">https://github.com/rezaei121/raspina</a> می باشد و باید این نرم افزار را از همین منبع دانلود و نصب کنید.</div><br>
                    <div style="text-align: center; font-weight: bold; color: #973634">در صورتی که با Privacy Policy And Terms of Service مخالفت دارید،یعنی مجاز به استفاده از رَسپینا نیستید و باید سیستم مدیریت محتوای رَسپینا را از هاست شخصی خود پاک کنید.</div>
                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <br>
        <div class="col-lg-12" style="margin: 0px auto">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>5) Install</h3></div>
                <div class="panel-body">
                <div style="text-align: center"><button class="btn btn-primary btn-lg">Install</button></div>

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
