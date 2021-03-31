const express = require('express');
const router = express.Router();
const auth = require('../../middleware/auth');
const { check, validationResult } = require('express-validator');
const Chatsonlineuser = require('../../models/Chatsonlineuser');
const Chatroom = require('../../models/Chatroom');

// @route    GET api/chats/rooms
// @desc     Get a chats rooms
// @access   Private
router.get('/rooms', auth, async (req, res) => {
  //console.log(Chatroom);
  try {
    const ChatRooms = await Chatroom.find()
      .populate('user', ['name', 'avatar'])
      .sort({ createdAt: 1 });
    return res.json(ChatRooms);
  } catch (err) {
    console.error(err.message);
    res.status(500).send('Server Error');
  }
});

// @route    ADD api/chats/room
// @desc     Add a chats room
// @access   Private
router.post(
  '/room',
  auth,
  check('text', 'Text is required').not().isEmpty(),
  async (req, res) => {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }
    try {
      // build a profile
      const name = {
        name: req.body.text
      };

      // Using upsert option (creates new doc if no match is found):
      const newChatRoom = await Chatroom.findOneAndUpdate(
        { user: req.user.id, name: req.body.text },
        { $set: name },
        { new: true, upsert: true, setDefaultsOnInsert: true }
      ).populate('user', ['name', 'avatar']);
      return res.json(newChatRoom);
    } catch (err) {
      console.error(err.message);
      res.status(500).send('Server Error');
    }
  }
);

// @route    POST api/chats/user
// @desc     Add a chats online user
// @access   Private
router.post('/user', auth, async (req, res) => {
  var io = req.app.get('socketio');
  console.log('A user entered chatroom: ' + req.user.id);
  const newUser = {
    user: req.user.id
  };
  // Using upsert option (creates new doc if no match is found):
  await Chatsonlineuser.findOneAndUpdate(
    { user: req.user.id },
    { $set: newUser },
    { new: true, upsert: true, setDefaultsOnInsert: true }
  );
  const OnlineUsers = await Chatsonlineuser.find()
    .populate('user', ['name', 'avatar'])
    .sort({ createdAt: 1 });
  io.emit('addedOnlineUser', OnlineUsers);
});

module.exports = router;
