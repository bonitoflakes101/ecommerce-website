function goToCheckout() {
    console.log("I am clicked");
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "index.php";

    const inputCheckout = document.createElement("input");
    inputCheckout.type = "hidden";
    inputCheckout.name = "btnCheckoutClicked";
    inputCheckout.value = 1;

    form.appendChild(inputCheckout);
    document.body.appendChild(form);
    form.submit();
  }