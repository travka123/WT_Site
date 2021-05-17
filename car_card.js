async function add_to_backet(id) {
        let respnse = await fetch("http://localhost/methods/tobasket.php", {
        credentials: "same-origin",
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: ("id=" + id)
    });
    if (respnse.status == 401) {
        alert("Вы должны быть авторизованы");
    }
}