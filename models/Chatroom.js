const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const ChatroomSchema = mongoose.Schema(
  {
    name: {
      type: String
    },
    user: {
      type: Schema.Types.ObjectId,
      ref: 'user'
    },
    messages: [
      {
        text: {
          type: String
        },
        user: {
          type: Schema.Types.ObjectId,
          ref: 'user'
        },
        createdAt: {
          type: Date,
          default: Date.now
        },
        updatedAt: {
          type: Date,
          default: Date.now
        }
      }
    ]
  },
  { timestamps: true }
);

const Chatroom = mongoose.model('Chatroom', ChatroomSchema);
module.exports = Chatroom;
