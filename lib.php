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

function printHTMLHeader(string $HTMLPageTitle) {
    $bootstrapURL        = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css";
    //$javascriptURL       = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js";
    $javascriptBundleURL = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js";
    echo '<!doctype html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
    echo '<link rel="stylesheet" href="'.$bootstrapURL.'">';
    echo '<title>'.$HTMLPageTitle.'</title>';
    echo '<!-- Bootstrap CSS -->';
    
    echo '<script src="'.$javascriptBundleURL.'"></script>';
    echo '</head>';
}

function printHTMLBodyStart(string $PageTitle, string $LessonTitle="") {
    echo '<body>';
    echo '<h1>'.$PageTitle.'</h1>';
    echo '<h3>'.$LessonTitle.'</h3>';

}

function printHTMLFooter() {
    //$javascriptURL       = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js";
    $javascriptBundleURL = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js";
    
    echo '<!-- Bootstrap Bundle with Popper -->';
    //echo '<script src="'.$javascriptURL.'"></script>';
    echo '<script src="'.$javascriptBundleURL.'"></script>';
    echo '</body>';
    echo '</html>';
}


?>