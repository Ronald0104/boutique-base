<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model
{


    public function modificarEmpresa($empresa, $empresaId) {
        try {

            $this->addPropertyIfExists($empresa, "nombreComercial");
            $this->addPropertyIfExists($empresa, "razonSocial");
            $this->addPropertyIfExists($empresa, "nroRuc");
            $this->addPropertyIfExists($empresa, "direccion");
            $this->addPropertyIfExists($empresa, "telefono");
            $this->addPropertyIfExists($empresa, "celular");
            $this->addPropertyIfExists($empresa, "paginaWeb");
            $this->addPropertyIfExists($empresa, "tituloLogin");
            $this->addPropertyIfExists($empresa, "logoLogin");

            // $this->db->set('nombreComercial', $empresa['nombreComercial']); 
            // $this->db->set('razonSocial', $empresa['razonSocial']);
            // $this->db->set('nroRuc', $empresa['nroRuc']);
            // $this->db->set('direccion', $empresa['direccion']);
            // $this->db->set('telefono', $empresa['telefono']);
            // $this->db->set('celular', $empresa['celular']);
            // $this->db->set('paginaWeb', $empresa['paginaWeb']);
            // $this->db->set('tituloLogin', $empresa['tituloLogin']);            
            // $this->db->set('logoLogin', $empresa['logoLogin']);   

            $this->db->where('empresaId', $empresaId);
            $this->db->update('tbl_empresa');
            return TRUE;
        } catch (\Exception $e){
            return FALSE;
        }
    }

    public function addPropertyIfExists($propertyArray, $propertyName)
    {
        if (isset($propertyArray[$propertyName])) {
            $this->db->set($propertyName, $propertyArray[$propertyName]);
        }        
    }


}