const express = require("express");
const { createServer } = require("http");
const { Server } = require("socket.io");
const { jwtDecode } = require('jwt-decode');
const app = express();
const httpServer = createServer(app);
const io = new Server(httpServer, { 
   cors: { 
      origin: "*", 
      methods: ["GET", "POST"] 
   }
 });

io.use((socket, next) => {
  if (socket.handshake.query && socket.handshake.query.token){

    try {
      const decoded = jwtDecode(socket.handshake.query.token);
      console.log("decoded", decoded);
    } 
    catch(err) {
      next(new Error('Authentication error'));
    }
   
   
    next();
  }
  else {
    return next(new Error("invalid token"));
  }   
  
});

io.on("connection", (socket) => {

    socket.on("disconnect", () => {
        console.log("user disconnected");
    });
    socket.on("connected", () => {
      console.log("user connected");
    });

    socket.on("transaction_update", ( data ) => {
        console.log("transaction_changes" + data);
        io.emit("transaction_changes", data);
    });
});

httpServer.listen(6002);