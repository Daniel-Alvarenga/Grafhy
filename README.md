# Grafhy
First version of Grafhy (PHP)

Sistema de chat web feito em PHP, onde as pessoas podem se comunicar.

<p align="center">
  <img src="https://github.com/Daniel-Alvarenga/Grafhy/assets/128755697/5708d30e-af69-4fd5-b084-447023b0aba4"/>

</p>

## SOBRE

Essa é a primeira versão do projeto Grafhy, criado juntamente a [Vitor Eduardo][link], onde o obejto era criar uma rede social web onde as pessoas pudessem enviar mensagens umas as outras, criar grupos, chats abertos e etc.
Na época (este repositório apesar de publicado no presente momento teve seu conteúdo desenvolvido em  fevereiro de 2023), a tecnologia escolhida para lidar com o registro de usuários, login, envio de mensagens, criação de grupos, etc. foi PHP por ser simples de ser usado.
Além de mandar mensagens umas para as outras, as pessoas que são amigas (tem o contato uma da outra), podem ver se o contato está online, ou qual a data de seu último acesso. Algo risório que foi feito até então é o armazem de imagens de perfil, feita no banco de dados através de campos blobs, o que não permitia que fotos com tamanho acima de 
75kb fossem inteiramente vistas após o upload...
Gosto de olhar para esse projeto tanto por ser um dos primeiros a ser desenvolvido mutuamente, com integração a um banco de dados tanto para web, e tanto porque apesar de bagunçado e totalmente inaplicável, posso ver o quanto evoluí ao longo do tempo, tanto na questão de desenvolvimento como em estruturação de projetos de médio/grande porte, mas não paro por aqui!

[link]: https://github.com/VitorCarvalho67

## Uso

Se você quiser fazer uso da plataforma, pode clonar esse repositório dentro de sua pasta htdocs (XAMPP), criar uma conexão para banco de dados, ativar o XAMPP (Apache e MySQL), acessar a pasta config/database e executar o script que irá criar o banco de dados em sua máquina, e acessar sua_host/Grafhy

Stop, think and code!
