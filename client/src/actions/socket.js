import { setAlert } from './alert';
import { CONNECT_SOCKET, DISCONNECT_SOCKET } from './types';
import io from 'socket.io-client';

export const connectSocket = () => (dispatch) => {
  const newSocket = io('http://localhost:5000', {
    //path: '/socket.io',
    'force new connection': true,
    reconnection: true,
    reconnectionAttempts: 'Infinity',
    timeout: 10000,
    transports: ['websocket'],
    agent: false,
    upgrade: false,
    rejectUnauthorized: false,
    secure: false,
    query: {
      token: localStorage.token
    }
  });

  newSocket.on('connect', () => {
    //console.log('Socket Connected!');
    dispatch({
      type: CONNECT_SOCKET
    });
    dispatch(setAlert('Socket Connected', 'success'));
    newSocket.emit('addOnlineUser');
  });

  newSocket.on('disconnect', () => {
    //console.log('Socket Disconnected!');
    dispatch({
      type: DISCONNECT_SOCKET
    });
    dispatch(setAlert('Socket Disconnected', 'danger'));
    setTimeout(connectSocket(), 3000);
  });
  return newSocket;
};

//export default newSocket - I am using arrow function and return socket instead of const newsocket export because I want to use dispatch inside here
