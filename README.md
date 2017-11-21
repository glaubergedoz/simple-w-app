# Simple W APP

Simple W APP é o resultado de uma prova técnica sobre PHP. Contém resolução de exercícios e um pequeno gerenciador de tarefas. Também possui uma API REST para integração.


## Instalação via Git e Composer

1º Passo => Clonar o projeto do repositório https://github.com/glaubergedoz/simple-w-app.git

2º Passo => Instalar os componentes do projeto com o comando: composer update

3º Passo => Criar a base de dados 'simplewapp' e rodar o SQL simplewapp.sql localizado na raiz do projeto

4º Passo => Configurar o arquivo app/Config/database.php com as credenciais de acesso à base de dados


## Requisitos

PHP = 5.3

MySQL >= 5.1 (ou MariaDB >= 10.1)


## Recursos

Controle de Tarefas

API REST para integração

Utiliza framework CakePHP 2.1 (https://book.cakephp.org/2.0/)

Utiliza template view AdminLTE (https://adminlte.io/)

Interface responsiva

Recurso arrasta-e-solta para ordenar as tarefas (funciona também em dispositivos móveis)

Situações para as tarefas: tarefas para fazer e tarefas feitas

Prioridades para as tarefas: Baixa, Normal, Alta e Urgente