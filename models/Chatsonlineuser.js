const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const ChatsonlineuserSchema = mongoose.Schema(
  {
    user: {
      type: Schema.Types.ObjectId,
      ref: 'user'
    }
  },
  { timestamps: true }
);

const Chatsonlineuser = mongoose.model(
  'chatsonlineuser',
  ChatsonlineuserSchema
);

module.exports = Chatsonlineuser;
