<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    private $emails = [
        'jebsantosalves@gmail.com',
        'alandelimasilva51@gmail.com',
        'amandabispo037@gmail.com',
        'cg70136@gmail.com',
        'andreimatias97@gmail.com',
        'beatrizapvallemartins@gmail.com',
        'bibicless@gmail.com',
        'faresende914@gmail.com',
        'bruno2004sa@gmail.com',
        'danieldesouzarufino@gmail.com',
        'jean.roberto927@gmail.com',
        'eliel.a.m.godoy@gmail.com',
        'erick.p781@outlook.com',
        'bigol2109@outlook.com',
        'gl3492860@gmail.com',
        'giovanas.franca01@gmail.com',
        'giovannadasilva280500@gmail.com',
        'vanessafigueiredogr@gmail.com',
        'guscadnerd@gmail.com',
        'jajpsa225@gmail.com',
        'raildee@hotmail.com',
        'juanfariasbr@gmail.com',
        'dojeitoj@gmail.com',
        'vilmasilva201019@hotmail.com',
        'pereira.l.c4137@gmail.com',
        'maraparecida.almeida@gmail.com',
        'werlang.mariaeduarda@gmail.com',
        'mariane.souza030405@gmail.com',
        'nana090605@gmail.com',
        'santossilva.7400@gmail.com',
        'raafel.xp500@gmail.com',
        'raissa1501santos@gmail.com',
        'raphaelgarciaalves3@gmail.com',
        'sjandoza18@gmail.com',
        'luis@lualdyreintegracao.com.br',
        'vektromboni@gmail.com',
        'victor25032006@gmail.com',
        'alan.silva397@etec.sp.gov.br',
        'amanda.batista71@etec.sp.gov.br',
        'ana.oliveira1610@etec.sp.gov.br',
        'andrei.matias@etec.sp.gov.br',
        'beatriz.martins108@etec.sp.gov.br',
        'bianca.silva1152@etec.sp.gov.br',
        'bruno.rezende01@etec.sp.gov.br',
        'bruno.portugal01@etec.sp.gov.br',
        'daniel.rufino6@etec.sp.gov.br',
        'danilo.rodrigues108@etec.sp.gov.br',
        'edward.silva4@etec.sp.gov.br',
        'eliel.godoy@etec.sp.gov.br',
        'erick.bastos2@etec.sp.gov.br',
        'gabriel.mendes88@etec.sp.gov.br',
        'gabriel.freire01@etec.sp.gov.br',
        'giovana.franca4@etec.sp.gov.br',
        'giovanna.silva548@etec.sp.gov.br',
        'guilherme.pereira361@etec.sp.gov.br',
        'gustavo.cruz90@etec.sp.gov.br',
        'henrique.machado34@etec.sp.gov.br',
        'joao.alves254@etec.sp.gov.br',
        'joao.cabral14@etec.sp.gov.br',
        'joao.rodrigues328@etec.sp.gov.br',
        'juan.rocha5@etec.sp.gov.br',
        'julia.goncalves83@etec.sp.gov.br',
        'julio.neves2@etec.sp.gov.br',
        'lucas.carvalho269@etec.sp.gov.br',
        'marcela.almeida17@etec.sp.gov.br',
        'maria.werlang@etec.sp.gov.br',
        'mariane.souza22@etec.sp.gov.br',
        'nair.sousa@etec.sp.gov.br',
        'paulo.silva1449@etec.sp.gov.br',
        'rafael.silva2103@etec.sp.gov.br',
        'raissa.ramos4@etec.sp.gov.br',
        'raphael.silva297@etec.sp.gov.br',
        'sarah.laurindo@etec.sp.gov.br',
        'tamiris.carvalho5@etec.sp.gov.br',
        'victor.cardoso36@etec.sp.gov.br',
        'victor.roma@etec.sp.gov.br',
        "ana.mb236@gmail.com",
        "ajlimaa12@gmail.com",
        "analuisaaugusto046@gmail.com",
        "marister22@hotmail.com",
        "gustavodiasdsc@gmail.com",
        "robertofecap@hotmail.com",
        "elaine-cabral@hotmail.com",
        "maraparecida.almeida@gmail.com",
        "tamirisromano718@gmail.com"
    ];

    private $emailsFatec = [
        "alan.silva138@fatec.sp.gov.br",
        "beatriz.martins13@fatec.sp.gov.br",
        "victor.cardoso8@fatec.sp.gov.br",
        "daniel.rufino01@fatec.sp.gov.br",
        "bruno.portugal01@fatec.sp.gov.br",
        "edward.silva@fatec.sp.gov.br",
        "henrique.machado3@fatec.sp.gov.br",
        "natasha.alves@fatec.sp.gov.br",
        "nair.sousa@fatec.sp.gov.br",
        "sarah.laurindo@fatec.sp.gov.br",
        "gabriel.germano@fatec.sp.gov.br",
        "melissa.conceicao01@fatec.sp.gov.br",
        "bruno.rezende@fatec.sp.gov.br",
        "kayky.sousa@fatec.sp.gov.br",
        "tamiris.carvalho01@fatec.sp.gov.br",
        "erick.bastos@fatec.sp.gov.br",
        "raissa.ramos2@fatec.sp.gov.br",
        "giovana.franca01@fatec.sp.gov.br",
        "joao.rodrigues94@fatec.sp.gov.br",
        "gustavo.siqueira14@fatec.sp.gov.br",
        "gabriel.alves70@fatec.sp.gov.br",
        "victor.roma@fatec.sp.gov.br",
        "lucas.carvalho84@fatec.sp.gov.br",
        "guilherme.paula24@fatec.sp.gov.br",
        "yann.casanova@fatec.sp.gov.br",
        "marcela.almeida3@fatec.sp.gov.br",
        "gabriel.freire4@fatec.sp.gov.br",
        "gabriel.mendes19@fatec.sp.gov.br",
        "gabriel.mendes19@fatec.sp.gov.br",
        "paulo.silva498@fatec.sp.gov.br",
        "eliel.godoy01@fatec.sp.gov.br",
        "ana.val@fatec.sp.gov.br",
        "joao.cabral01@fatec.sp.gov.br",
        "rafael.silva744@fatec.sp.gov.br",
        "maria.werlang@fatec.sp.gov.br",
        "juan.rocha01@fatec.sp.gov.br",
        "giovanna.silva90@fatec.sp.gov.br",
        "danilo.rodrigues24@fatec.sp.gov.br",
        "carolina.lima3@fatec.sp.gov.br",
        "julio.neves01@fatec.sp.gov.br",
        "ana.batista12@fatec.sp.gov.br",
        "mariane.souza6@fatec.sp.gov.br",
        "bianca.silva142@fatec.sp.gov.br",
        "ana.oliveira277@fatec.sp.gov.br",
        "julia.goncalves6@fatec.sp.gov.br",
        "natan.rezende@fatec.sp.gov.br",
        "marcos.santos227@fatec.sp.gov.br"
    ];

    private $otherEmails = [
        'smartjoboficial@gmail.com',
        'domingaspatricia014@gmail.com',
        'marta0967@gmail.com',
        'ra-fa0605@hotmail.com',
        'tania.fernandez@gmail.com',
        'viincoder@gmail.com',
        'maria.correia36@etec.sp.gov.br',
        'maria.correia37@etec.sp.gov.br',
        'joao.alves254@etec.sp.gov.br',
        'jajpsa225@gmail.com',
        'msc2005eduarda@gmail.com',
    ];

    public function senEmails(){
        $allEmails = array_merge($this->otherEmails, $this->emailsFatec, $this->emails);
        $allEmails = ['jebsantosalves@gmail.com'];

        $subject = 'Nova Senha';
        $lineText = 'Eai meu camarada, sua senha foi redefinida. Desculpa a demora, mas o Zuckerberg fez nosso server ir de arrasta pra cima <br><br>Email: jajpsa225@gmail.com <br>Senha: 12345678';
        $actionText = 'Login';
        // $url = url('/');
        $url = env('APP_URL');

        foreach ($allEmails as $email) {
            $this->setNotificationEmail($email, $subject, $lineText, $actionText, $url);
        }

        return "E-mails enviados com sucesso!";
    }


    public function setNotificationEmail($email, $subject, $lineText, $actionText, $url) {
        Mail::send('mails.notification',
        [
            'email' => $email,
            'subject' => $subject,
            'lineText' => $lineText,
            'actionText' => $actionText,
            'url' => $url
        ],
        function ($m) use ($email, $subject) {
            $m->from('pacoca150723@gmail.com', 'Paçoca');
            $m->to($email)->subject($subject);
        });
    }
}
