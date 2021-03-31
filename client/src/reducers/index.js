import { combineReducers } from 'redux';
import alert from './alert';
import auth from './auth';
import profile from './profile';
import post from './post';
import chats from './chats';
import socket from './socket';

export default combineReducers({
  alert,
  auth,
  profile,
  post,
  chats,
  socket
});
