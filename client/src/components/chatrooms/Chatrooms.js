import React, { Fragment, useState, useEffect } from 'react';
import { connect } from 'react-redux';
import { useDispatch, useSelector } from 'react-redux';
import PropTypes from 'prop-types';
import { getChatsRooms, addChatsRoom } from '../../actions/chats';
import { connectSocket } from '../../actions/socket';

import { makeStyles } from '@material-ui/core/styles';
import Paper from '@material-ui/core/Paper';
import Grid from '@material-ui/core/Grid';
import Divider from '@material-ui/core/Divider';
import TextField from '@material-ui/core/TextField';
import List from '@material-ui/core/List';

//import OnlineUser from './OnlineUser';
import Room from './Room';

let socket;
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
const Chatrooms = ({
  getChatsRooms,
  addChatsRoom,
  chats: { chats_rooms },
  connectSocket,
  socket: { isConnected }
}) => {
  const classes = useStyles();
  const [text, setText] = useState('');

  useEffect(() => {
    if (!isConnected) socket = connectSocket();
    getChatsRooms();
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
        <Grid item xs={12} className={classes.borderRight500}>
          <Grid item xs={12} style={{ padding: '10px' }}>
            <TextField
              label="Create Room"
              variant="outlined"
              fullWidth
              onChange={(e) => setText(e.target.value)}
              value={text}
              onKeyPress={(e) => {
                if (e.key === 'Enter') {
                  addChatsRoom(e.target.value);
                  setText('');
                }
              }}
            />
          </Grid>
          <Divider />
          <List>
            {chats_rooms.map((chats_room) => (
              <Room
                key={chats_room._id}
                chats_room={chats_room}
                socket={socket}
              />
            ))}
          </List>
        </Grid>
      </Grid>
    </div>
  );
};

Chatrooms.protoType = {
  getChatsRooms: PropTypes.func.isRequired,
  addChatsRoom: PropTypes.func.isRequired,
  chats: PropTypes.object.isRequired,
  connectSocket: PropTypes.object.isRequired,
  socket: PropTypes.object.isRequired
};

const mapStateToProps = (state) => ({
  chats: state.chats,
  socket: state.socket
});

export default connect(mapStateToProps, {
  getChatsRooms,
  addChatsRoom,
  connectSocket
})(Chatrooms);
