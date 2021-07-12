<?php
/**
 * Quick Lesson
 * @copyright  2021 Brad Pasley <brad.pasley@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

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
include_once('database.php');

printHTMLHeader(SITENAME);
printHTMLBodyStart(SITENAME, LESSONNAME);
 
if(!isSessionValid()) {
    printLogin();
    if(isLoginAttempt()) { //if login attempted but session not valid
        println('<p class="text-danger">username/password incorrect.</p>');
    }
} else {//authenticated user & session valid
    //println("<h3>CHECK Screen: $screen</h3>");
    $quickDatabase = new QuickDatabase();
    switch($screen) {
        case SCREENMAINMENU:
            println('<div class="row">');
            printMenuCard("Consonants", "Learn how to identify and say the Korean consonants.", SCREENMODULE, 1, 1);
            printMenuCard("Vowels", "Learn how to identify and say the Korean vowels.", SCREENMODULE, 1, 2);
            printMenuCard("Review", "Get a summary of the key points.", SCREENREVIEW, 1, 1); //need to add module list  screen if moduleid left blank
            printMenuCard("Quizzes", "Check what you've learnt.", SCREENQUIZ, 1, 1);   //need to add module list  screen if moduleid left blank
            printMenuCard("Account", "Change your username or password.", SCREENACCOUNTEDIT); //need to add
            printMenuCard("Logout", "Exit ".SITENAME.".", SCREENEXIT); //need to add
            println('</div>');
            break;
        case SCREENMODULE:
            //println('<h4>screen module...</h4>');
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=0) {
                $moduleID = $_POST['moduleID'];
                //println('<h4>module id: '.$moduleID.'</h4>');
                //main menu of Module
                printModulePage($moduleID);
            }
            break;
        case SCREENMODULECONCEPT:
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=0) {
                if(isset($_POST['conceptID']) && $_POST['conceptID']!=0) {//concept screen of module
                    $moduleID = $_POST['moduleID'];
                    $conceptID = $_POST['conceptID'];
                    printModulePage($moduleID, $conceptID);
                } else {//main menu of Module
                    printModulePage($moduleID);
                }
            }
            break;
        case SCREENREVIEW:
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=0) {
                $moduleID = $_POST['moduleID'];
                //main menu of Review
                printReviewPage($moduleID);
            }
            break;
        case SCREENREVIEWCONCEPT:
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=0) {
                if(isset($_POST['conceptID']) && $_POST['conceptID']!=0) {//concept screen of module
                    $moduleID = $_POST['moduleID'];
                    $conceptID = $_POST['conceptID'];
                    printReviewPage($moduleID, $conceptID);
                } else {//main menu of Module
                    printReviewPage($moduleID);
                }
            }
            break;
        case SCREENQUIZ:
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=0) {
                $moduleID = $_POST['moduleID'];
                //main menu of Quiz
                printQuizPage($moduleID);
            }
            break;
        case SCREENQUIZCONCEPT:
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=0) {
                if(isset($_POST['conceptID']) && $_POST['conceptID']!=0) {//concept screen of module
                    $moduleID = $_POST['moduleID'];
                    $conceptID = $_POST['conceptID'];
                    printQuizPage($moduleID, $conceptID);
                } else {//main menu of Module
                    printQuizPage($moduleID);
                }
            }
            break;
        default:
            printLogin();
    }
}
printHTMLFooter();
?>
