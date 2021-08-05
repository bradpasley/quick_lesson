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
 * constants.php - constants file keeps all constants used in the site..
 */

const SITENAME = "Quick Lesson";
const LESSONNAME = "Korean Alphabet";

const SCREENLOGIN = 0;
const SCREENMAINMENU = 10;
const SCREENLESSONMENU = 20;
const SCREENMODULE = 30;
const SCREENMODULECONCEPT = 35;
const SCREENREVIEW = 40;
const SCREENREVIEWCONCEPT = 45;
const SCREENQUIZ = 50;
const SCREENQUIZCONCEPT = 55;
const SCREENACCOUNTEDIT = 90;
const SCREENEXIT = -100;

const DEEPBACKGROUNDSTYLE = 'dark-deep-background';
const MAINBACKGROUNDSTYLE = 'dark-main-background';
const SECONDBACKGROUNDSTYLE = 'dark-second-background';
const CARDBACKGROUNDSTYLE = 'dark-card-background';
const LESSONBACKGROUNDSTYLE = 'dark-lesson-background';
const MODULEBACKGROUNDSTYLE = 'dark-module-background';
const QUIZBACKGROUNDSTYLE = 'dark-quiz-background';
const REVIEWBACKGROUNDSTYLE = 'dark-review-background';
const LESSONBUTTONSTYLE = 'dark-lesson-button';
const NEXTBUTTONICON = '<i class="bi bi-arrow-right-circle"></i>';
const PREVBUTTONICON = '<i class="bi bi-arrow-left-circle"></i>';
const MAINMENUBUTTONICON = '<i class="bi bi-house-door"></i>';
const MAINMENUBUTTONSVG = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-house-door" viewBox="0 0 15 15">
<path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
</svg>';

