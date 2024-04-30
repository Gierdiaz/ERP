
# Documentação

## Introdução
Nesta documentação, iremos revisar os conceitos e códigos aprendidos hoje, incluindo o agendamento de tarefas (schedule) e o despacho de trabalhos (jobs) em uma aplicação Laravel.

## Arquivos e Funcionalidades
1. **MeetingInvitation Mailable (`emails/MeetingInvitation.php`)**
   - Classe responsável por criar o e-mail de convite para reunião.
   - Define o assunto do e-mail e a visualização através do método `build()`.

2. **Schedule de Envio de E-mails (`schedule.php`)**
   - Utiliza o `Schedule` do Laravel para agendar o envio de e-mails de convite para reunião para todos os usuários.
   - O agendamento é configurado para ocorrer diariamente às 11:16, com o fuso horário da América/São_Paulo.

3. **UserObserver (`Observers/UserObserver.php`)**
   - Observador de evento de criação de usuário.
   - Despacha um trabalho (job) para enviar um e-mail de boas-vindas ao usuário com um atraso de 1 minuto após a criação do usuário.

4. **SendWelcomeEmailJob (`Jobs/SendWelcomeEmailJob.php`)**
   - Trabalho responsável por enviar um e-mail de boas-vindas ao usuário.
   - Recebe o usuário como parâmetro no construtor e envia o e-mail no método `handle()`.

5. **WelcomeNotification (`Notifications/WelcomeNotification.php`)**
   - Notificação para enviar um e-mail de boas-vindas ao usuário.
   - Configura o conteúdo do e-mail, incluindo cumprimento, mensagem de boas-vindas, ação e assinatura.

6. **AuthenticationController (`Controllers/Auth/AuthenticationController.php`)**
   - Controlador para registro de novos usuários.
   - Valida os dados de entrada, cria o usuário com uma foto de perfil padrão se não fornecida, e envia um e-mail de verificação após o registro.

## Comandos no Terminal
- **Executar o Job de Envio de E-mail:**
  ```
  php artisan queue:work
  ```
  - Este comando executa o processo de trabalho em segundo plano, permitindo que os trabalhos (jobs) enfileirados sejam processados.

- **Executar o Agendamento de Tarefas (Schedule):**
  ```
  php artisan schedule:run
  ```
  - Este comando verifica o agendamento de tarefas definido na aplicação Laravel e executa as tarefas programadas conforme necessário.

## Considerações Finais
Esta documentação fornece uma visão geral dos conceitos aprendidos hoje, incluindo o agendamento de tarefas e o despacho de trabalhos em uma aplicação Laravel. Ao implementar essas funcionalidades, os desenvolvedores podem automatizar tarefas e fornecer uma melhor experiência de usuário em suas aplicações.
