<?php


namespace App;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'pays')]
class Pays
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $nom;

    #[ORM\OneToMany(targetEntity: Zone::class, cascade: ['persist', 'remove'], mappedBy: 'pays')]
    private Collection $zones;
    
    public function __construct()
    {
        $this->zones = new ArrayCollection(); 
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

    public function getZones()
    {
        return $this->zones;
    }

    public function setZoness(Zone $zone)
    {
        $this->zones->add($zone);
        $zone->setPays($this);
    }
}