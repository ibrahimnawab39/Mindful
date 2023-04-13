<!DOCTYPE html>
<html>
  <head>
    <title>Jitsi Meet Example</title>
  </head>
  <body>
    <div id="jitsi-container">
      <div id="localVideoContainer"></div>
      <div id="remoteVideoContainer1"></div>
      <div id="remoteVideoContainer2"></div>
    </div>
    <script src="https://meet.jit.si/external_api.js"></script>
    <script>
      const domain = 'meet.jit.si'; // or your own Jitsi Meet domain
      const options = {
        roomName: 'new roowm', // the name of the Jitsi Meet room
        width: '100%',
        height: '100%',
        parentNode: document.querySelector('#jitsi-container'),
        userInfo: {
          displayName: 'Your Name' // your display name
        }
      };
      const api = new JitsiMeetExternalAPI(domain, options);
      api.addEventListener('videoConferenceJoined', () => {
        api.executeCommand('displayName', 'Your Name');
        api.executeCommand('subject', 'Your Room Subject');
      });
      api.addEventListener('participantJoined', (participant) => {
        // create video element for the new participant
        const videoElement = document.createElement('video');
        videoElement.autoplay = true;
        videoElement.muted = true;
        // add the new video element to the page
        if (participant.id === api.getMyUserId()) {
          // local participant
          document.querySelector('#localVideoContainer').appendChild(videoElement);
        } else if (document.querySelector('#remoteVideoContainer1 video') == null) {
          // first remote participant
          document.querySelector('#remoteVideoContainer1').appendChild(videoElement);
        } else {
          // second remote participant
          document.querySelector('#remoteVideoContainer2').appendChild(videoElement);
        }
        // set the remote video stream for the new participant
        api.setVideoParticipant(participant.id, videoElement);
      });
    </script>
  </body>
</html>
