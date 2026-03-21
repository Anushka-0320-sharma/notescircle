function toggleSidebar() {
  document.getElementById("sidebar").classList.toggle("active");
}
// Simple password match validation
document.querySelector("form").addEventListener("submit", function (e) {
  let pass = document.querySelector('input[name="password"]').value;
  let confirm = document.querySelector('input[name="confirm_password"]').value;
  if (pass !== confirm) {
    alert("Passwords do not match!");
    e.preventDefault();
  }
});
