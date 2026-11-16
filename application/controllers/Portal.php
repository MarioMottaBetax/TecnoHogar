<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller {

    public function index()
    {
        $data['titulo'] = 'Portal de acceso | TecnoHogar';

        $this->load->view('Portal/acceso', $data);
    }

    public function administrativo()
    {
        $data['titulo'] = 'Acceso administrativo | TecnoHogar';

        $this->load->view('Portal/administrativo', $data);
    }

}