<?php
session_start();
if(isset($_SESSION['USERNAME'])){
    header("Location:streamlist.php");
    exit;
}
error_reporting(E_ALL);
include "vendor/autoload.php";
include 'header.php';
$lang = "en";

// Create the Openfire Rest api object
$api = new Gidkom\OpenFireRestApi\OpenFireRestApi;

// Set the required config parameters
$api->username = "admin";
$api->password = "streaming";
$api->host = "153.126.152.115";
$api->port = "9090";  // default 9090

$api->useSSL = false;
$api->plugin = "/plugins/restapi/v1";  // plugin

// Add a new user to OpenFire and add to a group
$result = $api->getSessions();
?>
<script type="text/javascript">
    var active_user=new Array();
    jQuery(document).ready(function() {
        var result ='<?php echo json_encode($result) ?>';
        var sess = result.message.session;

        for (var j = 0; j < sess.length; j++) {
            active_user[j] = sess[j].username;
        }
    });
</script>
</head>

<body id="page-top" class="index">


    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <a class="navbar-brand" href="">Live Streaming</a>
            </div>
        </div>
        <!-- /.container-fluid -->
    </nav>
<br><br><br><br>
    <!-- Portfolio Grid Section -->
    <div class="language-header">
        <div class="language-link">
            <a class="language-link-item" href="index.php?lang=en" <?php if($lang == 'en'){?> style="color:#ff9900;" <?php } ?>>English</a> |
            <a class="language-link-item" href="indexjp.php?lang=jp"  <?php if($lang == 'jp'){?> style="color:#ff9900;" <?php } ?>>日本語</a>
        </div>
    </div>
    <section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-xs-offset-4 text-center">
                    <h2>Login</h2>
                    <hr class="star-primary">
                </div>
            </div>

            <div id="" class="col-sm-4 col-xs-offset-4">
                <div id="login">
                    <form action="" method="post">
                        <label>UserName  :</label>
                        <input type="text" name="username" id="username" placeholder="username"/><br /><br />
                        <label>Password  :</label>
                        <input type="password" name="password" id="password" placeholder="**********"/><br/><br />
                        <input type="button" value=" Login " name="submit" id="submit"/><br />
                        <span></span>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; Live Streaming 2017
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script type="text/javascript" id="jsxc-dep"></script>
    <!--  endrequire -->

    <!-- jsxc library -->
    <!--<script src="js/jsxc.min.js"></script>-->
    <script type="text/javascript" id="jsxc-js"></script>

    <!-- init script -->
    <script type="text/javascript">
        $('#submit').click(function() {

            var username = $('#username').val();
            var password = $('#password').val();
            var bool = true;

            for (var j = 0; j < active_user.length; j++) {
                if(active_user[j]==username){
                    bool = false;
                    break;
                }
            }
            console.log("===================================================bool="+bool);
            if(bool){
                wait('en');
                var settings = {
                    xmpp: {
                        //url: 'http://123.200.14.11:7070/http-bind/',
                        url: 'http://153.126.152.115:7070/http-bind/',
                        //domain: 'webhawksit',
                        domain: '153.126.152.115',
                        resource: 'Android',
                        overwrite: true
                    }
                };

                var jid = username + '@' + settings.xmpp.domain;


                document.getElementById("jsxc-dep").src = "js/jsxc.dep.js";
                document.getElementById("jsxc-dep").addEventListener('load', function () {
                    document.getElementById("jsxc-js").src = "js/jsxc.min.js";
                    document.getElementById("jsxc-js").addEventListener('load', function () {



                        // Initialize core functions, intercept login form
                        // and attach connection if possible.
                        jsxc.init({

                            xmpp: {
                                url: settings.xmpp.url,
                                resource: settings.xmpp.resource
                            }
                        });

                        jsxc.start(jid, password);
                        //jsxc.start('webuser@' + settings.xmpp.domain, 'webuser');
                        //var nameStream = streamName + '@conference.' + settings.xmpp.domain;

                        //after connected to jsxc
                        $(document).on('connected.jsxc', function () {

                            console.log("==============================================connected");

                            var dataString = 'username=' + username + '&password=' + password;


                            $.ajax({

                                type: "POST",
                                url: "websession.php",
                                data: dataString,
                                dataType: 'json',
                                cache: false,
                                success: function (response) {

                                    console.log("=============================================" + response.username);

                                }
                            });

                            //logout from current user
                            jsxc.xmpp.logout(!1);

                            setTimeout(function () {
                                jQuery.unblockUI();
                                console.log('==========================================logout');
                                window.location.href = "streamlist.php";
                            }, 3000);
                            /*jsxc.muc.join(nameStream, 'webuser', 'webuser', streamName, null, null, 1);

                             $("#jsxc_roster").hide(); //Hide chatlist window
                             $(".jsxc_rosteritem[data-bid='" + streamName + "@conference." + settings.xmpp.domain + "']").trigger('click'); //Show the chat room window
                             $(".jsxc_caption").trigger('click'); //expand the chat room window
                             $(".jsxc_bar").click(); //expand the chat room window
                             //jsxc.gui.window.toggle("nexus@conference.webhawksit");
                             //jsxc.gui.window.init("kudduss@conference.webhawksit");
                             jQuery.unblockUI();
                             chatLoaded = 2;
                             startWatch();*/
                        });


                        //onMessage
                        $(document).on('message.jsxc', function () {
                            console.log("==============================================onMessage");
                        });
                        //console.log("Message on");


                        $(document).on('connecting.jsxc', function () {
                            //formElements.prop('disabled', true);
                            console.log("===============================================connecting");
                        });

                        $(document).on('authfail.jsxc', function () {
                            //formElements.prop('disabled', false);
                            //$(source).find('.alert').show();
                            //$(source).find('.submit').button('reset');
                            console.log("===============================================authfail");
                            jQuery.unblockUI();
                            alert("Invalid user name or password");
                        });

                        $(document).on('attached.jsxc', function () {
                            //formElements.prop('disabled', true);
                            // $('.submit').hide();
                            // $('form .alert').hide();
                            //
                            // $('.logout').show().click(jsxc.xmpp.logout);
                            console.log("===============================================attached");
                        });

                        $(document).on('disconnected.jsxc', function () {

                        });

                        $(document).on('ready.roster.jsxc', function () {
                            console.log("===============================================ready.roster.jsxc ()");

                        });
                    });
                });
            } else{
                alert('This user has already logged in with another device. Please try with a different user name');
            }
        });

    </script>
</body>

</html>
