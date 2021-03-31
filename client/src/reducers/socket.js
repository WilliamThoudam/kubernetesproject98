import { CONNECT_SOCKET, DISCONNECT_SOCKET } from '../actions/types';

const initialState = {
  isConnected: false,
  loading: true
};

function socketReducer(state = initialState, action) {
  const { type, payload } = action;

  switch (type) {
    case CONNECT_SOCKET:
      return {
        ...state,
        isConnected: true,
        loading: false
      };
    case DISCONNECT_SOCKET:
      return {
        ...state,
        isConnected: false,
        loading: false
      };
    default:
      return state;
  }
}

export default socketReducer;
