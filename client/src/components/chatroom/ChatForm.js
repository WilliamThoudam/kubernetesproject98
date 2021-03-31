import React, { Fragment } from 'react';
import Fab from '@material-ui/core/Fab';
import SendIcon from '@material-ui/icons/Send';
import Grid from '@material-ui/core/Grid';
import TextField from '@material-ui/core/TextField';

const ChatForm = () => {
  return (
    <Fragment>
      <Grid container style={{ padding: '20px' }}>
        <Grid item xs={11}>
          <TextField
            id="outlined-basic-email"
            label="Type Something"
            fullWidth
          />
        </Grid>
        <Grid xs={1} align="right">
          <Fab color="primary" aria-label="add">
            <SendIcon />
          </Fab>
        </Grid>
      </Grid>
    </Fragment>
  );
};

export default ChatForm;
