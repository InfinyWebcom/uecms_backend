<?php

    if(isset($header) && $header)
        $this->load->view('header');

    if(isset($sidemenu) && $sidemenu)
        $this->load->view('sidemenu');

    if(isset($_view)){
        $this->load->view($_view);
    }

    if(isset($footer) && $footer)
        $this->load->view('footer');