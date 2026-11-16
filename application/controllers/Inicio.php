<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

    public function index()
    {
        $data['titulo'] = 'TecnoHogar | Tecnología para tu hogar';

        $this->load->view('Inicio/welcome', $data);
    }

}