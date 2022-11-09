<?php

namespace netvod\action;

abstract class Action
{
    /**
     * @var string|mixed|null methode http
     */
    protected ?string $http_method = null;
    /**
     * @var string|mixed|null nom de l'hôte
     */
    protected ?string $hostname = null;
    /**
     * @var string|mixed|null nom du script
     */
    protected ?string $script_name = null;

    /**
     * Constructeur par défaut
     */
    public function __construct()
    {

        $this->http_method = $_SERVER['REQUEST_METHOD'];
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->script_name = $_SERVER['SCRIPT_NAME'];
    }

    /**
     * @return string
     * execute l'action
     */
    abstract public function execute(): string;

}