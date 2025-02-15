<?php

namespace App;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "pointsurveillances")]
class PointSurveillance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $nom_pointsuper;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: "pointsurveillances")]
    #[ORM\JoinColumn(nullable: false)]
    private Zone $zone;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom_pointsuper()
    {
        return $this->nom_pointsuper;
    }

    public function setNom_pointsuper($nom_pointsuper)
    {
        $this->nom_pointsuper = $nom_pointsuper;
    }

    public function getZone()
    {
        return $this->zone;
    }

    public function setZone($zone)
    {
        $this->zone = $zone;
    }
}