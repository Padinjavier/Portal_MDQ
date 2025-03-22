function showToast(type, message, icon = null, backgroundColor = null, color = null, borderColor = null) {
    let defaultIcon, defaultBackgroundColor, defaultColor, defaultBorderColor;

    switch (type) {
        case 'correcto':
            defaultIcon = '<i class="bi bi-check-circle-fill"></i>'; // Ícono de éxito
            defaultBackgroundColor = "white";
            defaultColor = "#28a745"; // Verde
            defaultBorderColor = "#28a745";
            break;
        case 'error':
            defaultIcon = '<i class="bi bi-x-circle-fill"></i>'; // Ícono de error
            defaultBackgroundColor = "white";
            defaultColor = "#dc3545"; // Rojo
            defaultBorderColor = "#dc3545";
            break;
        case 'advertencia':
            defaultIcon = '<i class="bi bi-exclamation-triangle-fill"></i>'; // Ícono de advertencia
            defaultBackgroundColor = "white";
            defaultColor = "#ffc107"; // Amarillo
            defaultBorderColor = "#ffc107";
            break;
        case 'peligro':
            defaultIcon = '<i class="bi bi-fire"></i>'; // Ícono de peligro (fuego)
            defaultBackgroundColor = "white";
            defaultColor = "#dc3545"; // Rojo
            defaultBorderColor = "#dc3545";
            break;
        case 'precaucion':
            defaultIcon = '<i class="bi bi-info-circle-fill"></i>'; // Ícono de información
            defaultBackgroundColor = "white";
            defaultColor = "#17a2b8"; // Azul
            defaultBorderColor = "#17a2b8";
            break;
        case 'tiempo_agotado':
            defaultIcon = '<i class="bi bi-hourglass-split"></i>'; // Ícono de tiempo agotado
            defaultBackgroundColor = "white";
            defaultColor = "#6c757d"; // Gris
            defaultBorderColor = "#6c757d";
            break;
        case 'custom':
            // Usar los valores personalizados proporcionados
            defaultIcon = icon || '<i class="bi bi-info-circle-fill"></i>'; // Ícono por defecto si no se proporciona
            defaultBackgroundColor = backgroundColor || "white"; // Fondo por defecto si no se proporciona
            defaultColor = color || "#17a2b8"; // Color del texto por defecto si no se proporciona
            defaultBorderColor = borderColor || "#17a2b8"; // Color del borde por defecto si no se proporciona
            break;
        default:
            defaultIcon = '<i class="bi bi-info-circle-fill"></i>'; // Ícono por defecto
            defaultBackgroundColor = "white";
            defaultColor = "#17a2b8"; // Azul
            defaultBorderColor = "#17a2b8";
    }

    // Mostrar la notificación
    Toastify({
        text: `${defaultIcon} ${message}`,
        duration: 3000,
        close: false,
        gravity: "top",
        position: "right",
        style: {
            background: defaultBackgroundColor,
            color: defaultColor,
            border: `2px solid ${defaultBorderColor}`,
            borderRadius: "5px",
            boxShadow: "0 2px 8px rgba(0, 0, 0, 0.1)",
        },
        escapeMarkup: false, // Permite usar HTML en el texto
    }).showToast();
}