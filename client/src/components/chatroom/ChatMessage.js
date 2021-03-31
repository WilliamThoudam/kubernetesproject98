import React, { Fragment } from 'react';
import Grid from '@material-ui/core/Grid';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';

const ChatMessage = () => {
  return (
    <Fragment>
      <ListItem key="1">
        <Grid container>
          <Grid item xs={12}>
            <ListItemText primary="Remy Sharp">Remy Sharp</ListItemText>
            <ListItemText
              align="left"
              secondary="Hey, Iam Good! What about you ?"
            ></ListItemText>
          </Grid>
          <Grid item xs={12}>
            <ListItemText align="left" secondary="09:31"></ListItemText>
          </Grid>
        </Grid>
      </ListItem>
    </Fragment>
  );
};

export default ChatMessage;
