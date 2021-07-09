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

 include('lib.php');

 const SITENAME = "Quick Lesson";
 const LESSONNAME = "Korean Alphabet";

 printHTMLHeader(SITENAME);
 printHTMLBodyStart("Welcome to ".SITENAME, LESSONNAME);
 printHTMLFooter();
 ?>