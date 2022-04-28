<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
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
		// $isLogged = false;
		// $loggindRequired = true;

		// $methodsWithoutLogin = ["panel", ""];

		// switch ($this->$method()) {
		// 	case 'value':
		// 		# code...
		// 		break;
			
		// 	default:
		// 		# code...
		// 		break;
		// }

        if ($this->admin_model->logged_id()) {
			$this->datos["usuario"] = $this->session->userdata('user');
            $this->datos["empresa"] = $this->admin_model->getInfoBasic(1);    
            $this->datos["tiendaId"] = $this->datos["usuario"]['tienda_sel'];  						
            $this->$method();
        }
        else {
            redirect('login/login');
            // redirect('/');
        }
	}


	public function index()
	{
		// if ($this->admin_model->logged_id()) {
		// 	redirect('admin/panel');
		// } else {
		// 	redirect('admin/login');
		// }
		redirect('admin/panel');
	}


	/***
	 * Método: GET
	 * Respuesta: View
	 */
	public function panel() {
		// if ($this->admin_model->logged_id()) {
		// 	$user =  $this->session->userdata('user');			
		// 	$opciones = $this->admin_model->listarOpciones();
		// 	$datos = [ 'page' => 'main', 'user' => $user, 'opciones' => $opciones ];
		// 	$this->load->view('init', $datos);
		// } else {
		// 	redirect('/');
		// }

		// $datosNew = new ArrayObject($this->datos);   
        // $datos = $datosNew->getArrayCopy();

		// $user =  $this->session->userdata('user');			
		$opciones = $this->admin_model->listarOpciones();
		// $datos = [ 'page' => 'main', 'user' => $user, 'opciones' => $opciones ];

		$this->datos["page"] =  "main";
		$this->datos["opciones"] =  $opciones;
		$this->load->view('init', $this->datos);
	}

	/***
	 * Método: GET
	 * Respuesta: Json
	 */
	public function obtenerUsuario() {
		$user = $this->session->userdata('user');
		echo json_encode($user);
	}

	/***
	 * Método: POST
	 * Respuesta: Text
	 */
	public function cambiarTienda() {
		$tiendaId = $this->input->post('tiendaId');
		$tiendas = $this->session->userdata('user')['tiendas'];
		// $tienda = array_filter($tiendas, function($v, $k) { return $v->tiendaId == $tiendaId;}, ARRAY_FILTER_USE_BOTH);
		$tienda ="";
		foreach ($tiendas as $item) {
			if ($item->tiendaId == $tiendaId) {
				$tienda = $item->tienda;
			}
		}
		$session_data['user'] = $this->session->userdata('user');
		$session_data['user']['tienda_sel'] = $tiendaId;		
		$session_data['user']['tienda_sel_nombre'] = $tienda;
		$this->session->set_userdata($session_data);
		return 1;
	}

	public function loadFotoTemp() {
		$upl = array_shift($_FILES); 
		try {
			// $msj = read_file('log_error.txt');
			// $msj .= serialize(json_encode($upl)) ."\n";  
			// write_file('log_error.txt', $msj);   			
		}
		catch(Exception $e){
			die(json_encode(['file_name'=> $e->getMessage()]));			
		}

        $token = $this->admin_model->generarTokenSeguro(50);
		$folderPath = $this->input->post('folderPath');
        // Validar que el token no se encuentre en la tabla tbl_temp_imagen

        $folder="assets/img/temp/".$token."/"; 
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        move_uploaded_file($upl["tmp_name"], "$folder".$upl["name"]);
        $fecha = mdate('%Y-%m-%d %H:%i:%s');
        $this->admin_model->setImagenTemp($token, $upl["name"], $fecha);

        die(json_encode( array('file_name' => $upl['name'], 'file' => $upl, 'token' => $token)));
	}

	public function listarOpciones() {		
		if ($this->admin_model->logged_id()) {
			$user =  $this->session->userdata('user');
			$opciones = $this->admin_model->listarOpciones();
			$datos = [ 'page' => 'main', 'user' => $user, 'opciones' => $opciones ];
			$this->load->view('init', $datos);
		} else {
			redirect('/');
		}
	}

    // public function index()
    // {
    //     if($this->admin->logged_id())
	// 	{
	// 		redirect("/welcome");
    //     }
    //     else{
	// 		// echo "entro aqui";
	// 		//set form validation
	//         $this->form_validation->set_rules('username', 'Username', 'required');
	//         $this->form_validation->set_rules('password', 'Password', 'required');

	//         //set message form validation
	//         $this->form_validation->set_message('required', '<div class="alert alert-danger" style="margin-top: 3px">
	//                 <div class="header"><b><i class="fa fa-exclamation-circle"></i> {field}</b></div></div>');

	//         //cek validasi
	// 		if ($this->form_validation->run() == TRUE) {

	// 			//get data dari FORM
	//             $username = $this->input->post("username", TRUE);
	//             $password = MD5($this->input->post('password', TRUE));
	            
	//             //checking data via model
	//             $checking = $this->admin->check_login('tbl_users', array('username' => $username), array('password' => $password));
	            
	//             //jika ditemukan, maka create session
	//             if ($checking != FALSE) {
	//                 foreach ($checking as $apps) {

	//                     $session_data = array(
	//                         'user_id'   => $apps->id_user,
	//                         'user_name' => $apps->username,
	//                         'user_pass' => $apps->password,
	//                         'user_nama' => $apps->nama_user
	//                     );
	//                     //set session userdata
	//                     $this->session->set_userdata($session_data);

	//                     redirect('welcome/');

	//                 }
	//             }else{
    //                 $data['error'] = '<div class="col-sm-6 col-sm-offset-3 form-box">
    //                     <div class="alert alert-danger">
	//                 	<div class="header"><b><i class="fa fa-exclamation-circle"></i> ERROR</b> Usuario o clave incorrectos!</div></div></div>';
    //                 $this->load->view('login', $data);
	//             }

	//         }else{
    //             $data['error']='<div class="alert alert-danger">test</div>';
	//             $this->load->view('login', $data);
	//         }

	// 	}
    // }
}

?>