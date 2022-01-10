<?php

namespace App\Presenters;


use \Nette\Application\UI\Presenter;
use App\Model\PostManager;
use \Nette\Application\UI\Form;
use Nette;
use \Tracy\Debugger;

class GetPresenter extends Presenter
{

    private $postManager;

    function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
        parent::__construct();
    }

    public function renderDefault(int $page = 1) : void
    {
        $articlesCount = $this->postManager->getPublishedArticlesCount();
        $paginator = new Nette\Utils\Paginator;
        $paginator->setItemCount($articlesCount); // celkový počet článků
		$paginator->setItemsPerPage(5); // počet položek na stránce
		$paginator->setPage($page);
        $articles = $this->postManager->getAllItems($paginator->getLength(), $paginator->getOffset());
        $this->template->postItems = $articles;
		// a také samotný Paginator pro zobrazení možností stránkování
		$this->template->paginator = $paginator;
        $this->template->title = 'Přehled příspěvků ostravských otužilců';
        
    }
    // public function renderDefault() : void
    // {
    //     $this->template->postItems = $this->postManager->getAllItems();
    //     $this->template->title = 'Přehled příspěvků ostravských otužilců';
    // }

   public function renderFilterItem(Form $form, $values)
    {
        Debugger::barDump($form);
        $values = $form->getValues();
        $this->template->postItems = $this->postManager->getOneItem($values['nick']);
        $this->template->title = 'Přehled příspěvků ostravských otužilců - filtr dle jména';
    }
    // public function renderFilterItem($jmeno)
    // {
    //     $this->template->postItems = $this->postManager->getOneItem($jmeno);
    //     $this->template->title = 'Přehled příspěvků ostravských otužilců - filtr dle jména';
    // }

    public function createComponentGetForm()
    {
        $form = new Form();
        $form->addText('nick', 'Filtrovat dle jména / přezdívky');
        $razeni = ['asc' => 'vzestupně', 'des' => 'sestupně'];
        $form->addRadioList('radit', 'Řazení', $razeni);
        $form->addSubmit('insert', 'Odeslat');
        $form->onSuccess[] = [$this, 'renderFilterItem'];
        return $form;
    }
    // public function postFilterItem(Form $form, $values)
    // {
    //     $values = $form->getValues();
    //     $jmeno = $values->nick;
    //     $this->postManager->getOneItem($jmeno);
    //     $this->redirect('Get:renderFilterItem');
    // }

    
}
