//app.js

function adicionar_carrinho(id_produto) {
    
    axios.defaults.withCredentials = true;
    axios.get('?a=adicionar_carrinho&id_produto=' + id_produto)
    .then(   function(response){
        var total_produtos = response.data;
        document.getElementById('carrinho').innerText = total_produtos;
        /* console.log(response.data); */


    });
    
}




function limpar_carrinho(id_produto) {

     var e = document.getElementById("confirmar_limpar_carrinho");
     e.style.display = "inline";
    
}


function limpar_carrinho_off(id_produto) {

    var e = document.getElementById("confirmar_limpar_carrinho");
    e.style.display = "none";
   
}


function usar_morada_alternativa() {
 
    var e = document.getElementById('check_morada_alternativa');
    if (e.checked == true ) {
        document.getElementById("morada_alternativa").style.display='block';
    } else {
        document.getElementById("morada_alternativa").style.display='none';
    }
}


   function morada_alternativa(){
    axios({
        method: 'post',
        url: '?a=morada_alternativa',
        data : {
             text_morada   : 'app_js',    
            //  text_morada   : document.getElementById('text_morada_alternativa').Value,
            text_email    : document.getElementById('text_email_alternativa').Value,
            text_cidade   : document.getElementById('text_cidade_alternativa').Value,
            text_telefone : document.getElementById('text_telefone_alternativa').Value



        }


    }).
      then(function(response){
           console.log('ok');
        });


    }


    

