<?php

namespace App\Presenters;


use \Nette\Application\UI\Presenter;
use App\Model\PostManager;
use \Nette\Application\UI\Form;

class GetPresenter extends Presenter
{

    private $postManager;

    function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
        parent::__construct();
    }

    public function renderDefault()
    {
        $this->template->postItems = $this->postManager->getAllItems();
        $this->template->title = 'Přehled příspěvků ostravských otužilců';
    }

    public function renderFiltrJmeno($jmeno){
        $this->template->postItems = $this->postManager->getFiltrJmeno($jmeno);
        $this->template->title = 'Přehled příspěvků ostravských otužilců - filtr dle jména';        
    }

    public function createComponentGetForm()
    {
        $form = new Form();
        $form->addText('nick', 'Filtrovat dle jména / přezdívky');
        $razeni = ['asc' => 'vzestupně', 'des' => 'sestupně'];
        $form->addRadioList('radit', 'Řazení', $razeni);
        $form->addSubmit('insert', 'Odeslat');
        $form->onSuccess[] = [$this, 'getItemFilter'];
        return $form;
    }
    

    

}