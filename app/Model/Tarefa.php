<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class Tarefa extends Model
{
    public $validate = array(
        'titulo' => array(
            'alphaNumeric' => array(
                'rule' => array('minLength', '3'),
                'required' => true,
                'message' => 'O título é obrigatório com no mínimo 3 caracteres.'
            )
        ),
        'situacao_id' => array(
            'rule' => 'numeric',
            'required' => true,
            'message' => 'Status é obrigatório.'
        ),
        'prioridade_id' => array(
            'rule' => 'numeric',
            'required' => true,
            'message' => 'Prioridade é obrigatória.'
        )
    );

    public $belongsTo = array(
        'Situacao' => array(
            'className' => 'Situacao',
            'foreignKey' => 'situacao_id'
        ),
        'Prioridade' => array(
            'className' => 'Prioridade',
            'foreignKey' => 'prioridade_id'
        )
    );
}
