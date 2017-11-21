<?php

App::uses('AppController', 'Controller');

class CalculadoraController extends AppController
{
    public function index()
    {
        $calc = $this->getFizzBuzz();
        $this->set(compact('calc'));
    }

    public function getFizzBuzz()
    {
        $Result = '';

        for($i=1; $i<=100; $i++)
        {
            if($i%3==0 || $i%5==0)
            {
                if($i%3==0)
                {
                    $Result .= 'Fizz';
                }
                if($i%5==0)
                {
                    $Result .= 'Buzz';
                }

            } else {
                $Result .= $i;
            }
            $Result .= '<br>';
        }

        return $Result;
    }
}