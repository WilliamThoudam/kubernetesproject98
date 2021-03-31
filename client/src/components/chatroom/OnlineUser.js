import React, { Fragment } from 'react';
import PropTypes from 'prop-types';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import Avatar from '@material-ui/core/Avatar';
import ListItemText from '@material-ui/core/ListItemText';
import formatDate from '../../utils/formatDate';
import { Link } from 'react-router-dom';

const OnlineUser = ({ online_user: { user, createdAt } }) => {
  const { _id, name, avatar } = user;
  return (
    <Fragment>
      {
        <Link to={`/profile/${_id}`}>
          <ListItem button key={_id}>
            <ListItemIcon>
              <Avatar alt={name} src={avatar} />
            </ListItemIcon>
            <ListItemText primary={name}></ListItemText>
            <ListItemText secondary="online" align="right"></ListItemText>
          </ListItem>
        </Link>
      }
    </Fragment>
  );
};

OnlineUser.propTypes = { online_user: PropTypes.object.isRequired };

export default OnlineUser;
