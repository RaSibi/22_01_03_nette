<?php

namespace App\Model;

use Nette;
use Nette\Database\Explorer;
use \Tracy\Debugger;

class PostManager
{
    use Nette\SmartObject;
    protected $database;

    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

    //STRANKOVANI PAGINATOR
    public function getAllItems(int $limit, int $offset): Nette\Database\ResultSet
    {
        return $this->database->query('SELECT h.nickname, h.email, j.popis AS id_jezero, r.popis AS id_reka, h.klidna_voda, h.tekouci_voda, h.sprcha, h.sauna, text
        FROM hlavni h
        LEFT JOIN jezera j ON h.id_jezero = j.id
        LEFT JOIN reky r ON h.id_reka = r.id
        LIMIT ?
        OFFSET ?', $limit, $offset);
    }
    public function getPublishedArticlesCount(): int
    {
        return $this->database->fetchField('SELECT COUNT(*) FROM hlavni');
    }
    
    //FILTR DLE JMENA
    //public function getOneItem(int $limit, int $offset, string $jmeno): Nette\Database\ResultSet
    public function getOneItem(string $jmeno): Nette\Database\ResultSet
    {
        return $this->database->query('SELECT h.nickname, h.email, j.popis AS id_jezero, r.popis AS id_reka,
        h.klidna_voda, h.tekouci_voda, h.sprcha, h.sauna, text
        FROM hlavni h
        LEFT JOIN jezera j ON h.id_jezero = j.id
        LEFT JOIN reky r ON h.id_reka = r.id
        WHERE h.nickname = ?',
        $jmeno);
        //OFFSET ?',$jmeno, $limit, $offset);
    }

    public function savePostItems($nick, $email, $klidna, $tekouci, $sprcha, $sauna, $jezero, $reka, $text): void
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
    
    //PUVODNI KOD DLE RADIMA DOSTALA
    // public function getAllItems()
    // {
    //     $database = $this->database;
    //     $database->beginTransaction();
    //     $queryUvod = 'SELECT h.nickname, h.email, j.popis AS id_jezero, r.popis AS id_reka, 
    //     h.klidna_voda, h.tekouci_voda, h.sprcha, h.sauna, text
    //     FROM hlavni h
    //     LEFT JOIN jezera j ON h.id_jezero = j.id
    //     LEFT JOIN reky r ON h.id_reka = r.id';
    //     $rows = $database->query($queryUvod)->fetchAll();
    //     $database->commit();
    //     Debugger::barDump($rows);
    //     return $rows; //Obvykle se vrací DTO - Data Transfer Object(y)
    // }
}
