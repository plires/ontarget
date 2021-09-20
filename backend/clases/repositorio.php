<?php

abstract class Repositorio {
  protected $repositorioUsers;
  protected $repositorioComments;

  public function getRepositorioUsers() {
    return $this->repositorioUsers;
  }

  public function getRepositorioComments() {
    return $this->repositorioComments;
  }

}

?>