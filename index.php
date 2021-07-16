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
 
if(!isSessionValid() || !isset($_POST['screen']) || $_POST['screen']=="") {
    printHTMLBodyStart(SITENAME); //print site heading without lesson title
    printLogin();
    if(isLoginAttempt()) { //if login attempted but session not valid
        println('<p class="text-danger">username/password incorrect.</p>');
    }
} else {//authenticated user & session valid
    $screen = $_REQUEST['screen'];
    $quickDatabase = new QuickDatabase();
    $lessonID = 0;
    $moduleID = 0;
    $conceptID = 0;

    //print website heading without or with lesson title depending on if it's the main menu or not
    if($screen==SCREENMAINMENU) {
        printHTMLBodyStart(SITENAME);
        println("<h3>CHECK Screen: $screen</h3>");
        println("<h4>CHECK post: ".var_dump($_POST)."</h4>"); 
    } else if(isset($_POST['lessonID']) && $_POST['lessonID']!=0) {
        $lessonID = $_POST['moduleID'];
        printHTMLBodyStart(SITENAME, $lessonID);
        println("<p>CHECK lessonid set? ".isset($_POST['lessonID'])."</p>");
        println("<p>CHECK lessonid value? ".$_POST['lessonID']."</p>");
        println("<h3>CHECK Screen: $screen</h3>");
        println("<h4>CHECK post: ".var_dump($_POST)."</h4>"); 
    } else { //default to non-lesson title menu
        printHTMLBodyStart(SITENAME);
    }

    switch($screen) {
        case SCREENMAINMENU:
            println('<div class="row">');
            $numberOfLessons = $quickDatabase->getNumberOfLessons();
            for($lessonNumber=1; $lessonNumber<=$numberOfLessons; $lessonNumber++) {
                $lessonTitle = $quickDatabase->getLessonTitle($lessonNumber);
                $lessonContent = $quickDatabase->getLessonContent($lessonNumber);
                printMenuCard($lessonTitle, $lessonContent, SCREENLESSONMENU, $lessonNumber);
            }
            printMenuCard("Account", "Change your username or password.", SCREENACCOUNTEDIT); //need to add
            printMenuCard("Logout", "Exit ".SITENAME.".", SCREENEXIT); //need to add
            println('</div>');
            break;
        case SCREENLESSONMENU: 
            println('<div class="row">');
            for($moduleNumber=1; $moduleNumber<=$numberOfLessons; $moduleNumber++) {
                $moduleTitle = $quickDatabase->getLessonTitle($moduleNumber);
                $moduleContent = $quickDatabase->getLessonContent($moduleNumber);
                printMenuCard($moduleTitle, $moduleContent, SCREENMODULE, $lessonID, $moduleNumber);
            }
            for($moduleNumber=1; $moduleNumber<=$numberOfLessons; $moduleNumber++) {
                $moduleTitle = $quickDatabase->getLessonTitle($moduleNumber);
                $moduleContent = $quickDatabase->getLessonContent($moduleNumber);
                printMenuCard("Review - ".$moduleTitle, $moduleContent, SCREENREVIEW, $lessonID, $moduleNumber);
            }
            for($moduleNumber=1; $moduleNumber<=$numberOfLessons; $moduleNumber++) {
                $moduleTitle = $quickDatabase->getLessonTitle($moduleNumber);
                $moduleContent = $quickDatabase->getLessonContent($moduleNumber);
                printMenuCard("Quiz for ".$moduleTitle, $moduleContent, SCREENQUIZ, $lessonID, $moduleNumber);
            }
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
        /*case SCREENQUIZCONCEPT:
            if(isset($_POST['moduleID']) && $_POST['moduleID']!=0) {
                if(isset($_POST['conceptID']) && $_POST['conceptID']!=0) {//concept screen of module
                    $moduleID = $_POST['moduleID'];
                    $conceptID = $_POST['conceptID'];
                    printQuizPage($moduleID, $conceptID);
                } else {//main menu of Module
                    printQuizPage($moduleID);
                }
            }
            break;*/
        default:
            printLogin();
    }
}
printHTMLFooter();
?>
