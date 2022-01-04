<?php

namespace App\Presenters;

use \Nette\Application\UI\Presenter;
use App\Model\PostManager;
use \Nette\Application\UI\Form;
use \Tracy\Debugger;

class PostPresenter extends Presenter
{
    private $postManager;

    function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
        parent::__construct();
    }

    public function createComponentPostForm()
    {
        $form = new Form();
        $form->addText('nick', 'Přezdívka / Jméno');
        $form->addEmail('email', 'Email');
        $form->addCheckboxList('checkboxy', 'Zatrhni co praktikuješ', array(
            'klidna' => 'Pobyt v klidné ledové vodě ',
            'tekouci' => 'Pobyt v tekoucí ledové vodě ',
            'sprcha' => 'Studené sprchování ',
            'sauna' => 'Pobyt v sauně '
        ));

        $jezera = [
            '1' => 'Kališok Starý Bohumín',
            '2' => 'Štěrkovna Hlučín',
            '3' => 'Vrbice Bohumín',
        ];
        $form->addSelect('jezero', 'Vyberte preferované jezero', $jezera)
            ->setDefaultValue('2');
        $reky = [
            '1' => 'Odra, splav Svinov',
            '2' => 'Ostravice, splav Vratimov',
            '3' => 'Čeladenka, splav Čeladná',
        ];
        $form->addMultiSelect('reka', 'Vyberte preferovanou řeku', $reky)->setDefaultValue('2');
        $form->addTextArea('text', 'Příspěvek');
        $form->addSubmit('insert', 'Vložit');
        $form->onSuccess[] = [$this, 'postItemInsert'];
        return $form;
    }

    public function postItemInsert(Form $form, $values)
    {
        $values = $form->getValues();
        Debugger::barDump($form->getValues());
        $nick = $values->nick;
        $email = $values->email;
        $klidna = 0;
        $tekouci = 0;
        $sprcha = 0;
        $sauna = 0;
        foreach ($values->checkboxy as $item) {
            switch ($item) {
                case "klidna":
                    $klidna = 1;
                    break;
                case "tekouci":
                    $tekouci = 1;
                    break;
                case "sprcha":
                    $sprcha = 1;
                    break;
                case "sauna":
                    $sauna = 1;
                    break;
            }
        }
        $jezero = $values->jezero;
        $reka = $values->reka[0];
        $text = $values->text;
        
        //KOMBINACE $VALUES A OSTATNICH PROMENNYCH HLASILO MULTI-INSERTED...BUT WASNT ARRAY.
        $this->postManager->savePostItems(
            $nick,
            $email,
            $klidna,
            $tekouci,
            $sprcha,
            $sauna,
            $jezero,
            $reka,
            $text
        );
        $this->flashMessage('Příspěvek vložen.');
        // $this->postManager->savePostItems($values['nick'], $values['email'], $klidna, $tekouci,
        // $sprcha, $sauna, $values['jezero'], $values['reka'], $values['text']);
    }
}
