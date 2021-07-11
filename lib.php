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

    $isHome = true;
    if(!isSessionValid() || !isset($_REQUEST['screen']) || $_REQUEST['screen']==SCREENMAINMENU) {
        $isHome=true;
    } else {
        $isHome=false;
    }

    println('<body>');
    println('<div class="container col-sm-11" style="'.MAINBACKGROUNDSTYLE.'">');
    println('<div class="jumbotron py-3 px-lg-3">');
    println('<div class="row justify-content-center">');
    println('<h3 class="col-sm-8 display-3 text-secondary" style="font-size: 3.0em; text-align: center"><i class="bi bi-journal-check"></i>'.$pageTitle.'</h1>');
    println('</div>');//row
    println('<br>');
    println('<div class="row justify-content-center">');
    if(!$isHome) {//print the home button except when already home
        //println('<div class="col-lg-2 col-md-4 col-sm-6 card">');
        printMainMenuButton();
        //println('</div>'); //col    
    }
    //println('<div class="col-lg-2 col-md-4 col-sm-6 card">');
    println('<span class="btn rounded-pill lh-lg bg-secondary shadow-lg justify-content-center" pointer-event="none" aria-disabled="true">');
    println('<button class="bg-secondary text-light shadow-sm lead" pointer-event="none" aria-disabled="true" style="font-size: 1.6em; text-align: center">&nbsp;'.$lessonTitle.'&nbsp;</button>');
    println('</span>');
    //println('</div>'); //col
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

function printMenuCard(string $cardTitle, string $cardContent, int $menuScreen=SCREENEXIT, int $moduleID=-1, int $conceptID=-1) {

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
    println('  <p class="card-text"><b>menuScreen:</b>'.$menuScreen.'</p>');
    if($moduleID!=-1 && $conceptID!=-1) {
        printRightArrowButton($cardTitle, $menuScreen, $buttonName, $moduleID, $conceptID);
    } else if($moduleID!=-1) {
        printRightArrowButton($cardTitle, $menuScreen, $buttonName, $moduleID);
    } else {
        printRightArrowButton($cardTitle, $menuScreen, $buttonName);
    }
    //println('</div>');//
    println('</div>');//card-body
    println('</div>');//card
    //println('</div>');//row
}

function printModulePage(int $moduleID, int $conceptID=-1) {
    $moduleTitle = "Demo Module Title";
    $moduleWelcomeMessage = "In this module you will learn about ".$moduleTitle;
    $buttonName = "Learn";
    println('<h3 class="display-4 text-secondary">'.$moduleTitle.'</h3>');
    if($conceptID==-1) { //just print main page
        println('<p>'.$moduleWelcomeMessage.'</p>');
    } else {//print concept page
        $conceptTitle = "Demo Concept Title";
        println('<h4 class="lead text-primary" style="font-size: 1.4em">'.$conceptTitle.'</h4>');
        println('<p>Module ID:  '.$moduleID.'</p>');
        println('<p>Concept ID: '.$conceptID.'</p>');
    }
    println("<h3>CHECK ModuleID: $moduleID ConceptID: $conceptID</h3>");
    if($moduleID!=-1 && $conceptID!=-1) {
        $conceptID++;
        $buttonName = "Next";
        printRightArrowButton($moduleTitle, SCREENMODULECONCEPT, $buttonName, $moduleID, $conceptID);
    } else if($moduleID!=-1) {
        $conceptID = 1;
        printRightArrowButton($moduleTitle, SCREENMODULECONCEPT, $buttonName, $moduleID, $conceptID);
    } else {
        $buttonName = "Main Menu";
        printRightArrowButton($moduleTitle, SCREENMAINMENU, $buttonName);
    }
}

function printReviewPage(int $moduleID, int $conceptID=-1) {
    $moduleTitle = "Demo Module Title";
    $moduleWelcomeMessage = "This module was about ".$moduleTitle.".";
    $buttonName = "Review";
    println('<h3 class="display-4 text-secondary">Review '.$moduleTitle.'</h3>');
    if($conceptID==-1) { //just print main page
        println('<p>'.$moduleWelcomeMessage.'</p>');
    } else {
        $conceptTitle = "Demo Concept Title";
        println('<h4 class="lead text-primary" style="font-size: 1.4em">'.$conceptTitle.'</h4>');
        println('<p>Module ID:  '.$moduleID.'</p>');
        println('<p>Concept ID: '.$conceptID.'</p>');
    }
    if($moduleID!=-1 && $conceptID!=-1) {
        $conceptID++;
        $buttonName = "Next";
        printRightArrowButton($moduleTitle, SCREENREVIEWCONCEPT, $buttonName, $moduleID, $conceptID);
    } else if($moduleID!=-1) {
        $conceptID = 1;
        printRightArrowButton($moduleTitle, SCREENREVIEWCONCEPT, $buttonName, $moduleID, $conceptID);
    } else {
        $buttonName = "Main Menu";
        printRightArrowButton($moduleTitle, SCREENMAINMENU, $buttonName);
    }
}

function printQuizPage(int $moduleID, int $conceptID=-1) {
    $moduleTitle = "Demo Module Title";
    $moduleWelcomeMessage = "Are you ready to check your knowledge on ".$moduleTitle."?";
    $buttonName = "Test";
    println('<h3 class="display-4 text-secondary">Quiz '.$moduleTitle.'</h3>');
    if($conceptID==-1) { //just print main page
        println('<p>'.$moduleWelcomeMessage.'</p>');
    } else {
        $conceptTitle = "Demo Concept Title";
        println('<h4 class="lead text-primary" style="font-size: 1.4em">'.$conceptTitle.'</h4>');
        println('<p>Module ID:  '.$moduleID.'</p>');
        println('<p>Concept ID: '.$conceptID.'</p>');
    }
    if($moduleID!=-1 && $conceptID!=-1) {
        $conceptID++;
        $buttonName = "Next";
        printRightArrowButton($moduleTitle, SCREENQUIZCONCEPT, $buttonName, $moduleID, $conceptID);
    } else if($moduleID!=-1) {
        $conceptID = 1;
        printRightArrowButton($moduleTitle, SCREENQUIZCONCEPT, $buttonName, $moduleID, $conceptID);
    } else {
        $buttonName = "Main Menu";
        printRightArrowButton($moduleTitle, SCREENMAINMENU, $buttonName);
    }
}

function printRightArrowButton(string $pageTitle, int $screenType, string $buttonText="", int $moduleID=-1, int $conceptID=-1) {
    println('<form id="rightArrowButton_'.$pageTitle.'" method="post">');
    println('  <input type="hidden" name="screen" value="'.$screenType.'">');
    if(in_array($screenType, array(SCREENMODULE, SCREENMODULECONCEPT, SCREENREVIEW, SCREENREVIEWCONCEPT, SCREENQUIZ, SCREENQUIZCONCEPT))) {
        if($moduleID!=-1) println('  <input type="hidden" name="moduleID" value="'.$moduleID.'">');
    }
    if(in_array($screenType, array(SCREENMODULECONCEPT, SCREENREVIEWCONCEPT, SCREENQUIZCONCEPT))) {
        if($conceptID!=-1) println('  <input type="hidden" name="conceptID" value="'.$conceptID.'">');
    }
    println('  <button type="submit" class="btn rounded-pill lh-lg bg-secondary text-light shadow-lg" name="rightArrowButton_'.$pageTitle.'">'.$buttonText.'&nbsp;'.NEXTBUTTONICON.'</button>');
    println('</form>');
}

function printMainMenuButton() {
    $buttonText = "Main Menu";
    println('<form id="mainMenu" method="post">');
    println('  <input type="hidden" name="screen" value="'.SCREENMAINMENU.'">');
    println('<span class="btn rounded-pill lh-lg bg-secondary shadow-lg justify-content-center">');
    println('  <button type="submit" class="btn rounded-pill lh-lg bg-secondary text-light lead shadow-sm" '
            .'style="font-size: 1.6em; text-align: center" name="mainMenu">'
            //.'<p class="bg-secondary text-light lead" style="font-size: 1.6em; text-align: center">'
            .MAINMENUBUTTONSVG.'&nbsp;'.$buttonText.'&nbsp;'
            //.'</p>'
            .'</button>');
    println('</span>');
    println('</form>');
}

function println(string $string) {
    print($string.PHP_EOL);
}

?>
