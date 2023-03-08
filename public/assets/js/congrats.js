var csrf    = '';

// meta url
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }
}

$(function() {
	var numberOfStars = 200;

	for (var i = 0; i < numberOfStars; i++) {
	  $('.congrats').append('<div class="blob fa fa-star ' + i + '"></div>');
	}

	animateText();

	animateBlobs();
});

$('.congrats').click(function() {
	reset();

	animateText();

	animateBlobs();
});

function reset() {
	$.each($('.blob'), function(i) {
		TweenMax.set($(this), { x: 0, y: 0, opacity: 1 });
	});

	TweenMax.set($('h1'), { scale: 1, opacity: 1, rotation: 0 });
}

function animateText() {
		TweenMax.from($('h1'), 0.8, {
		scale: 0.4,
		opacity: 0,
		rotation: 15,
		ease: Back.easeOut.config(4),
	});
}

function animateBlobs() {

	var xSeed = _.random(350, 380);
	var ySeed = _.random(120, 170);

	$.each($('.blob'), function(i) {
		var $blob = $(this);
		var speed = _.random(1, 5);
		var rotation = _.random(5, 100);
		var scale = _.random(0.8, 1.5);
		var x = _.random(-xSeed, xSeed);
		var y = _.random(-ySeed, ySeed);

		TweenMax.to($blob, speed, {
			x: x,
			y: y,
			ease: Power1.easeOut,
			opacity: 0,
			rotation: rotation,
			scale: scale,
			onStartParams: [$blob],
			onStart: function($element) {
				$element.css('display', 'block');
			},
			onCompleteParams: [$blob],
			onComplete: function($element) {
				$element.css('display', 'none');
			}
		});
	});
}


tsParticles.load("tsparticles", {
    fpsLimit: 60,
    particles: {
        number: {
        value: 0
        },
        color: {
        value: ["#00FFFC", "#FC00FF", "#fffc00"]
        },
        shape: {
        type: "confetti",
        options: {
            confetti: {
            type: ["circle", "square"]
            }
        }
        },
        opacity: {
        value: 1,
        animation: {
            enable: true,
            minimumValue: 0,
            speed: 2,
            startValue: "max",
            destroy: "min"
        }
        },
        size: {
        value: 7,
        random: {
            enable: true,
            minimumValue: 3
        }
        },
        links: {
        enable: false
        },
        life: {
        duration: {
            sync: true,
            value: 5
        },
        count: 1
        },
        move: {
        enable: true,
        gravity: {
            enable: true,
            acceleration: 20
        },
        speed: 20,
        decay: 0.1,
        direction: "none",
        random: false,
        straight: false,
        outModes: {
            default: "destroy",
            top: "none"
        }
        }
    },
    interactivity: {
        detectsOn: "window",
        events: {
        resize: true
        }
    },
    detectRetina: true,
    emitters: {
        direction: "none",
        life: {
        count: 0,
        duration: 0.1,
        delay: 0.4
        },
        rate: {
        delay: 0.1,
        quantity: 100
        },
        size: {
        width: 0,
        height: 0
        }
    }
});
