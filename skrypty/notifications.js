function displayNotification(message) {
    // Wyświetl komunikat w elemencie #notification
    let notificationElement = $("#notification");
    notificationElement.text(message);
    notificationElement.fadeIn().delay(3000).fadeOut(); // Pokaż przez 3 sekundy, a następnie schowaj
}

function displayAlert(message) {
    // Wyświetl komunikat w elemencie #alert
    let notificationElement = $("#alert");
    notificationElement.text(message);
    notificationElement.fadeIn().delay(3000).fadeOut(); // Pokaż przez 3 sekundy, a następnie schowaj
}