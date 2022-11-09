<?php

namespace netvod\user;

use netvod\db\ConnectionFactory;
use netvod\video\Catalogue;
use PDOException;

class User
{
    private static ?User $instance = null;

    public static function getInstance(): ?User
    {
        return self::$instance;
    }

    public static function setInstance(User $user): void
    {
        self::$instance = $user;
        $_SESSION['user'] = true;
    }

    /**
     * email de l'utilisateur
     */
    private string $email;

    /**
     * mot de passe de l'utilisateur
     */
    private string $passwd;

    /**
     * catalogue de l'utilisateur
     */
    private Catalogue $catalogue;

    /**
     * liste de series preferées de l'utilisateur
     */
    private Catalogue $seriesPref;

    /**
     * liste des séries commencées
     */
    private Catalogue $serieenCours;

    /**
     * @param string $eml email
     * @param string $pwd mot de passe
     */
    public function __construct(string $eml, string $pwd)
    {
        $this->email = $eml;
        $this->passwd = $pwd;
    }

    /**
     * @return Catalogue
     */
    public function getCatalogue(): Catalogue
    {
        $serie1 = new \netvod\video\Serie(1,"Une série cool","fichier/img.png","horreur","adulte","vraiment une série trop cool",2020,"01/03/2021");
        $serie2 = new \netvod\video\Serie(2, "Une série encore plus cool", "fichier/img.png", "fantaisie", "ado", "trop bien", 2016, "06/05/2016");

        $text = "Maecenas at mattis dolor, ac egestas ex. Maecenas accumsan libero a euismod ullamcorper. Duis maximus purus in velit dapibus volutpat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc sit amet pretium nulla, nec lacinia mauris. Aenean ut accumsan justo. Vestibulum at sapien dapibus, dignissim diam sed, maximus diam. Nam semper fringilla justo ac consequat. Suspendisse auctor in eros sed lobortis. Donec efficitur eleifend ante id tempus.";

        $episode1 = new \netvod\video\Episode(1,"ressources/cars-by-night.mp4", "fast And furious", $text, "0:27", false);

        $episode2 = new \netvod\video\Episode(2,"ressources/beach.mp4", "Les dents de la mer", $text, "0:17", false);

        $episode3 = new \netvod\video\Episode(3, "ressources/horses.mp4", "Des cheveaux", $text, "0:07", false);

        $episode4 = new \netvod\video\Episode(4, "ressources/lake.mp4", "Un lac", $text, "0:08", false);

        $serie1->ajouterEpisode($episode1);
        $serie1->ajouterEpisode($episode2);

        $serie2->ajouterEpisode($episode3);
        $serie2->ajouterEpisode($episode4);

        $series = array($serie1,$serie2);

        $catalogue = new \netvod\video\Catalogue("AVAILABLE SERIES", $series);
        return $catalogue;
    }

    /**
     * @return Catalogue
     */
    public function getSeriesPref(): Catalogue
    {
        $serie1 = new \netvod\video\Serie(1,"Une série cool","ressources/beach.mp4","horreur","adulte","vraiment une série trop cool",2020,"01/03/2021");
        $serie2 = new \netvod\video\Serie(2, "Une série encore plus cool", "ressources/cars-by-night.mp4", "fantaisie", "ado", "trop bien", 2016, "06/05/2016");

        $text = "Maecenas at mattis dolor, ac egestas ex. Maecenas accumsan libero a euismod ullamcorper. Duis maximus purus in velit dapibus volutpat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc sit amet pretium nulla, nec lacinia mauris. Aenean ut accumsan justo. Vestibulum at sapien dapibus, dignissim diam sed, maximus diam. Nam semper fringilla justo ac consequat. Suspendisse auctor in eros sed lobortis. Donec efficitur eleifend ante id tempus.";

        $episode1 = new \netvod\video\Episode(1,"ressources/cars-by-night.mp4", "fast And furious", $text, "0:27", false);

        $episode2 = new \netvod\video\Episode(2,"ressources/beach.mp4", "Les dents de la mer", $text, "0:17", false);

        $episode3 = new \netvod\video\Episode(3, "ressources/horses.mp4", "Des cheveaux", $text, "0:07", false);

        $episode4 = new \netvod\video\Episode(4, "ressources/lake.mp4", "Un lac", $text, "0:08", false);

        $serie1->ajouterEpisode($episode1);
        $serie1->ajouterEpisode($episode2);

        $serie2->ajouterEpisode($episode3);
        $serie2->ajouterEpisode($episode4);

        $series = array($serie1,$serie2);

        $catalogue = new \netvod\video\Catalogue("FAVORITE SERIES", $series);
        return $catalogue;
    }

    public function getSeriesEnCours() : Catalogue {
        return $this->serieenCours;
    }

    public function ajouterSerieEnCours(Serie $s) {
        try {
            $query = "INSERT INTO serieVisionnee VALUES ( ? , ? )";
            $db = ConnectionFactory::makeConnection();
            $st = $db->prepare($db);
            $st->execute([$s->get('id'), $this->email]);
        } catch (PDOException $e) {
            throw new \Exception("erreur d'insersion dans catalogue en cours");
        }
        $this->serieenCours->ajouterSerie($s);
    }
}