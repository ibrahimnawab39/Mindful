<!DOCTYPE html>
<html>
<head>
    <title>Video Call Demo</title>
</head>
<body>
    <div>
        <h1>Video Call Demo</h1>
        <video id="localVideo" autoplay muted></video>
        <video id="remoteVideo" autoplay></video>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/web-socket-js/1.0.0/web_socket.min.js"></script>
    <script>
        const configuration = { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }] };
        const peerConnection = new RTCPeerConnection(configuration);
        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then(stream => {
                const localVideo = document.querySelector('#localVideo');
                localVideo.srcObject = stream;
                stream.getTracks().forEach(track => peerConnection.addTrack(track, stream));
            })
            .catch(error => console.log(error));
        peerConnection.ontrack = event => {
            const remoteVideo = document.querySelector('#remoteVideo');
            remoteVideo.srcObject = event.streams[0];
        };
        peerConnection.createOffer()
            .then(offer => peerConnection.setLocalDescription(offer))
            .then(() => {
                // Send the offer to the random person using a signaling server
            })
            .catch(error => console.log(error));
        const ws = new WebSocket('wss://mindful.xiomstudio.com');

        ws.addEventListener('open', () => {
          console.log('Connected to signaling server');
        });
        
        ws.addEventListener('message', event => {
          const data = JSON.parse(event.data);
          handleSignalingMessage(data);
        });
        
        function sendSignalingMessage(data) {
          ws.send(JSON.stringify(data));
        }
        
        function handleSignalingMessage(data) {
          switch (data.type) {
            case 'user-id':
              handleUserIdMessage(data);
              break;
            case 'offer':
              handleOfferMessage(data);
              break;
            case 'answer':
              handleAnswerMessage(data);
              break;
            case 'ice-candidate':
              handleIceCandidateMessage(data);
              break;
            default:
              console.error('Unknown signaling message type:', data.type);
          }
        }

        // const userId = Math.random().toString(36).substr(2, 9);
        // signalingServer.send({ type: 'user-id', userId });
        // signalingServer.on('user-connected', async remoteUserId => {
        //     const offer = await peerConnection.createOffer();
        //     await peerConnection.setLocalDescription(new RTCSessionDescription(offer));
        //     signalingServer.send({
        //         type: 'offer',
        //         offer,
        //         from: userId,
        //         to: remoteUserId,
        //     });
        // });
        // signalingServer.on('offer', async ({ offer, from }) => {
        //     const remotePeerConnection = new RTCPeerConnection();
        //     remotePeerConnection.ontrack = handleRemoteTrackEvent;
        //     remotePeerConnection.onicecandidate = event => {
        //         if (event.candidate) {
        //             signalingServer.send({
        //                 type: 'ice-candidate',
        //                 candidate: event.candidate,
        //                 from: userId,
        //                 to: from,
        //             });
        //         }
        //     };
        //     await remotePeerConnection.setRemoteDescription(new RTCSessionDescription(offer));
        //     const answer = await remotePeerConnection.createAnswer();
        //     await remotePeerConnection.setLocalDescription(new RTCSessionDescription(answer));
        //     signalingServer.send({
        //         type: 'answer',
        //         answer,
        //         from: userId,
        //         to: from,
        //     });
        // });
        // signalingServer.on('answer', async ({ answer, from }) => {
        //     const remotePeerConnection = getRemotePeerConnectionForUser(from);
        //     await remotePeerConnection.setRemoteDescription(new RTCSessionDescription(answer));
        // });
        // signalingServer.on('ice-candidate', async ({ candidate, from }) => {
        //     const remotePeerConnection = getRemotePeerConnectionForUser(from);
        //     await remotePeerConnection.addIceCandidate(new RTCIceCandidate(candidate));
        // });
        // peerConnection.onicecandidate = event => {
        //     if (event.candidate) {
        //         signalingServer.send({
        //             type: 'ice-candidate',
        //             candidate: event.candidate,
        //             from: userId,
        //             to: remoteUserId,
        //         });
        //     }
        // };
        // signalingServer.on('ice-candidate', async ({ candidate, from }) => {
        //     await peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
        // });
        // function handleRemoteTrackEvent(event) {
        //      const remoteVideo = document.querySelector('#remoteVideo');
        //     remoteVideo.srcObject = event.streams[0];
        //     remoteVideo.autoplay = true;
        // }
    </script>
</body>
</html>