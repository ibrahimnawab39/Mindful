const express = require('express');
const { Socket } = require('socket.io');
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: { origin: "*" }
})
io.on('connection', (socket) => {
    console.log("connection");
    socket.on("sendChatToServer", (message) => {
        console.log(message);
        io.sockets.emit('sendChatToClient', {
            content: message.content,
            senderID: message.sender // where socket.id is the unique ID of the current socket connection
        });
    });

    socket.on('disconnect', (socket) => {
        console.log("Disconnect");
    })
})
server.listen(3000, () => {
    console.log("server is running");
})