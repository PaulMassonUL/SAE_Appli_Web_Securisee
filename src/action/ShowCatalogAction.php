<?php

namespace netvod\action;

use netvod\filtre\Tri;
use netvod\render\CatalogueRenderer;
use netvod\render\Renderer;
use netvod\video\Catalogue;

class ShowCatalogAction extends Action
{

    /**
     * @var Catalogue
     */
    private Catalogue $catalogue;

    /**
     * @param Catalogue $catalogue
     * Constructeur paramétré
     */
    public function __construct(Catalogue $catalogue)
    {
        $this->catalogue = $catalogue;
        parent::__construct();
    }

    /**
     * @return string
     * execute l'action
     */
    public function execute(): string
    {
        $renderer = new CatalogueRenderer($this->catalogue);
        $html = '<form id="mots-cles" action = "?action=addMotsCles" method="post">';
        $html .= '<input type="text" name="choixMotsCles" placeholder="mot(s) cle(s)"> <button type="submit"> Rechercher </button>';
        $html .= '</form>';

        $page = htmlspecialchars($_SERVER['PHP_SELF'] . '?action=' . $_GET['action']);
        $normal = Tri::FILTRE_NORMAL;
        $titre = Tri::FILTRE_TITRE;
        $date = Tri::FILTRE_DATE;
        $episodes = Tri::FILTRE_EPISODES;
        $note = Tri::FILTRE_NOTE;

        if ($this->http_method === 'POST' && isset($_POST['tri'])) {
            $tri = intval($_POST['tri']);
            header("Location: http://$_SERVER[HTTP_HOST]$page&tri=$tri");
        }
        if (isset($_GET['action']) && isset($_GET['tri'])) {
            $tri = intval($_GET['tri']);
            $this->catalogue->appliquerFiltre($tri);
        }
        $html .= <<<END
            <form id="choix" action="$page" method="post">
                <label id="" for="tri">Trier par :</label>
                <div>
                    <select name="tri"">
                        <option value="$normal">Aucun</option>
                        <option value="$titre">Titre</option>
                        <option value="$date">Date d'ajout</option>
                        <option value="$episodes">Nombre d'épisodes</option>
                        <option value="$note">Note</option>
                    </select>
                    <button type="submit">Trier</button>
                </div>
            </form>
            
        END;
        $html .= '<form method="post" action="?action=show-serie-details">';
        $html .= $renderer->render(Renderer::COMPACT);
        $html .= '</form>';

        return $html;
    }
}