// video events
var STATE = 0;
var Unpublish = 1;
var Conclosed = 2;
//For Mobile screnn size
var SCREENSIZE_X = 0;
var SCREENSIZE_Y = 0;
var POS_X = 0;
var POS_Y = 0;
var CAMERA = 'frontCamera';
var BLUR_STYLE ='1';
var BLUR_STATE ='0';
var ORIENTATION ='90';
var BODY_MSG ='';
// video events
var browser = myBrowser();
var protocol_rtc = 'ws';
var protocol_rtmp = 'rtmp';
var protocol_hls = 'http';
var host = '153.126.152.115';
//var host = '123.200.14.11';
//var isSecure = protocol.charAt(protocol.length - 2);

// Using Chrome/Google TURN/STUN servers.
var iceServers = [{urls: 'stun:stun2.l.google.com:19302'}];
var subscriber = new red5prosdk.RTCSubscriber;
if((browser=='Safari')) {
    subscriber = new red5prosdk.HLSSubscriber;
}
var viewer = new red5prosdk.PlaybackView('red5pro-subscriber');
// Attach the subscriber to the view.
var coun = 0;
var closemsg = "Streaming Closed.";

function BlurMovePositionCalculation(screensize, position, screenWidth) {
    return ((position/screensize) * screenWidth);
}

function myBrowser() {
    if((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) != -1 )
    {
        return 'Opera';
    }
    else if(navigator.userAgent.indexOf("Chrome") != -1 )
    {
        return 'Chrome';
    }
    else if(navigator.userAgent.indexOf("Safari") != -1)
    {
        return 'Safari';
    }
    else if(navigator.userAgent.indexOf("Firefox") != -1 )
    {
        return 'Firefox';
    }
    else if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true )) //IF IE > 10
    {
        return 'IE';
    }
    else
    {
        return 'unknown';
    }
}




subscriber.on('*', function handleSubscriberEvent (event) {
// The name of the event:
    var type = event.type;
// The dispatching publisher instance:
    var subscriber = event.subscriber;
// Optional data releated to the event (not available on all events):
    var data = event.data;
    console.log(type+":======================================="+Date());

    if(type == 'Subscribe.Start'){
        //console.log("=======Start================================"+Date());
        document.getElementById("jsxc-dep").src="js/jsxc.dep.js";
        document.getElementById("jsxc-dep").addEventListener('load',function(){
            if(lang=='en') {
                document.getElementById("jsxc-js").src = "js/jsxc.min.js";
                closemsg="Streaming Closed.";
            } else {
                document.getElementById("jsxc-js").src = "js/jsxcjp.min.js";
                closemsg="ストリーミングクローズ.";
            }
            document.getElementById("jsxc-js").addEventListener('load',function(){
               document.getElementById("chat-js").src="js/example.js";
               document.getElementById("chat-js").addEventListener('load', function(){
                    //console.log("=======Start=======================ssss========="+Date());

                    //$(".jsxc_windowList").hide(); //Hide existing chat window
                    /*$("#jsxc_roster").hide(); //Hide chatlist window
                    $(".jsxc_rosteritem[data-bid='"+ streamName + "@conference.webhawksit']").trigger('click'); //Show the chat room window
                    //$(".jsxc_caption").trigger('click'); //expand the chat room window
                    $(".jsxc_bar").trigger('click'); //expand the chat room window*/
                   //jsxc.xmpp.logout(!1);
                   chatLoaded = 1;
                   if(browser=='Safari') {
                       setTimeout(function () {
                           $('#red5pro-subscriber').show();
                           $("#loader").hide('slow');
                           //$("#blur-img").show();
                       }, 2000);
                   }

                });
            });
        });
    }
    if(type == 'Subscribe.Metadata'){
        if(coun==0) {
            //console.log("=======Metadata================================"+Date());
            coun = 1;
            if((browser=='Safari')) {

            } else {

                setTimeout(function () {
                    $('#red5pro-subscriber').show();
                    $("#loader").hide('slow');
                    //$("#blur-img").show();
                }, 2000);
            }
        }
    }

    if(type == 'Subscriber.Play.Unpublish') {
        STATE = Unpublish;
        jsxc.xmpp.logout(!1);
        setTimeout(function () {
            var i = confirm(closemsg);
            stopWatch();
            if (i == true) {
                if(lang=='en') {
                    window.location.href = "streamlist.php";
                } else{
                    window.location.href = "streamlistjp.php";
                }
            }
        }, 5000);
    }


    if((type == 'Subscriber.Connection.Closed') || (type == 'Connect.Failure')) {

        //if(Object.keys(jsxc.CONST.STATE)[jsxc.currentState]!='SUSPEND'){
        if(STATE != Unpublish){
            $('#red5pro-subscriber').hide();
            $("#loader").show();
            //$("#blur-img").show();
            coun=0;
            streamingInitialization();
        }
    }

    if (type == 'Subscribe.InvalidName') {
        STATE = Unpublish;
        if(chatLoaded>=1) {
            jsxc.xmpp.logout(!1);
            setTimeout(function () {
                var i = confirm(closemsg);
                stopWatch();
                if (i == true) {
                    if(lang=='en') {
                        window.location.href = "streamlist.php";
                    } else{
                        window.location.href = "streamlistjp.php";
                    }
                }
            }, 5000);
        } else{
            var i = confirm(closemsg);
            if (i == true) {
                if(lang=='en') {
                    window.location.href = "streamlist.php";
                } else{
                    window.location.href = "streamlistjp.php";
                }
            }
        }
    }

});

viewer.attachSubscriber(subscriber);

streamingInitialization = function() {
    // Initialize
    if (browser == 'Safari') {
        //console.log("Safari HLS======================================="+Date());
        subscriber.init({
            protocol: protocol_hls,
            host: host,
            port: 5080,
            app: 'live',
            streamName: streamName,
            mimeType: 'application/x-mpegURL',
            swf: 'lib/red5pro/red5pro-video-js.swf',
            swfobjectURL: '../../lib/swfobject/swfobject.js',
            productInstallURL: '../../lib/swfobject/playerProductInstall.swf'
        })
            .then(function (player) {
                // `player` has been determined from browser support.
                // Invoke play action
                player.play();
            })
            .catch(function (error) {
                // A fault occurred in finding failover player and playing stream.
                console.error(error);
            });
    } else {
        //console.log("Others WebRTC======================================="+Date());
        subscriber.init({
            protocol: protocol_rtc,
            host: host,
            port: 8081,
            app: 'live',
            streamName: streamName,
            iceServers: iceServers,
            subscriptionId: 'subscriber-' + Math.floor(Math.random() * 0x10000).toString(16),
            bandwidth: {
             audio: 56,
             video: 400,
             data: 30 * 1000 * 1000
             }
        })
            .then(function () {
                // `player` has been determined from browser support.
                // Invoke play action
                return subscriber.play();
            })
            .catch(function (error) {
                // A fault occurred in finding failover player and playing stream.
                console.error(error);
            });
    }
}


streamingInitialization();

/*subscriber
        .setPlaybackOrder(['rtc', 'hls', 'rtmp'])
        .init({
            "rtc": {
                protocol: protocol_rtc,
                host: host,
                port: 8081,
                app: 'live',
                subscriptionId: 'subscriber-' + Math.floor(Math.random() * 0x10000).toString(16),
                streamName: streamName,
                iceServers: iceServers,
                bandwidth: {
                    audio: 56,
                    video: 256,
                    data: 30 * 1000 * 1000
                }
            },
            "hls": {
                protocol: protocol_hls,
                host: host,
                port: 5080,
                app: 'live',
                streamName: streamName,
                mimeType: 'application/x-mpegURL',
                width: 540,
                height: 540,
                swf: 'lib/red5pro/red5pro-video-js.swf',
                swfobjectURL: '../../lib/swfobject/swfobject.js',
                productInstallURL: '../../lib/swfobject/playerProductInstall.swf'
            },
            "rtmp": {
                protocol: protocol_rtmp,
                host: host,
                port: 1935,
                app: 'live',
                streamName: streamName,
                mimeType: 'rtmp/flv',
                useVideoJS: false,
                width: 540,
                height: 540,
                swf: 'lib/red5pro-video-js.swf',
                swfobjectURL: '../../lib/swfobject/swfobject.js',
                productInstallURL: '../../lib/swfobject/playerProductInstall.swf'
            }
        })
        .then(function (player) {
            // `player` has been determined from browser support.
            // Invoke play action
            player.play();
        })
        .then(function () {
            // Playback has initiated successfully.
        })
        .catch(function (error) {
            // A fault occurred in finding failover player and playing stream.
            console.error(error);
        });*/
