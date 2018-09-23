var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.get('/', function(req, res){
  	res.json({welcome:'Hello world'});
});

io.on('connection', function(socket){
	socket.on('on-create', function (res) {
        socket.broadcast.emit('on-create', res);
    });

    socket.on('on-update', function (res) {
        socket.broadcast.emit('on-update', res);
    });

    socket.on('on-confirm', function (res) {
        socket.broadcast.emit('on-confirm', res);
    });

    socket.on('on-confirm-exit', function (res) {
        socket.broadcast.emit('on-confirm-exit', res);
    });

	socket.on('disconnect', function(){
    	console.log('user disconnected');
  	});
});

http.listen(3000, function(){
  	console.log('listening on *:3000');
});