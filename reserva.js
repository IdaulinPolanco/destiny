document.getElementById('reservaForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(e.target);

    // Crear el objeto de datos
    const data = {
        id_usuario: parseInt(formData.get('id_usuario')), // Puedes obtener esto del contexto o una sesión
        id_lugar: parseInt(formData.get('id_lugar')),    // ID del restaurante "El Buen Sabor"
        fecha: formData.get('fecha'),
        hora: formData.get('hora'),
        cantidad_personas: parseInt(formData.get('cantidad_personas')),
    };

    try {
        // Enviar los datos al servidor
        const response = await fetch('http://localhost:3000/guardarReserva', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();

        if (response.ok) {
            alert(result.message); // Confirmación de éxito
        } else {
            alert('Error al guardar la reserva: ' + result.error);
        }
    } catch (err) {
        console.error('Error al enviar la solicitud:', err);
        alert('No se pudo conectar con el servidor.');
    }
});