import api from '../utils/api';
import { setAlert } from './alert';
import {
  GET_CHATS_ROOMS,
  ADD_CHATS_ROOM,
  ADD_CHATS_ONLINE_USER,
  CHATS_ERROR,
  GET_CHATS_ROOM
} from './types';

// Get chats rooms
export const getChatsRooms = () => async (dispatch) => {
  try {
    const res = await api.get('/chats/rooms');
    dispatch({
      type: GET_CHATS_ROOMS,
      payload: res.data
    });
  } catch (err) {
    dispatch({
      type: CHATS_ERROR,
      payload: { msg: err.response.statusText, status: err.response.status }
    });
  }
};

// Add chats room
export const addChatsRoom = (text) => async (dispatch) => {
  try {
    const res = await api.post('/chats/room', { text });
    dispatch({
      type: ADD_CHATS_ROOM,
      payload: res.data
    });
    dispatch(setAlert('Room Created', 'success'));
  } catch (err) {
    dispatch({
      type: CHATS_ERROR,
      payload: { msg: err.response.statusText, status: err.response.status }
    });
    dispatch(setAlert('Name is required', 'danger'));
  }
};

// Get chats room
export const addChatsOnlineUser = () => () => {
  api.post('/chats/user');
};

// Get chats rooms
export const getChatsRoom = (id) => async (dispatch) => {
  try {
    const res = await api.get(`/chats/${id}`);

    dispatch({
      type: GET_CHATS_ROOM,
      payload: res.data
    });
  } catch (err) {
    dispatch({
      type: CHATS_ERROR,
      payload: { msg: err.response.statusText, status: err.response.status }
    });
  }
};
