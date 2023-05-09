<?php

echo "Executing the robot... uh uh ah ah...\n\n\n";

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Interactions\WebDriverActions;
use Facebook\WebDriver\WebDriver;

require_once(__DIR__ . '/vendor/autoload.php');

$list = [
    'chirokero',
    'kaidolex.okabe'
];

$host = "http://localhost:4444/wd/hub";

$driver = RemoteWebDriver::create(
    $host, 
    DesiredCapabilities::chrome()
);

// Open browser
$driver->get("http://mbasic.facebook.com");
$driver->manage()->window();

// Login credentials
// $emailInput = $driver->findElement(WebDriverBy::id('email'));
$emailXPath = '//[]';
$emailInput = $driver->findElement(WebDriverBy::name('email'));
$emailInput->sendKeys('chris.tops132@gmail.com');
// $passwordInput = $driver->findElement(WebDriverBy::id('pass'));
$passwordInput = $driver->findElement(WebDriverBy::name('pass'));
$passwordInput->sendKeys('09084506172.Az');
$loginButton = $driver->findElement(WebDriverBy::name('login'));
$loginButton->click();

foreach ($list as $s) {
    // Wait a moment before redirecting to the user profile
    $driver->wait(10, 500)->until(function($driver) {
        $a = $driver->findElements(WebDriverBy::linkText('What\'s on your mind'));
        return $a !== null;
    });
    $driver->get('https://mbasic.facebook.com/' . $s);

    // Waiting to load profile before clicking message button
    $driver->wait(10, 500)->until(function($driver) {
        // $a = $driver->findElements(WebDriverBy::linkText('Write something'));
        $a = $driver->findElements(WebDriverBy::linkText('What\'s on your mind'));
        return $a !== null;
    });
    // $messageButton = $driver->findElement(WebDriverBy::cssSelector('div[role="button"]')->cssSelector('div[aria-label="Message"]'));
    $messageButton = $driver->findElement(WebDriverBy::linkText('Message'));
    $messageButton->click();

    // $messageButtonLocation = $messageButton->getLocation();

    // print_r([
    //     $messageButtonLocation->getX(),
    //     $messageButtonLocation->getY(),
    // ]);

    // $a = new WebDriverActions($driver);

    // $a->moveToElement(
    //     $messageButton, 
    //     $messageButtonLocation->getX(), 
    //     $messageButtonLocation->getY()
    // )->doubleClick()->perform();

    // Sending message

    $driver->wait(10, 500)->until(function($driver) {
        // $a = $driver->findElements(WebDriverBy::id('div[role="textbox"]')->cssSelector('div[aria-label="Message"]'));
        $xPathMessage = '//textarea[(@id="composerInput" or @name="body")]';
        $a = $driver->findElement(WebDriverBy::xpath($xPathMessage));
        return $a !== null;
    });

    $xPathMessage = '//textarea[(@id="composerInput" or @name="body")]';
    $messageText = $driver->findElement(WebDriverBy::xpath($xPathMessage));
    // $messageText = $driver->findElement(WebDriverBy::cssSelector('div[aria-label="Message"]')->cssSelector('div[role="textbox"]'));
    $messageText->sendKeys('wag ka magchat');

    // $sendButton = $driver->findElement(WebDriverBy::cssSelector('div[aria-label="Press enter to send"]'));
    $xPathSend = '//input[(@name="send" or @name="Send")]';
    $sendButton = $driver->findElement(WebDriverBy::xpath($xPathSend));
    $sendButton->click();
}

echo "End of execution...\n\n\n";

// $searchBar = $driver->findElement(WebDriverBy::partialLinkText('Search Facebook'));
// $searchBar->click()->sendKeys('testingtesting');

