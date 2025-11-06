// 🌸 Floating Flower Animation
document.addEventListener("DOMContentLoaded", () => {
  const floralBackground = document.querySelector(".floral-background");
  const colors = ["#ffb6c1", "#ffc0cb", "#ff69b4", "#ff1493", "#ff4d6d", "#f78da7","#fbcce7"];

  function createFlower() {
    const flower = document.createElement("div");
    flower.classList.add("flower");
    flower.style.background = colors[Math.floor(Math.random() * colors.length)];

    // Random horizontal position
    flower.style.left = Math.random() * 100 + "vw";

    // Random animation duration (speed)
    flower.style.animationDuration = 10 + Math.random() * 10 + "s";

    floralBackground.appendChild(flower);

    // Remove the flower when animation ends
    setTimeout(() => {
      flower.remove();
    }, 20000);
  }

  // Create new flowers at intervals
  setInterval(createFlower, 800);
});
// 😊 Smiley popup after upload
function showSmiley() {
  const smiley = document.createElement("div");
  smiley.textContent = "😊";
  smiley.style.position = "fixed";
  smiley.style.bottom = "50px";
  smiley.style.left = "50%";
  smiley.style.transform = "translateX(-50%)";
  smiley.style.fontSize = "2.5rem";
  smiley.style.opacity = "1";
  smiley.style.transition = "all 1.5s ease-out";
  document.body.appendChild(smiley);

  setTimeout(() => {
    smiley.style.opacity = "0";
    smiley.style.transform = "translateX(-50%) translateY(-100px)";
  }, 500);

  setTimeout(() => smiley.remove(), 2000);
}

// Run when upload button clicked
const uploadBtn = document.getElementById("uploadPhotoBtn");
if (uploadBtn) {
  uploadBtn.addEventListener("click", () => {
    setTimeout(showSmiley, 800); // delay for fun effect
});
}
// 😄 Emoji popup after successful memory upload
function showEmojiPopup() {
  const popup = document.getElementById("emoji-popup");
  if (!popup) return;

  const emojis = ["😊", "🥰", "💜", "🌸", "😄", "💫"];
  popup.textContent = emojis[Math.floor(Math.random() * emojis.length)];
  popup.classList.add("show");

  setTimeout(() => {
    popup.classList.remove("show");
},2000);
}
// 💖 Heart popup for Confession
function showHeartPopup(name) {
  const heart = document.createElement("div");
  heart.classList.add("heart");
  heart.textContent = "💖 " + name;
  heart.style.left = Math.random() * 100 + "vw";
  heart.style.bottom = "10px";
  document.body.appendChild(heart);

  setTimeout(() => heart.remove(),4000);
}