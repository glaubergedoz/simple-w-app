<div class="panel panel-info">

    <div class="panel-heading">

        <h3 class="panel-title" style="font-size: 180%">

            Tarefa #<?php echo $tarefa->Tarefa->id ?>

            <a href="/<?php echo $this->webroot; ?>/minhas_tarefas"
               class="btn btn-sm btn-primary pull-right color-white">
                <i class="fa fa-search"></i>
                <span class="texto_responsivo"> Minhas Tarefas</span>
            </a>

            <a href="/<?php echo $this->webroot; ?>/minhas_tarefas/alterar/<?php echo $tarefa->Tarefa->id ?>"
               class="btn btn-sm bg-orange pull-right margin-r20">
                <i class="fa fa-edit"></i>
                <span class="texto_responsivo"> Alterar Tarefa</span>
            </a>

            <div style="clear: both;"></div>

        </h3>

    </div>

    <div class="panel-body">

        <div>
            <div class="Col-Esq">
                <b>
                    Situação:
                </b>
            </div>
            <div class="Col-Dir">
                <?php echo $tarefa->Situacao->nome; ?>
            </div>
        </div>

        <div>
            <div class="Col-Esq">
                <b>
                    Prioridade:
                </b>
            </div>
            <div class="Col-Dir">
                <?php echo $tarefa->Prioridade->nome; ?>
            </div>
        </div>

        <div>
            <div class="Col-Esq">
                <b>
                    Título:
                </b>
            </div>
            <div class="Col-Dir text-150">
                <?php echo strtoupper($tarefa->Tarefa->titulo); ?>
            </div>
        </div>

        <div>
            <div class="Col-Esq">
                <b>
                    Descrição:
                </b>
            </div>
            <div class="Col-Dir">
                <?php echo $tarefa->Tarefa->descricao; ?>
            </div>
        </div>

    </div>

</div>