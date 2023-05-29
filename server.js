const express = require('express');
const { Socket } = require('socket.io');
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: { origin: "mindful.xiomstudio.com" }
})
io.on('connection', (socket) => {
    console.log("connection");
    socket.on('joinRoom', (room) => {
        socket.join(room);
        console.log(`User joined room ${room}`);
    });

    socket.on('leaveRoom', (room) => {
        socket.leave(room);
        console.log(`User left room ${room}`);
    });
    socket.on("sendChatToServer", (message) => {
        console.log(message);
        io.sockets.to(message.room).emit('sendChatToClient', {
            content: message.content,
            room:message.room,
            senderID: message.sender // where socket.id is the unique ID of the current socket connection
        });
    });

    socket.on('disconnect', (socket) => {
        console.log("Disconnect");
    })
})
server.listen(8000, () => {
    console.log("server is running");
})