var apiObj = null;
var myid = null;
function BindEvent() {
    $("#btnHangup").on('click', function () {
        apiObj.executeCommand('hangup');
    });
    $("#btnCustomMic").on('click', function () {
        apiObj.executeCommand('toggleAudio');
    });
    $("#btnCustomCamera").on('click', function () {
        apiObj.executeCommand('toggleVideo');
    });
    $("#btnCustomTileView").on('click', function () {
        apiObj.executeCommand('toggleTileView');
    });
    $("#btnScreenShareCustom").on('click', function () {
        apiObj.executeCommand('toggleShareScreen');
    });
    $("#btnChat").on('click', function () {
        apiObj.executeCommand('toggleChat');
    });
    $("#btnCustomMuteevoryone").on('click', function () {
        apiObj.executeCommand('muteEveryone');
    });
}
function StartMeeting(roomName, dispNme) {
    $(".connected-video").removeClass("d-none");
    $(".skip-video").addClass("d-none");
    // const domain = 'meet.jit.si';
    const domain = '8x8.vc';
    const options = {
        roomName: roomName,
        width: '100%',
        height: '100%',
        parentNode: document.querySelector('#local-video'),
        DEFAULT_REMOTE_DISPLAY_NAME: 'New User',
        userInfo: {
            displayName: dispNme,
        },
        configOverwrite: {
            doNotStoreRoom: true,
            enableWelcomePage: false,
            prejoinPageEnabled: false,
            disableDeepLinking: true,
            toolbarVisible: false,
            remoteVideoMenu: {
                disableKick: false
            },
            constraints: {
                maxParticipants: 2, // Set the maximum number of participants per room
            },
        },
        localRecording: {
            enabled: false,
            format: 'flac',
        },
        //      },
        interfaceConfigOverwrite: {
            // noSsl: true,
            BRAND_WATERMARK_LINK: '',
            SHOW_JITSI_WATERMARK: false,
            DISABLE_TRANSCRIPTION_SUBTITLES: true,
            HIDE_DEEP_LINKING_LOGO: true,
            SHOW_BRAND_WATERMARK: false,
            VIDEO_QUALITY_LABEL_DISABLED: false,
            SHOW_WATERMARK_FOR_GUESTS: false,
            SHOW_POWERED_BY: false,
            TILE_VIEW_MAX_COLUMNS: 2,
            SHOW_CHROME_EXTENSION_BANNER: false,
            DEFAULT_BACKGROUND: '#fff',
            DISABLE_VIDEO_BACKGROUND: true,
            CHAT_EDIT_MESSAGE_BACKGROUND: "#fff",
            TOOLBAR_BUTTONS: []
        },
        onload: function () {
            $('#joinMsg').hide();
            $('#container').show();
            $('#toolbox').show();
        }
    };
    apiObj = new JitsiMeetExternalAPI(domain, options);
    // apiObj.executeCommand('subject', 'New Room 2');

    apiObj.addEventListeners({
        readyToClose: function () {
            $('#local-video').empty();
            $('#toolbox').hide();
            $('#container').hide();
            $('#joinMsg').show().text('Meeting Ended');
        },
        audioMuteStatusChanged: function (data) {
            if (data.muted) {
                mic = false;
                $("#btnCustomMic").html('<i class="mdi mdi-microphone-off"></i>');
            } else {
                mic = true;
                $("#btnCustomMic").html('<i class="mdi mdi-microphone"></i>');
            }
        },
        videoMuteStatusChanged: function (data) {
            if (data.muted) {
                video = false;
                $("#btnCustomCamera").html('<i class="mdi mdi-video-off"></i>');
            } else {
                video = true;
                $("#btnCustomCamera").html('<i class="mdi mdi-video"></i>');
            }
        },
        tileViewChanged: function (data) {
            console.log("tileViewChanged", data);
        },
        screenSharingStatusChanged: function (data) {
            if (data.on)
                $("#btnScreenShareCustom").html('<i class="mdi mdi-share-off"></i>');
            else
                $("#btnScreenShareCustom").html('<i class="mdi mdi-share"></i>');
        },
        participantJoined: function (data) {
            console.log('participantJoined', data);
            apiObj.executeCommand('toggleTileView');
            change_status();
        },
        participantLeft: function (data) {
            console.log('participantLeft', data);
            skip_query();
        },
        videoConferenceJoined: function (data) {
            console.log("videoConferenceJoined", data);

        }
    });
    // if(video == false) {
    //     if (!apiObj.isVideoMuted()) {
    //         apiObj.executeCommand('toggleVideo');
    //     }
    // }
    // if(mic == false){
    //     if (!apiObj.isAudioMuted()) {
    //         apiObj.executeCommand('toggleAudio');
    //     }
    // }
}
