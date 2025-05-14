<?php

namespace App\DTO;

use JsonSerializable;

class IncidenciasDTO implements JsonSerializable{

    private $id;
    private $idTrabajador;
    private $nombreTrabajador;
    private $idInstalacion;
    private $nombreInstalacion;
    private $hora;
    private $descripcion;

    public function __construct( $id, $idTrabajador,$nombreTrabajador, $idInstalacion,$nombreInstalacion, $hora, $descripcion ){

        $this->id = $id;
        $this->idTrabajador = $idTrabajador;
        $this->nombreTrabajador = $nombreTrabajador;
        $this->idInstalacion = $idInstalacion;
        $this->nombreInstalacion = $nombreInstalacion;
        $this->hora = $hora;
        $this->descripcion = $descripcion;

    }

    public function jsonSerialize(){

        return get_object_vars($this);

    }

    
    /**
     * Get the value of idIncidencia
     */
    public function getIdIncidencia()
    {
        return $this->id;
    }

    /**
     * Get the value of trabajador
     */
    public function getIdTrabajador()
    {
        return $this->idTrabajador;
    }

    /**
     * Get the value of trabajador
     */
    public function getNombreTrabajador()
    {
        return $this->nombreTrabajador;
    }

    /**
     * Get the value of instalacion
     */
    public function getIdInstalacion()
    {
        return $this->idInstalacion;
    }

    /**
     * Get the value of instalacion
     */
    public function getNombreInstalacion()
    {
        return $this->nombreInstalacion;
    }

    /**
     * Get the value of hora
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

}