let rangeInput = document.querySelectorAll(".range-input input");
let rangeText = document.querySelectorAll(".text-range div");
let range = document.querySelector(".progress");
let priceMax = rangeInput[0].max;
let priceGap = 1000;


rangeInput.forEach((input) => {
  input.addEventListener("input", (e) => {
    let minVal = parseInt(rangeInput[0].value),
      maxVal = parseInt(rangeInput[1].value);

    if (maxVal - minVal < priceGap) {
      if (e.target.className === "range-min") {
        minVal = rangeInput[0].value = maxVal - priceGap;
      } else {
        maxVal = rangeInput[1].value = minVal + priceGap;
      }
    }
    range.style.left = (minVal / priceMax) * 100 + "%";
    range.style.right = 100 - (maxVal / priceMax) * 100 + "%";

    rangeText[0].style.left = (minVal / priceMax) * 100 + "%";
    rangeText[1].style.right = 100 - (maxVal / priceMax) * 100 + "%";

    rangeText[0].innerText  = minVal.toLocaleString();
    rangeText[1].innerText  = maxVal.toLocaleString();
  });
});
