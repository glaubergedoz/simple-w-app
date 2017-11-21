<div class="panel panel-primary">

    <div class="panel-heading">
        <h3 class="panel-title" style="font-size: 180%">

            Minhas Tarefas

            <a href="<?php echo $this->webroot; ?>minhas_tarefas/adicionar"
               class="btn btn-sm btn-success pull-right">
                <i class="fa fa-plus"></i>
                <span class="texto_responsivo"> Adicionar Tarefa</span>
            </a>

            <div style="clear: both;"></div>

        </h3>
    </div>

    <div class="panel-body loading_bg box">

        <div class="row">

            <section class="col-lg-12 connectedSortable">

                <div class="box box-primary">

                    <div class="box-header">
                    </div>

                    <div class="box-body">

                        <ul class="todo-list" data-url="<?php echo $this->webroot; ?>minhas_tarefas/ordenar">

                            <?php
                            echo count($tarefas);
                            if(isset($tarefas) && count($tarefas)>0)
                            {

                                echo '<pre>';
                                var_dump($tarefas);
                                echo '</pre>';exit;
                                foreach($tarefas as $tarefa)
                                {
                                    ?>

                                    <li class="<?php if($tarefa->Tarefa->situacao_id==2) { echo 'bg-checked'; } else { echo 'situacao_feita'; } ?>"  data-id="<?php echo $tarefa->Tarefa->id; ?>">

                                        <?php

                                        if($tarefa->Tarefa->situacao_id==2)
                                        {
                                            echo '<i class="fa fa-check check_green"></i>';

                                        } else {

                                        ?>

                                            <span class="handle">
                                            <i class="fa fa-ellipsis-v"></i>
                                            <i class="fa fa-ellipsis-v"></i>
                                            </span>

                                            <input class="pointer btn-status btn-salvar"
                                                   name="situacao_id" type="checkbox"
                                                   value="1" title="concluir a tarefa"
                                                   data-url="<?php echo $this->webroot; ?>minhas_tarefas/concluir/<?php echo $tarefa->Tarefa->id; ?>">

                                        <?php
                                        }
                                        ?>

                                        <a href="<?php echo $this->webroot; ?>minhas_tarefas/mostrar/<?php echo $tarefa->Tarefa->id; ?>">
                                            <span class="text text-black <?php if($tarefa->Tarefa->situacao_id==2) { echo 'text-line-through'; } ?>">



                                                #<?php echo strtoupper($tarefa->Tarefa->id); ?>:
                                                <?php echo strtoupper($tarefa->Tarefa->titulo); ?>
                                            </span>
                                        </a>

                                        <?php

                                        $style = '';

                                        if($tarefa->Tarefa->prioridade_id==1)
                                        {
                                            $style = 'label-info';
                                        } else if($tarefa->Tarefa->prioridade_id==2) {
                                            $style = 'label-primary';
                                        } else if($tarefa->Tarefa->prioridade_id==3) {
                                            $style = 'label-warning';
                                        } else if($tarefa->Tarefa->prioridade_id==4) {
                                            $style = 'label-danger';
                                        }

                                        if($tarefa->Tarefa->situacao_id!=2)
                                        {
                                        ?>

                                            <small class="label <?php echo $style; ?>">

                                                <i class="fa fa-clock-o"></i>

                                                <?php echo strtoupper($tarefa->Prioridade->nome); ?>

                                            </small>

                                        <?php
                                        }

                                        ?>

                                        <div class="tools">

                                            <a class="tools-a"
                                               href="<?php echo $this->webroot; ?>minhas_tarefas/mostrar/<?php echo $tarefa->Tarefa->id; ?>">
                                                <i class="fa fa-info"></i>
                                            </a>

                                            <a class="tools-a"
                                               href="<?php echo $this->webroot; ?>minhas_tarefas/alterar/<?php echo $tarefa->Tarefa->id; ?>">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a class="btn-salvar"
                                               href="<?php echo $this->webroot; ?>minhas_tarefas/excluir/<?php echo $tarefa->Tarefa->id; ?>">
                                                <i class="fa fa-trash-o"></i>
                                            </a>

                                        </div>

                                    </li>

                                <?php
                                }
                            } else {
                                echo 'Nenhuma tarefa cadastrada.';
                            }
                            ?>

                        </ul>

                    </div>

                    <div class="box-footer clearfix no-border">
                    </div>

                </div>

            </section>

        </div>

    </div>

</div>