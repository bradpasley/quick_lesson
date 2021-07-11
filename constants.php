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
 * constants.php - constants file keeps all constants used in the site..
 */

const SITENAME = "Quick Lesson";
const LESSONNAME = "Korean Alphabet";

const SCREENLOGIN = 0;
const SCREENMAINMENU = 10;
const SCREENMODULE = 20;
const SCREENMODULECONCEPT = 25;
const SCREENREVIEW = 30;
const SCREENREVIEWCONCEPT = 35;
const SCREENQUIZ = 40;
const SCREENQUIZCONCEPT = 45;
const SCREENACCOUNTEDIT = 80;
const SCREENEXIT = -100;

const MAINBACKGROUNDSTYLE = 'background: #FFE6E3';
const NEXTBUTTONICON = '<i class="bi bi-arrow-right-circle"></i>';
const MAINMENUBUTTONICON = '<i class="bi bi-house-door"></i>';
