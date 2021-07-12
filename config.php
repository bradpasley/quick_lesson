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
 * config.php - configuration file
 * 
 * IMPORTANT: Change database username/password then IGNORE THIS FILE from Git.
 */

class QuickConfig {
    public const USER_TABLE = "user";
    public const LESSON_TABLE = "lesson";
    public const QUIZ_TABLE = "quiz";
    public const GRADE_TABLE = "grade";
    public const DATABASE_SCHEMA = "quick_lesson";
    public const DATABASE_HOST = "localhost";
    public const DATABASE_USERNAME = "CHANGE"; //after changing username, DON'T include this file in git
    public const DATABASE_PASSWORD = "CHANGE"; //after changing password, DON'T include this file in git
}