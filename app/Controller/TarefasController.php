<?php

App::uses('AppController', 'Controller');

class TarefasController extends AppController
{
    public $components = array('RequestHandler');

    public function index()
    {
        $this->request->allowMethod(array('get'));
    }

    private function findAll($params=null, $extra_params=null)
    {
        if($params==null)
        {
            $params = array(
                'conditions' => array('Tarefa.removido' => false),
                'order' => array('Tarefa.situacao_id', 'Tarefa.prioridade_id DESC', 'Tarefa.ordem'),
            );
        }

        if($extra_params!==null)
        {
            $params = array_merge_recursive(
                $params,
                $extra_params
            );
        }

        return $this->Tarefa->find('all', $params);
    }

    public function pesquisar()
    {
        $this->request->allowMethod(array('get'));

        $tarefas = $this->findAll();

        $this->set(array(
            'tarefas' => (object) $tarefas,
            '_serialize' => array('tarefas')
        ));
    }

    public function mostrar($id)
    {
        $this->request->allowMethod(array('get'));

        $tarefa = $this->Tarefa->findById($id);

        $this->set(array(
            'tarefa' => $tarefa,
            '_serialize' => array('tarefa')
        ));
    }

    public function adicionar()
    {
        $this->request->allowMethod(array('post'));

        unset($this->request->data['id']);
        $this->request->data['situacao_id'] = 1;

        $this->Tarefa->set($this->request->data);

        if($this->Tarefa->validates())
        {
            $extra_params = array(
                'conditions' => array(
                    'Tarefa.prioridade_id' => $this->request->data['prioridade_id'],
                    'Tarefa.situacao_id' => 1
                )
            );

            $this->request->data['ordem'] = count(TarefasController::findAll(null, $extra_params))+1;

            if($this->Tarefa->save($this->request->data))
            {
                $this->Tarefa->resultado = 'sucesso';
            } else {

                $this->Tarefa->resultado = 'erro_bd';
            }

        } else {

            $this->Tarefa->resultado = 'erro_validacao';
        }

        $this->set(array(
            'tarefa' => $this->Tarefa,
            '_serialize' => array('tarefa')
        ));
    }

    public function alterar()
    {
        $this->request->allowMethod(array('post'));

        if(isset($this->request->data['id']) && $this->request->data['id']>0)
        {
            $this->Tarefa->set($this->request->data);

            if($this->Tarefa->validates())
            {
                $tarefa_atual = $this->Tarefa->findById($this->request->data['id']);
                $prioridade_atual = $tarefa_atual['Tarefa']['prioridade_id'];
                $situacao_atual = $tarefa_atual['Tarefa']['situacao_id'];

                $nova_prioridade = $this->request->data['prioridade_id'];
                $nova_situacao = $this->request->data['situacao_id'];

                $arr22 = array();

                if($nova_situacao!=$situacao_atual)
                {
                    if($nova_situacao==2)
                    {
                        //atualiza apenas grupo da prioridade antiga :: reordena os que ficaram na situacao 1

                        $extra_params = array(
                            'conditions' => array(
                                'Tarefa.prioridade_id' => $prioridade_atual,
                                'Tarefa.situacao_id' => $situacao_atual,
                                'Tarefa.id != ' => $this->request->data['id'],
                            )
                        );

                        $tarefas_prioridade_atual = TarefasController::findAll(null, $extra_params);

                        foreach($tarefas_prioridade_atual as $k => $v)
                        {
                            $arr22[] = array(
                                'Tarefa' => array(
                                    'id' => $v['Tarefa']['id'],
                                    'ordem' => $k+1
                                )
                            );
                        }

                    } else if($nova_situacao==1) {

                        //atualiza apenas grupo da prioridade nova :: total dos que já estão mais um

                        $extra_params = array(
                            'conditions' => array(
                                'Tarefa.prioridade_id' => $nova_prioridade,
                                'Tarefa.situacao_id' => $nova_situacao
                            )
                        );

                        $this->request->data['ordem'] = count(TarefasController::findAll(null, $extra_params))+1;

                    }
                } else if($nova_situacao==1) {

                    if($prioridade_atual!=$nova_prioridade)
                    {
                        //atualiza grupo da prioridade antiga :: reordena os que ficaram na prioridade antiga

                        $extra_params = array(
                            'conditions' => array(
                                'Tarefa.prioridade_id' => $prioridade_atual,
                                'Tarefa.situacao_id' => $nova_situacao,
                                'Tarefa.id != ' => $this->request->data['id'],
                            )
                        );

                        $tarefas_prioridade_atual = TarefasController::findAll(null, $extra_params);

                        foreach($tarefas_prioridade_atual as $k => $v)
                        {
                            $arr22[] = array(
                                'Tarefa' => array(
                                    'id' => $v['Tarefa']['id'],
                                    'ordem' => $k+1
                                )
                            );
                        }

                        //atualiza grupo da prioridade nova :: total dos que já estão mais um

                        $extra_params = array(
                            'conditions' => array(
                                'Tarefa.prioridade_id' => $nova_prioridade,
                                'Tarefa.situacao_id' => $nova_situacao
                            )
                        );

                        $this->request->data['ordem'] = count(TarefasController::findAll(null, $extra_params))+1;
                    }
                }

                if($this->Tarefa->save($this->request->data))
                {
                    if(!empty($arr22))
                    {
                        if($this->Tarefa->saveMany($arr22, array('validate' => false)))
                        {
                            $this->Tarefa->resultado = 'sucesso';
                        } else {
                            $this->Tarefa->resultado = 'erro_bd_ordem';
                        }
                    } else {
                        $this->Tarefa->resultado = 'sucesso';
                    }

                } else {
                    $this->Tarefa->resultado = 'erro_bd';
                }

            } else {
                $this->Tarefa->resultado = 'erro_validacao';
            }

            $this->set(array(
                'tarefa' => $this->Tarefa,
                '_serialize' => array('tarefa')
            ));

        } else {

            $this->Tarefa->resultado = 'erro_validacao_id';
        }
    }

    public function excluir()
    {
        $this->request->allowMethod(array('post'));

        if(isset($this->request->data['id']) && $this->request->data['id']>0)
        {
            $tarefa_atual = $this->Tarefa->findById($this->request->data['id']);
            $prioridade_atual = $tarefa_atual['Tarefa']['prioridade_id'];
            $situacao_atual = $tarefa_atual['Tarefa']['situacao_id'];

            $arr22 = array();

            if($situacao_atual==1)
            {
                $extra_params = array(
                    'conditions' => array(
                        'Tarefa.prioridade_id' => $prioridade_atual,
                        'Tarefa.situacao_id' => $situacao_atual,
                        'Tarefa.id != ' => $this->request->data['id'],
                    )
                );

                $tarefas_prioridade_atual = TarefasController::findAll(null, $extra_params);

                foreach($tarefas_prioridade_atual as $k => $v)
                {
                    $arr22[] = array(
                        'Tarefa' => array(
                            'id' => $v['Tarefa']['id'],
                            'ordem' => $k+1
                        )
                    );
                }
            }

            $this->Tarefa->set($this->request->data);

            if($this->Tarefa->saveField('removido', 1))
            {
                if(!empty($arr22))
                {
                    if($this->Tarefa->saveMany($arr22, array('validate' => false)))
                    {
                        $this->Tarefa->resultado = 'sucesso';
                    } else {
                        $this->Tarefa->resultado = 'erro_bd_ordem';
                    }
                } else {
                    $this->Tarefa->resultado = 'sucesso';
                }

            } else {
                $this->Tarefa->resultado = 'erro_bd';
            }

        } else {

            $this->Tarefa->resultado = 'erro_validacao_id';
        }

        $this->set(array(
            'tarefa' => $this->Tarefa,
            '_serialize' => array('tarefa')
        ));
    }

    public function concluir()
    {
        $this->request->allowMethod(array('post'));

        if(isset($this->request->data['id']) && $this->request->data['id']>0)
        {
            $tarefa_atual = $this->Tarefa->findById($this->request->data['id']);
            $prioridade_atual = $tarefa_atual['Tarefa']['prioridade_id'];
            $situacao_atual = $tarefa_atual['Tarefa']['situacao_id'];

            $arr22 = array();

            $extra_params = array(
                'conditions' => array(
                    'Tarefa.prioridade_id' => $prioridade_atual,
                    'Tarefa.situacao_id' => $situacao_atual,
                    'Tarefa.id != ' => $this->request->data['id'],
                )
            );

            $tarefas_prioridade_atual = TarefasController::findAll(null, $extra_params);

            foreach($tarefas_prioridade_atual as $k => $v)
            {
                $arr22[] = array(
                    'Tarefa' => array(
                        'id' => $v['Tarefa']['id'],
                        'ordem' => $k+1
                    )
                );
            }

            $this->Tarefa->set($this->request->data);

            if($this->Tarefa->saveField('situacao_id', 2))
            {
                if(!empty($arr22))
                {
                    if($this->Tarefa->saveMany($arr22, array('validate' => false)))
                    {
                        $this->Tarefa->resultado = 'sucesso';
                    } else {
                        $this->Tarefa->resultado = 'erro_bd_ordem';
                    }
                } else {
                    $this->Tarefa->resultado = 'sucesso';
                }

            } else {
                $this->Tarefa->resultado = 'erro_bd';
            }

        } else {

            $this->Tarefa->resultado = 'erro_validacao_id';
        }

        $this->set(array(
            'tarefa' => $this->Tarefa,
            '_serialize' => array('tarefa')
        ));
    }

    public function ordenar()
    {
        $this->request->allowMethod(array('post'));

        if(isset($this->request->data['id']) && $this->request->data['id']>0
            && isset($this->request->data['index_destino']) && $this->request->data['index_destino']>=0)
        {
            $extra_params = array(
                'conditions' => array('Tarefa.situacao_id' => 1)
            );

            $pesquisar = $this->findAll(null, $extra_params);

            //origem

            $id = $this->request->data['id'];
            $index_origem = null;
            $prioridade_origem = null;
            $result = array_keys(array_filter($pesquisar, function($v) use ($id){
                return $v['Tarefa']['id']==$id;
            }));
            if(isset($result[0]) && $result[0]>-1)
            {
                $index_origem = $result[0];
                $prioridade_origem = $pesquisar[$result[0]]['Tarefa']['prioridade_id'];
            }

            //destino

            $index_destino = $this->request->data['index_destino'];
            $index_anterior=null;
            $index_proximo=null;
            $prioridade_anterior=null;
            $prioridade_proximo=null;
            $prioridade_destino = null;

            //

            if($index_origem!==null && $index_origem!=$index_destino)
            {

                if($index_origem<$index_destino)
                {
                    $index_anterior = $index_destino;
                    $index_proximo = $index_destino+1;

                } else if($index_origem>$index_destino) {

                    $index_anterior = $index_destino-1;
                    $index_proximo = $index_destino;
                }

                if($index_anterior!==null && $index_anterior>=0)
                {
                    $prioridade_anterior = $pesquisar[$index_anterior]['Tarefa']['prioridade_id'];
                }

                if($index_proximo!==null && $index_proximo<count($pesquisar))
                {
                    $prioridade_proximo = $pesquisar[$index_proximo]['Tarefa']['prioridade_id'];
                }

                //prioridade destino

                if(count($pesquisar)>1)
                {
                    if($index_destino>0 && $index_destino<count($pesquisar)-1)
                    {
                        if($prioridade_origem==$prioridade_anterior)
                        {
                            $prioridade_destino = $prioridade_anterior;

                        } else if($prioridade_origem==$prioridade_proximo) {

                            $prioridade_destino = $prioridade_proximo;

                        } else {
                            //echo 32;exit;
                            $prioridade_destino = $prioridade_proximo;
                        }

                    } else if($index_destino==0) {

                        $prioridade_destino = $prioridade_proximo;

                    } else if($index_destino==count($pesquisar)-1) {

                        $prioridade_destino = $prioridade_anterior;

                    } else {
                        //echo 76;exit;
                    }

                } else {
                    //echo 98;exit;
                }

                //atualiza prioridade destino
                //reordena tarefas da prioridade destino
                //reordena tarefas da prioridade origem

                $arr22=array();
                $ordem_destino = 1;
                $ordem_origem = 1;
                $origem_verif = 0;

                if($prioridade_destino!=$prioridade_origem)
                {
                    //reordena destino

                    $reord_destino = array_keys(array_filter($pesquisar, function($v) use ($prioridade_destino){
                        return $v['Tarefa']['prioridade_id']==$prioridade_destino;
                    }));

                    if($reord_destino!==null && count($reord_destino)>0)
                    {
                        foreach($reord_destino as $v)
                        {
                            if($pesquisar[$v]['Tarefa']['id']!=$id)
                            {
                                if( ($index_origem<$index_destino && $v>$index_destino)
                                    || ($index_origem>$index_destino && $v>=$index_destino) )
                                {
                                    $arr22[] = array(
                                        'Tarefa' => array(
                                            'id' => $pesquisar[$v]['Tarefa']['id'],
                                            'ordem' => $pesquisar[$v]['Tarefa']['ordem']+1
                                        )
                                    );
                                } else {

                                    $ordem_destino++;

                                }
                            }
                        }
                    }

                    //atualiza tarefa/$id deslocada (prioridade e ordem)

                    $arr22[] = array(
                        'Tarefa' => array(
                            'id' => $id,
                            'ordem' => $ordem_destino,
                            'prioridade_id' => $prioridade_destino,
                        )
                    );

                    //reordena origem

                    $reord_origem = array_keys(array_filter($pesquisar, function($v) use ($prioridade_origem, $id){
                        return $v['Tarefa']['prioridade_id']==$prioridade_origem && $v['Tarefa']['id']!=$id;
                    }));

                    if($reord_origem!==null && count($reord_origem)>0)
                    {
                        foreach($reord_origem as $v)
                        {
                            $arr22[] = array(
                                'Tarefa' => array(
                                    'id' => $pesquisar[$v]['Tarefa']['id'],
                                    'ordem' => $ordem_origem
                                )
                            );

                            $ordem_origem++;
                        }
                    }

                } else {

                    //reordena destino/origem

                    $reord_destino_origem = array_keys(array_filter($pesquisar, function($v) use ($prioridade_origem, $id){
                        return $v['Tarefa']['prioridade_id']==$prioridade_origem && $v['Tarefa']['id']!=$id;
                    }));

                    if($reord_destino_origem!==null && count($reord_destino_origem)>0)
                    {
                        foreach($reord_destino_origem as $v)
                        {
                            if($index_origem<$index_destino)
                            {
                                if($v<=$index_destino && $v>$index_origem)
                                {
                                    $arr22[] = array(
                                        'Tarefa' => array(
                                            'id' => $pesquisar[$v]['Tarefa']['id'],
                                            'ordem' => $pesquisar[$v]['Tarefa']['ordem']-1
                                        )
                                    );
                                }

                                $ordem_destino++;

                            } else if($index_origem>$index_destino && $v>=$index_destino && $v<$index_origem) {

                                if($origem_verif===0)
                                {
                                    $ordem_destino = $pesquisar[$v]['Tarefa']['ordem'];
                                    $origem_verif=1;
                                }

                                $arr22[] = array(
                                    'Tarefa' => array(
                                        'id' => $pesquisar[$v]['Tarefa']['id'],
                                        'ordem' => $pesquisar[$v]['Tarefa']['ordem']+1
                                    )
                                );
                            }
                        }
                    }

                    //

                    $arr22[] = array(
                        'Tarefa' => array(
                            'id' => $id,
                            'ordem' => $ordem_destino,
                            'prioridade_id' => $prioridade_destino,
                        )
                    );

                }

                if(!empty($arr22) && $this->Tarefa->saveMany($arr22, array('validate' => false)))
                {
                    $this->Tarefa->resultado = 'sucesso';

                } else {
                    $this->Tarefa->resultado = 'erro_bd';
                }

            } else {

                $this->Tarefa->resultado = 'erro_bd';
            }

        } else {
            $this->Tarefa->resultado = 'erro_validacao_id';
        }

        $this->set(array(
            'tarefa' => $this->Tarefa,
            '_serialize' => array('tarefa')
        ));
    }
}