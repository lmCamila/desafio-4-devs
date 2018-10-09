A = {
    valforms: null,
    init: function(){
        A.valforms();
    },
    valforms:{
        jQuery('document').ready(function () {
            var form = document.getElementById('formContact');
            form.addEventListener("click", validar);
            function validar(e) {
                var cliente = document.getElementById('cliente'),
                var contato = document.getElementById('nome_contato');
                var data= document.getElementById('data');
                var status= data.getElementById('status');
                    contErr = 0,
                    
                /*Validar cliente*/
                box_name = document.querySelector('.msg-cliente');
                if (cliente.value == "") {
                    box_name.innerHTML = "Preencha o nome da empresa.";
                    box_name.style.display = 'block';
                    contErr++;
                } else {
                    box_name.style.display = 'none';
                }
                /*Validar contato*/
                box_name = document.querySelector('.msg-contato');
                if (contato.value == "") {
                    box_name.innerHTML = "Preencha o nome do contato.";
                    box_name.style.display = 'block';
                    contErr++;
                } else {
                    box_name.style.display = 'none';
                }
                /*Validar data*/
                box_name = document.querySelector('.msg-data');
                if (data.value == "") {
                    box_name.innerHTML = "Preencha a data.";
                    box_name.style.display = 'block';
                    contErr++;
                } else {
                    box_name.style.display = 'none';
                }
                
                /*Validar status*/
                box_name = document.querySelector('.msg-status');
                if (status.value == "") {
                    box_name.innerHTML = "Preencha o status.";
                    box_name.style.display = 'block';
                    contErr++;
                } else {
                    box_name.style.display = 'none';
                }
                if(contErr =! 0){
                    alert("Cadastro preenchido incorretamente, favor preencher novamente.");
                }
            }
        })
    }
    }

