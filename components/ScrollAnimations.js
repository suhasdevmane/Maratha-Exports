import React, { useEffect, useState } from "react";
import { makeStyles } from "@material-ui/core/styles";
import FlightIcon from "@material-ui/icons/Flight";
import DirectionsBoatIcon from "@material-ui/icons/DirectionsBoat";

const useStyles = makeStyles((theme) => ({
  root: {
    position: "fixed",
    top: 0,
    left: 0,
    width: "100%",
    height: "100%",
    pointerEvents: "none",
    zIndex: 9999,
    overflow: "hidden",
  },
  flightWrapper: {
    position: "absolute",
    top: "15%",
    left: "-5vw", // Start slightly off-screen
    willChange: "transform",
    transition: "transform 0.1s linear", // Smooth scroll tracking
  },
  boatWrapper: {
    position: "absolute",
    bottom: "5%",
    left: "-5vw",
    willChange: "transform",
    transition: "transform 0.1s linear",
  },
  flightIcon: {
    fontSize: "3rem",
    color: "#2979ff",
    transform: "rotate(90deg)",
    filter: "drop-shadow(0px 10px 10px rgba(0,0,0,0.2))",
    animation: "$soar 3s ease-in-out infinite",
  },
  boatIcon: {
    fontSize: "3rem",
    color: "#F8BB86",
    filter: "drop-shadow(0px 10px 10px rgba(0,0,0,0.2))",
    animation: "$bob 3s ease-in-out infinite",
  },
  "@keyframes soar": {
    "0%, 100%": { transform: "rotate(90deg) translateY(0)" },
    "50%": { transform: "rotate(90deg) translateY(-10px)" },
  },
  "@keyframes bob": {
    "0%, 100%": { transform: "translateY(0) rotate(0deg)" },
    "50%": { transform: "translateY(-5px) rotate(2deg)" },
  },
  // Initial entrance animations
  entranceFlight: {
    animation: "$flyIn 1.5s ease-out forwards",
  },
  entranceBoat: {
    animation: "$sailIn 2s ease-out forwards",
  },
  "@keyframes flyIn": {
    "0%": { opacity: 0, transform: "translateX(-100px)" },
    "100%": { opacity: 1, transform: "translateX(0)" },
  },
  "@keyframes sailIn": {
    "0%": { opacity: 0, transform: "translateX(-50px)" },
    "100%": { opacity: 1, transform: "translateX(0)" },
  },
}));

export default function ScrollAnimations() {
  const classes = useStyles();
  const [scrollProgress, setScrollProgress] = useState(0);
  const [mounted, setMounted] = useState(false);

  useEffect(() => {
    setMounted(true);
    const handleScroll = () => {
      const totalScroll = document.documentElement.scrollTop || document.body.scrollTop;
      const windowHeight =
        document.documentElement.scrollHeight -
        document.documentElement.clientHeight;
      
      if (windowHeight > 0) {
        setScrollProgress(totalScroll / windowHeight);
      }
    };

    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  if (!mounted) return null;

  return (
    <div className={classes.root}>
      {/* Flight moves faster (110vw range) */}
      <div
        className={`${classes.flightWrapper} ${classes.entranceFlight}`}
        style={{
          transform: `translateX(${scrollProgress * 110}vw)`,
        }}
      >
        <FlightIcon className={classes.flightIcon} />
      </div>

      {/* Boat moves slower (80vw range) */}
      <div
        className={`${classes.boatWrapper} ${classes.entranceBoat}`}
        style={{
          transform: `translateX(${scrollProgress * 80}vw)`,
        }}
      >
        <DirectionsBoatIcon className={classes.boatIcon} />
      </div>
    </div>
  );
}
