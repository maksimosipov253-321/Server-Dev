<?php

namespace App\Controllers;

class MainController extends AbstractController
{
    public function main()
    {
        $this->view->renderHtml('main/main.php');
    }

    public function sayHello(string $name)
    {
        $this->view->renderHtml('main/hello.php', [
            'name' => $name,
            'title' => 'Страница приветствия',
        ]);
    }

    public function sayBye(string $name)
    {
        $this->view->renderHtml('main/bye.php', [
            'name' => $name,
        ]);
    }
}
