<?php
/**
 * Quick Lesson is a dynamic webpage which produces a quick training
 * The sample teaching content will be the Korean alphabet, and each character's pronunciation
 * 
 * by Brad Pasley 2021
 * 
 * Flow:
 * 1. Login
 * a) Register new account
 * b) Login
 * C) Forgot Password
 * 2. Main Menu
 * a) Modules - Consonants, Vowels
 * b) Quizzes - Consonants, Vowels
 * c) Review
 * d) Account - Change Email, Change Password, Log out
 * 3. Module
 * 4. Quiz
 * 5. Review
 * 6. Logout 
 * 
 * auth.php - authentication file to provide a session and verify a user.
 */

session_start();
//include("rollover_conf.php");

//now the page contents

const SCREENLOGIN = 0;
const SCREENMAINMENU = 10;
const SCREENMODULE = 20;
const SCREENMODULECONCEPT = 25;
const SCREENREVIEW = 30;
const SCREENQUIZ = 40;
const SCREENEXIT = -100;

if (!ISSET($Screen) ) $Screen=SCREENLOGIN; //if no POST Screen parameter, set to login page
if (ISSET($_REQUEST['Screen'])) $Screen=$_REQUEST['Screen']; //if POST Screen parameter, set to that.

//if last update was more than 30 minutes, destroy the session
if(ISSET($_SESSION['last_activity']) && $_SESSION['last_activity'] + 30 * 60 < time()) { 
	session_unset();
	session_destroy();
} else { //otherwise update the last time to now
	if(ISSET($_SESSION['last_activity'])) {
		$_SESSION['last_activity'] = time();
	}
}

//establish session if credentials provided
$valid_session = false;
if(ISSET($_POST['username']) && ISSET($_POST['password'])) {
	if(checkCredentials($_POST['username'], $_POST['password'])) {
        $Screen=SCREENMAINMENU;
	}
} else if ($Screen==SCREENEXIT) {
	session_unset();
	session_destroy();
	$Screen = $SCREENLOGIN;
}

function authenticateValidCredentials(string $username, $password) {
    $test_uid = "test.username";
    $test_pid = "test.password";
    if($username==$test_uid && $password==$test_pid) {
		$_SESSION['valid'] = true;
		$_SESSION['last_activity'] = time();
        return true;
    } else {
        return false;
    }
}

function isSessionValid() {
    return ((session_status()==PHP_SESSION_ACTIVE) 
            && ISSET($_SESSION['valid'])
            && $_SESSION['valid']);
}
