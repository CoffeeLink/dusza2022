function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    if (exdays != 0) {
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
    } else {
        d.setTime(d.getTime());
    }
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}

function checkCookie(cname) {
    let user = getCookie(cname);
    if (user != "") {
        return true;
    } else {
        return false;
    }
}

/*

TODO: set cookie nézze meg hogy tartalam van e mielött beállítja


*/