<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {
    
    public $datos = [];

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->model('empresa_model');
		$this->load->helper('date');
    }

	public function _remap($method)
    {
        if ($this->admin_model->logged_id()) {
            $this->$method();
        }
        else {
            redirect('/');
        }
	}

    /***
     * Metodo: GET
     * Tipo: View
     */
	public function index() {
		$usuario = $this->admin_model->logged_id();       
		$empresa = $this->admin_model->getInfo(1);       
        if (in_array($usuario['rol_id'], ["1"])){
			$company = ""; // Obtener los datos de la empresa
			$datos = [
				'page' => 'admin/company'
			];
            $datos["empresa"] = $empresa;
			$this->load->view('init', $datos);		
		} else {
            $page = "layouts/message";
            $mensaje = "NO TIENE AUTORIZACIÓN PARA ACCEDER A ESTE SITIO";
            $this->load->view('init', ['page'=>$page, 'mensaje'=>$mensaje]);            
        } 
	}

    public function guardar() {
        $config['upload_path']          = './assets/img/company/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10240;
        $config['max_width']            = 10240;
        $config['max_height']           = 7680;

        $this->load->library('upload', $config);


        
        // if (isset($_FILES['fileLogoLogin'])){ 
        //     echo json_encode('Existe archivo');
        // } else {
        //     echo json_encode('No existe existe');
        // }
        // return;
        // $file = []; 
        // if (isset($_FILES['fileLogoLogin']) && $_FILES['fileLogoLogin']['error'] === UPLOAD_ERR_OK) {
        //     $fileUpload = $_FILES['fileLogoLogin'];
        //     $file['TmpPath'] = $fileUpload['tmp_name'];
        //     $file['Name'] = $fileUpload['name'];
        //     $file['Size'] = $fileUpload['size'];
        //     $file['Type'] = $fileUpload['type'];
        //     $file['NameCmps'] = explode(".", $file['Name']);
        //     $file['Extension'] = strtolower(end($file['NameCmps']));

        //     // $pathFolder='assets/files/'.$fecha->format('Y-m-d');
        //     // if (!file_exists($pathFolder)) {
        //     //     mkdir($pathFolder, 0777, true);
        //     // }
        //     // move_uploaded_file($file['TmpPath'], "$pathFolder/$file[Name]");
        //     // $fileExcel = $pathFolder.'/'.$file['Name'];
        //     // $this->load->library('Leerexcelclass', [$fileExcel]);
        //     // $data = $this->leerexcelclass->obtenerDatosExcel();
        //     // $file['data'] = $data;
        //     echo json_encode($file);
        // } else {
        //     echo json_encode('No existe file');
        // }
        // return;

        $empresa = [];
        $empresa["nombreComercial"] = $this->input->post('nombreComercial');
        $empresa["nroRuc"] = $this->input->post('ruc');
        $empresa["razonSocial"] = $this->input->post('razonSocial');
        $empresa["direccion"] = $this->input->post('direccion');
        $empresa["telefono"] = $this->input->post('telefono');
        $empresa["celular"] = $this->input->post('celular');
        $empresa["paginaWeb"] = $this->input->post('paginaWeb');
        $empresa["tituloLogin"] = $this->input->post('tituloLogin');     

        $result = $this->empresa_model->modificarEmpresa($empresa, 1);
        // $this->upload->do_upload('fileLogoLogin');
        // $fileData = $this->upload->data('fileLogoLogin');
        // echo json_encode(isset($empresa["logo"]));  
        // echo json_encode($result);  

        if ($result) {
            // $resp = array("result" => true, "message" => "Datos actualizados", "content" => $empresa);                   
            if (isset($_FILES['fileLogoLogin']) && $_FILES['fileLogoLogin']['error'] == UPLOAD_ERR_OK){ 
                if (!$this->upload->do_upload('fileLogoLogin'))
                {
                    // $error = array('error' => $this->upload->display_errors());
                    $resp = array("result" => true, "message" => "Datos actualizados, pero ocurrio un error al cargar el logo", "content" => $this->upload->display_errors());   
                    // $this->load->view('upload_form', $error);
                    // echo json_encode($error);
                }
                else
                {
                    $empresa = [];
                    $empresa["logoLogin"] = $this->upload->data()["file_name"];
                    $result = $this->empresa_model->modificarEmpresa($empresa, 1);

                    $resp = array("result" => true, "message" => "Datos actualizados", "content" => $this->upload->data());         
                    // $this->load->view('upload_success', $data);      
                    // echo json_encode($result);
                }
                // $resp = array("result" => true, "message" => "Datos actualizados noooo", "content" => $_FILES['fileLogoLogin']['error']);                   
            } else {
                $resp = array("result" => true, "message" => "Datos actualizados");                   
            }            
        } else {
            $resp = array("result" => false, "message" => "Ocurrio un error al actualizar los datos");               
        }  
        echo json_encode($resp);          		
    }

}