async function logout() {
    await fetch('http://localhost/methods/logout.php', 
        {credentials: 'same-origin', 
        method: 'POST'});
    document.getElementById("logout").remove();
    let elem = document.getElementById("backet-link");
    elem.textContent = "Войти";
    elem.setAttribute("href", "login.php");
    let response = await fetch(document.URL);
    console.log(response);
    if (response.status != 200) {
        window.location = "http://localhost/index.php";
    }
}