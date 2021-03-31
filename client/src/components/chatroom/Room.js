import React, { Fragment } from 'react';
import PropTypes from 'prop-types';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import formatDate from '../../utils/formatDate';
import { Link } from 'react-router-dom';
import Button from '@material-ui/core/Button';

import { makeStyles } from '@material-ui/core/styles';

const useStyles = makeStyles((theme) => ({
  button: {
    margin: theme.spacing(1)
  }
}));

const Room = ({ chats_room: { _id, name, user, createdAt } }) => {
  const classes = useStyles();
  const { _id: user_id, avatar } = user;
  return (
    <Fragment>
      {
        <Link to={`/chatrooms/${_id}`}>
          <ListItem button key={_id}>
            <ListItemText primary={name}></ListItemText>
            <Button
              variant="contained"
              color="default"
              size="small"
              className={classes.button}
            >
              Join
            </Button>
          </ListItem>
        </Link>
      }
    </Fragment>
  );
};

Room.propTypes = { chats_room: PropTypes.object.isRequired };

export default Room;
