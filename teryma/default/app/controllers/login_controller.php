<?php

/**
 * Controller por defecto si no se usa el routes
 * 
 */
class LoginController extends AppController
{

    public function index()
    {
        
    }

    public function login(){
        View::select("login");
        if (Input::hasPost("nombre","pass")){
            $pwd = Input::post("pass");
            $usuario=Input::post("nombre");
            Load::lib('auth');
            $auth = new Auth("model", "class: usuarios", "nombre: $usuario", "pass: $pwd");
            if ($auth->authenticate()) {
                Flash::error("acierto");
                Router::redirect("default");
					 
            } else {
                Flash::error("Falló");
            }
        }
    }

}
