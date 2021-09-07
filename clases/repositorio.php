<?php

abstract class Repositorio {
  protected $repositorioUsers;
  protected $repositorioEpisodes;

  public function getRepositorioUsers() {
    return $this->repositorioUsers;
  }

  public function getRepositorioEpisodes() {
    return $this->repositorioEpisodes;
  }

}

?>