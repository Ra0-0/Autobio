function loaded(){


    gsap.registerPlugin(ScrollTrigger);

    gsap.to(
      ".svg-attraction-case__svg-attraction_orange-red",
      {
        scrollTrigger:{
          trigger: ".pages-case_scrollT-move",
          start: "top bottom",
          scrub: true,
          toggleActions: "restart pause reverse pause"
      },
      left: "0%",
      rotation: 360,
      zIndex: -1,
      duration: 3,
      transform: "translate(-50%, -100%)"
    });
    gsap.to(
      ".svg-attraction-case__svg-attraction_blue-green",
      {
        scrollTrigger:{
          trigger: ".pages-case_scrollT-move",
          start: "top bottom",
          scrub: true,
          toggleActions: "restart pause reverse pause"
      },
      right: "0%",
      rotation: 360,
      duration: 3,
      transform: "translate(50%, -100%)"
    });

    gsap.to(
      ".svg-attraction-case__svg-attraction_orange-red",
      {
        scrollTrigger:{
          trigger: ".pages-case_scrollT-rotate",
          start: "bottom center",
          scrub: true,
          toggleActions: "restart pause reverse pause"
      },
      rotation: 270,
      duration: 10,
    });
    gsap.to(
      ".svg-attraction-case__svg-attraction_blue-green",
      {
        scrollTrigger:{
          trigger: ".pages-case_scrollT-rotate",
          start: "bottom center",
          scrub: true,
          toggleActions: "restart pause reverse pause"
      },
      rotation: 270,
      duration: 10,
    });

  }
