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
include_once('constants.php');

if (ISSET($_REQUEST['screen'])) $screen=$_REQUEST['screen']; //if POST screen parameter, set to that.
else $screen=SCREENLOGIN; //if no POST screen parameter, set to login page

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
if(isLoginAttempt()) {
    if(authenticateValidCredentials($_POST['username'], $_POST['password'])) {
        $screen=SCREENMAINMENU;
	} else {//login failed
        $screen=SCREENLOGIN;
    }
} else if ($screen==SCREENEXIT) {
	session_unset();
	session_destroy();
	$screen = SCREENLOGIN;
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

function isLoginAttempt() {
    return ISSET($_POST['username']) && ISSET($_POST['password']);
}

function isSessionValid() {
    return ((session_status()==PHP_SESSION_ACTIVE) 
            && ISSET($_SESSION['valid'])
            && $_SESSION['valid']);
}
