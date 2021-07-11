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
 * lib.php - library file to produce common HTML parts
 */

include_once('constants.php');

function printHTMLHeader(string $HTMLPageTitle) {
    $bootstrapURL        = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css";
    $bootstrapIconURL    = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css";
    //$javascriptURL       = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js";
    $javascriptBundleURL = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js";
    println('<!doctype html>');
    println('<html lang="en">');
    println('<head>');
    println('<meta charset="utf-8">');
    println('<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">');
    println('<link rel="stylesheet" href="'.$bootstrapURL.'">');
    println('<link rel="stylesheet" href="'.$bootstrapIconURL.'">');
    println('<title>'.$HTMLPageTitle.'</title>');
    println('<!-- Bootstrap CSS -->');
    println('<script src="'.$javascriptBundleURL.'"></script>');
    println('</head>');
}

function printHTMLBodyStart(string $pageTitle, string $lessonTitle="") {
    println('<body>');
    println('<div class="container col-sm-11" style="'.MAINBACKGROUNDSTYLE.'">');
    println('<div class="jumbotron py-3 px-lg-3">');
    println('<div class="row justify-content-center">');
    println('<h3 class="col-sm-8 display-4" style="font-size: 3.0em; text-align: center"><i class="bi bi-journal-check">'.$pageTitle.'</i></h1>');
    println('</div>');//row
    println('<br>');
    println('<div class="row justify-content-center">');
    println('<span class="btn rounded-pill lh-lg bg-secondary shadow-lg justify-content-center" pointer-event="none" aria-disabled="true">');
    println('<p class="bg-secondary text-light lead" style="font-size: 1.6em; text-align: center">&nbsp;'.$lessonTitle.'&nbsp;</p>');
    println('</span>');
    println('</div>');//row
    println('</div>');//jumbotron
}

function printHTMLFooter() {
    //$javascriptURL       = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js";
    $javascriptBundleURL = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js";
    println('<!-- end of container -->');
    println('</div>');
    println('<!-- Bootstrap Bundle with Popper -->');
    //println('<script src="'.$javascriptURL.'"></script>');
    println('<script src="'.$javascriptBundleURL.'"></script>');
    println('</body>');
    println('</html>');
}

function printLogin() {
    println('<form id="login" method="post">');
    println('<input type="hidden" name="Screen" value="'.SCREENMAINMENU.'"></td></tr>');
    println('<div class"row justify-content-center">');
    println('<div class"col-md-3"></div>');
    println('<div class"col-md">');
    println('<label>Username:&nbsp;</label><input type="text" placeholder="username" /></div>');
    println('<div class"col-md-3"></div>');
    println('</div><br>');
    println('<div class"row">');
    println('<div class"col-md-3"></div>');
    println('<div class"col-md">');
    println('<label>Password:&nbsp;</label><input type="password" placeholder="password" /></div>');
    println('</div><br>');
    println('<div class"row justify-content-md-center">');
    println('<div class"col-md-6"><input class="btn bg-primary text-light" type="submit" name="login" value="Log in"  /></div>');
    println('</div></form>');
}

function printMenuCard(string $cardTitle, string $cardContent, string $lessonLink="#") {

    $cardColWidth = 2;
    
    //println('<div class="row">');
    println('<div class="col-lg-2 col-md-4 col-sm-6 card">');
    println('<div class="card-body">');
    println('  <h4 class="card-title">'.$cardTitle.'</h4>');
    println('  <p class="card-text">'.$cardContent.'</p>');
    println('  <a href="'.$lessonLink.'" class="btn card-link"><i class="bi bi-arrow-right-circle-fill"></i></a>');
    //println('</div>');//
    println('</div>');//card-body
    println('</div>');//card
    //println('</div>');//row
}

function println(string $string) {
    print($string.PHP_EOL);
}

?>
