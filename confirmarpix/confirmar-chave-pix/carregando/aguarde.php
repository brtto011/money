<?php
session_start();

include './../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
  die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

$demo = "first";

$updateQuery = "UPDATE appconfig SET demo = ? WHERE email = ?";
$stmt = $conn->prepare($updateQuery);

// Defina corretamente os tipos de dados para os parâmetros
$stmt->bind_param("ss", $demo, $email); // Aqui você pode precisar ajustar o tipo de dado para o email, dependendo do seu banco de dados

$stmt->execute();
$stmt->close();

} else {
    header("Location: ../login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rodada Grátis - Subway Brasil</title>

    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <style id="" media="all">
        /* thai */
        * {
            background-color: #0b316b;
            font-family: 'Poppins';
        }

.container {
  margin: 30px auto;
  width: 100%;
  text-align: center;
}

.progress {
  padding: 6px;
  background: rgba(0, 0, 0, 0.25);
  border-radius: 6px;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.25), 0 1px rgba(255, 255, 255, 0.08);
}

.progress-bar {	
  height: 18px;
	background-color: #ee303c;  
  border-radius: 4px; 
  transition: 0.4s linear;  
  transition-property: width, background-color;    
}

.progress-striped .progress-bar { 	
  background-color: #FCBC51; 
  width: 50%; 
  background-image: linear-gradient(
        45deg, rgb(252,163,17) 25%, 
        transparent 25%, transparent 50%, 
        rgb(252,163,17) 50%, rgb(252,163,17) 75%,
        transparent 75%, transparent); 
  animation: progressAnimationStrike 6s;
}

@keyframes progressAnimationStrike {
     from { width: 0 }
     to   { width: 100% }
}
 
.progress2 {
  padding: 6px;
  border-radius: 30px;
  background: rgba(0, 0, 0, 0.25);  
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.25), 0 1px rgba(255, 255, 255, 0.08);
}

.progress-bar2 {
  height: 18px;
  border-radius: 30px;
  background-image: 
    linear-gradient(to bottom, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.05));
  transition: 0.4s linear;  
  transition-property: width, background-color;    
}

.progress-moved .progress-bar2 {
  width: 85%; 
  background-color: #EF476F;  
  animation: progressAnimation 6s;
}

@keyframes progressAnimation {
  0%   { width: 5%; background-color: #F9BCCA;}
  100% { width: 85%; background-color: #EF476F; }
}

    </style>

<meta http-equiv="refresh" content="4;url=http://subwaybrasil.bet/jogodemo" />


    <link type="text/css" rel="stylesheet" href="css/font-awesome.min.css" />

    <link type="text/css" rel="stylesheet" href="css/style.css" />


    <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
    <meta name="robots" content="noindex, follow">
    <script nonce="9c5def65-1de3-4be6-bc19-ee6ffdabfd04">
        (function(w, d) {
            ! function(j, k, l, m) {
                j[l] = j[l] || {};
                j[l].executed = [];
                j.zaraz = {
                    deferred: [],
                    listeners: []
                };
                j.zaraz.q = [];
                j.zaraz._f = function(n) {
                    return async function() {
                        var o = Array.prototype.slice.call(arguments);
                        j.zaraz.q.push({
                            m: n,
                            a: o
                        })
                    }
                };
                for (const p of ["track", "set", "debug"]) j.zaraz[p] = j.zaraz._f(p);
                j.zaraz.init = () => {
                    var q = k.getElementsByTagName(m)[0],
                        r = k.createElement(m),
                        s = k.getElementsByTagName("title")[0];
                    s && (j[l].t = k.getElementsByTagName("title")[0].text);
                    j[l].x = Math.random();
                    j[l].w = j.screen.width;
                    j[l].h = j.screen.height;
                    j[l].j = j.innerHeight;
                    j[l].e = j.innerWidth;
                    j[l].l = j.location.href;
                    j[l].r = k.referrer;
                    j[l].k = j.screen.colorDepth;
                    j[l].n = k.characterSet;
                    j[l].o = (new Date).getTimezoneOffset();
                    if (j.dataLayer)
                        for (const w of Object.entries(Object.entries(dataLayer).reduce(((x, y) => ({ ...x[1],
                                ...y[1]
                            })), {}))) zaraz.set(w[0], w[1], {
                            scope: "page"
                        });
                    j[l].q = [];
                    for (; j.zaraz.q.length;) {
                        const z = j.zaraz.q.shift();
                        j[l].q.push(z)
                    }
                    r.defer = !0;
                    for (const A of [localStorage, sessionStorage]) Object.keys(A || {}).filter((C => C.startsWith("_zaraz_"))).forEach((B => {
                        try {
                            j[l]["z_" + B.slice(7)] = JSON.parse(A.getItem(B))
                        } catch {
                            j[l]["z_" + B.slice(7)] = A.getItem(B)
                        }
                    }));
                    r.referrerPolicy = "origin";
                    r.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(j[l])));
                    q.parentNode.insertBefore(r, q)
                };
                ["complete", "interactive"].includes(k.readyState) ? zaraz.init() : j.addEventListener("DOMContentLoaded", zaraz.init)
            }(w, d, "zarazData", "script");
        })(window, document);
    </script>
</head>

<body>
    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404" style="margin-bottom: 100px !important;">
                <img src="https://subwaybrasil.bet/arquivos/Logo.webp" loading="lazy" width="350"  alt="">
            </div>
            <h2 style="color: #fff;"><b>Rodada Grátis está carregando...</b></h2>
            <div class="container">    
                <div class="progress progress-striped">
                  <div class="progress-bar">
                  </div>                       
                </div> 
              </div>
            <!-- <p>The page you are looking for might have been removed had its name changed or is temporarily unavailable. <a href="#">Return to homepage</a></p>
            <div class="notfound-social">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-pinterest"></i></a>
                <a href="#"><i class="fa fa-google-plus"></i></a> -->
            </div>
        </div>
    </div>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"83286c79ebc1a4aa","version":"2023.10.0","token":"cd0b4b3a733644fc843ef0b185f98241"}'
        crossorigin="anonymous"></script>
</body>

</html>