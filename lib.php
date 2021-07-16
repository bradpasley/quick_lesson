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
 * lib.php - library file to produce common HTML parts
 */

include_once('constants.php');
include_once('database.php');

$quickDatabase;

function printHTMLHeader(string $HTMLPageTitle) {
    $bootstrapURL        = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css";
    $bootstrapIconURL    = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css";
    //$javascriptURL       = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js";
    $javascriptBundleURL = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js";
    $flipCardCSSURL      = "flipper.css";
    $quizCSSURL          = "quiz.css";
    $quizJsURL           = "dragdrop.js";
    println('<!doctype html>');
    println('<html lang="en">');
    println('<head>');
    println('<meta charset="utf-8">');
    println('<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">');
    println('<link rel="stylesheet" href="'.$bootstrapURL.'">');
    println('<link rel="stylesheet" href="'.$bootstrapIconURL.'">');
    println('<link rel="stylesheet" href="'.$flipCardCSSURL.'">');
    println('<link rel="stylesheet" href="'.$quizCSSURL.'">');
    println('<title>'.$HTMLPageTitle.'</title>');
    println('<!-- Bootstrap CSS -->');
    println('<script src="'.$javascriptBundleURL.'"></script>');
    println('<script src="'.$quizJsURL.'"></script>');
    println('</head>');
}

function printHTMLBodyStart(string $pageTitle, int $lessonid=0) {
    
    println('<body>');
    println('<h1> print HTML lessonid: '.$lessonid.'</h1>');
    
    $isHome = true;
    if(!isSessionValid() || !isset($_REQUEST['screen']) || $_REQUEST['screen']==SCREENMAINMENU) {
        $isHome=true;
    } else {
        $isHome=false;
    }
    
    println('<div class="container col-sm-11" style="'.MAINBACKGROUNDSTYLE.'">');
    println('<div class="jumbotron py-3 px-lg-3">');
    println('<div class="row justify-content-center">');
    println('<h3 class="col-sm-8 display-3 text-secondary" style="font-size: 3.0em; text-align: center"><i class="bi bi-journal-check"></i>'.$pageTitle.'</h1>');
    println('</div>');//row
    println('<br>');
    println('<div class="row justify-content-center">');
    if(!$isHome && $lessonid>0) {//print the home button except when already home + print Lesson bubble title when in submenu/lesson page
        println("<h4>Attempt to get lesson title</h4>");
        $lessonTitle = $quickDatabase->getLessonTitle($lessonID);
        println("<h4>lesson title: $lessonTitle</h4>");
        //println('<div class="col-lg-2 col-md-4 col-sm-6 card">');
        printMainMenuButton();
        //println('</div>'); //col
        //println('<div class="col-lg-2 col-md-4 col-sm-6 card">');
        println('<span class="btn rounded-pill lh-lg bg-secondary shadow-lg justify-content-center" pointer-event="none" aria-disabled="true">');
        println('<button class="btn rounded-pill bg-secondary text-light lead" pointer-event="none" aria-disabled="true" style="font-size: 1.4em; text-align: center">&nbsp;'.$lessonTitle.'&nbsp;</button>');
        println('</span>');
        //println('</div>'); //col
    } 
    println('</div>');//row
    println('</div>');//jumbotron
}

function printHTMLFooter() {
    //$javascriptURL       = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js";
    $javascriptBundleURL = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js";
    println('<br><br><br>');
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
    println('<input type="hidden" name="screen" value="'.SCREENMAINMENU.'">');
    println('<div class"row justify-content-center">');
    println('<div class"col-md-3"></div>');
    println('<div class"col-md">');
    println('<label>Username:&nbsp;</label><input type="text" name="username" placeholder="username" /></div>');
    println('<div class"col-md-3"></div>');
    println('</div><br>');
    println('<div class"row">');
    println('<div class"col-md-3"></div>');
    println('<div class"col-md">');
    println('<label>Password:&nbsp;</label><input type="password" name="password" placeholder="password" /></div>');
    println('</div><br>');
    println('<div class"row justify-content-md-center">');
    println('<div class"col-md-6"><input class="btn bg-primary text-light" type="submit" name="login" value="Log in"  /></div>');
    println('</div></form>');
}

function printMenuCard(string $cardTitle, string $cardContent, int $menuScreen=SCREENEXIT, int $lessonID=0, int $moduleID=0, int $conceptID=0) {

    $cardColWidth = 2;
    
    $buttonName = "Go!";
    if(in_array($menuScreen, array(SCREENMODULE, SCREENMODULECONCEPT)))
        $buttonName = "Learn";
    if(in_array($menuScreen, array(SCREENREVIEW, SCREENREVIEWCONCEPT)))
        $buttonName = "Revise";
    if(in_array($menuScreen, array(SCREENQUIZ, SCREENQUIZCONCEPT)))
        $buttonName = "Test";
    if(in_array($menuScreen, array(SCREENACCOUNTEDIT)))
        $buttonName = "Edit";

    //println('<div class="row">');
    println('<div class="col-lg-2 col-md-4 col-sm-6 card">');
    println('<div class="card-body">');
    println('  <h4 class="card-title">'.$cardTitle.'</h4>');
    println('  <p class="card-text">'.$cardContent.'</p>');
    //println('  <p class="card-text"><b>menuScreen:</b>'.$menuScreen.'</p>');
    if($moduleID!=0 && $conceptID!=0) {
        printRightArrowButton($cardTitle, $menuScreen, $buttonName, $lessonID, $moduleID, $conceptID);
    } else if($moduleID!=0) {
        printRightArrowButton($cardTitle, $menuScreen, $buttonName, $lessonID, $moduleID);
    } else {
        printRightArrowButton($cardTitle, $menuScreen, $buttonName, $lessonID);
    }
    //println('</div>');//
    println('</div>');//card-body
    println('</div>');//card
    //println('</div>');//row
}

function printModulePage(int $moduleID, int $conceptID=0) {
    global $quickDatabase;
    $lessonID = 1; //only one lesson currently
    if(isset($quickDatabase)) {
        $moduleTitle = $quickDatabase->getLessonTitle($lessonID, $moduleID);
        $moduleContent = $quickDatabase->getLessonContent($lessonID, $moduleID);
    } else {//when database not active
        $moduleTitle = "Demo Module Title";
        $moduleContent = "In this module you will learn about ".$moduleTitle;
    }
    $buttonName = "Learn";
    println('<h3 class="display-4 text-secondary">'.$moduleTitle.'</h3>');
    if($conceptID==0) { //just print main page
        println('<p>'.$moduleContent.'</p>');
    } else {//print concept page
        if(isset($quickDatabase)) {
            $conceptTitle = $quickDatabase->getLessonTitle($lessonID, $moduleID, $conceptID);
            $conceptContent = $quickDatabase->getLessonContent($lessonID, $moduleID, $conceptID);
        } else {
            $conceptTitle = "Demo Concept Title";
            $conceptContent = "Insert content here";
        }    
        println('<h4 class="lead text-primary" style="font-weight:bolder; font-size: 1.4em">'.$conceptTitle.'</h4>');
        println('<p style="font-size: 1.3em">'.$conceptContent.'</p>');
    }
    println('<br><br>');
    //println('<p>Module ID:  '.$moduleID.'</p>');
    //println('<p>Concept ID: '.$conceptID.'</p>');
    
    if($moduleID>0 && $conceptID>0) {
        $buttonName = "Previous";
        println('<div class="row">');//start row
        printLeftArrowButton($moduleTitle, SCREENMODULECONCEPT, $buttonName, $lessonID, $moduleID, $conceptID);
        $buttonName = "Next";
        printRightArrowButton($moduleTitle, SCREENMODULECONCEPT, $buttonName, $lessonID, $moduleID, $conceptID);
        println('</div>');//end row
    } else if($moduleID>0) {
        $buttonName = "Next";
        printRightArrowButton($moduleTitle, SCREENMODULECONCEPT, $buttonName, $lessonID, $moduleID, $conceptID);
    } else {
        $buttonName = "Main Menu";
        printRightArrowButton($moduleTitle, SCREENMAINMENU, $buttonName, $lessonID);
    }
}

function printReviewPage(int $moduleID, int $conceptID=0) {
    global $quickDatabase;
    $lessonID = 1; //only one lesson currently
    if(isset($quickDatabase)) {
        $moduleTitle = $quickDatabase->getLessonTitle($lessonID, $moduleID);
        //$quickDatabase->getLessonContent($lessonID, $moduleID);
    } else {//when database not active
        $moduleTitle = "Demo Review Title";
    }
    $moduleContent = "In this module you will review ".$moduleTitle;
    $buttonName = "Review";
    println('<h3 class="display-4 text-secondary">'.$moduleTitle.'</h3>');
    if($conceptID==0) { //just print main page
        println('<p>'.$moduleContent.'</p>');
    } else {//print concept page
        if(isset($quickDatabase)) {
            $conceptTitle = $quickDatabase->getLessonTitle($lessonID, $moduleID, $conceptID);
            $conceptContent = $quickDatabase->getLessonContent($lessonID, $moduleID, $conceptID);
        } else {
            $conceptTitle = "Demo Concept Review Title";
            $conceptContent = "Insert content here";
        }    
        println('<h4 class="lead text-primary" style="font-weight:bolder; font-size: 1.4em">Review '.$conceptTitle.'</h4>');
        println('<p style="font-size: 1.3em">Flip the card below to reveal the concept explanation.</p>');
        println('<div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <h1>'.$conceptTitle.'</h1>
                        </div>
                        <div class="flip-card-back">
                            <p style="font-size: 1.3em">'.$conceptContent.'</p>
                        </div>
                    </div>
                </div>');
        println('<br><br>');
        //println('<p>Module ID:  '.$moduleID.'</p>');
        //println('<p>Concept ID: '.$conceptID.'</p>');
    }
    if($moduleID>0 && $conceptID>0) {
        $buttonName = "Previous";
        println('<div class="row">');//start row
        printLeftArrowButton($moduleTitle, SCREENREVIEWCONCEPT, $buttonName, $lessonID, $moduleID, $conceptID);
        $buttonName = "Next";
        printRightArrowButton($moduleTitle, SCREENREVIEWCONCEPT, $buttonName, $lessonID, $moduleID, $conceptID);
    } else if($moduleID>0) {
        $buttonName = "Next";
        printRightArrowButton($moduleTitle, SCREENREVIEWCONCEPT, $buttonName, $lessonID, $moduleID, $conceptID);
        println('</div>');//end row
    } else {
        $buttonName = "Main Menu";
        printRightArrowButton($moduleTitle, SCREENMAINMENU, $buttonName, $lessonID);
    }
}

function printQuizPage(int $moduleID) { //int $conceptID=0
    global $quickDatabase;
    $lessonID = 1; //only one lesson currently
    if(isset($quickDatabase)) {
        $moduleTitle = $quickDatabase->getLessonTitle($lessonID, $moduleID);
        //$moduleContent = $quickDatabase->getLessonContent($lessonID, $moduleID);
    } else {//when database not active
        $moduleTitle = "Demo Quiz Title";
    }
    $moduleContent = "In this quiz you will be tested on ".$moduleTitle;
    println('<h3 class="display-4 text-secondary">'.$moduleTitle.'</h3>');
    if(isset($quickDatabase)) {
        $conceptCount = $quickDatabase->getNumberOfConceptsInModule($lessonID, $moduleID);
        
        //questions
        $quizHeadHTML = '<div id="dragScriptContainer">';//start of dragScriptContainer div tag
        $quizQuestionsHTML = '<div id="questionDiv">';//start of questionDiv div tag
        for($conceptID=1; $conceptID<=$conceptCount; $conceptID++) {
            $conceptTitle = $quickDatabase->getLessonTitle($lessonID, $moduleID, $conceptID);
            $quizQuestionsHTML .= '<div class="dragDropSmallBox" id="q'.$conceptID.'">'.$conceptTitle.'</div>'
                                  .'<div class="destinationBox"></div>';
        }
        $quizQuestionsHTML .= '</div>';//end of questionDiv div tag

        //answers
        $quizAnswersHTML = '<div id="answerDiv">';//start of answerDiv div tag
        for($conceptID=1; $conceptID<=$conceptCount; $conceptID++) {
            $conceptContent = $quickDatabase->getLessonContent($lessonID, $moduleID, $conceptID);
            $quizAnswersHTML .= '<div class="dragDropSmallBox" id="a'.$conceptID.'">'.substr($conceptContent,0,50).'</div>';
        }
        $quizAnswersHTML .= '</div>';//end of answerDiv div tag
        $quizTail = '</div>' //end of dragScriptContainer div tag
                    .'<div id="dragContent"></div>'
                    .'<input type="button" onclick="dragDropResetForm();return false" value="Reset">';
        println($quizHeadHTML);
        println($quizQuestionsHTML);
        println($quizAnswersHTML);
        println($quizTailHTML);
    } else {
        $conceptTitle = "Demo Concept Review Title";
        $conceptContent = "Insert content here";
        println('<h4 class="lead text-primary" style="font-weight:bolder; font-size: 1.4em">Quiz '.$conceptTitle.'</h4>');
        println('<p style="font-size: 1.3em">'.$conceptContent.'</p>');    
    }    
    println('<br><br>');
    //println('<p>Module ID:  '.$moduleID.'</p>');
    //println('<p>Concept ID: '.$conceptID.'</p>');
    
    /*
    if($moduleID>0 && $conceptID>0) {
        $buttonName = "Previous";
        println('<div class="row">');//start row
        printLeftArrowButton($moduleTitle, SCREENQUIZCONCEPT, $buttonName, $lessonID, $moduleID, $conceptID);
        $buttonName = "Next";
        printRightArrowButton($moduleTitle, SCREENQUIZCONCEPT, $buttonName, $lessonID, $moduleID, $conceptID);
        println('</div>');//end row
    } else if($moduleID>0) {
        $buttonName = "Next";
        printRightArrowButton($moduleTitle, SCREENQUIZCONCEPT, $buttonName, $lessonID, $moduleID, $conceptID);
    } else {
        $buttonName = "Main Menu";
        printRightArrowButton($moduleTitle, SCREENMAINMENU, $buttonName, $lessonID);
    }*/
}

function printRightArrowButton(string $pageTitle, int $screenType, string $buttonText="", int $lessonID=0, int $moduleID=0, int $conceptID=0) {
    global $quickDatabase;
    $middleText = "";
    $isLessonButton = false;
    $isMainMenuButton = false;
    $conceptCount = 0;
    if($moduleID==0 && $conceptID==0) {
        $isNextButton = false;
        $isMainMenuButton = true;
    } else if($conceptID==0) {
        $isLessonButton = true;
    } else if($conceptID>0) {
        $conceptCount = $quickDatabase->getNumberOfConceptsInModule($lessonID, $moduleID);
    }
    //println("<p>printRight next? $isNextButton main? $isMainMenuButton les:$lessonID, mod:$moduleID con:$conceptID Count: $conceptCount</p>");  
    if($isMainMenuButton || $isLessonButton || $conceptID<$conceptCount) {//don't print right button for last concept.
        $conceptID++; //change to the value of next screen
        if(in_array($screenType, array(SCREENLESSONMENU, SCREENMODULE, SCREENMODULECONCEPT, SCREENREVIEW, SCREENREVIEWCONCEPT, SCREENQUIZ, SCREENQUIZCONCEPT))) {
            if($lessonID>0) $middleText .= '  <input type="hidden" name="lessonID" value="'.$lessonID.'">';
        }
        if(in_array($screenType, array(SCREENMODULE, SCREENMODULECONCEPT, SCREENREVIEW, SCREENREVIEWCONCEPT, SCREENQUIZ, SCREENQUIZCONCEPT))) {
            if($moduleID>0) $middleText .= '  <input type="hidden" name="moduleID" value="'.$moduleID.'">';
        }
        if(in_array($screenType, array(SCREENMODULECONCEPT, SCREENREVIEWCONCEPT, SCREENQUIZCONCEPT))) {
            $middleText .= '  <input type="hidden" name="conceptID" value="'.$conceptID.'">';
        } 
        if($isNextButton) println('<div class="col-sm-4 col-md-3 col-lg-2">');//start of col
        println('<form id="rightArrowButton_'.$pageTitle.'" method="post">');
        println('  <input type="hidden" name="screen" value="'.$screenType.'">');
        println($middleText);
        println('  <button type="submit" class="btn rounded-pill lh-lg bg-secondary text-light shadow-lg" name="rightArrowButton_'.$pageTitle.'">'.$buttonText.'&nbsp;'.NEXTBUTTONICON.'</button>');
        println('</form>');
        if($isNextButton) println('</div>');//end of col
    }
}

function printLeftArrowButton(string $pageTitle, int $screenType, string $buttonText="", int $lessonID=0, int $moduleID=0, int $conceptID=0) {
    global $quickDatabase;
    $middleText = "";
    if($conceptID>0) {//don't display for first concept
        $conceptID--; //change to the value of previous screen
        if($conceptID==0) $screenType = $screenType-5; //bring back to main type of page
        if(in_array($screenType, array(SCREENMODULE, SCREENMODULECONCEPT, SCREENREVIEW, SCREENREVIEWCONCEPT, SCREENQUIZ, SCREENQUIZCONCEPT))) {
            if($moduleID>0) $middleText .= '  <input type="hidden" name="moduleID" value="'.$moduleID.'">';
        }
        if(in_array($screenType, array(SCREENMODULECONCEPT, SCREENREVIEWCONCEPT, SCREENQUIZCONCEPT))) {
                $middleText .= '  <input type="hidden" name="conceptID" value="'.$conceptID.'">';
        }
        println('<div class="col-sm-4 col-md-3 col-lg-2">');//start of col
        println('<form id="leftArrowButton_'.$pageTitle.'" method="post">');
        println('  <input type="hidden" name="screen" value="'.$screenType.'">');
        println($middleText);
        println('  <button type="submit" class="btn rounded-pill lh-lg bg-secondary text-light shadow-lg" name="leftArrowButton_'.$pageTitle.'">'.PREVBUTTONICON.'&nbsp;'.$buttonText.'</button>');
        println('</form>');
        println('</div>');//end of col
    }
}

function printMainMenuButton() {
    $buttonText = "Main Menu";
    println('<form id="mainMenu" method="post">');
    println('  <input type="hidden" name="screen" value="'.SCREENMAINMENU.'">');
    println('<span class="btn rounded-pill lh-lg bg-secondary shadow-lg justify-content-center">');
    println('  <button type="submit" class="btn rounded-pill lh-lg bg-secondary text-light lead" '
            .'style="font-size: 1.4em; text-align: center" name="mainMenu">'
            .MAINMENUBUTTONSVG.'&nbsp;'.$buttonText.'&nbsp;'
            .'</button>');
    println('</span>');
    println('</form>');
}

function println(string $string) {
    print($string.PHP_EOL);
}

function printlnError(string $input) {
    print(PHP_EOL.'<h4 class="text-danger">Error: '.$input.'</h4>'.PHP_EOL);
}

?>
