<?php
/*
 * PHPSocial installer
 *
 */

error_reporting(E_ALL ^ E_NOTICE);

/*
 * Main installer function
 * 
 */
function installMain() {
	$mysqlConnection = false;
	$dbOptions = _setDbConnectionVars();
	$output = _createHeaderHtml();
	$installStep = _checkStep();

	switch ($installStep) {
		case 'step0' :
			$output .= _createStep0Html();
		break;
		case 'step1' :
			$dbOptions = _checkDbOptions($dbOptions);

			$dbOptions['license'] = $_POST['license'];
			if(isset($_POST['additional']) && $_POST['additional'] == 'connect') {
				$mysqlConnection = _checkConnection($dbOptions);
			}

			$output .= _createStep1Html($dbOptions, $mysqlConnection);
		break;
		case 'step2' :
			$output .= _createStep2Html();
		break;
		case 'finalize' :
			include "./include/Config.php";
			include "./include/Database.class.php";
			$generatedPassword = _generateRandomKeys(15);
			$adminPasswordHash = crypt($generatedPassword, "$4admin"."admin$4"."4$4");
			$database = new PHPS_Database($databaseHost, $databaseUsername, $databasePassword, $databaseName);
			require_once("InstallDatabase.php");
			$output .= _createStepFinalHtml($generatedPassword);
		break;
	}
	$output .= _createFooterHtml();
	echo $output;
}

/**
 * Check the connection to mysql server and if connection
 *
 * Successfull put the correct data into the system's
 * Config file and returns success in other cases - returns error code.
 *
 * @param array $dbOptions
 * @return string
 */
function _checkConnection($dbOptions) {
	$mysqlConnect = @mysql_connect($dbOptions['mysqlHost'], $dbOptions['mysqlUser'], $dbOptions['mysqlPass']);
	$mysqlSelect = @mysql_select_db($dbOptions['mysqlDb']);
	if(!$mysqlConnect) {
		return 'error_connect';
	}
	elseif (!$mysqlSelect) {
		return 'error_select';
	}


    require_once 'include/License.class.php';
    $lic = new License($_SERVER['SERVER_NAME']);
    $lic->setLicFilePath("include/");
    $lic->acceptLicense($_POST['license']);
//


    if (!$lic->check()){
        return 'error_license';
    }

	$configPath = './include/Config.php';
	$configContent = "<?php\n\$databaseHost = '" . $dbOptions['mysqlHost'] . "';\n\$databaseUsername = '" . $dbOptions['mysqlUser'] . "';\n\$databasePassword = '" . $dbOptions['mysqlPass'] . "';\n\$databaseName = '" . $dbOptions['mysqlDb'] . "';\n\$path2Phps = '".$dbOptions['path2Phps']."';\n\$baseurl = '".$dbOptions['baseurl']."';?>";
	if(!file_put_contents($configPath, $configContent)) {
		return 'error_config';
	}
	return 'success';
}

/**
 * Function that checks current installer step.
 *
 * @return string
 */
function _checkStep() {
	if(isset($_POST['step'])) {
		return $_POST['step'];
	}
	elseif(isset($_GET['step'])) {
		return $_GET['step'];
	}
	return "step0";
}

/**
 * Check if user provide database connetction settings. If yes - fill database connection array
 *
 * @return array
 */
function _checkDbOptions() {
	if(isset($_POST['mysqlHost']) && isset($_POST['mysqlDb']) && isset($_POST['mysqlUser']) && isset ($_POST['mysqlPass'])) {
		return _setDbConnectionVars($_POST['mysqlHost'], $_POST['mysqlDb'], $_POST['mysqlUser'], $_POST['mysqlPass']);
	}
	return _setDbConnectionVars();
}

/**
 * Fill data base connection array
 *
 * @param string $host
 * @param string $db
 * @param string $user
 * @param string $password
 * @return array
 */
function _setDbConnectionVars($host = 'localhost', $db = '', $user = '', $password = '') {
	return array(
		'mysqlHost' => $host,
		'mysqlDb'   => $db,
		'mysqlUser' => $user,
		'mysqlPass' => $password,
		'path2Phps' => $_POST['path2Phps'],
		'baseurl' => $_POST['baseurl']
	);
}

/**
 * Generates keys for random password
 *
 * @param integer $length
 * @return string
 */
function _generateRandomKeys($length) {
    $pattern = "123456789abcdefghijklmnopqrstuvwxyz";
    $key  = $pattern{rand(0,36)};
    for($i=1; $i < $length; $i++)
    {
        $key .= $pattern{rand(0,36)};
    }
    return $key;
  }

/**
 * Creates main header html for output
 *
 * @return string
 */
function _createHeaderHtml() {
	$header = "
		<html>
			<head>
				<title>Install PHPSocial</title>
				<style type='text/css'>
					body, td, div {
						font-family: \"Trebuchet MS\", tahoma, verdana, arial, serif;
						font-size: 10pt;
						color: #333333;
						line-height: 16pt;
					}
					h2 {
						font-size: 16pt;
						margin-bottom: 4px;
						color: #990000;
						text-align: center;
					}
					.box {
						padding: 10px 13px 10px 13px;
						border: 1px solid #990000;
						background-color: #eee;
					}
					ul {
						margin-top: 2px;
						margin-bottom: 2px;
					}
					input.text {
						font-family: \"Trebuchet MS\", tahoma, verdana, arial, serif;
					}
					input.button {
						background: #990000;
						font-weight: bold;
						padding: 2px;
						font-family: \"Trebuchet MS\", tahoma, verdana, arial, serif;
						border: 0px;
						color: #fff;
					}
					form {
						margin: 0px;
					}
					a:link { color: #2078C8; text-decoration: none; }
					a:visited { color: #2078C8; text-decoration: none; }
					a:hover { color: #3FA4FF; text-decoration: underline; }
			</style>
		</head>
		<body>
	";
	return $header;
}

/**
 * Creates main footer html for output
 *
 * @return string
 */
function _createFooterHtml() {
	$footer = "
			</body>
		</html>
	";
	return $footer;
}

/**
 * Create html for step 0
 *
 * @return string
 */
function _createStep0Html() {
	$html = "
		<h2>Install PHPSocial</h2>
		<div style=\"text-align: center; font-weight:bold; font-size: 15px; font-family: Verdana;\">Welcome to the PHPSocial installation program. Installing PHPSocial is easy! To get started, click the button below.</div>
		<br/>
		<div class='box'>
			<b>If you are installing PHPSocial yourself:</b>
			<br/>
			Before continuing, please be sure you have reviewed the installation instructions
			provided in install.html. If you are unfamiliar with how to upload files via FTP, setup MySQL databases, or set permissions on files, we suggest that you purchase our professional installation service instead. Most problems that arise post-installation happen because of an improper installation.
		</div>
		<br/>
		<div class='box'>
			<b>To install PHPSocial you will need:</b>
			<br/>
			<ul>
				<li>One MySQL database</li>
				<li>PHP 5.x </li>
				<li>PHP Safe Mode OFF</li>
				<li>GD Libaries 2.0 or newer</li>
			</ul>
			<b>For optional \"search engine friendly URLs\" you will need:</b>
			<br/>
			<ul>
				<li>Apache webserver with mod_rewrite (ability to use .htaccess files)</li>
			</ul>
		</div>
		<br/>
		<form action='Install.php' method='post'>
			<input type='submit' class='button' value='Continue &rarr;'>
			<input type='hidden' name='step' value='step1'>
		</form>
	";
	return $html;
}

/**
 * Create html for step 1
 *
 * @return string
 */
function _createStep1Html($dbOptions, $mysqlConnection = false) {
	$html = "
		<h2>Step 1: Connect to MySQL Database</h2>
			<div style=\"text-align: center; font-weight:bold; font-size: 15px; font-family: Verdana;\">Please provide your MySQL database login information in the fields below. If you do not yet have an available MySQL database, you can most likely create one by accessing your website's control panel (i.e. cPanel or Plesk) or by simply contacting your hosting provider.</div>
		<br/>
		<form action='Install.php' method='post'>
			<table cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td class='box' width='150' nowrap='nowrap'>
						<div style='margin-bottom: 10px;'>
							<b>MySQL Hostname</b><br>
							<input type='text' class='text' name='mysqlHost' size='30' value='" . $dbOptions['mysqlHost'] . "' />
						</div>
						<div style='margin-bottom: 10px;'>
							<b>MySQL Database Name</b><br>
							<input type='text' class='text' name='mysqlDb' size='30' value='" . $dbOptions['mysqlDb'] . "' />
						</div>
						<div style='margin-bottom: 10px;'>
							<b>MySQL Username</b><br>
							<input type='text' class='text' name='mysqlUser' size='30' value='" . $dbOptions['mysqlUser'] . "' />
						</div>
						<div>
							<b>MySQL Password</b><br>
							<input type='password' class='text' name='mysqlPass' size='30' value='" . $dbOptions['mysqlPass'] . "' />
						</div>
						<div>
							<b>Abs path</b><br>
							<input type='text' class='text' name='path2Phps' size='30' value='" . dirname(__FILE__) . "/' />
						</div>
						<div>
							<b>Site URL</b><br>
							<input type='text' class='text' name='baseurl' size='30' value='" . "http://".$_SERVER['SERVER_NAME'].str_replace("Install.php", "", $_SERVER['REQUEST_URI']) . "' />
						</div>
                      
						<div>
							<b>License</b><br>
							<input type='text' class='text' name='license' size='30' value='" . $dbOptions['license'] . "' />
						</div>
                     
				</td>
				<td align='center' valign='top' style='padding: 10px 30px 10px 30px;'>
					Please enter your MySQL information in the fields to the left, then click the button below to connect.
				<br/><br/>
	";
	if(!$mysqlConnection) {
		$html .= "
				<input type='submit' class='button' value='Connect to MySQL Server' />
				<input type='hidden' name='step' value='step1' />
				<input type='hidden' name='additional' value='connect' />
			</form>
		";
	}
	elseif($mysqlConnection == 'error_connect') {
		$html .= '
			<span style="color: #ff0000;">Failed to Connect to MySQL Server. Please check your connection information and try again.</span><br/>
			<input type="submit" class="button" value="Connect to MySQL Server" />
			<input type="hidden" name="step" value="step1" />
			<input type="hidden" name="additional" value="connect" />
			</form>
		';
	}
	elseif($mysqlConnection == 'error_license') {
		$html .= '
			<span style="color: #ff0000;">Wrong license number</span><br/>
			<input type="submit" class="button" value="Try again" />
			<input type="hidden" name="step" value="step1" />
			<input type="hidden" name="additional" value="connect" />
			</form>
		';
	}
	elseif($mysqlConnection == 'success') {
		$error = "<font color='#0AC92B'><b>Connection Successful</b></font><br>Click the button below to continue.<br><br><form action='Install.php' method='post'><input type='submit' class='button' value='Continue &rarr;'><input type='hidden' name='step' value='step2' /></form>";
	}
	$html .= 
			$error .
			"</td>
			</tr>
		</table>
	";
	return $html;
}

/**
 * Create html for step 2
 *
 * @return string
 */
function _createStep2Html() {
	$html = "
		<h2>Step 2: Finalize Installation</h2>
			<div style=\"text-align: center; font-weight:bold; font-size: 15px; font-family: Verdana;\">Now that your database is ready, we need to fill it with the appropriate tables and default data. Click the button below to complete your PHPSocial installation.</div>
		<br/>
		<div style=\"text-align: center;\">
			<form action='Install.php' method='post'>
				<input type='submit' class='button' value='Continue &rarr;'>
				<input type='hidden' name='step' value='finalize'>
			</form>
		</div>
	";
	return $html;
}

/**
 * Create html for step final
 *
 * @return string
 */
function _createStepFinalHtml($password) {
    $server_array = explode("/", $_SERVER['PHP_SELF']);
    $server_array_mod = array_pop($server_array);
    //$server_array_mod = array_pop($server_array);
    $server_info = implode("/", $server_array);
	$html = "
		<h2>Installation Complete</h2>
			<div style=\"text-align: center; font-weight:bold; font-size: 15px; font-family: Verdana;\">You have successfully completed the PHPSocial installation process. You can now login to your control panel with the information shown below. After logging in, you can begin changing the system settings to suit your needs.</div>
		<br/>
		<div class=\"box\">
			<ol>
				<li><b>Important: You must now delete \"Install.php\" and \"InstallDatabase.php\" from your server. Failing to delete these files is a serious security risk!</b></li>
				<li>After logging in to your control panel you should visit the \"View Admins\" page and update your admin profile with your name and email address.
				<li>Next, you will most likely want to get started by creating profile fields. Profile fields allow you to decide what will appear on your users' profiles. For example, if you want to create a social network about fitness, you would create fields like \"height\", \"weight\", \"favorite exercise\", etc., while if you wanted to create a social network about business, you might create fields like \"employer\", \"position\", \"education\", and so forth.</li>
				<li>You will also probably want to adjust the signup settings. These settings determine what happens when users create accounts on your social network.</li>
				<li>Finally, you might be ready to add your own style or apply your website's header/footer wrapper to your social network. To accomplish this, visit the HTML Templates page in your control panel. You can also edit your template files by opening them directly from the \"/templates\" directory on your server. Your \"/templates\" directory should already be inaccessible to web users (an included .htaccess file takes care of this) if you're on a Apache server. If you're running Windows IIS or another server platform, you might want to move the \"/templates\" directory to another place on your server so that it's not accessible to web users. If you decide to do this, you will need to update \"/include/smarty/smarty.config.php\" with the new path to your templates directory.</li>
			</ol>
		</div>
		<br/>

        Add this text to your .htaccess file<br/>
        <textarea cols=\"100\" rows=\"10\">RewriteEngine On
Options +Followsymlinks
RewriteBase /
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^.* - [L,QSA]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^.*/images/(.*)$ ".$server_info."/images/$1 [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^.*/uploads_user/(.*)$ ".$server_info."/uploads_user/$1 [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^/]+)/?$ ".$server_info."/Profile.php?user=$1 [L]</textarea>
		
		<br/><br/><table cellpadding='0' cellspacing='0' align='center'>
			<tr>
				<td class='box'>
					<table cellpadding='0' cellspacing='0'>
						<tr>
							<td align='right'><b>Username: &nbsp;</td>
							<td>admin</td>
						</tr>
						<tr>
							<td align='right'><b>Password: &nbsp;</td>
							<td>$password</td>
						</tr>
					</table>
				 </td>
			</tr>
		</table>
		<br/>

		<div style='text-align: center; font-weight: bold;'>
			[ <a href='./admin/AdminLogin.php' target='_blank'>Login to Control Panel</a> ]
		</div>
	";
	return $html;
}



//installer entry point
installMain();
