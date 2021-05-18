async function checkout() {
    email = prompt("Введите email для обратной связи", "email");
    let response = await fetch("http://localhost/methods/checkout.php", {
        credentials: "same-origin",
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: ("email=" + email)
    });

    if (response.status != 200) {
        alert("Не удалось оформить заказ");
    }
    else {
        let els = document.getElementsByClassName("card-btn-add");
        while (els.length > 0) {
            els[0].click();
        }
    }
}