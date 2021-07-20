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
    $siteCSSURL          = "quick.css";
    println('<!doctype html>');
    println('<html lang="en">');
    println('<head>');
    println('<meta charset="utf-8">');
    println('<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">');
    println('<link rel="stylesheet" href="'.$bootstrapURL.'">');
    println('<link rel="stylesheet" href="'.$bootstrapIconURL.'">');
    println('<link rel="stylesheet" href="'.$flipCardCSSURL.'">');
    println('<link rel="stylesheet" href="'.$quizCSSURL.'">');
    println('<link rel="stylesheet" href="'.$siteCSSURL.'">');
    println('<title>'.$HTMLPageTitle.'</title>');
    println('<!-- Bootstrap CSS -->');
    println('<script src="'.$javascriptBundleURL.'"></script>');
    println('<script src="'.$quizJsURL.'"></script>');
    println('</head>');
}

function printHTMLBodyStart(string $pageTitle, int $lessonid=0) {
    global $quickDatabase;
    println('<body>');
    //println('<h1> print HTML lessonid: '.$lessonid.'</h1>');
    
    $isHome = true;
    if(!isSessionValid() || !isset($_REQUEST['screen']) || $_REQUEST['screen']==SCREENMAINMENU) {
        $isHome=true;
    } else {
        $isHome=false;
    }
    
    println('<div class="container col-sm-11 '.MAINBACKGROUNDSTYLE.'">');
    println('<div class="jumbotron py-3 px-lg-3">');
    println('<div class="row justify-content-center">');
    println('<h3 class="col-sm-8 display-3 text-secondary" style="font-size: 3.0em; text-align: center"><i class="bi bi-journal-check"></i>'.$pageTitle.'</h1>');
    println('</div>');//row
    println('<br>');
    println('<div class="row justify-content-center">');
    if(!$isHome && $lessonid>0) {//print the home button except when already home + print Lesson bubble title when in submenu/lesson page
        $lessonTitle = $quickDatabase->getLessonTitle($lessonid);
        //println('<div class="col-lg-2 col-md-4 col-sm-6 card">');
        printMainMenuButton();
        //println('</div>'); //col
        //println('<div class="col-lg-2 col-md-4 col-sm-6 card">');
        printLessonButton($lessonTitle, $lessonid);
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

function printMenuCard(string $cardTitle, string $cardContent, int $menuScreen=SCREENEXIT, int $lessonid=0, int $moduleid=0, int $conceptid=0) {

    $cardColWidth = 2;
    
    $buttonName = "Go!";
    $backgroundClass = WHITEBACKGROUNDSTYLE;
    if(in_array($menuScreen, array(SCREENLESSONMENU))) {
        $buttonName = "Go!";
        $backgroundClass = LESSONBACKGROUNDSTYLE;
    }
    if(in_array($menuScreen, array(SCREENMODULE, SCREENMODULECONCEPT))) {
        $buttonName = "Learn";
        $backgroundClass = MODULEBACKGROUNDSTYLE;
    }
    if(in_array($menuScreen, array(SCREENREVIEW, SCREENREVIEWCONCEPT))) {
        $buttonName = "Revise";
        $backgroundClass = REVIEWBACKGROUNDSTYLE;
    }
    if(in_array($menuScreen, array(SCREENQUIZ, SCREENQUIZCONCEPT))) {
        $buttonName = "Test";
        $backgroundClass = QUIZBACKGROUNDSTYLE;
    }
    if(in_array($menuScreen, array(SCREENACCOUNTEDIT))) {
        $buttonName = "Edit";
    }
        

    //println('<div class="row">');
    println('<div class="col-lg-2 col-md-4 col-sm-6 card '.$backgroundClass.'">');
    println('<div class="card-body d-flex flex-column justify-content-sm-between">');
    println('  <h4 class="card-title">'.$cardTitle.'</h4>');
    println('  <p class="card-text">'.$cardContent.'</p>');
    //println('  <p class="card-text"><b>menuScreen:</b>'.$menuScreen.'</p>');
    if($moduleid!=0 && $conceptid!=0) {
        printRightArrowButton($cardTitle, $menuScreen, $buttonName, $lessonid, $moduleid, $conceptid);
    } else if($moduleid!=0) {
        printRightArrowButton($cardTitle, $menuScreen, $buttonName, $lessonid, $moduleid);
    } else {
        printRightArrowButton($cardTitle, $menuScreen, $buttonName, $lessonid);
    }
    //println('</div>');//
    println('</div>');//card-body
    println('</div>');//card
    //println('</div>');//row
}

function printModulePage(int $lessonid, int $moduleid, int $conceptid=0) {
    global $quickDatabase;
    
    if(isset($quickDatabase)) {
        $moduleTitle = $quickDatabase->getLessonTitle($lessonid, $moduleid);
        $moduleContent = $quickDatabase->getLessonContent($lessonid, $moduleid);
    } else {//when database not active
        $moduleTitle = "Demo Module Title";
        $moduleContent = "In this module you will learn about ".$moduleTitle;
    }
    $buttonName = "Learn";
    println('<h3 class="display-4 text-secondary">'.$moduleTitle.'</h3>');
    if($conceptid==0) { //just print main page
        println('<p>'.$moduleContent.'</p>');
    } else {//print concept page
        if(isset($quickDatabase)) {
            $conceptTitle = $quickDatabase->getLessonTitle($lessonid, $moduleid, $conceptid);
            $conceptContent = $quickDatabase->getLessonContent($lessonid, $moduleid, $conceptid);
        } else {
            $conceptTitle = "Demo Concept Title";
            $conceptContent = "Insert content here";
        }    
        println('<h4 class="lead text-primary" style="font-weight:bolder; font-size: 1.4em">'.$conceptTitle.'</h4>');
        println('<p style="font-size: 1.3em">'.$conceptContent.'</p>');
    }
    println('<br><br>');
    //println('<p>Module ID:  '.$moduleid.'</p>');
    //println('<p>Concept ID: '.$conceptid.'</p>');
    
    if($moduleid>0 && $conceptid>0) {
        $buttonName = "Previous";
        println('<div class="d-flex justify-content-sm-start">');//start flex
        printLeftArrowButton($moduleTitle, SCREENMODULECONCEPT, $buttonName, $lessonid, $moduleid, $conceptid);
        $buttonName = "Next";
        println('<div class="p2">&nbsp;</div>');//gap between buttons
        printRightArrowButton($moduleTitle, SCREENMODULECONCEPT, $buttonName, $lessonid, $moduleid, $conceptid);
        println('</div>');//end flex
    } else if($moduleid>0) {
        $buttonName = "Next";
        printRightArrowButton($moduleTitle, SCREENMODULECONCEPT, $buttonName, $lessonid, $moduleid, $conceptid);
    } else {
        $buttonName = "Main Menu";
        printRightArrowButton($moduleTitle, SCREENMAINMENU, $buttonName, $lessonid);
    }
}

function printReviewPage(int $lessonid, int $moduleid, int $conceptid=0) {
    global $quickDatabase;
    
    if(isset($quickDatabase)) {
        $moduleTitle = $quickDatabase->getLessonTitle($lessonid, $moduleid);
        //$quickDatabase->getLessonContent($lessonid, $moduleid);
    } else {//when database not active
        $moduleTitle = "Demo Review Title";
    }
    $moduleContent = "In this module you will review ".$moduleTitle;
    $buttonName = "Review";
    println('<h3 class="display-4 text-secondary">'.$moduleTitle.'</h3>');
    if($conceptid==0) { //just print main page
        println('<p>'.$moduleContent.'</p>');
    } else {//print concept page
        if(isset($quickDatabase)) {
            $conceptTitle = $quickDatabase->getLessonTitle($lessonid, $moduleid, $conceptid);
            $conceptContent = $quickDatabase->getLessonContent($lessonid, $moduleid, $conceptid);
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
        //println('<p>Module ID:  '.$moduleid.'</p>');
        //println('<p>Concept ID: '.$conceptid.'</p>');
    }
    if($moduleid>0 && $conceptid>0) {
        $buttonName = "Previous";
        println('<div class="row">');//start row
        printLeftArrowButton($moduleTitle, SCREENREVIEWCONCEPT, $buttonName, $lessonid, $moduleid, $conceptid);
        $buttonName = "Next";
        printRightArrowButton($moduleTitle, SCREENREVIEWCONCEPT, $buttonName, $lessonid, $moduleid, $conceptid);
    } else if($moduleid>0) {
        $buttonName = "Next";
        printRightArrowButton($moduleTitle, SCREENREVIEWCONCEPT, $buttonName, $lessonid, $moduleid, $conceptid);
        println('</div>');//end row
    } else {
        $buttonName = "Main Menu";
        printRightArrowButton($moduleTitle, SCREENMAINMENU, $buttonName, $lessonid);
    }
}

function printQuizPage(int $lessonid, int $moduleid) { //int $conceptid=0
    global $quickDatabase;
    
    if(isset($quickDatabase)) {
        $moduleTitle = $quickDatabase->getLessonTitle($lessonid, $moduleid);
        //$moduleContent = $quickDatabase->getLessonContent($lessonid, $moduleid);
    } else {//when database not active
        $moduleTitle = "Demo Quiz Title";
    }
    $moduleContent = "In this quiz you will be tested on ".$moduleTitle;
    println('<h3 class="display-4 text-secondary">'.$moduleTitle.'</h3>');
    if(isset($quickDatabase)) {
        $conceptCount = $quickDatabase->getNumberOfConceptsInModule($lessonid, $moduleid);
        
        //questions
        $quizHeadHTML = '<div id="dragScriptContainer">';//start of dragScriptContainer div tag
        $quizQuestionsHTML = '<div id="questionDiv">';//start of questionDiv div tag
        for($conceptid=1; $conceptid<=$conceptCount; $conceptid++) {
            $conceptTitle = $quickDatabase->getLessonTitle($lessonid, $moduleid, $conceptid);
            $quizQuestionsHTML .= '<div class="dragDropSmallBox" id="q'.$conceptid.'">'.$conceptTitle.'</div>'
                                  .'<div class="destinationBox"></div>';
        }
        $quizQuestionsHTML .= '</div>';//end of questionDiv div tag

        //answers
        $quizAnswersHTML = '<div id="answerDiv">';//start of answerDiv div tag
        for($conceptid=1; $conceptid<=$conceptCount; $conceptid++) {
            $conceptContent = $quickDatabase->getLessonContent($lessonid, $moduleid, $conceptid);
            $quizAnswersHTML .= '<div class="dragDropSmallBox" id="a'.$conceptid.'">'.substr($conceptContent,0,50).'</div>';
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
}

/**
 * Json version module/review/quiz functions
 */

 /**
  * getModuleJSON() - retrieves all concepts for one module
  * returns a JSON formatted string to be used in a Javascript function.
  * if moduleid is not included or equals 0, the lesson metadata will be returned
  */

function printJSONModulePage(int $lessonid, int $moduleid) {
    global $quickDatabase;
    $conceptid = 0;
    println('<h3 id="moduleTitle" class="display-5 text-secondary"></h3>');
    println('<h4 id="conceptTitle" class="display-4 text-primary"></h4>');
    println('<p id="content" style="font-size: 1.3em"></p>');
    //println('<p id="conceptID" style="font-size: 1.3em">Concept id: '.$conceptid.'</p>');
    println('<p id="pageNumber"></p>');
    println('<div id="modNavButtons"></div>');
    println("<script>");
    println("var conceptid = $conceptid;");
    println("const moduleJSON = ".getModuleJSON($lessonid, $moduleid).";");
    println('document.getElementById("conceptID").innerHTML = "JSON Content("+conceptid+")";');
    println('document.getElementById("moduleTitle").innerHTML = moduleJSON["0"].title;'); //0 is the module metadata conceptid
    println('document.getElementById("conceptTitle").innerHTML = moduleJSON["'.$moduleid.'"].title;');
    println('document.getElementById("content").innerHTML = moduleJSON["0"].content;'); //0 is the module metadata conceptid
    println('showNavigationButtons();');
    println('function showNavigationButtons() {');
    println('   var navButtons = "";');
    println('   var numberOfConcepts = Object.keys(moduleJSON).length-1;');
    println('   document.getElementById("testOutput").innerHTML = "Page "+conceptid;');
    println('   if(conceptid>0) {  //left button limit');
    println('       navButtons += \'<button onClick="previousConcept()" class="btn rounded-pill lh-lg bg-secondary text-light shadow-lgname="leftArrowButton_JSON">Previous</button>\n\';');
    println('   }');
    println('   if(conceptid<numberOfConcepts) { //right button limit');
    println('       navButtons += \'<button onClick="nextConcept()" class="btn rounded-pill lh-lg bg-secondary text-light shadow-lgname="rightArrowButton_JSON">Next</button>\n\';');
    println('   }');
    println('   document.getElementById("modNavButtons").innerHTML = navButtons;');
    println('}');
    println('function nextConcept() {');
    println('   conceptid++;');
    println('   document.getElementById("conceptTitle").innerHTML = moduleJSON[conceptid].title;');
    println('   document.getElementById("content").innerHTML = moduleJSON[conceptid].content;');
    println('   showNavigationButtons();');
    println('}');
    println('function previousConcept() {');
    println('   conceptid--;');
    println('   document.getElementById("conceptTitle").innerHTML = moduleJSON[conceptid].title;');
    println('   document.getElementById("content").innerHTML = moduleJSON[conceptid].content;');
    println('   showNavigationButtons();');
    println('}');
    println("</script>");
}

function printJSHTMLLessonJSON(int $lessonid) {
    println('<p id="LessonTitle"></p>');
    println('<p id="LessonContent"></p>');
    println("<script>");
    println("const lessonJSON = '".getLessonJSON($lessonid)."';");
    println("const lessonObj = JSON.parse(lessonJSON);");
    println('document.getElementById("LessonTitle").innerHTML = "JSON Title: " + lessonObj.title;');
    println('document.getElementById("LessonContent").innerHTML = "JSON Content: " + lessonObj.content;');
    println("</script>");
}

function getLessonJSON(int $lessonid) {
    return getJSON($lessonid);
}

function getModuleJSON(int $lessonid, int $moduleid) {
    return getJSON($lessonid, $moduleid);
}

function getJSON(int $lessonid, int $moduleid=0) {
    global $quickDatabase;
    return $quickDatabase->getJSONLesson($lessonid, $moduleid);
}

/**
 * Right and Left navigation buttons
 */

function printRightArrowButton(string $pageTitle, int $screenType, string $buttonText="", int $lessonid=0, int $moduleid=0, int $conceptid=0) {
    global $quickDatabase;
    $middleText = "";
    $isLessonButton = false;
    $isMainMenuButton = false;
    $conceptCount = 0;
    if($moduleid==0 && $conceptid==0) {
        $isNextButton = false;
        $isMainMenuButton = true;
    } else if($conceptid==0) {
        $isLessonButton = true;
    } else if($conceptid>0) {
        $isNextButton = true;
        $conceptCount = $quickDatabase->getNumberOfConceptsInModule($lessonid, $moduleid);
    }
    //println("<p>printRight next? $isNextButton main? $isMainMenuButton les:$lessonid, mod:$moduleid con:$conceptid Count: $conceptCount</p>");  
    if($isMainMenuButton || $isLessonButton || $conceptid<$conceptCount) {//don't print right button for last concept.
        $conceptid++; //change to the value of next screen
        if(in_array($screenType, array(SCREENLESSONMENU, SCREENMODULE, SCREENMODULECONCEPT, SCREENREVIEW, SCREENREVIEWCONCEPT, SCREENQUIZ, SCREENQUIZCONCEPT))) {
            if($lessonid>0) $middleText .= '  <input type="hidden" name="lessonid" value="'.$lessonid.'">';
        }
        if(in_array($screenType, array(SCREENMODULE, SCREENMODULECONCEPT, SCREENREVIEW, SCREENREVIEWCONCEPT, SCREENQUIZ, SCREENQUIZCONCEPT))) {
            if($moduleid>0) $middleText .= '  <input type="hidden" name="moduleid" value="'.$moduleid.'">';
        }
        if(in_array($screenType, array(SCREENMODULECONCEPT, SCREENREVIEWCONCEPT, SCREENQUIZCONCEPT))) {
            $middleText .= '  <input type="hidden" name="conceptid" value="'.$conceptid.'">';
        } 
        if($isNextButton) println('<div class="p2">');//start of padding
        println('<form id="rightArrowButton_'.$pageTitle.'" method="post">');
        println('  <input type="hidden" name="screen" value="'.$screenType.'">');
        println($middleText);
        println('  <button type="submit" class="btn rounded-pill lh-lg bg-secondary text-light shadow-lg" name="rightArrowButton_'.$pageTitle.'">'.$buttonText.'&nbsp;'.NEXTBUTTONICON.'</button>');
        println('</form>');
        if($isNextButton) println('</div>');//end of padding
    }
}

function printLeftArrowButton(string $pageTitle, int $screenType, string $buttonText="", int $lessonid=0, int $moduleid=0, int $conceptid=0) {
    global $quickDatabase;
    $middleText = "";
    if($conceptid>0) {//don't display for first concept
        $conceptid--; //change to the value of previous screen
        if($conceptid==0) $screenType = $screenType-5; //bring back to main type of page
        if(in_array($screenType, array(SCREENLESSONMENU, SCREENMODULE, SCREENMODULECONCEPT, SCREENREVIEW, SCREENREVIEWCONCEPT, SCREENQUIZ, SCREENQUIZCONCEPT))) {
            if($lessonid>0) $middleText .= '  <input type="hidden" name="lessonid" value="'.$lessonid.'">';
        }
        if(in_array($screenType, array(SCREENMODULE, SCREENMODULECONCEPT, SCREENREVIEW, SCREENREVIEWCONCEPT, SCREENQUIZ, SCREENQUIZCONCEPT))) {
            if($moduleid>0) $middleText .= '  <input type="hidden" name="moduleid" value="'.$moduleid.'">';
        }
        if(in_array($screenType, array(SCREENMODULECONCEPT, SCREENREVIEWCONCEPT, SCREENQUIZCONCEPT))) {
                $middleText .= '  <input type="hidden" name="conceptid" value="'.$conceptid.'">';
        }
        println('<div class="p2">');//start of padding
        println('<form id="leftArrowButton_'.$pageTitle.'" method="post">');
        println('  <input type="hidden" name="screen" value="'.$screenType.'">');
        println($middleText);
        println('  <button type="submit" class="btn rounded-pill lh-lg bg-secondary text-light shadow-lg" name="leftArrowButton_'.$pageTitle.'">'.PREVBUTTONICON.'&nbsp;'.$buttonText.'</button>');
        println('</form>');
        println('</div>');//end of padding
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

function printLessonButton(string $lessonTitle, int $lessonid) {
    
    println('<form id="Lesson-'.$lessonTitle.'" method="post">');
    println('  <input type="hidden" name="screen" value="'.SCREENLESSONMENU.'">');
    println('  <input type="hidden" name="lessonid" value="'.$lessonid.'">');
    println('<span class="btn rounded-pill lh-lg bg-secondary shadow-lg justify-content-center">');
    println('  <button type="submit" class="btn rounded-pill lh-lg bg-secondary text-light lead '.LESSONBUTTONSTYLE.'" '
            .' name="ButtonLesson-'.$lessonTitle.'">'
            .'&nbsp;'.$lessonTitle.'&nbsp;'
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
