<?php
use PHPUnit\Framework\TestCase;

class ArticlesControllerTest extends TestCase
{
    public function testStoreSuccess()
    {
        $_POST['title'] = 'Test Title';
        $_POST['abstract'] = 'Test Abstract';
        $_POST['text'] = 'Test content of the article';
        $_SESSION["USER_ID"] = 1; // Uporabniški ID, ki je prijavljen

        $controller = new articles_controller();

        ob_start();
        $controller->store();
        $output = ob_get_clean();

        $this->assertContains('Location: ?controller=articles&action=index', $output);
    }

    public function testStoreFailureMissingFields()
    {
        // Simuliraj, da manjkajo potrebni podatki
        $_POST['title'] = '';
        $_POST['abstract'] = '';
        $_POST['text'] = '';

        $controller = new articles_controller();

        ob_start();
        $controller->store();
        $output = ob_get_clean();

        $this->assertContains('Location: ?controller=pages&action=error', $output);
    }
}
