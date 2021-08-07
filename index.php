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
    $lessonid = 0;
    $moduleid = 0;
    $conceptid = 0;

    //print website heading without or with lesson title depending on if it's the main menu or not
    if($screen==SCREENMAINMENU) {
        printHTMLBodyStart(SITENAME);
        //println("<h3>CHECK Screen: $screen</h3>");
        //println("<h4>CHECK post: ".var_dump($_POST)."</h4>"); 
    } else if(isset($_POST['lessonid']) && $_POST['lessonid']!=0) {
        $lessonid = $_POST['lessonid'];
        printHTMLBodyStart(SITENAME, $lessonid);
        //println("<p>CHECK lessonid set? ".isset($_POST['lessonid'])."</p>");
        //println("<p>CHECK lessonid value? ".$_POST['lessonid']."</p>");
        //println("<h3>CHECK Screen: $screen</h3>");
        //println("<h4>CHECK post: ".var_dump($_POST)."</h4>"); 
    } else { //default to non-lesson title menu
        printHTMLBodyStart(SITENAME);
    }

    switch($screen) {
        case SCREENMAINMENU:
            println('<div class="row px-3">');
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
            println('<div class="row px-3">');
            $numberOfModules = $quickDatabase->getNumberOfModulesInLesson($lessonid);
            for($moduleNumber=1; $moduleNumber<=$numberOfModules; $moduleNumber++) {
                $moduleTitle = $quickDatabase->getLessonTitle($lessonid, $moduleNumber);
                $moduleContent = $quickDatabase->getLessonContent($lessonid, $moduleNumber);
                printMenuCard($moduleTitle, $moduleContent, SCREENMODULE, $lessonid, $moduleNumber);
            }
            for($moduleNumber=1; $moduleNumber<=$numberOfModules; $moduleNumber++) {
                $moduleTitle = $quickDatabase->getLessonTitle($lessonid, $moduleNumber);
                $moduleContent = $quickDatabase->getLessonContent($lessonid, $moduleNumber);
                printMenuCard("Review - ".$moduleTitle, $moduleContent, SCREENREVIEW, $lessonid, $moduleNumber);
            }
            for($moduleNumber=1; $moduleNumber<=$numberOfModules; $moduleNumber++) {
                $moduleTitle = $quickDatabase->getLessonTitle($lessonid, $moduleNumber);
                $moduleContent = $quickDatabase->getLessonContent($lessonid, $moduleNumber);
                printMenuCard("Quiz for ".$moduleTitle, $moduleContent, SCREENQUIZ, $lessonid, $moduleNumber);
            }
            printMenuCard("Account", "Change your username or password.", SCREENACCOUNTEDIT); //need to add
            printMenuCard("Logout", "Exit ".SITENAME.".", SCREENEXIT); //need to add
            println('</div>');
            println("<br><br>");
            println("<h3>Testing Json Lesson</h3>");
            println("<p>".getLessonJSON($lessonid)."</p>");
            printJSHTMLLessonJSON($lessonid);
            break;
        case SCREENMODULE:
            //println('<h4>screen module...</h4>');
            if( ((isset($_POST['moduleid']) && $_POST['moduleid']!=0))
                &&(isset($_POST['lessonid']) && $_POST['lessonid']!=0) ) {
                $lessonid = $_POST['lessonid'];
                $moduleid = $_POST['moduleid'];
                //println('<h4>module id: '.$moduleid.'</h4>');
                //main menu of Module
                //printModulePage($lessonid, $moduleid);
                printJSONModulePage($lessonid, $moduleid);
                //println("<br><br>");
                //println("<h3>Testing Json Module</h3>");
                //println("<p>".getModuleJSON($lessonid, $moduleid)."</p>");
            }
            break;
        case SCREENMODULECONCEPT:
            if( ((isset($_POST['moduleid']) && $_POST['moduleid']!=0))
                &&(isset($_POST['lessonid']) && $_POST['lessonid']!=0) )  {
                if(isset($_POST['conceptid']) && $_POST['conceptid']!=0) {//concept screen of module
                    $moduleid = $_POST['moduleid'];
                    $conceptid = $_POST['conceptid'];
                    printModulePage($lessonid, $moduleid, $conceptid);
                    printJSONModulePage($lessonid, $moduleid);
                } else {//main menu of Module
                    printModulePage($lessonid, $moduleid);
                    printJSONModulePage($lessonid, $moduleid);

                }
                //println("<br><br>");
                //println("<h3>Testing Json Module Content</h3>");
                //println("<p>".getModuleJSON($lessonid, $moduleid)."</p>");
            }
            break;
        case SCREENREVIEW:
            if( ((isset($_POST['moduleid']) && $_POST['moduleid']!=0))
                &&(isset($_POST['lessonid']) && $_POST['lessonid']!=0) ) {
                
                $moduleid = $_POST['moduleid'];
                //main menu of Review
                printReviewPage($lessonid, $moduleid);
            }
            break;
        case SCREENREVIEWCONCEPT:
            if( ((isset($_POST['moduleid']) && $_POST['moduleid']!=0))
                &&(isset($_POST['lessonid']) && $_POST['lessonid']!=0) ) {
                if(isset($_POST['conceptid']) && $_POST['conceptid']!=0) {//concept screen of module
                    $moduleid = $_POST['moduleid'];
                    $conceptid = $_POST['conceptid'];
                    printReviewPage($lessonid, $moduleid, $conceptid);
                } else {//main menu of Module
                    printReviewPage($lessonid, $moduleid);
                }
            }
            break;
        case SCREENQUIZ:
            if( ((isset($_POST['moduleid']) && $_POST['moduleid']!=0))
                &&(isset($_POST['lessonid']) && $_POST['lessonid']!=0) ) {
                $moduleid = $_POST['moduleid'];
                //main menu of Quiz
                printQuizPage($lessonid, $moduleid);
            }
            break;
        /*case SCREENQUIZCONCEPT:
            if(isset($_POST['moduleid']) && $_POST['moduleid']!=0) {
                if(isset($_POST['conceptid']) && $_POST['conceptid']!=0) {//concept screen of module
                    $moduleid = $_POST['moduleid'];
                    $conceptid = $_POST['conceptid'];
                    printQuizPage($moduleid, $conceptid);
                } else {//main menu of Module
                    printQuizPage($moduleid);
                }
            }
            break;*/
        default:
            printLogin();
    }
}
printHTMLFooter();
?>
