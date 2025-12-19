import React from "react";
import { makeStyles, createStyles } from "@material-ui/core/styles";
import Button from "@material-ui/core/Button";
const useStyles = makeStyles((theme) =>
  createStyles({
    root: {
      background: "#2979ff",
      padding: "1rem",
      color: "white",
      textTransform: "none",
      fontWeight: "bold",
      fontFamily: "Gilroy, sans-serif",
      "&:hover": {
        background: "#1565c0",
      },
    },
  })
);
export default function contactButton() {
  const classes = useStyles();
  return <Button className={classes.root}>Get In Touch</Button>;
}
