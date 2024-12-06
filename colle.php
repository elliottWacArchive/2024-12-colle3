<?php

class C3PO extends Robot
{
    protected $numeroDeSerie;
    private $nom;
    protected static $compteur = 0;
    private $type = "droide de protocole";

    public function __construct($nom)
    {
        self::$compteur++;
        $this->numeroDeSerie = self::$compteur;
        $this->nom = $nom;
        echo "Je suis le droïde de protocole numéro " . $this->numeroDeSerie . ", enchanté de vous rencontrer !\n";
    }

    public function initierProtocole()
    {
        $repos = false;
        while ($repos == false) {
            echo "En attente d’interaction utilisateur : \n";
            $var = trim(fgets(STDIN));
            if ($var == "repos") {
                $repos = true;
                echo "Fin du protocole.\n";
                break;
            }
            $tab = [];
            $inStr = false;
            $j = 0;
            for ($i = 0; $i < strlen($var); $i++) {
                if ($var[$i] == '"') {
                    $inStr = !$inStr;
                } elseif ($var[$i] == " " && $inStr == false) {
                    $j++;
                } else {
                    if (!isset($tab[$j])) {
                        array_push($tab, $var[$i]);
                    } else {
                        $tab[$j] = $tab[$j] . $var[$i];
                    }
                }
            }
            foreach ($tab as &$value) {
                if (is_numeric($value)) {
                    if (strpos($value, '.') !== false) {
                        $value = (float)$value;
                    } else {
                        $value = (int)$value;
                    }
                }
            }
            $exec = $tab[0];
            array_shift($tab);
            call_user_func_array([$this, $exec], array_slice($tab, 0, count($tab)));
            // $exec($tab[1]);
        }
    }

    public function dire($str)
    {
        echo "C3PO no " . $this->numeroDeSerie . " : " . $str . "\n";
    }

    public function marcher()
    {
        echo "Je me mets en route, inutile d’insister.\n";
        parent::marcher();
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
    public function getNom()
    {
        echo $this->nom . "\n";
    }
    public function getType()
    {
        echo $this->type . "\n";
    }

    public function __call($name, $arguments)
    {
        echo "La méthode " . $name . " n’existe pas.\n";
    }
}
