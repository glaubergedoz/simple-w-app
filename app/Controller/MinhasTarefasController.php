<?php

App::uses('AppController', 'Controller');
App::uses('TarefasController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Situacao', 'Model');
App::uses('Prioridade', 'Model');

class MinhasTarefasController extends AppController
{
    public $components = array('RequestHandler');

    public $acao = array(
        'adicionar' => array(
            'adicionar',
            'adicionada'
        ),
        'alterar' => array(
            'alterar',
            'alterada'
        ),
    );

    public function index()
    {
        $this->setAction('pesquisar');
    }

    public function pesquisar()
    {
        $link =  $this->webroot.'tarefas/pesquisar.json';

        $data = null;
        $httpSocket = new HttpSocket();
        $response = $httpSocket->get($link, $data);
        $response_body = json_decode($response->body);
        $tarefas = null;

        if($response_body!==null)
        {
            //response = json format

            if(isset($response_body->tarefas) && !empty($response_body->tarefas))
            {
                $tarefas = $response_body->tarefas;
                $this->set('tarefas', $tarefas);

            } else if(isset($response_body->status) && $response_body->status>0) {

                throw new ErrorException('Erro 5364 - WS retornou erro', 400);

            } else {
                throw new ErrorException('Erro 5364 - WS retornou erro', 400);
            }

        } else {
            //response não está no formato json
            throw new ErrorException('Erro 5364 - WS retornou erro', 400);
        }
    }

    public function mostrar($id=null)
    {
        $link = $this->webroot.'tarefas/mostrar/'.$id.'.json';

        $data = null;
        $httpSocket = new HttpSocket();
        $response = $httpSocket->get($link, $data );
        $response_body = json_decode($response->body);
        $tarefa = null;

        if($response_body!==null)
        {
            //response = json format

            if(isset($response_body->tarefa) && !empty($response_body->tarefa))
            {
                $tarefa = json_decode($response->body)->tarefa;
                $this->set('tarefa', $tarefa);

            } else if(isset($response_body->status) && $response_body->status>0) {

                throw new ErrorException('Erro 5364 - WS retornou erro', 400);

            } else {
                throw new ErrorException('Erro 5364 - WS retornou erro', 400);
            }

        } else {
            //response não está no formato json
            throw new ErrorException('Erro 5364 - WS retornou erro', 400);
        }
    }

    public function adicionar()
    {
        $this->set($this->tabelas_apoio());
    }

    public function alterar($id=null)
    {
        $link = $this->webroot.'tarefas/mostrar/'.$id.'.json';

        $data = null;
        $httpSocket = new HttpSocket();
        $response = $httpSocket->get($link, $data );
        $response_body = json_decode($response->body);
        $tarefa = null;

        if($response_body!==null)
        {
            //response = json format

            if(isset($response_body->tarefa) && !empty($response_body->tarefa))
            {
                $tarefa = json_decode($response->body)->tarefa;
                $this->set('tarefa', $tarefa);
                $this->set($this->tabelas_apoio());

            } else if(isset($response_body->status) && $response_body->status>0) {

                throw new ErrorException('Erro 5364 - WS retornou erro', 400);

            } else {
                throw new ErrorException('Erro 5364 - WS retornou erro', 400);
            }

        } else {
            //response não está no formato json
            throw new ErrorException('Erro 5364 - WS retornou erro', 400);
        }
    }

    public function excluir($id, $confirm=null)
    {
        if($confirm!==null && $confirm=='confirm')
        {
            //exclui a tarefa

            $link = $this->webroot.'tarefas/excluir.json';

            $data = array('id' => $id);

            $httpSocket = new HttpSocket();
            $response = $httpSocket->post($link, $data, $this->request);
            $response_body = json_decode($response->body);
            $tarefa = null;

            if($response_body!==null)
            {
                //response = json format

                if(isset($response_body->tarefa) && !empty($response_body->tarefa))
                {
                    $tarefa = json_decode($response->body)->tarefa;

                    if($tarefa->resultado=='erro_validacao')
                    {
                        $mensagem_geral = 'Erro ao excluir a tarefa.';

                    } else if($tarefa->resultado=='erro_bd') {

                        $mensagem_geral = 'Erro ao excluir a tarefa.';

                    } else if($tarefa->resultado=='erro_bd_ordem') {

                        $mensagem_geral = 'Erro ao excluir a tarefa. A tarefa foi excluída mas houve um erro ao reordenar as tarefas após a exclusão.';

                    } else if($tarefa->resultado=='erro_validacao_id') {

                        $mensagem_geral = 'Erro ao excluir a tarefa. Dados incorretos, tarefa não identificada, não foi possível excluir tarefa.';

                    } else if($tarefa->resultado=='sucesso') {

                        $mensagem_geral = 'Tarefa excluída com sucesso.';

                    } else {

                        $mensagem_geral = 'Erro ao excluir a tarefa.';
                    }

                } else if(isset($response_body->status) && $response_body->status>0) {

                    throw new ErrorException('Erro 5364 - WS retornou erro', 400);

                } else {
                    throw new ErrorException('Erro 5364 - WS retornou erro', 400);
                }

            } else {
                //response não está no formato json
                throw new ErrorException('Erro 5364 - WS retornou erro', 400);
            }

            //

            $url_close = $this->webroot.'/minhas_tarefas';
            $id_sufix = '_2';
            $resultado = 'sucesso';

        } else {

            //pede pra confirmar

            $url_close = $url_close = $this->webroot.'/minhas_tarefas/excluir/'.$id.'/confirm';
            $mensagem_geral = 'A Tarefa selecionada será excluída. Você confirma?';
            $id_sufix = '_1';
            $resultado = 'confirma';
        }

        $this->autoRender = false;
        return json_encode(
            array(
                'id_sufix' => $id_sufix,
                'url_close' => $url_close,
                'resultado' => $resultado,
                'mensagem_geral' => $mensagem_geral
            )
        );
    }

    public function concluir($id)
    {
        $link = $this->webroot.'tarefas/concluir.json';

        $data = array('id' => $id);

        $httpSocket = new HttpSocket();
        $response = $httpSocket->post($link, $data, $this->request);
        $response_body = json_decode($response->body);
        $tarefa = null;

        if($response_body!==null)
        {
            //response = json format

            if(isset($response_body->tarefa) && !empty($response_body->tarefa))
            {
                $tarefa = json_decode($response->body)->tarefa;

                if($tarefa->resultado=='erro_validacao')
                {
                    $mensagem_geral = 'Erro ao concluir a tarefa.';

                } else if($tarefa->resultado=='erro_bd') {

                    $mensagem_geral = 'Erro ao concluir a tarefa.';

                } else if($tarefa->resultado=='erro_bd_ordem') {

                    $mensagem_geral = 'Erro ao concluir a tarefa. A tarefa foi concluída mas houve um erro ao reordenar as tarefas após a alteração.';

                } else if($tarefa->resultado=='erro_validacao_id') {

                    $mensagem_geral = 'Erro ao concluir a tarefa. Dados incorretos, tarefa não identificada, não foi possível concluir tarefa.';

                } else if($tarefa->resultado=='sucesso') {

                    $mensagem_geral = 'Tarefa concluída com sucesso.';

                } else {

                    $mensagem_geral = 'Erro ao concluir a tarefa.';
                }

            } else if(isset($response_body->status) && $response_body->status>0) {

                throw new ErrorException('Erro 5364 - WS retornou erro', 400);

            } else {
                throw new ErrorException('Erro 5364 - WS retornou erro', 400);
            }
        } else {
            //response não está no formato json
            throw new ErrorException('Erro 5364 - WS retornou erro', 400);
        }

        //

        $url_close = $url_close = $this->webroot.'/minhas_tarefas';
        $id_sufix = '_1';
        $resultado = 'sucesso';

        $this->autoRender = false;
        return json_encode(
            array(
                'id_sufix' => $id_sufix,
                'url_close' => $url_close,
                'resultado' => $resultado,
                'mensagem_geral' => $mensagem_geral
            )
        );
    }

    public function ordenar()
    {
        $link = $this->webroot.'tarefas/ordenar.json';

        $data = array(
            'id' => $this->request->data['id'],
            'index_destino' => $this->request->data['index_destino']
        );

        $httpSocket = new HttpSocket();
        $response = $httpSocket->post($link, $data, $this->request);

        $tarefa = json_decode($response->body)->tarefa;

        if($tarefa->resultado=='erro_validacao')
        {
            $mensagem_geral = 'Erro ao ordenar as tarefas.';

        } else if($tarefa->resultado=='erro_bd') {

            $mensagem_geral = 'Erro ao ordenar as tarefas.';

        } else if($tarefa->resultado=='sucesso') {

            $mensagem_geral = 'Tarefas reordenadas com sucesso.';

        } else {

            $mensagem_geral = 'Erro ao ordenar as tarefas.';
        }


        //

        $url_close = $url_close = $this->webroot.'/minhas_tarefas';
        $id_sufix = '_1';
        $resultado = 'sucesso';

        $this->autoRender = false;
        return json_encode(
            array(
                'id_sufix' => $id_sufix,
                'url_close' => $url_close,
                'resultado' => $resultado,
                'mensagem_geral' => $mensagem_geral
            )
        );
    }

    public function salvar()
    {
        $this->request->allowMethod(array('ajax'));

        if($this->request->is('ajax'))
        {
            $request_id = (isset($this->request->data['id'])) ? $this->request->data['id'] : null;

            if($request_id>0)
            {
                $metodo = 'alterar';
                $acao = $this->acao['alterar'];
            } else {
                $metodo = 'adicionar';
                $acao = $this->acao['adicionar'];
            }

            $link = $this->webroot.'tarefas/'.$metodo.'.json';

            $data = $this->request->data;
            $httpSocket = new HttpSocket();
            $response = $httpSocket->post($link, $data, $this->request);
            $response_body = json_decode($response->body);
            $tarefa = null;

            if($response_body!==null)
            {
                //response no formato json

                if(isset($response_body->tarefa) && !empty($response_body->tarefa))
                {
                    $tarefa = json_decode($response->body)->tarefa;

                    if($tarefa->resultado=='erro_validacao')
                    {
                        $mensagem_geral = 'Erro ao '.$acao[0].' a tarefa. (Erro nº 9711)';
                    } else if($tarefa->resultado=='erro_bd') {
                        $mensagem_geral = 'Erro ao '.$acao[0].' a tarefa. (Erro nº 9322)';
                    } else if($tarefa->resultado=='erro_bd_ordem') {
                        $mensagem_geral = 'Erro ao '.$acao[0].' a tarefa. (Erro nº 9389803). A tarefa foi atualizada mas houve um erro ao reordenar as tarefas após a alteração.';
                    } else if($tarefa->resultado=='erro_validacao_id') {
                        $mensagem_geral = 'Erro ao '.$acao[0].' a tarefa. (Erro nº 93228877). Dados incorretos, tarefa não identificada, não foi possível alterar tarefa.';
                    } else if($tarefa->resultado=='sucesso') {
                        $mensagem_geral = 'Tarefa '.$acao[1].' com sucesso.';
                    } else {
                        $mensagem_geral = 'Erro ao '.$acao[0].' a tarefa. (Erro nº 9933)';
                    }

                    $this->autoRender = false;

                    return json_encode(
                        array(
                            'id_sufix' => '_1',
                            'url_close' => $url_close = $this->webroot.'/minhas_tarefas',
                            //'resultado' => 'sucesso',
                            'resultado' => $tarefa->resultado,
                            'mensagem_geral' => $mensagem_geral,
                            'mensagem_erro' => $tarefa->validationErrors,
                        )
                    );


                } else if(isset($response_body->status) && $response_body->status>0) {

                    throw new ErrorException('Erro 5364 - WS retornou erro', 400);

                } else {
                    throw new ErrorException('Erro 5366 - WS retornou erro', 400);
                }

            } else {
                //response não está no formato json
                throw new ErrorException('Erro 5367 - WS retornou erro', 400);
            }
        }

        return false;
    }

    private function tabelas_apoio()
    {
        $situacoes = new Situacao();
        $situacoes = $situacoes->find('all');

        $prioridades = new Prioridade();
        $prioridades = $prioridades->find('all');

        return array(
            'situacoes' => $situacoes,
            'prioridades' => $prioridades,
        );
    }
}