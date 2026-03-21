document.querySelectorAll(".faq-item").forEach((item) => {
  item.addEventListener("click", () => {
    let ans = item.querySelector(".faq-answer");
    ans.style.display = ans.style.display === "block" ? "none" : "block";
  });
});
// typing
let text = "Your Notes, But Better";
let i = 0;
function type() {
  if (i < text.length) {
    document.querySelector(".typing").innerHTML += text.charAt(i);
    i++;
    setTimeout(type, 40);
  }
}
type();
document.querySelectorAll(".faq-question").forEach((btn) => {
  btn.addEventListener("click", () => {
    let item = btn.parentElement;
    // close others
    document.querySelectorAll(".faq-item").forEach((i) => {
      if (i !== item) {
        i.classList.remove("active");
      }
    });
    // toggle current
    item.classList.toggle("active");
  });
});