<?php


namespace App\robber\domain\robber\command;


class CreateRobberCommand
{
    private $name;
    private $level;
    private $id;

    /**
     * CreateRobberCommand constructor.
     * @param $id
     * @param $name
     * @param $level
     */
    public function __construct($id, $name, $level)
    {
        $this->name = $name;
        $this->level = $level;
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


}