<div class="panel panel-warning">

    <div class="panel-heading bg-orange">
        <h3 class="panel-title" style="font-size: 180%">

            Alterar Tarefa

            <a href="/<?php echo basename(dirname(APP)); ?>/minhas_tarefas"
               class="btn btn-sm btn-primary pull-right">
                <i class="fa fa-search"></i>
                <span class="texto_responsivo"> Minhas Tarefas</span>
            </a>

            <div style="clear: both;"></div>

        </h3>
    </div>

    <div class="panel-body loading_bg box">

        <div class="col-sm-12">

            <div class="alert alert-danger" style="display: none;">
                <ul>
                </ul>
            </div>

            <form id="form_tarefas" class="form-horizontal"
                  method="post"
                  action="/<?php echo basename(dirname(APP)); ?>/minhas_tarefas/salvar"
                  data-url="/<?php echo basename(dirname(APP)); ?>/minhas_tarefas/salvar">

                <input type="hidden" name="id" value="<?php echo $tarefa->Tarefa->id; ?>">


                <div class="form-group">

                    <label for="situacao_id" class="col-sm-3 control-label">
                        <div class="Obrigatorio">*</div>
                        Status:
                    </label>
                    <div class="col-sm-2 input-group">
                        <select name="situacao_id" id="situacao_id"
                                class="form-control">

                            <?php
                            foreach($situacoes as $opt)
                            {
                                ?>
                                <option value="<?php echo $opt['Situacoes']['id']; ?>"
                                    <?php if($opt['Situacoes']['id']==$tarefa->Tarefa->situacao_id) { echo 'selected'; }; ?>
                                    >
                                    <?php echo $opt['Situacoes']['nome']; ?>
                                </option>
                            <?php
                            }
                            ?>

                        </select>
                    </div>

                </div>

                <div class="form-group">
                    <label for="prioridade_id" class="col-sm-3 control-label">
                        <div class="Obrigatorio">*</div>
                        Prioridade:
                    </label>
                    <div class="col-sm-2 input-group">
                        <select name="prioridade_id" id="prioridade_id"
                                class="form-control">

                            <?php
                            foreach($prioridades as $opt)
                            {
                                ?>
                                <option value="<?php echo $opt['Prioridades']['id']; ?>"
                                    <?php if($opt['Prioridades']['id']==$tarefa->Tarefa->prioridade_id) { echo 'selected'; }; ?>
                                    >
                                    <?php echo $opt['Prioridades']['nome']; ?>
                                </option>
                            <?php
                            }
                            ?>

                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label for="titulo" class="col-sm-3 control-label">
                        <div class="Obrigatorio">*</div>
                        Título:
                    </label>
                    <div class="col-sm-6 input-group">
                        <textarea
                            name="titulo" id="titulo"
                            class="form-control input-upper textarea-60"
                            ><?php echo ($tarefa->Tarefa->titulo!='') ? $tarefa->Tarefa->titulo : ''; ?></textarea>
                    </div>
                </div>


                <div class="form-group">
                    <label for="descricao" class="col-sm-3 control-label">
                        Descrição:
                    </label>
                    <div class="col-sm-6 input-group">
                        <textarea
                            name="descricao" id="descricao"
                            class="form-control textarea-120"
                            ><?php echo ($tarefa->Tarefa->descricao!='') ? $tarefa->Tarefa->descricao : ''; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">

                        <button type="button" class="btn btn-warning btn-salvar">
                            <i class="fa fa-check"></i>
                            Salvar Alterações
                        </button>

                        <a href="/<?php echo basename(dirname(APP)); ?>/minhas_tarefas" class="btn btn-danger">
                            <i class="fa fa-close"></i>
                            Cancelar
                        </a>

                    </div>
                </div>


            </form>

        </div>

    </div>

</div>