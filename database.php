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
 * database.php - database management file - to retrieve user and lesson content from MySQL Database
 */


include_once("lib.php");
include_once("config.php");

class QuickDatabase {
    
    //QuickDatabase Variables
    private $DBConnection;
    private $DBConnectionStatus; //turns 'true' if the connectToDatabase() function is called, 'false' if closeDatabase() called.

    public function __construct(bool $connectToDatabaseNow=false) {
        $this->DBConnectionStatus = false;
        if($connectToDatabaseNow) $this->connectToDatabase();
    }

    //Database connection/close functions
    private function connectToDatabase() {
        
        try {
            $this->DBConnection = new mysqli(QuickConfig::DATABASE_HOST,QuickConfig::DATABASE_USERNAME,QuickConfig::DATABASE_PASSWORD);

            
            /* check connection */
            if (mysqli_connect_errno()) {
                //$mysqlError = mysqli_connect_error(); //don't include in error to keep the error message cleaner
                println();
                printlnError("Failed to connect to database host.".PHP_EOL." The server appears to be out of reach.");
                exit();
            }

            if($this->DBConnection === false) {
                println();
                printlnError("Could not connect to database host");
                $this->DBConnectionStatus = false;
                exit();
            }
            $this->DBConnection->set_charset("utf8mb4");
            $this->DBConnection->mysqli_query('SET NAMES utf8mb4');
            $this->DBConnectionStatus = true;
        } catch (mysqli_sql_exception $e) {
            printlnError("We apologise there appears to be a database issue.");
            throw $e;
        }
    }

    private function closeDatabase() {
        
        mysqli_close($this->DBConnection);
        $this->DBConnectionStatus = false;
    }

    //Database check functions

    /**
     * function createNewUser()
     * hashes password and creates a new user
     * returns true if successfully added, false if failed.
     */

    public function createNewUser(string $email, string $password, string $firstname, string $surname) {
        $this->connectToDatabase();
        if(!$this->DBConnectionStatus) $this->connectToDatabase(); //to ensure database connection made first.

        $hashedPassword = password_hash($password);

        $sqlInsertUserCommand = "INSERT INTO `".QuickConfig::DATABASE_SCHEMA."`.`".QuickConfig::USER_TABLE."` "
                            ."(`email`, `firstname`, `lastname`, `password`)"
                            ."VALUES ('%s', '%s', '%s', '%s')";
        $sqlInsertUserCommand = sprintf($sqlInsertUserCommand, 
                                    mysqli_real_escape_string($this->DBConnection, $email),
                                    mysqli_real_escape_string($this->DBConnection, $firstname),
                                    mysqli_real_escape_string($this->DBConnection, $lastname),
                                    mysqli_real_escape_string($this->DBConnection, $hashedPassword));

        if($queryResult = mysqli_query($this->DBConnection,$sqlInsertUserCommand)) {
            return true;
        } else {
            return false;
        }
     }

    public function getLessonTitle(int $lessonID, int $moduleID=0, int $conceptID=0) {
        $this->connectToDatabase();
        if(!$this->DBConnectionStatus) $this->connectToDatabase(); //to ensure database connection made first.

        $sqlQueryTitle = "";

        if($moduleID==0 && $conceptID==0) {//Lesson title
            $sqlQueryTitle = "SELECT title FROM `".QuickConfig::DATABASE_SCHEMA."`.`".QuickConfig::LESSON_TABLE."` "
                            ."WHERE lessonID='%s' AND moduleID=0 AND conceptID=0";
            $sqlQueryTitle = sprintf($sqlQueryLessonTitle, 
                                    mysqli_real_escape_string($this->DBConnection, $lessonID));
        } else if($conceptID==0) {//Module title
            $sqlQueryTitle = "SELECT title FROM `".QuickConfig::DATABASE_SCHEMA."`.`".QuickConfig::LESSON_TABLE."` "
            ."WHERE lessonID='%s' AND moduleID='%s' AND conceptID=0";
            $sqlQueryTitle = sprintf($sqlQueryLessonTitle, 
                    mysqli_real_escape_string($this->DBConnection, $lessonID),
                    mysqli_real_escape_string($this->DBConnection, $moduleID));
        } else {//concept title
            $sqlQueryTitle = "SELECT title FROM `".QuickConfig::DATABASE_SCHEMA."`.`".QuickConfig::LESSON_TABLE."` "
            ."WHERE lessonID='%s' AND moduleID='%s' AND conceptID='%s'";
            $sqlQueryTitle = sprintf($sqlQueryLessonTitle, 
                    mysqli_real_escape_string($this->DBConnection, $lessonID),
                    mysqli_real_escape_string($this->DBConnection, $moduleID),
                    mysqli_real_escape_string($this->DBConnection, $conceptID));
        }
        
        if($queryResult = mysqli_query($this->DBConnection,$sqlQueryTitle)) {
            $row = $queryResult->fetch_row();
            $title = $row[0];
            return $title;
        } else {
            return "{unknown}";
        }
     }
     
    public function getLessonContent(int $lessonID, int $moduleID=0, int $conceptID=0) {
        $this->connectToDatabase();
        if(!$this->DBConnectionStatus) $this->connectToDatabase(); //to ensure database connection made first.

        $hashedPassword = password_hash($password);

        $sqlQueryContent = "";

        if($moduleID==0 && $conceptID==0) {//Lesson content
            $sqlQueryContent = "SELECT content FROM `".QuickConfig::DATABASE_SCHEMA."`.`".QuickConfig::LESSON_TABLE."` "
                            ."WHERE lessonID='%s' AND moduleID=0 AND conceptID=0";
            $sqlQueryContent = sprintf($sqlQueryLessonTitle, 
                                    mysqli_real_escape_string($this->DBConnection, $lessonID));
        } else if($conceptID==0) {//Module content
            $sqlQueryContent = "SELECT content FROM `".QuickConfig::DATABASE_SCHEMA."`.`".QuickConfig::LESSON_TABLE."` "
            ."WHERE lessonID='%s' AND moduleID='%s' AND conceptID=0";
            $sqlQueryContent = sprintf($sqlQueryLessonTitle, 
                    mysqli_real_escape_string($this->DBConnection, $lessonID),
                    mysqli_real_escape_string($this->DBConnection, $moduleID));
        } else {//concept content
            $sqlQueryContent = "SELECT content FROM `".QuickConfig::DATABASE_SCHEMA."`.`".QuickConfig::LESSON_TABLE."` "
            ."WHERE lessonID='%s' AND moduleID='%s' AND conceptID='%s'";
            $sqlQueryContent = sprintf($sqlQueryLessonTitle, 
                    mysqli_real_escape_string($this->DBConnection, $lessonID),
                    mysqli_real_escape_string($this->DBConnection, $moduleID),
                    mysqli_real_escape_string($this->DBConnection, $conceptID));
        }
        
        if($queryResult = mysqli_query($this->DBConnection,$sqlQueryContent)) {
            $row = $queryResult->fetch_row();
            $content = $row[0];
            return $content;
        } else {
            return "{unknown}";
        }
     }

}//end of class

?>