/*jshint latedef: nofunc */


$(function () {
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

    // Initialize core functions, intercept login form
    // and attach connection if possible.
    jsxc.init({
        rosterAppend: 'body',
        root: window.location.pathname.replace(/\/[^/]+$/, "/") + (window.location.pathname.match(/dev\.html/) ? '../dev' : '../build'),
        displayRosterMinimized: function () {
            return true;
        },
        loadSettings: function (username, password, cb) {
            cb(settings);
        },
        xmpp: {
            url: settings.xmpp.url,
            resource: settings.xmpp.resource
        }
    });


    //custom jsxc
    //jsxc.xmpp.logout(!1);
    //login to xmpp
    //join(room(jid), nickname (username), password,roomName,subject,bookmark,autojoin)

    jsxc.start(username + '@' + settings.xmpp.domain, password);
    var nameStream = streamName + '@conference.' + settings.xmpp.domain;
    //after connected to jsxc
    $(document).on('connected.jsxc', function () {
        console.log("==============================================connected");
        jsxc.muc.join(nameStream, username, password, streamName, null, null, 1);

        $("#jsxc_roster").hide(); //Hide chatlist window
        $(".jsxc_rosteritem[data-bid='" + streamName + "@conference." + settings.xmpp.domain + "']").trigger('click'); //Show the chat room window
        $(".jsxc_caption").trigger('click'); //expand the chat room window
        $(".jsxc_bar").click(); //expand the chat room window
        //jsxc.gui.window.toggle("nexus@conference.webhawksit");
        //jsxc.gui.window.init("kudduss@conference.webhawksit");
        jQuery.unblockUI();
        chatLoaded = 2;
        startWatch();
    });


    //onMessage
    $(document).on('message.jsxc', function () {
        //console.log("==============================================onMessage");
    });
    //console.log("Message on");

    // helper variable
    //var source = '#form';

    $(document).on('connecting.jsxc', function () {
        //formElements.prop('disabled', true);
       // console.log("===============================================connecting");
    });

    $(document).on('authfail.jsxc', function () {
        //formElements.prop('disabled', false);
        //$(source).find('.alert').show();
        //$(source).find('.submit').button('reset');
        //console.log("===============================================authfail");
    });

    $(document).on('attached.jsxc', function () {
        //formElements.prop('disabled', true);
        // $('.submit').hide();
        // $('form .alert').hide();
        //
        // $('.logout').show().click(jsxc.xmpp.logout);
        //console.log("===============================================attached");
    });

    $(document).on('disconnected.jsxc', function () {

    });

    $(document).on('ready.roster.jsxc', function (){
        //console.log("===============================================ready.roster.jsxc ()");
        jQuery.unblockUI();
    });


});





