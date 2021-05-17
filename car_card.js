async function add_to_basket(id) {
    let response = await fetch("http://localhost/methods/tobasket.php", {
        credentials: "same-origin",
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: ("id=" + id)
    });
}