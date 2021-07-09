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

const MAINBACKGROUNDSTYLE = 'background: #FFE6E3';

function printHTMLHeader(string $HTMLPageTitle) {
    $bootstrapURL        = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css";
    $bootstrapIconURL    = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css";
    //$javascriptURL       = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js";
    $javascriptBundleURL = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js";
    echo '<!doctype html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
    echo '<link rel="stylesheet" href="'.$bootstrapURL.'">';
    echo '<link rel="stylesheet" href="'.$bootstrapIconURL.'">';
    echo '<title>'.$HTMLPageTitle.'</title>';
    echo '<!-- Bootstrap CSS -->';
    echo '<script src="'.$javascriptBundleURL.'"></script>';
    echo '</head>';
}

function printHTMLBodyStart(string $pageTitle, string $lessonTitle="") {
    echo '<body>';
    echo '<div class="container col-sm-11" style="'.MAINBACKGROUNDSTYLE.'">';
    echo '<div class="jumbotron py-3 px-lg-3">';
    echo '<div class="row justify-content-center">';
    echo '<h3 class="col-sm-8 display-4" style="font-size: 3.0em; text-align: center"><i class="bi bi-journal-check">'.$pageTitle.'</i></h1>';
    echo '</div>';//row
    echo '<br>';
    echo '<div class="row justify-content-center">';
    echo '<span class="btn rounded-pill lh-lg bg-secondary shadow-lg justify-content-center" pointer-event="none" aria-disabled="true">';
    echo '<p class="bg-secondary text-light lead" style="font-size: 1.6em; text-align: center">&nbsp;'.$lessonTitle.'&nbsp;</p>';
    echo '</span>';
    echo '</div>';//row
    echo '</div>';//jumbotron
}

function printHTMLFooter() {
    //$javascriptURL       = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js";
    $javascriptBundleURL = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js";
    echo '<!-- end of container -->';
    echo '</div>';
    echo '<!-- Bootstrap Bundle with Popper -->';
    //echo '<script src="'.$javascriptURL.'"></script>';
    echo '<script src="'.$javascriptBundleURL.'"></script>';
    echo '</body>';
    echo '</html>';
}

function printLogin() {
    echo '<form>';
    echo '<div class"row justify-content-center">';
    echo '<div class"col-md-3"></div>';
    echo '<div class"col-md">';
    echo '<label>Username:&nbsp;</label><input type="text" placeholder="username" /></div>';
    echo '<div class"col-md-3"></div>';
    echo '</div><br>';
    echo '<div class"row">';
    echo '<div class"col-md-3"></div>';
    echo '<div class"col-md">';
    echo '<label>Password:&nbsp;</label><input type="password" placeholder="password" /></div>';
    echo '</div><br>';
    echo '<div class"row justify-content-md-center">';
    echo '<div class"col-md-6"><input class="btn bg-primary text-light" type="submit" value="Log in"  /></div>';
    echo '</div></form>';
}

function printMenuCard(string $cardTitle, string $cardContent, string $lessonLink="#") {

    $cardColWidth = 2;
    
    //echo '<div class="row">';
    echo '<div class="col-lg-2 col-md-4 col-sm-6 card">';
    echo '<div class="card-body">';
    echo '  <h4 class="card-title">'.$cardTitle.'</h4>';
    echo '  <p class="card-text">'.$cardContent.'</p>';
    echo '  <a href="'.$lessonLink.'" class="card-link">Get started...</a>';
    //echo '</div>';//
    echo '</div>';//card-body
    echo '</div>';//card
    //echo '</div>';//row
}



?>
