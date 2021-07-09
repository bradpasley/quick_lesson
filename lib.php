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

function printHTMLHeader(string $HTMLPageTitle) {
    $bootstrapURL        = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css";
    //$javascriptURL       = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js";
    $javascriptBundleURL = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js";
    ?>
    <!doctype html>'
    <html lang="en">'
    <head>'
    <meta charset="utf-8">'
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?$bootstrapURL?>">
    <title><?$HTMLPageTitle?></title>
    <!-- Bootstrap CSS -->
    <script src=<?$javascriptBundleURL?>></script>
    </head>
    <?
}

function printHTMLBodyStart(string $pageTitle, string $lessonTitle="") {
    ?>
    <body>
    <h1><?$pageTitle?></h1>
    <h3><?$lessonTitle?></h3>
    <?
}

function printHTMLFooter() {
    //$javascriptURL       = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js";
    $javascriptBundleURL = "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js";
    ?>
    <!-- Bootstrap Bundle with Popper -->
    <script src="<?$javascriptURL?>"></script>
    <script src="<?$javascriptBundleURL?>"></script>
    </body>
    </html>
    <?
}

function printLogin() {
    ?>
    <form>
    <label>Username:</label>
    <input type="text" placeholder="username" />
    <label>Password:</label>
    <input type="password" placeholder="password" />
    <input type="submit" value="Log in"  />
    </form>
    <?
}

function printMenuCard(string $cardTitle, string $cardContent, string $lessonLink="#") {
    ?>
    <div class="card">
    <div class="card-body">
      <h4 class="card-title"><?$cardTitle?></h4>
      <p class="card-text"><?$cardContent?></p>
      <a href="<?$lessonLink?>" class="card-link">Get started...</a>
    </div>
  </div>
  <?
}



?>