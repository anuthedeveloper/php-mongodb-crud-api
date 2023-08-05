const coffees = document.querySelector(".coffees");
const msg = document.querySelector("#message");

const showCoffees = async () => {
  let output = "";
  const response = await fetch(
    "http://localhost/test-projects/php-mongodb-project/api/product.php"
  );
  const json = await response.json();
  // console.log(json.data);
  json.data.forEach(
    ({ name, image }) =>
      (output += `
              <div class="card">
                <img class="card--avatar" src=${image} loading="lazy" />
                <h1 class="card--title">${name}</h1>
                <a class="card--link" href="?cf=${name}">Taste</a>
              </div>
              `)
  );
  if (coffees) coffees.innerHTML = output;
};

document.addEventListener("DOMContentLoaded", showCoffees);

let input = document.querySelector("input[type=file]");
let imageName = document.querySelector(".imagename");

if (input) {
  input.addEventListener("change", () => {
    let inputImage = document.querySelector("input[type=file]").files[0];

    imageName.innerText = inputImage.name;
  });
}

const form = document.querySelector("form");
if (form) {
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const submitBtn = document.querySelector('button[name="submit"]');
    const defualtBtn = submitBtn.innerText;
    submitBtn.innerText = "Please wait...";
    try {
      const formdata = new FormData(form);
      formdata.append("image", `images/${imageName.innerText}`);
      const fd = JSON.stringify(Object.fromEntries(formdata.entries()));
      const response = await fetch(
        "http://localhost/test-projects/php-mongodb-project/api/product.php",
        {
          method: "post",
          body: fd,
          headers: { "Content-Type": "application/json" },
        }
      );
      const json = await response.json();
      if (json?.status !== "success") throw new Error(json.message);
      msg.innerText = json.message;
      msg.style.color = "green";
      submitBtn.innerText = defualtBtn;
      submitBtn.disabled = false;
      form.reset();
    } catch (error) {
      // console.log(error);
      msg.innerText = error.message;
      msg.style.color = "red";
      submitBtn.innerText = defualtBtn;
      submitBtn.disabled = false;
    }
  });
}

if ("serviceWorker" in navigator) {
  window.addEventListener("load", function () {
    navigator.serviceWorker
      .register("serviceWorker.js")
      .then((res) => console.log("service worker registered"))
      .catch((err) => console.log("service worker not registered", err));
  });
}
