<?php

function get_email_template($name, $data)
{
    switch (strtolower($name)) {
    	case 'forgot passward':
            $emailContent = array('subject' => 'Recover your UECMS Account Password!','message' =>'
                Hello,<br/><br/>
                
                If you have forgotten your password, you can click on the link below to set a new one.<br/><br/>
                
                '.$data['link'].'<br/><br/>
                
                Keep it shining,<br/>
                Team UECMS!');
            return $emailContent;
    	break;

        case 'add staff':
            $emailContent = array('subject' => 'Welcome in UECMS','message' =>'
                Hello '.$data['name'].',<br/><br/>
                
                You are registered successfully in UECMS. Please use following email and password for login in UECMS.<br/><br/>
                
                Email: '.$data['email'].'<br/>
                Password: '.$data['password'].'<br/><br/>
                
                Keep it shining,<br/>
                Team UECMS!');
            return $emailContent;
        break;
    	
    	default:
    		# code...
    	break;
    }
}