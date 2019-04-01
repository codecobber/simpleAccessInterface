<?php
/*
Plugin Name: Hello World
Description: Echos "Hello World" in footer of theme
Version: 1.0
Author: Chris Cagle
Author URI: http://www.cagintranet.com/
*/

# get correct id for plugin
$thisfile=basename(__FILE__, ".php");

//Initiat Hooks
# activate filter
add_action('theme-footer','hello_world');

# add a link in the admin tab 'theme'
//@Params(within the plugins sidebar, create a side menu, (link to this file, use this text as title))
add_action( 'nav-tab', 'createNavTab', array( 'simple_access', $thisfile, 'Simple Access','overview' ) );
add_action('simple_access-sidebar', 'createSideMenu', array($thisfile, '<i class="fa fa-eye" aria-hidden="true"></i> Overview', 'overview'));
add_action('simple_access-sidebar', 'createSideMenu', array($thisfile, '<i class="fa fa-users" aria-hidden="true"></i> Edit perms', 'editperms'));
add_action('simple_access-sidebar', 'createSideMenu', array($thisfile, '<i class="fa fa-tag" aria-hidden="true"></i> Reset users perms', 'reset'));



# register plugin
register_plugin(
	$thisfile, //Plugin id
	'Hello World', 	//Plugin name
	'1.0', 		//Plugin version
	'Craig Adams',  //Plugin author
	'http://www.codecobber.co.uk/', //author website
	'Allows only certain pages to be viewed in admin based on user name', //Plugin description
	'simple_access', //page type - on which admin tab to display
	'simple_access_show'  //main function (administration) called immediately on activation of plugin
);

function makeList(){
	$jdata = array();

	$files = "../data/users/";
	$userFiles = scandir($files);

	foreach($userFiles as $ausr){
		if($ausr == "." || $ausr == ".."){
			continue;
		}
			//
			$name = str_ireplace(".xml","",$ausr);
			$user = array("id" => $name, "category" => $name);
			array_push($jdata,$user);
			echo $user['id']."<br>";
	}


	$jdata = json_encode($jdata,JSON_PRETTY_PRINT);
 	file_put_contents(GSDATAOTHERPATH."perms.json",$jdata);
}


function simple_access_show() {

	if(isset($_GET['overview'])){
		include(GSPLUGINPATH.'simpleAccess/overview.php');
	}
	elseif(isset($_GET['reset'])){
		makeList();
	}
	elseif(isset($_GET['editperms'])){
		include(GSPLUGINPATH.'simpleAccess/editperms.php');
	}

}

?>
