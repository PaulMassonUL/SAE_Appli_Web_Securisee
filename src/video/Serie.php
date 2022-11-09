<?php

namespace netvod\video;

use netvod\db\ConnectionFactory;
use netvod\exception\InvalidPropertyNameException;

class Serie
{
    private int $id;

    private string $titre;

    private string $descriptif;

    private string $image;

    private int $annee;

    private string $dateAjout;

    private string $genre;

    private string $public;

    private array $episodes;


    public function __construct(int $id, string $t, string $desc, string $img, int $annee, string $dateAjout, string $genre, string $public)
    {
        $this->id = $id;
        $this->titre = $t;
        $this->descriptif = $desc;
        $this->image = $img;
        $this->annee = $annee;
        $this->dateAjout = $dateAjout;
        $this->genre = $genre;
        $this->public = $public;
        $this->episodes = $this->getEpisodes();
    }

    public function getEpisodes(): array
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT * FROM episode WHERE serie_id = :id");
        $resultset->execute(['id' => $this->id]);

        $episodes = [];
        while ($row = $resultset->fetch()) {
            $episodes[] = new Episode($row['id'], $row['numero'], $row['titre'], $row['resume'], $row['duree'], $row['file']);
        }
        return $episodes;
    }

    public function getCommentaires(): array
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT * FROM Commentaire WHERE serie_id = :id");
        $resultset->execute(['id' => $this->id]);

        $commentaires = [];
        while ($row = $resultset->fetch()) {
            $commentaires[$row['email']] = $row['commentaire'];
        }
        return $commentaires;
    }

    /**
     * @return bool true si la série est en cours, false sinon
     */
    public function estEnCours(): bool
    {
        foreach ($this->episodes as $ep) {
            if ($ep->estVu()) {
                return true;
            }
        }
        return false;
    }

    public function estPreferee(): bool
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT count(*) as nb FROM seriePreferee WHERE idSerie = :id and email = :email");
        $user = unserialize($_SESSION['user']);
        $resultset->execute(['id' => $this->id, 'email' => $user->__get("email")]);

        $row = $resultset->fetch();
        return $row['nb'] == 1;
    }

    public function getNote(): float
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT note FROM Notation WHERE idSerie = :id and email = :email");
        $user = unserialize($_SESSION['user']);
        $resultset->execute(['id' => $this->id, 'email' => $user->__get("email")]);

        $row = $resultset->fetch();
        return $row['note'];
    }

    public function estCommentee(): bool
    {
        $connection = ConnectionFactory::makeConnection();
        $resultset = $connection->prepare("SELECT count(*) as nb FROM Commentaire WHERE idSerie = :id and email = :email");
        $user = unserialize($_SESSION['user']);
        $resultset->execute(['id' => $this->id, 'email' => $user->__get("email")]);

        $row = $resultset->fetch();
        return $row['nb'] == 1;
    }


    public function ajouterPreferee(): void
    {
        if (!$this->estPreferee()) {
            $db = ConnectionFactory::makeConnection();
            $st = $db->prepare("INSERT INTO seriePreferee VALUES ( ? , ? )");
            $user = unserialize($_SESSION['user']);
            $st->execute([$this->id, $user->__get("email")]);
        }
    }

    public function ajouterNote(float $note): void
    {
        if (!$this->estNotee()) {
            $db = ConnectionFactory::makeConnection();
            $st = $db->prepare("INSERT INTO Notation VALUES ( ? , ? , ? )");
            $user = unserialize($_SESSION['user']);
            $st->execute([$this->id, $user->__get("email"), $note]);
        }
    }

    public function ajouterCommentaire(string $commentaire): void
    {
        if (!$this->estCommentee()) {
            $db = ConnectionFactory::makeConnection();
            $st = $db->prepare("INSERT INTO Commentaire VALUES ( ? , ? , ? )");
            $user = unserialize($_SESSION['user']);
            $st->execute([$this->id, $user->__get("email"), $commentaire]);
        }
    }


    public function getEpisodeByNum(int $num): ?Episode
    {
        foreach ($this->episodes as $ep) {
            if ($ep->__get("numero") == $num) {
                return $ep;
            }
        }
        return null;
    }

    public function __get($attrname)
    {
        if (property_exists($this, $attrname)) return $this->$attrname;
        throw new InvalidPropertyNameException("Nom d'attribut invalide : $attrname");
    }

    public function __set($attrname, $value)
    {
        if (property_exists($this, $attrname)) $this->$attrname = $value;
        else throw new InvalidPropertyNameException("Nom d'attribut invalide : $attrname");
    }
}