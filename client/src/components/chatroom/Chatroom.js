import React, { Fragment } from 'react';
import { connect, useDispatch, useSelector } from 'react-redux';
import PropTypes from 'prop-types';
import {
  getChatsRooms,
  addChatsRoom,
  addChatsOnlineUser
} from '../../actions/chats';
import { setAlert } from '../../actions/alert';
import { ADD_CHATS_ONLINE_USER } from '../../actions/types';

import { makeStyles } from '@material-ui/core/styles';
import Paper from '@material-ui/core/Paper';
import Grid from '@material-ui/core/Grid';
import Divider from '@material-ui/core/Divider';
import List from '@material-ui/core/List';

import OnlineUser from './OnlineUser';
import ChatForm from './ChatForm';
import ChatMessage from './ChatMessage';

const useStyles = makeStyles({
  table: {
    minWidth: 650
  },
  chatSection: {
    width: '100%',
    height: '80vh'
  },
  headBG: {
    backgroundColor: '#e0e0e0'
  },
  borderRight500: {
    borderRight: '1px solid #e0e0e0'
  },
  borderLeft500: {
    borderLeft: '1px solid #e0e0e0'
  },
  messageArea: {
    height: '70vh',
    overflowY: 'auto'
  }
});
const Chatroom = ({
  getChatsRooms,
  addChatsOnlineUser,
  chats: { online_users }
}) => {
  const classes = useStyles();
  const { text, setText } = React.useState('');
  const chatroomId = 79274923472;
  const [messages, setMessages] = React.useState([]);
  const messageRef = React.useRef();

  const dispatch = useDispatch();
  //const chats = useSelector((state) => state.chats);
  React.useEffect(() => {
    getChatsRooms();
    //addChatsOnlineUser();

    // socket.emit('addOnlineUser');

    // socket.on('addedOnlineUser', (res) => {
    //   const newOnlineUser = res;
    //   dispatch({
    //     type: ADD_CHATS_ONLINE_USER,
    //     payload: newOnlineUser
    //   });
    //   const { length, [length - 1]: last } = res; //should be last
    //   //dispatch(setAlert('Joined user ' + last.user._id, 'success'));
    // });

    // socket.on('removedOnlineUser', (res) => {
    //   dispatch(setAlert('Left user ' + res.user._id, 'danger'));
    // });

    // // socket.on('removedOnlineUser', (res) => {
    // //   const removeOnlineUser = res;
    // //   console.log(removeOnlineUser);
    // //   dispatch({
    // //     type: DELETE_CHATS_ONLINE_USER,
    // //     payload: removeOnlineUser
    // //   });
    // //   dispatch(setAlert('Left user ' + res.user._id, 'danger'));
    // // });

    // return () => {
    //   //Component Unmount
    //   socket.emit('removeOnlineUser');
    // };
    // eslint-disable-next-line
  }, []);

  return (
    <div>
      <Grid container>
        <Grid item xs={12}>
          <h1 className="large text-primary">Rooms</h1>
          <p className="lead">
            <i className="fas fa-user" /> Welcome to the global messaging
          </p>
        </Grid>
      </Grid>
      <Grid container component={Paper} className={classes.chatSection}>
        <Grid item xs={9}>
          <List className={classes.messageArea}>
            <ChatMessage />
          </List>
          <Divider />
          <ChatForm />
        </Grid>
        <Grid item xs={3} className={classes.borderLeft500}>
          <List>
            {online_users.map((online_user) => (
              <OnlineUser key={online_user._id} online_user={online_user} />
            ))}
          </List>
        </Grid>
      </Grid>
    </div>
  );
};

Chatroom.protoType = {
  getChatsRooms: PropTypes.func.isRequired,
  addChatsRoom: PropTypes.func.isRequired,
  addChatsOnlineUser: PropTypes.func.isRequired,
  chats_online_users: PropTypes.object.isRequired,
  chats: PropTypes.object.isRequired
};

const mapStateToProps = (state) => ({
  chats: state.chats
});

export default connect(mapStateToProps, {
  getChatsRooms,
  addChatsRoom,
  addChatsOnlineUser
})(Chatroom);
