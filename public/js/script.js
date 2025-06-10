const canvas = document.getElementById("space-canvas");
const ctx = canvas.getContext("2d");
let w = canvas.width = window.innerWidth;
let h = canvas.height = window.innerHeight;

window.addEventListener('resize', () => {
    w = canvas.width = window.innerWidth;
    h = canvas.height = window.innerHeight;
});

const stars = [];
const shootingStars = [];

for (let i = 0; i < 100; i++) {
    stars.push({
        x: Math.random() * w,
        y: Math.random() * h,
        radius: Math.random() * 1.2,
        alpha: Math.random(),
        speed: Math.random() * 0.2
    });
}

function createShootingStar() {
    shootingStars.push({
        x: Math.random() * w,
        y: Math.random() * h / 2,
        len: Math.random() * 80 + 10,
        speed: Math.random() * 10 + 6,
        angle: Math.PI / 4,
        alpha: 1
    });
}

let shootingStarInterval;

function startShootingStars() {
    shootingStarInterval = setInterval(createShootingStar, 3000);
}

function stopShootingStars() {
    clearInterval(shootingStarInterval);
}

document.addEventListener("visibilitychange", function () {
    if (document.hidden) {
        stopShootingStars();
    } else {
        startShootingStars();
    }
});

startShootingStars();

function draw() {
    ctx.clearRect(0, 0, w, h);


    // ذرات (ستاره‌ها)
    ctx.fillStyle = "rgba(255, 255, 255, 0.8)";
    stars.forEach(star => {
        ctx.beginPath();
        ctx.arc(star.x, star.y, star.radius, 0, Math.PI * 2);
        ctx.fill();
        star.y += star.speed;
        if (star.y > h) star.y = 0;
    });

    // ستاره دنباله‌دار
    shootingStars.forEach((s, i) => {
        ctx.strokeStyle = `rgba(255,255,255,${s.alpha})`;
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(s.x, s.y);
        ctx.lineTo(s.x - s.len * Math.cos(s.angle), s.y - s.len * Math.sin(s.angle));
        ctx.stroke();
        s.x += s.speed * Math.cos(s.angle);
        s.y += s.speed * Math.sin(s.angle);
        s.alpha -= 0.02;
        if (s.alpha <= 0) shootingStars.splice(i, 1);
    });

    requestAnimationFrame(draw);
}

draw();
