<?php

abstract class Repositorio {
  protected $repositorioUsers;
  protected $repositorioComments;
  protected $repositorioChallenger;

  public function getRepositorioUsers() {
    return $this->repositorioUsers;
  }

  public function getRepositorioComments() {
    return $this->repositorioComments;
  }

  public function getRepositorioChallenger() {
    return $this->repositorioChallenger;
  }

}

?>