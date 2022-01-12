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
    public string $jmeno = " ";
    //public int $page = 0;

    function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
        parent::__construct();
    }

    public function renderDefault(int $page = 1): void
    //public function renderDefault(): void CHYBNE NELZE VYHODIT $PAGE Z PARAMETRU
    {
        //$page = 1; CHYBA
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

    public function onSuccessGetForm(Form $form, $values)
    {
        $values = $form->getValues();
        $jmeno = $values['nick'];
        Debugger::barDump($jmeno);
        $this->redirect('Get:filterItem', $jmeno);
        //$this->redirect('Get:', $jmeno);
    }
    public function renderFilterItem(string $jmeno): void
    //public function renderDefault(string $jmeno): void  NEFUNGUJE STEJNY NAZEV, ALE JINY PARAMETR
    {
        //$this->template->postItems = $this->postManager->getOneItem($values['nick']);
        $this->template->postItems = $this->postManager->getOneItem($jmeno);
        $this->template->title = 'Přehled příspěvků ostravských otužilců - filtr dle jména';
    }

    public function createComponentGetForm()
    {
        $form = new Form();
        $form->addText('nick', 'Filtrovat dle jména / přezdívky');
        $razeni = ['asc' => 'vzestupně', 'des' => 'sestupně'];
        $form->addRadioList('radit', 'Řazení', $razeni);
        $form->addSubmit('insert', 'Odeslat');
        $form->onSuccess[] = [$this, 'onSuccessGetForm'];
        return $form;
    }
}
