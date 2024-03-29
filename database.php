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
    private $DBConnectionStatus = false; //turns 'true' if the connectToDatabase() function is called, 'false' if closeDatabase() called.

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
        if(!$this->DBConnectionStatus) $this->connectToDatabase(); //to ensure database connection made first.
        $sqlQueryTitle = "";
        //println("<h5>getLessonTitle($lessonID, $moduleID, $conceptID) Database? $DBConnectionStatus</h5>");
        if($moduleID==0 && $conceptID==0) {//Lesson title
            $sqlQueryTitle = "SELECT title FROM ".QuickConfig::DATABASE_SCHEMA.".".QuickConfig::LESSON_TABLE." "
                            ."WHERE lessonid='$lessonID' AND moduleid=0 AND conceptid=0";
        } else if($conceptID==0) {//Module title
            $sqlQueryTitle = "SELECT title FROM ".QuickConfig::DATABASE_SCHEMA.".".QuickConfig::LESSON_TABLE." "
                            ."WHERE lessonid='$lessonID' AND moduleid='$moduleID' AND conceptid=0";
        } else {//concept title
            $sqlQueryTitle = "SELECT title FROM ".QuickConfig::DATABASE_SCHEMA.".".QuickConfig::LESSON_TABLE." "
                            ."WHERE lessonid='$lessonID' AND moduleid='$moduleID' AND conceptid='$conceptID'";
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
        
        if(!$this->DBConnectionStatus) $this->connectToDatabase(); //to ensure database connection made first.

        $sqlQueryContent = "";

        if($moduleID==0 && $conceptID==0) {//Lesson content
            $sqlQueryContent = "SELECT content FROM ".QuickConfig::DATABASE_SCHEMA.".".QuickConfig::LESSON_TABLE." "
                            ."WHERE lessonid='$lessonID' AND moduleid=0 AND conceptid=0";
        } else if($conceptID==0) {//Module content
            $sqlQueryContent = "SELECT content FROM `".QuickConfig::DATABASE_SCHEMA."`.`".QuickConfig::LESSON_TABLE."` "
                            ."WHERE lessonid='$lessonID' AND moduleid='$moduleID' AND conceptid=0";
        } else {//concept content
            $sqlQueryContent = "SELECT content FROM `".QuickConfig::DATABASE_SCHEMA."`.`".QuickConfig::LESSON_TABLE."` "
            ."WHERE lessonid='$lessonID' AND moduleid='$moduleID' AND conceptid='$conceptID'";
        }
        
        if($queryResult = mysqli_query($this->DBConnection,$sqlQueryContent)) {
            $row = $queryResult->fetch_row();
            $content = $row[0];
            return $content;
        } else {
            return "{unknown}";
        }
    }


    public function getJSONLesson(int $lessonID, int $moduleID=0) {
        
        if(!$this->DBConnectionStatus) $this->connectToDatabase(); //to ensure database connection made first.

        $sqlQueryContent = "";

        if($moduleID==0) {//Lesson content (just Lesson metadata)
            $sqlQueryContent = "SELECT title, content, contentHTML FROM ".QuickConfig::DATABASE_SCHEMA.".".QuickConfig::LESSON_TABLE." "
                            ."WHERE lessonid='$lessonID' AND moduleid=0 AND conceptid=0";
        } else {//Module content (Module metadata and each concept)
            $sqlQueryContent = "SELECT conceptid, title, content FROM `".QuickConfig::DATABASE_SCHEMA."`.`".QuickConfig::LESSON_TABLE."` "
                            ."WHERE lessonid='$lessonID' AND moduleid='$moduleID'";
        }
        
        if($queryResult = mysqli_query($this->DBConnection,$sqlQueryContent)) {
            //println($sqlQueryContent);
            //println("<p>result fields: ".$queryResult->field_count."</p>");
            //println("<p>result rows: ".$queryResult->num_rows."</p>");
            $table = $queryResult->fetch_all(MYSQLI_BOTH);
            //println("<p>table preconvert: (not displayed intentionally)");
            //var_dump($table);
            $table = $this->convert_lesson_array($table); //convert plain text to HTML friendly text.
            //println("<p>table after convert: (not displayed intentionally)");
           // var_dump($table);
            //print("</p>");
            $resultJson = json_encode($table, JSON_FORCE_OBJECT);
	    //print("<p>resultJson: $resultJson</p>");
            return $resultJson;
        } else {
            return "{error:unknown_error}";
        }
    }

    /**
     * convert content
     * array - should be an array of arrays - rows containing cell elements
     * if contentHTML is empty/null, then convert "content" cell to HTML friendly text
     * if contentHTML has content, then output the 'content' cell with the contentHTML value.
     * 'content' is used in JSON/Javascript to display to web
     */
    private function convert_lesson_array(array $table) {
        //println("<p>convert_lesson_array()");
        foreach($table as $rowID => $row) {
            //println("<p>row($rowID):");
            //var_dump($row);
            $plainTextContent = $table[$rowID]['content'];
            //println("<p>content cell($rowID): ".$table[$rowID]['content']);
            if(!isset($row['contentHTML']) || $row['contentHTML']=='') { //contentHTML has no content, so convert plain content to HTML friendly output
                $htmlContent = text_to_html($plainTextContent);//convert plaintext to html
                //println("<p>content plain to HTML cell($rowID): ".$htmlContent);
            } else {
                $plainTextContent = $table[$rowID]['content'];
                $htmlContent = $table[$rowID]['contentHTML'];//change 'content' values to 'contentHTML' values
                //println("<p>content HTML cell($rowID): ".$table[$rowID]['contentHTML']);
            }
            foreach($row as $cellID => $cell) {//change each cell that has the 'content' value (i.e. both number and text key)
                if($table[$rowID][$cellID]==$plainTextContent)
                   $table[$rowID][$cellID] = $htmlContent;
            }
        }
        return $table;
    }

    function getNumberOfLessons() {
        if(!$this->DBConnectionStatus) $this->connectToDatabase(); //to ensure database connection made first.

        $sqlCountQuery = "SELECT COUNT(DISTINCT(lessonid)) FROM ".QuickConfig::DATABASE_SCHEMA.".".QuickConfig::LESSON_TABLE;
        
        if($queryResult = mysqli_query($this->DBConnection,$sqlCountQuery)) {
            $row = $queryResult->fetch_row();
            $content = $row[0];
            return $content;
        } else {
            return 0;
        }
    }

    function getNumberOfModulesInLesson(int $lessonID) {
        if(!$this->DBConnectionStatus) $this->connectToDatabase(); //to ensure database connection made first.

        $sqlCountQuery = "SELECT COUNT(DISTINCT(moduleid)) FROM ".QuickConfig::DATABASE_SCHEMA.".".QuickConfig::LESSON_TABLE." "
                            ."WHERE lessonid='$lessonID' AND moduleid!=0";
        
        if($queryResult = mysqli_query($this->DBConnection,$sqlCountQuery)) {
            $row = $queryResult->fetch_row();
            $content = $row[0];
            return $content;
        } else {
            return 0;
        }
    }

    function getNumberOfConceptsInModule(int $lessonID, int $moduleID) {
        //println("getNumberConcepts: lesson: $lessonID, module: $moduleID");
        if(!$this->DBConnectionStatus) $this->connectToDatabase(); //to ensure database connection made first.
        
        $sqlCountQuery = "SELECT COUNT(DISTINCT(conceptid)) FROM ".QuickConfig::DATABASE_SCHEMA.".".QuickConfig::LESSON_TABLE." "
                            ."WHERE lessonid='$lessonID' AND moduleid='$moduleID' AND conceptid!=0";
        
        if($queryResult = mysqli_query($this->DBConnection,$sqlCountQuery)) {
            $row = $queryResult->fetch_row();
            $count = $row[0];
            //println("getNumberConcepts: $count");
            return $count;
        } else {
            return 0;
        }
    }

}//end of class

?>
