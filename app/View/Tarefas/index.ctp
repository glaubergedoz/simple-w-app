<div class="panel panel-primary">

    <div class="panel-heading">
        <h3 class="panel-title text-180">
            API Tarefas
        </h3>
    </div>

    <div class="panel-body">

        <div class="row">

            <section class="col-lg-12 connectedSortable">

                <div class="box box-primary">

                    <div class="box-header">
                        <div class="text-150">Métodos</div>
                    </div>

                    <div class="box-body">

                        <ul class="ul-1">

                            <li class="li-1">

                                <div class="text-150"><b>Pesquisar</b></div>

                                <ul>
                                    <li><b>Url: </b>/tarefas/pesquisar.json</li>
                                    <li><b>Método:</b> GET</li>
                                    <li>Parâmetros: nenhum</li>
                                    <li>Retorno: array formato JSON</li>
                                </ul>

                            </li>

                            <li class="li-1">

                                <div class="text-150"><b>Mostrar</b></div>

                                <ul>
                                    <li><b>Url: </b>/tarefas/mostrar/{id}.json</li>
                                    <li><b>Método:</b> GET</li>
                                    <li>
                                        Parâmetros:
                                        <ul><li>Informar o id da tarefa na Url</li></ul>
                                    </li>
                                    <li>Retorno: array formato JSON</li>
                                </ul>

                            </li>

                            <li class="li-1">

                                <div class="text-150"><b>Adicionar</b></div>

                                <ul>
                                    <li><b>Url: </b>/tarefas/adicionar.json</li>
                                    <li><b>Método:</b> POST</li>
                                    <li>
                                        Parâmetros:
                                        <ul>
                                            <li>titulo: string</li>
                                            <li>descricao: string</li>
                                            <li>prioridade: int (valores 1, 2, 3 ou 4)</li>
                                            <li>situacao: int (valor 1)</li>
                                        </ul>
                                    </li>
                                    <li>Retorno: array formato JSON</li>
                                </ul>

                            </li>

                            <li class="li-1">

                                <div class="text-150"><b>Alterar</b></div>

                                <ul>
                                    <li><b>Url: </b>/tarefas/alterar.json</li>
                                    <li><b>Método:</b> POST</li>
                                    <li>
                                        Parâmetros:
                                        <ul>
                                            <li>id: int</li>
                                            <li>titulo: string</li>
                                            <li>descricao: string</li>
                                            <li>prioridade: int (valores 1, 2, 3 ou 4)</li>
                                            <li>situacao: int (valores 1 ou 2)</li>
                                        </ul>
                                    </li>
                                    <li>Retorno: array formato JSON</li>
                                </ul>

                            </li>

                            <li class="li-1">

                                <div class="text-150"><b>Excluir</b></div>

                                <ul>
                                    <li><b>Url: </b>/tarefas/excluir.json</li>
                                    <li><b>Método:</b> POST</li>
                                    <li>
                                        Parâmetros:
                                        <ul>
                                            <li>id: int</li>
                                        </ul>
                                    </li>
                                    <li>Retorno: array formato JSON</li>
                                </ul>

                            </li>

                            <li class="li-1">

                                <div class="text-150"><b>Concluir</b></div>

                                <ul>
                                    <li><b>Url: </b>/tarefas/concluir.json</li>
                                    <li><b>Método:</b> POST</li>
                                    <li>
                                        Parâmetros:
                                        <ul>
                                            <li>id: int</li>
                                        </ul>
                                    </li>
                                    <li>Retorno: array formato JSON</li>
                                </ul>


                            </li>

                            <li class="li-1">

                                <div class="text-150"><b>Ordenar</b></div>

                                <ul>
                                    <li><b>Url: </b>/tarefas/ordenar.json</li>
                                    <li><b>Método:</b> POST</li>
                                    <li>
                                        Parâmetros:
                                        <ul>
                                            <li>id: int</li>
                                            <li>index_destino: int (posição zero-indexada da tarefa no array para onde será reordenada a tarefa)</li>
                                        </ul>
                                    </li>
                                    <li>Retorno: array formato JSON</li>
                                </ul>

                            </li>

                        </ul>

                    </div>

                    <div class="box-footer clearfix no-border">
                    </div>

                </div>

            </section>

        </div>

    </div>

</div>