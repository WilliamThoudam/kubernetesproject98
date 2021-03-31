import {
  GET_CHATS_ROOMS,
  ADD_CHATS_ROOM,
  ADD_CHATS_ONLINE_USER,
  DELETE_CHATS_ONLINE_USER,
  CHATS_ERROR
} from '../actions/types';

const initialState = {
  chats_rooms: [],
  online_users: [],
  message: [],
  edit_message: [],
  loading: true,
  error: {}
};

const chatsReducer = (state = initialState, action) => {
  const { type, payload } = action;

  switch (type) {
    case GET_CHATS_ROOMS:
      return {
        ...state,
        chats_rooms: payload,
        loading: false
      };
    case ADD_CHATS_ROOM:
      return {
        ...state,
        chats_rooms: [...state.chats_rooms, payload],
        loading: false
      };
    case ADD_CHATS_ONLINE_USER:
      return {
        ...state,
        online_users: payload,
        loading: false
      };
    case DELETE_CHATS_ONLINE_USER:
      return {
        ...state,
        online_users: state.online_users.filter(
          (online_user) => online_user._id !== payload
        ),
        loading: false
      };
    case CHATS_ERROR:
      return {
        ...state,
        error: payload,
        loading: false
      };
    default:
      return state;
  }
};

export default chatsReducer;
