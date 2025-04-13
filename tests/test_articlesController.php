<?php
use PHPUnit\Framework\TestCase;

class ArticlesControllerTest extends TestCase
{
    protected function setUp(): void
    {
        // Start the session to simulate a logged-in user
        session_start();
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

    public function testStoreSuccess()
    {
        // Simulate form input for storing a new article
        $_POST['title'] = 'Test Title';
        $_POST['abstract'] = 'Test Abstract';
        $_POST['text'] = 'Test content of the article';
        $_SESSION["USER_ID"] = 1; // Simulate a logged-in user

        // Mock the controller and call the store method
        $controller = new articles_controller();
        
        ob_start(); // Capture output
        $controller->store();
        $output = ob_get_clean(); // Get the captured output

        // Assert that the redirect is to the index page
        $this->assertStringContainsString('Location: ?controller=articles&action=index', $output);
    }

    public function testStoreFailureMissingFields()
    {
        // Simulate missing fields in the form
        $_POST['title'] = '';
        $_POST['abstract'] = '';
        $_POST['text'] = '';

        $_SESSION["USER_ID"] = 1; // Simulate a logged-in user

        // Mock the controller and call the store method
        $controller = new articles_controller();

        ob_start(); // Capture output
        $controller->store();
        $output = ob_get_clean(); // Get the captured output

        // Assert that the redirect is to the error page
        $this->assertStringContainsString('Location: ?controller=pages&action=error', $output);
    }

    public function testStoreFailureNotLoggedIn()
    {
        // Simulate user not being logged in
        unset($_SESSION["USER_ID"]);

        // Simulate form input
        $_POST['title'] = 'Test Title';
        $_POST['abstract'] = 'Test Abstract';
        $_POST['text'] = 'Test content of the article';

        // Mock the controller and call the store method
        $controller = new articles_controller();

        ob_start(); // Capture output
        $controller->store();
        $output = ob_get_clean(); // Get the captured output

        // Assert that the redirect is to the error page
        $this->assertStringContainsString('Location: ?controller=pages&action=error', $output);
    }
}
