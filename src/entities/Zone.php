<?php
namespace App;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "zones")]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $nom;

    #[ORM\Column(type: "string", length: 10)]
    private string $statut;

    #[ORM\Column(type: "integer")]
    private int $nb_habitants;

    #[ORM\Column(type: "integer")]
    private int $nb_symptomatiques;

    #[ORM\Column(type: "integer")]
    private int $nb_positifs;

    #[ORM\ManyToOne(targetEntity: Pays::class, inversedBy: "zones")]
    #[ORM\JoinColumn(nullable: false)]
    private Pays $pays;

    #[ORM\OneToMany(targetEntity: PointSurveillance::class, mappedBy: "zone", cascade: ["persist", "remove"])]
    private Collection $pointsurveillances;

    public function __construct()
    {
        $this->pointsurveillances = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getStatut()
    {
        return $this->statut;
    }

    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    public function getNb_habitants()
    {
        return $this->nb_habitants;
    }

    public function setNb_habitants($nb_habitants)
    {
        $this->nb_habitants = $nb_habitants;
    }

    public function getNb_symptomatiques()
    {
        return $this->nb_symptomatiques;
    }

    public function setNb_symptomatiques($nb_symptomatiques)
    {
        $this->nb_symptomatiques = $nb_symptomatiques;
    }

    public function getNb_positifs()
    {
        return $this->nb_positifs;
    }

    public function setNb_positifs($nb_positifs)
    {
        $this->nb_positifs = $nb_positifs;
    }

    public function getPays()
    {
        return $this->pays;
    }

    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    public function getPointsurveillances()
    {
        return $this->pointsurveillances;
    }

    public function setPointsurveillances(PointSurveillance $pointsurveillance)
    {
        $this->pointsurveillances->add($pointsurveillance);
        $pointsurveillance->setZone($this);
    }
}