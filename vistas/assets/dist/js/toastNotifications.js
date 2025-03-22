function showToast(type, message, icon = null, backgroundColor = null, color = null, borderColor = null) {
    let defaultIcon, defaultBackgroundColor, defaultColor, defaultBorderColor;

    switch (type) {
        case 'correcto':
            defaultIcon = '<i class="bi bi-check-circle-fill"></i>'; // Ícono de éxito
            defaultBackgroundColor = "rgb(255, 255, 255)"; // Blanco
            defaultColor = "rgb(40, 167, 69)"; // Verde
            defaultBorderColor = "rgb(40, 167, 69)";
            break;
        case 'error':
            defaultIcon = '<i class="bi bi-x-circle-fill"></i>'; // Ícono de error
            defaultBackgroundColor = "rgb(255, 255, 255)"; // Blanco
            defaultColor = "rgb(220, 53, 69)"; // Rojo
            defaultBorderColor = "rgb(220, 53, 69)";
            break;
        case 'advertencia':
            defaultIcon = '<i class="bi bi-exclamation-triangle-fill"></i>'; // Ícono de advertencia
            defaultBackgroundColor = "rgb(255, 255, 255)"; // Blanco
            defaultColor = "rgb(255, 193, 7)"; // Amarillo
            defaultBorderColor = "rgb(255, 193, 7)";
            break;
        case 'peligro':
            defaultIcon = '<i class="bi bi-fire"></i>'; // Ícono de peligro (fuego)
            defaultBackgroundColor = "rgb(255, 255, 255)"; // Blanco
            defaultColor = "rgb(220, 53, 69)"; // Rojo
            defaultBorderColor = "rgb(220, 53, 69)";
            break;
        case 'precaucion':
            defaultIcon = '<i class="bi bi-info-circle-fill"></i>'; // Ícono de información
            defaultBackgroundColor = "rgb(255, 255, 255)"; // Blanco
            defaultColor = "rgb(23, 162, 184)"; // Azul
            defaultBorderColor = "rgb(23, 162, 184)";
            break;
        case 'tiempo_agotado':
            defaultIcon = '<i class="bi bi-hourglass-split"></i>'; // Ícono de tiempo agotado
            defaultBackgroundColor = "rgb(255, 255, 255)"; // Blanco
            defaultColor = "rgb(108, 117, 125)"; // Gris
            defaultBorderColor = "rgb(108, 117, 125)";
            break;
        case 'informacion':
            defaultIcon = '<i class="bi bi-info-square-fill"></i>'; // Ícono de información
            defaultBackgroundColor = "rgb(255, 255, 255)"; // Blanco
            defaultColor = "rgb(0, 123, 255)"; // Azul brillante
            defaultBorderColor = "rgb(0, 123, 255)";
            break;
        case 'exito_alternativo':
            defaultIcon = '<i class="bi bi-check2-all"></i>'; // Ícono de éxito alternativo
            defaultBackgroundColor = "rgb(255, 255, 255)"; // Blanco
            defaultColor = "rgb(0, 128, 0)"; // Verde oscuro
            defaultBorderColor = "rgb(0, 128, 0)";
            break;
        case 'alerta_urgente':
            defaultIcon = '<i class="bi bi-bell-fill"></i>'; // Ícono de alerta urgente
            defaultBackgroundColor = "rgb(255, 255, 255)"; // Blanco
            defaultColor = "rgb(255, 69, 0)"; // Naranja
            defaultBorderColor = "rgb(255, 69, 0)";
            break;
        case 'confirmacion':
            defaultIcon = '<i class="bi bi-question-circle-fill"></i>'; // Ícono de confirmación
            defaultBackgroundColor = "rgb(255, 255, 255)"; // Blanco
            defaultColor = "rgb(128, 0, 128)"; // Morado
            defaultBorderColor = "rgb(128, 0, 128)";
            break;
        case 'custom':
            // Usar los valores personalizados proporcionados
            defaultIcon = icon || '<i class="bi bi-info-circle-fill"></i>'; // Ícono por defecto si no se proporciona
            defaultBackgroundColor = backgroundColor || "rgb(255, 255, 255)"; // Fondo por defecto si no se proporciona
            defaultColor = color || "rgb(23, 162, 184)"; // Color del texto por defecto si no se proporciona
            defaultBorderColor = borderColor || "rgb(23, 162, 184)"; // Color del borde por defecto si no se proporciona
            break;
        default:
            defaultIcon = '<i class="bi bi-info-circle-fill"></i>'; // Ícono por defecto
            defaultBackgroundColor = "rgb(255, 255, 255)"; // Blanco
            defaultColor = "rgb(23, 162, 184)"; // Azul
            defaultBorderColor = "rgb(23, 162, 184)";
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