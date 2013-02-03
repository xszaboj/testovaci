<?php


namespace Todo;
use Nette;

class IncompleteTask extends Nette\Application\UI\Control
{
    /** @var \Nette\Database\Table\Selection */
    private $selected;

    public function __construct(Nette\Database\Table\Selection $selected)
    {
        parent::__construct(); // vždy je potřeba volat rodičovský konstruktor
        $this->selected = $selected;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/IncompleteTask.latte');
        $this->template->tasks = $this->selected;
        $this->template->render();
    }
}

