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
 * index.php - main page
 */

include_once('constants.php');
include('auth.php');
include('lib.php');

 printHTMLHeader(SITENAME);
 printHTMLBodyStart(SITENAME, LESSONNAME);
 
 if(!isSessionValid()) {
    printLogin();
    if(isLoginAttempt()) { //if login attempted but session not valid
        println('<p class="text-danger">username/password incorrect.</p>');
    }
 } else {//authenticated user & session valid
    println("<h3>Screen: $Screen</h3>");
    switch($Screen) {
        case SCREENMAINMENU:
            println('<div class="row">');
            printMenuCard("Consonants", "Learn how to identify and say the Korean consonants.", SCREENMODULE, 1);
            printMenuCard("Vowels", "Learn how to identify and say the Korean vowels.", SCREENMODULE, 2);
            printMenuCard("Review", "Get a summary of the key points.", SCREENREVIEW);
            printMenuCard("Quizzes", "Check what you've learnt.", SCREENQUIZ);
            printMenuCard("Account", "Change your username or password."); //need to add
            printMenuCard("Logout", "Exit ".SITENAME."."); //need to add
            println('</div>');
            break;
        case SCREENMODULE:
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=-1) {
                //main menu of Module
                printModulePage($moduleID);
            }
            break;
        case SCREENMODULECONCEPT:
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=-1) {
                if(isset($_POST['conceptID']) && $_POST['conceptID']!=-1) {//concept screen of module
                    $moduleID = $_POST['moduleID'];
                    $conceptID = $_POST['conceptID'];
                    printModulePage($moduleID, $conceptID);
                } else {//main menu of Module
                    printModulePage($moduleID);
                }
            }
            break;
        case SCREENREVIEW:
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=-1) {
                //main menu of Module
                printModulePage($moduleID);
            }
            break;
        case SCREENREVIEWCONCEPT:
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=-1) {
                if(isset($_POST['conceptID']) && $_POST['conceptID']!=-1) {//concept screen of module
                    $moduleID = $_POST['moduleID'];
                    $conceptID = $_POST['conceptID'];
                    printReviewPage($moduleID, $conceptID);
                } else {//main menu of Module
                    printReviewPage($moduleID);
                }
            }
            break;
        case SCREENQUIZ:
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=-1) {
                //main menu of Module
                printQuizPage($moduleID);
            }
            break;
        case SCREENQUIZCONCEPT:
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=-1) {
                if(isset($_POST['conceptID']) && $_POST['conceptID']!=-1) {//concept screen of module
                    $moduleID = $_POST['moduleID'];
                    $conceptID = $_POST['conceptID'];
                    printQuizPage($moduleID, $conceptID);
                } else {//main menu of Module
                    printQuizPage($moduleID);
                }
            }
            break;
    }
}
 printHTMLFooter();
 ?>
