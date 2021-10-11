function login() {

    // impede o form de ser enviado
    event.preventDefault();

    // pega os campos do html
    const email = document.querySelector(".loginArea input[name='email']").value;
    const senha = document.querySelector(".loginArea input[name='senha']").value;
    const keepLog = document.querySelector(".loginArea input[name='keepLoged']").value;
    const erro = document.querySelector(".loginArea form div");

    // campos preenchidos?
    if(email.length === 0 || senha.length === 0){
        erro.innerHTML = "Preencha os Campos";
    } else {

        // request do ajax
        const ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
                const resp = JSON.parse(this.responseText);
                erro.innerHTML = resp.error;
                if(resp.head.length > 0){
                    eval(resp.head);
                }                 
                console.log(this.responseText);
            }
        };

        // direcionamento
        ajax.open("POST", "../php/connLog.php")
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        // prepara os dados a serem enviados
        const sendObj = {};
        sendObj.email = email;
        sendObj.senha = senha;
        sendObj.keepLog = keepLog;
        const toSend = "data=" + JSON.stringify(sendObj);

        ajax.send(toSend);
    }

}

function singin() {

    // impede o form de ser enviado
    event.preventDefault();

    // pega os campos do html
    const email = document.querySelector(".singinArea input[name='email']");
    const name = document.querySelector(".singinArea input[name='userName']");
    const senha = document.querySelector(".singinArea input[name='senha']");
    const senhaConf = document.querySelector(".singinArea input[name='senhaConf']");
    const formId = document.querySelector(".singinArea form");
    const erro = document.querySelector(".singinArea form div");
    
    // campos preenchidos?
    if(email.value.length == 0 || senha.value.length == 0 
        || name.value.length == 0 || senhaConf.value.length == 0){
        erro.innerHTML = "Preencha os Campos";
    } else {

        // as senhas coincidem?
        if(senha.value != senhaConf.value){
            erro.innerHTML = "Senhas não Coincidem";
        } else {

            // request do ajax
            const ajax = new XMLHttpRequest();

            ajax.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    // pega a mensagem de erro
                    /* const resp = JSON.parse(this.responseText);
                    erro.innerHTML = resp.error;
                    if(resp.head.length > 0){
                        eval(resp.head);
                    }           */     
                    console.log(this.responseText);     
                }
            };

            // direcionamento
            ajax.open("POST", "../php/connCad.php");
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            
            // prepara os dados a serem enviados
            const data = new FormData(formId);
            console.log(data);

            ajax.send(data);
        }
    }

}