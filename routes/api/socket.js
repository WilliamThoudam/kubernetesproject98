const jwt = require('jsonwebtoken');
const config = require('config');
const Chatsonlineuser = require('../../models/Chatsonlineuser');

const socket = async (server, app) => {
  const io = require('socket.io')(server);

  // Set global socket to enable use other route also
  app.set('socketio', io);

  io.use((socket, next) => {
    const token = socket.handshake.query.token;

    // Check if not token
    if (!token) {
      console.error('No token, authorization denied');
    }

    // Verify token
    try {
      jwt.verify(token, config.get('jwtSecret'), (error, decoded) => {
        if (error) {
          console.error('Token is not valid');
        } else {
          socket.user = decoded.user;
          next();
        }
      });
    } catch (err) {
      console.error('something wrong with auth middleware');
    }
  });
  io.on('connection', (socket) => {
    const { id } = socket.user;
    console.log('Connected user ' + id);
    socket.on('disconnect', () => {
      console.log('Disconnected user ' + id);
    });

    socket.on('addOnlineUser', async () => {
      console.log('A user entered chatroom: ' + id);
      const newUser = {
        user: id
      };
      // Using upsert option (creates new doc if no match is found):
      await Chatsonlineuser.findOneAndUpdate(
        { user: id },
        { $set: newUser },
        { new: true, upsert: true, setDefaultsOnInsert: true }
      );
      const OnlineUsers = await Chatsonlineuser.find()
        .populate('user', ['name', 'avatar'])
        .sort({ createdAt: 1 });
      io.emit('addedOnlineUser', OnlineUsers);
    });

    socket.on('removeOnlineUser', async () => {
      console.log('A user left chatroom: ' + id);
      const removeOnlineUser = await Chatsonlineuser.findOneAndRemove({
        user: id
      }).populate('user', ['name', 'avatar']);
      io.emit('removedOnlineUser', removeOnlineUser);
    });

    socket.on('joinRoom', ({ chatroomId }) => {
      socket.join(chatroomId);
      console.log('A user joined chatroom: ' + chatroomId);
    });

    socket.on('leaveRoom', ({ chatroomId }) => {
      socket.leave(chatroomId);
      console.log('A user left chatroom: ' + chatroomId);
    });

    socket.on('chatroomMessage', async ({ chatroomId, message }) => {
      if (message.trim().length > 0) {
        const user = await User.findOne({ _id: id });
        const newMessage = new Message({
          chatroom: chatroomId,
          user: id,
          message
        });
        io.to(chatroomId).emit('newMessage', {
          message,
          name: user.name,
          userId: id
        });
        await newMessage.save();
      }
    });
  });
};

module.exports = socket;
