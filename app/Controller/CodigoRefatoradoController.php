<?php

App::uses('AppController', 'Controller');

class CodigoRefatoradoController extends AppController {

    public function index($code=1)
    {
        if($code!==null)
        {
            if($code==1)
            {
                $code = $this->getCodeOne();
            } else if($code==2) {
                $code = $this->getCodeTwo();
            }
        }

        $this->set(compact('code'));
    }

    private function getCodeOne()
    {
        return '
        if( (isset($_SESSION[\'loggedin\']) && $_SESSION[\'loggedin\']===true)
            || (isset($_COOKIE[\'Loggedin\']) && $_COOKIE[\'Loggedin\']===true) )
        {
            header("Location: http://www.google.com");
        }
        exit;
        ';
    }

    private function getCodeTwo()
    {
        return '
        class MyUserClass
        {
            public function getUserList()
            {
                $dbconn = new mysqli(\'localhost\',\'user\',\'password\', \'table\');

                if($dbconn->connect_error)
                {
                    die(\'Erro ao conectar o BD (\' . $dbconn->connect_errno . \') \'
                        . $dbconn->connect_error);
                }
        
                $sql = \'select name from user order by table_name\';

                $rows=null;
                
                if($results=$dbconn->query($sql))
                {
                    $rows=$results->fetch_all(MYSQLI_ASSOC);
                    $results->close();
                }

                $dbconn->close();
        
                return $rows;
            }
        }
        ';
    }
}