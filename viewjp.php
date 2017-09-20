<?php
session_start();
if(!isset($_SESSION['USERNAME'])){
    header("Location: indexjp.php");
    exit;
}
include 'header.php';
$loged_user = $_SESSION['USERNAME'];
$loged_pass = $_SESSION['PASSWORD'];
$lang = "jp";
?>
    <!--JSXC script and css-->

    <!-- require:dependencies -->
    <!-- block by ALA -->
    <!--<link href="css/jquery-ui.min.css" media="all" rel="stylesheet" type="text/css" />-->
    <link href="css/jsxc.css" media="all" rel="stylesheet" type="text/css" />
    <!--  endrequire -->

    <link href="css/example.css" media="all" rel="stylesheet" type="text/css" />

    <script type="text/javascript">
        var username = "<?php echo $loged_user; ?>";
        var password = "<?php echo $loged_pass; ?>";
        var streamName = '<?php echo $_GET['name']?>';
        var lang = '<?php echo $_GET['lang']?>';
        var count = 0;
        var clearTime;
        var seconds = 0, minutes = 0, hours = 0;
        var clearState;
        var secs, mins, gethours;
        function startWatch() {
            /* check if seconds is equal to 60 and add a +1 to minutes, and set seconds to 0 */
            if ( seconds === 60 ) { seconds = 0; minutes = minutes + 1; }
            /* you use the javascript tenary operator to format how the minutes should look and add 0 to minutes if less than 10 */
            mins = ( minutes < 10 ) ? ( '0' + minutes + ': ' ) : ( minutes + ': ' );
            /* check if minutes is equal to 60 and add a +1 to hours set minutes to 0 */
            if ( minutes === 60 ) { minutes = 0; hours = hours + 1; }
            /* you use the javascript tenary operator to format how the hours should look and add 0 to hours if less than 10 */
            gethours = ( hours < 10 ) ? ( '0' + hours + ': ' ) : ( hours + ': ' ); secs = ( seconds < 10 ) ? ( '0' + seconds ) : ( seconds );
            // display the stopwatch
            var x = document.getElementById("timer");
            //console.log('Time: ' + gethours + mins + secs);
            //console.log(gethours);
            //console.log(mins);
            //console.log(secs);
            x.innerHTML = '経過時間: ' + gethours + mins + secs;
            /* call the seconds counter after displaying the stop watch and increment seconds by +1 to keep it counting */
            seconds++;
            /* call the setTimeout( ) to keep the stop watch alive ! */
            clearTime = setTimeout("startWatch()", 1000 );
        }

        function stopWatch(){
            seconds = 0;
            minutes = 0;
            hours = 0;
            secs = '0' + seconds;
            mins = '0' + minutes + ': ';
            gethours = '0' + hours + ': ';
            /* display the stopwatch after it's been stopped */
            var x = document.getElementById ("timer");
            x.innerHTML = '経過時間: ' + gethours + mins + secs;
            clearTimeout(clearTime);
        }

        logoutview = function(){
            if(chatLoaded == 2){
                jsxc.xmpp.logout(!1);

                setTimeout(function () {
                    console.log('==========================================logout');
                    /* clear the stop watch using the setTimeout( ) return value 'clearTime' as ID */
                    stopWatch();
                    window.location.href = "streamlist.php";
                }, 2000);
            }
        }

        function destroy_session() {
            if(chatLoaded == 2) {
                $.ajax({
                    type: 'GET',
                    url: 'destroy_websession.php',
                    success: function (response) {
                        jsxc.xmpp.logout(!1);
                        setTimeout(function () {
                            console.log('==========================================logout');
                            /* clear the stop watch using the setTimeout( ) return value 'clearTime' as ID */
                            stopWatch();
                            window.location.href = "/";
                        }, 2000);
                    }
                });
            }
        }
    </script>

</head>

<body id="page-top" class="index" <!--onunload="logoutview();"-->>

<!-- Navigation -->
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <a class="navbar-brand" href="javascript:logoutview();">"<?php echo $_GET['name']; ?>" ライブチャット</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="page-scroll active">
                   <!-- <button type="button" onclick="logoutview();">Logout</button>-->
                    <a href="javascript:logoutview();">リストに戻る</a>
                </li>
                <li class="page-scroll logout">
                    <a href="javascript:destroy_session();">ログアウト</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<br><br>
<!-- Portfolio Grid Section -->
<section id="stopWatch">
    <p id="timer">経過時間: 00:00:00</p>
</section>
<section id="portfolio">
    <div class="container">
<!--         <div class="row">
            <div class="col-lg-12 text-center">
                <h2>"<?php echo $_GET['name']; ?>" Live streaming</h2>
                <hr class="star-primary">
            </div>
        </div> -->
        <div id="video-container">
            <div id="loader" style="text-align:left; z-index: 9;">
              <img src="img/spinnner.gif" alt="loader">
            </div>
<!--            <video id="red5pro-subscriber" controls></video>-->
            <div class="video-loader" id="video-loader">
                <img src="img/blur.png" class="blur-img" id="blur-img">
                <img src="" >
                <video id="red5pro-subscriber" width="540" height="540" class="" autoplay></video>
            </div>
        </div>

    </div>

    <!--chatbox in rightside -->
    <div id="chat-box">

    </div>

</section>

<div id="jsxc_windowList_c" class="jsxc_roster_shown beginer-chat">
    <ul style="right: 0px;">
        <li class="jsxc_windowItem jsxc_min_c jsxc_groupchat" data-bid="demo@conference.153.126.152.115">
            <div class="jsxc_window_c" style="bottom: 0px;">
                <div class="jsxc_bar_c">
                    <p class="openchat_c">コメント</p>
                    <div class="jsxc_avatar jsxc_statusIndicator jsxc_undefined" style="background-color: rgb(246, 128, 85); color: rgb(255, 255, 255); font-weight: bold; text-align: center; line-height: 36px; font-size: 21.6px;">D</div>
                    <div class="jsxc_tools">
                        <div class="jsxc_settings">
                            <div class="jsxc_more"></div>
                            <div class="jsxc_inner jsxc_menu">
                                <ul>
                                    <li>
                                        <a class="jsxc_verification" href="#">
                                            <span data-i18n="Authentication">Authentication</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jsxc_clear" href="#">
                                            <span data-i18n="clear_history">Clear history</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="jsxc_sendFile jsxc_disabled" href="#">
                                            <span data-i18n="Send_file">Send file</span>
                                        </a>
                                    </li>
                                    <li><a href="#" class="jsxc_destroy" style="display: none;">Destroy</a></li><li><a href="#" class="jsxc_configure" style="display: none;">Configure</a></li><li><a href="#" class="jsxc_leave">Leave</a></li></ul>
                            </div>
                        </div><div class="jsxc_members"></div>
                        <!--<div class="jsxc_close">×</div>-->
                    </div>
                    <div class="jsxc_caption">
                        <div class="jsxc_name" title="is ">demo</div>
                        <div class="jsxc_lastmsg">
                            <span class="jsxc_unread">0</span>
                            <span class="jsxc_text">you?</span>
                        </div>
                        <div class="jsxc_status-msg" title=""></div>
                    </div>
                </div>
                <div class="jsxc_fade">
                    <div class="jsxc_memberlist"><ul></ul></div>
                    <div class="jsxc_overlay">
                        <div>
                            <div class="jsxc_body"></div>
                            <!--<div class="jsxc_close"></div>-->
                        </div>
                    </div>
                    <div class="slimScrollDiv ui-resizable" style="position: relative; overflow: hidden; width: auto; height: 450px;">
                        <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 124px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 3px; height: 326.613px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 3px;"></div><div class="ui-resizable-handle ui-resizable-w" style="z-index: 90;"></div>
                        <div class="ui-resizable-handle ui-resizable-nw" style="z-index: 90;"></div>
                        <div class="ui-resizable-handle ui-resizable-n" style="z-index: 90;"></div>

                    </div>
                    <div class="jsxc_emoticons jsxc_list_c">
                        <div class="jsxc_inner">
                            <ul><li><div title=":wait:"><div class="jsxc_emoticon jsxc_large" title=":wait:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f590.svg&quot;);"></div></div></li><li><div title=":zzz:"><div class="jsxc_emoticon jsxc_large" title=":zzz:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f4a4.svg&quot;);"></div></div></li><li><div title=":brokenheart:"><div class="jsxc_emoticon jsxc_large" title=":brokenheart:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f494.svg&quot;);"></div></div></li><li><div title=":heart:"><div class="jsxc_emoticon jsxc_large" title=":heart:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/2764.svg&quot;);"></div></div></li><li><div title=":love:"><div class="jsxc_emoticon jsxc_large" title=":love:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f60d.svg&quot;);"></div></div></li><li><div title=":music:"><div class="jsxc_emoticon jsxc_large" title=":music:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f3b5.svg&quot;);"></div></div></li><li><div title="@->--"><div class="jsxc_emoticon jsxc_large" title="@->--" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f339.svg&quot;);"></div></div></li><li><div title=":kiss:"><div class="jsxc_emoticon jsxc_large" title=":kiss:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f617.svg&quot;);"></div></div></li><li><div title=":devil:"><div class="jsxc_emoticon jsxc_large" title=":devil:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f608.svg&quot;);"></div></div></li><li><div title=":coffee:"><div class="jsxc_emoticon jsxc_large" title=":coffee:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/2615.svg&quot;);"></div></div></li><li><div title=":beer:"><div class="jsxc_emoticon jsxc_large" title=":beer:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f37a.svg&quot;);"></div></div></li><li><div title=":no:"><div class="jsxc_emoticon jsxc_large" title=":no:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f44e.svg&quot;);"></div></div></li><li><div title=":yes:"><div class="jsxc_emoticon jsxc_large" title=":yes:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f44d.svg&quot;);"></div></div></li><li><div title=":-X"><div class="jsxc_emoticon jsxc_large" title=":-X" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f910.svg&quot;);"></div></div></li><li><div title="8-)"><div class="jsxc_emoticon jsxc_large" title="8-)" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f60e.svg&quot;);"></div></div></li><li><div title=":kiss:"><div class="jsxc_emoticon jsxc_large" title=":kiss:" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f618.svg&quot;);"></div></div></li><li><div title="=-O"><div class="jsxc_emoticon jsxc_large" title="=-O" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f632.svg&quot;);"></div></div></li><li><div title=":-P"><div class="jsxc_emoticon jsxc_large" title=":-P" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f61b.svg&quot;);"></div></div></li><li><div title=";-)"><div class="jsxc_emoticon jsxc_large" title=";-)" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f609.svg&quot;);"></div></div></li><li><div title=":-("><div class="jsxc_emoticon jsxc_large" title=":-(" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f61e.svg&quot;);"></div></div></li><li><div title=":-D"><div class="jsxc_emoticon jsxc_large" title=":-D" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f601.svg&quot;);"></div></div></li><li><div title=":-)"><div class="jsxc_emoticon jsxc_large" title=":-)" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f642.svg&quot;);"></div></div></li><li><div title=">:-("><div class="jsxc_emoticon jsxc_large" title=">:-(" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f620.svg&quot;);"></div></div></li><li><div title="O:-)"><div class="jsxc_emoticon jsxc_large" title="O:-)" style="background-image: url(&quot;/live/../build/lib/emojione/assets/svg/1f607.svg&quot;);"></div></div></li>
                                <li class="jsxc_clear"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="jsxc_transfer jsxc_otr jsxc_disabled"></div>
                    <textarea class="jsxc_textinput" data-i18n="[placeholder]Comments" placeholder="コメントはまだ準備ができていません" disabled></textarea>
                </div>
            </div>
        </li>
    </ul>
</div>


<?php include 'footer.php';?>


<!-- block by ALA -->
<!--<script src="js/jquery.fullscreen.js"></script>-->

<!--<script src="js/jsxc.dep.js"></script>-->
<!--<script src="build/lib/otr/lib/dsa-webworker.js "></script>-->
<script type="text/javascript" id="jsxc-dep"></script>

<!--  endrequire -->

<!-- jsxc library -->
<!--<script src="js/jsxc.min.js"></script>-->
<script type="text/javascript" id="jsxc-js"></script>

<!-- init script -->
<script type="text/javascript" id="chat-js"></script>
<!--<script src="js/example.js"></script>-->

<!--End of JSXC script and css-->

<!--Red5 custom config-->
<script src="lib/config.js"></script>


<!--Custom JS-->
<script>
    jQuery(document).ready(function() {
        $('#red5pro-subscriber').hide();

        wait('jp');

    });



</script> 


</body>

</html>
