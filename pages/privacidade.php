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
        <a href="#1">Política Privacidade</a>
        <a href="#2">Compromisso do Usuário</a>
    </div>
    <div class="main">
        <h2 id="1">Política Privacidade</h2>
			A sua privacidade é importante para nós. É política do  Onlybarber respeitar a sua privacidade em relação a qualquer informação sua que 
			possamos coletar no site Onlybarber, e outros sites que possuímos e operamos.
			
			Solicitamos informações pessoais apenas quando realmente precisamos delas para lhe fornecer um serviço. Fazemo-lo por meios justos e legais, 
			com o seu conhecimento e consentimento. Também informamos por que estamos coletando e como será usado.

			Apenas retemos as informações coletadas pelo tempo necessário para fornecer o serviço solicitado. Quando armazenamos dados, protegemos dentro 
			de meios comercialmente aceitáveis para evitar perdas e roubos, bem como acesso, divulgação, cópia, uso ou modificação não autorizados.

			Não compartilhamos informações de identificação pessoal publicamente ou com terceiros, exceto quando exigido por lei.

			O nosso site pode ter links para sites externos que não são operados por nós. Esteja ciente de que não temos controle sobre o conteúdo e 
			práticas desses sites e não podemos aceitar a responsabilidade por suas respectivas políticas de privacidade.

			Você é livre para recusar a nossa solicitação de informações pessoais, entendendo que talvez não possamos fornecer alguns dos serviços 
			desejados.

			O cadastro em nosso site será considerado como aceitação de nossas práticas em torno de privacidade e informações pessoais. Se você tiver 
			alguma dúvida sobre como lidamos com dados do usuário e informações pessoais, entre em contacto conosco.
			
			<br>
            <hr id='2'></hr>
            <br>
            
			<h3>Compromisso do Usuário</h3>
			O usuário se compromete a fazer uso adequado dos conteúdos e da informação que o Onlybarber oferece no site e com caráter enunciativo, mas não limitativo:
			<ol>
				<li> Não se envolver em atividades que sejam ilegais ou contrárias à boa fé a à ordem pública;
				<li> Não difundir propaganda ou conteúdo de natureza racista, xenofóbica, ou apostas online (ex.: Betano), jogos de sorte e azar, qualquer tipo de pornografia ilegal, de apologia ao terrorismo ou contra os direitos humanos;
				<li> Não causar danos aos sistemas físicos (hardwares) e lógicos (softwares) do Onlybarber, de seus fornecedores ou terceiros, para introduzir ou disseminar vírus informáticos ou quaisquer outros sistemas de hardware ou software que sejam capazes de causar danos anteriormente mencionados.
			</ol>
			<br>
        
    </div>
</body>
<script src="../js/userFunctions.js"></script>
</html>