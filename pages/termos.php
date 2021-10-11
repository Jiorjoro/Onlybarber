<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="Barber, Barbearia, Bigode, Mustache, Barba, Beard, Cabelo, Hair">
    <link href="../fonts/feather.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/termos.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel='shortcut icon' href="../media/default/logo.png">
    <title>Termos de Uso | Onlybarber</title>
</head>
<body>
    <?php
    
        // inicia a sessão pro site
        session_start();
    
        // pega dados do cookie
        include "../php/getCookie.php";
    
        // cabeçalho
        include "../templates/cabecalho.php";
    
        // caixinha de notificação
        if(isset($_SESSION['userId'])){
            include "../templates/notification.php";
        }
        
    ?>
    <div class="index">
        <a href="#intro">Introdução</a>
        <a href="#1">Licença</a>
        <a href="#2">Responsabilização pelo Conteúdo</a>
        <a href="#3">Reserva de Direitos</a>
        <a href="#4">Remoção de links postados em nosso site</a>
        <a href="#5">Declaração de Isenção de Responsabilidade</a>
        <a href="#6">Remoção de conteúdos postados em nosso site</a>
    </div>
    <div class="main">
        <h2>Introdução</h2></li>
        <div>
            Estes termos e condições descrevem as regras de uso do site Onlybarber,  localizado no endereço onlybarber.com
            <br />
            Ao acessar este site, consideramos que você está de acordo com os termos e condições abaixo. Não continue a usar o Onlybarber caso você discorde dos termos e condições descritos neste contrato.
        </div>
        <br />
        <hr id="1"></hr>
        <br />
        <h2>Licença: </h2></li>
        <div>
            Exceto em casos em que for indicado o contrário, Onlybarber e seus licenciados têm direito à propriedade intelectual de todo o material 
				postado no Onlybarber. Todos os direitos à propriedade intelectual são reservados.
        </div>
        <br />
        <hr id="2"></hr>
        <br>
        <h2>Responsabilização pelo Conteúdo: </h2>
        <div>Não seremos responsabilizados legalmente por qualquer conteúdo que apareça em nosso Site. Você concorda em nos proteger e nos defender 
				contra todas as acusações que forem levantadas contra nosso Site. Nenhum link deve aparecer em qualquer Site que possa ser interpretado 
				como difamatório, obsceno, criminoso, ou que infrinja, viole ou defenda a violação dos direitos de terceiros.
				<br /><br>
				Precisamos do direito legal de fazer coisas como hospedar Seu Conteúdo, publicá-lo e compartilhá-lo. 
				Você concede a nós e aos nossos sucessores legais o direito de armazenar, arquivar, analisar e exibir 
				Seu Conteúdo e fazer cópias incidentais, conforme necessário para fornecer o Serviço, incluindo a melhoria do Serviço ao longo do tempo. 
				Esta licença inclui o direito de fazer coisas como copiá-lo para nosso banco de dados e fazer backups; mostre para você e outros usuários; 
				analisá-lo em um índice de pesquisa ou de outra forma analisá-lo em nossos servidores; compartilhe-o com outros usuários; e executá-lo, 
				caso Seu Conteúdo seja algo como música ou vídeo.
		</div>
		<br />
		<hr id="3"></hr>
		<br />
        <h2>Reserva de Direitos: </h2>
        <div>
            Reservamos nosso direito de solicitar que você remova todos os links ou quaisquer links que redirecionem para nosso site. Você concorda 
				em remover imediatamente todos os links para nosso site assim que a remoção for solicitada. Também reservamos nosso direito de corrigir 
				e alterar estes termos e condições a qualquer momento. Ao publicar continuadamente links para nosso site, você concorda a seguir estes 
				termos e condições sobre links.
        </div>
        <br />
        <hr id="4"></hr>
        <br />
        <h2>Remoção de links postados em nosso site: </h2>
        <div>
            Se você encontrar qualquer link em nosso Site que seja de qualquer forma ofensivo, você tem a liberdade de entrar em contato conosco e 
				nos informar do problema a qualquer momento. Vamos considerar as solicitações de remoção de links, mas não somos obrigados a remover 
				quaisquer links do nosso site nem a responder diretamente à sua solicitação.<br><br>

				Nós não garantimos que as informações continas neste site são corretas. Nós não garantimos integralidade ou exatidão do conteúdo. Não 
				garantimos que o site se manterá disponível ou que o material do site se manterá atualizado.
        </div>
        <br />
        <hr id="5"></hr>
        <br />
        <h2>Declaração de Isenção de Responsabilidade: </h2>
        <div>
            No máximo possível permitido por lei, nós excluímos todas as representações, garantias e condições relativas ao nosso site e ao uso 
				deste site. Nada nesta declaração de isenção de responsabilidade vai:<br><br>

				<ul>
					<li>limitar ou excluir nossa responsabilidade ou sua responsabilidade por mortes ou danos pessoais;
					<li>limitar ou excluir nossa responsabilidade ou sua responsabilidade por fraudes ou deturpações fraudulentas;
					<li>limitar nossa responsabilidade ou sua responsabilidade de quaisquer maneiras que não forem permitidas sob a lei; excluir quaisquer 
				responsabilidades suas ou nossas que não podem ser excluídas de acordo com a lei aplicável.
				</ul>
					
				As limitações e proibições de responsabilização listadas nesta Seção e em outras partes desta declaração: (a) estão sujeitas ao parágrafo 
				anterior; e (b) regem todas as responsabilizações que surgirem sob a declaração, incluindo responsabilizações surgidas em contrato, em 
				delitos e em quebra de obrigações legais.<br><br>

				Nós não seremos responsáveis por perdas e danos de qualquer natureza.<br><br>
				
				O Onlybarber fornece o site e o serviço “no estado em que se encontra” e “conforme disponível”, 
				sem garantia de qualquer tipo. Sem limitar isso, renunciamos expressamente a todas as garantias, 
				expressas, implícitas ou estatutárias, em relação ao Site e ao Serviço, incluindo, sem limitação, 
				qualquer garantia de comercialização, adequação a uma finalidade específica, título, segurança, precisão e não violação.

                <br><br>

                O Onlybarber não garante que o Serviço atenderá aos seus requisitos; 
                que o Serviço será ininterrupto, oportuno, seguro ou livre de erros; 
                que as informações fornecidas por meio do Serviço são precisas, 
                confiáveis ou corretas; que quaisquer defeitos ou erros serão corrigidos; 
                que o Serviço estará disponível em qualquer horário ou local específico; 
                ou que o Serviço está livre de vírus ou outros componentes prejudiciais. 
                Você assume total responsabilidade e risco de perda resultante do download e / ou uso de arquivos, 
                informações, conteúdo ou outro material obtido do Serviço.
        </div>
        <br />
        <hr id="6"></hr>
        <br />
        <h2>Remoção de conteúdos postados em nosso site: </h2>
        <div>
            O site se resguarda o direito de remover o conteúdo em qualquer caso que for julgado pertinente e acionar os órgãos competentes em caso de vídeos 
            envolvendo Pedofilia ou Maus-Tratos aos animais.
        </div>
        <br />
        <hr id="6"></hr>
        <br />
        <h2>Alterações dos Termos</h2>
        <div>
            Podemos fazer alterações nestes termos bem como em nossas políticas de privacidade sem aviso prévio.
        </div>
        
    </div>
</body>
<script src="../js/userFunctions.js"></script>
</html>