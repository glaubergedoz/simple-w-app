<div class="panel panel-success">

    <div class="panel-heading bg-olive">
        <h3 class="panel-title" style="font-size: 180%">

            Adicionar Tarefa

            <a href="/<?php echo basename(dirname(APP)); ?>/minhas_tarefas"
               class="btn btn-sm btn-primary pull-right">
                <i class="fa fa-search"></i>
                <span class="texto_responsivo"> Minhas Tarefas</span>
            </a>

            <div style="clear: both;"></div>

        </h3>
    </div>

    <div class="panel-body loading_bg box">

        <div class="alert alert-danger" style="display: none;">
            <ul>
            </ul>
        </div>

        <div class="col-sm-12">

            <form id="form_tarefas" class="form-horizontal"
                  action="/<?php echo basename(dirname(APP)); ?>/minhas_tarefas/salvar"
                  data-url="/<?php echo basename(dirname(APP)); ?>/minhas_tarefas/salvar"
                  method="post">

                <div class="form-group" style="display: none;">

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
                                <option value="<?php echo $opt['Situacoes']['id']; ?>">
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
                                    <?php if($opt['Prioridades']['id']==2) { echo 'selected'; }; ?>
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
                            ></textarea>
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
                            ></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">

                        <button type="button" class="btn btn-success btn-salvar">
                            <i class="fa fa-plus"></i>
                            Salvar
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