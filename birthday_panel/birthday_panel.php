<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright � 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: birthday_panel.php
| Author: Stephan Hansson (StarglowOne) & Unknown Author
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."birthday_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."birthday_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."birthday_panel/locale/English.php";
}

$result=dbquery("SELECT user_id, user_name, user_avatar,
	DATE_FORMAT(user_birthdate, '%d') AS birth_day, 
	EXTRACT(MONTH FROM user_birthdate) AS birth_month 
	FROM ".DB_USERS." 
	WHERE (EXTRACT(MONTH FROM user_birthdate)=EXTRACT(MONTH FROM NOW()) 
	AND EXTRACT(DAY FROM user_birthdate)=EXTRACT(DAY FROM NOW()) AND user_status = 0) 
	ORDER BY birth_month , birth_day LIMIT 0,15"
);

$rows = dbrows($result);
if ($rows != 0) {
	@openside($locale['bdp_title']);
	echo "<div align='center'><img border='0' src='".INFUSIONS."birthday_panel/images/cookie.png' alt='".$locale['bdp_title']."' />\n";
	echo "</div />\n";
	echo "<div />\n";
	echo "<hr />\n";
	if(dbrows($result)!=0) {
		while($data=dbarray($result)) {
			if(!empty($data['user_avatar'])) {
				$avatar = "<img src='".IMAGES."avatars/".$data['user_avatar']."' alt='".$data['user_name']."' border='0' width='50' height='50'>\n";
			} else {
				$avatar = "<img src='".IMAGES."news_cats/blank.gif' border='0' width='0' height='0' />\n";
			}
			echo "".THEME_BULLET." <a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'>".$data['user_name']."</a><br />\n";
		}
	}
	echo "</div>\n";
	@closeside();
} else {
	openside($locale['bdp_001']);
	echo "<div>\n";
	echo $locale['bdp_002'] . "\n";
	echo "</div>\n";
	closeside();
}
?>