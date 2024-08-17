document.addEventListener("DOMContentLoaded", function () {
  const toggleButtons = document.querySelectorAll(".u-accordion-btn");

  toggleButtons.forEach(function (button) {
      button.addEventListener("click", function () {
          const contentId = "accordionContent" + this.id.replace("toggleBtn", "");
          const accordionContent = document.getElementById(contentId);
          const plusIcon = this.querySelector(".plus-icon");

          if (accordionContent.style.display === "none" || accordionContent.style.display === "") {
              accordionContent.style.display = "block";
              plusIcon.textContent = "-";
          } else {
              accordionContent.style.display = "none";
              plusIcon.textContent = "+";
          }
      });
  });
});
