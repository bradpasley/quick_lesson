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

include('auth.php');
 include('lib.php');
 

 const SITENAME = "Quick Lesson";
 const LESSONNAME = "Korean Alphabet";

 printHTMLHeader(SITENAME);
 printHTMLBodyStart(SITENAME, LESSONNAME);
if(!isSessionValid()) {
    printLogin();
    if(isLoginAttempt()) { //if login attempted but session not valid
        echo '<p class="text-warning">username/password incorrect.</p>';
    }
 }
 if(isSessionValid()) {
    if($Screen = SCREENMAINMENU) {
        echo '<div class="row">';
        printMenuCard("Consonants", "Learn how to identify and say the Korean consonants.");
        printMenuCard("Vowels", "Learn how to identify and say the Korean vowels.");
        printMenuCard("Review", "Get a summary of the key points.");
        printMenuCard("Quizzes", "Check what you've learnt.");
        printMenuCard("Account", "Change your username or password.");
        printMenuCard("Logout", "Exit ".SITENAME.".");
        echo '</div>';
    }
}
 printHTMLFooter();
 ?>
