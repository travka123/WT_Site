async function remove_from_backet(order_id, rem_id) {
        fetch("http://localhost/methods/remove_from_backet.php", {
        credentials: "same-origin",
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: ("id=" + order_id)
    });
    document.getElementById(rem_id).remove();
}