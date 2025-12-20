import React from "react";
import Navbar from "./navbar";
import Footer from "./footer";
import ScrollAnimations from "./ScrollAnimations";

const layout = ({ children, solidNav, whiteLogo }) => {
  return (
    <React.Fragment>
      <ScrollAnimations />
      <Navbar solidNav={solidNav} whiteLogo={whiteLogo} />
      <main>{children}</main>
      <Footer />
    </React.Fragment>
  );
};

export default layout;
