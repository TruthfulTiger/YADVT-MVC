<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 10/04/2018
 * Time: 02:53
 */

namespace Main\Model;


class Dragon
{
    // Attributes
    protected $_dragonid;
    protected $_dragonname;
    protected $_type;
    protected $_unlocklvl;
    protected $_breedreg;
    protected $_breedup;
    protected $_eggimage;
    protected $_babyimage;
    protected $_teenimage;
    protected $_adultimage;
    protected $_elderimage;
    protected $_desc;
    protected $_notes;
    protected $_elementid;
    protected $_elementname;
    protected $_elementicon;
    protected $_elementnotes;
    protected $_typeid;
    protected $_typename;
    protected $_maxlevel;
    protected $_typeicon;

    // Properties

    /**
     * @return mixed
     */
    public function getDragonid()
    {
        return $this->_dragonid;
    }

    /**
     * @return mixed
     */
    public function getDragonname()
    {
        return $this->_dragonname;
    }

    /**
     * @return mixed
     */
    public function getAdultimage()
    {
        return $this->_adultimage;
    }

    /**
     * @return mixed
     */
    public function getBabyimage()
    {
        return $this->_babyimage;
    }

    /**
     * @return mixed
     */
    public function getBreedreg()
    {
        return $this->_breedreg;
    }

    /**
     * @return mixed
     */
    public function getBreedup()
    {
        return $this->_breedup;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->_desc;
    }

    /**
     * @return mixed
     */
    public function getEggimage()
    {
        return $this->_eggimage;
    }

    /**
     * @return mixed
     */
    public function getElderimage()
    {
        return $this->_elderimage;
    }

    /**
     * @return mixed
     */
    public function getElementicon()
    {
        return $this->_elementicon;
    }

    /**
     * @return mixed
     */
    public function getElementid()
    {
        return $this->_elementid;
    }

    /**
     * @return mixed
     */
    public function getElementname()
    {
        return $this->_elementname;
    }

    /**
     * @return mixed
     */
    public function getElementnotes()
    {
        return $this->_elementnotes;
    }

    /**
     * @return mixed
     */
    public function getMaxlevel()
    {
        return $this->_maxlevel;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->_notes;
    }

    /**
     * @return mixed
     */
    public function getTeenimage()
    {
        return $this->_teenimage;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return mixed
     */
    public function getTypeicon()
    {
        return $this->_typeicon;
    }

    /**
     * @return mixed
     */
    public function getTypeid()
    {
        return $this->_typeid;
    }

    /**
     * @return mixed
     */
    public function getTypename()
    {
        return $this->_typename;
    }

    /**
     * @return mixed
     */
    public function getUnlocklvl()
    {
        return $this->_unlocklvl;
    }

    /**
     * @param mixed $adultimage
     */
    public function setAdultimage($adultimage)
    {
        $this->_adultimage = $adultimage;
    }

    /**
     * @param mixed $babyimage
     */
    public function setBabyimage($babyimage)
    {
        $this->_babyimage = $babyimage;
    }

    /**
     * @param mixed $breedreg
     */
    public function setBreedreg($breedreg)
    {
        $this->_breedreg = $breedreg;
    }

    /**
     * @param mixed $breedup
     */
    public function setBreedup($breedup)
    {
        $this->_breedup = $breedup;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->_desc = $desc;
    }

    /**
     * @param mixed $dragonid
     */
    public function setDragonid($dragonid)
    {
        $this->_dragonid = $dragonid;
    }

    /**
     * @param mixed $dragonname
     */
    public function setDragonname($dragonname)
    {
        $this->_dragonname = $dragonname;
    }

    /**
     * @param mixed $eggimage
     */
    public function setEggimage($eggimage)
    {
        $this->_eggimage = $eggimage;
    }

    /**
     * @param mixed $elderimage
     */
    public function setElderimage($elderimage)
    {
        $this->_elderimage = $elderimage;
    }

    /**
     * @param mixed $elementicon
     */
    public function setElementicon($elementicon)
    {
        $this->_elementicon = $elementicon;
    }

    /**
     * @param mixed $elementid
     */
    public function setElementid($elementid)
    {
        $this->_elementid = $elementid;
    }

    /**
     * @param mixed $elementname
     */
    public function setElementname($elementname)
    {
        $this->_elementname = $elementname;
    }

    /**
     * @param mixed $elementnotes
     */
    public function setElementnotes($elementnotes)
    {
        $this->_elementnotes = $elementnotes;
    }

    /**
     * @param mixed $maxlevel
     */
    public function setMaxlevel($maxlevel)
    {
        $this->_maxlevel = $maxlevel;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->_notes = $notes;
    }

    /**
     * @param mixed $teenimage
     */
    public function setTeenimage($teenimage)
    {
        $this->_teenimage = $teenimage;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * @param mixed $typeicon
     */
    public function setTypeicon($typeicon)
    {
        $this->_typeicon = $typeicon;
    }

    /**
     * @param mixed $typeid
     */
    public function setTypeid($typeid)
    {
        $this->_typeid = $typeid;
    }

    /**
     * @param mixed $typename
     */
    public function setTypename($typename)
    {
        $this->_typename = $typename;
    }

    /**
     * @param mixed $unlocklvl
     */
    public function setUnlocklvl($unlocklvl)
    {
        $this->_unlocklvl = $unlocklvl;
    }

    // Methods
}