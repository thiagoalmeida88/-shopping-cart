var tl = new TimelineMax({repeat:30, repeatDelay:1});

var tl2 = new TimelineMax({repeat:30, repeatDelay:1});

var tl3 = new TimelineMax({repeat:30, repeatDelay:0});

TweenMax.set('.circle', {
	transformOrigin: 'center center'
});


tl.to("#circle-inner", 2, {rotation:300})
	.to("#circle-inner", 1, {rotation:300})
	.to("#circle-inner", 0.6, { scale:1.07, ease: Back.easeInOut, delay: 0, yoyo: true})
  .to("#circle-inner", 0.5, { scale:1, ease: Back.easeInOut, delay: 0, yoyo: true})
	.to("#circle-inner", 1.1, {rotation:300})
	.to("#circle-inner", 1.1, {rotation:300})
	.to("#circle-inner", 4, {rotation:0})

tl2.to("#circle-midlle", 2, {rotation:180})
	.to("#circle-midlle", 1, {rotation:180})
	.to("#circle-midlle", 1.1, {rotation:180})
	.to("#circle-midlle", 0.6, { scale:1.07, ease: Back.easeInOut, delay: 0, yoyo: true})
  .to("#circle-midlle", 0.5, { scale:1, ease: Back.easeInOut, delay: 0, yoyo: true})
	.to("#circle-midlle", 1.1, {rotation:180})
	.to("#circle-midlle", 4, {rotation:0})

tl3.to("#circle-outer", 3, {rotation:90})
	.to("#circle-outer", 1.1, {rotation:90})
	.to("#circle-outer", 1.1, {rotation:90})
	.to("#circle-outer", 0.6, { scale:1.07, ease: Back.easeInOut, delay: 0, yoyo: true})
  .to("#circle-outer", 0.5, { scale:1, ease: Back.easeInOut, delay: 0, yoyo: true})
	.to("#circle-outer", 4, {rotation:0})
