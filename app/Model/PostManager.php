<?php

namespace App\Model;

use Nette\Database\Explorer;

class PostManager
{
    protected $database;

    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

    public function getAllItems()
    {
        $database = $this->database;
        $database->beginTransaction();
        $queryUvod = 'SELECT h.nickname, h.email, j.popis AS id_jezero, r.popis AS id_reka, h.klidna_voda, h.tekouci_voda, h.sprcha, h.sauna, text
        FROM hlavni h
        LEFT JOIN jezera j ON h.id_jezero = j.id
        LEFT JOIN reky r ON h.id_reka = r.id';
        $rows = $database->query($queryUvod)->fetchAll();
        $database->commit();
        //Debugger::barDump($rows);
        return $rows; //Obvykle se vrací DTO - Data Transfer Object(y)
    }

    public function savePostItems($nick, $email, $klidna, $tekouci, $sprcha, $sauna, $jezero, $reka, $text)
    {
        $database = $this->database;
        $database->beginTransaction();
        try {
            $database->query('INSERT INTO hlavni (nickname, email, klidna_voda, tekouci_voda, sprcha, sauna, id_jezero, id_reka, text)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', $nick, $email, $klidna, $tekouci, $sprcha, $sauna, $jezero, $reka, $text);
            $database->commit();
        } catch (\Exception $e) {
            $database->rollback();
            throw $e;
        }
    }

    //FILTR DLE JMENA
    public function getFiltrJmeno($jmeno)
    {
        $database = $this->database;
        $database->beginTransaction();
        $queryUvod = 'SELECT h.nickname, h.email, j.popis AS id_jezero, r.popis AS id_reka, h.klidna_voda, h.tekouci_voda, h.sprcha, h.sauna, text
        FROM hlavni h
        LEFT JOIN jezera j ON h.id_jezero = j.id
        LEFT JOIN reky r ON h.id_reka = r.id';
        $row = $database->fetch($queryUvod . 'WHERE h.nickname = ?', $jmeno);
        $database->commit();
        //Debugger::barDump($rows);  je zajímavé zkusit odkomentovat
        return $row; //Obvykle se vrací DTO - Data Transfer Object(y)
    }
}
