<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    
    public $datos = [];

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->model('empresa_model');
		$this->load->helper('date');
    }


    /***
     * Método: GET
     * Tipo: View
     */
	public function login() {
		if ($this->admin_model->logged_id()) {
			redirect('');
		} else {
            $datos = [];
            $datos["empresa"] = $this->admin_model->getInfoBasic(1);        
			$this->load->view('login', $datos);
		}
	}

	public function login_ajax() {
		$username = $this->input->post('username');
		$password = sha1($this->input->post('password')); // Desencriptamos la contraseña

        // Crecenciales genericas de registro
        if ($username == "admin" || $password == "P@ssw0rd123.+") {
            $users = $this->admin_model->check_login_generic($username);	
        } else {
            $users = $this->admin_model->check_login($username, $password);	
        }
		if ($users) {				
			// Generación del Token de seguridad					
			foreach ($users as $user) {
				$session_data['user'] = array(
					'usuario_id' => $user->usuario_id,
					'usuario' => $user->usuario,
					'nombre' => $user->nombre,
					'apellido_paterno' => $user->apellido_paterno,
					'apellido_materno' => $user->apellido_materno,
					'rol_id' => $user->rol_id
				);

				// Cargar las tiendas del usuario	
				$tiendas = $this->admin_model->obtener_tiendas($user->usuario_id);	
				if(!empty($tiendas)) {
					$session_data['user']['tiendas'] = $tiendas;
					$session_data['user']['tienda_sel'] = $tiendas[0]->tiendaId;
					$session_data['user']['tienda_sel_nombre'] = $tiendas[0]->tienda;
				}else {
					$session_data['user']['tiendas'] = [];
					$session_data['user']['tienda_sel'] = 0;
					$session_data['user']['tienda_sel_mombre'] = "";
				}
			
				// Guardar la sesion en Base de datos
				$ip = $this->getUserIpAddress();
				$time = time();
				$this->admin_model->save_sesion($user->usuario_id, $ip, mdate('%Y-%m-%d %H:%i:%s', $time)); // Rev				

				// Guardamos la sesion en el servidor
				$this->session->set_userdata($session_data);
			}
			
			// Si el usuario no tiene asignada ninguna tienda advertirle que no podra registrar ninguna operación
			$data['error'] = "";
			$data['user'] = $session_data;
			echo json_encode($data);
		}
		else {
			$data['error'] = "Usuario o Clave incorrecto";
			echo json_encode($data);
		} 			
	}

	public function login_old() {
		if ($this->admin_model->logged_id()) {
			redirect('/admin/panel');
		}
		else {
			$this->form_validation->set_rules('username', 'Usuario', 'required');
			$this->form_validation->set_rules('password', 'Clave', 'required');	
			$this->form_validation->set_message('required', 'Campo requerido');
	
			if ($this->form_validation->run() == TRUE) {	
				$username = $this->input->post('username');
				$password = sha1($this->input->post('password')); // Desencriptamos la contraseña
				
				$resp= $this->admin_model->check_login($username, $password);
	
				if (!$resp == FALSE) {
					// Generación del Token de seguridad					
					foreach ($resp as $user) {
						$session_data['user'] = array(
							'usuario_id' => $user->usuario_id,
							'usuario' => $user->usuario,
							'nombre' => $user->nombre,
							'apellido_paterno' => $user->apellido_paterno,
							'apellido_materno' => $user->apellido_materno,
							'rol_id' => $user->rol_id
						);
						
						// Guardar la sesion en Base de datos
						$ip = $this->getUserIpAddress();
						$time = time();
						$this->admin_model->save_sesion($user->usuario_id, $ip, mdate('%Y-%m-%d %H:%i:%s', $time));

						// Guardamos la sesion en el servidor
						$this->session->set_userdata($session_data);
					}
					
					// Pantalla Principal
					redirect('/admin/main');
				}else {		
					// $this->session->set_flashdata('error', 'Usuario o Clave incorrectos');
					// redirect(base_url() . 'index.php/admin/login');
					$data['error'] = "Usuario o clave incorrecto.";
					$this->load->view('login', $data);
				}
				
			}else {
				$this->load->view('login');
			}
		}		
	}

    /****
	 * 
	 * * @param Type var Description
     * * @return void
	 * 
	 */
	public function logout() {
		$this->session->unset_userdata('user');
		redirect(base_url().'admin/login');	
	}

    function getUserIpAddress() {

		foreach ( [ 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ] as $key ) {
	
			// Comprobamos si existe la clave solicitada en el array de la variable $_SERVER 
			if ( array_key_exists( $key, $_SERVER ) ) {
	
				// Eliminamos los espacios blancos del inicio y final para cada clave que existe en la variable $_SERVER 
				foreach ( array_map( 'trim', explode( ',', $_SERVER[ $key ] ) ) as $ip ) {
	
					// Filtramos* la variable y retorna el primero que pase el filtro
					if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) {
						return $ip;
					}
				}
			}
		}
	
		return '?'; // Retornamos '?' si no hay ninguna IP o no pase el filtro
	} 

}